<?php

var_dump(mb_get_info());
# mb_get_info
#["mail_charset"]=>
# string(5) "UTF-8"
# ["mail_header_encoding"]=>
# string(6) "BASE64"
# ["mail_body_encoding"]=>
# string(6) "BASE64"
$res = file_get_contents('sample.txt');
$res = mb_convert_encoding($res, 'UTF-8', 'auto');
#Warning: mb_convert_encoding(): Unable to detect character encoding
var_dump($res);
#string(15) "?{???͐??V????


mb_language('Ja');
echo '------------------------';
var_dump(mb_get_info());
#["mail_charset"]=>
#string(11) "ISO-2022-JP"
#["mail_header_encoding"]=>
#string(6) "BASE64"
#["mail_body_encoding"]=>
#string(4) "7bit"
#["illegal_chars"]=>
#int(0)
#["encoding_translation"]=>
#string(3) "Off"
#["language"]=>
#  string(8) "Japanese"
$res = file_get_contents('sample.txt');
#正確に検知できる
$res = mb_convert_encoding($res, 'UTF-8', 'auto');
var_dump($res);
#string(22) "本日は晴天あり
