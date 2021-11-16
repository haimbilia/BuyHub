<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$langFrm->setFormTagAttribute('onsubmit', 'saveContentPageLangData($("#frmLangJs")); return(false);');
$langFrm->setFormTagAttribute('id', 'frmLangJs1');
$otherButtons = [
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

$activeLangtab = true;
require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php'); ?>