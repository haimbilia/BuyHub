<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$fld = $frm->getField('lang_id');
$fld->setFieldTagAttribute('onchange', 'editPageLanguageRecord("'.$pLangKey.'",'.$lang_id.');');
$displayLangTab = false;
$includeTabs = false;

$formTitle = Labels::getLabel('LBL_PAGE_LANGUAGE_DATA_UPDATE', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');