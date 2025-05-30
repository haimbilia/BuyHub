<?php
if (!empty($couponsList)) {
    if (!empty($cartSummary['cartDiscounts']['coupon_code'])) { ?>
        <div class="coupons-applied">
            <button class="btn-close" onClick="removePromoCode()"></button>
            <h6 class="coupons-applied-title">
                <?php echo Labels::getLabel('LBL_Code:', $siteLangId); ?>
                <?php echo $cartSummary['cartDiscounts']['coupon_code']; ?>
            </h6>
            <p class="coupons-applied-desc">
                <?php $arr =  ['{AMOUNT}' => CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total'])];
                echo CommonHelper::replaceStringData(Labels::getLabel("LBL_YOU_SAVED_ADDITIONAL_{AMOUNT}", $siteLangId), $arr); ?>
            </p>
        </div>
    <?php } else { ?>
        <div class="promotional-code">
            <div class="promotional-code-head">
                <h5 class="promotional-code-title">
                    <?php echo Labels::getLabel('LBL_PROMOTIONAL_COUPONS', $siteLangId); ?>
                </h5>
                <button class="link-underline" onclick="getPromoCode()">
                    <?php echo Labels::getLabel('LBL_VIEW', $siteLangId); ?>
                </button>
            </div>

            <?php
            $PromoCouponsFrm->setFormTagAttribute('class', 'form form-apply');
            $PromoCouponsFrm->setFormTagAttribute('onsubmit', 'applyPromoCode(this); return false;');
            $PromoCouponsFrm->setJsErrorDisplay('afterfield');
            $fld = $PromoCouponsFrm->getField('coupon_code');
            $fld->addFieldTagAttribute('class', 'couponCodeJs');

            echo $PromoCouponsFrm->getFormTag(); ?>
            <?php echo $PromoCouponsFrm->getFieldHtml('coupon_code'); ?>
            <?php echo $PromoCouponsFrm->getFieldHtml('btn_submit'); ?>
            </form>
            <?php echo $PromoCouponsFrm->getExternalJs(); ?>
        </div>
<?php }
}
