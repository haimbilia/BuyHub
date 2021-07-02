<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('onsubmit', 'searchReport(this); return(false);');
$frmSearch->setFormTagAttribute('class', 'web_form');
$frmSearch->developerTags['colClassPrefix'] = 'col-md-';
$frmSearch->developerTags['fld_default_col'] = 4;

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$actionButtons = [];
if (!empty($orderDate)) {
    $url = UrlHelper::generateFullUrl('SalesReport');
    $actionButtons['otherButtons'][] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => "redirectBack('" . $url . "')",
            'title' => Labels::getLabel('LBL_Back', $adminLangId)
        ],
        'label' => '<i class="fas fa-arrow-left"></i>'
    ];
}

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Sales_Report', $adminLangId),
    'adminLangId' => $adminLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' =>  $actionButtons,
    'fields' => $fields,
    'defaultColumns' => $defaultColumns,
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);
