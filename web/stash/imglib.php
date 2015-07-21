<?php

function getInfo($filename) {
    $info = getimagesize($filename);

    $w = $info[0];
    $h = $info[1];

    return [
        'width' => $w,
        'height' => $h,
        'mime' => $info['mime'],
    ];    
}

function getPixels($filename) {

    $info = getInfo($filename);
    $w = $info['width'];
    $h = $info['height'];
    list($image, $type) = explode('/', $info['mime']);
    
    $function = sprintf('imagecreatefrom%s', $type);

    $pixels = [];

    $img = $function($filename);
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

    for ($i = 0; $i < count($pixels);
    ) {
        $rgb = $pixels[$i];
        $y = ceil($i / $w) - 1;
        $x = $i % $w;

        imagesetpixel($img, $x, $y, $rgb);
        $i++;
    }

    imagepng($img, $filename);
    imagedestroy($img);
}
