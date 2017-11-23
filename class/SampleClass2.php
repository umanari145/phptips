<?php
//マジックメソッドcallの使い方

$sc2 = new SampleClass2();

//通常ならundefinedだが_callがあればそちらが呼ばれる
$kaiin_list = $sc2->kaiin_list();
//var_dump($kaiin_list);
//array(2) {
//    [0] =>
//    string(6) "会員"
//    [1] =>
//    string(9) "非会員"
//}
class SampleClass2
{

    private $kaiin_list = array(
        0=>'会員',
        1=>'非会員'
    );

    # リストまたはリストのひとつの要素の値を返す
    public function __call($method, $args)
    {
        // リストの決定
        if (isset($this->$method)) {
            $list = $this->$method;
        } else {
            throw new \exception("undefined method: {$method}");
        }

        return $list;
    }

}