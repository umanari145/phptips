<?php

#参考 http://staff.osakan-space.com/wp-content/uploads/2017/07/%E3%82%A8%E3%83%A9%E3%83%BC%E3%82%B3%E3%83%BC%E3%83%89%E8%A1%A8_1_73.pdf
$records = load_csv("gmo_error_code.csv");

$errorHash = parse_error_code($records, "ErrorInfo", "ErrorMessage");
var_dump($errorHash);

function load_csv($filePath) {

    $fp = fopen($filePath, "r");
    $records = [];
    $loopCnt = 0;
    while($res = fgetcsv($fp)) {
        if ($loopCnt === 0) {
            $header = $res;
        } else {
            $data = $res;

            if (count($header) === count($data)) {
                $hash = array_combine($header, $data);
                $records[] = $hash;
            }

        }
        $loopCnt++;
    }
    return $records;
}

function parse_error_code($records, $keyCol, $valCol) {
    $hash = [];
    foreach ($records as $record) {
        if (isset($record[$keyCol]) && isset($record[$valCol])) {
            $key = $record[$keyCol];
            $val = $record[$valCol];
            $hash[$key] = $val;
        }
    }
    return $hash;
}