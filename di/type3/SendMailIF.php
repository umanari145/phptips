<?php 

interface SendMailIF
{
    public function sendmail(string $to, string $title, string $message);


}