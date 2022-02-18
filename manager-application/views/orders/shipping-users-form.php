<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'updateShippingUser(this); return(false);');
$frm->setFormTagAttribute('data-onclear', 'getShippingUsersForm(' . $orderId . ', ' . $recordId . ')');

if (true === $isShippingUserAssigned) {
    $fld = $frm->getField('optsu_user_id');
    $fld->setFieldTagAttribute('disabled', 'disabled');
    $displayFooterButtons = false;
}

$generalTab = [
    'attr' => [
        'href' => 'javascript:void(0);',
        'onclick' => "getShippingUsersForm(" . $orderId . ", " . $recordId . ");",
        'title' => Labels::getLabel('LBL_SHIPPING_USER', $siteLangId)
    ],
    'label' => Labels::getLabel('LBL_SHIPPING_USER', $siteLangId),
    'isActive' => true
];

$otherButtons = [
    [
        'attr' => [
            'href' => 'javascript:void(0);',
            'onclick' => "getOrderCommentForm(" . $orderId . ", " . $recordId . ")",
            'title' => Labels::getLabel('LBL_ORDER_STATUS', $siteLangId)
        ],
        'label' => Labels::getLabel('LBL_ORDER_STATUS', $siteLangId),
        'isActive' => false
    ]
];

require_once(CONF_THEME_PATH . '_partial/listing/form.php');
