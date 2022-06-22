<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('onSubmit', 'setupMessage(this); return false;');
$frm->setFormTagAttribute('data-onclear', 'addNewComment(' . $orrequestId . ')');

$formTitle = Labels::getLabel('LBL_ADD_COMMENT', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
