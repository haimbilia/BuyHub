<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$actionItemsData['performBulkAction'] = true;
$actionItemsData['statusButtons'] = false;
$btnLabel = Labels::getLabel('LBL_NEW', $siteLangId);
$actionItemsData['newRecordBtnAttrs'] = [
    'attr' => [
        'href' => 'javascript:void(0);',
        'onclick' => 'addNewFaq('.$faqCatId.')',
        'title' => $btnLabel,
    ],
    'label' => $btnLabel
];
require_once(CONF_THEME_PATH . '_partial/listing/index.php');   
