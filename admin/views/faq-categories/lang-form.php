<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');
$langFrm->setFormTagAttribute('id', 'frmFaqCatLangJs');
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData($("#frmFaqCatLangJs")); return(false);');
require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php'); ?>