<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');
$langFrm->setFormTagAttribute('id', 'frmBannerLangJs');
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData($("#frmBannerLangJs")); return(false);');
$formTitle  = Labels::getLabel('LBL_BANNER_SETUP', $siteLangId);
$generalTab = [
    'attr' => [
        'title' => Labels::getLabel('LBL_GENERAL', $siteLangId),
        'href' => 'javascript:void(0);',
        'onclick' => 'editRecord('.$recordId .','. $bannerLocationId.');'
    ],
    'label' => Labels::getLabel('LBL_GENERAL', $siteLangId),
    'isActive' => false
];

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm('.$recordId.','. $bannerLocationId.')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ]
];
require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php'); ?>