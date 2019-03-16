<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$sentry_url  = getenv('SENTRY_URL');
Sentry\init(['dsn' => $sentry_url ]);

try {
    throw new Exception("Error Processing Request", 1);
} catch (Exception $exception) {
    Sentry\captureException($exception);
}
