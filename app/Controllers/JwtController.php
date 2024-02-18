<?php
namespace App\Controllers;

use Exception;

class JwtController {
    private string $key;

    public function __construct($key)
    {
        $this->key = $key;
    }

    private function base64url_encode(string $data) : string{
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
      }
      
    private function base64url_decode(string $data) : string{
        return base64_decode(strtr($data, '-_', '+/') . str_repeat('=', 3 - (3 + strlen($data)) % 4 ));
    }

    // Create a jwt token
    public function createToken(array $payload) : string
    {
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256', 'exp' => (time() + 3600)]);
        $payload = json_encode($payload);

        // Encrypt the payload using AES with the same key
        $iv = openssl_random_pseudo_bytes(16);
        $encryptedPayload = openssl_encrypt($payload, 'AES-256-CBC', $this->key, 0, $iv);

        $base64UrlHeader = $this->base64url_encode($header);
        $base64UrlEncryptedPayload = $this->base64url_encode($encryptedPayload);
        $base64UrlIv = $this->base64url_encode($iv);

        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlEncryptedPayload . "." . $base64UrlIv, $this->key, true);
        $base64UrlSignature = $this->base64url_encode($signature);

        $jwt = $base64UrlHeader . "." . $base64UrlEncryptedPayload . "." . $base64UrlIv . "." . $base64UrlSignature;

        return $this->base64url_encode($jwt);
    }

    // Validate the token (sign + exp)
    public function validateToken(string $jwt) : bool
    {
        $jwt = $this->base64url_decode($jwt);
        $tokenParts = explode('.', $jwt);

        if (count($tokenParts) !== 4)
            return false;
        
        try {
            $signature = $tokenParts[3];

            $validSignature = hash_hmac('sha256', $tokenParts[0] . "." . $tokenParts[1] . "." . $tokenParts[2], $this->key, true);
            $base64UrlValidSignature = $this->base64url_encode($validSignature);

            if ($base64UrlValidSignature === $signature)
            {
                $header = json_decode($this->base64url_decode($tokenParts[0]), true);
                if($header['exp'] > time())
                    return true;
            }  
        } catch (Exception $e) {
            return false;
        }

        return false;
    }

    // Get the original payload
    // Unsafe function
    // Used after validation
    public function decryptPayload(string $jwt) : array
    {
        $jwt = $this->base64url_decode($jwt);
        $tokenParts = explode('.', $jwt);
        $encryptedPayload = $this->base64url_decode($tokenParts[1]);
        $iv = $this->base64url_decode($tokenParts[2]);

        $decryptedPayload = openssl_decrypt($encryptedPayload, 'AES-256-CBC', $this->key, 0, $iv);

        return json_decode($decryptedPayload, true);
    }
}