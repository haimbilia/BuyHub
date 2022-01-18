<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('onsubmit', 'sendMail(this); return(false);');
$frm->setFormTagAttribute('data-onclear', 'sendMailToUser(' . $recordId . ');');
$formTitle = Labels::getLabel('LBL_Send_Mail', $siteLangId);

require_once(CONF_THEME_PATH . '_partial/listing/form.php');