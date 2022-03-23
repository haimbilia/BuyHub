<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (!empty($cartSummary['cartDiscounts']['coupon_code'])) { ?>
    <div class="coupons-applied">
        <h6 class="coupons-applied-title">
            <?php echo Labels::getLabel('LBL_Code:', $siteLangId); ?><?php echo $cartSummary['cartDiscounts']['coupon_code']; ?>
            <button class="btn-close" onClick="removePromoCode()"></button>
        </h6>
        <p class="coupons-applied-desc">
            <?php $arr =  ['{AMOUNT}' => CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total'])];
            echo CommonHelper::replaceStringData(Labels::getLabel("LBL_YOU_SAVED_ADDITIONAL_{AMOUNT}", $siteLangId), $arr); ?>
        </p>
    </div>
<?php } else { ?>
    <div class="cart-total-body">
        <div class="promotional-code">
            <div class="promotional-code-head">
                <h5 class="promotional-code-title">
                    <?php echo Labels::getLabel('LBL_PROMOTIONAL_CODE', $siteLangId); ?>
                </h5>
                <button class="link-underline" onclick="getPromoCode()">
                    <?php echo Labels::getLabel('LBL_VIEW_PROMOTIONS', $siteLangId); ?>
                </button>
            </div>

            <?php
            $PromoCouponsFrm->setFormTagAttribute('class', 'form');
            $PromoCouponsFrm->setFormTagAttribute('onsubmit', 'applyPromoCode(this); return false;');
            $fld = $PromoCouponsFrm->getField('btn_submit');
            $fld->setFieldTagAttribute('class', 'btn btn-secondary btn-wide');
            $PromoCouponsFrm->setJsErrorDisplay('afterfield');
            echo $PromoCouponsFrm->getFormTag(); ?>
            <div class="input-group">
                <?php echo $PromoCouponsFrm->getFieldHtml('coupon_code'); ?>
                <div class="input-group-append">
                    <?php echo $PromoCouponsFrm->getFieldHtml('btn_submit'); ?>
                </div>
            </div>
            </form>
            <?php echo $PromoCouponsFrm->getExternalJs(); ?>

        </div>
    </div>
<?php } ?>
<div class="cart-total-head">
    <h3 class="cart-total-title">
        <?php echo Labels::getLabel('LBL_Price', $siteLangId); ?>
    </h3>
</div>
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
                <span class="value txt-success"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartVolumeDiscount']); ?></span>
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
</div>
<?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
    <p class="included"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $cartSummary['orderNetAmount']); ?>
    </p>

<?php } ?>