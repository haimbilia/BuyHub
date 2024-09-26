<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$userFld = $frmSearch->getField('user_id');
$userFld->addFieldtagAttribute('class', 'form-control');
$userFld->addFieldtagAttribute('id', 'searchFrmUserIdJs');
$userFld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_BY_USER_NAME_OR_EMAIL', $siteLangId));

require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php');
