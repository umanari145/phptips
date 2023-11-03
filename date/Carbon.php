<?php

use Carbon\Carbon;
use Carbon\CarbonImmutable;

require_once "../vendor/autoload.php";

$carbon = new Carbon('2023-01-01');

// 以下のような条件あり
// 年月日と時間
// タイムゾーンに対応
// 年は4桁（2桁では年が確定できない）
// 単位は秒まで（ミリ秒も可能だが桁数が定まっていないため）
echo $carbon->toIso8601String() . "\n";;
// 2023-01-01T00:00:00+09:00

$now = Carbon::now();
echo $now->format('Y-m-d') . " 本当の今日の日付　\n";
$tomorrow = $now->addDay();

echo $now->format('Y-m-d') . " ２行上のaddDayによりすんでしまう\n";
echo $tomorrow->format('Y-m-d') . "\n";

$now = Carbon::now();
echo $now->format('Y-m-d') . " 今日の日付　\n";
$tomorrow = $now->addDay();

echo $now->format('Y-m-d') . " ２行上のaddDayによりすんでしまう\n";

echo "Immutableを使うことで値が変わらない　\n";
$now = CarbonImmutable::now();
echo $now->format('Y-m-d') . " 今日の日付　\n";
$tomorrow = $now->addDay();
echo $now->format('Y-m-d') . " addDayを使ってもすすまない\n";
