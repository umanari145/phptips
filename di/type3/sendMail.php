<?php

require_once 'config.php';
require_once 'TestSendMail.php';
require_once 'ProdSendMail.php';

switch (ENV) {
    case 'development':
        $sendmail = new TestSendMail();
        $sendmail->sendmail('umanari145@gmail.com', 'メールタイトル', 'メール本文');
        break;
    case 'prod':
        $sendmail = new ProdSendMail();
        $sendmail->sendmail('umanari145@gmail.com', 'メールタイトル', 'メール本文');
        break;
}
