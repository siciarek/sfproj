<?php

define('GNUPLOT', 'gnuplot');
define('M_2PI', 2 * M_PI);

function generateSamples(&$t, $freq, $sampling = 256, $duration = 3) {
   
    $parts =  $sampling / $freq;
    $chunk = M_2PI / $parts;

    $i = count($t);
    
    $t[$i] = [];

    foreach (range(0, $freq * M_2PI, $chunk) as $v) {
        $t[$i][] = number_format(sin($v), 12);
    }
    
    return $t; 
}

$time = [];
$time = generateSamples($time, 1);
$time = generateSamples($time, 2);
$time = generateSamples($time, 4);
$time = generateSamples($time, 7);
$time = generateSamples($time, 8);


$x = [];

for ($i = 0; $i < count($time[0]); $i++) {
    $sample = 0;

    foreach ($time as $key) {
        $sample += $key[$i];
    }

    $x[] = $sample;
}

$N = count($x);
$m = 0;
$j = 1;

$X = [];
for ($m = 0; $m < $N; $m++) {
    $sum = 0;

    for ($n = 0; $n < $N; $n++) {
        $coef = (M_2PI * $n * $m) / $N;
        $sum += $x[$n] * (cos($coef) - sin($coef));
    }

    $X[$m] = abs($sum);
}

unlink('time.dat');
unlink('frequency.dat');

file_put_contents('time.dat', implode("\n", $x));
file_put_contents('frequency.dat', implode("\n", $X));

$xmax = 9;

$plot = <<<PLOT
set multiplot

set size 1, 0.5
set origin 0, 0.5
plot "time.dat" notitle with points

set size 1, 0.5
set origin 0, 0
set xrange [0:$xmax]
plot "frequency.dat" notitle with impulses 

unset multiplot
pause(3)
PLOT;

file_put_contents('temp.gpl', $plot);
$cmd = sprintf('%s temp.gpl', GNUPLOT);

system($cmd);

