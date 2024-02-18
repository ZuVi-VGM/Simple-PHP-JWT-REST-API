<?php
require_once __DIR__.'/app/includes/autoload.php';

use App\Controllers\RestController;
use App\Routing\Router;
use App\Controllers\JwtController;

$restController = new RestController();
$router = new Router($restController);

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Define routes
$router->addRoute('POST', '/Simple-PHP-JWT-REST-API/token/create', 'createToken');
$router->addRoute('GET', '/Simple-PHP-JWT-REST-API/token/validate/${token}', 'validateToken');


// Send request to router
$router->routeRequest($method, $path);
