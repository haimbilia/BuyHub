<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('data-onclear', 'editRecord('.$recordId.','.$faqCatId.')');
$generalTab = [
    'attr' => [
        'title' => Labels::getLabel('LBL_GENERAL', $siteLangId),
        'href' => 'javascript:void(0);',
        'onclick' => 'editRecord('.$recordId .','. $faqCatId.');'
    ],
    'label' => Labels::getLabel('LBL_GENERAL', $siteLangId),
    'isActive' => true
];

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>