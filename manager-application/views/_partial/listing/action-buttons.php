<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$canEdit = isset($canEdit) ? $canEdit : false;

$ul = new HtmlElement("ul", array());
if (isset($htmlContent) && $htmlContent != '') {
    $ul->appendElement('li', [], $htmlContent, true);
}

$msg = isset($msg) ? $msg : '';
if (isset($statusButtons) && true === $statusButtons && $canEdit) {
    $li = $ul->appendElement('li');

    $li->appendElement(
        'a',
        [
            'href' => 'javascript:void(0)',
            'class' => 'btn btn-outline-brand btn-icon toolbar-btn-js disabled',
            'title' => Labels::getLabel('BTN_ACTIVE', $siteLangId),
            'onclick' => "toggleBulkStatues(1, '" . $msg . "')"
        ],
        '<svg class="svg" width="18" height="18">
            <use
                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#active">
            </use>
        </svg><span>' . Labels::getLabel('BTN_ACTIVE', $siteLangId) . '</span>',
        true
    );

    $li = $ul->appendElement('li');
    $li->appendElement(
        'a',
        [
            'href' => 'javascript:void(0)',
            'class' => 'btn btn-outline-brand btn-icon toolbar-btn-js disabled',
            'title' => Labels::getLabel('BTN_IN-ACTIVE', $siteLangId),
            'onclick' => "toggleBulkStatues(0, '" . $msg . "')"
        ],
        '<svg class="svg" width="18" height="18">
            <use
                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#in-active">
            </use>
        </svg><span>' . Labels::getLabel('BTN_IN-ACTIVE', $siteLangId) . '</span>',
        true
    );
}

if (isset($deleteButton) && true === $deleteButton && $canEdit) {
    $li = $ul->appendElement('li');
    $li->appendElement(
        'a',
        [
            'href' => 'javascript:void(0)',
            'class' => 'btn btn-outline-brand btn-icon toolbar-btn-js disabled',
            'title' => Labels::getLabel('BTN_DELETE', $siteLangId),
            'onclick' => "deleteSelected()"
        ],
        '<svg class="svg" width="18" height="18">
            <use
                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#delete">
            </use>
        </svg><span>' . Labels::getLabel('BTN_DELETE', $siteLangId) . '</span>',
        true
    );
}

if (isset($otherButtons) && is_array($otherButtons) && $canEdit) {
    foreach ($otherButtons as $attr) {
        $li = $ul->appendElement('li');
        $li->appendElement('a', $attr['attr'], (string) $attr['label'], true);
    }
}

if (!empty($columnButtons)) {
    $li = $ul->appendElement('li', ['class' => 'custom-drag-drop']);
    $li->appendElement(
        'a',
        [
            'href' => 'javascript:void(0)',
            'class' => 'btn btn-icon btn-link',
            'title' => Labels::getLabel('LBL_COLUMNS', $siteLangId),
            'data-toggle' => 'dropdown',
            'aria-expanded' => false
        ],
        '<svg class="svg" width="18" height="18">
            <use
                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#columns">
            </use>
        </svg>' . Labels::getLabel('LBL_COLUMNS', $siteLangId),
        true
    );

    $li->appendElement('div', ['class' => 'dropdown-menu dropdown-menu-right dropdown-menu-fit dropdown-menu-anim scroll scroll-y'], $columnButtons, true);
}
echo $ul->getHtml();
