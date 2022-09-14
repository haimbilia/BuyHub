<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
$btn = $frm->getField('btn_submit');
$btn->addFieldTagAttribute('class', 'btn btn-brand');
$btn->addFieldTagAttribute('data-processing-text', Labels::getLabel('LBL_PLEASE_WAIT..', $siteLangId));

if (null != $btn) {
    $btn->setFieldTagAttribute('class', "d-none");
}

$btn = $frm->getField('btn_cancel');
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
            <div class="payable-form-body">
                <?php if (!isset($error)) : ?>
                    <h6><?php echo Labels::getLabel('LBL_REDIRECTING_TO_PAYMENT_PAGE...', $siteLangId); ?></h6>
                    <?php echo $frm->getFormHtml(); ?>
                <?php else : ?>
                    <div class="alert alert-danger"><?php echo $error ?></div>
                <?php endif; ?>
                <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                    <p class="form-text text-muted mt-4"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $paymentAmount); ?> </p>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(function() {
        setTimeout(function() {
            $('form[name="frmPayFort"]').submit();
        }, 2000);
    });
</script>