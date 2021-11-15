<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$fld = $frmSearch->getField('orderstatus_type');
$fld->addFieldtagAttribute('class', 'form-control');

require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php');
