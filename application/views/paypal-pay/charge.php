<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

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
                <p class='loading-js'><?php echo Labels::getLabel('MSG_LOADING_PAYMENT_OPTIONS...', $siteLangId); ?></p>
                <div id="paypal-buttons"></div>
            </div>
            <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                <p class="form-text text-muted mt-4"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $paymentAmount); ?> </p>
            <?php } ?>
        </div>
    </div>
</section>
<?php if (!FatUtility::isAjaxCall()) { ?>
    <script type="text/javascript" src="<?php echo $externalLibUrl; ?>"></script>
<?php } ?>
<script type="text/javascript">
    function loadPayPalButtons() {
        //=== Render paypal Buttons
        paypal.Buttons({
            onError: function(err) {
                fcom.displayErrorMessage(err.message);
                return;
            },
            style: {
                layout: "vertical"
            },
            //=== Call your server to create an order
            createOrder: function(data, actions) {
                fcom.displayProcessing();
                return fetch(fcom.makeUrl('PaypalPay', 'createOrder', ['<?php echo $orderInfo['id']; ?>']), {
                    method: "POST",
                }).then(function(res) {
                    return res.json();
                }).then(function(data) {
                    $.ykmsg.info(langLbl.waitingForResponse);
                    if (!data.success && (data.message || data.msg)) {
                        var msg = typeof data.msg != 'undefined' ? data.msg : data.message;
                        fcom.displayErrorMessage(msg);
                        return;
                    }
                    $.ykmsg.close();
                    return data.id;
                });
            },
            //=== Call your server to save the transaction
            onApprove: function(data, actions) {
                $.ykmsg.info(langLbl.waitingForResponse);
                return fetch(fcom.makeUrl('PaypalPay', 'captureOrder', [data.orderID]), {
                    method: "POST",
                }).then(function(res) {
                    return res.json();
                }).then(function(data) {
                    //=== Redirect to thank you/success page after saving transaction
                    $.ajax({
                        type: "POST",
                        url: fcom.makeUrl('PaypalPay', 'callback', ['<?php echo $orderInfo['id']; ?>']),
                        data: data,
                        dataType: 'json',
                        beforeSend: function() {
                            $.ykmsg.info(langLbl.updatingRecord);
                        },
                        success: function(resp) {
                            if (1 > resp.status) {
                                fcom.displayErrorMessage(resp.msg);
                            } else {
                                fcom.displaySuccessMessage(resp.msg);
                                setTimeout(function() {
                                    window.location.href = resp.redirecUrl;
                                }, 100);
                            }
                        }
                    });
                });
            }
        }).render("#paypal-buttons");
    }

    $(function() {
        loadPayPalButtons();
        setTimeout(function() {
            if ('' != $("#paypal-buttons").html()) {
                $(".loading-js").hide();
            }
        }, 1000);
    });
</script>