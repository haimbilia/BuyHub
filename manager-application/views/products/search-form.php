<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$fld = $frmSearch->getField('product_seller_id');
$fld->setFieldtagAttribute('id', 'searchFrmUserIdJs');
$fld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_USER_NAME', $siteLangId));

$fld = $frmSearch->getField('prodcat_id');
$fld->setFieldtagAttribute('id', 'prodcatIdJs');
$fld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_CATEGORY', $siteLangId));
require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>