<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php foreach ($externalLibraries as $url) { ?>
    <script type="text/javascript" src="<?php echo $url; ?>"></script>
<?php } ?>
<?php $frm->setFormTagAttribute('onsubmit', 'confirmOrder(); return(false);');
$frm->setFormTagAttribute('id', 'paymentForm');
?>
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
                    <div class="col-md-12" id="card_frame">

                    </div>
                </div>
            </div>
            <div class="payable-form-footer">
                <div class="row">
                    <div class="col-6">
                        <a href="<?php echo $cancelBtnUrl; ?>" class="btn btn-outline-gray btn-block"><?php echo Labels::getLabel('LBL_Cancel', $siteLangId); ?></a>
                    </div>
                    <div class="col-6">
                        <?php
                        $btn = $frm->getField('btn_submit');
                        $btn->addFieldTagAttribute('class', 'btn btn-brand btn-block');
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
<script type="text/javascript">
    var sdk = new window.YocoSDK({
        publicKey: '<?php echo $publicKey; ?>'
    });
    var inline = sdk.inline({
        layout: 'basic',
        amountInCents: <?php echo $paymentAmount; ?>,
        currency: '<?php echo $orderInfo["order_currency_code"]; ?>'
    });
    inline.mount('#card_frame');

    function confirmOrder() {
        var btnEle = $("#paymentForm input[type='submit']");
        var btnText = btnEle.val();
        btnEle.val(btnEle.data('processing-text')).attr('disabled', 'disabled');

        inline.createToken().then(function(result) {
            if (result.error) {
                btnEle.val(btnText).removeAttr('disabled');
                const errorMessage = result.error.message;
                errorMessage && fcom.displayErrorMessage(errorMessage);
            } else {
                fcom.displayProcessing();
                fcom.updateWithAjax(fcom.makeUrl('YocoPay', 'chargeCard', ['<?php echo $orderInfo["id"]; ?>']), {
                    token: result.id
                }, function(t) {
                    fcom.closeProcessing();
                    fcom.removeLoader();
                    btnEle.val(btnText).removeAttr('disabled');
                    if (t.status == 1) {
                        window.location.href = t.redirectUrl;
                    }
                });
            }
        }).catch(function(error) {
            fcom.displayErrorMessage(error);
            btnEle.val(btnText).removeAttr('disabled');
        });

    }
</script>