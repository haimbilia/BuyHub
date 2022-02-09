<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frmSearch->getField('date_from');
if (null != $fld) {
    $fld->setFieldTagAttribute('placeholder', $fld->getCaption());
}

$fld = $frmSearch->getField('date_to');
if (null != $fld) {
    $fld->setFieldTagAttribute('placeholder', $fld->getCaption());
}

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Payout_Report', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' => [],
    'fields' => $fields,
    'defaultColumns' => $defaultColumns,
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);
