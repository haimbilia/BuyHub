<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSrch->setFormTagAttribute('onSubmit', 'searchReport(this); return false;');
$frmSrch->setFormTagAttribute('class', 'form');
$frmSrch->developerTags['colClassPrefix'] = 'col-md-';
$frmSrch->developerTags['fld_default_col'] = 6;

$keyFld = $frmSrch->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));

$submitBtnFld = $frmSrch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class', 'btn btn-brand btn-block');
$submitBtnFld->setWrapperAttribute('class', 'col-3');
$submitBtnFld->developerTags['col'] = 3;

$cancelBtnFld = $frmSrch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
$cancelBtnFld->setWrapperAttribute('class', 'col-3');
$cancelBtnFld->developerTags['col'] = 3;
$sortBy = $frmSrch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSrch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$sortOrder->developerTags['noCaptionTag'] = true;
$keyFld->developerTags['noCaptionTag'] = true;
$sortBy->developerTags['noCaptionTag'] = true;

$submitFld = $frmSrch->getField('btn_submit');
$fldClear = $frmSrch->getField('btn_clear');
$submitFld->developerTags['noCaptionTag'] = true;
$fldClear->developerTags['noCaptionTag'] = true;

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Products_Inventory_Report', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSrch,
    'actionButtons' =>  [],
    'fields' => $fields,
    'defaultColumns' => $defaultColumns,
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);