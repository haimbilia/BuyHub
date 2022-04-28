<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if (0 < $isShippingSelected && 1 > count($paymentMethods)) {
    if ($fulfillmentType == Shipping::FULFILMENT_SHIP && $shippingAddressId == $billingAddressId) { ?>
        <div class="step_section">
            <div class="step_head">
                <label class="checkbox">
                    <input onclick="billingAddress(this);" type="checkbox" checked='checked' name="isShippingSameAsBilling" value="1">
                    <?php echo Labels::getLabel('LBL_MY_BILLING_IS_SAME_AS_SHIPPING_ADDRESS', $siteLangId); ?>
                </label>
            </div>
        </div>
    <?php } else { ?>
        <ul class="review-block">
            <li class="review-block-item">
                <div class="review-block-head">
                    <h5 class="h5">
                        <?php echo Labels::getLabel('LBL_Billing_to:', $siteLangId); ?>
                    </h5>

                    <div class="review-block-action" role="cell">
                        <button class="link-underline" onClick="loadAddressDiv(1)">
                            <span>
                                <?php echo Labels::getLabel('LBL_Edit', $siteLangId); ?>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="review-block-body" role="cell">
                    <div class="delivery-address">
                        <p><?php echo $billingAddressArr['addr_name'] . ', ' . $billingAddressArr['addr_address1']; ?>
                            <?php if (strlen($billingAddressArr['addr_address2']) > 0) {
                                echo ", " . $billingAddressArr['addr_address2']; ?>
                            <?php } ?>
                        </p>
                        <p><?php echo $billingAddressArr['addr_city'] . ", " . $billingAddressArr['state_name'] . ", " . $billingAddressArr['country_name'] . ", " . $billingAddressArr['addr_zip']; ?>
                        </p>

                        <?php if (strlen($billingAddressArr['addr_phone']) > 0) {
                            $addrPhone = ValidateElement::formatDialCode($billingAddressArr['addr_phone_dcode']) . $billingAddressArr['addr_phone'];
                        ?>
                            <p class="phone-txt"><i class="fas fa-mobile-alt"></i><?php echo $addrPhone; ?></p>
                        <?php } ?>
                    </div>
                </div>
            </li>
        </ul>
    <?php }
} ?>

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
        <?php if ($cartSummary['originalShipping']) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Delivery_Charges', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['shippingTotal']); ?></span>
            </li>
        <?php  } ?>
        <?php if ($cartSummary['cartVolumeDiscount']) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Loyalty/Volume_Discount', $siteLangId); ?>
                </span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartVolumeDiscount']); ?></span>
            </li>
        <?php } ?>
        <?php if (!FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0) && !empty($cartSummary['cartDiscounts'])) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total']); ?></span>
            </li>
        <?php } ?>
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
                <span class="value txt-secondary"><?php echo CommonHelper::displayMoneyFormat($cartSummary['totalSaving']); ?></span>
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
                <button class="btn btn-brand btn-block" type="button" onclick="loadFinancialSummary(1);loadPaymentSummary();">
                    <?php echo Labels::getLabel('LBL_Continue', $siteLangId); ?>
                </button>
            <?php } ?>
        </div>
    </div>
<?php } elseif (1 > count($paymentMethods) && 1 > $userWalletBalance) { ?>
    <div class="cart-total-foot">
        <div class="mt-4">
            <?php echo HtmlHelper::getErrorMessageHtml(Labels::getLabel('ERR_PAYMENT_METHOD_IS_NOT_AVAILABLE._PLEASE_CONTACT_YOUR_ADMINISTRATOR.', $siteLangId)); ?>
        </div>
    </div>
<?php } ?>