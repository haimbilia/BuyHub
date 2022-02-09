<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$sortBy = $frmSrch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSrch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Products_Inventory_Report', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSrch,
    'actionButtons' =>  [],
    'fields' => $fields,
    'defaultColumns' => $defaultColumns,
    'keywordPlaceholder' => $keywordPlaceholder,
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);