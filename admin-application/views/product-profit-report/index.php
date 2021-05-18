<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frmSearch->setFormTagAttribute('onsubmit', 'searchReport(this); return(false);');
$frmSearch->setFormTagAttribute('class', 'web_form');
$frmSearch->developerTags['colClassPrefix'] = 'col-md-';
$frmSearch->developerTags['fld_default_col'] = 6;

$sortBy = $frmSearch->getField('sortBy');
$sortBy->setFieldTagAttribute('id', 'sortBy');

$sortOrder = $frmSearch->getField('sortOrder');
$sortOrder->setFieldTagAttribute('id', 'sortOrder');

$reportsData = [
    'pageTitle' => Labels::getLabel('LBL_Product_Profit_Report', $adminLangId),
    'adminLangId' => $adminLangId,
    'frmSearch' => $frmSearch,
    'actionButtons' => []
];
$this->includeTemplate('_partial/report-index.php', $reportsData, false);
