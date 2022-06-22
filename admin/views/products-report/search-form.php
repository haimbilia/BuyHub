<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$keywordPlaceholder = Labels::getLabel('FRM_SEARCH_BY_CUSTOM_TITLE_OR_BRAND_NAME', $siteLangId);

$shopFld = $frmSearch->getField('shop_id');
$shopFld->addFieldtagAttribute('id', 'shop_id');

$brandFld = $frmSearch->getField('brand_id');
$brandFld->addFieldtagAttribute('id', 'brand_id');
$brandFld->addFieldtagAttribute('class', 'brand_id');

require_once(CONF_THEME_PATH . '_partial/listing/listing-search-form.php'); ?>
<script type="text/javascript">
    $("document").ready(function() {
        if ($('#shop_id').length) {
            select2('shop_id', fcom.makeUrl('Shops', 'autoComplete'));
        }
        if ($('#brand_id').length) {
            select2('brand_id', fcom.makeUrl('Brands', 'autoComplete'));
        }
    });
</script>