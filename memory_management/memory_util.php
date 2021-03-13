<?php


function memory_calc($isTotal = true):string
{
    return sprintf("%f MB", (memory_get_usage($isTotal) / 1000000));
}
