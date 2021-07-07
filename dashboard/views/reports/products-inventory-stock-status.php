<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('onSubmit', 'searchReport(this); return false;');
$frmSearch->setFormTagAttribute('class', 'form');
$frmSearch->developerTags['colClassPrefix'] = 'col-md-';
$frmSearch->developerTags['fld_default_col'] = 12;

$keyFld = $frmSearch->getField('keyword');
$keyFld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Keyword', $siteLangId));
$keyFld->setWrapperAttribute('class', 'col-lg-6');
$keyFld->developerTags['col'] = 6;
$keyFld->developerTags['noCaptionTag'] = true;

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$submitBtnFld = $frmSearch->getField('btn_submit');
$submitBtnFld->setFieldTagAttribute('class', 'btn btn-brand btn-block');
$submitBtnFld->setWrapperAttribute('class', 'col-lg-3');
$submitBtnFld->developerTags['col'] = 3;
$submitBtnFld->developerTags['noCaptionTag'] = true;

$cancelBtnFld = $frmSearch->getField('btn_clear');
$cancelBtnFld->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
$cancelBtnFld->setWrapperAttribute('class', 'col-lg-3');
$cancelBtnFld->developerTags['col'] = 3;
$cancelBtnFld->developerTags['noCaptionTag'] = true;

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Products_Inventory_Stock_Status_Report', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' => [],
    'fields' => $fields,
    'defaultColumns' => $defaultColumns,
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);
