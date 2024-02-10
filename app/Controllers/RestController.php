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

        if(DEV_MODE && LOGS && REST_CONTR_LOGS)
            var_dump($this->params);
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

    public function test() : array {
        $data = isset($_REQUEST['testa']) ? $_REQUEST['testa'] : 1;
        return ['message' => 'GET!', 'data' => $data];
    }

    public function testp() : array {
        $data = isset($_REQUEST['testa']) ? $_REQUEST['testa'] : 1;
        return ['message' => 'POST!', 'data' => $data];
    }

    public function testput() : array{
        $data = isset($_REQUEST['testa']) ? $_REQUEST['testa'] : 1;
        return ['message' => 'PUT!', 'data' => $data];
    }

    public function testdel() : array{
        $data = isset($_REQUEST['testa']) ? $_REQUEST['testa'] : 1;
        return ['message' => 'DELETE!', 'data' => $data];
    }
}