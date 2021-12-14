<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit');
$frm->setFormTagAttribute('id', 'digitalDownloadFrm');
$frm->setFormTagAttribute('enctype', 'multipart/form-data');

$frm->setFormTagAttribute('onsubmit', "setupDigitalDownload($('#digitalDownloadFrm'))");


$fld = $frm->getField('option_comb_id');
if($fld){
    //$fld->addFieldTagAttribute('id', "image_option_id");
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('attach_with_existing_orders');
if($fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('lang_id');
if($fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('downloadable_file');
if($fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('preview_file');
if($fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('product_downloadable_link');
if($fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('product_preview_link');
if($fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$includeTabs = false;
$formTitle = $type == applicationConstants::DIGITAL_DOWNLOAD_FILE ? Labels::getLabel('LBL_DIGITAL_FILES', $siteLangId) :Labels::getLabel('LBL_DIGITAL_LINKS', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');