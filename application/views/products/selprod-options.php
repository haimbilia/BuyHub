<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$ul = "";
if (!empty($optionRows)) {
    $displayCount = 3;
    foreach ($optionRows as $key => $option) {
        if (array_key_exists('values', $option) && is_array($option['values'])) {
            $count = 0;
            $ul .= '<ul class="list-options">';
            $ul .= '<li class="label">' . $option['option_name'] . ' : </li>';
            foreach ($option['values'] as $opVal) {
                $isColor = ($option['option_is_color'] && $opVal['optionvalue_color_code'] != '');

                $optionValueName = $opVal['optionvalue_name'];
                if ($isColor) {
                    $color = ("#" == $opVal['optionvalue_color_code'][0] ? $opVal['optionvalue_color_code'] : "#" . $opVal['optionvalue_color_code']);
                    $ul .= '<li data-toggle="tooltip" data-placement="top" title="' . $optionValueName . '"><span class="colors-dot" style="background:' . $color . ';"></span></li>';
                } else {
                    $ul .= '<li><span class="ellipsis">' . $optionValueName . '</span></li>';
                }

                if ($displayCount == ($count + 1) && (0 < count($option['values']) - $displayCount)) {
                    $ul .= '<li class="more">+' . (count($option['values']) - $displayCount) . Labels::getLabel('LBL_MORE', $siteLangId).' </li>';
                    break;
                }
                $count++;
            } 
            $ul .= '</ul>';
        }
    } 
}
echo (empty($ul) ? Labels::getLabel('LBL_N/A', $siteLangId) : $ul);