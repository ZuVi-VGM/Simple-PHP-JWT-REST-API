<?php

namespace App\Controllers;
use App\Controllers\JwtController;

class RestController {
    private string $method;
    private array $params;
    private JwtController $jwt;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        //$this->endpoint = $_SERVER['REQUEST_URI']; //maybe for other checks...
        $this->jwt = new JwtController(SECRET_KEY);
        $this->prepareParams();

        // if(DEV_MODE && LOGS && REST_CONTR_LOGS)
        //     var_dump($this->params);
    }

    private function prepareParams() : void {
        switch ($this->method) {
            case 'PUT':
                $putData = file_get_contents('php://input');
                parse_str($putData, $putParams);
                $_REQUEST = array_merge($_REQUEST, $putParams);
            default:
                $this->params = $_REQUEST;
        }
    }

    public function updateParams(array $data) : void {
        $this->params = array_merge($this->params, $data);
        if(DEV_MODE && LOGS && REST_CONTR_LOGS)
            var_dump($this->params);
    }

    public function createToken() : array {
        if(!isset($_POST['peer_id']) || !isset($_POST['salt']))
            return ['code' => 422, 'message' => 'Missing Parameters', 'data' => ['error' => 422, 'message' => 'Missing Parameters.']];
        
        $token = $this->jwt->createToken($_POST);

        return ['code' => 200, 'message' => 'OK', 'data' => ['token' => $token]];
    }

    public function validateToken() : array {
        if(!isset($this->params['token']))
            return ['code' => 422, 'message' => 'Missing Parameters', 'data' => ['error' => 422, 'message' => 'Missing Parameters.']];
        if($this->jwt->validateToken(urldecode($this->params['token'])))
            return ['code' => 200, 'message' => 'OK', 'data' => ['payload' => $this->jwt->decryptPayload(urldecode($this->params['token']))]];

        return ['code' => 200, 'message' => 'OK', 'data' => ['error' => 'Invalid Token']];
    }
}