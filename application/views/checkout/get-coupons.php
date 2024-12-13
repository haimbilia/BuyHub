<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_AVAILABLE_COUPONS', $siteLangId); ?></h5>
</div>
<div class="modal-body p-0">
    <?php if ($couponsList) { ?>
        <ul class="coupon-offers m-5">
            <?php $counter = 1;
            foreach ($couponsList as $coupon_id => $coupon) { ?>
                <li class="coupon-offers-item">
                    <div class="coupon-code" onclick="triggerApplyCoupon('<?php echo $coupon['coupon_code']; ?>');"
                        title="<?php echo Labels::getLabel("LBL_Click_to_apply_coupon", $siteLangId); ?>">
                        <?php echo $coupon['coupon_code']; ?>
                    </div>
                    <?php if ($coupon['coupon_description'] != '') { ?>
                        <p><?php echo $coupon['coupon_description']; ?> </p>
                    <?php } ?>
                </li>
                <?php $counter++;
            } ?>
        </ul>
    <?php } else { ?>
        <?php echo Labels::getLabel("LBL_NO_COPONS_OFFER_IS_AVAILABLE_NOW.", $siteLangId); ?>
    <?php } ?>
</div>