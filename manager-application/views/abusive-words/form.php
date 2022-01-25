<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ', true)');
$frm->setFormTagAttribute('class', 'form modalFormJs layout--' . $formLayout);
$frm->setFormTagAttribute('id', 'frmAbusiveWordJs');
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this, "closeForm"); return(false);');

$fld = $frm->getField('abusive_lang_id');
$fld->addFieldTagAttribute('onChange', 'changeFormLayOut(this);');

require_once(CONF_THEME_PATH . '_partial/listing/form.php');