<?php
return [
	'settings' => [
		'displayErrorDetails' => true, 			# En modo de producción colocarlo en FALSE
		'addContentLengthHeader' => false, 		# Agrega el tamaño del encabezado en la respuesta

		"db" => [
			"driver"  => getenv('DB_DRIVER'), 	# Ej. PostgreSQL -> 'pgsql' o MySQL -> 'mysql'
			"host" 	  => getenv('DB_HOST'), 	# Dirección IP donde está ubicada la Base de Datos
			"dbname"  => getenv('DB_NAME'), 	# Nombre de la base de datos
			"charset" => getenv('DB_CHARSET'), 
			"user"    => getenv('DB_USER'), 	# Usuario de la base de datos
			"pass"    => getenv('DB_PASS') 		# Password del usuario
		],
	],
];