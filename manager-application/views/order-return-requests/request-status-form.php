<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'setupStatus(this); return(false);');
$frm->setFormTagAttribute('data-onclear', 'requestStatusForm(' . $orrequestId . ')');
$frm->setFormTagAttribute('data-status', $oldStatus);

$frm->getField('orrequest_status')->setFieldTagAttribute('class', 'requestStatusJs');
$frm->getField('orrequest_admin_comment')->setWrapperAttribute('class', 'commentSectionJs hide');
$frm->getField('orrequest_refund_in_wallet')->setWrapperAttribute('class', 'refundToWalletSectionJs hide');

$formTitle = Labels::getLabel('LBL_UPDATE_STATUS', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
