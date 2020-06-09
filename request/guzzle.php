<?php

require_once 'vendor/autoload.php';
require_once 'conf.php';
require_once 'params.php';

$url = GUZZLE_URL . '/users/login';
$client = new \GuzzleHttp\Client([
    'cookies' => true, 'http_errors' => false
]);

$response = $client->post($url, [
    'form_params' => $formParams
]);

//$response->getBody();

$url2 = GUZZLE_URL . '/users/viewannouncelist';
$response2 = $client->get($url2);
echo $response2->getBody();
exit();


/*
$('input').each(function(i,e){
	console.log($(e).attr('name'))
})
*/
