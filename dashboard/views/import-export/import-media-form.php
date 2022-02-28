
<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('onSubmit', 'importFile("importMedia",' . $actionType . '); return false;');
$activeMediaTab = true;
require_once(CONF_THEME_PATH . 'import-export/_partial/import-form.php');