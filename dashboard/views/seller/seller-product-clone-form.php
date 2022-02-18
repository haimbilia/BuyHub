<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$returnAgeFld = $frm->getField('selprod_return_age');
$cancellationAgeFld = $frm->getField('selprod_cancellation_age');
$btnFld = $frm->getField('btn_submit');
$btnFld->addFieldTagAttribute('class', 'btn btn-brand');
$returnAge = FatUtility::int($returnAgeFld->value);
$hidden = '';
if ('' === $returnAgeFld->value || '' === $cancellationAgeFld->value) {
    $hidden = 'hidden';
}
$returnAgeFld->setWrapperAttribute('class', 'use-shop-policy ' . $hidden);
$cancellationAgeFld->setWrapperAttribute('class', 'use-shop-policy ' . $hidden);
?>
<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Clone_Inventory', $siteLangId); ?></h5>
</div>
<div class="modal-body form-edit">
    <div class="form-edit-body loaderContainerJs">
        <div class="box__body">
            <?php
            $frm->setFormTagAttribute('class', 'form form--horizontal');
            $frm->developerTags['colClassPrefix'] = 'col-sm-12 col-md-12 col-lg-';
            $frm->developerTags['fld_default_col'] = 12;
            $frm->setFormTagAttribute('onsubmit', 'setUpSellerProductClone(this); return(false);');
            echo $frm->getFormHtml();
            ?>
        </div>
    </div>
    <?php require_once(CONF_THEME_PATH . '_partial/listing/form-edit-foot.php'); ?>
</div>

<script type="text/javascript">
    $("document").ready(function() {
        $("#use_shop_policy").change(function() {
            if ($(this).is(":checked")) {
                $('.use-shop-policy').addClass('hidden');
            } else {
                $('.use-shop-policy').removeClass('hidden');
            }
        });
    });
</script>