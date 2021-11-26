<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$formTitle = Labels::getLabel('LBL_TESTIMONIAL_SETUP', $siteLangId);
$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm('.$recordId.')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ]
]; 


require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php'); ?>