<?php

/**
 * http://hamuhamu.hatenablog.jp/entry/2015/08/17/020308
 *
 */

Class Calcer{
    public function calc($food, $num) {
        echo "calc\n";
    }
}

Class Register{
    public function pay($payment, $money) {
        echo "pay\n";
    }
}

Class Coupon{
    public function publish($userId) {
        echo "publish\n";
    }
}

/**
 *
 * 非DI　かなり複雑なクラス
 *
 */
class BuyFacadeDI{


    private $userId;

    private $food;

    private $num;

    private $money;

    private $calcer;

    private $register;

    private $coupon;

    public function __construct($userId, $food, $num, $money, Calcer $calcer, Register $register, Coupon $coupon)
    {
        $this->userId = $userId;
        $this->food = $food;
        $this->num = $num;
        $this->money = $money;
        $this->calcer = $calcer;
        $this->register = $register;
        $this->coupon = $coupon;
    }

    /**
     * 　ここが注入ポイント(インスタンス変更時はここでコントロール変更できる)
     */
    public static function create($userId, $food, $num, $money)
    {
        return new BuyFacadeDI(
            $userId, $food, $num, $money, new Calcer(), new Register(), new Coupon()
        );
    }

    public function execute(){
        try {
            $this->payment = $this->calcer->calc($this->food, $this->num);
            $this->register->pay($this->payment, $this->money);
            $this->coupon->publish($this->userId);

        } catch (Exception $e) {
            var_dump($e->getMessage());
            throw new Exception($e);
        }

    }
}


$facade = BuyFacadeDI::create(10, "りんご", 50, 5000);
$facade->execute();