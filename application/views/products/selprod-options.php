<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$ul1 = $ul2 = '';
if (!empty($optionRows)) {
    $count = 0;
    $displayCount = 3;
    foreach ($optionRows as $key => $option) {
        $ul1 = $ul2 = '';
        if (array_key_exists('values', $option) && is_array($option['values'])) {
            foreach ($option['values'] as $opVal) {
                $isColor = ($option['option_is_color'] && $opVal['optionvalue_color_code'] != '');

                $optionValueName = $opVal['optionvalue_name'];
                if (0 == $count) {
                    $ulStart = '<ul class="list-options">';
                    if ($isColor) {
                        $ul1 .= $ulStart;
                    }
                    $ul2 .= $ulStart;
                }

                if ($isColor) {
                    $ul1 .= '<li><span class="colors-dot" style="background:#' . $opVal['optionvalue_color_code'] . ';"></span></li>';
                }
                $ul2 .= '<li><span class="sizes-dot">' . $optionValueName . '</span></li>';

                if ($displayCount == ($count + 1)) {
                    $ulEnd = '<li class="more">+' . (count($option['values']) - $displayCount) . ' more</li></ul>';
                    if ($isColor) {
                        $ul1 .= $ulEnd;
                    }
                    $ul2 .= $ulEnd;
                    break;
                }
                $count++;
            } 
        } 
    } 
}
echo (empty($ul1 . $ul2) ? Labels::getLabel('LBL_N/A', $siteLangId) : $ul1 . $ul2);