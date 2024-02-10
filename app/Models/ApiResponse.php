<?php

namespace App\Models;

class ApiResponse {
    private int $status;
    private string $message;
    private array $data;

    public function __construct(){
       $this->reset();
    }

    private function reset() : void{
        $this->status = 500;
        $this->message = 'Internal Server Error';
        $this->data = ['error' => 500, 'message' => 'No data prepared for the response.'];
    }

    public function prepareResponse(int $status, string $message, ?array $data = null) : void{
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }

    private function toArray() : array{
        return array(
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        );
    }

    public function toJson() : string|false{
        $res = json_encode($this->toArray());
        $this->reset();
        return $res;
    }
}