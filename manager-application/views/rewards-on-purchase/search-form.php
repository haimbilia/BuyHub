<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$fld = $frmSearch->getField('rop_reward_point');
$fld->addFieldtagAttribute('class', 'form-control');
$fld->setFieldtagAttribute('placeholder', Labels::getLabel('FRM_REWARD_POINTS', $siteLangId));

require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php');