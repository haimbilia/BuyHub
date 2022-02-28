<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onsubmit', 'importFile("importData",' . $actionType . '); return false;');
$activeContentTab = true;
require_once(CONF_THEME_PATH . 'import-export/_partial/import-form.php');