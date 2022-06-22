<?php  defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('faqcat_active');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
}

require_once(CONF_THEME_PATH . '_partial/listing/form.php');
