<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Products_Performance', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' => [],
    'fields' => $fields,
    'defaultColumns' => $defaultColumns,
    'keywordPlaceholder' => $keywordPlaceholder,
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);
