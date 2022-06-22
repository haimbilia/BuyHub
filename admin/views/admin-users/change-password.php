<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('onsubmit', 'updatePassword(this); return(false);');
$frm->setFormTagAttribute('data-onclear', 'changeUserPassword(' . $recordId . ');');
$formTitle = Labels::getLabel('LBL_CHANGE_PASSWORD', $siteLangId);

require_once(CONF_THEME_PATH . '_partial/listing/form.php');