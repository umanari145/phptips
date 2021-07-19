<?php

require_once 'ProdSendMail.php';
require_once 'TestSendMail.php';
require_once "../../vendor/autoload.php";
require_once "config.php";

use Pimple\Container;

$container = new Container();

$container['sendMail'] = $container->factory(function () {
    switch (ENV) {
        case 'test':
            //メール送信(テスト)
            return new TestSendMail();
        break;
        case 'prod':
            //メール送信(本番)
            return new ProdSendMail();
        break;
    }
});
