<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('onsubmit', 'sendMail(this); return(false);');
$frm->setFormTagAttribute('data-onclear', 'sendMailToUser(' . $recordId . ');');
$formTitle = Labels::getLabel('LBL_Send_Mail', $siteLangId);

$username = !empty($user['user_name']) ? $user['user_name'] . ' (' . $user['credential_username'] . ')' : $user['credential_username'];
$fld = $frm->getField('to_info');
$fld->value = '<label class="label">'.Labels::getLabel('LBL_To', $siteLangId).'</label><div>'.$username.'</div>';


require_once(CONF_THEME_PATH . '_partial/listing/form.php');