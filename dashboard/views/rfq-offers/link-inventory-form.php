<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);

$frm->setFormTagAttribute('data-onclear', 'linkInventoryForm(' . $rfqId . ')');
$frm->setFormTagAttribute('class', 'form modalFormJs');
$frm->setFormTagAttribute('onsubmit', 'linkInventory(this); return(false);');

$fld = $frm->getField('rfqts_selprod_id');
$fld->addFieldTagAttribute('id', 'rfqSelprodIdJs');
$fld->addFieldTagAttribute('placeholder', Labels::getLabel('FRM_SELECT_INVENTORY', $siteLangId));

$formTitle = Labels::getLabel('LBL_LINK_INVENTORY', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php');