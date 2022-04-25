<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$transferBank = (isset($order['plugin_code']) && 'TransferBank' == $order['plugin_code']);
$cartTotal = 0;
foreach ($order['items'] as $oitem) {
    $cartTotal += $oitem['ossubs_price'];
}
?>

<div class="card orderSummaryJs">
    <div class="card-head">
        <div class="card-head-label">
            <h3 class="card-head-title">
                <i class="fas fa-file"></i> <?php echo Labels::getLabel('LBL_ORDER_SUMMARY', $siteLangId); ?>
            </h3>
        </div>
    </div>
    <div class="card-body">
        <div class="cart-summary">
            <ul>
                <li>
                    <span class="label"><?php echo Labels::getLabel('LBL_ADDED_ON', $siteLangId); ?></span>
                    <span class="value"><?php echo FatDate::format($order['order_date_added']); ?></span>
                </li>
                <li>
                    <span class="label"><?php echo Labels::getLabel('LBL_CART_TOTAL', $siteLangId); ?></span>
                    <span class="value">
                        <?php echo CommonHelper::displayMoneyFormat($cartTotal, true, false, true, false, true); ?>
                    </span>
                </li>
                <?php
                $adjustedAmount = CommonHelper::orderSubscriptionAmount($order, 'ADJUSTEDAMOUNT');
                if ($adjustedAmount != 0) {
                ?>
                    <li>
                        <span class="label"><?php echo Labels::getLabel('LBL_ADJUSTED_AMOUNT', $siteLangId); ?></span>
                        <span class="value">
                            <?php echo CommonHelper::displayMoneyFormat(CommonHelper::orderSubscriptionAmount($order, 'ADJUSTEDAMOUNT'), true, false, true, false, true); ?>
                        </span>
                    </li>
                <?php
                }
                if (0 < $order['order_discount_total']) { ?>
                    <li class="discounted">
                        <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId) ?></span>
                        <span class="value">
                            <?php echo '-' . CommonHelper::displayMoneyFormat($order['order_discount_total'], true, false, true, false, true); ?>
                        </span>
                    </li>
                <?php } ?>
                <?php
                if (0 < $order['order_reward_point_value']) { ?>
                    <li class="discounted">
                        <span class="label">
                            <?php echo Labels::getLabel('LBL_REWARD_POINTS_DISCOUNT', $siteLangId); ?>
                        </span>
                        <span class="value">
                            <?php echo '-' . CommonHelper::displayMoneyFormat($order['order_reward_point_value'], true, false, true, false, true); ?>
                        </span>
                    </li>
                <?php } ?>
                <?php if (array_key_exists('order_rounding_off', $order) && 0 != $order['order_rounding_off']) { ?>
                    <li>
                        <span class="label">
                            <?php echo (0 < $order['order_rounding_off']) ? Labels::getLabel('LBL_Rounding_Up', $siteLangId) : Labels::getLabel('LBL_Rounding_Down', $siteLangId); ?>
                        </span>
                        <span class="value">
                            <?php echo CommonHelper::displayMoneyFormat($order['order_rounding_off'], true, false, true, false, true); ?>
                        </span>
                    </li>
                <?php } ?>
                <li class="highlighted">
                    <span class="label"><?php echo Labels::getLabel('LBL_NET_AMOUNT', $siteLangId) ?></span>
                    <span class="value">
                        <?php echo CommonHelper::displayMoneyFormat($order['order_net_amount'], true, false, true, false, true); ?>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>