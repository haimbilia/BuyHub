<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (0 < $isShippingSelected && $rewardPoints > 0) { ?>
    <div class="cart-total-head">
        <h3 class="cart-total-title">
            <?php echo Labels::getLabel('LBL_REWARD_POINTS', $siteLangId); ?>
        </h3>
    </div>
    <div class="cart-total-body">
        <div class="cart-summary mb-4">
            <?php
            if (empty($cartSummary['cartRewardPoints'])) {
                $redeemRewardFrm->setFormTagAttribute('class', 'form form-apply');
                $redeemRewardFrm->setFormTagAttribute('onsubmit', 'useRewardPoints(this); return false;');
                $redeemRewardFrm->setJsErrorDisplay('afterfield');
                $fld = $redeemRewardFrm->getField('redeem_rewards');
                $fld->setFieldTagAttribute('class', 'form-control');
                $fld->setFieldTagAttribute('placeholder', Labels::getLabel('LBL_Use_Reward_Point', $siteLangId));

                $fld = $redeemRewardFrm->getField('btn_submit');
                $fld->setFieldTagAttribute('class', 'btn btn-secondary btn-wide');

                echo $redeemRewardFrm->getFormTag(); ?>
                <div class="input-group">
                    <?php echo $redeemRewardFrm->getFieldHtml('redeem_rewards'); ?>
                    <div class="input-group-append">
                        <?php echo $redeemRewardFrm->getFieldHtml('btn_submit'); ?>
                    </div>
                </div>
                </form>
                <?php echo $redeemRewardFrm->getExternalJs(); ?>

                <p class="txt-sm">
                    <?php
                    $cartTotal = isset($cartSummary['cartTotal']) ? $cartSummary['cartTotal'] : 0;
                    $cartDiscounts = isset($cartSummary['cartDiscounts']["coupon_discount_total"]) ? $cartSummary['cartDiscounts']["coupon_discount_total"] : 0;
                    $canBeUsed = min(min($rewardPoints, CommonHelper::convertCurrencyToRewardPoint($cartTotal - $cartDiscounts)), FatApp::getConfig('CONF_MAX_REWARD_POINT', FatUtility::VAR_INT, 0));
                    $str = Labels::getLabel('LBL_MAXIMUM_{REWARDS}_OUT_OF_{AVAILABLE-REWARDS}_REWARD_POINTS_CAN_BE_REDEEMED_FOR_THIS_ORDER.', $siteLangId);
                    echo CommonHelper::replaceStringData($str, ['{REWARDS}' => '<b>' . $canBeUsed . '</b>', '{AVAILABLE-REWARDS}' => '<b>' . $rewardPoints . '</b>']); ?>
                </p>
            <?php } else { ?>
                <div class="info">
                    <span>
                        <svg class="svg">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info">
                            </use>
                        </svg> <?php echo Labels::getLabel('LBL_REWARD_POINTS', $siteLangId); ?>
                        <strong><?php echo $cartSummary['cartRewardPoints']; ?>
                            (<?php echo CommonHelper::displayMoneyFormat(CommonHelper::convertRewardPointToCurrency($cartSummary['cartRewardPoints']), true, false, true, false, true); ?>)</strong>
                        <?php echo Labels::getLabel('LBL_SUCCESSFULLY_USED', $siteLangId); ?>
                    </span>
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
        </div>
    </div>
<?php } ?>

<div class="cart-total-head">
    <h3 class="cart-total-title">
        <?php echo Labels::getLabel('LBL_PRICE_SUMMARY', $siteLangId); ?>
    </h3>
</div>
<div class="cart-total-body">
    <ul class="cart-summary">
        <li class="cart-summary-item">
            <span class="label"><?php echo Labels::getLabel('LBL_Sub_Total', $siteLangId); ?></span> <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal']); ?></span>
        </li>
        <?php if ($cartSummary['cartVolumeDiscount']) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Loyalty/Volume_Discount', $siteLangId); ?>
                </span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartVolumeDiscount']); ?></span>
            </li>
        <?php } ?>
        <?php if (FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0) && !empty($cartSummary['cartDiscounts'])) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total']); ?></span>
            </li>
        <?php } ?>
        <?php if (isset($cartSummary['taxOptions'])) {
            foreach ($cartSummary['taxOptions'] as $taxName => $taxVal) { ?>
                <li class="cart-summary-item">
                    <span class="label"><?php echo $taxVal['title']; ?></span>
                    <span class="value"><?php echo CommonHelper::displayMoneyFormat($taxVal['value']); ?></span>
                </li>
        <?php }
        } ?>
        <?php if (!FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0) && !empty($cartSummary['cartDiscounts'])) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total']); ?></span>
            </li>
        <?php } ?>
        <?php if ($cartSummary['originalShipping']) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Delivery_Charges', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['shippingTotal']); ?></span>
            </li>
        <?php  } ?>
        <?php if (!empty($cartSummary['cartRewardPoints'])) {
            $appliedRewardPointsDiscount = CommonHelper::convertRewardPointToCurrency($cartSummary['cartRewardPoints']);
        ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Reward_point_discount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($appliedRewardPointsDiscount); ?></span>
            </li>
        <?php } ?>
        <?php if (array_key_exists('roundingOff', $cartSummary) && $cartSummary['roundingOff'] != 0) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo (0 < $cartSummary['roundingOff']) ? Labels::getLabel('LBL_Rounding_Up', $siteLangId) : Labels::getLabel('LBL_Rounding_Down', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['roundingOff']); ?></span>
            </li>
        <?php } ?>
        <?php if (0 < $cartSummary['totalSaving']) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_TOTAL_SAVING', $siteLangId); ?></span>
                <span class="value text-success"><?php echo CommonHelper::displayMoneyFormat($cartSummary['totalSaving']); ?></span>
            </li>
        <?php } ?>
        <?php $orderNetAmt = $cartSummary['orderNetAmount']; ?>
        <li class="cart-summary-item highlighted">
            <span class="label"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?></span>
            <span class="value"><?php echo CommonHelper::displayMoneyFormat($orderNetAmt); ?></span>
        </li>
        <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
            <p class="form-text text-muted mt-1"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $orderNetAmt); ?> </p>
        <?php } ?>

    </ul>
