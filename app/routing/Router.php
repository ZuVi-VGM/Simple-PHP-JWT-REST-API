<?php

namespace App\Routing;
use App\Models\ApiResponse;

class Router {
    private $routes = [];
    private $restController;
    private $apiResponse;

    public function __construct($rest_controller) {
        $this->restController = $rest_controller;
    }

    public function addRoute($method, $path, $action) {
        $this->routes[$method][$path] = $action;
    }

    public function routeRequest($method, $path) {
        if (isset($this->routes[$method][$path])) {
            //$action = $this->routes[$method][$path];
            //call_user_func_array([$this->restController, $action], []);
            //header('Content-Type: application/json');

        } else {
            // Gestione dell'errore 404
            http_response_code(404);
            $this->apiResponse = new ApiResponse('404', '404 Not Found', ['error' => true, 'code' => 404]);
            echo $this->apiResponse->toJson();
        }
    }
}
