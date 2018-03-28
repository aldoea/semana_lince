<?php

/*
* POST   /api/user/login            ->  API para el logeo de los clientes.
* POST   /api/user/registration     ->  API para registro de clientes.
* GET    /api/user/{id}				->  API para obtener la información (nombre, direccion, codigo_postal, telefono, email) de un cliente en especifico.
* GET    /api/user/{id}/coupons     ->  API para obtener la información (nombre, direccion, codigo_postal, telefono, email) de un cliente en especifico.
* PUT    /api/user/{id}             ->  API para modificar la información (direccion, codigo_postal, telefono) de un cliente en especifico.
* GET    /api/menu                  ->  API para obtener las categorias con sus respectivos productos
* GET    /api/user/{id}/purchases   ->  API para obtener las compras y sus productos comprados de un usuario en especifico.
* GET    /api/coupon/{id}           ->  API para obtener la información (id_cupon, descripcion, descuento, fecha_vencimiento) de un cupón en especificio siempre cuando sea
										valido.
*/

$app->group('/api', function () use ($app) {

	$app->group('/user', function () use ($app) {

		$app->post('/login', function ($request, $response) {

                $user = $request->getParsedBody()['user'];
                $pass = $request->getParsedBody()['pass'];

                $stmt = $this->db->prepare("SELECT id_cliente, nombre, email, image FROM cliente WHERE email = :email AND contrasena = :contrasena AND status = 1");
                $stmt->bindParam(':email', $user, PDO::PARAM_STR);
                $stmt->bindParam(':contrasena', $pass, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->RowCount() > 0) {
                    $response = $response->withJson(array(
                        'data' => $stmt->fetchAll(), 
                        'message' => '¡Bienvenido!'
                    ), 200);
                } else {
                    $response = $response->withJson(array(
                        'message' => 'Los datos son incorrectos, verifica e intente nuevamente'
                    ), 200);
                }
            
            return $response;
        });

		$app->post('/registration', function ($request, $response) {

            $name = $request->getParsedBody()['name'];
            $address = $request->getParsedBody()['address'];
            $zipCode = $request->getParsedBody()['zip_code'];
            $phone = $request->getParsedBody()['phone'];
            $user = $request->getParsedBody()['user'];
            $pass = $request->getParsedBody()['pass'];

			$stmt = $this->db->prepare("SELECT email FROM cliente WHERE email = :email");
			$stmt->bindParam(':email', $user, PDO::PARAM_STR);
			$stmt->execute();

			if ($stmt->RowCount() == 0) {

				$stmt = $this->db->prepare("INSERT INTO cliente (status, nombre, direccion, codigo_postal, telefono, email, contrasena) VALUES (1, :nombre, :direccion, :codigo_postal, :telefono, :email, :contrasena)");
	            $stmt->bindParam(':nombre', $name, PDO::PARAM_STR);
	            $stmt->bindParam(':direccion', $address, PDO::PARAM_STR);
	            $stmt->bindParam(':codigo_postal', $zipCode, PDO::PARAM_INT);
	            $stmt->bindParam(':telefono', $phone, PDO::PARAM_STR);
	            $stmt->bindParam(':email', $user, PDO::PARAM_STR);
	            $stmt->bindParam(':contrasena', $pass, PDO::PARAM_STR);
	            $stmt->execute();

	            if ($stmt->RowCount() > 0) {
	                $response = $response->withJson(array(
	                    'message' => '¡El usuario ha sido registrado con exito!', 
	                    'location' => $request->getUri()->getBaseUrl().'/api/user/'.$this->db->lastInsertId()
	                ), 201);
	            } else {
	                $response = $response->withJson(array(
	                    'message' => 'No se ha podido completar el registro. Verifica tus datos.'
	                ), 202);
	            }

			} else {
				$response = $response->withJson(array(
	                    'message' => 'El email especificado ya se encuentra en uso.'
	                ), 200);
			}

            return $response;
        });

        $app->get('/{id:[0-9]+}', function ($request, $response) {

            $id = $request->getAttribute('id');

            $stmt = $this->db->prepare("SELECT nombre, direccion, codigo_postal, telefono, email FROM cliente WHERE id_cliente = :id_cliente");
            $stmt->bindParam(':id_cliente', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->RowCount() > 0) {
                $response = $response->withJson($stmt->fetchAll(), 200);
            } else {
                $response = $response->withJson(array(
                    'message' => 'El usuario no ha sido encontrado'
                ), 404);
            }

            return $response;
        });

        $app->get('/{id:[0-9]+}/coupons', function ($request, $response) {

            $id = $request->getAttribute('id');

            $stmt = $this->db->prepare("SELECT c.id_cupon, ec.estado_cupon, c.descripcion, c.codigo, c.descuento, c.fecha_vencimiento FROM cupon c JOIN estado_cupon ec ON c.id_estado_cupon = ec.id_estado_cupon WHERE c.id_cliente = :id_cliente");
            $stmt->bindParam(':id_cliente', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->RowCount() > 0) {
                $response = $response->withJson($stmt->fetchAll(), 200);
            } else {
                $response = $response->withJson(array(
                    'message' => 'El usuario no hasido encontrado o no tiene cupones asignados'
                ), 404);
            }

            return $response;
        });

        $app->put('/{id:[0-9]+}', function ($request, $response) {

            $id = $request->getAttribute('id');
            $address = $request->getParsedBody()['address'];
            $zipCode = $request->getParsedBody()['zip_code'];
            $phone = $request->getParsedBody()['phone'];

            $stmt = $this->db->prepare("UPDATE cliente SET direccion = :direccion, codigo_postal = :codigo_postal, telefono = :telefono WHERE id_cliente = :id_cliente");
            $stmt->bindParam(':id_cliente', $id, PDO::PARAM_INT);
            $stmt->bindParam(':direccion', $address, PDO::PARAM_STR);
            $stmt->bindParam(':codigo_postal', $zipCode, PDO::PARAM_INT);
            $stmt->bindParam(':telefono', $phone, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->RowCount() > 0) {
                $response = $response->withJson(array(
                	'message' => '¡Se actualizaron los datos de facturación y envio con exito!'
                ), 200);
            } else {
                $response = $response->withJson(array(
                    'message' => 'Los datos son incorrectos, verifica e intente nuevamente.'
                ), 404);
            }

            return $response;
        });

        $app->get('/{id:[0-9]+}/purchases', function ($request, $response) {

            $id = $request->getAttribute('id');

            $stmt = $this->db->prepare("SELECT * FROM venta WHERE id_cliente = :id_cliente");
            $stmt->bindParam(':id_cliente', $id, PDO::PARAM_INT);
            $stmt->execute();
            
            $data = array();
            foreach ($stmt->fetchAll() as $key => $value) {
                
                $data[$key]['id_venta'] = $value['id_venta'];

                if ($value['id_cupon'] != null) {
                
                    $stmt = $this->db->prepare("SELECT descuento, codigo FROM cupon WHERE id_cupon = :id_cupon");
                    $stmt->bindParam(':id_cupon', $value['id_cupon'], PDO::PARAM_INT);
                    $stmt->execute();
                    
                    $result = $stmt->fetchAll()[0];

                    $data[$key]['cupon'] = $result['codigo'];
                    $data[$key]['descuento'] = $result['descuento'];

                } else {
                    $data[$key]['cupon'] = $value['id_cupon'];
                }

                if ($value['id_tipo_pago'] != null) {
                
                    $stmt = $this->db->prepare("SELECT tipo_pago FROM tipo_pago WHERE id_tipo_pago = :id_tipo_pago");
                    $stmt->bindParam(':id_tipo_pago', $value['id_tipo_pago'], PDO::PARAM_INT);
                    $stmt->execute();
                    
                    $data[$key]['tipo_pago'] = $stmt->fetchAll()[0]['tipo_pago'];
                } else {
                    $data[$key]['tipo_pago'] = $value['id_tipo_pago'];
                }

                
                $data[$key]['fecha_venta'] = $value['fecha_venta'];
                $data[$key]['num_tarjeta'] = $value['num_tarjeta'];

                $stmt = $this->db->prepare("SELECT total FROM vw_total_venta WHERE id_venta = :id_venta");
                $stmt->bindParam(':id_venta', $data[$key]['id_venta'], PDO::PARAM_INT);
                $stmt->execute();
                
                if (isset($data[$key]['descuento'])) {
                    $data[$key]['total'] = $stmt->fetchAll()[0]['total'];
                    $data[$key]['total'] = $data[$key]['total'] - ($data[$key]['total'] * $data[$key]['descuento'] / 100);
                } else {
                    $data[$key]['total'] = $stmt->fetchAll()[0]['total'];    
                }

            }

            $response = $response->withJson($data, 200);

            return $response;
        });

        $app->get('/{id:[0-9]+}/coupon/{code}', function ($request, $response) {

            $id = $request->getAttribute('id');
            $code = $request->getAttribute('code');

            $stmt = $this->db->prepare("SELECT id_cupon, descuento FROM cupon WHERE NOW()::DATE <= fecha_vencimiento AND id_cliente = :id_cliente AND codigo = :codigo AND id_estado_cupon = 1");
            $stmt->bindParam(':id_cliente', $id, PDO::PARAM_INT);
            $stmt->bindParam(':codigo', $code, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->RowCount() > 0) {
                $response = $response->withJson($stmt->fetchAll()[0], 200);
            } else {
                $response = $response->withJson(array(
                    'message' => 'El cupón no es valido'
                ), 200);
            }

            return $response;
        });

	});

    $app->get('/menu', function ($request, $response) {

        $result = array();

        $stmt = $this->db->prepare("SELECT id_categoria, nombre FROM categoria ORDER BY id_categoria");
        $stmt->execute();
        $categories = $stmt->fetchAll();

        foreach ($categories as $key => $value) {
            
            $result[$key]['id_categoria'] = $value['id_categoria'];
            $result[$key]['nombre'] = $value['nombre'];

            $stmt = $this->db->prepare("SELECT prod.id_producto, prod.nombre, prov.nombre as proveedor, prod.imagen, prod.descripcion, prod.color, prod.existencias, prod.precio  FROM producto prod JOIN proveedor prov ON prod.id_proveedor = prov.id_proveedor WHERE prod.id_categoria = :id_categoria AND prod.existencias > 0 ORDER BY prod.id_producto");
            $stmt->bindParam(':id_categoria', $value['id_categoria'], PDO::PARAM_INT);
            $stmt->execute();

            $result[$key]['productos'] = $stmt->fetchAll();
        }

        $response = $response->withJson($result, 200);

        return $response;
    });

    $app->get('/purchase/{id:[0-9]+}/products', function ($request, $response) {

        $id = $request->getAttribute('id');

        $stmt = $this->db->prepare("SELECT prov.nombre AS proveedor, prod.nombre AS producto, dv.precio_venta, dv.cantidad FROM detalle_venta dv JOIN producto prod ON dv.id_producto = prod.id_producto JOIN proveedor prov ON prod.id_proveedor = prov.id_proveedor WHERE dv.id_venta = :id_venta ORDER BY dv.id_detalle_venta");
        $stmt->bindParam(':id_venta', $id, PDO::PARAM_INT);
        $stmt->execute();

        $response = $response->withJson($stmt->fetchAll(), 200);

        return $response;
    });

    $app->post('/payment', function ($request, $response) {

        $data = json_decode($request->getParsedBody()['data'], true);

        $this->db->beginTransaction();

        try {
            
            $idCliente = $data['id_cliente'];
            $idCupon = $data['id_cupon'];
            $tipoPago = $data['tipo_pago'];
            $numTarjeta = $data['num_tarjeta'];

            if ($idCupon == -1 && $numTarjeta == "") {
                
                $stmt = $this->db->prepare("INSERT INTO venta (id_cliente, id_cupon, id_tipo_pago, fecha_venta, num_tarjeta) VALUES (:id_cliente, null, :id_tipo_pago, NOW(), null)");
                $stmt->bindParam(':id_cliente', $idCliente, PDO::PARAM_INT);
                $stmt->bindParam(':id_tipo_pago', $tipoPago, PDO::PARAM_INT);
                $stmt->execute();                

            } elseif ($idCupon == -1 && $numTarjeta != "") {
                
                $stmt = $this->db->prepare("INSERT INTO venta (id_cliente, id_cupon, id_tipo_pago, fecha_venta, num_tarjeta) VALUES (:id_cliente, null, :id_tipo_pago, NOW(), :num_tarjeta)");
                $stmt->bindParam(':id_cliente', $idCliente, PDO::PARAM_INT);
                $stmt->bindParam(':id_tipo_pago', $tipoPago, PDO::PARAM_INT);
                $stmt->bindParam(':num_tarjeta', $numTarjeta, PDO::PARAM_STR);
                $stmt->execute();

            } elseif ($idCupon != -1 && $numTarjeta == "") {
                
                $stmt = $this->db->prepare("INSERT INTO venta (id_cliente, id_cupon, id_tipo_pago, fecha_venta, num_tarjeta) VALUES (:id_cliente, :id_cupon, :id_tipo_pago, NOW(), null)");
                $stmt->bindParam(':id_cliente', $idCliente, PDO::PARAM_INT);
                $stmt->bindParam(':id_cupon', $idCupon, PDO::PARAM_INT);
                $stmt->bindParam(':id_tipo_pago', $tipoPago, PDO::PARAM_INT);
                $stmt->execute();

                $stmt = $this->db->prepare("UPDATE cupon SET id_estado_cupon = 2 WHERE id_cupon = :id_cupon");
                $stmt->bindParam(':id_cupon', $idCupon, PDO::PARAM_INT);
                $stmt->execute();

            } elseif ($idCupon != -1 && $numTarjeta != "") {
                
                $stmt = $this->db->prepare("INSERT INTO venta (id_cliente, id_cupon, id_tipo_pago, fecha_venta, num_tarjeta) VALUES (:id_cliente, :id_cupon, :id_tipo_pago, NOW(), :num_tarjeta)");
                $stmt->bindParam(':id_cliente', $idCliente, PDO::PARAM_INT);
                $stmt->bindParam(':id_cupon', $idCupon, PDO::PARAM_INT);
                $stmt->bindParam(':id_tipo_pago', $tipoPago, PDO::PARAM_INT);
                $stmt->bindParam(':num_tarjeta', $numTarjeta, PDO::PARAM_STR);
                $stmt->execute();

                $stmt = $this->db->prepare("UPDATE cupon SET id_estado_cupon = 2 WHERE id_cupon = :id_cupon");
                $stmt->bindParam(':id_cupon', $idCupon, PDO::PARAM_INT);
                $stmt->execute();
            }

            $idVenta = $this->db->lastInsertId();

            foreach ($data['productos'] as $key => $value) {
                
                $idProducto = $value['id_producto'];
                $precioVenta = $value['precio_venta'];
                $cantidad = $value['cantidad'];

                $stmt = $this->db->prepare("INSERT INTO detalle_venta (id_venta, id_producto, precio_venta, cantidad) VALUES (:id_venta, :id_producto, :precio_venta, :cantidad)");
                $stmt->bindParam(':id_venta', $idVenta, PDO::PARAM_INT);
                $stmt->bindParam(':id_producto', $idProducto, PDO::PARAM_INT);
                $stmt->bindParam(':precio_venta', $precioVenta, PDO::PARAM_STR);
                $stmt->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
                $stmt->execute();
            }   

            $this->db->commit();
            $response = $response->withJson(array('message' => 'La compra se realizo con exito'), 200);

        } catch (Exception $ex) {

            $this->db->rollBack();
            $response = $response->withJson(array('message' => 'La compra no pudo ser realizada '.$ex), 200);
        }

        return $response;
    });
});
