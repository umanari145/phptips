<?php

require_once 'SendMailIF.php';

class ProdSendMail implements SendMailIF
{

    public function sendmail(string $to, string $title, string $message)
    {
        echo sprintf("prod_mail_to_%s title_%s message_%s\n", $to, $title, $message);
    }

}