<?php
#Middleware for authentication
$app->add(new \Slim\Middleware\JwtAuthentication([
    "secure" => true,
    "relaxed" => ["localhost"],
    "path" => "/api/v1",
    "passthrough" => "/api/v1/login",
    "secret" => getenv('JWT_PASSWORD'),
    "callback" => function ($request, $response, $arguments) use ($container) {
        $container["jwt"] = $arguments["decoded"];
    },
    "error" => function($request, $response, $arguments) {
        $data["status"] = "error";
        $data["message"] = $arguments["message"];
        return $response
            ->withHeader("Content-Type", "application/json")
            ->write(json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT));
    }
]));