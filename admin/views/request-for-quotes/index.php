<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$fld = $frmSearch->getField('rfq_user_id');
$fld->setFieldTagAttribute('id', 'buyerJs');
$fld->setFieldTagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_BUYER_NAME,_USER_NAME,_EMAIL_OR_PHONE_NUMBER', $siteLangId));

$fld = $frmSearch->getField('rfq_seller_id');
$fld->setFieldTagAttribute('id', 'sellerJs');
$fld->setFieldTagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_SELLER_NAME,_USER_NAME,_EMAIL_OR_PHONE_NUMBER', $siteLangId));

require_once(CONF_THEME_PATH . '_partial/listing/index.php');