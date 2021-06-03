<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$html = "";
switch ($type) {
    case Badge::SHAPE_RECTANGLE:
        $html = '<div class="badges badges-' . $type . '" style="background:' . $color . '">' . $text . '</div>';
        break;
    case Badge::SHAPE_STRIP:
    case Badge::SHAPE_STAR:
    case Badge::SHAPE_TRIANGLE:
    case Badge::SHAPE_CIRCLE:
        $html = '<div class="badges badges-' . $type . '">
            <svg class="svg" style="fill:' . $color . '">
                <use xlink:href="' . CONF_WEBROOT_FRONT_URL . 'images/retina/badges/sprite.svg#badges-' . $type . '"></use>
            </svg>
            <span class="text">' . $text . '</span>
        </div>';
        break;
}

if (isset($return) && true === $return) {
    return $html;
}

echo $html;