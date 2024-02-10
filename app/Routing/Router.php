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

    public function addRoute(string $method, string $path, string $action) : void{
        $method = strtoupper($method);
        if($this->checkMethod($method))
            $this->routes[$method][$path] = $action;
        else
            throw new \Exception("Method not supported. Must be one of GET, POST, PUT or DELETE");

        if(DEV_MODE && LOG)
            var_dump($this->routes);
    }

    private function checkMethod(string $method) : bool{
        return array_key_exists($method, $this->routes);
    }

    private function checkAllowedRequest() : bool{
        if (!isset($_SERVER['HTTP_ORIGIN']) || empty($_SERVER['HTTP_ORIGIN'])) {
            http_response_code(403);
            return false;
        }

        $allowedOrigin = (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS'])) ? 'https://' . APP_URL : 'http://' . APP_URL;
        if ($_SERVER['HTTP_ORIGIN'] !== $allowedOrigin) {
            http_response_code(403);
            return false;
        }

        header('Access-Control-Allow-Origin: ' . $allowedOrigin);
        return true;
    }

    public function routeRequest(string $method, string $path) :void{
        if(!DEV_MODE)
            if(!$this->checkAllowedRequest())
                return;
        

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
