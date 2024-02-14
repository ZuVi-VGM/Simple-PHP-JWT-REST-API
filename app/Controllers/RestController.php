<?php

namespace App\Controllers;

class RestController {
    private string $method;
    private string $endpoint;
    private array $params;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->endpoint = $_SERVER['REQUEST_URI']; //maybe for other checks...

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

    public function test() : array {
        return ['message' => 'GET!', 'params' => $this->params];
    }

    public function testp() : array {
        return ['message' => 'POST!', 'params' => $this->params];
    }

    public function testput() : array{
        return ['message' => 'PUT!', 'params' => $this->params];
    }

    public function testdel() : array{
        return ['message' => 'DELETE!', 'params' => $this->params];
    }
}