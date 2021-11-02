<?php 
$formOnSubmit = 'saveRecord(this, "closeForm"); return(false);';

$fld = $frm->getField('voldiscount_min_qty');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('voldiscount_percentage');
$fld->developerTags['colWidthValues'] = [null, '6', null, null];

$fld = $frm->getField('voldiscount_selprod_id');
$fld->addFieldTagAttribute('id', 'productNameJs');
$fld->addFieldTagAttribute('placeholder', Labels::getLabel('FRM_SELECT_PRODUCT', $siteLangId));

require_once(CONF_THEME_PATH . '_partial/listing/form.php'); ?>
<script>
    bindProductNameSelect2();
</script>