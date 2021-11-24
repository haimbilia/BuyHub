<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');
$langFrm->setFormTagAttribute('id', 'frmFaqLangJs');
$langFrm->setFormTagAttribute('onsubmit', 'saveLangData($("#frmFaqLangJs")); return(false);');

require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php'); ?>