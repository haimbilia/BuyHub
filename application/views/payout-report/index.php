<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('onsubmit', 'searchReport(this); return(false);');
$frmSearch->setFormTagAttribute('class', 'form');
$frmSearch->developerTags['colClassPrefix'] = 'col-lg-4 col-md-';
$frmSearch->developerTags['fld_default_col'] = 4;

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$submitFld = $frmSearch->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', 'btn btn-brand btn-block ');
//$submitFld->developerTags['col'] = 2;

$fldClear = $frmSearch->getField('btn_clear');
$fldClear->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
//$fldClear->developerTags['col'] = 2;

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Product_Profit_Report', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' => []
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);