</div>
<?php if (1 > $isShippingSelected) { ?>
    <div class="cart-total-foot">
        <div class="cart-action">
            <?php if ($cartHasPhysicalProduct) {
                $fn = Shipping::FULFILMENT_SHIP == $fulfillmentType ? 'setUpShippingMethod();' : 'setUpPickup();'; ?>
                <button class="btn btn-brand btn-block" type="button" onclick="<?php echo $fn; ?>">
                    <?php echo Labels::getLabel('LBL_Continue', $siteLangId); ?>
                </button>
            <?php } else { ?>
                <button class="btn btn-brand btn-block" type="button" onclick="loadPaymentSummary();">
                    <?php echo Labels::getLabel('LBL_Continue', $siteLangId); ?>
                </button>
            <?php } ?>
        </div>
    </div>
<?php } else { ?>
    <?php if ($userWalletBalance > 0 && $cartSummary['orderNetAmount'] > 0 && $canUseWalletForPayment) { ?>
        <div class="divider"></div>
        <div class="cart-total-foot">
            <div class="cart-action">
                <label class="checkbox wallet-credits">
                    <input onchange="walletSelection(this)" type="checkbox" <?php echo ($cartSummary["cartWalletSelected"]) ? 'checked="checked"' : ''; ?> name="pay_from_wallet" id="pay_from_wallet" value="1">
                    <?php echo Labels::getLabel('LBL_WALLET_CREDITS:', $siteLangId); ?>
                    <strong><?php echo CommonHelper::displayMoneyFormat($userWalletBalance, true, false, true, false, true); ?></strong>
                </label>

                <?php if ($cartSummary["cartWalletSelected"] && $userWalletBalance >= $cartSummary['orderNetAmount']) {
                    $btnSubmitFld = $walletPaymentForm->getField('btn_submit');
                    $btnSubmitFld->addFieldTagAttribute('class', 'btn btn-brand btn-block');
                    $btnSubmitFld->value = Labels::getLabel('LBL_PAY', $siteLangId) . ' ' . CommonHelper::displayMoneyFormat($cartSummary['orderNetAmount'], true, false, true, false, false);
                    $walletPaymentForm->developerTags['colClassPrefix'] = 'col-md-';
                    $walletPaymentForm->developerTags['fld_default_col'] = 12;
                    echo $walletPaymentForm->getFormTag();
                    echo $walletPaymentForm->getFieldHTML('btn_submit');
                    echo $walletPaymentForm->getExternalJS();
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
        </div>
    <?php } ?>
<?php } ?>