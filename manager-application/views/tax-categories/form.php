<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit');  
 
$otherButtons = [
     
]; 

$formTitle = Labels::getLabel('LBL_TAX_CATEGORY_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');