<?php



trait Calculator
{
    private $tax = 0.08;

    public function samplefunc1($price)
    {
        return $price * $this->tax;
    }
}
