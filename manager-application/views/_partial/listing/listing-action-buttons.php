<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$ul = new HtmlElement("ul", array("class" => "actions"));
$actionItems = false;

if (isset($editButton) && is_array($editButton)) {
    $onClick = isset($editButton['onClick']) ? $editButton['onClick'] : 'editRecord(' . $recordId . ')';

    $cls = isset($editButton['class']) ? $editButton['class'] : '';
    $li = $ul->appendElement('li');
    $li->appendElement('a', array('href' => 'javascript:void(0)', 'class' => $cls, 'title' => Labels::getLabel('LBL_EDIT', $adminLangId), "onclick" => $onClick), '<svg class="svg" width="18" height="18">
    <use
        xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#edit">
    </use>
</svg>', true);
    $actionItems = true;
}

if (isset($deleteButton) && is_array($deleteButton)) {
    $onClick = isset($deleteButton['onClick']) ? $deleteButton['onClick'] : "deleteRecord(" . $recordId . ")";

    $cls = isset($editButton['class']) ? $editButton['class'] : '';
    $li = $ul->appendElement('li');
    $li->appendElement('a', array('href' => 'javascript:void(0)', 'class' => $cls, 'title' => Labels::getLabel('LBL_DELETE', $adminLangId), "onclick" => $onClick), '<svg class="svg" width="18" height="18">
    <use
        xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#delete">
    </use>
</svg>', true);
    $actionItems = true;
}

if (true == $actionItems) {
    echo $ul->getHtml();
}
