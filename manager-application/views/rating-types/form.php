<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit');
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);'); 
$otherButtons = [ 
]; 

$formTitle = Labels::getLabel('LBL_RATING_TYPES_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');