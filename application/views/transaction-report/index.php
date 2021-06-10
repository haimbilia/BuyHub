<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setCustomRendererClass('FormRendererBS');
$frmSearch->developerTags['colWidthClassesDefault'] = ['col-lg', 'col-md-', null, null];
$frmSearch->developerTags['colWidthValuesDefault'] = [4, 4, null, null];
$frmSearch->setFormTagAttribute('onsubmit', 'searchReport(this); return(false);');
$frmSearch->setFormTagAttribute('class', 'form');

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$submitFld = $frmSearch->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', 'btn btn-brand btn-block ');
$submitFld->developerTags['colWidthClasses'] = ['col-lg', 'col-md-', null, null];
$submitFld->developerTags['colWidthValues'] = [2, 2, null, null];

$fldClear = $frmSearch->getField('btn_clear');
$fldClear->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
$fldClear->developerTags['colWidthClasses'] = ['col-lg', 'col-md-', null, null];
$fldClear->developerTags['colWidthValues'] = [2, 2, null, null];

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Transaction_Report', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' => []
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);
