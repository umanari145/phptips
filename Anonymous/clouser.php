<?php


class Cart
{
    const TAX = 0.08;

    private $products = [];

    public function add($productName, $price, $quantity)
    {
        $this->products[$productName] = [
            'price'    => $price,
            'quantity' => $quantity
        ];
    }

    public function getTotal()
    {
        $total = 0;

        array_walk( $this->products, function ($productInfo, $productName) use (&$total){
             $total += $productInfo['price'] * ( 1 + self::TAX ) * $productInfo['quantity'];
        });

        return round($total,2);
    }

}


$myCart = new Cart;
$myCart->add('apple',150,3);
$myCart->add('orange',250,4);

echo $myCart->getTotal();
