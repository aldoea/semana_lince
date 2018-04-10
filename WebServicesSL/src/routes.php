<?php
use Firebase\JWT\JWT;

/*
    __        ______     _______  __  .__   __. 
    |  |      /  __  \   /  _____||  | |  \ |  | 
    |  |     |  |  |  | |  |  __  |  | |   \|  | 
    |  |     |  |  |  | |  | |_ | |  | |  . `  | 
    |  `----.|  `--'  | |  |__| | |  | |  |\   | 
    |_______| \______/   \______| |__| |__| \__| 
    */


$app->group('/v1', function () use ($app) {

	$app->post('/login', function ($request, $response) {
        $noControl = $request->getParsedBody()['no_control'];

        $stmt = $this->db->prepare("SELECT id, nocontrol, nombre, id_especialidad 
                                    FROM alumno WHERE nocontrol = :nocontrol");
        $stmt->bindParam(':nocontrol', $noControl, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->RowCount() > 0) {
            #Generate token
            $now = new DateTime();
            $expiration = new DateTime("+30 minutes"); #Stablish token expiration time 
            $server = $request->getServerParams();

            $payload = [
                "iat" => $now->getTimeStamp(),
                "exp" => $expiration->getTimeStamp(),
                "sub" => $server["PHP_AUTH_USER"]
            ]; 
            $secret = getenv('JWT_PASSWORD'); #get password of environment variable
            $token = JWT::encode($payload, $secret, "HS256");
            
            $response_array = [
                "data" => $stmt->fetchAll(),
                "message" => "¡Bienvenido!",
                "token" => $token,
                "token_expiration" => $expiration->getTimeStamp()
            ];

            $response = $response->withJson($response_array, 200);
        } else {
            $response = $response->withJson(array(
                'message' => 'Los datos son incorrectos, verifica e intente nuevamente'
            ), 200);
        }
        
        return $response;
    });


     /*
         ___        ______ .___________. __  ____    ____  __   _______       ___       _______   _______      _______.
        /   \      /      ||           ||  | \   \  /   / |  | |       \     /   \     |       \ |   ____|    /       |
       /  ^  \    |  ,----'`---|  |----`|  |  \   \/   /  |  | |  .--.  |   /  ^  \    |  .--.  ||  |__      |   (----`
      /  /_\  \   |  |         |  |     |  |   \      /   |  | |  |  |  |  /  /_\  \   |  |  |  ||   __|      \   \    
     /  _____  \  |  `----.    |  |     |  |    \    /    |  | |  '--'  | /  _____  \  |  '--'  ||  |____ .----)   |   
    /__/     \__\  \______|    |__|     |__|     \__/     |__| |_______/ /__/     \__\ |_______/ |_______||_______/    
    */

    /*
    ___ ____ ___  ____ ____    _    ____ ____    ____ ____ ___ _ _  _ _ ___  ____ ___  ____ ____ 
     |  |  | |  \ |__| [__     |    |__| [__     |__| |     |  | |  | | |  \ |__| |  \ |___ [__  
     |  |__| |__/ |  | ___]    |___ |  | ___]    |  | |___  |  |  \/  | |__/ |  | |__/ |___ ___] 
                                                                                                 
    */
	$app->get('/actividad/especialidad/{id_especialidad:[0-9]+}', function ($request, $response) {
        $idEspecialidad = $request->getAttribute('id_especialidad');
        $stmt = $this->db->prepare("SELECT  act.id, 
                                            act.nombre, 
                                            act.material_ponente, 
                                            act.material_participante, 
                                            act.descripcion, 
                                            ubi.nombre as lugar,
                                            hor.fecha,
                                            hor.hora_inicio,
                                            hor.hora_final,
                                            resp.id as id_responsable,
                                            resp.nombre as nombre_responsable,
                                            cat.id as id_categoria,
                                            cat.nombre as categoria
                                    FROM actividad act 
                                        INNER JOIN horario hor
                                             ON hor.id_actividad = act.id 
                                        INNER JOIN ubicacion ubi
                                             ON hor.id_ubicacion = ubi.id
                                        INNER JOIN responsable resp
                                             ON act.id_responsable = resp.id 
                                        INNER JOIN categoria cat 
                                            ON act.id_categoria = cat.id
                                    WHERE act.id_especialidad <> :id_especialidad");
        $stmt->bindParam(':id_especialidad', $idEspecialidad, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->RowCount() > 0) 
            $response = $response->withJson(array('actividades'=>$stmt->fetchAll(),
                                                  'num_actividades'=>$stmt->RowCount()),
                                                   200);
         else 
            $response = $response->withJson(array(
                'message' => 'No existen actividades para la especialidad'
            ), 404);
        
        return $response;
    });

    /*
        
    _  _ _  _ ____    ____ ____ ___ _ _  _ _ ___  ____ ___  
    |  | |\ | |__|    |__| |     |  | |  | | |  \ |__| |  \ 
    |__| | \| |  |    |  | |___  |  |  \/  | |__/ |  | |__/ 
                                                            

    */

    $app->get('/actividad/{id_actividad:[0-9]+}', function($request, $response) {
        $id_actividad = $request->getAttribute('id_actividad');
        $stmt = $this->db->prepare("SELECT 	a.id,
                                            a.nombre,
                                            a.material_participante ,
                                            a.material_ponente ,
                                            a.descripcion ,
                                            u.nombre as lugar,
                                            h.fecha,
                                            h.hora_inicio,
                                            h.hora_final,
                                            r.id as id_responsable,
                                            r.nombre as nombre_responsable,
                                            c.id as id_categoria ,
                                            c.nombre as catergoria
                                    FROM 	actividad a
                                            INNER JOIN horario h
                                                ON h.id_actividad = a.id
                                            INNER JOIN ubicacion u
                                                ON h.id_ubicacion = u.id
                                            INNER JOIN responsable r
                                                ON a.id_responsable = r.id
                                            INNER JOIN categoria c 
                                                ON a.id_categoria = c.id
                                    WHERE a.id=:id_actividad");
        $stmt->bindParam(':id_actividad', $id_actividad, PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->RowCount() > 0)
            $response = $response->withJson($stmt->fetchAll(), 200);
        else
            $response = $response->withJson(array(
                'message' => 'No existe una actividad con ese identificador'
            ), 404);

        return $response;
    });

    /*
        
         ___       __       __    __  .___  ___. .__   __.   ______   
        /   \     |  |     |  |  |  | |   \/   | |  \ |  |  /  __  \  
       /  ^  \    |  |     |  |  |  | |  \  /  | |   \|  | |  |  |  | 
      /  /_\  \   |  |     |  |  |  | |  |\/|  | |  . `  | |  |  |  | 
     /  _____  \  |  `----.|  `--'  | |  |  |  | |  |\   | |  `--'  | 
    /__/     \__\ |_______| \______/  |__|  |__| |__| \__|  \______/  
                                                                      

    */

    /*
    ____ ____ ___ _ _  _ _ ___  ____ ___  ____ ____    _ _  _ ____ ____ ____ _ ___ ____ ____ 
    |__| |     |  | |  | | |  \ |__| |  \ |___ [__     | |\ | [__  |    |__/ |  |  |__| [__  
    |  | |___  |  |  \/  | |__/ |  | |__/ |___ ___]    | | \| ___] |___ |  \ |  |  |  | ___] 
                                                                                             
    */

    $app->get('/actividad/alumno/{nocontrol:[0-9]+}', function($request, $response) {
        $nocontrol = $request->getAttribute('nocontrol');
        $stmt = $this->db->prepare("SELECT 	a.id,
                                            a.nombre,
                                            a.material_participante ,
                                            a.descripcion ,
                                            u.nombre as lugar,
                                            h.fecha,
                                            h.hora_inicio,
                                            h.hora_final,
                                            r.id as id_responsable,
                                            r.nombre as nombre_responsable,
                                            c.id as id_categoria ,
                                            c.nombre as catergoria
                                    FROM 	actividad a
                                            INNER JOIN horario h
                                                ON h.id_actividad = a.id
                                            INNER JOIN ubicacion u
                                                ON h.id_ubicacion = u.id
                                            INNER JOIN responsable r
                                                ON a.id_responsable = r.id
                                            INNER JOIN categoria c 
                                                ON a.id_categoria = c.id
                                            INNER JOIN registro re 
                                                ON re.id_horario = h.id
                                            INNER JOIN alumno al 
                                                ON re.id_alumno = al.id
                                    WHERE al.nocontrol = :nocontrol");
        $stmt->bindParam(':nocontrol', $nocontrol, PDO::PARAM_INT);
        $stmt->execute();
        
        if($stmt->RowCount() > 0)
            $response = $response->withJson(array('actividades'=>$stmt->fetchAll(), 
                                                  'num_actividades'=>$stmt->RowCount()),
                                                   200);
        else
            $response = $response->withJson(array(
                'message' => 'No hay actividades inscritas con el numero de control especificado'
            ), 404);

        return $response;
    });

    /*
        _ _  _ ____ ____ ____ _ ___  _ ____    ____ ____ ___ _ _  _ _ ___  ____ ___  
        | |\ | [__  |    |__/ | |__] | |__/    |__| |     |  | |  | | |  \ |__| |  \ 
        | | \| ___] |___ |  \ | |__] | |  \    |  | |___  |  |  \/  | |__/ |  | |__/ 
                                                                                     
    */

    $app->post('/actividad/alumno', function($request, $response) {
        $nocontrol = $request->getParsedBody()['nocontrol'];
        $id_actividad = $request->getParsedBody()['id_actividad'];
        $fecha = $request->getParsedBody()['fecha'];
        $hora_inicio = $request->getParsedBody()['hora_inicio'];

        $stmt = $this->db->prepare("SELECT id FROM horario 
                                    WHERE fecha = :fecha 
                                        AND hora_inicio = :hora_inicio 
                                        AND id_actividad = :id_actividad");

        $stmt->bindParam(':fecha', $fecha, PDO::PARAM_STR);
        $stmt->bindParam(':hora_inicio', $hora_inicio, PDO::PARAM_STR);
        $stmt->bindParam(':id_actividad', $id_actividad, PDO::PARAM_INT);
        $stmt->execute();
        
        if($stmt->RowCount() > 0) {
            $id_horario = $stmt->fetchAll()[0]['id'];
            $stmt = $this->db->prepare("SELECT id FROM alumno WHERE nocontrol=:nocontrol");
            $stmt->bindParam(':nocontrol', $nocontrol, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->RowCount() > 0){
                $id_alumno = $stmt->fetchAll()[0]['id'];
                try{
                $stmt = $this->db->prepare("INSERT INTO registro (id_alumno, id_horario) 
                                            VALUES (:id_alumno, :id_horario)");
                
                $stmt->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);
                $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
                $stmt->execute();
                $response = $response->withJson(array('success' => true, 'code' => 200), 200);
                }catch(PDOException $e){
                    $response = $response->withJson(array('success' => false, 
                                                    'code' => 200, 
                                                    'message' => 'Database Error: Ya existe un registro para esta actividad'), 
                                                     200);
                }

            }else $response = $response->withJson(array('success' => false, 
                                                        'code' => 200, 
                                                        'message' => 'Alumno no encontrado'), 
                                                         200);

        }else $response = $response->withJson(array('success' => false, 
                                                    'code' => 200, 
                                                    'message' => 'Horario no encontrado'), 
                                                     200);
        
        return $response;
    });

    /*
    ___  ____ ____ _ _  _ ____ ____ ____ _ ___  _ ____    ____ ____ ___ _ _  _ _ ___  ____ ___  
    |  \ |___ [__  | |\ | [__  |    |__/ | |__] | |__/    |__| |     |  | |  | | |  \ |__| |  \ 
    |__/ |___ ___] | | \| ___] |___ |  \ | |__] | |  \    |  | |___  |  |  \/  | |__/ |  | |__/ 
                                                                                                
    */

    $app->delete('/actividad/alumno/{id_alumno:[0-9]+}/{id_horario:[0-9]+}', function($request, $response) {
        $id_alumno = $request->getAttribute('id_alumno');
        $id_horario = $request->getAttribute('id_horario');

        try{
            $stmt = $this->db->prepare("DELETE FROM registro WHERE id_alumno = :id_alumno AND id_horario = :id_horario");
            $stmt->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);
            $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
            $stmt->execute();
            if($stmt->RowCount() > 0)
                $response = $response->withJson(array('success'=>true, 'code'=>200), 200);
            else
                $response = $response->withJson(array('success'=>false, 
                'code'=>200, 
                'message'=>'Error: El registro no existe'), 
                200);
        }catch(PDOException $e){
            $response = $response->withJson(array('success'=>false, 
            'code'=>200, 
            'message'=>'Database Error: '.$e), 
            200);
        }

        return $response;
    });
});