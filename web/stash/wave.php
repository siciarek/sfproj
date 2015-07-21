<?php

$pi = M_PI;

$f = 4;
$seconds = 2;
$sample_rate = 100;
$len = $seconds * $sample_rate;

$time = range(0, $len);

$result = [];

foreach ($time as $pos) {
    $t = ($pos / $sample_rate);
    $sample = sin(2 * M_PI * $t * $f);
    $sample = (8.0/pow($pi, 2)) * (sin(2.0 * $pi * $f * $t) -  (1.0/9.0) * sin(6 * $pi * $f * $t) + (1.0 / 25.0) * sin(10.0 * $pi * $f * $t));
    $sample = (4.0/($pi)) * (sin(2.0 * $pi * $f * $t) + (1.0/3.0) * sin(6 * $pi * $f * $t) + (1.0/5.0) * sin(10.0 * $pi * $f * $t));

    echo printf('%.12f', $sample) . PHP_EOL;
}