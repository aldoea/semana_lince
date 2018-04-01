<?php
use Firebase\JWT\JWT;

$app->group('/api', function () use ($app) {

	$app->group('/v1', function () use ($app) {

		$app->post('/login', function ($request, $response) {
            $noControl = $request->getParsedBody()['no_control'];

            $stmt = $this->db->prepare("SELECT id, nocontrol, nombre, id_especialidad FROM alumno WHERE nocontrol = :nocontrol");
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

        $app->get('/alumno/{id_alumno:[0-9]+}', function($request, $response) {
            $id = $request->getAttribute('id_alumno');

            $stmt = $this->db->prepare("SELECT nombre, nocontrol 
                                        FROM alumno 
                                        WHERE id=:id_alumno");
            $stmt->bindParam(':id_alumno', $id, PDO::PARAM_INT);
            $stmt->execute();

            if($stmt->RowCount() > 0)
                $response = $response->withJson($stmt->fetchAll(), 200);
            else
                $response = $response->withJson(array("message"=>"Alumno no encontrado"), 400);
            
            return $response;
        });

		$app->get('/cursos/{id_especialidad:[0-9]+}', function ($request, $response) {

            $idEspecialidad = $request->getAttribute('id_especialidad');
            $stmt = $this->db->prepare("SELECT
                                            act.id, 
                                            act.nombre, 
                                            act.duracion, 
                                            act.material_ponente, 
                                            act.material_participante, 
                                            act.descripcion, 
                                            ubi.nombre as lugar,
                                            hor.fecha_hora,
                                            resp.id as id_responsable,
                                            resp.nombre as nombre_responsable,
                                            cat.id as id_categoria,
                                            cat.nombre as categoria
                                            FROM actividad act 
                                                INNER JOIN horario hor ON hor.id_actividad = act.id 
                                                INNER JOIN ubicacion ubi ON hor.id_ubicacion = ubi.id
                                                INNER JOIN responsable resp ON act.id_responsable = resp.id 
                                                INNER JOIN categoria cat ON act.id_categoria = cat.id
                                            WHERE act.id_especialidad <> :id_especialidad");
            $stmt->bindParam(':id_especialidad', $idEspecialidad, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->RowCount() > 0) {
                $response = $response->withJson($stmt->fetchAll(), 200);
            } else {
                $response = $response->withJson(array(
                    'message' => 'No existen cursos para la especialidad'
                ), 404);
            }
            return $response;
        });
	});
});