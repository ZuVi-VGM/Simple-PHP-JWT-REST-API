<?php
namespace App\Controllers;

class JwtController {
    private string $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    // Metodo per creare un token JWT
    public function createToken(array $payload) : string
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode($payload);

        // Crittografiamo il payload utilizzando AES con la stessa chiave
        $iv = openssl_random_pseudo_bytes(16);
        $encryptedPayload = openssl_encrypt($payload, 'AES-256-CBC', $this->key, 0, $iv);

        $base64UrlHeader = base64_encode($header);
        $base64UrlEncryptedPayload = base64_encode($encryptedPayload);
        $base64UrlIv = base64_encode($iv);

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlEncryptedPayload . "." . $base64UrlIv, $this->key, true);
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        $jwt = $base64UrlHeader . "." . $base64UrlEncryptedPayload . "." . $base64UrlIv . "." . $base64UrlSignature;

        return $jwt;
    }

    // Metodo per validare e decodificare un token JWT
    public function validateToken(string $jwt) : bool
    {
        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $encryptedPayload = base64_decode($tokenParts[1]);
        $iv = base64_decode($tokenParts[2]);
        $signature = $tokenParts[3];

        $base64UrlHeader = base64_encode($header);
        $base64UrlIv = base64_encode($iv);

        $validSignature = hash_hmac('sha256', $base64UrlHeader . "." . $tokenParts[1] . "." . $base64UrlIv, $this->key, true);
        $base64UrlValidSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($validSignature));

        return ($base64UrlValidSignature === $signature);
    }

    public function decryptPayload(string $jwt) : array
    {
        $tokenParts = explode('.', $jwt);
        $encryptedPayload = base64_decode($tokenParts[1]);
        $iv = base64_decode($tokenParts[2]);

        // Decrittografiamo il payload utilizzando AES con la stessa chiave
        $decryptedPayload = openssl_decrypt($encryptedPayload, 'AES-256-CBC', $this->key, 0, $iv);

        return json_decode($decryptedPayload, true);
    }
}