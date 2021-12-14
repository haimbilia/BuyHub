<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit');

$fld = $frm->getField('option_id');
if($fld){
    $fld->addFieldTagAttribute('id', "image_option_id");
}

$fld = $frm->getField('option_id');
if($fld){
    $fld->addFieldTagAttribute('id', "image_option_id");
}

$fld = $frm->getField('option_id');
if($fld){
    $fld->addFieldTagAttribute('id', "image_option_id");
}

$fld = $frm->getField('option_id');
if($fld){
    $fld->addFieldTagAttribute('id', "image_option_id");
}

$fld = $frm->getField('option_id');
if($fld){
    $fld->addFieldTagAttribute('id', "image_option_id");
}



$displayFooterButtons = false;
$includeTabs = false;
$formTitle = $type == applicationConstants::DIGITAL_DOWNLOAD_FILE ? Labels::getLabel('LBL_DIGITAL_FILES', $siteLangId) :Labels::getLabel('LBL_DIGITAL_LINKS', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');