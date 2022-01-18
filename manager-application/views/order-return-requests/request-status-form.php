<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'setupStatus(this); return(false);');
$frm->setFormTagAttribute('data-onclear', 'requestStatusForm(' . $orrequestId . ')');
$frm->setFormTagAttribute('data-status', $oldStatus);

$fld = $frm->getField('orrequest_refund_in_wallet');
$fld->developerTags['rdLabelAttributes'] = ['class' => 'radio'];

$formTitle = Labels::getLabel('LBL_UPDATE_STATUS', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
