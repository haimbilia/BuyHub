<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$transferBank = (isset($order['plugin_code']) && 'TransferBank' == $order['plugin_code']);

$cartTotal = $shippingCharges = $totalTax = $volDiscount = $discount = $rewards = $netAmount = $selProdTotalSpecialPrice = $op_tax_after_discount = 0;
$taxOptionsTotal = [];

$fulfillmentType = 0;
foreach ($order['products'] as $op) {
    $selProdTotalSpecialPrice += $op['op_special_price'] * $op["op_qty"];
    $cartTotal = $cartTotal + CommonHelper::orderProductAmount($op, 'CART_TOTAL');
    $shippingCharges = $shippingCharges + CommonHelper::orderProductAmount($op, 'SHIPPING');
    $volDiscount = $volDiscount + CommonHelper::orderProductAmount($op, 'VOLUME_DISCOUNT');
    $discount = $discount + CommonHelper::orderProductAmount($op, 'DISCOUNT');
    $rewards = $rewards + CommonHelper::orderProductAmount($op, 'REWARDPOINT');
    $netAmount = $netAmount + CommonHelper::orderProductAmount($op, 'NETAMOUNT');
    if (1 > $fulfillmentType) {
        $fulfillmentType = $op['opshipping_fulfillment_type'];
    }
    if (empty($op['taxOptions'])) {
        $totalTax = $totalTax + CommonHelper::orderProductAmount($op, 'TAX');
    } else {
        foreach ($op['taxOptions'] as $key => $val) {
            $totalTax = $totalTax + $val['value'];

            if (!isset($taxOptionsTotal[$key]['value'])) {
                $taxOptionsTotal[$key]['value'] = 0;
            }
            $taxOptionsTotal[$key]['value'] += $val['value'];
            $taxOptionsTotal[$key]['title'] = CommonHelper::displayTaxPercantage($val);
        }
    }
    $op_tax_after_discount = $op['op_tax_after_discount'] ?? 0;
}
$totalSaving = $selProdTotalSpecialPrice + $order['order_discount_total'] + $order['order_volume_discount_total'];
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
                <?php if (!empty($fulfillmentType)) { ?>
                    <li>
                        <span class="label"><?php echo Labels::getLabel('LBL_FULFILLMENT_TYPE', $siteLangId); ?></span>
                        <span class="value">
                            <span class="badge badge-success">
                                <?php
                                $fulfillmentTypeArr = Shipping::getFulFillmentArr($siteLangId, $fulfillmentType);
                                echo $fulfillmentTypeArr[$fulfillmentType];
                                ?>
                            </span>
                        </span>
                    </li>
                <?php } ?>
                <li>
                    <span class="label"><?php echo Labels::getLabel('LBL_ADDED_ON', $siteLangId); ?></span>
                    <span class="value"><?php echo FatDate::format($order['order_date_added']); ?></span>
                </li>
                <li>
                    <span class="label"><?php echo Labels::getLabel('Lbl_Cart_Total', $siteLangId) ?></span>
                    <span class="value">
                        <span class="currency-value" dir="ltr">
                            <?php echo CommonHelper::displayMoneyFormat($cartTotal, true, false, true, false, true); ?>
                        </span>
                    </span>
                </li>
                <?php
                $volDiscount = (0 < $opSellerId) ? abs($volDiscount) : $order['order_volume_discount_total'];
                if (0 < $volDiscount) { ?>
                    <li class="discounted">
                        <span class="label">
                            <?php
                            if (1 == count($order['products'])) {
                                echo Labels::getLabel('LBL_VOLUME_DISCOUNT', $siteLangId);
                            } else { ?>
                                <a class="link-dotted" href="javascript:void(0)" onclick="loadOpVolDiscount('<?php echo $order['order_id']; ?>', <?php echo OrderProduct::CHARGE_TYPE_VOLUME_DISCOUNT; ?>)">
                                    <?php echo Labels::getLabel('LBL_VOLUME_DISCOUNT', $siteLangId);  ?>
                                </a>
                            <?php } ?>
                        </span>
                        <span class="value">
                            <?php echo '-' . CommonHelper::displayMoneyFormat($volDiscount, true, false, true, false, true); ?>
                        </span>
                    </li>
                <?php }                 
                if($op_tax_after_discount){
                    $discount = (0 < $opSellerId) ? abs($discount) : $order['order_discount_total'];
                    if (0 < $discount) { ?>
                        <li class="discounted">
                            <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId) ?></span>
                            <span class="value">
                                <?php echo '-' . CommonHelper::displayMoneyFormat($discount, true, false, true, false, true); ?>
                            </span>
                        </li>
                    <?php } 
                    $rewards = (0 < $opSellerId) ? abs($rewards) : $order['order_reward_point_value'];
                    if (0 < $rewards) { ?>
                        <li class="discounted">
                            <span class="label">
                                <?php
                                if (1 == count($order['products'])) {
                                    echo Labels::getLabel('LBL_REWARD_POINTS_DISCOUNT', $siteLangId);
                                } else { ?>
                                    <a class="link-dotted" href="javascript:void(0)" onclick="loadOpRewards('<?php echo $order['order_id']; ?>', <?php echo OrderProduct::CHARGE_TYPE_REWARD_POINT_DISCOUNT; ?>)">
                                        <?php echo Labels::getLabel('LBL_REWARD_POINTS_DISCOUNT', $siteLangId); ?>
                                    </a>
                                <?php } ?>
                            </span>
                            <span class="value">
                                <?php echo '-' . CommonHelper::displayMoneyFormat($rewards, true, false, true, false, true); ?>
                            </span>
                        </li>
                    <?php }
                } 
                if (0 < $totalTax) { ?>
                    <li>
                        <span class="label">                         
                        <a class="link-dotted" href="javascript:void(0)" onclick="loadOpTaxCharges('<?php echo $order['order_id']; ?>', <?php echo OrderProduct::CHARGE_TYPE_TAX; ?>)">
                             <?php echo Labels::getLabel('LBL_Tax_Charges', $siteLangId); ?>
                         </a>
                        </span>
                        <span class="value">
                            <span class="currency-value" dir="ltr">
                                <?php echo CommonHelper::displayMoneyFormat($totalTax, true, false, true, false, true); ?>
                            </span>
                        </span>
                    </li>
                <?php }
                if(!$op_tax_after_discount){
                $discount = (0 < $opSellerId) ? abs($discount) : $order['order_discount_total'];
                if (0 < $discount) { ?>
                    <li class="discounted">
                        <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId) ?></span>
                        <span class="value">
                            <?php echo '-' . CommonHelper::displayMoneyFormat($discount, true, false, true, false, true); ?>
                        </span>
                    </li>
                <?php } 
                $rewards = (0 < $opSellerId) ? abs($rewards) : $order['order_reward_point_value'];
                if (0 < $rewards) { ?>
                    <li class="discounted">
                        <span class="label">
                            <?php
                            if (1 == count($order['products'])) {
                                echo Labels::getLabel('LBL_REWARD_POINTS_DISCOUNT', $siteLangId);
                            } else { ?>
                                <a class="link-dotted" href="javascript:void(0)" onclick="loadOpRewards('<?php echo $order['order_id']; ?>', <?php echo OrderProduct::CHARGE_TYPE_REWARD_POINT_DISCOUNT; ?>)">
                                    <?php echo Labels::getLabel('LBL_REWARD_POINTS_DISCOUNT', $siteLangId); ?>
                                </a>
                            <?php } ?>
                        </span>
                        <span class="value">
                            <?php echo '-' . CommonHelper::displayMoneyFormat($rewards, true, false, true, false, true); ?>
                        </span>
                    </li>
                <?php }
            } ?>






                <?php if (0 < $shippingCharges) { ?>
                    <li>
                        <span class="label">
                            <?php
                            if (1 == count($order['products'])) {
                                echo Labels::getLabel('LBL_Shipping_Charges', $siteLangId);
                            } else { ?>
                                <a class="link-dotted" href="javascript:void(0)" onclick="loadOpShippingCharges('<?php echo $order['order_id']; ?>', <?php echo OrderProduct::CHARGE_TYPE_SHIPPING; ?>)">
                                    <?php echo Labels::getLabel('LBL_Shipping_Charges', $siteLangId); ?>
                                </a>
                            <?php } ?>
                        </span>
                        <span class="value">
                            <span class="currency-value" dir="ltr">
                                <?php echo CommonHelper::displayMoneyFormat($shippingCharges, true, false, true, false, true); ?>
                            </span>
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
                <?php if (0 < $totalSaving) { ?>
                    <li>
                        <span class="label text-success">
                            <?php echo Labels::getLabel('LBL_TOTAL_SAVING', $siteLangId); ?>
                        </span>
                        <span class="value text-success">
                            <?php echo CommonHelper::displayMoneyFormat($totalSaving, true, false, true, false, true); ?>
                        </span>
                    </li>
                <?php } ?>
                <?php $netAmount = (0 < $opSellerId) ? $netAmount : $order['order_net_amount']; ?>
                <li class="highlighted">
                    <span class="label"><?php echo Labels::getLabel('LBL_NET_AMOUNT', $siteLangId) ?></span>
                    <span class="value">
                        <?php echo CommonHelper::displayMoneyFormat($netAmount, true, false, true, false, true); ?>
                    </span>
                </li>
                <li>
                    <span class="label"><?php echo Labels::getLabel('LBL_SITE_COMMISSION', $siteLangId) ?></span>
                    <span class="value">
                        <?php echo CommonHelper::displayMoneyFormat($order['order_site_commission'], true, true); ?>
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>