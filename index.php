<?php
require_once __DIR__.'/app/includes/autoload.php';

use App\Controllers\RestController;
use App\Routing\Router;

$restController = new RestController();
$router = new Router($restController);

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Instrada la richiesta al router
$router->addRoute('GET', '/Simple-PHP-JWT-REST-API/test', 'test');
$router->routeRequest($method, $path);