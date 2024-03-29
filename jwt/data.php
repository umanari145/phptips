<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use \Firebase\JWT\JWT;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// GET 時
if (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') {
    $auth = isset($_SERVER['HTTP_AUTHORIZATION']) ? $_SERVER['HTTP_AUTHORIZATION'] : '';
    if (preg_match('#\ABearer\s+(.+)\z#', $auth, $m) === 1) { // Bearer xxxx...
        $jwt = $m[1];
        try {
            $payload = JWT::decode($jwt, $_ENV['JWT_KEY'], array($_ENV['JWT_ALG'])); // JWT デコード (失敗時は例外)
            $username = $payload->username; // エンコード時のデータ取得

            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *'); // CORS
            echo json_encode(array('username' => $username)); //データを返す
            return;
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }
    // Bearer が取得できない、JWT のでコードに失敗した場合は 401
    http_response_code(401);
}