<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');
$langFrm->setFormTagAttribute('id', 'frmFaqLangJs');
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData($("#frmFaqLangJs")); return(false);');
$generalTab = [
    'attr' => [
        'title' => Labels::getLabel('LBL_GENERAL', $siteLangId),
        'href' => 'javascript:void(0);',
        'onclick' => 'editRecord('.$recordId .','. $faqCatId.');'
    ],
    'isActive' => false,
    'label' => Labels::getLabel('LBL_GENERAL', $siteLangId)
];
require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php'); ?>