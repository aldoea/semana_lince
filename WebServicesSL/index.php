<?php

require_once 'vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$settings = require_once __DIR__.'/src/settings.php'; 		// Configuraciones del proyecto
$app = new \Slim\App($settings); 							// Instancia de Slim con configuraciones

require_once __DIR__.'/src/dependencies.php'; 				// Establecemos las dependencias
require_once __DIR__.'/src/routes.php'; 					// Registramos las Rutas (API'S)

$app->run();
