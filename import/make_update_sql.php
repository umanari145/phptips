<?php

$argument_str = "";
//inputfile
$argument_str .= "i:";
//outputfile
$argument_str .= "o:";
//table
$argument_str .= "t:";
//key
$argument_str .= "k:";

$options = getopt($argument_str);

if (count($options) !== 4) {
    exit("引数が不足しています。\n");
}


if (!file_exists($options['i'])) {
    exit("ファイル名が存在しません。\n");
}

$fp = fopen($options["i"], 'r');

if (empty($fp)) {
    echo 'ファイルが存在しないか、不正です。';
}

$update_table = $options['t'];

$list = [];
$header = [];
$index = 0;
$update_key_index;
$update_key_str = $options["k"];
while ($value = fgetcsv($fp)) {
    if ($index == 0) {
        $header = $value;
        foreach ($header as $key_index => $h) {
            if ($update_key_str === $h) {
                $update_key_index = $key_index;
            }
        }
    } else {
        $hash = [];
        for ($i=0; $i<count($header); $i++) {
            $headerStr = $header[$i];
            $valueStr = $value[$i];
            $hash[$headerStr] = $valueStr;
        }
        $record[] = $hash;
    }
    $index++;
}


foreach ($record as $eachrecord) {
    $column = array_keys($eachrecord);
    $value_list = array_values($eachrecord);

    $col_con = count($column);
    $update_list = [];
    $update_value;
    for ($i =0; $i < $col_con; $i++) {
        if ($i == 0) {
            $update_value = $value_list[$update_key_index];
        } else {
            $update_list[]=sprintf("%s = '%s'", $column[$i], $value_list[$i]);
        }
    }
    $sql[] = sprintf("UPDATE %s SET %s WHERE %s = '%s' ; ", $update_table, implode(' , ', $update_list), $update_key_str, $update_value);
}

$text = implode("\n", $sql);
$outputfile = sprintf("sql/%s_%s.sql", $options['o'], date('YmdHis'));
file_put_contents($outputfile, $text);
