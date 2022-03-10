<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (!empty($cartSummary['cartDiscounts']['coupon_code'])) { ?>
    <div class="coupons-applied">
        <h6 class="coupons-applied-title">
            Code: <?php echo $cartSummary['cartDiscounts']['coupon_code']; ?>
            <button class="btn-close" onClick="removePromoCode()"></button>
        </h6>
        <p class="coupons-applied-desc">
            <?php $arr =  ['{AMOUNT}' => CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total'])];
            echo CommonHelper::replaceStringData(Labels::getLabel("LBL_YOU_SAVED_ADDITIONAL_{AMOUNT}", $siteLangId), $arr); ?>
        </p>
    </div>
<?php } else { ?>
    <div class="coupons">
        <button class="btn btn-block btn-coupons" onclick="getPromoCode()">
            <i class="icn">
                <svg class="svg">
                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#coupon">
                    </use>
                </svg>
            </i>
            <span>
                <?php echo Labels::getLabel('LBL_Add_promo_code_or_gift_card', $siteLangId); ?></span></button>

    </div>
<?php } ?>
<div class="cart-total-head">
    <h3 class="cart-total-title">
        <?php echo Labels::getLabel('LBL_Price', $siteLangId); ?>
    </h3>
</div>
<ul class="cart-summary">
    <li class="cart-summary-item">
        <span class="label"><?php echo Labels::getLabel('LBL_Total', $siteLangId); ?>
        </span>
        <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal']); ?></span>
    </li>
    <?php if ($cartSummary['cartVolumeDiscount']) { ?>
        <li class="cart-summary-item">
            <span class="label"><?php echo Labels::getLabel('LBL_Volume_Discount', $siteLangId); ?></span>
            <span class="value txt-success"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartVolumeDiscount']); ?></span>
        </li>
    <?php } ?>

    <?php if (FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0) && !empty($cartSummary['cartDiscounts'])) { ?>
        <li class="cart-summary-item">
            <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></span>
            <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total']); ?></span>
        </li>
    <?php } ?>
    <?php /* if (isset($cartSummary['taxOptions']) && !empty($cartSummary['taxOptions'])) {
        foreach ($cartSummary['taxOptions'] as $taxName => $taxVal) { ?>
        <li >
            <span class="label"><?php echo $taxVal['title']; ?></span> <span
                class="value"><?php echo CommonHelper::displayMoneyFormat($taxVal['value']); ?></span>
        </li>
        <?php   }
    } */ ?>
    <?php if (!FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0) && !empty($cartSummary['cartDiscounts'])) { ?>
        <li class="cart-summary-item">
            <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></span>
            <span class="value txt-success"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total']); ?></span>
        </li>
    <?php } ?>
    <?php $netChargeAmt = $cartSummary['cartTotal'] - ((0 < $cartSummary['cartVolumeDiscount']) ? $cartSummary['cartVolumeDiscount'] : 0);
    $netChargeAmt = $netChargeAmt - ((isset($cartSummary['cartDiscounts']['coupon_discount_total']) && 0 < $cartSummary['cartDiscounts']['coupon_discount_total']) ? $cartSummary['cartDiscounts']['coupon_discount_total'] : 0); ?>
    <li class="cart-summary-item highlighted">
        <span class="label"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?></span>
        <span class="value"><?php echo CommonHelper::displayMoneyFormat($netChargeAmt); ?></span>
    </li>
</ul>


<?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
    <p class="included"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $cartSummary['orderNetAmount']); ?>
    </p>

<?php } ?>