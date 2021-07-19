<?php

require_once 'ProdSendMail.php';
require_once 'TestSendMail.php';
require_once "../../vendor/autoload.php";

use Pimple\Container;

$container = new Container();

$container['sendMail'] = $container->factory(function () {
    //メール送信(テスト)
    return new TestSendMail();
    //メール送信(本番)
    //return new ProdSendMail();
});
