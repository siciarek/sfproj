<?php

$filename = __DIR__ . DIRECTORY_SEPARATOR . 'source.png';

function getInfo($filename) {
    $info = getimagesize($filename);

    $w = $info[0];
    $h = $info[1];

    return [
        'width' => $w,
        'height' => $h,
    ];
}

function getPixels($filename) {

    $info = getInfo($filename);
    $w = $info['width'];
    $h = $info['height'];

    $pixels = [];

    $img = imagecreatefrompng($filename);
    for ($x = 0; $x < $w; $x++) {
        for ($y = 0; $y < $h; $y++) {

            $pixels[$y * $w + $x] = imagecolorat($img, $x, $y);
        }
    }

    imagedestroy($img);

    return $pixels;
}

function saveAs($filename, $pixels, $info) {
    $w = $info['width'];
    $h = $info['height'];

    $img = @imagecreatetruecolor($w, $h) or die("Cannot Initialize new GD image stream");

    for ($i = 0; $i < count($pixels);) {
        $rgb = $pixels[$i];
        $y = ceil($i / $w) - 1;
        $x = $i % $w;

        imagesetpixel($img, $x, $y, $rgb);
        $i++;
    }

    imagepng($img, $filename);
    imagedestroy($img);
}

/**
 * http://www.tannerhelland.com/3643/grayscale-image-algorithm-vb6/
 * 
 * @param type $pixels
 * @param type $info
 * @param type $algorithm
 * @param type $shades
 * @return type
 */
function grayScale($pixels, $info, $algorithm = 'luminosity', $shades = 32) {

    $result = [];

    $img = imagecreatetruecolor(10, 10) or die("Cannot Initialize new GD image stream");

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

$info = getInfo($filename);
$pixels = getPixels($filename);
foreach ([
    'lightness', 'min', 'max', 'average', 'luma', 'luminosity', 'dummy', 'red', 'green', 'blue', 'shades'] as $algorithm) {
    var_dump($algorithm);
    $result = grayScale($pixels, $info, $algorithm);
    saveAs($algorithm . '.png', $result, $info);
}

