<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($langFrm);
$otherButtons = [
    [
       'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'catMediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $siteLangId),
        'isActive' => false
    ]
]; 

$formTitle = Labels::getLabel('LBL_CATEGORY_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php');