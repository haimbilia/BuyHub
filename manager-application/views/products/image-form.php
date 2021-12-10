<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit');
$frm->setFormTagAttribute('data-callbackfn', 'productImagesCallback');
//$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');


$fld = $frm->getField('prod_image');
$fld->addFieldTagAttribute('onChange', "loadImageCropper(this)");
$fld->addFieldTagAttribute('accept', "image/*");
$fld->addFieldTagAttribute('data-name', Labels::getLabel("FRM_BACKGROUND_IMAGE", $siteLangId));

$fld = $frm->getField('option_id');
$fld->addFieldTagAttribute('id', "image_option_id");

$displayFooterButtons = false;
$includeTabs = false;

$formTitle = Labels::getLabel('LBL_MEDIA_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');