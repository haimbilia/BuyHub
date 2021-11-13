<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$columnButtons = true;
$performBulkAction = true;
$otherButtons = [[
    'attr' => [
        'href' => 'javascript:void(0)',
        'class' => 'btn btn-icon btn-link',
        'onclick' => 'exportRecords()',
        'title' => Labels::getLabel('LBL_Export', $siteLangId)
    ],
    'label' => '<svg class="svg" width="18" height="18">
    <use xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#export">
    </use>
</svg>' . Labels::getLabel('LBL_Export', $siteLangId)
]];
$searchFrmTemplate = FatUtility::camel2dashed(LibHelper::getControllerName()) . '/search-form.php';
require_once(CONF_THEME_PATH . '_partial/listing/index.php');
