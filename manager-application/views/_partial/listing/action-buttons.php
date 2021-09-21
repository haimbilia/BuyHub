<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$canEdit = isset($canEdit) ? $canEdit : false;

$ul = new HtmlElement("ul", array("class" => "actions"));
if (isset($htmlContent) && $htmlContent != '') {
    $ul->appendElement('li', [], $htmlContent, true);
}

if (isset($newRecordBtn) && true === $newRecordBtn && $canEdit) {
    $li = $ul->appendElement('li');
    $li->appendElement(
        'a',
        [
            'href' => 'javascript:void(0)',
            'class' => 'btn btn-icon btn-light btn-add',
            'title' => Labels::getLabel('LBL_NEW', $adminLangId),
            'onclick' => "addNew()"
        ],
        '<i class="icn">
            <svg class="svg">
                <use
                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#add">
                </use>
            </svg>
        </i><span> ' . Labels::getLabel('LBL_NEW', $adminLangId) . '</span>',
        true
    );
}

$msg = isset($msg) ? $msg : '';
if (isset($statusButtons) && true === $statusButtons && $canEdit) {
    $li = $ul->appendElement('li');

    $li->appendElement(
        'a',
        [
            'href' => 'javascript:void(0)',
            'class' => 'toolbar-btn-js disabled',
            'title' => Labels::getLabel('LBL_PUBLISH', $adminLangId),
            'onclick' => "toggleBulkStatues(1, '" . $msg . "')"
        ],
        '<svg class="svg" width="18" height="18">
            <use
                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#toggle-on">
            </use>
        </svg>',
        true
    );

    $li = $ul->appendElement('li');
    $li->appendElement(
        'a',
        [
            'href' => 'javascript:void(0)',
            'class' => 'toolbar-btn-js disabled',
            'title' => Labels::getLabel('LBL_UNPUBLISH', $adminLangId),
            'onclick' => "toggleBulkStatues(0, '" . $msg . "')"
        ],
        '<svg class="svg" width="18" height="18">
            <use
                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#toggle-off">
            </use>
        </svg>',
        true
    );
}

if (isset($deleteButton) && true === $deleteButton && $canEdit) {
    $li = $ul->appendElement('li');
    $li->appendElement(
        'a',
        [
            'href' => 'javascript:void(0)',
            'class' => 'toolbar-btn-js disabled',
            'title' => Labels::getLabel('LBL_DELETE', $adminLangId),
            'onclick' => "deleteSelected()"
        ],
        '<svg class="svg" width="18" height="18">
            <use
                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#trash">
            </use>
        </svg>',
        true
    );
}

if (isset($otherButtons) && is_array($otherButtons) && $canEdit) {
    foreach ($otherButtons as $attr) {
        $li = $ul->appendElement('li');
        $li->appendElement('a', $attr['attr'], (string) $attr['label'], true);
    }
}

echo $ul->getHtml();
