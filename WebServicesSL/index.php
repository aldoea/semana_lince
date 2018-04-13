<?php

//require 'vendor/qr/qrlib.php';
require_once 'vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$dotenv = new Dotenv\Dotenv(__DIR__);                       // Instancia configuracion variables de entorno
$dotenv->load();
$dotenv->required([
    'JWT_PASSWORD', 
    'DB_DRIVER', 
    'DB_HOST', 
    'DB_NAME', 
    'DB_CHARSET', 
    'DB_USER', 
    'DB_PASS']);

$settings = require_once __DIR__.'/src/settings.php'; 		// Configuraciones del proyecto
$app = new \Slim\App($settings); 	                        // Instancia slim configuraciones
require_once __DIR__.'/src/dependencies.php'; 	            // Establecemos las dependencias
require_once __DIR__.'/src/middleware.php';			        // Middlewares del api
require_once __DIR__.'/src/routes.php'; 					// Registramos las Rutas (API'S)


// apxjcl was here, d00d

// Allow from any origin
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}
// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

}

// just a little bit

$app->run();
