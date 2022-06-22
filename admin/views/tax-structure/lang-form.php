<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$formTitle = Labels::getLabel('LBL_TAX_STRUCTURE_SETUP', $siteLangId);
$langFrm->developerTags['fieldWrapperRowExtraClassDefault'] = 'form-group mb-2';
require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php');
