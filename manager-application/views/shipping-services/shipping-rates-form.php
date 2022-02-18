<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'setUpShippingRate(this); return(false);');

$formTitle = Labels::getLabel('LBL_SHIPPING_RATES', $siteLangId);
$includeTabs = false;
require_once(CONF_THEME_PATH . '_partial/listing/form.php');