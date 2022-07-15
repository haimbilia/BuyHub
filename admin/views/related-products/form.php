<?php 
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this, "closeForm"); return(false);');

$fld = $frm->getField('selprod_user_id');
$fld->addFieldTagAttribute('id', 'sellerIdJs');

$fld = $frm->getField('selprod_id');
$fld->addFieldTagAttribute('id', 'productNameJs');
$fld->addFieldTagAttribute('placeholder', Labels::getLabel('FRM_SELECT_PRODUCT', $siteLangId));

$fld = $frm->getField('products_related[]');
$fld->addFieldTagAttribute('id', 'relatedProductsJs');
$fld->addFieldTagAttribute('data-allow-clear', '0');
$fld->addFieldTagAttribute('disabled', 'disabled');
$fld->addFieldTagAttribute('multiple', 'multiple');
$fld->addFieldTagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_RELATED_PRODUCTS', $siteLangId));

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>
<script>
    bindProductNameSelect2();
    bindlRelatedProdSelect2();
</script>