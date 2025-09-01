<?php
namespace WHMWPManager\Lib;

class Crypto
{
    private string $key;

    public function __construct(string $keyFile)
    {
        if (!is_readable($keyFile)) {
            throw new \RuntimeException("Key file not readable: $keyFile");
        }
        $this->key = hex2bin(trim(file_get_contents($keyFile)));
    }

    public function encrypt(string $plaintext): string
    {
        $iv = random_bytes(16);
        $cipher = openssl_encrypt($plaintext, 'aes-256-gcm', $this->key, OPENSSL_RAW_DATA, $iv, $tag);
        return base64_encode($iv . $tag . $cipher);
    }

    public function decrypt(string $ciphertext): string
    {
        $data = base64_decode($ciphertext);
        $iv = substr($data, 0, 16);
        $tag = substr($data, 16, 16);
        $cipher = substr($data, 32);
        return openssl_decrypt($cipher, 'aes-256-gcm', $this->key, OPENSSL_RAW_DATA, $iv, $tag);
    }
}
