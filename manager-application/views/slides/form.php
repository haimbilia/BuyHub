<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('slide_target');
$fld->developerTags['colWidthValues'] = [null, '6', null, null]; 
$fld = $frm->getField('slide_active');
$fld->developerTags['colWidthValues'] = [null, '6', null, null]; 

$formTitle = Labels::getLabel('LBL_SLIDE_SETUP', $siteLangId);


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
require_once(CONF_THEME_PATH . '_partial/listing/form.php');