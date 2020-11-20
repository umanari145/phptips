<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ .'/Controller/TopController.php';

$router = new AltoRouter();
$hoge = new  App\Controller\TopController();

$router->map('GET','/routing/sampleAction', 'App\Controller\TopController::sampleAction', 'sampleAction');
$match = $router->match();


if(is_array($match) && is_callable($match['target'])) {
    $params = explode("::", $match['target']);
    $action = new $params[0]();
    call_user_func_array(array($action, $params[1]) , $match['params']);
} else {
    exit('404');
}

