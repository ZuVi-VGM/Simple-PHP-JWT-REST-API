<?php

namespace App\Models;

class ApiResponse {
    private $status;
    private $message;
    private $data;

    public function __construct($status, $message, $data = null) {
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }

    private function toArray() {
        return array(
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data
        );
    }

    public function toJson() {
        return json_encode($this->toArray());
    }
}