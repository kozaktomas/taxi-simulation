<?php

/**
 * Return random number from gauss distribution
 * @param mixed $mean
 * @param mixed $sd
 * @return integer|float
 */
function gauss_random($mean, $sd) {
    $w = 2.0;
    while (($w >= 1.0) || ($w == 0.0)) {
        $x = (2.0 * ((float) mt_rand() / (float) mt_getrandmax())) - 1.0;
        $y = (2.0 * ((float) mt_rand() / (float) mt_getrandmax())) - 1.0;
        $w = ($x * $x) + ($y * $y);
    }
    $xw = sqrt((-2.0 * log($w)) / $w);
    $res = $x * $xw;
    return ($res * ($sd / 4) + $mean);
}

function time_index($time) {
    $index = intval($time) / 120;
    return floor($index);
}
