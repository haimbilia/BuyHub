<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$isUsersSelected = $isUsersSelected ?? false;

$formClassExtra = 'layout--' . $formLayout;
$frm->setFormTagAttribute('dir', $formLayout);

$fld = $frm->getField('pnotification_lang_id');
$fld->addFieldTagAttribute('onchange', 'editPushNotification(' . $recordId . ', this.value);');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('pnotification_user_auth_type');
if (true === $isUsersSelected) {
    $fld->addFieldTagAttribute('disabled', 'disabled');
    $fld->setWrapperAttribute('data-bs-toggle', 'tooltip');
    $fld->setWrapperAttribute('data-placement', 'top');
    $fld->setWrapperAttribute('title', Labels::getLabel('LBL_PLEASE_UNBIND_NOTIFY_USERS_TO_CHANGE_AUTH_TYPE', $siteLangId));
}
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('pnotification_title');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('pnotification_url');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('pnotification_notified_on');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('pnotification_device_os');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$generalTab = [
    'attr' => [
        'href' => 'javascript:void(0);',
        'onclick' => "",
        'title' => Labels::getLabel('LBL_GENERAL', $siteLangId)
    ],
    'label' => Labels::getLabel('LBL_GENERAL', $siteLangId),
    'isActive' => true
];

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

if (User::AUTH_TYPE_GUEST != $userAuthType) {
    $otherButtons[] = [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'notifyUsersForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_BIND_USERS_FOR_THIS_NOTIFICATION', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_NOTIFY_TO', $siteLangId),
        'isActive' => false
    ];
}

require_once(CONF_THEME_PATH . '_partial/listing/form.php');
