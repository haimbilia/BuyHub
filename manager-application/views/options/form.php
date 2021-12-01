<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('option_is_separate_images');
$fld->developerTags['colWidthValues'] = [null, '4', null, null];

$fld = $frm->getField('option_is_color');
$fld->developerTags['colWidthValues'] = [null, '4', null, null];

$fld = $frm->getField('option_display_in_filter');
$fld->developerTags['colWidthValues'] = [null, '4', null, null];

require_once(CONF_THEME_PATH . '_partial/listing/form.php');