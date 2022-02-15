<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Catalog_Report', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' => [],
    'fields' => $fields,
    'defaultColumns' => $defaultColumns,
    'keywordPlaceholder' => $keywordPlaceholder,
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);
