<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

HtmlHelper::formatFormFields($frm);
$frm->setFormTagAttribute('class', 'modal-body form form-edit layout--' . $formLayout);
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
        <?php echo Labels::getLabel('LBL_COMMISSION_SETUP', $adminLangId); ?>
    </h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <?php echo $frm->getFormHtml(); ?>
    </div>

    <div class="form-edit-foot">
        <div class="row">
            <div class="col-auto">
                <button type="button" class="btn btn-brand gb-btn gb-btn-primary submitBtnJs">
                    <?php
                    if (0 < $recordId) {
                        echo Labels::getLabel('LBL_UPDATE', $adminLangId);
                    } else {
                        echo Labels::getLabel('LBL_SAVE', $adminLangId);
                    }
                    ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("document").ready(function() {
        if ($('#commsetting_user_id').length) {
            select2('commsetting_user_id', fcom.makeUrl('Commission', 'userAutoComplete'));
        }
        if ($('#commsetting_product_id').length) {
            select2('commsetting_product_id', fcom.makeUrl('Commission', 'productAutoComplete'));
        }
        if ($('#commsetting_prodcat_id').length) {
            select2('commsetting_prodcat_id', fcom.makeUrl('productCategories', 'links_autocomplete'));
        }
    });
</script>