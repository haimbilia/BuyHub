<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$fld = $frmSearch->getField('date_from');
$fld->setFieldTagAttribute('placeholder', $fld->getCaption());

$fld = $frmSearch->getField('date_to');
$fld->setFieldTagAttribute('placeholder', $fld->getCaption());

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Transaction_Report', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' => [],
    'fields' => $fields,
    'defaultColumns' => $defaultColumns,
    'keywordPlaceholder' => $keywordPlaceholder,
];

$this->includeTemplate('_partial/report-index.php', $reportsData, false);
