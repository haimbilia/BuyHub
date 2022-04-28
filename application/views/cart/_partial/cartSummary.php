<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

require('coupons-section.php'); ?>
<div class="cart-total-body">
    <ul class="cart-summary">
        <li class="cart-summary-item">
            <span class="label"><?php echo Labels::getLabel('LBL_Total', $siteLangId); ?>
            </span>
            <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal']); ?></span>
        </li>
        <?php if ($cartSummary['cartVolumeDiscount']) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Volume_Discount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartVolumeDiscount']); ?></span>
            </li>
        <?php } ?>

        <?php if (FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0) && !empty($cartSummary['cartDiscounts'])) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total']); ?></span>
            </li>
        <?php } ?>
        <?php if (!FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0) && !empty($cartSummary['cartDiscounts'])) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total']); ?></span>
            </li>
        <?php } ?>
        <?php $netChargeAmt = $cartSummary['cartTotal'] - ((0 < $cartSummary['cartVolumeDiscount']) ? $cartSummary['cartVolumeDiscount'] : 0);
        $netChargeAmt = $netChargeAmt - ((isset($cartSummary['cartDiscounts']['coupon_discount_total']) && 0 < $cartSummary['cartDiscounts']['coupon_discount_total']) ? $cartSummary['cartDiscounts']['coupon_discount_total'] : 0); ?>
        <li class="cart-summary-item highlighted">
            <span class="label"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?></span>
            <span class="value"><?php echo CommonHelper::displayMoneyFormat($netChargeAmt); ?></span>
        </li>
    </ul>
    <div class="checkout-bottom">
        <div class="amount">
            <strong><?php echo CommonHelper::displayMoneyFormat($netChargeAmt); ?></strong>
            <button class="link-underline" onClick="scrollToPriceSummary();"><?php echo Labels::getLabel('LBL_VIEW_SUMMARY', $siteLangId); ?></a>
        </div>
        <button class="btn btn-brand btn-wide" type="button" onclick="goToCheckout()">
            <?php echo Labels::getLabel('LBL_Checkout', $siteLangId); ?>
        </button>
    </div>
</div>
<?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
    <p class="included">
        <?php echo CommonHelper::currencyDisclaimer($siteLangId, $cartSummary['orderNetAmount']); ?>
    </p>
<?php } ?>