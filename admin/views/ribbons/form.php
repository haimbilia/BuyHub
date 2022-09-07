<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ', true)');

$fld = $frm->getField('badge_name');
$fld->addFieldTagAttribute('maxlength', Badge::RIBB_TEXT_MAX_LEN);

$colWidthValuesDefault = 6;
require_once(CONF_THEME_PATH . '_partial/listing/form.php');