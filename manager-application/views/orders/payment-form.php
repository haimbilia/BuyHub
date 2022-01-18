<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('onsubmit', 'updatePayment(this); return(false);');
$frm->setFormTagAttribute('class', 'form');

echo $frm->getFormTag(); 
    echo $frm->getFieldHtml('opayment_order_id');
    ?>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="label">
                    <?php echo $frm->getField('opayment_comments')->getCaption(); ?>
                    <span class="spn_must_field">*</span>
                </label>
                <?php echo $frm->getFieldHtml('opayment_comments'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="label">
                    <?php echo $frm->getField('opayment_method')->getCaption(); ?>
                    <span class="spn_must_field">*</span>
                </label>
                <?php echo $frm->getFieldHtml('opayment_method'); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="label">
                    <?php echo $frm->getField('opayment_gateway_txn_id')->getCaption(); ?>
                    <span class="spn_must_field">*</span>
                </label>
                <?php echo $frm->getFieldHtml('opayment_gateway_txn_id'); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="label">
                    <?php echo $frm->getField('opayment_amount')->getCaption(); ?>
                    <span class="spn_must_field">*</span>
                </label>
                <?php echo $frm->getFieldHtml('opayment_amount'); ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <?php echo HtmlHelper::addButtonHtml(Labels::getLabel('LBL_CLEAR', $siteLangId), 'button', 'btn_cancel', 'btn btn-outline-brand clearFormJs'); ?>
        </div>
        <div class="col-auto">
            <?php echo HtmlHelper::addButtonHtml(Labels::getLabel('LBL_UPDATE', $siteLangId), 'button', 'btn_submit', 'btn btn-brand gb-btn gb-btn-primary submitFormBtnJs'); ?>
        </div>
    </div>
</form>
<?php echo $frm->getExternalJS(); ?>