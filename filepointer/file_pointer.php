<?php
$fp = fopen("sample_text.txt", 'r');

$res = fgets($fp);
var_dump($res);
var_dump(stream_get_meta_data($fp));
#"
#array(9) {
#  ["timed_out"]=>
#  bool(false)
#  ["blocked"]=>
#  bool(true)
#  ["eof"]=>
#  bool(false)
#  ["wrapper_type"]=>
#  string(9) "plainfile"
#  ["stream_type"]=>
#  string(5) "STDIO"
#  ["mode"]=>
#  string(1) "r"
#  ["unread_bytes"]=>
#  int(436)
#  ["seekable"]=>
#  bool(true)
#  ["uri"]=>
#  string(15) "sample_text.txt"
var_dump(ftell($fp));
#int(147)

$res = fgets($fp);
var_dump($res);
var_dump(stream_get_meta_data($fp));
var_dump(ftell($fp));
#int(364)

rewind($fp);
var_dump(ftell($fp));
#先頭に戻す
#int(0)
