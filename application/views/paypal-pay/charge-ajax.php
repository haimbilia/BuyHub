<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<p class='loading-js'><?php echo Labels::getLabel('MSG_LOADING_PAYMENT_OPTIONS...', $siteLangId); ?></p>
<div id="paypal-buttons"></div>

<?php if (!FatUtility::isAjaxCall()) { ?>
    <script type="text/javascript" src="<?php echo $externalLibUrl; ?>"></script>
<?php } ?>
<script type="text/javascript">
    function loadPayPalButtons() {
        //=== Render paypal Buttons
        var errorOccurred = false;
        paypal.Buttons({
            onError: function(err) {
                if (false == errorOccurred) {
                    fcom.displayErrorMessage(err.message);
                }
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
                    $.ykmsg.info(langLbl.waitingForResponse, -1);
                    if (!data.success && (data.message || data.msg)) {
                        errorOccurred = true;
                        fcom.removeLoader();
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
                $(".Paypal-js").prepend(fcom.getLoader());
                $.ykmsg.info(langLbl.waitingForResponse, -1);
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
                            $.ykmsg.close();
                            $.ykmsg.info(langLbl.updatingRecord, -1);
                        },
                        success: function(resp) {
                            if (1 > resp.status) {
                                fcom.removeLoader();
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