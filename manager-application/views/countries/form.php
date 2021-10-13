<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('country_code');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('country_code_alpha3');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('country_language_id');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('country_active');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); 