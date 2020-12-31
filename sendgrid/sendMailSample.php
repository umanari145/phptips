<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use SendGrid\Mail\Mail;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$SENDGRID_API_KEY = $_ENV['SENDGRID_API_KEY'];
$email = new Mail();
$email->setFrom("matsumoto@kourinnet.co.jp", "Matsumoto Norio");
$email->setSubject("subject test");
$email->addTo("umanari145@gmail.com", "Example User");
$email->addContent("text/plain", "testdayo");

$sendgrid = new SendGrid($SENDGRID_API_KEY);
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}