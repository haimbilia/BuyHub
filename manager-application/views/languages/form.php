<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs layout--' . $formLayout);

$fld = $frm->getField('language_name');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('language_code');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('language_active');
HtmlHelper::configureSwitchForCheckbox($fld);

require_once(CONF_THEME_PATH . '_partial/listing/form.php');