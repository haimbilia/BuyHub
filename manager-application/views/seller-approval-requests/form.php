<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ', true)');
require_once(CONF_THEME_PATH . '_partial/listing/form.php');