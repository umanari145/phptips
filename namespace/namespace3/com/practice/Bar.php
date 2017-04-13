<?php

namespace Com\Practice;

//通常はフルパスを定義
use Com\Sample\Hoge;

require_once ("../sample/Hoge.php");

//クラス名のみで呼び出すことが一般的
$hoge = new Hoge();

class Bar{

	public function __construct(){
		echo "this is bar class";
	}


}
