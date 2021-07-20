<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php
if (!empty($cartSummary['cartDiscounts']['coupon_code'])) { ?>
	<div class="alert alert--success">
		<a href="javascript:void(0)" class="close" onClick="removePromoCode()"></a>
		<p><?php echo Labels::getLabel('LBL_Promo_Code', $siteLangId); ?> <strong><?php echo $cartSummary['cartDiscounts']['coupon_code']; ?></strong> <?php echo Labels::getLabel('LBL_Successfully_Applied', $siteLangId); ?></p>
	</div>
<?php } ?>

<div class="modal-header">
	<h5 class="modal-title"><?php echo Labels::getLabel('LBL_Apply_Promo_Coupons', $siteLangId); ?></h5>
</div>
<div class="modal-body">
	<?php
	$PromoCouponsFrm->setFormTagAttribute('class', 'form apply--coupon--form custom-form');
	$PromoCouponsFrm->setFormTagAttribute('onsubmit', 'applyPromoCode(this); return false;');
	$fld = $PromoCouponsFrm->getField('btn_submit');
	$fld->setFieldTagAttribute('class', 'btn btn-brand');
	$PromoCouponsFrm->setJsErrorDisplay('afterfield');
	echo $PromoCouponsFrm->getFormTag();
	echo $PromoCouponsFrm->getFieldHtml('coupon_code');
	echo $PromoCouponsFrm->getFieldHtml('btn_submit');
	echo $PromoCouponsFrm->getExternalJs();
	?>
	</form>
	<div class="row">
		<?php if ($couponsList) { ?>
			<div class="col-md-12 text-center">
				<span>
					<?php echo Labels::getLabel("LBL_Available_Coupons", $siteLangId); ?>
				</span>
			</div>
			<div class="col-md-12">
				<ul class="coupon-offers">
					<?php $counter = 1;
					foreach ($couponsList as $coupon_id => $coupon) {	?>
						<li>
							<div class="coupon-code" onClick="triggerApplyCoupon('<?php echo $coupon['coupon_code']; ?>');" title="<?php echo Labels::getLabel("LBL_Click_to_apply_coupon", $siteLangId); ?>"><?php echo $coupon['coupon_code']; ?></div>
							<?php if ($coupon['coupon_description'] != '') { ?>
								<p><?php echo $coupon['coupon_description']; ?> </p>
							<?php } ?>
						</li>
					<?php $counter++;
					} ?>
				</ul>
			</div>
		<?php } else {
			echo Labels::getLabel("LBL_No_Copons_offer_is_available_now.", $siteLangId);
		} ?>
	</div>
</div>