<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$langFrm->setFormTagAttribute('data-onclear', 'editLangData(' . $recordId . ', ' . $lang_id . ', 0, "modal-dialog-vertical-md")');
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
$fld = $langFrm->getField('lang_id');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $langFrm->getField('shop_name');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $langFrm->getField('shop_city');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld = $langFrm->getField('shop_contact_person');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$generalTab['attr']['onclick'] = 'editRecord(' . $recordId . ', false, "modal-dialog-vertical-md")';
$langTabExtraClass = "modal-dialog-vertical-md";
$formTitle = Labels::getLabel('LBL_SHOP_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php');
