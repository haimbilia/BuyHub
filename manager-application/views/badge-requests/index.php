<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); 

$fld = $frmSearch->getField('user_id');
if (null != $fld) {
    $fld->setFieldTagAttribute('id', 'searchFromSellerJs');
}

require_once (CONF_THEME_PATH . '_partial/listing/index.php');