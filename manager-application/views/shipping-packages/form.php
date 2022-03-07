
<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

//$frm->setFormTagAttribute('onsubmit', 'saveRecord(this, "closeForm"); return(false);');

$fld = $frm->getField('shippack_name');
$fld->developerTags['colWidthValues'] = [null, '6', null, null]; 

$fld = $frm->getField('shippack_units');
$fld->developerTags['colWidthValues'] = [null, '6', null, null]; 

$fld = $frm->getField('shippack_length');
$fld->developerTags['colWidthValues'] = [null, '4', null, null]; 

$fld = $frm->getField('shippack_width');
$fld->developerTags['colWidthValues'] = [null, '4', null, null]; 

$fld = $frm->getField('shippack_height');
$fld->developerTags['colWidthValues'] = [null, '4', null, null]; 

require_once(CONF_THEME_PATH . '_partial/listing/form.php');