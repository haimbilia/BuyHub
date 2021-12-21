<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('orderstatus_color_class');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('orderstatus_type');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('orderstatus_is_digital');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['noCaptionTag'] = true;

$fld = $frm->getField('orderstatus_is_active');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['noCaptionTag'] = true;

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); 