<?php
function getAspectRatio(int $width, int $height)
{
    // search for greatest common divisor
    $greatestCommonDivisor = static function($width, $height) use (&$greatestCommonDivisor) {
        return ($width % $height) ? $greatestCommonDivisor($height, $width % $height) : $height;
    };

    $divisor = $greatestCommonDivisor($width, $height);

    return $width / $divisor . ':' . $height / $divisor;
}

echo getAspectRatio(2000, 666);
echo PHP_EOL;
echo getAspectRatio(1275, 715);
?>