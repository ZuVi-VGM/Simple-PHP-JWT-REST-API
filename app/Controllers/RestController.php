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
            default:
                $this->respondNotFound();
                break;
        }

        // Creazione di un'istanza di ApiResponse
        //$response = new ApiResponse(200, 'Success', $data);

        // Invio della risposta JSON al client
        //echo $response->toJson();
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

    private function respondJson($data) {
        // Imposta l'header Content-Type per indicare che la risposta è in formato JSON
        header('Content-Type: application/json');

        // Codifica i dati della risposta in formato JSON
        $jsonResponse = json_encode($data);

        // Invia la risposta JSON al client
        echo $jsonResponse;
    }

    private function respondNotFound() {
        http_response_code(404);
        echo json_encode(array('error' => 'Not Found'));
    }
}