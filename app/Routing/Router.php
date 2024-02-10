<?php

namespace App\Routing;
use App\Models\ApiResponse;
use App\Controllers\RestController;

class Router {
    private $routes = ['GET' => [], 'POST' => [], 'PUT' => [], 'DELETE' => []];
    private $restController;
    private $apiResponse;

    public function __construct(RestController $rest_controller) {
        $this->restController = $rest_controller;
        $this->apiResponse = new ApiResponse;
    }

    public function addRoute(string $method, string $path, string $action) {
        $method = strtoupper($method);
        if($this->checkMethod($method))
            $this->routes[$method][$path] = $action;
        else
            throw new \Exception("Method not supported. Must be one of GET, POST, PUT or DELETE");

        var_dump($this->routes);
    }

    private function checkMethod($method){
        return array_key_exists($method, $this->routes);
    }

    public function routeRequest($method, $path) {
        if (isset($this->routes[$method][$path])) {
            $action = $this->routes[$method][$path];
            header('Content-Type: application/json');
            $resdata = call_user_func_array([$this->restController, $action], []);
            $this->apiResponse->prepareResponse(200, 'OK', $resdata);
            echo $this->apiResponse->toJSON();
        } else {
            // Handle 404 error
            http_response_code(404);
            header('Content-Type: application/json');
            $this->apiResponse->prepareResponse(404, 'Not Found', ['error' => 404, 'message' => '404 Not Found']);
            echo $this->apiResponse->toJson();
        }
    }
}
