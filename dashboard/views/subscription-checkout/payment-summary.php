<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="checkout-page">
    <main class="checkout-page_main">
        <div class="step">
            <div class="step_section">
                <div class="step_head">
                    <h5 class="step_title">
                        <?php echo Labels::getLabel('LBL_Payment_Summary', $siteLangId); ?>
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
                        }

                        if ($cartSummary['orderPaymentGatewayCharges']) { ?>
                            <div class="payment-area" <?php echo ($cartSummary['orderPaymentGatewayCharges'] <= 0) ? 'is--disabled' : ''; ?>>
                                <?php if ($cartSummary['orderPaymentGatewayCharges'] && 0 < $gatewayCount && 0 < count($paymentMethods)) { ?>
                                    <?php if ($paymentMethods) { ?>
                                        <ul class="nav nav-payments <?php echo 1 == count($paymentMethods) ? 'd-none' : ''; ?>" id="payment_methods_tab">
                                            <?php foreach ($paymentMethods as $key => $val) {
                                                if (in_array($val['plugin_code'], $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_SUBSCRIPTION])) {
                                                    continue;
                                                }
                                                $pmethodCode = $val['plugin_code'];
                                                $pmethodId = $val['plugin_id'];
                                                $pmethodName = (isset($val['plugin_name']) && !empty($val['plugin_name'])) ? $val['plugin_name'] : $val['plugin_identifier'];
                                                if (in_array($pmethodCode, $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_PRODUCT])) {
                                                    continue;
                                                } ?>
                                                <li class="nav-item">
                                                    <a class="nav-link" aria-selected="true" href="<?php echo UrlHelper::generateUrl('SubscriptionCheckout', 'PaymentTab', array($orderInfo['order_id'], $pmethodId)); ?>" data-paymentmethod="<?php echo $pmethodCode; ?>">
                                                        <div class="payment-box">
                                                            <span><?php echo $pmethodName; ?></span>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php
                                            } ?>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane fade show active">
                                                <div class="tabs-container" id="tabs-container"></div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } else {
                                    echo Labels::getLabel("LBL_Payment_method_is_not_available._Please_contact_your_administrator.", $siteLangId);
                                } ?>
                            </div>
                        <?php } ?>
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
        $(document).ready(function() {
            $(tabsId + " li:first a").addClass('active');
            if ($(tabsId + ' li a.active').length > 0) {
                loadTab($(tabsId + ' li a.active'));
            }
            $(tabsId + ' a').click(function() {
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
            if (isUserLogged() == 0) {
                loginPopUpBox();
                return false;
            }
            if (!tabObj || !tabObj.length) {
                return;
            }

            fcom.ajax(tabObj.attr('href'), '', function(response) {
                $('#tabs-container').html(response);
                var paymentMethod = tabObj.data('paymentmethod');
                var form = '#tabs-container form';
                if (0 < $(form).length) {
                    $('#tabs-container').append(fcom.getLoader());
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
