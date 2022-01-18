<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('currency_code');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('currency_symbol_left');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('currency_symbol_right');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('currency_value');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('currency_active');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['noCaptionTag'] = true;

require_once(CONF_THEME_PATH . '_partial/listing/form.php');
