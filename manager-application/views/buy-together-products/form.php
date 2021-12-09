<?php 
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this, "closeForm"); return(false);');

$fld = $frm->getField('product_name');
$fld = $frm->getField('product_name');
$fld->addFieldTagAttribute('placeholder', Labels::getLabel('FRM_SELECT_PRODUCT', $siteLangId));

$fld = $frm->getField('selected_products[]');
$fld->addFieldTagAttribute('class', 'relatedProductsJs');
$fld->addFieldTagAttribute('placeholder', Labels::getLabel('FRM_SEARCH_RELATED_PRODUCTS', $siteLangId));
$fld->addFieldTagAttribute('multiple', 'multiple');

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>
<script>
    bindProductNameSelect2();
    bindlRelatedProdSelect2();
</script>