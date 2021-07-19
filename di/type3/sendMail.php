<?php

require_once 'ProdSendMail.php';
require_once 'TestSendMail.php';
require_once 'container.php';


$sendMail = new SendMail($container['sendMail']);
$sendMail->sendMailForExe('umanari145@gmail.com', 'メールタイトル', 'メール本文');

class SendMail
{
    private $sendMailClass;

    public function __construct(SendMailIF $sendMailClass)
    {
        $this->sendMailClass = $sendMailClass;
    }

    public function sendMailForExe(string $to, string $title, string $message)
    {
        $this->sendMailClass->sendmail($to, $title, $message);
    }

}
