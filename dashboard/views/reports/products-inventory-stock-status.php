<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Products_Inventory_Stock_Status_Report', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' => [],
    'fields' => $fields,
    'defaultColumns' => $defaultColumns,
    'keywordPlaceholder' => $keywordPlaceholder,
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);
