<?php
 defined('SYSTEM_INIT') or die('Invalid Usage.');
$frm->setFormTagAttribute('id', 'frmversion');
$frm->setFormTagAttribute('onsubmit', 'saveRecord($("#frmversion")); return(false);');
$frm->developerTags['colClassPrefix'] = 'col-md-';
$frm->developerTags['fld_default_col'] = 12;
$fld = $frm->getField('arv_is_critical');
$fld->developerTags['rdLabelAttributes'] = ['class' => 'radio'];
$fld = $frm->getField('arv_app_type');
$fld->developerTags['rdLabelAttributes'] = ['class' => 'radio'];
require_once(CONF_THEME_PATH . '_partial/listing/form.php');