<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="payment-page">
    <div class="cc-payment">
        <?php $this->includeTemplate('_partial/paymentPageLogo.php', array('siteLangId' => $siteLangId)); ?>
        <div class="reff row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <p class=""><?php echo Labels::getLabel('LBL_Payable_Amount', $siteLangId); ?> : <strong><?php echo CommonHelper::displayMoneyFormat($paymentAmount) ?></strong> </p>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <p class=""><?php echo Labels::getLabel('LBL_Order_Invoice', $siteLangId); ?>: <strong><?php echo $orderInfo["invoice"]; ?></strong></p>
            </div>
        </div>
        <div class="payment-from container">
            <?php if (!isset($error)) { ?>
                <p><?php echo Labels::getLabel('MSG_We_are_redirecting_to_payment_page', $siteLangId); ?></p>
            <?php } else { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php  } ?>
            <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                <p class="form-text text-muted mt-4"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $paymentAmount); ?> </p>
            <?php } ?>
        </div>
    </div>
</div>
<script src="https://beautiful.start.payfort.com/checkout.js"></script>
<script>
    $(function() {

        var cancelPay = '<?php echo CommonHelper::getPaymentCancelPageUrl(); ?>';
        StartCheckout.config({
            key: "<?php echo $open_key; ?>",
            complete: function(params) {
                submitFormWithToken(params);
            },
            cancel: function() {
                paymentCancel();
            }

        });
        StartCheckout.open({
            amount: <?php echo $amount_in_cents ?>,
            email: "<?php echo $customer_email ?>",
            currency: "<?php echo $currency ?>"
        });
        /**
         * This method is called after a token is returned when the form is submitted.
         * We add the token + email to the form, and then submit the form.
         */
        function submitFormWithToken(params) {
            frm = $("<form action='<?php echo UrlHelper::generateFullUrl('PayFortStartPay', 'payFortCharge'); ?>' method='POST'></form>");
            frm.append("<input type='hidden' name='ord' id='ord' value='<?php echo $orderId ?>'>");
            frm.append("<input type='hidden' name='startToken' value='" + params.token.id + "'>");
            frm.append("<input type='hidden' name='startEmail' value='" + params.email + "'>");
            frm.appendTo(document.body);
            frm.submit();
        }

        function paymentCancel() {
            window.location = cancelPay;
        }

    });
</script>