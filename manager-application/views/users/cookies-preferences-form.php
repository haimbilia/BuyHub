<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('ucp_functional');
$fld->setFieldTagAttribute('disabled', 'disabled');

$fld = $frm->getField('ucp_statistical');
$fld->setFieldTagAttribute('disabled', 'disabled');

$fld = $frm->getField('ucp_personalized');
$fld->setFieldTagAttribute('disabled', 'disabled');

$frm->setFormTagAttribute('data-onclear', 'displayCookiesPerferences(' . $recordId . ');');

$formTitle = Labels::getLabel('LBL_COOKIES_PREFERENCES', $siteLangId);

$otherButtons = [];

if ($userParent == 0) {
    $otherButtons = [
        [
            'attr' => [
                'href' => 'javascript:void(0)',
                'onclick' => 'addBankInfoForm(' . $recordId . ')',
                'title' => Labels::getLabel('LBL_BANK_INFO', $siteLangId),
            ],
            'label' => Labels::getLabel('LBL_BANK_INFO', $siteLangId),
            'isActive' => false
        ]
    ];
}

$otherButtons[] = [
    'attr' => [
        'href' => 'javascript:void(0)',
        'onclick' => 'displayCookiesPerferences(' . $recordId . ')',
        'title' => Labels::getLabel('LBL_COOKIES_PREFERENCES', $siteLangId),
    ],
    'label' => Labels::getLabel('LBL_COOKIES_PREFERENCES', $siteLangId),
    'isActive' => true
];
$displayFooterButtons = false;
$activeGentab = false;
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>