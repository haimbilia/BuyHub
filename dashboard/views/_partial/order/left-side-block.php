<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$canViewShippingCharges = isset($canViewShippingCharges) ? $canViewShippingCharges : false;
$canViewTaxCharges = isset($canViewTaxCharges) ? $canViewTaxCharges : false;
$primaryOrder = isset($primaryOrder) ? $primaryOrder : true;

$transferBank = (isset($orderDetail['plugin_code']) && 'TransferBank' == $orderDetail['plugin_code']);
$cartTotal = 0;
$shippingCharges = 0;
$totalTax = 0;

foreach ($arr as $childOrder) {
    $cartTotal = $cartTotal + CommonHelper::orderProductAmount($childOrder, 'cart_total');
    $shippingCharges = $shippingCharges + CommonHelper::orderProductAmount($childOrder, 'shipping');
    if (empty($childOrder['taxOptions'])) {
        $totalTax = $totalTax + CommonHelper::orderProductAmount($childOrder, 'TAX');
    } else {
        foreach ($childOrder['taxOptions'] as $key => $val) {
            $totalTax = $totalTax + $val['value'];
        }
    }
}
?>
<div class="col-md-4">
    <div class="ml-md-4">
        <div class="order-block">
            <h4><?php echo Labels::getLabel('LBL_ORDER_SUMMARY', $siteLangId); ?></h4>
            <div class="cart-summary">
                <ul>
                    <?php if (isset($orderDetail['user_name'])) { ?>
                        <li>
                            <span class="label"><?php echo Labels::getLabel('LBL_Customer_Name', $siteLangId); ?> </span>
                            <span class="value"><?php echo $orderDetail['user_name']; ?></span>
                        </li>
                    <?php } ?>
                    <li>
                        <span class="label"><?php echo Labels::getLabel('MSG_Order_Created', $siteLangId); ?> </span>
                        <span class="value"><?php echo FatDate::format($orderDetail['order_date_added']); ?></span>
                    </li>
                    <?php if (0 < $shippingCharges && true == $canViewShippingCharges) { ?>
                        <li>
                            <span class="label">
                                <?php if (true === $primaryOrder) {
                                    echo Labels::getLabel('LBL_Shipping_Charges', $siteLangId);
                                } else { ?>
                                    <a class="dotted" href="javascript:void(0)" onclick="loadOpShippingCharges('<?php echo $orderDetail['order_id']; ?>', <?php echo OrderProduct::CHARGE_TYPE_SHIPPING; ?>)">
                                        <?php echo Labels::getLabel('LBL_Shipping_Charges', $siteLangId); ?>
                                    </a>
                                <?php } ?>
                            </span>
                            <span class="value">
                                <?php echo CommonHelper::displayMoneyFormat($shippingCharges, true, false, true, false, true); ?>
                            </span>
                        </li>
                    <?php } ?>

                    <?php if (true == $canViewTaxCharges) { ?>
                        <li>
                            <span class="label">
                                <?php if (true === $primaryOrder) {
                                    echo Labels::getLabel('LBL_Tax_Charges', $siteLangId);
                                } else { ?>
                                    <a class="dotted" href="javascript:void(0)" onclick="loadOpTaxCharges('<?php echo $orderDetail['order_id']; ?>', <?php echo OrderProduct::CHARGE_TYPE_TAX; ?>)">
                                        <?php echo Labels::getLabel('LBL_Tax_Charges', $siteLangId); ?>
                                    </a>
                                <?php } ?>
                            </span>
                            <span class="value"><?php echo CommonHelper::displayMoneyFormat($totalTax, true, false, true, false, true); ?></span>
                        </li>
                    <?php } ?>
                    <li>
                        <span class="label"><?php echo Labels::getLabel('Lbl_Cart_Total', $siteLangId) ?></span>
                        <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartTotal, true, false, true, false, true); ?></span>
                    </li>
                    <?php 
                    $discount = true === $primaryOrder ? abs(CommonHelper::orderProductAmount($childOrderDetail, 'DISCOUNT', true)) : $orderDetail['order_discount_total'];
                    if (0 < $discount) { ?>
                        <li class="discounted">
                            <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId) ?></span>
                            <span class="value">
                                <?php echo '-' . CommonHelper::displayMoneyFormat($discount, true, false, true, false, true); ?>
                            </span>
                        </li>
                    <?php } ?>
                    <?php 
                    $volDiscount = true === $primaryOrder ? abs(CommonHelper::orderProductAmount($childOrderDetail, 'VOLUME_DISCOUNT', true)) : $orderDetail['order_volume_discount_total'];
                    if (0 < $volDiscount) { ?>
                        <li class="discounted">
                            <span class="label"><?php echo Labels::getLabel('LBL_VOLUME/LOYALTY_DISCOUNT', $siteLangId);  ?></span>
                            <span class="value">
                                <?php echo '-' . CommonHelper::displayMoneyFormat($volDiscount, true, false, true, false, true); ?>
                            </span>
                        </li>
                    <?php } ?>
                    <?php 
                    $rewards = true === $primaryOrder ? abs(CommonHelper::orderProductAmount($childOrderDetail, 'REWARDPOINT', true)) : $orderDetail['order_reward_point_value'];
                    if (0 < $rewards) { ?>
                        <li class="discounted">
                            <span class="label"><?php echo Labels::getLabel('LBL_REWARD_POINTS_DISCOUNT', $siteLangId); ?> </span>
                            <span class="value">
                                    <?php echo '-' . CommonHelper::displayMoneyFormat($rewards, true, false, true, false, true); ?>
                            </span>
                        </li>
                    <?php } ?>
                    <?php if (array_key_exists('order_rounding_off', $orderDetail) && 0 != $orderDetail['order_rounding_off']) { ?>
                        <li>
                            <span class="label">
                                <?php echo (0 < $orderDetail['order_rounding_off']) ? Labels::getLabel('LBL_Rounding_Up', $siteLangId) : Labels::getLabel('LBL_Rounding_Down', $siteLangId); ?>
                            </span>
                            <span class="value">
                                <?php echo CommonHelper::displayMoneyFormat($orderDetail['order_rounding_off'], true, false, true, false, true); ?>
                            </span>
                        </li>
                    <?php } ?>
                    <li class="highlighted">
                        <span class="label"><?php echo Labels::getLabel('LBL_NET_AMOUNT', $siteLangId) ?></span>
                        <span class="value">
                            <?php 
                                if (true === $primaryOrder) {
                                    echo CommonHelper::orderProductAmount($childOrderDetail, 'NETAMOUNT', true);
                                } else {
                                    echo CommonHelper::displayMoneyFormat($orderDetail['order_net_amount'], true, false, true, false, true);
                                }
                            ?>
                        </span>
                    </li>
                </ul>
            </div>

        </div>
        <?php if (isset($totalSaving) && 0 < $totalSaving) { ?>
            <div class="total-savings">
                <img class="total-savings-img" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/savings.svg" alt="">
                <p><?php echo Labels::getLabel('MSG_YOUR_TOTAL_SAVINGS_AMOUNT_ON_THIS_ORDER', $siteLangId); ?></p>
                <span class="amount"><?php echo CommonHelper::displayMoneyFormat($totalSaving, true, false, true, false, true); ?></span>

            </div>
        <?php } ?>

        <?php if (isset($orderDetail['op_product_dimension_unit']) && isset($unitTypeArray[$orderDetail['op_product_dimension_unit']])) { ?>
            <div class="order-block">
                <h4><?php echo Labels::getLabel('LBL_PACKAGE_DETAIL', $siteLangId); ?></h4>
                <div class="order-block-data">
                    <?php 
                        $data = $this->variables + [
                            'unitType' => $unitTypeArray[$orderDetail['op_product_dimension_unit']],
                        ];
                        $this->includeTemplate('_partial/order/package-detail.php', $data, false);
                    ?>
                </div>
            </div>
        <?php } ?>

        <?php if (!empty($orderDetail['shippingAddress']) && $productType != Product::PRODUCT_TYPE_DIGITAL) { ?>
            <div class="order-block">
                <h4><?php echo Labels::getLabel('LBL_Shipping_ADDRESS', $siteLangId); ?></h4>
                <div class="order-block-data">
                    <?php 
                        $data = $this->variables + [
                            'address' => $orderDetail['shippingAddress'],
                        ];
                        $this->includeTemplate('_partial/order/address.php', $data, false);
                    ?>
                </div>
            </div>
        <?php } ?>
        <div class="order-block">
            <h4 class="dropdown-toggle-custom collapsed" data-toggle="collapse" data-target="#order-block2" aria-expanded="false" aria-controls="order-block2">
                <?php echo Labels::getLabel('LBL_Billing_ADDRESS', $siteLangId); ?>: <i class="dropdown-toggle-custom-arrow"></i></h4>
            <div class="collapse" id="order-block2">
                <div class="order-block-data">
                    <?php 
                        $data = $this->variables + [
                            'address' => $orderDetail['billingAddress'],
                        ];
                        $this->includeTemplate('_partial/order/address.php', $data, false);
                    ?>
                </div>
            </div>

        </div>
        <?php if ($primaryOrder && !empty($orderDetail['pickupAddress'])) { ?>
            <div class="order-block">
                <h4 class="dropdown-toggle-custom collapsed" data-toggle="collapse" data-target="#order-block3" aria-expanded="false" aria-controls="order-block3">
                    <?php echo Labels::getLabel('LBL_PICKUP_ADDRESS', $siteLangId); ?>:
                    <i class="dropdown-toggle-custom-arrow"></i>
                </h4>
                <div class="collapse" id="order-block3">
                    <div class="order-block-data">
                        <?php 
                            $data = $this->variables + [
                                'address' => $orderDetail['pickupAddress'],
                            ];
                            $this->includeTemplate('_partial/order/address.php', $data, false);
                        ?>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php if (!empty($pickUpDetails) && 0 < $pickUpDetails['opsp_scheduled']) {
            $pickUpPostedDetails = json_decode($pickUpDetails['opsp_requested_data'], true);
            $pickUpflds = $shippingApiObj->getPickupFormElementsArr();
        ?>
            <div class="order-block">
                <h4 class="dropdown-toggle-custom collapsed" data-toggle="collapse" data-target="#order-block7" aria-expanded="false" aria-controls="order-block3">
                    <?php echo Labels::getLabel('LBL_PICKUP_TIMING', $siteLangId); ?>:
                    <i class="dropdown-toggle-custom-arrow"></i>
                </h4>
                <div class="collapse" id="order-block7">
                    <div class="order-block-data">
                        <div class="list-specification">
                            <ul>
                                <?php foreach ($pickUpflds as $fldName => $fldVal) {
                                    if (!isset($pickUpPostedDetails[$fldName])) {
                                        continue;
                                    } ?>
                                    <li>
                                        <span class="label"><?php echo $fldVal['label']; ?></span>
                                        <span class="value"><?php echo $pickUpPostedDetails[$fldName]; ?></span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>


        <?php if (true === $primaryOrder) {
            $selected_method = '';
            if ($childOrderDetail['order_pmethod_id'] > 0) {
                $selected_method .= empty($childOrderDetail["plugin_name"]) ? CommonHelper::displayNotApplicable($siteLangId, $childOrderDetail["plugin_code"]) : $childOrderDetail["plugin_name"];
            }
            if ($childOrderDetail['order_is_wallet_selected'] > 0) {
                $selected_method .= ($selected_method != '') ? ' + ' . Labels::getLabel("LBL_Wallet", $siteLangId) : Labels::getLabel("LBL_Wallet", $siteLangId);
            }
            if ($childOrderDetail['order_reward_point_used'] > 0) {
                $selected_method .= ($selected_method != '') ? ' + ' . Labels::getLabel("LBL_Rewards", $siteLangId) : Labels::getLabel("LBL_Rewards", $siteLangId);
            }

            if (in_array(strtolower($childOrderDetail['plugin_code']), ['cashondelivery', 'payatstore'])) {
                $selected_method = (empty($childOrderDetail['plugin_name'])) ? $childOrderDetail['plugin_identifier'] : $childOrderDetail['plugin_name'];
            } ?>
            <div class="order-block">
                <h4 class="dropdown-toggle-custom collapsed" data-toggle="collapse" data-target="#order-block5" aria-expanded="false" aria-controls="order-block3">
                    <?php echo Labels::getLabel('LBL_PAYMENT_METHOD', $siteLangId); ?>:
                    <i class="dropdown-toggle-custom-arrow"></i>
                </h4>
                <div class="collapse" id="order-block5">
                    <div class="order-block-data">
                        <div class="list-specification">
                            <ul>
                                <li>
                                    <span class="label"><?php echo Labels::getLabel('LBL_Payment_Method', $siteLangId); ?></span>
                                    <span class="value"><?php echo $selected_method; ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>

        <?php
        if (true == $transferBank) {
            $pluginSettingsObj = new PluginSetting(0, 'TransferBank');
            $settings = $pluginSettingsObj->get($siteLangId);
        ?>
            <div class="order-block">
                <h4 class="dropdown-toggle-custom collapsed" data-toggle="collapse" data-target="#order-block4" aria-expanded="false" aria-controls="order-block3">
                    <?php echo Labels::getLabel('LBL_BANK_DETAIL', $siteLangId); ?>:
                    <i class="dropdown-toggle-custom-arrow"></i>
                </h4>
                <div class="collapse" id="order-block4">
                    <div class="order-block-data">
                        <div class="list-specification">
                            <ul>
                                <li>
                                    <span class="label"><?php echo Labels::getLabel('LBL_BUSSINESS_NAME', $siteLangId); ?></span>
                                    <span class="value"><?php echo $settings['business_name']; ?></span>

                                </li>
                                <li>
                                    <span class="label"><?php echo Labels::getLabel('LBL_BANK_NAME', $siteLangId); ?></span>
                                    <span class="value"><?php echo $settings['bank_name']; ?></span>

                                </li>
                                <li>
                                    <span class="label"><?php echo Labels::getLabel('LBL_BANK_BRANCH', $siteLangId); ?></span>
                                    <span class="value"><?php echo $settings['bank_branch']; ?></span>

                                </li>
                                <li>
                                    <span class="label"><?php echo Labels::getLabel('LBL_ACCOUNT_#', $siteLangId); ?></span>
                                    <span class="value"><?php echo $settings['account_number']; ?></span>

                                </li>
                                <li>
                                    <span class="label"><?php echo Labels::getLabel('LBL_IFSC_/_MICR', $siteLangId); ?></span>
                                    <span class="value"><?php echo $settings['ifsc']; ?></span>

                                </li>
                                <?php if (!empty($settings['routing'])) { ?>
                                    <li>
                                        <span class="label"><?php echo Labels::getLabel('LBL_ROUTING_#', $siteLangId); ?></span>
                                        <span class="value"><?php echo $settings['routing']; ?></span>

                                    </li>
                                <?php } ?>
                                <?php if (!empty($settings['bank_notes'])) { ?>
                                    <li>
                                        <span class="label"><?php echo Labels::getLabel('LBL_OTHER_NOTES', $siteLangId); ?></span>
                                        <span class="value"><?php echo $settings['bank_notes']; ?></span>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php if (!empty($orderDetail['payments'])) { ?>
            <div class="order-block">
                <h4 class="dropdown-toggle-custom collapsed" data-toggle="collapse" data-target="#order-block6" aria-expanded="false" aria-controls="order-block3">
                    <?php echo Labels::getLabel('LBL_Payment_History', $siteLangId); ?>:
                    <i class="dropdown-toggle-custom-arrow"></i>
                </h4>
                <div class="collapse" id="order-block6">
                    <div class="order-block-data">
                        <div class="list-specification">
                            <?php foreach ($orderDetail['payments'] as $i => $row) { ?>
                                <ul>
                                    <li>
                                        <span class="label"><?php echo Labels::getLabel('LBL_Date_Added', $siteLangId); ?></span>
                                        <span class="value"><?php echo FatDate::format($row['opayment_date']); ?></span>
                                    </li>
                                    <li>
                                        <span class="label"><?php echo Labels::getLabel('LBL_Txn_Id', $siteLangId); ?></span>
                                        <span class="value"><?php echo $row['opayment_gateway_txn_id']; ?></span>
                                    </li>
                                    <li>
                                        <span class="label"><?php echo Labels::getLabel('LBL_Payment_Method', $siteLangId); ?></span>
                                        <span class="value"><?php echo $row['opayment_method']; ?></span>
                                    </li>
                                    <li>
                                        <span class="label"><?php echo Labels::getLabel('LBL_Amount', $siteLangId); ?></span>
                                        <span class="value"><?php echo CommonHelper::displayMoneyFormat($row['opayment_amount'], true, false, true, false, true); ?></span>
                                    </li>
                                    <li>
                                        <span class="label"><?php echo Labels::getLabel('LBL_Comments', $siteLangId); ?></span>
                                        <span class="value"><?php echo nl2br($row['opayment_comments']); ?></span>
                                    </li>
                                    <li>
                                        <span class="label"><?php echo Labels::getLabel('LBL_STATUS', $siteLangId); ?></span>
                                        <span class="value"><?php echo $orderStatusArr[$row['opayment_txn_status']]; ?></span>
                                    </li>
                                </ul>
                                <?php if (isset($orderDetail['payments'][$i + 1])) { ?>
                                    <hr class="dotted">
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>