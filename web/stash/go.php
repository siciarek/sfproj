<?php

/*

  http://www.imageprocessingplace.com/root_files_V3/image_databases.htm
  http://lodev.org/cgtutor/filtering.html
 */


require_once __DIR__ . DIRECTORY_SEPARATOR . 'imglib.php';

/**
 * http://blog.ivank.net/fastest-gaussian-blur.html
 * https://en.wikipedia.org/wiki/Gaussian_blur
 * 
 * @param type $pixels
 * @param type $info
 * @param type $r
 * @return array
 */
function gaussianBlur($pixels, $info, $r = 3) {
    $result = [];

    $channels = [];

    $img = imagecreatetruecolor(1, 1) or die("Cannot Initialize new GD image stream");

    for ($i = 0; $i < count($pixels); $i++) {
        $RGB = $pixels[$i];

        $R = ($RGB >> 16) & 0xFF;
        $G = ($RGB >> 8) & 0xFF;
        $B = $RGB & 0xFF;

        $channels[] = [
            'R' => $R,
            'G' => $G,
            'B' => $B,
        ];
    }

    $temp = [];

    $w = $info['width'];
    $h = $info['height'];

    /**
     * Operację wykonujemy osobno dla każdego kanału
     */
    foreach (['R', 'G', 'B'] as $ch) {
        $scl = [];
        $tcl = [];

        $rs = ceil($r * 2.57);

        foreach ($channels as $c) {
            $scl[] = $c[$ch];
        }

        echo PHP_EOL;
        var_dump($ch);

        // Algorytm przetwarzania kanału:
        for ($i = 0; $i < $h; $i++) {
            for ($j = 0; $j < $w; $j++) {

                echo '.';
                
                $val = 0;
                $wsum = 0;

                // Przelicza wszystkie wartości znajdujące się w oknie:
                for ($iy = $i - $rs; $iy < $i + $rs + 1; $iy++) {
                    for ($ix = $j - $rs; $ix < $j + $rs + 1; $ix++) {

                        // Pomija wartości ujemne
                        $x = min($w - 1, max(0, $ix));
                        $y = min($h - 1, max(0, $iy));

                        // Właściwy wzór na rozmycie
                        $dsq = pow(($ix - $j), 2) + pow(($iy - $i), 2);
                        $wght = exp(-$dsq / (2 * pow($r, 2))) / (2 * M_PI * pow($r, 2));

                        $val += $scl[$y * $w + $x] * $wght;
                        $wsum += $wght;
                    }
                }

                $tcl[$i * $w + $j] = round($val / $wsum);
            }
        }

        for ($i = 0; $i < count($tcl); $i++) {
            $temp[$i][] = $tcl[$i];
        }
    }

    foreach ($temp as $RGB) {
        list($R, $G, $B) = $RGB;
        $result[] = imagecolorallocate($img, $R, $G, $B);
    }

    imagedestroy($img);

    return $result;
}

/**
 * http://www.tannerhelland.com/3643/grayscale-image-algorithm-vb6/
 * 
 * @param type $pixels
 * @param type $info
 * @param type $algorithm
 * @param type $shades
 * @return array
 */
function grayScale($pixels, $info, $algorithm = 'luminosity', $shades = 32) {

    $result = [];

    $img = imagecreatetruecolor(1, 1) or die("Cannot Initialize new GD image stream");

    for ($i = 0; $i < count($pixels); $i++) {
        $RGB = $pixels[$i];

        $R = ($RGB >> 16) & 0xFF;
        $G = ($RGB >> 8) & 0xFF;
        $B = $RGB & 0xFF;

        switch ($algorithm) {
            case 'shades':
                $factor = 255 / ($shades - 1);
                $avg = array_sum([$R, $G, $B]) / 3;
                $gray = intval(($avg / $factor) + 0.5) * $factor;
                break;

            case 'max':
                $gray = max([$R, $G, $B]);
                break;
            case 'min':
                $gray = min([$R, $G, $B]);
                break;
            case 'average':
                $gray = array_sum([$R, $G, $B]) / 3;
                break;

            case 'red':
                $gray = $R;
                break;
            case 'green':
                $gray = $G;
                break;
            case 'blue':
                $gray = $B;
                break;

            case 'lightness':
                $gray = (max([$R, $G, $B]) + min([$R, $G, $B])) / 2;
                break;
            case 'luma':
                $gray = array_sum([0.299 * $R, 0.587 * $G, 0.114 * $B]);
                break;
            case 'luminosity':
                $gray = array_sum([0.2126 * $R, 0.7152 * $G, 0.0722 * $B]);
                break;

            default:
                $gray = 0;
                break;
        }

        $gray = intval($gray);

        $result[] = imagecolorallocate($img, $gray, $gray, $gray);
    }

    imagedestroy($img);

    return $result;
}

$filename = __DIR__ . DIRECTORY_SEPARATOR . 'peppers_color.png';
$info = getInfo($filename);

$pixels = getPixels($filename);

//$algorithms = ['lightness', 'min', 'max', 'average', 'luma', 'luminosity', 'dummy', 'red', 'green', 'blue', 'shades'];
//
//foreach ($algorithms as $algorithm) {
//    var_dump($algorithm);
//    $result = grayScale($pixels, $info, $algorithm);
//    saveAs($algorithm . '.png', $result, $info);
//}
//
//exit;

$result = gaussianBlur($pixels, $info, 3);
saveAs('blurred.png', $result, $info);
