<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'updateStatus(this); return(false);');
$frm->setFormTagAttribute('class', 'form markAsShipped-js');

$frm->setFormTagAttribute('data-onclear', 'getOrderCommentForm(' . $op['order_id'] . ', ' . $op['op_id'] . ')');

$manualFld = $frm->getField('manual_shipping');

$statusFld = $frm->getField('op_status_id');
$statusFld->setFieldTagAttribute('class', 'statusJs fieldsVisibilityJs');
$statusFld->developerTags['col'] = (null != $manualFld) ? 4 : 6;

$notiFld = $frm->getField('customer_notified');
$notiFld->setFieldTagAttribute('class', 'notifyCustomerJs');
$notiFld->developerTags['col'] = (null != $manualFld) ? 4 : 6;

if (null != $manualFld) {
    $manualFld->setFieldTagAttribute('class', 'manualShippingJs fieldsVisibilityJs');
    $manualFld->developerTags['col'] = 4;

    $fldTracking = $frm->getField('tracking_number');
    $fldTracking->developerTags['col'] = 4;

    $fld = $frm->getField('opship_tracking_url');
    $courierFld = $frm->getField('oshistory_courier');
    if (null != $fld) {
        $fld->developerTags['col'] = 4;
        $fld->setWrapperAttribute('class', 'trackingUrlBlkJs');
        $fld->setFieldTagAttribute('class', 'trackingUrlFldJs');
        if (null != $courierFld) {
            $fld->htmlAfterField = '<a href="javascript:void(0)" onclick="courierFld()">' . Labels::getLabel(
                'LBL_OR_SELECT_COURIER_?',
                $adminLangId
            ) . '</a>';
        }
    }

    if (null != $courierFld) {
        $courierFld->developerTags['col'] = 4;
        $courierFld->setWrapperAttribute('class', 'courierBlkJs d-none');
        $courierFld->setFieldTagAttribute('class', 'courierFldJs');
        $courierFld->htmlAfterField = '<a href="javascript:void(0)" onclick="trackingUrlFld()">' . Labels::getLabel(
            'LBL_OR_TRACK_THROUGH_URL_?',
            $adminLangId
        ) . '</a>';
    }
}

$formTitle = $op['op_selprod_title'];

if (true === $displayShippingUserForm) {
    $recordId = $op['op_id'];
    $generalTab = [
        'attr' => [
            'href' => 'javascript:void(0);',
            'onclick' => "getShippingUsersForm(" . $op['order_id'] . ", " . $op['op_id'] . ");",
            'title' => Labels::getLabel('LBL_SHIPPING_USER', $siteLangId)
        ],
        'label' => Labels::getLabel('LBL_SHIPPING_USER', $siteLangId),
        'isActive' => false
    ];

    $otherButtons = [
        [
            'attr' => [
                'href' => 'javascript:void(0);',
                'onclick' => "getOrderCommentForm(" . $op['order_id'] . ", " . $op['op_id'] . ")",
                'title' => Labels::getLabel('LBL_ORDER_STATUS', $siteLangId)
            ],
            'label' => Labels::getLabel('LBL_ORDER_STATUS', $siteLangId),
            'isActive' => true
        ]
    ];
}
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
