<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('orderstatus_is_digital');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('orderstatus_is_active');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); 