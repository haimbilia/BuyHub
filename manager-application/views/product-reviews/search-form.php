<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$userFld = $frmSearch->getField('reviewed_for_id');
$userFld->addFieldtagAttribute('class', 'form-control');
$userFld->addFieldtagAttribute('id', 'searchFrmSellerIdJs');
$userFld->addFieldtagAttribute('placeholder', Labels::getLabel('LBL_SEARCH_BY_SHOP_USER', $siteLangId));
require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php');