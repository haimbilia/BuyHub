<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'updateStatus(this); return(false);');
$frm->setFormTagAttribute('class', 'form markAsShipped-js');

$frm->setFormTagAttribute('data-onclear', 'getOrderCommentForm(' . $op['order_id'] . ', ' . $op['op_id'] . ')');

$manualFld = $frm->getField('manual_shipping');

$statusFld = $frm->getField('op_status_id');
$statusFld->setFieldTagAttribute('class', 'status-js fieldsVisibilityJs');
$statusFld->developerTags['col'] = (null != $manualFld) ? 4 : 6;

$notiFld = $frm->getField('customer_notified');
$notiFld->setFieldTagAttribute('class', 'notifyCustomer-js');
$notiFld->developerTags['col'] = (null != $manualFld) ? 4 : 6;

if (null != $manualFld) {
    $manualFld->setFieldTagAttribute('class', 'manualShipping-js fieldsVisibilityJs');
    $manualFld->developerTags['col'] = 4;

    $fldTracking = $frm->getField('tracking_number');
    $fldTracking->developerTags['col'] = 4;

    $fld = $frm->getField('opship_tracking_url');
    $courierFld = $frm->getField('oshistory_courier');
    if (null != $fld) {
        $fld->developerTags['col'] = 4;
        $fld->setWrapperAttribute('class', 'trackingUrlBlk--js');
        $fld->setFieldTagAttribute('class', 'trackingUrlFld--js');
        if (null != $courierFld) {
            $fld->htmlAfterField = '<a href="javascript:void(0)" onclick="courierFld()">' . Labels::getLabel(
                'LBL_OR_SELECT_COURIER_?',
                $adminLangId
            ) . '</a>';
        }
    }

    if (null != $courierFld) {
        $courierFld->developerTags['col'] = 4;
        $courierFld->setWrapperAttribute('class', 'courierBlk--js d-none');
        $courierFld->setFieldTagAttribute('class', 'courierFld--js');
        $courierFld->htmlAfterField = '<a href="javascript:void(0)" onclick="trackingUrlFld()">' . Labels::getLabel(
            'LBL_OR_TRACK_THROUGH_URL_?',
            $adminLangId
        ) . '</a>';
    }
}

$formTitle = $op['op_selprod_title'];

require_once(CONF_THEME_PATH . '_partial/listing/form.php');
