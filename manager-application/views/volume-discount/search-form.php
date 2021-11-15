<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$fld = $frmSearch->getField('product_seller_id');
$fld->addFieldtagAttribute('class', 'form-control');
$fld->setFieldtagAttribute('id', 'productSellerJs');
$fld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SELECT_SELLER', $siteLangId));

require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php');