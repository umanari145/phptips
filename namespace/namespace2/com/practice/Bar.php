<?php

namespace Com\Practice;

//通常は何もしなければフルパスを記述するしかないが
//下記のような方法で名前空間の名称を意図的に変更できる
//(両方書いたらエラーになるので注意)
use Com\Sample as Sample; //フルパスを使わずにSampleでいける
use Com\Sample; //asがない場合、最後の\以下が名前空間名になる

require_once ("../sample/Hoge.php");

//useを使うことによりフルパスでなくてもいける
$hoge = new Sample\Hoge();

class Bar{

	public function __construct(){
		echo "this is bar class";
	}


}
