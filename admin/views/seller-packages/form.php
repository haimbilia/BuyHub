<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$fld = $frm->getField('spackage_commission_rate');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('spackage_products_allowed');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('spackage_inventory_allowed');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('spackage_images_per_product');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('spackage_type');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('spackage_active');
HtmlHelper::configureSwitchForCheckbox($fld);
$fld->developerTags['noCaptionTag'] = true;

$fld = $frm->getField('spackage_display_order');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('spackage_rfq_offers_allowed');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); 