<?php

namespace Com\Practice;


require_once ("../sample/Hoge.php");

//名前空間違うから呼び出せない
//Fatal error: Class 'Com\Sample\Practice\Hoge' not found
//$hoge = new Hoge();

//フルパスでいけばOK
//冒頭の\がないと相対パスになる
$hoge = new \Com\Sample\Hoge();

class Bar{

	public function __construct(){
		echo "this is bar class";
	}


}