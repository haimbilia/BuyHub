<?php
defined('SYSTEM_INIT') or die('Invalid Usage');

$div = new HtmlElement("div", array("class" => "btn-group"));
if (isset($htmlContent) && $htmlContent != '') {
    $div->appendElement('div', [], $htmlContent, true);
}

$msg = isset($msg) ? $msg : '';

if (isset($otherButtons) && is_array($otherButtons)) {
    foreach ($otherButtons as $attr) {
        $class = isset($attr['attr']['class']) ? $attr['attr']['class'] : '';
        $attr['attr']['class'] = 'btn btn-outline-brand btn-sm ' . $class;
        $div->appendElement('a', $attr['attr'], (string) $attr['label'], true);
    }
}

echo $div->getHtml();
