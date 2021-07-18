<?php

require_once 'config.php';
require_once 'TestSendMail.php';
require_once 'ProdSendMail.php';


function injection(SendMailIF $sendmailclass)
{
    $sendmailclass->sendmail('umanari145@gmail.com', 'メールタイトル', 'メール本文');
}
