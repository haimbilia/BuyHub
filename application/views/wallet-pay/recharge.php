<?php defined('SYSTEM_INIT') or die('Invalid Usage'); ?>
<?php $gatewayCount = 0;
foreach ($paymentMethods as $key => $val) {
    if (in_array($val['plugin_code'], $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_ADD_MONEY_TO_WALLET])) {
        unset($paymentMethods[$key]);
        continue;
    }
    $gatewayCount++;
} ?>
<section class="section" data-section="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <header class="section-head  section-head-center">
                    <div class="section-heading">
                        <h2><?php echo Labels::getLabel('LBL_ADD_MONEY_TO_WALLET', $siteLangId); ?></h2>
                    </div>
                </header>
                <div class="section-body">
                    <?php if ($orderInfo['order_net_amount']) { ?>
                        <?php if ($gatewayCount > 0) { ?>
                            <div class="col-md-8">
                                <h5 class="h5">
                                    <?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?> :
                                    <?php echo CommonHelper::displayMoneyFormat($orderInfo['order_net_amount'], true, false, true, false, true); ?>
                                    <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                                        <p><?php echo CommonHelper::currencyDisclaimer($siteLangId, $orderInfo['order_net_amount']); ?>
                                        </p>
                                    <?php } ?>
                                </h5>
                            </div>
                            <div class="col-md-12">
                                <div id="payment">
                                    <div class="payment-area">
                                        <ul class="payments-nav" id="payment_methods_tab">
                                            <?php
                                            $showFirstElement = '';
                                            foreach ($paymentMethods as $key => $val) {
                                                $pmethodCode = $val['plugin_code'];
                                                $pmethodId = $val['plugin_id'];
                                                $pmethodName = $val['plugin_name'];
                                                $showFirstElement = empty($showFirstElement) ? 'show' : ''; ?>
                                                <li class="payments-nav-item">
                                                    <a class="payments-nav-link" aria-selected="true"
                                                        href="<?php echo UrlHelper::generateUrl('Checkout', 'PaymentTab', array($orderInfo['order_id'], $pmethodId)); ?>"
                                                        data-paymentmethod="<?php echo $pmethodCode; ?>" data-bs-toggle="collapse"
                                                        data-bs-target="#<?php echo $pmethodCode; ?>-section" aria-expanded="true"
                                                        aria-controls="<?php echo $pmethodCode; ?>-section">
                                                        <?php echo $pmethodName; ?>
                                                    </a>

                                                    <div class="accordion-collapse <?php echo $showFirstElement; ?> collapse payment-block paymentBlockJs <?php echo $pmethodCode . '-js'; ?>"
                                                        id="<?php echo $pmethodCode; ?>-section" data-bs-parent="#payment_methods_tab">
                                                    </div>
                                                </li>
                                            <?php
                                            } ?>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        <?php } else {
                            echo Labels::getLabel("LBL_PAYMENT_METHOD_IS_NOT_AVAILABLE._PLEASE_CONTACT_YOUR_ADMINISTRATOR.", $siteLangId);
                        } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if ($orderInfo['order_net_amount']) { ?>
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

                if (0 < paymentMethodSection.find('.paymentFormSection-js').length && paymentMethodSection.find(
                        '.paymentFormSection-js').hasClass('d-none')) {
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

        sendPayment = function(frm, dv = '') {
            var data = fcom.frmData(frm);
            var action = $(frm).attr('action');
            fcom.ajax(action, data, function(t) {
                // debugger;
                try {
                    var json = $.parseJSON(t);
                    if (typeof json.status != 'undefined' && 1 > json.status) {
                        fcom.displayErrorMessage(json.msg);
                        fcom.removeLoader();
                        return false;
                    }
                    if (typeof json.html != 'undefined') {
                        $(dv).append(json.html);
                    }
                    if (json['redirect']) {
                        $(location).attr("href", json['redirect']);
                    }
                } catch (e) {
                    $(dv).append(t);
                }
            });
        };
    </script>
<?php } ?>