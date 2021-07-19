<?php

require_once 'config.php';
require_once 'ProdSendMail.php';
require_once 'TestSendMail.php';

//$sendMail = new SendMail(new ProdSendMail());
$sendMail = new SendMail(new TestSendMail());

$sendMail->sendMailForExe('umanari145@gmail.com', 'メールタイトル', 'メール本文');


class SendMail
{
    private $sendMailClass;

    public function __construct(SendMailIF $sendMailClass)
    {
        $this->sendMailClass = $sendMailClass;
    }

    function sendMailForExe(string $to, string $title, string $message)
    {
        $this->sendMailClass->sendmail($to, $title, $message);
    }

}
