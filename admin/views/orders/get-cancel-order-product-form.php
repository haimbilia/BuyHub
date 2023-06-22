<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('class', 'form');
$frm->setFormTagAttribute('data-onclear', 'getCancelOrderProductForm(' . $recordId . ')');
$frm->setFormTagAttribute('onsubmit', 'cancelOrderProduct($("#' . $frm->getFormTagAttribute('id') . '")[0]); return(false);');

$formTitle = Labels::getLabel('LBL_CANCEL_ORDER_{ITEM}_-_{INVOICE-NO}', $siteLangId);
$formTitle = CommonHelper::replaceStringData($formTitle, ['{ITEM}' => $orderProductName, '{INVOICE-NO}' => $invoiceNumber]);
$includeTabs = false;
require_once(CONF_THEME_PATH . '_partial/listing/form.php');
