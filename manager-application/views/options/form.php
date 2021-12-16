<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('option_is_separate_images');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['noCaptionTag'] = true;
$fld->developerTags['colWidthValues'] = [null, '12', null, null];

$fld = $frm->getField('option_is_color');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['noCaptionTag'] = true;
$fld->developerTags['colWidthValues'] = [null, '12', null, null];

$fld = $frm->getField('option_display_in_filter');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['noCaptionTag'] = true;
$fld->developerTags['colWidthValues'] = [null, '12', null, null];


require_once(CONF_THEME_PATH . '_partial/listing/form.php');
