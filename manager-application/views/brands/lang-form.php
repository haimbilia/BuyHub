<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$otherButtons = [
    [
       'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $adminLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $adminLangId),
        'isActive' => false
    ]
]; 

$formTitle = Labels::getLabel('LBL_BRAND_SETUP', $adminLangId);
require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php');