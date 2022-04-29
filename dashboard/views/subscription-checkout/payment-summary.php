<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="checkout-page">
    <main class="checkout-page_main">
        <div class="step">
            <div class="step_section">
                <div class="step_head">
                    <h5 class="step_title">
                        <a class="btn btn-back back" type="button" href="<?php echo UrlHelper::generateUrl('seller','packages'); ?>">
                            <svg class="svg" width="24" height="24">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#back">
                                </use>
                            </svg>
                        </a>
                        <?php echo Labels::getLabel('LBL_PAYMENT_SUMMARY', $siteLangId); ?>
                    </h5>
                </div>
                <div class="step_body">
                    <section id="payment" class="section-checkout">
                        <?php
                        $gatewayCount = 0;
                        foreach ($paymentMethods as $key => $val) {
                            if (in_array($val['plugin_code'], $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_SUBSCRIPTION])) {
                                unset($paymentMethods[$key]);
                                continue;
                            }
                            $gatewayCount++;
                        } ?>
                        <div class="payment-area" <?php echo ($cartSummary['orderPaymentGatewayCharges'] <= 0) ? 'is--disabled' : ''; ?>>
                            <?php if (0 < count($paymentMethods)) { ?>
                                <ul class="payments-nav" id="payment_methods_tab">
                                    <?php
                                    $showFirstElement = '';
                                    foreach ($paymentMethods as $key => $val) {
                                        if (in_array($val['plugin_code'], $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_SUBSCRIPTION])) {
                                            continue;
                                        }
                                        $pmethodCode = $val['plugin_code'];
                                        $pmethodId = $val['plugin_id'];
                                        $pmethodName = (isset($val['plugin_name']) && !empty($val['plugin_name'])) ? $val['plugin_name'] : $val['plugin_identifier'];
                                        if (in_array($pmethodCode, $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_PRODUCT])) {
                                            continue;
                                        }
                                        $showFirstElement = empty($showFirstElement) && 0 < $cartSummary['orderPaymentGatewayCharges'] ? 'show' : ''; ?>
                                        <li class="payments-nav-item">
                                            <a class="payments-nav-link" aria-selected="true" href="<?php echo UrlHelper::generateUrl('SubscriptionCheckout', 'PaymentTab', array($orderInfo['order_id'], $pmethodId)); ?>" data-paymentmethod="<?php echo $pmethodCode; ?>" data-bs-toggle="collapse" data-bs-target="#<?php echo $pmethodCode; ?>-section" aria-expanded="true" aria-controls="<?php echo $pmethodCode; ?>-section">
                                                <?php echo $pmethodName; ?>
                                            </a>

                                            <?php if (0 < $cartSummary['orderPaymentGatewayCharges']) { ?>
                                                <div class="accordion-collapse <?php echo $showFirstElement; ?> collapse payment-block paymentBlockJs <?php echo $pmethodCode . '-js'; ?>" id="<?php echo $pmethodCode; ?>-section" aria-labelledby="headingOne" data-bs-parent="#payment_methods_tab"></div>
                                            <?php } ?>
                                        </li>
                                    <?php
                                    } ?>
                                </ul>
                            <?php } else {
                                echo Labels::getLabel("LBL_PAYMENT_METHOD_IS_NOT_AVAILABLE._PLEASE_CONTACT_YOUR_ADMINISTRATOR.", $siteLangId);
                            } ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

    <aside class="checkout-page_aside">
        <div class="sticky-summary">
            <div id="order-summary" class="cart-total order-summary summary-listing-js">
                <?php include(CONF_INSTALLATION_PATH . 'application/views/cart/_partial/summary-skeleton.php'); ?>
            </div>
        </div>
    </aside>
</div>

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
            var paymentMethod = tabObj.data('paymentmethod');
            var paymentMethodSection = $('.' + paymentMethod + '-js');
            paymentMethodSection.prepend(fcom.getLoader());
            fcom.updateWithAjax(tabObj.attr('href'), '', function(res) {
                if ('paypal' != paymentMethod.toLowerCase() && 0 < $("#paypal-buttons").length) {
                    $("#paypal-buttons").html("");
                }

                if (0 < paymentMethodSection.find('.paymentFormSection-js').length && paymentMethodSection.find('.paymentFormSection-js').hasClass('d-none')) {
                    paymentMethodSection.replaceWith(res.html);
                } else {
                    paymentMethodSection.html(res.html);
                }
                var form = '.' + paymentMethod + '-js .paymentFormSection-js form';
                if (0 < $(form).length) {
                    paymentMethodSection.prepend(fcom.getLoader());
                    if (0 < $(form + " input[type='submit']").length) {
                        $(form + " input[type='submit']").val(langLbl.requestProcessing);
                    }
                    setTimeout(function() {
                        $(form).submit()
                    }, 100);
                }
            });
        }
    </script>
<?php }
