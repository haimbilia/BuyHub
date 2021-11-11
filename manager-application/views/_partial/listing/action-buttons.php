<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$canEdit = isset($canEdit) ? $canEdit : false;

$ul = new HtmlElement("ul", array("class" => "actions"));
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
            'class' => 'toolbar-btn-js disabled',
            'title' => Labels::getLabel('LBL_ACTIVE', $siteLangId),
            'onclick' => "toggleBulkStatues(1, '" . $msg . "')"
        ],
        '<svg class="svg" width="18" height="18">
            <use
                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#active">
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
            'title' => Labels::getLabel('LBL_IN-ACTIVE', $siteLangId),
            'onclick' => "toggleBulkStatues(0, '" . $msg . "')"
        ],
        '<svg class="svg" width="18" height="18">
            <use
                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#in-active">
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
            'title' => Labels::getLabel('LBL_DELETE', $siteLangId),
            'onclick' => "deleteSelected()"
        ],
        '<svg class="svg" width="18" height="18">
            <use
                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#delete">
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

if (isset($newRecordBtn) && true === $newRecordBtn && $canEdit) {
    $href = "javascript:void(0)";
    $onclick = "addNew()";
    $title = Labels::getLabel('BTN_NEW', $siteLangId);
    $label = $title;
    if (isset($newRecordBtnAttrs) && 0 < count($newRecordBtnAttrs)) {
        $href = $newRecordBtnAttrs['attr']['href'] ?? $href;
        $onclick = $newRecordBtnAttrs['attr']['onclick'] ?? $onclick;
        $title = $newRecordBtnAttrs['attr']['title'] ?? $title;
        $label = $newRecordBtnAttrs['label'] ?? $label;
    }

?>
    <a href="<?php echo $href; ?>" class="btn btn-icon btn-outline-brand btn-add" onclick="<?php echo $onclick; ?>" title="<?php echo $title; ?>">
        <svg class="svg" width="18" height="18">
            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>/images/retina/sprite-actions.svg#add">
            </use>
        </svg>
        <span><?php echo $label; ?></span>
    </a>
<?php
}

if (!empty($htmlContent) || !empty($statusButtons) || !empty($deleteButton) || !empty($otherButtons) || !empty($columnButtons)) {
    echo $ul->getHtml();
}
