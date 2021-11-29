<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$ul = new HtmlElement("ul", array("class" => "actions"));
$actionItems = false;

if (isset($dropdownButtons) && is_array($dropdownButtons)) {
    $li = $ul->appendElement('li', ['class' => 'dropdown']);
    $li->appendElement('a', array('href' => 'javascript:void(0)', 'title' => Labels::getLabel('LBL_ACTION', $siteLangId), 'data-toggle' => 'dropdown', 'aria-haspopup' => 'true',  'aria-expanded' => 'false'), '<svg class="svg" width="18" height="18">
                                    <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#more-dots">
                                    </use>
                                </svg>', true);
    $div = $li->appendElement('div', array('class' => 'dropdown-menu dropdown-menu-right dropdown-menu-anim'));

    if (isset($dropdownButtons['editButton'])) {
        $ddEditButton = $dropdownButtons['editButton'];

        $cls = isset($ddEditButton['class']) ?  'dropdown-item ' . $ddEditButton['class'] : 'dropdown-item';
        $onClick = $ddEditButton['onClick'] ?? 'editRecord(' . $recordId . ')';
        $div->appendElement('a', array('href' => 'javascript:void(0)', 'class' => $cls, 'title' => Labels::getLabel('LBL_EDIT', $siteLangId), "onclick" => $onClick), 
        '<i class="icn">
            <svg class="svg" width="18" height="18">
                <use
                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#edit">
                </use>
            </svg>
        </i>' . Labels::getLabel('LBL_EDIT', $siteLangId), true);
    }
    
    if (isset($dropdownButtons['otherButtons'])) {
        $ddOtherButtons = $dropdownButtons['otherButtons'];
        foreach ($ddOtherButtons as $btn) {
            $attr = $btn['attr'] ?? [];
            $attr['class'] = isset($attr['class']) ? $attr['class'] . ' dropdown-item' : 'dropdown-item';

            $label = isset($btn['label']) ? $btn['label'] : ''; 
            $div->appendElement('a', $attr, $label, true);
        }
    }
    
    if (isset($dropdownButtons['deleteButton'])) {
        $ddDeleteButton = $dropdownButtons['deleteButton'];
        $cls = isset($ddDeleteButton['class']) ?  'dropdown-item ' . $ddDeleteButton['class'] : 'dropdown-item';
        $onClick = $ddDeleteButton['onClick'] ?? 'deleteRecord(' . $recordId . ')';

        $div->appendElement('div', array('class' => 'dropdown-divider')); 
        $div->appendElement('a', array('href' => 'javascript:void(0)', 'class' => $cls, 'title' => Labels::getLabel('LBL_DELETE', $siteLangId), "onclick" => $onClick), 
        '<i class="icn">
            <svg class="svg" width="18" height="18">
                <use
                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#delete">
                </use>
            </svg>
        </i>' . Labels::getLabel('LBL_DELETE', $siteLangId), true);
    }
    
    $actionItems = true;
}


if (isset($editButton) && is_array($editButton)) {
    $onClick = isset($editButton['onClick']) ? $editButton['onClick'] : 'editRecord(' . $recordId . ')';

    $cls = isset($editButton['class']) ? $editButton['class'] : '';
    $li = $ul->appendElement('li', ['title' => Labels::getLabel('LBL_EDIT', $siteLangId)]);
    $li->appendElement('a', array('href' => 'javascript:void(0)', 'class' => $cls, 'title' => Labels::getLabel('LBL_EDIT', $siteLangId), "onclick" => $onClick), 
    '<svg class="svg" width="18" height="18">
        <use
            xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#edit">
        </use>
    </svg>', true);
    $actionItems = true;
}

if (isset($otherButtons) && is_array($otherButtons)) {
    foreach ($otherButtons as $attr) {
        $title = isset($attr['attr']['title']) ? $attr['attr']['title'] : '';
        $li = $ul->appendElement('li', ['title' => $title ]);
        $li->appendElement('a', $attr['attr'], (string) $attr['label'], true);
    }
    $actionItems = true;
}

if (isset($deleteButton) && is_array($deleteButton)) {
    $onClick = isset($deleteButton['onClick']) ? $deleteButton['onClick'] : "deleteRecord(" . $recordId . ")";

    $cls = isset($deleteButton['class']) ? $deleteButton['class'] : '';
    $title = isset($deleteButton['title']) && !empty($deleteButton['title']) ? $deleteButton['title'] : Labels::getLabel('LBL_DELETE', $siteLangId);
    $li = $ul->appendElement('li', ['title' => $title]);
    $li->appendElement('a', array('href' => 'javascript:void(0)', 'class' => $cls, 'title' => $title, "onclick" => $onClick), 
    '<svg class="svg" width="18" height="18">
        <use
            xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#delete">
        </use>
    </svg>', true);
    $actionItems = true;
}

if (true == $actionItems) {
    echo $ul->getHtml();
}
