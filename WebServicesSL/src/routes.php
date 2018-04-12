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
            $expiration = new DateTime("+60 minutes"); #Stablish token expiration time 
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
    ____ ____ ___ _ _  _ _ ___  ____ ___  ____ ____    ___  ____ ____    ____ ____ ___  ____ ____ _ ____ _    _ ___  ____ ___  
    |__| |     |  | |  | | |  \ |__| |  \ |___ [__     |__] |  | |__/    |___ [__  |__] |___ |    | |__| |    | |  \ |__| |  \ 
    |  | |___  |  |  \/  | |__/ |  | |__/ |___ ___]    |    |__| |  \    |___ ___] |    |___ |___ | |  | |___ | |__/ |  | |__/ 
    */
	$app->get('/actividad/especialidad/{id_especialidad:[0-9]+}', function ($request, $response) {
        $idEspecialidad = $request->getAttribute('id_especialidad');
        $stmt = $this->db->prepare("SELECT  act.id, 
                                            t.id as id_tipo,
                                            t.nombre as tipo,
                                            act.nombre, 
                                            act.material_participante, 
                                            act.descripcion, 
                                            resp.id as id_responsable,
                                            resp.nombre as nombre_responsable,
                                            cat.id as id_categoria,
                                            cat.nombre as categoria
                                    FROM actividad act 
                                        INNER JOIN responsable resp
                                             ON act.id_responsable = resp.id 
                                        INNER JOIN categoria cat 
                                            ON act.id_categoria = cat.id
                                        INNER JOIN tipo t
                                            ON act.id_tipo = t.id
                                    WHERE act.id_especialidad <> :id_especialidad");
        $stmt->bindParam(':id_especialidad', $idEspecialidad, PDO::PARAM_INT);
        $stmt->execute();
        $num_actividades = $stmt->RowCount();
        
        if ($num_actividades > 0) {
            $data = $stmt->fetchAll();
            foreach ($data as $key => $value) {
                $stmt = $this->db->prepare("SELECT h.id as id_horario, fecha, hora_inicio, hora_final, u.nombre as lugar 
                                            FROM horario h INNER JOIN ubicacion u
                                                ON h.id_ubicacion = u.id 
                                            WHERE id_actividad = :id_actividad");
                $stmt->bindParam(':id_actividad', $data[$key]['id'], PDO::PARAM_INT);
                $stmt->execute();
                $data[$key]['horarios'] = $stmt->fetchAll();
                $data[$key]['imagen'] = getenv("IMAGE_PATH").strtolower($data[$key]['tipo']).".jpg";   
            }
            $response = $response->withJson(array('actividades'=>$data,
                                                  'num_actividades'=>$num_actividades),
                                                   200);
        } else {
            $response = $response->withJson(array(
                'message' => 'No existen actividades para la especialidad'
            ), 404);
        }
        return $response;
    });

    /*
    ____ ____ ___ _ _  _ _ ___  ____ ___  ____ ____    ___  ____ ____    ____ ____ ___ ____ ____ ____ ____ _ ____ 
    |__| |     |  | |  | | |  \ |__| |  \ |___ [__     |__] |  | |__/    |    |__|  |  |___ | __ |  | |__/ | |__| 
    |  | |___  |  |  \/  | |__/ |  | |__/ |___ ___]    |    |__| |  \    |___ |  |  |  |___ |__] |__| |  \ | |  | 
    */

    $app->get('/actividad/categoria/{id_categoria:[0-9]+}', function ($request, $response) {
        $idCategoria = $request->getAttribute('id_categoria');
        $stmt = $this->db->prepare("SELECT  act.id, 
                                            t.id as id_tipo,
                                            t.nombre as tipo,
                                            act.nombre, 
                                            act.material_participante, 
                                            act.descripcion, 
                                            resp.id as id_responsable,
                                            resp.nombre as nombre_responsable,
                                            cat.id as id_categoria,
                                            cat.nombre as categoria
                                    FROM actividad act 
                                        INNER JOIN responsable resp
                                                ON act.id_responsable = resp.id 
                                        INNER JOIN categoria cat 
                                            ON act.id_categoria = cat.id
                                        INNER JOIN tipo t
                                            ON act.id_tipo = t.id
                                    WHERE act.id_categoria =  :id_categoria");
        $stmt->bindParam(':id_categoria', $idCategoria, PDO::PARAM_INT);
        $stmt->execute();
        $num_actividades = $stmt->RowCount();
        
        if ($num_actividades > 0){
            $data = $stmt->fetchAll();
            foreach ($data as $key => $value) {
                $stmt = $this->db->prepare("SELECT h.id as id_horario, fecha, hora_inicio, hora_final, u.nombre as lugar 
                                            FROM horario h INNER JOIN ubicacion u
                                                ON h.id_ubicacion = u.id 
                                            WHERE id_actividad = :id_actividad");
                $stmt->bindParam(':id_actividad', $data[$key]['id'], PDO::PARAM_INT);
                $stmt->execute();
                $data[$key]['horarios'] = $stmt->fetchAll(); 
                $data[$key]['imagen'] = getenv("IMAGE_PATH").strtolower($data[$key]['tipo']).".jpg";  
            }
            $response = $response->withJson(array('actividades'=>$data,
                                                    'num_actividades'=>$num_actividades),
                                                    200);
        } else {  
            $response = $response->withJson(array(
                'message' => 'No existen actividades para la categoria'
            ), 404);
        }
        return $response;
    });

    $app->get('/actividad/categoria/', function ($request, $response) {
        $stmt = $this->db->prepare("SELECT id, nombre FROM categoria");
        $stmt->execute();
        $categorias = $stmt->fetchAll();
        $response_data = array(); 
        foreach($categorias as $key => $value) {
            $stmt = $this->db->prepare("SELECT  act.id, 
                                                t.id as id_tipo,
                                                t.nombre as tipo,
                                                act.nombre, 
                                                act.material_participante, 
                                                act.descripcion, 
                                                resp.id as id_responsable,
                                                resp.nombre as nombre_responsable,
                                                cat.id as id_categoria,
                                                cat.nombre as categoria
                                        FROM actividad act 
                                            INNER JOIN responsable resp
                                                    ON act.id_responsable = resp.id 
                                            INNER JOIN categoria cat 
                                                ON act.id_categoria = cat.id
                                            INNER JOIN tipo t
                                                ON act.id_tipo = t.id
                                        WHERE act.id_categoria = :id_categoria");
            
            $stmt->bindParam(':id_categoria', $categorias[$key]['id'], PDO::PARAM_INT);
            $stmt->execute();
            if($stmt->RowCount()>0) {
                $data = $stmt->fetchAll();
                #print_r($data);die();
                foreach ($data as $k => $value) {
                    $stmt = $this->db->prepare("SELECT h.id as id_horario, fecha, hora_inicio, hora_final, u.nombre as lugar 
                                                FROM horario h INNER JOIN ubicacion u
                                                    ON h.id_ubicacion = u.id 
                                                WHERE id_actividad = :id_actividad");
                    $stmt->bindParam(':id_actividad', $data[$k]['id'], PDO::PARAM_INT);
                    $stmt->execute();
                    $data[$k]['horarios'] = $stmt->fetchAll();   
                    $data[$k]['imagen'] = getenv("IMAGE_PATH").strtolower($data[$k]['tipo']).".jpg";
                }
                array_push($response_data, array("nombre" => $categorias[$key]['nombre'], "actividades" => $data));   
            }
        }
        if(count($response_data)>0)
            $response = $response->withJson($response_data, 200);
        else   
            $response = $response->withJson(array(
                'message' => 'No existen actividades'
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
                                            t.id as id_tipo,
                                            t.nombre as tipo,
                                            a.nombre,
                                            a.material_participante ,
                                            a.material_ponente ,
                                            a.descripcion ,
                                            r.id as id_responsable,
                                            r.nombre as nombre_responsable,
                                            c.id as id_categoria ,
                                            c.nombre as catergoria
                                    FROM 	actividad a
                                            INNER JOIN responsable r
                                                ON a.id_responsable = r.id
                                            INNER JOIN categoria c 
                                                ON a.id_categoria = c.id
                                            INNER JOIN tipo t
                                                ON a.id_tipo = t.id
                                    WHERE a.id=:id_actividad");
        $stmt->bindParam(':id_actividad', $id_actividad, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->RowCount() > 0) {
            $data = $stmt->fetchAll();
            $stmt = $this->db->prepare("SELECT h.id as id_horario, fecha, hora_inicio, hora_final, u.nombre as lugar 
                                        FROM horario h INNER JOIN ubicacion u
                                            ON h.id_ubicacion = u.id 
                                        WHERE id_actividad = :id_actividad");
            $stmt->bindParam(':id_actividad', $data[0]['id'], PDO::PARAM_INT);
            $stmt->execute();
            $data[0]['horarios'] = $stmt->fetchAll();
            $data[$key]['imagen'] = getenv("IMAGE_PATH").strtolower($data[$key]['tipo']).".jpg";   
            $response = $response->withJson($data, 200);
        }else {
            $response = $response->withJson(array(
                'message' => 'No existe una actividad con ese identificador'
            ), 404);
        }
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
                                            t.id as id_tipo,
                                            t.nombre as tipo, 
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
                                            INNER JOIN tipo t
                                                ON a.id_tipo = t.id
                                    WHERE al.nocontrol = :nocontrol");
        $stmt->bindParam(':nocontrol', $nocontrol, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll();
        foreach($data as $key => $value) {
            $data[$key]['imagen'] = getenv("IMAGE_PATH").strtolower($data[$key]['tipo']).".jpg";
        }
        if($stmt->RowCount() > 0)
            $response = $response->withJson(array('actividades'=>$data, 
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
        $id_horario = $request->getParsedBody()['id_horario'];

        $stmt = $this->db->prepare("SELECT r.id_horario as id_horario, h.capacidad as capacidad 
                                    FROM registro r JOIN horario h
                                        ON r.id_horario = h.id 
                                    WHERE id_horario = :id_horario");
        $stmt->bindParam(':id_horario', $id_horario);
        $stmt->execute();
        $inscritos = $stmt->RowCount();
        if($inscritos>0){
            if(($inscritos<$stmt->fetchAll()[0]['capacidad'])!=True) {
                $response = $response->withJson(array('success' => false, 
                                                      'code'    => 406, 
                                                      'message' => 'Ya no hay cupo para esta actividad'), 
                                                       406);
                return $response;
            }
        }

        $stmt = $this->db->prepare("SELECT id, fecha, hora_inicio, hora_final FROM horario 
                                    WHERE id = :id_horario");

        $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
        $stmt->execute();
        $data_horario_a_insertar = $stmt->fetchAll();
        $fecha_horario_a_insertar = $data_horario_a_insertar[0]['fecha'];
        $horario_hora_inicio = strtotime($data_horario_a_insertar[0]['hora_inicio']);
        $horario_hora_final = strtotime($data_horario_a_insertar[0]['hora_final']); 
        if($stmt->RowCount() > 0) {
            $stmt = $this->db->prepare("SELECT id FROM alumno WHERE nocontrol=:nocontrol");
            $stmt->bindParam(':nocontrol', $nocontrol, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->RowCount() > 0){
                $id_alumno = $stmt->fetchAll()[0]['id'];
                $stmt = $this->db->prepare("SELECT id_horario FROM registro WHERE id_alumno = :id_alumno");
                $stmt->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);
                $stmt->execute();
                $horario_cruzado = False;
                if($stmt->RowCount() < 3) {
                    if($stmt->RowCount() > 0) {
                        $horarios_inscritos = $stmt->fetchAll();
                        foreach($horarios_inscritos as $key => $value) {
                            $stmt = $this->db->prepare("SELECT hora_inicio, hora_final FROM horario  WHERE id = :id_horario AND fecha = :fecha");
                            
                            $stmt->bindParam(':id_horario', $horarios_inscritos[$key]['id_horario'], PDO::PARAM_INT);
                            $stmt->bindParam(':fecha', $fecha_horario_a_insertar, PDO::PARAM_STR);
                            $stmt->execute();
                            $data = $stmt->fetchAll();                            
                            if($stmt->RowCount()>0){
                                if($horario_hora_inicio <= strtotime($data[0]['hora_inicio']) &&
                                $horario_hora_final  >  strtotime($data[0]['hora_inicio']) &&
                                $horario_hora_final  <= strtotime($data[0]['hora_final'])){
                                    $horario_cruzado = True;
                                    break;
                                }else{
                                    if($horario_hora_inicio > strtotime($data[0]['hora_inicio']) &&
                                    $horario_hora_inicio < strtotime($data[0]['hora_final']) &&
                                    $horario_hora_final >= strtotime($data[0]['hora_final'])){
                                        $horario_cruzado = True;
                                        break;
                                    }else {
                                        if($horario_hora_inicio < strtotime($data[0]['hora_inicio']) &&
                                            $horario_hora_final  > strtotime($data[0]['hora_final'])){
                                                $horario_cruzado = True;
                                                break;
                                            }
                                    }
                                }
                            } 
                        }
                    }
                    if($horario_cruzado == False){
                        try{
                            $stmt = $this->db->prepare("INSERT INTO registro (id_alumno, id_horario) 
                                                        VALUES (:id_alumno, :id_horario)");
                            
                            $stmt->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);
                            $stmt->bindParam(':id_horario', $id_horario, PDO::PARAM_INT);
                            $stmt->execute();
                            $response = $response->withJson(array('success' => true, 'code' => 200), 200);
                        }catch(PDOException $e){
                            $response = $response->withJson(array('success' => false, 
                                                            'code' => 500, 
                                                            'message' => 'Database Error: Ya existe un registro para esta actividad'), 
                                                            500);
                        }
                    }else $response = $response->withJson(array('succes' => false,
                                                                'code' => 406,
                                                                'message' => 'No puedes inscribir esta actividad por que se cruza con otra.'),
                                                                406); 
                }else $response = $response->withJson(array('succes' => false,
                                                            'code' => 406,
                                                            'message' => 'Ya no puedes inscribir mas actividades (maximo 3)'),
                                                            406);

            }else $response = $response->withJson(array('success' => false, 
                                                        'code' => 406, 
                                                        'message' => 'Alumno no encontrado'), 
                                                         406);

        }else $response = $response->withJson(array('success' => false, 
                                                    'code' => 406, 
                                                    'message' => 'Horario no encontrado'), 
                                                     406);
        
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
                'code'=>406, 
                'message'=>'Error: El registro no existe'), 
                406);
        }catch(PDOException $e){
            $response = $response->withJson(array('success'=>false, 
            'code'=>500, 
            'message'=>'Database Error: '.$e), 
            500);
        }
        return $response;
    });

});