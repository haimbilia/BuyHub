<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'form');

$fld = $frm->getField('prod_image');
$fld->addFieldTagAttribute('onChange', "loadImageCropper(this)");
$fld->addFieldTagAttribute('accept', "image/*");
$fld->addFieldTagAttribute('data-name', Labels::getLabel("FRM_PRODUCT_IMAGE", $siteLangId));

$fld = $frm->getField('option_id');
if (null != $fld) {
    $fld->addFieldTagAttribute('id', "image_option_id");
}

$fld = $frm->getField('file_type');
if (null != $fld) {
    $fld->addFieldTagAttribute('id', "image_file_type");
}

$fld = $frm->getField('lang_id');
$fld->addFieldTagAttribute('id', "image_lang_id");


$fld = $frm->getField('record_id');
$fld->addFieldTagAttribute('id', "image_record_id");

$fld = $frm->getField('images');
$fld->value = '<div class="upload__files"><ul class="upload__list" id="productImagesJs"></ul></div>';

$displayFooterButtons = false;
$includeTabs = false;
$formTitle = Labels::getLabel('LBL_MEDIA_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
