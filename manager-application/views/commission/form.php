<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ')');
$frm->setFormTagAttribute('class', 'modal-body form form-edit modalFormJs layout--' . $formLayout);
$frm->setFormTagAttribute('onsubmit', 'saveRecord(this); return(false);');

$fld = $frm->getField('commsetting_prodcat_id');
if (null != $fld) {
    $fld->setfieldTagAttribute('id', "commsetting_prodcat_id");
}
$fld = $frm->getField('commsetting_user_id');
if (null != $fld) {
    $fld->setfieldTagAttribute('id', "commsetting_user_id");
}

$fld = $frm->getField('commsetting_product_id');
if (null != $fld) {
    $fld->setfieldTagAttribute('id', "commsetting_product_id");
}

?>
<div class="modal-header">
    <h5 class="modal-title">
        <?php echo Labels::getLabel('LBL_COMMISSION_SETUP', $siteLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>
    
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        if ($('#commsetting_user_id').length) {
            select2('commsetting_user_id', fcom.makeUrl('Users', 'autoComplete'), {'joinShop' : 1, 'user_is_supplier' : 1});
        }
        if ($('#commsetting_product_id').length) {
            select2('commsetting_product_id', fcom.makeUrl('Commission', 'productAutoComplete'));
        }
        if ($('#commsetting_prodcat_id').length) {
            select2('commsetting_prodcat_id', fcom.makeUrl('productCategories', 'links_autocomplete'));
        }
    });
</script>