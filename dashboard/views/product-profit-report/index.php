<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('onsubmit', 'searchReport(this); return(false);');
$frmSearch->setFormTagAttribute('class', 'form');
$frmSearch->setCustomRendererClass('FormRendererBS');
$frmSearch->developerTags['colWidthClassesDefault'] = ['col-lg-', 'col-md-', null, null];
$frmSearch->developerTags['colWidthValuesDefault'] = [4, 4, null, null];
$frmSearch->developerTags['fldWidthClassesDefault'] = ['field_', 'field_', 'field_', 'field_'];
$frmSearch->developerTags['fldWidthValuesDefault'] = ['cover', 'cover', 'cover', 'cover'];
$frmSearch->developerTags['labelWidthClassesDefault'] = ['field_', 'field_', 'field_', 'field_'];
$frmSearch->developerTags['labelWidthValuesDefault'] = ['label', 'label', 'label', 'label'];
$frmSearch->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group';

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$submitFld = $frmSearch->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', 'btn btn-brand btn-block ');
$submitFld->developerTags['colWidthValues'] = [2, 2, null, null];

$fldClear = $frmSearch->getField('btn_clear');
$fldClear->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
$fldClear->developerTags['colWidthValues'] = [2, 2, null, null];

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Product_Profit_Report', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' => [],
    'fields' => $fields,
    'defaultColumns' => $defaultColumns,
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);
