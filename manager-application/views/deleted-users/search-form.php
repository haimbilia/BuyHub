<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$fld = $frmSearch->getField('user_id');
$fld->addFieldtagAttribute('class', 'form-control');
$fld->setFieldtagAttribute('id', 'searchFrmUserIdJs');
$fld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_USER_NAME_OR_EMAIL', $siteLangId));

require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>