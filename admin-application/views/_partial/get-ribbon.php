<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$html = "";
if (is_array($row) && !empty($row)) {
    $type = $row['badge_shape_type'];
    $color = $row['badge_color'];
    $text = $row['badge_name'];
    $displayInside = $row['badge_display_inside'];

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
}

if (isset($return) && true === $return) {
    return $html;
}

echo $html;