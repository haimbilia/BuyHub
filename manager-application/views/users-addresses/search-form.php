<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$fld = $frmSearch->getField('addr_record_id');
$fld->setFieldtagAttribute('id', 'searchFrmUserIdJs');
$fld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_USER_NAME_OR_EMAIL', $siteLangId));

$fld = $frmSearch->getField('addr_title');
$fld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_Address_Title', $siteLangId));

require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>