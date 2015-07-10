<?php

define('GNUPLOT', 'gnuplot');
define('SAMPLING', 64);
define('M_2PI', 2 * M_PI);

$count = 5;
$delay = -1;
$frequencies = [];

$max = 48;

while(count($frequencies) < $count) {
	$r = rand(1, $max);
	if(in_array($r, $frequencies)) {
		continue;
	}
	$frequencies[] = $r;
}

$frequencies = [3, 7];

sort($frequencies);

function generateSamples($freq, $duration = 1) {
   
    $parts =  SAMPLING / $freq;
    $chunk = M_2PI / $parts;    
	$samples = [];
	
	for($s = 0; $s < $duration; $s++) {
		for($v = 0; $v < $freq * M_2PI; $v+= $chunk) {
			$samples[] = number_format(sin($v), 12);
		}
	}

	return $samples;
}

$time = [];

foreach($frequencies as $f) {
    $time[] = generateSamples($f);
}

$x = [];

for ($i = 0; $i < count($time[0]); $i++) {
    $sample = 0;

    foreach ($time as $key) {
        $sample = $sample + $key[$i];
    }

    $x[] = $sample;
}


//$x = [];
//for($i = 0; $i < 512; $i++) {
//    
//    if($i < 62) {
//        $x[] = (rand(0, 1) ? -1 : 1) * 0.05 * floatval(rand(0, $i % 32));
//        continue;
//    }
//    
//    $x[] = 0;
//}

// ----- Koniec generowania 

$N = count($x);
$m = 0;
$j = 1;

$X = [];

for ($m = 0; $m < $N; $m++) {
    $sum = 0;

    for ($n = 0; $n < $N; $n++) {
        $coef = (M_2PI * $n * $m) / $N;
        $sum += $x[$n] * cos($coef) - $x[$n] * sin($coef);
    }

    $X[$m] = abs($sum);
}

unlink('time.dat');
unlink('frequency.dat');

file_put_contents('time.dat', implode("\n", $x));
file_put_contents('frequency.dat', implode("\n", $X));

$xmax = intval($N / 2);
$xmax = end($frequencies) + 1;

$title = json_encode($frequencies);

$plot = <<<PLOT
set multiplot

set title "$title"
set size 1, 0.5
set origin 0, 0.5
#set xrange [0:20]
plot "time.dat" notitle with lines

unset title
set xtics 2
set size 1, 0.5
set origin 0, 0
set xrange [0:$xmax]
plot "frequency.dat" notitle with lines

unset multiplot
pause($delay)
PLOT;

file_put_contents('temp.gpl', $plot);
$cmd = sprintf('%s temp.gpl', GNUPLOT);

system($cmd);

