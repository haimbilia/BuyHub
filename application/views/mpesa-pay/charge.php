<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<?php $frm->setFormTagAttribute('onsubmit', 'confirmPayment(this); return(false);'); ?>
<section class="payment-section">
    <div class="payable-amount">
        <div class="payable-amount-head">
            <div class="payable-amount-logo">
                <?php $this->includeTemplate('_partial/paymentPageLogo.php', array('siteLangId' => $siteLangId)); ?>
            </div>
            <div class="payable-amount-total">
                <p> <span class="label"> <?php echo Labels::getLabel('LBL_Total_Payable', $siteLangId); ?>:</span>
                    <span class="value"> <?php echo CommonHelper::displayMoneyFormat($paymentAmount) ?> </span>
                </p>
                <p> <span class="label"> <?php echo Labels::getLabel('LBL_Order_Invoice', $siteLangId); ?>: </span>
                    <span class="value"><?php echo $orderInfo["invoice"]; ?></span>
                </p>
            </div>
        </div>
        <div class="payable-amount-body from-payment">
            <?php echo $frm->getFormTag(); ?>
            <div class="payable-form-body">
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
            </div>
            <div class="payable-form-footer">
                <div class="row">
                    <div class="col-6">
                        <?php if (FatUtility::isAjaxCall()) { ?>
                            <a href="javascript:void(0);" onclick="loadPaymentSummary()" class="btn btn-outline-brand  btn-block">
                                <?php echo Labels::getLabel('LBL_Cancel', $siteLangId); ?>
                            </a>
                        <?php } else { ?>
                            <a href="<?php echo $cancelBtnUrl; ?>" class="btn btn-outline-gray  btn-block"><?php echo Labels::getLabel('LBL_Cancel', $siteLangId); ?></a>
                        <?php } ?>
                    </div>
                    <div class="col-6">
                        <?php
                        $btn = $frm->getField('btn_submit');
                        $btn->addFieldTagAttribute('class', 'btn btn-brand  btn-block');
                        $btn->addFieldTagAttribute('data-processing-text', Labels::getLabel('LBL_PLEASE_WAIT..', $siteLangId));
                        echo $frm->getFieldHtml('btn_submit');
                        ?>
                    </div>
                </div>
            </div>
            <?php echo $frm->getExternalJs(); ?>
            </form>
            <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                <p class="form-text text-muted mt-4"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $paymentAmount); ?> </p>
            <?php } ?>
        </div>
    </div>
</section>
<?php include(CONF_THEME_PATH . '_partial/footer-part/fonts.php'); ?>
<script>
    var confirmPayment = function(frm) {
        var me = $(frm);
        if (me.data('requestRunning')) {
            return;
        }
        if (!me.validate())
            return;
        var btnEle = $("input[type='submit']");
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