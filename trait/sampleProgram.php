<?php

require_once 'sampleClass.php';


$sampClass = new SampleClass();

//クラス内部のメソッド
echo $sampClass->hoge(). "\n";

//traitしたクラスのメソッド
echo $sampClass->samplefunc1(1000). "\n";
