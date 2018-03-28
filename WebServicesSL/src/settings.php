<?php
return [
	'settings' => [
		'displayErrorDetails' => true, 			# En modo de producción colocarlo en FALSE
		'addContentLengthHeader' => false, 		# Agrega el tamaño del encabezado en la respuesta

		"db" => [
			"driver" => "mysql", 											# Ej. PostgreSQL -> 'pgsql' o MySQL -> 'mysql'
			"host" => "x.x.x.x", 											# Dirección IP donde está ubicada la Base de Datos
			"dbname" => "lince", 											# Nombre de la base de datos
			"user" => "linceapp", 											# Usuario de la base de datos
			"pass" => 'aghGQ$fdknpt#0rhmt457490dgfj45052nb3mg1q0r' 			# Password del usuario
		],
	],
];