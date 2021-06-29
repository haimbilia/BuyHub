<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('onSubmit', 'searchSalesReport(this); return false;');
$frmSearch->setFormTagAttribute('class', 'form');
$frmSearch->setCustomRendererClass('FormRendererBS');
$frmSearch->developerTags['colWidthClassesDefault'] = ['col-lg-', 'col-md-', null, null];
if (empty($orderDate)) {
    $frmSearch->developerTags['colWidthValuesDefault'] = [4, 4, null, null];
} else {
    $frmSearch->developerTags['colWidthValuesDefault'] = [4, 4, null, null];
}

$dateFrm = $frmSearch->getField('date_from');
$dateTo = $frmSearch->getField('date_to');

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$submitFld = $frmSearch->getField('btn_submit');
$submitFld->setFieldTagAttribute('class', 'btn btn-brand btn-block ');
$submitFld->developerTags['colWidthClasses'] = ['col-lg-', 'col-md-', null, null];
$submitFld->developerTags['colWidthValues'] = [2, 2, null, null];

$fldClear = $frmSearch->getField('btn_clear');
$fldClear->setFieldTagAttribute('class', 'btn btn-outline-brand btn-block');
$fldClear->developerTags['colWidthClasses'] = ['col-lg-', 'col-md-', null, null];
$fldClear->developerTags['colWidthValues'] = [2, 2, null, null];
if (!empty($orderDate)) {
    $keyword = $frmSearch->getField('keyword');
    $keyword->setFieldTagAttribute('placeholder', Labels::getLabel("LBL_Keyword", $siteLangId));

    $sortOrder->developerTags['noCaptionTag'] = true;
    $keyword->developerTags['noCaptionTag'] = true;
    $sortBy->developerTags['noCaptionTag'] = true;
    $submitFld->developerTags['noCaptionTag'] = true;
    $fldClear->developerTags['noCaptionTag'] = true;
}

$actionButtons = [];
if (!empty($orderDate)) {
    $url = UrlHelper::generateFullUrl('Reports', 'SalesReport');
    $actionButtons['otherButtons'][] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => "redirectUrl('" . $url . "')",
            'title' => Labels::getLabel('LBL_Back', $siteLangId)
        ],
        'label' => Labels::getLabel('LBL_Back', $siteLangId)
    ];
}

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Sales_Report', $siteLangId),
    'siteLangId' => $siteLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' =>  $actionButtons,
    'fields' => $fields,
    'defaultColumns' => $defaultColumns,
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);
