<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('emptycartitem_url_is_newtab');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('emptycartitem_display_order');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('emptycartitem_active');
if ($fld != null) {
    HtmlHelper::configureSwitchForCheckbox($fld);
    $fld->developerTags['noCaptionTag'] = true;
}

require_once(CONF_THEME_PATH . '_partial/listing/form.php');
