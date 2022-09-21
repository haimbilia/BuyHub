<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$cartTotal = isset($cartSummary['cartTotal']) ? $cartSummary['cartTotal'] : 0;
$cartAdjustableAmount = isset($cartSummary['cartAdjustableAmount']) ? $cartSummary['cartAdjustableAmount'] : 0;
$discountTotal = isset($cartSummary['cartDiscounts']) && isset($cartSummary['cartDiscounts']['coupon_discount_total']) ? $cartSummary['cartDiscounts']['coupon_discount_total'] : 0;
$amount = CommonHelper::displayMoneyFormat($cartTotal - $cartAdjustableAmount - $discountTotal, true, false, true, false, true);

$cartSubscription = current($subscriptions);
$spackage_type = $cartSubscription['spackage_type'];
?>

<div class="cart-total-head">
    <h3 class="cart-total-title">
        <?php echo Labels::getLabel('LBL_ORDER_SUMMARY', $siteLangId); ?>
    </h3>
</div>
<div class="cart-total-body">
    <ul class="list-cart list-cart-page list-shippings">
        <?php foreach ($subscriptions as $subscription) { ?>
            <li>
                <div class="row">
                    <div class="col">
                        <?php
                        $spackageName = isset($subscription['spackage_name']) ? $subscription['spackage_name'] : '';
                        $spackagePrice = isset($subscription[SellerPackagePlans::DB_TBL_PREFIX . 'price']) ? $subscription[SellerPackagePlans::DB_TBL_PREFIX . 'price'] : '';
                        $interval = isset($subscription[SellerPackagePlans::DB_TBL_PREFIX . 'trial_interval']) ? $subscription[SellerPackagePlans::DB_TBL_PREFIX . 'trial_interval'] : 0;
                        echo  $spackageName . ' / ' . SellerPackagePlans::getPlanPeriod($subscription, $spackagePrice); ?>
                    </div>
                </div>
            </li>
        <?php } ?>
    </ul>
    <?php
    if ($spackage_type != SellerPackages::FREE_TYPE) { ?>
        <div class="mt-5">
            <?php require(CONF_INSTALLATION_PATH . 'application/views/cart/_partial/coupons-section.php'); ?>
        </div>
    <?php } ?>

    <ul class="cart-summary">
        <li class="cart-summary-item">
            <span class="label"><?php echo Labels::getLabel('LBL_Sub_Total', $siteLangId); ?></span>
            <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartTotal, true, false, true, false, true); ?></span>
        </li>
        <?php if ($cartAdjustableAmount > 0) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Adjusted_Amount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartAdjustableAmount, true, false, true, false, true); ?></span>
            </li>
        <?php } ?>
        <?php if ($discountTotal > 0) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></span>
                <span class="value">
                    <?php echo CommonHelper::displayMoneyFormat($discountTotal, true, false, true, false, true); ?></span>
            </li>
        <?php } ?>
        <li class="cart-summary-item highlighted">
            <span class="label"><?php echo Labels::getLabel('LBL_You_Pay', $siteLangId); ?></span>
            <span class="value">
                <?php echo $amount; ?></span>
        </li>
    </ul>
</div>