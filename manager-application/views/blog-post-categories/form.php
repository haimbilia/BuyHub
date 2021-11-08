<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit');
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');

$fld = $frm->getField('bpcategory_identifier');
$fld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','bpcategory_id');getSlugUrl($(\"#urlrewrite_custom\"),$(\"#urlrewrite_custom\").val(),'','pre',true)");
$fld->developerTags['colWidthValues'] = [null, '6', null, null];


$fld = $frm->getField('bpcategory_name');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('bpcategory_active');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('bpcategory_featured');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];


$fld = $frm->getField('bpcategory_id');
$fld->setFieldTagAttribute('id', "bpcategory_id");

$fld = $frm->getField('urlrewrite_custom');
$fld->setFieldTagAttribute('id', "urlrewrite_custom");
$fld->htmlAfterField = "<span class='form-text text-muted'>" . UrlHelper::generateFullUrl('Blog', 'Category', array($recordId), CONF_WEBROOT_FRONT_URL) . '</span>';
$fld->setFieldTagAttribute('onkeyup', "getSlugUrl(this,this.value)");

$formTitle = Labels::getLabel('LBL_BLOG_POST_CATEGORIES_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
