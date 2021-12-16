<?php

defined('SYSTEM_INIT') or die('Invalid Usage.');

$otherButtons = [
]; 
$displayObj = $langFrm->getField('taxstr_component_name[]');
$displayObj->developerTags['noCaptionTag'] = true;
$formTitle = Labels::getLabel('LBL_TAX_STRUCTURE_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/lang-form.php');
?>
 