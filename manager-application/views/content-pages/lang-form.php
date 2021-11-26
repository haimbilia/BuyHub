<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$langFrm->setFormTagAttribute('id', 'frmLangJs1');
$langFrm->setFormTagAttribute('onsubmit', 'saveContentPageLangData($("#frmLangJs1")); return(false);');
$displayLangTab = false;
$otherButtons = [
    [
       'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'editLangData('.$recordId.','.array_key_first($languages).');',
            'title' => Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_LANGUAGE_DATA', $siteLangId),
        'isActive' => true
    ],
    [
       'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ]
]; 
require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php'); ?>