<?php 
defined('SYSTEM_INIT') or die('Invalid Usage');

$ul = new HtmlElement("ul", array("class" => "linksvertical"));
foreach ($links as $attr) {
    $li = $ul->appendElement('li');
    $class = isset($attr['attr']['class']) ? $attr['attr']['class'] : '';
    $attr['attr']['class'] = $class;
    $li->appendElement('a', $attr['attr'], (string) $attr['label'], true);
}

echo $ul->getHtml();
