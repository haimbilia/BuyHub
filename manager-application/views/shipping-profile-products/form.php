<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('onsubmit', 'setupProfileProduct(this); return(false);');
$frm->setFormTagAttribute('data-onclear', 'profileProductForm(' . $profile_id . ')');
$proFld = $frm->getField("product_name");
$proFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search_Product...', $siteLangId));
$formTitle = Labels::getLabel('LBL_PROFILE_PRODUCT_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');