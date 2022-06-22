<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
HtmlHelper::formatFormFields($frm);

$fld = $frm->getField('password');
if ($fld != null) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('confirm_password');
if ($fld != null) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('admin_name');
if ($fld != null) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

$fld = $frm->getField('admin_username');
if ($fld != null) {
    $fld->developerTags['colWidthValues'] = [null, '6', null, null];
}

require_once(CONF_THEME_PATH . '_partial/listing/form.php');
