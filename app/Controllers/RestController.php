<?php

namespace App\Controllers;

class RestController {
    private $method;
    private $endpoint;
    private $params;

    public function __construct() {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->endpoint = $_SERVER['REQUEST_URI'];
        $this->params = $_REQUEST;
    }

    public function handleRequest() {
        switch ($this->method) {
            case 'GET':
                $this->handleGetRequest();
                break;
            case 'POST':
                $this->handlePostRequest();
                break;
            case 'PUT':
                $this->handlePutRequest();
                break;
            case 'DELETE':
                $this->handleDeleteRequest();
                break;
        }
    }

    public function test(){
        return ['message' => 'Hello world!'];
    }

    private function handleGetRequest() {
        // Implementa la logica per gestire le richieste GET
    }

    private function handlePostRequest() {
        // Implementa la logica per gestire le richieste POST
    }

    private function handlePutRequest() {
        // Implementa la logica per gestire le richieste PUT
    }

    private function handleDeleteRequest() {
        // Implementa la logica per gestire le richieste DELETE
    }
}