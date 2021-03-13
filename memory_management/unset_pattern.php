<?php

require_once 'memory_util.php';

echo "使用前 - " . memory_calc() . "\n";

//この状態だとメモリがセットされないのか100万ループしても確保されない
$foo = sample();

echo "100万ループ後" . memory_calc() ."\n";

unset($foo);

echo "解放後" . memory_calc() ."\n";

function sample()
{
    $foo = [];
    for ($i=0; $i<1000000; $i++) {
        $foo[$i] = "Hello " . $i;
    }
    return $foo;
}