<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');
$langFrm->setFormTagAttribute('id', 'frmFaqCatLangJs');
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData($("#frmFaqCatLangJs")); return(false);');

// $fld = $langFrm->getField('lang_id');
// $fld->developerTags['colWidthValues'] = [null, '6', null, null]; 
// $fld = $langFrm->getField('faqcat_name');
// $fld->developerTags['colWidthValues'] = [null, '6', null, null]; 

require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php'); ?>