<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$fld = $frmSearch->getField('order_user_id');
$fld->setFieldTagAttribute('id', 'buyerJs');
$fld->setFieldTagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_BUYER_NAME,_USER_NAME,_EMAIL_OR_PHONE_NUMBER', $siteLangId));

$fld = $frmSearch->getField('op_selprod_user_id');
$fld->setFieldTagAttribute('id', 'sellerJs');
$fld->setFieldTagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_SELLER_NAME,_USER_NAME,_EMAIL_OR_PHONE_NUMBER', $siteLangId));

$fld = $frmSearch->getField('orrequest_op_id');
$fld->setFieldTagAttribute('id', 'oProductJs');
$fld->setFieldTagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_PRODUCT_NAME,_BRAND_NAME_OR_SHOP_NAME', $siteLangId));

$fld = $frmSearch->getField('date_from');
$fld->setFieldTagAttribute('class', 'field--calender');

$fld = $frmSearch->getField('date_to');
$fld->setFieldTagAttribute('class', 'field--calender');

require_once(CONF_THEME_PATH . '_partial/listing/index.php');