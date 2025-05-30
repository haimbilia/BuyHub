<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('onsubmit', 'confirmPayment(this); return(false);');
echo $frm->getFormTag(); ?>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <div class="caption-wraper">
                <label class="form-label"><?php echo Labels::getLabel('LBL_PHONE_NUMBER', $siteLangId); ?></label>
            </div>
            <div class="field-wraper">
                <div class="field_cover">
                    <?php echo $frm->getFieldHtml('customerPhone'); ?>
                    <span class='form-text text-muted'><?php echo Labels::getLabel('LBL_MSISDN_12_DIGITS_MOBILE_NUMBER', $siteLangId); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <div class="caption-wraper">
                <label class="form-label"></label>
            </div>
            <div class="field-wraper">
                <div class="field_cover">
                    <?php
                    $btn = $frm->getField('btn_submit');
                    $btn->addFieldTagAttribute('class', 'btn btn-secondary');
                    $btn->addFieldTagAttribute('data-processing-text', Labels::getLabel('LBL_PLEASE_WAIT..', $siteLangId));
                    $btn->value = $btn->value . ': ' . CommonHelper::displayMoneyFormat($paymentAmount);
                    echo $frm->getFieldHtml('btn_submit'); ?>
                    <a href="<?php echo $cancelBtnUrl; ?>" class="btn btn-outline-brand"><?php echo Labels::getLabel('LBL_Cancel', $siteLangId); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<?php echo $frm->getExternalJs(); ?>
<script>
    var confirmPayment = function(frm) {
        var me = $(frm);
        if (me.data('requestRunning')) {
            return;
        }
        if (!me.validate()) return;
        var btnEle = $("input[type='submit']", frm);
        var btnText = btnEle.val();
        btnEle.val(langLbl.processing).attr('disabled', 'disabled');
        fcom.displayProcessing();
        var data = fcom.frmData(frm);
        var action = me.attr('action');
        fcom.ajax(action, data, function(t) {
            btnEle.val(btnText).removeAttr('disabled');
            try {
                var json = $.parseJSON(t);
                if (1 > json.status) {
                    fcom.displayErrorMessage(json.msg);
                    return false;
                }
                fcom.displaySuccessMessage(json.msg);
                if (json['redirect']) {
                    $(location).attr("href", json['redirect']);
                }
            } catch (exc) {
                console.log(t);
            }
        });
    };
</script>