<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$ul = new HtmlElement("ul", array("class" => "actions"));
$actionItems = false;

if (isset($editButton) && is_array($editButton)) {
    $onclick = isset($editButton['onclick']) && !empty($editButton['onclick']) ? $editButton['onclick'] : 'editRecord(' . $recordId . ')';
    $cls = isset($editButton['class']) && !empty($editButton['class']) ? $editButton['class'] : '';
    $title = isset($editButton['title']) && !empty($editButton['title']) ? $editButton['title'] :  Labels::getLabel('LBL_EDIT', $siteLangId);

    $li = $ul->appendElement('li', ['title' => $title, 'data-bs-toggle' => 'tooltip', 'data-placement' => 'top']);
    $li->appendElement(
        'a',
        array('href' => 'javascript:void(0)', 'class' => $cls, "onclick" => $onclick),
        '<svg class="svg" width="18" height="18">
        <use
            xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg' . AttachedFile::setTimeParam(RELEASE_DATE) . '#edit">
        </use>
    </svg>',
        true
    );
    $actionItems = true;
}

if (isset($otherButtons) && is_array($otherButtons)) {
    foreach ($otherButtons as $attr) {
        $title = isset($attr['attr']['title']) ? $attr['attr']['title'] : '';
        $li = $ul->appendElement('li', ['title' => $title, 'data-bs-toggle' => 'tooltip', 'data-placement' => 'top']);
        if (isset($attr['attr']['title'])) {
            unset($attr['attr']['title']);
        }
        $li->appendElement('a', str_replace('&#039;', "'", $attr['attr']), (string) $attr['label'], true);
    }
    $actionItems = true;
}

if (isset($deleteButton) && is_array($deleteButton)) {
    $onclick = isset($deleteButton['onclick']) ? $deleteButton['onclick'] : "deleteRecord(" . $recordId . ")";

    $cls = isset($deleteButton['class']) ? $deleteButton['class'] : '';
    $title = isset($deleteButton['title']) && !empty($deleteButton['title']) ? $deleteButton['title'] : Labels::getLabel('LBL_DELETE_RECORD', $siteLangId);
    $li = $ul->appendElement('li', ['title' => $title, 'data-bs-toggle' => 'tooltip', 'data-placement' => 'top']);
    $li->appendElement(
        'a',
        array('href' => 'javascript:void(0)', 'class' => $cls, "onclick" => $onclick),
        '<svg class="svg" width="18" height="18">
        <use
            xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg' . AttachedFile::setTimeParam(RELEASE_DATE) . '#delete">
        </use>
    </svg>',
        true
    );
    $actionItems = true;
}

if (isset($dropdownButtons) && is_array($dropdownButtons)) {
    $li = $ul->appendElement('li', ['class' => 'dropdown dropdown-static', 'data-bs-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => Labels::getLabel('LBL_ACTION_BUTTONS', $siteLangId)]);
    $li->appendElement('a', array('href' => 'javascript:void(0)', 'data-bs-toggle' => 'dropdown', 'aria-haspopup' => 'true',  'aria-expanded' => 'false'), '<svg class="svg" width="18" height="18">
                                    <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg' . AttachedFile::setTimeParam(RELEASE_DATE) . '#more-dots">
                                    </use>
                                </svg>', true);
    $div = $li->appendElement('div', array('class' => 'dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim'));

    if (isset($dropdownButtons['editButton'])) {
        $ddEditButton = $dropdownButtons['editButton'];

        $cls = isset($ddEditButton['class']) ?  'dropdown-item ' . $ddEditButton['class'] : 'dropdown-item';
        $onclick = $ddEditButton['onclick'] ?? 'editRecord(' . $recordId . ')';
        $div->appendElement(
            'a',
            array('href' => 'javascript:void(0)', 'class' => $cls, 'data-bs-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => Labels::getLabel('LBL_EDIT', $siteLangId), "onclick" => $onclick),
            '<i class="icn"><svg class="svg" width="18" height="18">
                <use
                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg' . AttachedFile::setTimeParam(RELEASE_DATE) . '#edit">
                </use>
            </svg></i>' . Labels::getLabel('LBL_EDIT', $siteLangId),
            true
        );
    }

    if (isset($dropdownButtons['otherButtons'])) {
        $ddOtherButtons = $dropdownButtons['otherButtons'];
        foreach ($ddOtherButtons as $btn) {
            $attr = $btn['attr'] ?? [];
            $attr['class'] = isset($attr['class']) ? $attr['class'] . ' dropdown-item' : 'dropdown-item';
            $attr = array_merge($attr, ['data-bs-toggle' => 'tooltip', 'data-placement' => 'top']);
            $label = isset($btn['label']) ? $btn['label'] : '';
            $div->appendElement('a', $attr, $label, true);
        }
    }

    if (isset($dropdownButtons['deleteButton'])) {
        $ddDeleteButton = $dropdownButtons['deleteButton'];
        $cls = isset($ddDeleteButton['class']) ?  'dropdown-item ' . $ddDeleteButton['class'] : 'dropdown-item';
        $onclick = $ddDeleteButton['onclick'] ?? 'deleteRecord(' . $recordId . ')';

        $div->appendElement('div', array('class' => 'dropdown-divider'));
        $div->appendElement(
            'a',
            array('href' => 'javascript:void(0)', 'class' => $cls, 'data-bs-toggle' => 'tooltip', 'data-placement' => 'top', 'title' => Labels::getLabel('LBL_DELETE', $siteLangId), "onclick" => $onclick),
            '<i class="icn"><svg class="svg" width="18" height="18">
                <use
                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg' . AttachedFile::setTimeParam(RELEASE_DATE) . '#delete">
                </use>
            </svg></i>' . Labels::getLabel('LBL_DELETE', $siteLangId),
            true
        );
    }

    $actionItems = true;
}

if (false == $actionItems) {
    $ul->appendElement('li', [], Labels::getLabel('LBL_N/A'));
}

echo $ul->getHtml();
