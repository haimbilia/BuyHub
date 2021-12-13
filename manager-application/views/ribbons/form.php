<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('badge_shape_type');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('badge_display_inside');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
$fld->setWrapperAttribute('title', Labels::getLabel('LBL_RIBBON_TEXT_WILL_DISPLAY_INSIDE_THE_SHAPE', $siteLangId));
$fld->setWrapperAttribute('data-toggle', 'tooltip');
$fld->setWrapperAttribute('data-placement', 'top');

$fld = $frm->getField('badge_color');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('badge_active');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
require_once(CONF_THEME_PATH . '_partial/listing/form.php');