<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="cart-total-head">
    <h3 class="cart-total-title">
        <?php echo Labels::getLabel('LBL_PRICE_SUMMARY', $siteLangId); ?>
    </h3>
</div>
<div class="cart-total-body">
    <ul class="cart-summary">
        <li class="cart-summary-item">
            <span class="label"><?php echo Labels::getLabel('LBL_CART_TOTAL', $siteLangId); ?></span> <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal'], true, false, true, false, true); ?></span>
        </li>
        <?php if ($cartSummary['cartVolumeDiscount']) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Loyalty/Volume_Discount', $siteLangId); ?>
                </span>
                <span class="value">-<?php echo CommonHelper::displayMoneyFormat($cartSummary['cartVolumeDiscount'], true, false, true, false, true); ?></span>
            </li>
        <?php } ?>
        <?php if (FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0) && !empty($cartSummary['cartDiscounts'])) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></span>
                <span class="value">-<?php echo CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total'], true, false, true, false, true); ?></span>
            </li>
        <?php } ?>
        <?php if (isset($cartSummary['taxOptions'])) {
            foreach ($cartSummary['taxOptions'] as $taxName => $taxVal) { ?>
                <li class="cart-summary-item">
                    <span class="label"><?php echo $taxVal['title']; ?></span>
                    <span class="value"><?php echo CommonHelper::displayMoneyFormat($taxVal['value'], true, false, true, false, true); ?></span>
                </li>
        <?php }
        } ?>
        <?php if ($cartSummary['originalShipping']) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_SHIPPING_CHARGES', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['shippingTotal'], true, false, true, false, true); ?></span>
            </li>
        <?php  } ?>

        <?php if (!FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0) && !empty($cartSummary['cartDiscounts'])) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat(-$cartSummary['cartDiscounts']['coupon_discount_total'], true, false, true, false, true); ?></span>
            </li>
        <?php } ?>
        <?php if (!empty($cartSummary['cartRewardPoints'])) {
            $appliedRewardPointsDiscount =  CommonHelper::convertRewardPointToCurrency($cartSummary['cartRewardPoints']);
        ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Reward_point_discount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat(-$appliedRewardPointsDiscount, true, false, true, false, true); ?></span>
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
                <span class="value txt-secondary"><?php echo CommonHelper::displayMoneyFormat($cartSummary['totalSaving'], true, false, true, false, true); ?></span>
            </li>
        <?php } ?>
        <?php $orderNetAmt = $cartSummary['orderNetAmount']; ?>
        <li class="cart-summary-item highlighted">
            <span class="label"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?></span>
            <span class="value"><?php echo CommonHelper::displayMoneyFormat($orderNetAmt, true, false, true, false, true); ?></span>
        </li>
        <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
            <p class="form-text text-muted mt-1"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $orderNetAmt); ?> </p>
        <?php } ?>
    </ul>

    <?php if (1 > $isShippingSelected) { ?>
        <!-- Used for Mobile/Tab View -->
        <div class="checkout-bottom">
            <div class="amount">
                <strong><?php echo CommonHelper::displayMoneyFormat($orderNetAmt); ?></strong>
                <button class="link-underline" onClick="scrollToFinancialSummary();">
                    <?php echo Labels::getLabel('LBL_SUMMARY', $siteLangId); ?>
                </button>
            </div>
            <div class="further-actions">
                <?php if ($cartHasPhysicalProduct) {
                    $fn = Shipping::FULFILMENT_SHIP == $fulfillmentType ? 'setUpShippingMethod();' : 'setUpPickup();'; ?>
                    <button class="btn btn-brand btn-wide" type="button" onclick="<?php echo $fn; ?>">
                        <?php echo Labels::getLabel('LBL_Continue', $siteLangId); ?>
                    </button>
                <?php } else { ?>
                    <button class="btn btn-brand btn-wide" type="button" onclick="loadFinancialSummary(1);loadPaymentSummary();">
                        <?php echo Labels::getLabel('LBL_Continue', $siteLangId); ?>
                    </button>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
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
<?php } ?>