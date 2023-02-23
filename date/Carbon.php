<?php

use Illuminate\Support\Carbon;

require_once "../vendor/autoload.php";

$carbon = new Carbon('2023-01-01');

// 以下のような条件あり
// 年月日と時間
// タイムゾーンに対応
// 年は4桁（2桁では年が確定できない）
// 単位は秒まで（ミリ秒も可能だが桁数が定まっていないため）
echo $carbon->toIso8601String();
// 2023-01-01T00:00:00+09:00
