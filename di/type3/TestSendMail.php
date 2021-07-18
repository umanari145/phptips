<?php

require_once 'SendMailIF.php';

class TestSendMail implements SendMailIF
{

    public function sendmail(string $to, string $title, string $message)
    {
        echo sprintf("mail_to_%s title_%s message_%s\n", $to, $title, $message);
    }

}