<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frmSearch->getField('abandonedcart_selprod_id');
$fld->setfieldTagAttribute('id', 'searchFrmSellerProductJs');

include(CONF_THEME_PATH . '_partial/listing/index.php');