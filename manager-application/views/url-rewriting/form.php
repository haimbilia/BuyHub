<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ')');
$frm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');
$includeTabs  = false;
$formTitle = Labels::getLabel('LBL_URL_REWRITE_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');