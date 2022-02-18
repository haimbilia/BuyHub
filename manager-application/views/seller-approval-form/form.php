<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('sformfield_required');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('sformfield_type');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); 