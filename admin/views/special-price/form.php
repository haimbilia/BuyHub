<?php 
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this, "closeForm"); return(false);');
$fld = $frm->getField('splprice_start_date');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('splprice_end_date');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('product_name');
$fld->addFieldTagAttribute('id', 'productNameJs');
$fld->addFieldTagAttribute('placeholder', Labels::getLabel('FRM_SELECT_PRODUCT', $siteLangId));

$fld = $frm->getField('splprice_price');
$fld->htmlAfterField = '<span class="form-text text-muted" id="specialCurrentPrice"></span>';

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>
<script>
    bindProductNameSelect2();
    var currentPriceLbl = '<?php echo Labels::getLabel('LBL_SELLING_PRICE', $siteLangId);?>';
</script>