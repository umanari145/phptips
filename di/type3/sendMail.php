<?php

require_once 'sendMailDI.php';
require_once 'TestSendMail.php';

//テスト用
//injection(new TestSendMail());
//本番用
injection(new ProdSendMail());
