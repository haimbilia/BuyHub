<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_APPLY_PROMO_COUPONS', $siteLangId); ?></h5>
</div>
<div class="modal-body">
    <?php
    if (!empty($cartSummary['cartDiscounts']['coupon_code'])) { ?>
        <div class="alert alert--success">
            <a href="javascript:void(0)" class="btn-close" onclick="removePromoCode()"></a>
            <p>
                <?php echo Labels::getLabel('LBL_PROMO_CODE', $siteLangId); ?>
                <strong><?php echo $cartSummary['cartDiscounts']['coupon_code']; ?></strong>
                <?php echo Labels::getLabel('LBL_SUCCESSFULLY_APPLIED', $siteLangId); ?>
            </p>
        </div>
    <?php }

    $PromoCouponsFrm->setFormTagAttribute('class', 'form form-apply');
    $PromoCouponsFrm->setFormTagAttribute('id', 'checkoutCouponForm');
    $PromoCouponsFrm->setFormTagAttribute('onsubmit', 'applyPromoCode(this); return false;');
    $fld = $PromoCouponsFrm->getField('coupon_code');
    $fld->addFieldTagAttribute('class', 'couponCodeJs');
    $PromoCouponsFrm->setJsErrorDisplay('afterfield');

    echo $PromoCouponsFrm->getFormTag();
    echo $PromoCouponsFrm->getFieldHtml('coupon_code');
    echo $PromoCouponsFrm->getFieldHtml('btn_submit');
    echo $PromoCouponsFrm->getExternalJs();
    ?>
    </form>
    <div class="row">
        <?php if ($couponsList) { ?>
            <div class="col-md-12">
                <h6 class="h6">
                    <?php echo Labels::getLabel("LBL_AVAILABLE_COUPONS", $siteLangId); ?>
                </h6>
            </div>
            <div class="col-md-12">
                <ul class="coupon-offers">
                    <?php $counter = 1;
                    foreach ($couponsList as $coupon_id => $coupon) {    ?>
                        <li>
                            <div class="coupon-code" onclick="triggerApplyCoupon('<?php echo $coupon['coupon_code']; ?>');" title="<?php echo Labels::getLabel("LBL_Click_to_apply_coupon", $siteLangId); ?>">
                                <?php echo $coupon['coupon_code']; ?></div>
                            <?php if ($coupon['coupon_description'] != '') { ?>
                                <p><?php echo $coupon['coupon_description']; ?> </p>
                            <?php } ?>
                        </li>
                    <?php $counter++;
                    } ?>
                </ul>
            </div>
        <?php } else { ?>
            <div class="col-md-12">
                <?php echo Labels::getLabel("LBL_NO_COPONS_OFFER_IS_AVAILABLE_NOW.", $siteLangId); ?>
            </div>
        <?php } ?>
    </div>
</div>