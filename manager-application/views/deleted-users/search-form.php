<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$fld = $frmSearch->getField('user_id');
$fld->setFieldtagAttribute('id', 'searchFrmUserIdJs');
$fld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_Search_By_User_Name', $siteLangId));

require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>