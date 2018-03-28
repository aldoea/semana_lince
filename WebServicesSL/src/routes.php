<?php
$app->group('/api', function () use ($app) {

	$app->group('/v1', function () use ($app) {

		$app->post('/login', function ($request, $response) {
            $noControl = $request->getParsedBody()['no_control'];

            $stmt = $this->db->prepare("SELECT id, nocontrol, nombre, id_especialidad FROM alumno WHERE nocontrol = :nocontrol");
            $stmt->bindParam(':nocontrol', $noControl, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->RowCount() > 0) {
                $response = $response->withJson(array('data' => $stmt->fetchAll(), 'message' => '¡Bienvenido!'), 200);
            } else {
                $response = $response->withJson(array(
                    'message' => 'Los datos son incorrectos, verifica e intente nuevamente'
                ), 200);
            }
            
            return $response;
        });

		$app->get('/cursos/{id_especialidad:[0-9]+}', function ($request, $response) {

            $idEspecialidad = $request->getAttribute('id_especialidad');

            $stmt = $this->db->prepare("SELECT act.id, act.nombre, act.duracion, act.material_ponente, act.material_participante, act.descripcion, ser.nombre, cat.nombre, t.nombre FROM actividad act INNER JOIN servicio ser ON act.id_servicio = ser.id_servicio INNER JOIN categoria cat ON act.id_categoria = cat.id_categoria INNER JOIN tipo t ON act.id_tipo = t.id_tipo WHERE act.id_especialidad <> :id_especialidad");
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
