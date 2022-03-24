<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="step">
    <div class="step_section">
        <div class="step_head">
            <h5 class="step_title"><?php echo Labels::getLabel('LBL_PAYMENT_SUMMARY', $siteLangId); ?></h5>
        </div>
        <div class="step_body">
            <?php if ($fulfillmentType == Shipping::FULFILMENT_SHIP && $shippingAddressId == $billingAddressId) { ?>
                <label class="checkbox mb-4">
                    <input onclick="billingAddress(this);" type="checkbox" checked='checked' name="isShippingSameAsBilling" value="1">
                    <?php echo Labels::getLabel('LBL_MY_BILLING_IS_SAME_AS_SHIPPING_ADDRESS', $siteLangId); ?>
                </label>
            <?php } ?>

            <div id="payment">
                <?php if ($cartSummary['orderNetAmount'] <= 0) { ?>
                    <div class="confirm-payment" id="wallet">
                        <?php
                        $label = Labels::getLabel('LBL_PAYMENT_TO_BE_MADE', $siteLangId) . ' ' . strip_tags(CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount'], true, false, true, false, true));
                        $btnSubmitFld = $confirmForm->getField('btn_submit');
                        $btnSubmitFld->addFieldTagAttribute('class', 'btn btn-brand');
                        $btnSubmitFld->changeCaption($label);

                        $confirmForm->developerTags['colClassPrefix'] = 'col-md-';
                        $confirmForm->developerTags['fld_default_col'] = 12;
                        echo $confirmForm->getFormHtml(); ?>
                    </div>
                <?php } ?>

                <div class="payment-area" <?php echo ($cartSummary['orderPaymentGatewayCharges'] <= 0) ? 'is--disabled' : ''; ?>>
                    <?php if (0 < count($paymentMethods)) { ?>
                        <ul class="payments-nav" id="payment_methods_tab">
                            <?php foreach ($paymentMethods as $key => $val) {
                                $pmethodCode = $val['plugin_code'];
                                if ($cartHasDigitalProduct && in_array(strtolower($pmethodCode), ['cashondelivery', 'payatstore'])) {
                                    continue;
                                }
                                $pmethodId = $val['plugin_id'];
                                $pmethodName = $val['plugin_name'];

                                if (in_array($pmethodCode, $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_PRODUCT])) {
                                    continue;
                                } ?>
                                <li class="payments-nav-item">
                                    <a class="payments-nav-link" aria-selected="true" href="<?php echo UrlHelper::generateUrl('Checkout', 'PaymentTab', array($orderId, $pmethodId)); ?>" data-paymentmethod="<?php echo $pmethodCode; ?>">
                                        <?php echo $pmethodName; ?>
                                    </a>
                                    <div class="payment-block paymentBlockJs <?php echo $pmethodCode . '-js'; ?>" style="display: none;"></div>
                                </li>
                            <?php
                            } ?>
                        </ul>
                    <?php } else {
                        echo Labels::getLabel("LBL_PAYMENT_METHOD_IS_NOT_AVAILABLE._PLEASE_CONTACT_YOUR_ADMINISTRATOR.", $siteLangId);
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    var enableGcaptcha = false;
</script>
<?php
$siteKey = FatApp::getConfig('CONF_RECAPTCHA_SITEKEY', FatUtility::VAR_STRING, '');
$secretKey = FatApp::getConfig('CONF_RECAPTCHA_SECRETKEY', FatUtility::VAR_STRING, '');
$paymentMethods = new PaymentMethods();
if (!empty($siteKey) && !empty($secretKey) && true === $paymentMethods->cashOnDeliveryIsActive()) { ?>
    <script src='https://www.google.com/recaptcha/api.js?onload=googleCaptcha&render=<?php echo $siteKey; ?>'></script>
    <script>
        var enableGcaptcha = true;
    </script>
<?php } ?>

<?php if ($cartSummary['orderPaymentGatewayCharges']) { ?>
    <script type="text/javascript">
        var tabsId = '#payment_methods_tab';
        $(function() {
            $(tabsId + " li:first a").addClass('active');
            if ($(tabsId + ' li a.active').length > 0) {
                loadTab($(tabsId + ' li a.active'));
            }
            $(tabsId + ' a').on('click', function() {
                if ($(this).hasClass('active')) {
                    return false;
                }
                $(tabsId + ' li a.active').removeClass('active');
                $(this).addClass('active');
                loadTab($(this));
                return false;
            });
        });

        function loadTab(tabObj) {
            if (!tabObj || !tabObj.length) {
                return;
            }
            $('.paymentBlockJs').hide();
            fcom.updateWithAjax(tabObj.attr('href'), '', function(res) {
                var paymentMethod = tabObj.data('paymentmethod');
                if ('paypal' != paymentMethod.toLowerCase() && 0 < $("#paypal-buttons").length) {
                    $("#paypal-buttons").html("");
                }

                $('.' + paymentMethod + '-js').html(res.html).fadeIn();
                if ('cashondelivery' == paymentMethod.toLowerCase() || 'payatstore' == paymentMethod.toLowerCase()) {
                    if (true == enableGcaptcha) {
                        googleCaptcha();
                    }
                    $.ykmsg.close();
                } else {
                    var form = '.' + paymentMethod + '-js form';
                    if (0 < $(form).length) {
                        $('.' + paymentMethod + '-js').prepend(fcom.getLoader());
                        if (0 < $(form + " input[type='submit']").length) {
                            $(form + " input[type='submit']").val(langLbl.requestProcessing);
                        }
                        setTimeout(function() {
                            $(form).submit()
                        }, 100);
                    }
                }
            });
        }
    </script>
<?php }
