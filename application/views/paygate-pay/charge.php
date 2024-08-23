<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$frm->setFormTagAttribute('class', 'form');
$frm->developerTags['colClassPrefix'] = 'col-lg-12 col-md-12 col-sm-';
$frm->developerTags['fld_default_col'] = 12;
$frm->setFormTagAttribute('class', 'd-none');
if (false === $processRequest) {
    $frm->setFormTagAttribute('onsubmit', 'confirmOrder(this); return(false);');
}
$frm->setFormTagAttribute('id', 'paymentForm-js');
$btn = $frm->getField('btn_submit');
if (null != $btn) {
    $btn->setFieldTagAttribute('class', "d-none");
}
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
            <div class="payable-form-body" id="paymentFormElement-js">
                <h6><?php echo Labels::getLabel('LBL_REDIRECTING_TO_PAYMENT_PAGE...', $siteLangId); ?></h6>
                <?php echo $frm->getFormHtml(); ?>
            </div>
            <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                <p class="form-text text-muted mt-4"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $paymentAmount); ?> </p>
            <?php } ?>
        </div>
    </div>
</section>
<?php include(CONF_THEME_PATH . '_partial/footer-part/fonts.php'); ?>
<script type="text/javascript">
    $("form#paymentForm-js").submit();

    function confirmOrder(frm) {
        var data = fcom.frmData(frm);
        var action = $(frm).attr('action');
        var submitBtn = $("form#paymentForm-js input[type='submit']");
        fcom.displayProcessing();
        submitBtn.attr('disabled', 'disabled');
        fcom.ajax(action, data, function(res) {
            var json = $.parseJSON(res);
            if (1 > json.status) {
                submitBtn.removeAttr('disabled');
                fcom.displayErrorMessage(json.msg);
                return false;
            }
            $("#paymentFormElement-js").replaceWith(json.html);
            $("#paymentFormElement-js").removeClass('text-center');
            $("form#paymentForm-js").submit();
        });
    }
</script>