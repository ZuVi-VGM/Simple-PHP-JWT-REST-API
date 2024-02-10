<?php
require_once __DIR__.'/app/includes/autoload.php';

use App\Controllers\RestController;
use App\Routing\Router;

$restController = new RestController();
$router = new Router($restController);

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Define routes
$router->addRoute('GET', '/Simple-PHP-JWT-REST-API/test', 'test');
$router->addRoute('POST', '/Simple-PHP-JWT-REST-API/tata', 'testp');
$router->addRoute('Put', '/Simple-PHP-JWT-REST-API/tata', 'testput');
$router->addRoute('DELETE', '/Simple-PHP-JWT-REST-API/tata', 'testdel');

// Send request to router
$router->routeRequest($method, $path);