<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frmSearch->getField('date_from');
$fld->setFieldTagAttribute('placeholder', $fld->getCaption());

$fld = $frmSearch->getField('date_to');
$fld->setFieldTagAttribute('placeholder', $fld->getCaption());

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Product_Profit_Report', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' => [],
    'fields' => $fields,
    'defaultColumns' => $defaultColumns,
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);
