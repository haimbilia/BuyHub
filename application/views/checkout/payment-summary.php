<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$rewardPoints = UserRewardBreakup::rewardPointBalance(UserAuthentication::getLoggedUserId());
?>

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

            <div class="use-reward-block mb-5">
                <h6 class="h6">
                    <?php echo Labels::getLabel('LBL_USE_REWARD_AND_WALLET_CREDITS', $siteLangId); ?>
                </h6>
                <div class="wallet-options">
                    <?php if (empty($cartSummary['cartRewardPoints'])) {
                        if ($rewardPoints > 0) { ?>
                            <div class="wallet-options-list">
                                <?php
                                $redeemRewardFrm->setFormTagAttribute('class', 'form form-apply');
                                $redeemRewardFrm->setFormTagAttribute('onsubmit', 'useRewardPoints(this); return false;');
                                $redeemRewardFrm->setJsErrorDisplay('afterfield');
                                $fld = $redeemRewardFrm->getField('redeem_rewards');
                                $fld->setFieldTagAttribute('class', 'form-control');
                                $fld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Use_Reward_Point', $siteLangId));

                                echo $redeemRewardFrm->getFormTag();
                                echo $redeemRewardFrm->getFieldHtml('redeem_rewards');
                                echo $redeemRewardFrm->getFieldHtml('btn_submit'); ?>
                                </form>
                                <?php echo  $redeemRewardFrm->getExternalJs(); ?>

                                <p class="txt-sm">
                                    <?php
                                    $cartTotal = isset($cartSummary['cartTotal']) ? $cartSummary['cartTotal'] : 0;
                                    $cartDiscounts = isset($cartSummary['cartDiscounts']["coupon_discount_total"]) ? $cartSummary['cartDiscounts']["coupon_discount_total"] : 0;
                                    $canBeUsed = min(min($rewardPoints, CommonHelper::convertCurrencyToRewardPoint($cartTotal - $cartDiscounts)), FatApp::getConfig('CONF_MAX_REWARD_POINT', FatUtility::VAR_INT, 0));
                                    $str = Labels::getLabel('LBL_MAXIMUM_{REWARDS}_REWARDS_POINT_REDEEM_FOR_THIS_ORDER', $siteLangId);
                                    echo CommonHelper::replaceStringData($str, ['{REWARDS}' => $canBeUsed]); ?>
                                </p>
                            </div>
                        <?php
                        }
                    } else { ?>
                        <div class="info">
                            <span> <svg class="svg">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info">
                                    </use>
                                </svg> <?php echo Labels::getLabel('LBL_Reward_Points', $siteLangId); ?>
                                <strong><?php echo $cartSummary['cartRewardPoints']; ?>
                                    (<?php echo CommonHelper::displayMoneyFormat(CommonHelper::convertRewardPointToCurrency($cartSummary['cartRewardPoints']), true, false, true, false, true); ?>)</strong>
                                <?php echo Labels::getLabel('LBL_SUCCESSFULLY_USED', $siteLangId); ?></span>
                            <ul class="list-actions">
                                <li>
                                    <a class="link" href="javascript:void(0);" onclick="removeRewardPoints()">
                                        <svg class="svg" width="24" height="24">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#remove">
                                            </use>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php } ?>

                    <?php if ($userWalletBalance > 0 && $cartSummary['orderNetAmount'] > 0 && $canUseWalletForPayment) { ?>
                        <div class="wallet-options-list">
                            <label class="checkbox wallet-credits">
                                <input onchange="walletSelection(this)" type="checkbox" <?php echo ($cartSummary["cartWalletSelected"]) ? 'checked="checked"' : ''; ?> name="pay_from_wallet" id="pay_from_wallet" value="1">
                                <?php echo Labels::getLabel('LBL_WALLET_CREDITS:', $siteLangId); ?>
                                <strong><?php echo CommonHelper::displayMoneyFormat($userWalletBalance, true, false, true, false, true); ?></strong>
                            </label>

                            <?php if ($cartSummary["cartWalletSelected"] && $userWalletBalance >= $cartSummary['orderNetAmount']) {
                                $btnSubmitFld = $WalletPaymentForm->getField('btn_submit');
                                $btnSubmitFld->addFieldTagAttribute('class', 'btn btn-brand btn-sm');
                                $btnSubmitFld->value = Labels::getLabel('LBL_PAY', $siteLangId) . ' ' . CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount'], true, false, true, false, false);
                                $WalletPaymentForm->developerTags['colClassPrefix'] = 'col-md-';
                                $WalletPaymentForm->developerTags['fld_default_col'] = 12;
                                echo $WalletPaymentForm->getFormTag();
                                echo $WalletPaymentForm->getFieldHTML('btn_submit');
                                echo $WalletPaymentForm->getExternalJS();
                            ?>
                                </form>

                                <script type="text/javascript">
                                    function confirmOrder(frm) {
                                        var data = fcom.frmData(frm);
                                        var action = $(frm).attr('action');
                                        fcom.updateWithAjax(fcom.makeUrl('Checkout', 'confirmOrder'), data, function(ans) {
                                            $(location).attr("href", action);
                                        });
                                    }
                                </script>
                            <?php } else { ?>
                                <p class="txt-sm">
                                    <?php echo Labels::getLabel('LBL_USE_MY_WALLET_BALANCE_TO_PAY_FOR_MY_ORDER', $siteLangId); ?>
                                </p>
                            <?php } ?>
                        </div>
                    <?php } ?>

                    <div class="wallet-options-list">
                        <p class="txt-sm"><?php echo Labels::getLabel('LBL_AVAILABLE_REWARDS_POINTS', $siteLangId); ?></p>
                        <div class="wallet-options-value"><?php echo $rewardPoints; ?></div>
                    </div>
                    <div class="wallet-options-list">
                        <p class="txt-sm"><?php echo Labels::getLabel('LBL_POINTS_WORTH', $siteLangId); ?></p>
                        <div class="wallet-options-value">
                            <?php echo CommonHelper::displayMoneyFormat(CommonHelper::convertRewardPointToCurrency($rewardPoints), true, false, true, false, true); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div id="payment">
                <?php if ($cartSummary['orderNetAmount'] <= 0) { ?>
                    <div class="confirm-payment" id="wallet">
                        <?php
                        $label = Labels::getLabel('LBL_Payment_to_be_made', $siteLangId) . ' ' . strip_tags(CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount'], true, false, true, false, true));
                        $btnSubmitFld = $confirmForm->getField('btn_submit');
                        $btnSubmitFld->addFieldTagAttribute('class', 'btn btn-brand');
                        $btnSubmitFld->changeCaption($label);

                        $confirmForm->developerTags['colClassPrefix'] = 'col-md-';
                        $confirmForm->developerTags['fld_default_col'] = 12;
                        echo $confirmForm->getFormHtml(); ?>
                    </div>
                <?php } ?>
                <?php
                if ($cartSummary['orderPaymentGatewayCharges']) { ?>
                    <div class="payment-area" <?php echo ($cartSummary['orderPaymentGatewayCharges'] <= 0) ? 'is--disabled' : ''; ?>>
                        <?php if ($cartSummary['orderPaymentGatewayCharges'] && 0 < count($paymentMethods)) { ?>
                            <ul class="payments-nav <?php echo 1 == count($paymentMethods) ? 'd-none' : ''; ?>" id="payment_methods_tab">
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
                <?php } ?>
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
