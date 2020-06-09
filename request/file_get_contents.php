<?php

require 'conf.php';


$postdata = http_build_query($rawPostData, "", "&");

$header = array(
    "Content-Type: application/x-www-form-urlencoded",
    "Content-Length: ".strlen($postdata)
);
$context = array(
    "http" => array(
        "method"  => "POST",
        "header"  => implode("\r\n", $header),
        "content" => $postdata
    )
);
//第二引数はinclude_pathを使用したい場合に使うようです。
file_get_contents(POST_URL, false, stream_context_create($context));
