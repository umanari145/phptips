<?php

$argument_str = "";
//inputfile
$argument_str .= "i:";
//outputfile
$argument_str .= "o:";
//table
$argument_str .= "t:";

$options = getopt($argument_str);

if (count($options) !== 3) {
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
while ($value = fgetcsv($fp)) {
    if ($index == 0) {
        $header = $value;
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

$total_ins_list = [];
foreach ($record as $eachrecord) {
    $column = array_keys($eachrecord);
    $value_list = array_values($eachrecord);
    $value_list = array_map(function ($v) {
        return "'" . $v . "'";
    }, $value_list);

    $each_data_arr = [];
    $each_data_str = implode(",", $value_list);
    $total_ins_list[] = "(" . $each_data_str . ")";
}
$sql = sprintf("INSERT INTO %s (%s) VALUES %s ", $options["t"], implode(",", $column), implode(",", $total_ins_list));
$outputfile = sprintf("sql/%s_%s.sql", $options['o'], date('YmdHis'));
file_put_contents($outputfile, $sql);
