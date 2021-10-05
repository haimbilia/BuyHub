<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit');
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');


$fld = $frm->getField('brand_name');
$fld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','brand_id');
getSlugUrl($(\"#urlrewrite_custom\"),$(\"#urlrewrite_custom\").val())");

$fld = $frm->getField('brand_id');
$fld->setFieldTagAttribute('id', "brand_id");

$fld = $frm->getField('urlrewrite_custom');
$fld->setFieldTagAttribute('id', "urlrewrite_custom");
$fld->htmlAfterField = "<small class='text--small'>" . UrlHelper::generateFullUrl('Brands', 'View', array($recordId), CONF_WEBROOT_FRONT_URL) . '</small>';
$fld->setFieldTagAttribute('onKeyup', "getSlugUrl(this,this.value)");

$otherButtons = [
    [
       'attr' => [
            'href' => 'javascript:void(0)',
            'onclick' => 'mediaForm(' . $recordId . ')',
            'title' => Labels::getLabel('LBL_MEDIA', $adminLangId),
        ],
        'label' => Labels::getLabel('LBL_MEDIA', $adminLangId),
        'isActive' => false
    ]
]; 

$formTitle = Labels::getLabel('LBL_BRAND_SETUP', $adminLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');