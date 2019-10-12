<?php

$fp = fopen('hash_data.txt', 'r');

$total_data_arr = make_hash($fp);
echo_arr($total_data_arr);

function make_hash($fp) {
    $total_data_arr = [];
    $data_arr = [];
    $count = 0;
    while($res = fgets($fp)){

        if ($count == 0) {
            $res = str_replace("\n",'', $res);
            $col_key = $res;
            $count++;
            continue;
        }
        if ($res == "\n" || $res == "--\n") {
            $total_data_arr[$col_key] = $data_arr;
            $count = 0;
            $data_arr = [];
            $col_key = '';
            continue;
        }
        $res = str_replace("\n",'', $res);
        $each_one = sprintf("    '%d' => '%s'", $count, $res);
        $data_arr[] = $each_one;
        $count++;

    }
    return $total_data_arr;
}


function echo_arr($total_data_arr){
    $last_total_arr = [];
    foreach ($total_data_arr as $col_name => $data) {
        $last_total_arr[] = sprintf("'%s' => [", $col_name);
        $last_total_arr[] = implode(",\n", $data);
        $last_total_arr[] = "],";
    }
    echo implode("\n", $last_total_arr);
}
