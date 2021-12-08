<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$usersFld = $frm->getField('users');
$usersFld->addFieldTagAttribute('class', 'tagifyJs');
$usersFld->addFieldTagAttribute('data-record-id', $recordId);
$usersFld->addFieldTagAttribute('data-buyers', $notifyTo['pnotification_for_buyer']);
$usersFld->addFieldTagAttribute('data-sellers', $notifyTo['pnotification_for_seller']);

$generalTab = [
    'attr' => [
        'href' => 'javascript:void(0);',
        'onclick' => "editPushNotification(" . $recordId . ", " . $langId . ");",
        'title' => Labels::getLabel('LBL_GENERAL', $siteLangId)
    ],
    'label' => Labels::getLabel('LBL_GENERAL', $siteLangId),
    'isActive' => false
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
    ],
    [
        'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => '',
            'title' => Labels::getLabel('LBL_BIND_USERS_FOR_THIS_NOTIFICATION', $siteLangId),
        ],
        'label' => Labels::getLabel('LBL_NOTIFY_TO', $siteLangId),
        'isActive' => true
    ],
];

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>

<script>
    $(document).ready(function() {
        bindTagify();
    });
</script>