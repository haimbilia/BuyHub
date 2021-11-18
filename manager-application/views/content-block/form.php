<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('epage_label');
$fld->setFieldTagAttribute('onkeyup', "Slugify(this.value,'urlrewrite_custom','epage_id');getSlugUrl($(\"#urlrewrite_custom\"),$(\"#urlrewrite_custom\").val())");

$fld = $frm->getField('urlrewrite_custom');
$fld->setFieldTagAttribute('id', "urlrewrite_custom");
$fld->htmlAfterField = '<span class="form-text text-muted">' . UrlHelper::generateFullUrl('Custom', 'View', array($recordId), CONF_WEBROOT_FRONT_URL) . '</span>';
$fld->setFieldTagAttribute('onKeyup', "getSlugUrl(this,this.value)");
$formTitle = Labels::getLabel('LBL_CONTENT_BLOCK_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');