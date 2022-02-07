<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$fld = $frm->getField('CONF_DEFAULT_PLUGIN_'.$type);

if(null != $fld){
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
    $fld->developerTags['colWidthValues'] = [null, '12', null, null];
}


require_once(CONF_THEME_PATH . '_partial/listing/form.php');