<?php

namespace App\Routing;
use App\Models\ApiResponse;
use App\Controllers\RestController;

class Router {
    private array $routes = ['GET' => [], 'POST' => [], 'PUT' => [], 'DELETE' => []];
    private restController $restController;
    private apiResponse $apiResponse;

    public function __construct(RestController $rest_controller) {
        $this->restController = $rest_controller;
        $this->apiResponse = new ApiResponse;
    }

    private function log(string $message, array $data) : void {
        if(DEV_MODE && LOGS && ROUTER_LOGS){
            echo "{$message} \n";
            var_dump($data);
            echo "\n";
        }
    }

    private function checkMethod(string $method) : bool{
        return array_key_exists($method, $this->routes);
    }

    private function prepareRoute(string $method, string $pattern, string $action) : void {
        if(count(explode('/', trim($pattern, '/'))) > MAX_NID_LEVELS)
            throw new \Exception("Nidification limit exceeded in route pattern \"{$pattern}\", max is ".MAX_NID_LEVELS.". Check your configuration for MAX_NID_LEVELS.");
        
        if($method == 'GET' || $method == 'DELETE')
        { 
            if(str_contains($pattern, '${')) {
                // get dei parametri ed estrazione substring
                $path = rtrim(strstr($pattern, '${', true), '/');
                $pattern = strstr($pattern, '${');
                
                $this->routes[$method][$path] = ['action' => $action, 'pattern' => $pattern];

                $this->log('ROUTE ADDED', $this->routes[$method][$path]);

                return;
            }
        }
            
        $this->routes[$method][$pattern] = ['action' => $action];
        $this->log('ROUTE ADDED', $this->routes[$method][$pattern]);
    }

    public function addRoute(string $method, string $path, string $action) : void{
        $method = strtoupper($method);
        $path = rtrim($path, '/');
        if($this->checkMethod($method))
            $this->prepareRoute($method, $path, $action);
        else
            throw new \Exception("Method not supported. Must be one of GET, POST, PUT or DELETE");
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

    private function prepareParams(string $method, string $uri, string $path) : void {
        $position = strpos($uri, $path);
        if ($position !== false)
            $params = substr($uri, $position + strlen($path));

        preg_match_all('/\${([^}]+)}/', $this->routes[$method][$path]['pattern'], $matches);

        $params = explode('/', trim($params, '/'));
        $count = count($params);

        foreach($matches[1] as $i => $key)
        {
            if($i >= $count)
                break;
            if(isset($params[$i]))
                $this->restController->updateParams([$key => $params[$i]]);
        }
    }

    private function getRoute(string $method, string $uri) : string|false{
        // Too much params? :O
        if(count(explode('/', trim($uri, '/'))) > MAX_NID_LEVELS)
            return false;

        if(isset($this->routes[$method][$uri]))
            return $this->routes[$method][$uri]['action'];

        $path = dirname($uri);

        while($path != DIRECTORY_SEPARATOR)
        {
            if(isset($this->routes[$method][$path])) {
                if(isset($this->routes[$method][$path]['pattern']))
                    $this->prepareParams($method, $uri, $path);
                
                return $this->routes[$method][$path]['action'];
            }

            $path = dirname($path);
        }
        
        return false;
    }

    public function routeRequest(string $method, string $path) :void{
        if(!DEV_MODE)
            if(!$this->checkAllowedRequest())
                return;

        $this->log('ROUTES:', $this->routes);
        
        $path = rtrim($path, '/'); //prepare path for the research
        if ($action = $this->getRoute($method, $path)) {
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
