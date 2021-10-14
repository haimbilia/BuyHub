<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('onSubmit', 'exportMedia(this,' . $actionType . '); return false;');
$actionTypeArr = [
    Importexport::TYPE_PRODUCTS,
    Importexport::TYPE_SELLER_PRODUCTS,
    Importexport::TYPE_INVENTORIES
];
$activeMediaTab = true;
require_once(CONF_THEME_PATH . 'import-export/_partial/export-form-head.php');
