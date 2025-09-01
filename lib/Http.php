<?php
namespace WHMWPManager\Lib;

class Http
{
    public static function request(string $method, string $url, ?string $token = null, array $data = []): array
    {
        $ch = curl_init();
        $headers = ['Accept: application/json'];
        if ($token) {
            $headers[] = 'Authorization: Bearer ' . $token;
        }
        if ($data) {
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => strtoupper($method),
            CURLOPT_HTTPHEADER => $headers,
        ]);
        $response = curl_exec($ch);
        if ($response === false) {
            throw new \RuntimeException(curl_error($ch));
        }
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [$status, $response];
    }

    public static function get(string $url, ?string $token = null): array
    {
        return self::request('GET', $url, $token);
    }

    public static function post(string $url, ?string $token = null, array $data = []): array
    {
        return self::request('POST', $url, $token, $data);
    }
}
