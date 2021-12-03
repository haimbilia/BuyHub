<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit');
// $frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');

// $fld = $frm->getField('brand_name');
// $fld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','brand_id');
// getSlugUrl($(\"#urlrewrite_custom\"),$(\"#urlrewrite_custom\").val())");

// $fld = $frm->getField('brand_id');
// $fld->setFieldTagAttribute('id', "brand_id");

// $fld = $frm->getField('urlrewrite_custom');
// $fld->setFieldTagAttribute('id', "urlrewrite_custom");
// $fld->htmlAfterField = '<span class="form-text text-muted">' . UrlHelper::generateFullUrl('Brands', 'View', array($recordId), CONF_WEBROOT_FRONT_URL) . '</span>';
// $fld->setFieldTagAttribute('onKeyup', "getSlugUrl(this,this.value)");

$formTitle = Labels::getLabel('LBL_MEDIA_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');