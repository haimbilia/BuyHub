<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$userFld = $frmSearch->getField('reviewed_for_id');
$userFld->addFieldtagAttribute('class', 'form-control');
$userFld->addFieldtagAttribute('id', 'searchFrmSellerIdJs');
// $userFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_SELLER_NAME_OR_EMAIL', $siteLangId));

require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php');