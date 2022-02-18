<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('bpcategory_identifier');
$fld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','bpcategory_id');getSlugUrl($(\"#urlrewrite_custom\"),$(\"#urlrewrite_custom\").val(),'','pre',true)");
$fld->developerTags['colWidthValues'] = [null, '6', null, null];


$fld = $frm->getField('bpcategory_name');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('bpcategory_active');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->setFieldTagAttribute('data-old-value', $isActive);
$fld->developerTags['noCaptionTag'] = true;

$fld = $frm->getField('bpcategory_featured');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['noCaptionTag'] = true;

$fld = $frm->getField('bpcategory_parent');
$fld->setFieldTagAttribute('data-old-parent-id', $fld->value);

$fld = $frm->getField('bpcategory_id');
$fld->setFieldTagAttribute('id', "bpcategory_id");

$fld = $frm->getField('urlrewrite_custom');
$fld->setFieldTagAttribute('id', "urlrewrite_custom");
$fld->htmlAfterField = "<span class='form-text text-muted'>" . HtmlHelper::seoFriendlyUrl(UrlHelper::generateFullUrl('Blog', 'Category', array($recordId), CONF_WEBROOT_FRONT_URL)) . '</span>';
$fld->setFieldTagAttribute('onkeyup', "getSlugUrl(this,this.value)");

$formTitle = Labels::getLabel('LBL_BLOG_POST_CATEGORIES_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
