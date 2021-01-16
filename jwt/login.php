<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use Firebase\JWT\JWT;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// POST 時
if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
    $inputString = file_get_contents('php://input'); // JSON 文字列取得
    $input = @json_decode($inputString, true);

    if (is_array($input)) {
        $input = array_merge(array('username' => '', 'password' => ''), $input);
        $username = $input['username'];
        $password = $input['password'];

        $ok = ($username == $_ENV['USER_NAME'] && $password == $_ENV['PASSWORD']);

        if ($ok) {
            $payload = array(
                'iss' => $_ENV['JWT_ISSUER'],
                'exp' => time() + $_ENV['JWT_EXPIRES'],
                'username' => $username,
            );
            $jwt = JWT::encode($payload, $_ENV['JWT_KEY'], $_ENV['JWT_ALG']);
            header('Content-Type: application/json');
            header('Access-Control-Allow-Origin: *'); // CORS
            echo json_encode(array('token' => $jwt)); // token を返却
            exit();
        }
    }
    // JSON 取得失敗、認証に失敗した場合は 401
    http_response_code(401);
}