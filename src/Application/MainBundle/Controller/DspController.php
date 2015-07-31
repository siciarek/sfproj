<?php

namespace Application\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Process\ProcessBuilder;
use Symfony\Component\Process\Process;

define('M_2PI', 2 * M_PI);
define('SAMPLING', 64);

/**
 * @Route("/dsp")
 */
class DspController extends Controller {

    function generateSamples($freq, $duration = 1) {

        $parts = SAMPLING / $freq;
        $chunk = M_2PI / $parts;
        $samples = [];

        for ($s = 0; $s < $duration; $s++) {
            for ($v = 0; $v < $freq * M_2PI; $v+= $chunk) {
                $samples[] = number_format(sin($v), 12);
            }
        }

        return $samples;
    }

    /**
     * @Route("/", name="dsp.index")
     */
    public function indexAction() {

        $width = 1600;
        $height = 800;

        // Create data series:
        $count = 256;
        $max = 32;

        $time = [];
        $dft = [];
        $rdft = [];

        // Create time domain samples:
        $frequency = 3;
        $time = $this->generateSamples($frequency);

        // Convert to frequency domain (DFT):
        $N = count($time);
        $count = $N;
        $m = 0;
        $j = 1;

        $dft = [];

        for ($m = 0; $m < $N; $m++) {
            $real = 0;
            $imag = 0;

            for ($n = 0; $n < $N; $n++) {
                $coef = (M_2PI * $n * $m) / $N;
                $real += $time[$n] * cos($coef);
                $imag += $time[$n] * sin($coef);
            }

            $dft[$m] = [$real, $imag];
        }

        // Convert to time domain (RDFT):
        foreach (range(0, $count - 1) as $i) {
            $rdft[] = rand(0, $max);
        }

        // Prepare data for gnuplot:
        $data = [];

        foreach (range(0, $count - 1) as $i) {
            $freq = sqrt(pow($dft[$i][0], 2) + pow($dft[$i][1], 2));
            $data[] = sprintf('%s %s %s', $time[$i], $freq, $rdft[$i]);
        }

        $data[] = 'e';
        $dat = implode("\n", $data);
        $input = implode("\n", [$dat, $dat, $dat]);

        // Get gnuplot path:
        $process = new Process('which gnuplot');
        $output = $process->mustRun(function ($type, $buffer) {
                    if (Process::ERR === $type) {
                        throw new \Exception($buffer);
                    }
                })->getOutput();
        $gnuplot = trim($output);

        // Create chart image:
        $plot = <<<PLOT
set terminal pngcairo size $width,$height
set xrange [0:$count]
                
set multiplot layout 3, 1
       
set title 'Time domain' 
plot '-' using 1 notitle with lines ls 1               

set title 'DFT' 
plot '-' using 2 notitle with impulses ls 2           

set title 'RDFT' 
plot '-' using 3 notitle with lines ls 3               

unset multiplot
PLOT;
        $plot = preg_replace('/\n+/', ';', $plot);
        $cmd = sprintf('%s -e "%s"', $gnuplot, $plot);

        $process = new Process($cmd);
        $process->setInput($input);

        $content = $process->mustRun(function ($type, $buffer) {
                    if (Process::ERR === $type) {
                        throw new \Exception($buffer);
                    }
                })->getOutput();

        // Create response:
        $response = new \Symfony\Component\HttpFoundation\Response();
        $finfo = new \finfo(FILEINFO_MIME);
        $contentType = $finfo->buffer($content);
        $response->headers->set('Content-Type', $contentType);
        $response->setContent($content);
        return $response->send();
    }

}
