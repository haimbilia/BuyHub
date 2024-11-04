<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$rewardsAmtCanBeUsed = 0;
$rewardsCurrAmtCanBeUsed = 0;
if ($rewardPointBalance > 0) {
    $cartTotal = $orderData['Order_net_amount'] ?? 0;
    $cartDiscounts = 0;
    $rewardsAmtCanBeUsed = min(min($rewardPointBalance, CommonHelper::convertCurrencyToRewardPoint($cartTotal - $cartDiscounts)), FatApp::getConfig('CONF_MAX_REWARD_POINT', FatUtility::VAR_INT, 0));
    $rewardsCurrAmtCanBeUsed = CommonHelper::convertRewardPointToCurrency($rewardsAmtCanBeUsed);
    $inCurrency = CommonHelper::displayMoneyFormat($rewardsCurrAmtCanBeUsed);
}

$canUseWalletOrRewards = (0 < count($paymentMethods) || (($rewardsCurrAmtCanBeUsed + $userWalletBalance) >= $orderData['order_net_amount']));
$noPaymentMethod = (1 > count($paymentMethods) && (!$canUseWalletForPayment || (1 > $userWalletBalance && $orderData['order_net_amount'] > 0)));

if ($noPaymentMethod && $rewardsCurrAmtCanBeUsed < $orderData['order_net_amount']) { ?>
<div class="text-center">
    <img class="block__img" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-payment-methods.svg"
        alt="<?php echo Labels::getLabel('LBL_NO_PAYMENT_METHOD_FOUND', $siteLangId); ?>">
    <h3><?php echo Labels::getLabel('ERR_PAYMENT_METHOD_IS_NOT_AVAILABLE.', $siteLangId); ?></h3>
    <p><?php echo Labels::getLabel('ERR_PLEASE_CONTACT_YOUR_ADMINISTRATOR.', $siteLangId); ?></p>
</div>
<?php } else { ?>
<section class="section" data-section="">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="step">
                    <div class="step_head">
                        <h5 class="step_title"><?php echo Labels::getLabel('LBL_PAYMENT_SUMMARY', $siteLangId); ?></h5>
                        <h5 class="h5">
                            <?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?> :
                            <?php echo CommonHelper::displayMoneyFormat($orderData['order_net_amount'], true, false, true, false, true); ?>
                            <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
                            <p><?php echo CommonHelper::currencyDisclaimer($siteLangId, $orderData['order_net_amount']);  ?>
                            </p>
                            <?php } ?>
                        </h5>
                    </div>
                    <div class="step_body">
                        <?php if ($noPaymentMethod) { ?>
                        <div class="text-center">
                            <img class="block__img"
                                src="<?php echo CONF_WEBROOT_URL; ?>images/retina/no-payment-methods.svg"
                                alt="<?php echo Labels::getLabel('LBL_NO_PAYMENT_METHOD_FOUND', $siteLangId); ?>">
                            <h3><?php echo Labels::getLabel('ERR_PAYMENT_METHOD_IS_NOT_AVAILABLE.', $siteLangId); ?>
                            </h3>
                            <p><?php echo Labels::getLabel('ERR_PLEASE_CONTACT_YOUR_ADMINISTRATOR.', $siteLangId); ?>
                            </p>
                        </div>
                        <?php } else { ?>
                        <div id="payment">
                            <div class="payment-area" ?>
                                <?php if ($orderData['order_net_amount'] <= 0) { ?>
                                <div class="wallet-payment confirm-payment" id="wallet">
                                    <h4 class="h4">
                                        <?php echo Labels::getLabel('LBL_PAYMENT_TO_BE_MADE', $siteLangId); ?>:&nbsp;
                                        <strong><span class="currency-value" dir="ltr">
                                                <?php echo strip_tags(CommonHelper::displayMoneyFormat($orderData['order_net_amount'], true, false, true, false, true)); ?>
                                        </strong>
                                    </h4>
                                    <?php
                                                $label = Labels::getLabel('LBL_PAYMENT_TO_BE_MADE', $siteLangId) . ' ' . strip_tags(CommonHelper::displayMoneyFormat($orderData['order_net_amount'], true, false, true, false, true));
                                                $btnSubmitFld = $confirmForm->getField('btn_submit');
                                                $btnSubmitFld->addFieldTagAttribute('class', 'btn btn-brand');
                                                $btnSubmitFld->developerTags['noCaptionTag'] = true;
                                                $confirmForm->developerTags['colClassPrefix'] = 'col-md-';
                                                $confirmForm->developerTags['fld_default_col'] = 12;
                                                echo $confirmForm->getFormHtml(); ?>
                                </div>
                                <?php } ?>

                                <?php if ($userWalletBalance > 0 && $orderData['order_net_amount'] > 0 && $canUseWalletForPayment) { ?>
                                <div class="wallet-payment">
                                    <div>
                                        <label class="checkbox wallet-credits">
                                            <?php if ($canUseWalletOrRewards) { ?>
                                            <input onchange="walletSelection(this)"
                                                <?php echo ($cartSummary["cartWalletSelected"]) ? 'checked="checked"' : ''; ?>
                                                type="checkbox" name="pay_from_wallet" id="pay_from_wallet" value="1">
                                            <?php } ?>
                                            <?php echo Labels::getLabel('LBL_WALLET_CREDITS:', $siteLangId); ?>&nbsp;
                                            <strong><?php echo CommonHelper::displayMoneyFormat($userWalletBalance, true, false, true, false, true); ?></strong>
                                        </label>
                                        <p class="wallet-payment-txt">
                                            <?php if ($canUseWalletOrRewards) {
                                                            echo Labels::getLabel('LBL_USE_MY_WALLET_BALANCE_TO_PAY_FOR_MY_ORDER', $siteLangId);
                                                        } else {
                                                            echo HtmlHelper::getErrorMessageHtml(Labels::getLabel('LBL_PAYMENT_CANNOT_BE_MADE_DUE_TO_A_LOW_BALANCE', $siteLangId));
                                                        } ?>
                                        </p>
                                    </div>
                                    <?php if ($cartSummary["cartWalletSelected"] &&  $userWalletBalance >= $orderData['order_net_amount']) {
                                                    $btnSubmitFld = $walletPaymentForm->getField('btn_submit');
                                                    $btnSubmitFld->addFieldTagAttribute('class', 'btn btn-brand btn-wide');
                                                    $btnSubmitFld->value = Labels::getLabel('LBL_PAY', $siteLangId) . ' ' . CommonHelper::displayMoneyFormat($orderData['order_net_amount'], true, false, true, false, false);
                                                    $walletPaymentForm->developerTags['colClassPrefix'] = 'col-md-';
                                                    $walletPaymentForm->developerTags['fld_default_col'] = 12;

                                                    echo $walletPaymentForm->getFormTag();
                                                    echo $walletPaymentForm->getFieldHTML('order_id');
                                                    echo $walletPaymentForm->getFieldHTML('btn_submit');
                                                    echo $walletPaymentForm->getExternalJS();
                                                    echo '</form>';         ?>
                                    <script>
                                    function confirmOrder(frm) {
                                        var data = fcom.frmData(frm);
                                        data = data + "&order_type=" + <?php echo Orders::ORDER_GIFT_CARD; ?>;

                                        var action = $(frm).attr('action');
                                        $(frm.btn_submit).attr({
                                            'disabled': 'disabled'
                                        });
                                        fcom.updateWithAjax(fcom.makeUrl('Checkout', 'confirmOrder'), data, function(
                                            ans) {
                                            $(location).attr("href", action);
                                            fcom.removeLoader();
                                        });
                                    }
                                    </script>
                                    <?php } ?>
                                </div>
                                <?php } ?>

                                <?php if (0 < count($paymentMethods)) { ?>
                                <ul class="payments-nav" id="payment_methods_tab">
                                    <?php
                                                $showFirstElement = '';
                                                $i = 0;
                                                foreach ($paymentMethods as $key => $val) {
                                                    $pmethodCode = $val['plugin_code'];
                                                    if (isset($pmethodCode) && in_array(strtolower($pmethodCode), ['cashondelivery', 'payatstore'])) {
                                                        continue;
                                                    }
                                                    $pmethodId = $val['plugin_id'];
                                                    $pmethodName = $val['plugin_name'];

                                                    if (in_array($pmethodCode, $excludePaymentGatewaysArr[applicationConstants::CHECKOUT_PRODUCT])) {
                                                        continue;
                                                    }

                                                    if (0 == $i) {
                                                        $showFirstElement = 'show';
                                                        $i++;
                                                    } ?>
                                    <li class="payments-nav-item">
                                        <a class="payments-nav-link" aria-selected="true"
                                            href="<?php echo UrlHelper::generateUrl('Checkout', 'PaymentTab', array($orderId, $pmethodId)); ?>"
                                            data-paymentmethod="<?php echo $pmethodCode; ?>" data-bs-toggle="collapse"
                                            data-bs-target="#<?php echo $pmethodCode; ?>-section" aria-expanded="true"
                                            aria-controls="<?php echo $pmethodCode; ?>-section">
                                            <?php echo $pmethodName; ?>
                                        </a>

                                        <?php /* if (0 < $cartSummary['orderPaymentGatewayCharges']) {  */ ?>
                                        <div class="accordion-collapse <?php echo $showFirstElement; ?> collapse payment-block paymentBlockJs <?php echo $pmethodCode . '-js'; ?>"
                                            id="<?php echo $pmethodCode; ?>-section" aria-labelledby="headingOne"
                                            data-bs-parent="#payment_methods_tab"></div>
                                        <?php /* } */ ?>
                                    </li>
                                    <?php
                                                    $showFirstElement = '';
                                                } ?>
                                </ul>
                                <?php } ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
setTimeout(() => {
    fcom.removeLoader();
}, 2000);
var enableGcaptcha = false;

walletSelection = function(el) {
    var wallet = $(el).is(":checked") ? 1 : 0;
    var data = "payFromWallet=" + wallet;

    fcom.updateWithAjax(
        fcom.makeUrl("Checkout", "walletGiftSelection"),
        data,
        function(ans) {
            location.reload()
        }
    );
};
</script>
<?php
        $siteKey = FatApp::getConfig('CONF_RECAPTCHA_SITEKEY', FatUtility::VAR_STRING, '');
        $secretKey = FatApp::getConfig('CONF_RECAPTCHA_SECRETKEY', FatUtility::VAR_STRING, '');
        $pm = new PaymentMethods();
        if (!empty($siteKey) && !empty($secretKey) && true === $pm->cashOnDeliveryIsActive()) { ?>
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
    var paymentMethod = tabObj.data('paymentmethod');
    var paymentMethodSection = $('.' + paymentMethod + '-js');
    paymentMethodSection.prepend(fcom.getLoader());
    fcom.ajax(tabObj.attr('href'), '', function(res) {
        if ('undefined' != res.status && 0 == res.status) {
            paymentMethodSection.html(res.msg);
            fcom.displayErrorMessage(res.msg);
            return;
        }

        if ('paypal' != paymentMethod.toLowerCase() && 0 < $("#paypal-buttons").length) {
            $("#paypal-buttons").html("");
        }
        if ('cashondelivery' == paymentMethod.toLowerCase() || 'payatstore' == paymentMethod
            .toLowerCase()) {
            fcom.removeLoader();
            paymentMethodSection.html(res.html);
            if (true == enableGcaptcha) {
                googleCaptcha();
            }
            $.ykmsg.close();
        } else {
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
        }
    }, {
        fOutMode: 'json'
    });
}
</script>
<?php
        }
    }