<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('onsubmit', 'setupBankInfo(this); return(false);');
$frm->setFormTagAttribute('data-onclear', 'addBankInfoForm(' . $recordId . ');');

$formTitle = Labels::getLabel('LBL_BANK_ACCOUNT_INFO', $siteLangId);

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
            'isActive' => true
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
    'isActive' => false
];
$activeGentab = false;
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>