<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'createPickup(this); return(false);');
$frm->setFormTagAttribute('data-onclear', 'getPickupForm('.$op_id.');');

$formTitle = Labels::getLabel('LBL_REQUEST_FOR_PICKUP', $siteLangId);
$includeTabs = false;
require_once(CONF_THEME_PATH . '_partial/listing/form.php');