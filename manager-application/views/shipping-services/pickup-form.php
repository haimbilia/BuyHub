<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'createPickup(this); return(false);');

$formTitle = Labels::getLabel('LBL_REQUEST_FOR_PICKUP', $siteLangId);

require_once(CONF_THEME_PATH . '_partial/listing/form.php');