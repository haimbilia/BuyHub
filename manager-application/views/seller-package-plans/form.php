<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('spplan_frequency');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];
//$fld->htmlAfterField='<br/><small class="text--small">'.Labels::getLabel('LBL_PLease_Specify_the_Years_for_unlimited_years',$siteLangId).'</small>';

$fld = $frm->getField('spplan_interval');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('spplan_price');
if(null != $fld){
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}


$fld = $frm->getField('spplan_display_order');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('spplan_active');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];


$frm->setFormTagAttribute('data-onclear', 'editPlanRecord('.$spackageId.','.$spPlanId.')');
$formTitle = Labels::getLabel('LBL_SUBSCRIPTION_PACKAGE_PLANS_SETUP', $siteLangId);
require_once(CONF_THEME_PATH . '_partial/listing/form.php'); 