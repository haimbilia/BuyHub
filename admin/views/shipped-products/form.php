<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ', ' . $profileId . ')');
$frm->setFormTagAttribute('onsubmit', 'saveRecord($("#' . $frm->getFormTagAttribute('id') . '")[0], "closeForm"); return(false);');
require_once(CONF_THEME_PATH . '_partial/listing/form.php');