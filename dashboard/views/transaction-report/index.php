<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setCustomRendererClass('FormRendererBS');

$frmSearch->developerTags['colWidthClassesDefault'] = ['col-lg-', 'col-md-', null, null];
$frmSearch->developerTags['colWidthValuesDefault'] = [4, 4, null, null];
$frmSearch->developerTags['fldWidthClassesDefault'] = ['field_', 'field_', 'field_', 'field_'];
$frmSearch->developerTags['fldWidthValuesDefault'] = ['cover', 'cover', 'cover', 'cover'];
$frmSearch->developerTags['labelWidthClassesDefault'] = ['field_', 'field_', 'field_', 'field_'];
$frmSearch->developerTags['labelWidthValuesDefault'] = ['label', 'label', 'label', 'label'];
$frmSearch->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group';

$frmSearch->setFormTagAttribute('onsubmit', 'searchReport(this); return(false);');
$frmSearch->setFormTagAttribute('class', 'form');
$frmSearch->developerTags['noCaptionTag'] = true;

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$fld = $frmSearch->getField('keyword');
$fld->setFieldTagAttribute('placeholder', $fld->getCaption());
$fld->developerTags['noCaptionTag'] = true;

$fld = $frmSearch->getField('date_from');
$fld->setFieldTagAttribute('placeholder', $fld->getCaption());
$fld->developerTags['noCaptionTag'] = true;

$fld = $frmSearch->getField('date_to');
$fld->setFieldTagAttribute('placeholder', $fld->getCaption());
$fld->developerTags['noCaptionTag'] = true;

$submitFld = $frmSearch->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', 'btn btn-brand btn-block ');
$submitFld->developerTags['colWidthClasses'] = ['col-lg-', 'col-md-', null, null];
$submitFld->developerTags['colWidthValues'] = [2, 2, null, null];
$submitFld->developerTags['noCaptionTag'] = true;

$fldClear = $frmSearch->getField('btn_clear');
$fldClear->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
$fldClear->developerTags['colWidthClasses'] = ['col-lg-', 'col-md-', null, null];
$fldClear->developerTags['colWidthValues'] = [2, 2, null, null];
$fldClear->developerTags['noCaptionTag'] = true;

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Transaction_Report', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' => [],
    'fields' => $fields,
    'defaultColumns' => $defaultColumns,
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);
