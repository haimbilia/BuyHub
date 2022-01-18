<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$fld = $frm->getField('optionvalue_color_code');
if (null != $fld) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
    
    $fld = $frm->getField('optionvalue_display_order');
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

require_once(CONF_THEME_PATH . '_partial/listing/form.php');