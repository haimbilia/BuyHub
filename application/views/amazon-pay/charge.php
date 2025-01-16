<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
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
                <p id="paymentStatus"></p>
                <?php
                if (isset($error))
                    echo '<div class="alert alert-danger"><p>' . $error . '</p></div>';
                if (isset($success))
                    echo '<div class="alert alert-success" ><p>' . Labels::getLabel('LBL_Your_payment_has_been_successfully', $siteLangId) . '</p></div>';
                if (strlen((string)$orderId) > 0 && $orderInfo["order_payment_status"] == Orders::ORDER_PAYMENT_PENDING) echo '<div class="text-center" style="margin-top:40px;" id="AmazonPayButton"></div>';
                ?>
            </div>
            <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                <p class="form-text text-muted mt-4"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $paymentAmount); ?> </p>
            <?php } ?>
        </div>
    </div>
</section>
<?php include(CONF_THEME_PATH . '_partial/footer-part/fonts.php'); ?>
<?php
if (isset($amazon) && strlen((string)$orderId) > 0 && $orderInfo["order_payment_status"] == Orders::ORDER_PAYMENT_PENDING) {
    if (strlen((string)$amazon['merchant_id']) > 0 && strlen((string)$amazon['access_key']) > 0 && strlen((string)$amazon['secret_key']) > 0 && strlen((string)$amazon['client_id']) > 0 && strlen(FatApp::getConfig('CONF_TRANSACTION_MODE', FatUtility::VAR_STRING, '0'))) {
?>
        <?php if (!FatUtility::isAjaxCall()) { ?>
            <script type='text/javascript' src='https://static-na.payments-amazon.com/OffAmazonPayments/us/sandbox/js/Widgets.js'></script>
        <?php } ?>
        <script type="text/javascript">
            var loginReady = false;
            window.onAmazonLoginReady = function() {
                if (true === loginReady) {
                    return;
                }
                amazon.Login.setClientId('<?php echo $amazon['client_id']; ?>');
                amazon.Login.setUseCookie(true);
                loginReady = true;
            };
            if (false === loginReady) {
                window.onAmazonLoginReady();
            }
        </script>
        <script type="text/javascript">
            var authRequest;
            OffAmazonPayments.Button("AmazonPayButton", '<?php echo $amazon['merchant_id']; ?>', {
                type: "PwA",
                authorization: function() {
                    loginOptions = {
                        scope: "profile postal_code payments:widget payments:shipping_address",
                        popup: true
                    };
                    authRequest = amazon.Login.authorize(loginOptions, "<?php echo UrlHelper::generateUrl('AmazonPay', 'charge', array($orderId), CONF_WEBROOT_FRONTEND, false) ?>");
                },
                onError: function(error) {
                    amazon.Login.logout();
                    document.cookie = "amazon_Login_accessToken=; expires=Thu, 01 Jan 1970 00:00:00 GMT";
                    window.location = '<?php echo UrlHelper::generateUrl('AmazonPay', 'charge', array($orderId), CONF_WEBROOT_FRONTEND) ?>';
                }
            });
        </script>
<?php
    }
}
