<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$fld = $frmSearch->getField('blinkcond_user_id');
if (null != $fld) {
    $fld->setFieldTagAttribute('id', 'searchFromSellerJs');
}

$fld = $frmSearch->getField('blinkcond_condition_type');
if (null != $fld) {
    $fld->setFieldTagAttribute('id', 'searchFormConditionTypeJs');
    $fld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_SELECT_CONDITION_TYPE', $siteLangId));
}
require_once (CONF_THEME_PATH . '_partial/listing/index.php');