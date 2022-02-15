<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$dateFrm = $frmSearch->getField('date_from');
$dateFrm->setFieldTagAttribute('class', 'field--calender');

$dateTo = $frmSearch->getField('date_to');
if (null != $dateTo) {
    $dateTo->setFieldTagAttribute('class', 'field--calender');
}

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$actionButtons = [];
if (!empty($orderDate)) {
    $url = UrlHelper::generateFullUrl('Reports', 'SalesReport');
    $actionButtons['otherButtons'][] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => "redirectUrl('" . $url . "')",
            'title' => Labels::getLabel('LBL_Back', $siteLangId)
        ],
        'label' => '<i class="fas fa-arrow-left"></i>'
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
