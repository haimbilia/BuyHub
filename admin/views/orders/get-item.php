<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$op = current($order['products']);
$shippingCost = CommonHelper::orderProductAmount($op, 'SHIPPING');
$volumeDiscount = CommonHelper::orderProductAmount($op, 'VOLUME_DISCOUNT');
$discount = CommonHelper::orderProductAmount($op, 'DISCOUNT');
$rewards = CommonHelper::orderProductAmount($op, 'REWARDPOINT');
$total = CommonHelper::orderProductAmount($op, 'cart_total') + $shippingCost + $volumeDiscount;

$op['order_id'] = $order['order_id'];
$op['order_number'] = $order['order_number'];
$op['order_date_added'] = $order['order_date_added'];

$isOrderShipped = (Shipping::FULFILMENT_PICKUP != $op['opshipping_fulfillment_type']);

$orderObj = new Orders($op['order_id']);
$addresses = $orderObj->getOrderAddresses($op['order_id'], $op['op_id']);

$totalTax = 0;
$taxOptionsTotal = [];
foreach ($op['taxOptions'] as $key => $val) {
    $totalTax = $totalTax + $val['value'];

    if (!isset($taxOptionsTotal[$key]['value'])) {
        $taxOptionsTotal[$key]['value'] = 0;
    }
    $taxOptionsTotal[$key]['value'] += $val['value'];
    $taxOptionsTotal[$key]['title'] = CommonHelper::displayTaxPercantage($val);
}
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $op['op_selprod_title']; ?>
    </h5>
</div>
<div class="modal-body opDetailsJs<?php echo $op['op_id']; ?>">
    <div class="form-edit-body loaderContainerJs">
        <ul class="list-stats list-stats-double">
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_INVOICE_NUMBER', $siteLangId); ?>:</span>
                <span class="value"><?php echo $op['op_invoice_number'] ?></span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_STORE', $siteLangId); ?>:</span>
                <span class="value"><?php echo $op['op_shop_name'] ?></span>
            </li>

            <?php if (!empty($addresses)) {
                $pickupAddress = (!empty($addresses[Orders::PICKUP_ADDRESS_TYPE])) ? $addresses[Orders::PICKUP_ADDRESS_TYPE] : array();
                $pickupAddrPhone = "";
                if (!empty($pickupAddress['oua_phone_dcode'])) {
                    $pickupAddrPhone = '<span class="default-ltr">'. ValidateElement::formatDialCode($pickupAddress['oua_phone_dcode']) . $pickupAddress['oua_phone'] . '</span>';
                }
                $contactName = $pickupAddress['oua_name'];

                unset($pickupAddress['oua_name'], $pickupAddress['oua_order_id'], $pickupAddress['oua_op_id'], $pickupAddress['oua_type'], $pickupAddress['oua_phone_dcode'], $pickupAddress['oua_country_code'], $pickupAddress['oua_country_code_alpha3'], $pickupAddress['oua_state_code'], $pickupAddress['oua_phone']);

                if (!empty($pickupAddrPhone)) { ?>
                    <li class="list-stats-item">
                        <span class="lable"><?php echo Labels::getLabel('LBL_PICKUP_ADDRESS_CONTACT', $siteLangId); ?>:</span>
                        <span class="value">
                            <?php echo $contactName . ' (' . $pickupAddrPhone . ')'; ?>
                        </span>
                    </li>
                <?php } ?>
                <li class="list-stats-item">
                    <span class="lable"><?php echo Labels::getLabel('LBL_PICKUP_ADDRESS', $siteLangId); ?>:</span>
                    <span class="value">
                        <?php echo implode(', ', $pickupAddress); ?>
                    </span>
                </li>
            <?php } ?>
            <li class="list-stats-item list-stats-item-full">
                <span class="lable"><?php echo Labels::getLabel('LBL_STATUS', $siteLangId); ?>:</span>
                <span class="value">
                    <?php
                    $orderStatus = ucwords($op['orderstatus_name']);
                    if (Orders::ORDER_PAYMENT_CANCELLED == $order["order_payment_status"]) {
                        $orderStatus = Labels::getLabel('LBL_CANCELLED', $siteLangId);
                    } else {
                        $paymentMethodCode = Plugin::getAttributesById($order['order_pmethod_id'], 'plugin_code');
                        if (isset($paymentMethodCode) && in_array(strtolower($paymentMethodCode), ['cashondelivery', 'payatstore'])) {
                            if ($orderStatus != $order['plugin_name']) {
                                $orderStatus .= " - " . $order['plugin_name'];
                            }
                        }
                    }

                    echo OrderProduct::getStatusHtml($op["orderstatus_color_class"], $orderStatus);
                    ?>
                </span>
            </li>

            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_UNIT_PRICE', $siteLangId); ?>:</span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($op["op_unit_price"], true, true); ?></span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_ORDERED_QUANTITY', $siteLangId); ?>:</span>
                <span class="value"><?php echo $op['op_qty']; ?></span>
            </li>

            <?php if ($isOrderShipped && 0 < $shippingCost) { ?>
                <li class="list-stats-item">
                    <span class="lable"><?php echo Labels::getLabel('LBL_SHIPPING_COST', $siteLangId); ?>:</span>
                    <span class="value"><?php echo CommonHelper::displayMoneyFormat($shippingCost, true, true); ?></span>
                </li>
            <?php } ?>

            <?php if (empty($taxOptionsTotal)) {
                if (0 < $totalTax) { ?>
                    <li class="list-stats-item">
                        <span class="lable">
                            <?php echo Labels::getLabel('LBL_Tax_Charges', $siteLangId); ?>
                        </span>
                        <span class="value">
                            <span class="currency-value">
                                <?php echo CommonHelper::displayMoneyFormat($totalTax, true, false, true, false, true); ?>
                            </span>
                        </span>
                    </li>
                <?php }
            } else {
                foreach ($taxOptionsTotal as $key => $val) {
                    if (1 > $val['value']) {
                        continue;
                    }
                ?>
                    <li class="list-stats-item">
                        <span class="lable">
                            <?php echo $val['title']; ?>
                        </span>
                        <span class="value">
                            <span class="currency-value">
                                <?php echo CommonHelper::displayMoneyFormat($val['value'], true, false, true, false, true); ?>
                            </span>
                        </span>
                    </li>
            <?php }
            } ?>
            <?php $discount = abs($discount);
            if (0 < $discount) { ?>
                <li class="list-stats-item discounted">
                    <span class="lable"><?php echo Labels::getLabel('LBL_Discount', $siteLangId) ?></span>
                    <span class="value">
                        <?php echo '-' . CommonHelper::displayMoneyFormat($discount, true, false, true, false, true); ?>
                    </span>
                </li>
            <?php } ?>

            <?php
            $volumeDiscount = abs($volumeDiscount);
            if (0 < $volumeDiscount) { ?>
                <li class="list-stats-item">
                    <span class="lable"><?php echo Labels::getLabel('LBL_VOLUME_DISCOUNT', $siteLangId); ?>:</span>
                    <span class="value"><?php echo '-' . CommonHelper::displayMoneyFormat($volumeDiscount, true, true); ?></span>
                </li>
            <?php } ?>

            <?php
            $rewards = abs($rewards);
            if (0 < $rewards) { ?>
                <li class="list-stats-item discounted">
                    <span class="label">
                        <?php echo Labels::getLabel('LBL_REWARD_POINTS_DISCOUNT', $siteLangId); ?>
                    </span>
                    <span class="value">
                        <?php echo '-' . CommonHelper::displayMoneyFormat($rewards, true, false, true, false, true); ?>
                    </span>
                </li>
            <?php } ?>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_COMMISSION_CHARGED', $siteLangId); ?>[<?php echo $op["op_commission_percentage"] ?>%]</span>
                <span class="value">
                    <?php echo CommonHelper::displayMoneyFormat($op['op_commission_charged'] - $op['op_refund_commission'], true, true); ?>
                </span>
            </li>
            <li class="list-stats-item">
                <span class="lable"><?php echo Labels::getLabel('LBL_TOTAL', $siteLangId); ?>:</span>
                <span class="value" <?php echo CommonHelper::displayMoneyFormat($total, true, true, true, false, true); ?></span>
            </li>
            <li class="list-stats-item list-stats-item-full">
                <span class="lable"><?php echo Labels::getLabel('LBL_SHIPPING_LABEL', $siteLangId); ?>:</span>
                <span class="value">
                    <?php echo CommonHelper::displayNotApplicable($siteLangId, $op["opshipping_label"]); ?>
                </span>
            </li>
            <?php if (!empty($op["opshipping_service_code"])) { ?>
                <li class="list-stats-item list-stats-item-full">
                    <span class="lable"><?php echo Labels::getLabel('LBL_SHIPPING_SERVICES', $siteLangId); ?>:</span>
                    <span class="value">
                        <?php echo CommonHelper::displayNotApplicable($siteLangId, $op["opshipping_service_code"]); ?>
                    </span>
                </li>
            <?php } ?>

            <?php if (isset($op['op_product_dimension_unit']) && isset($unitTypeArray[$op['op_product_dimension_unit']])) {
                $unitType = $unitTypeArray[$op['op_product_dimension_unit']];
            ?>

                <li class="list-stats-item list-stats-item-full">
                    <span class="separator"></span>
                    <span class="value"><?php echo Labels::getLabel('LBL_PACKAGE_DETAIL', $siteLangId); ?>:</span>
                </li>
                <li class="list-stats-item">
                    <span class="lable"><?php echo Labels::getLabel('LBL_LENGTH', $siteLangId); ?></span>
                    <span class="value"><?php echo $op['op_product_length'] . ' ' . $unitType; ?></span>
                </li>
                <li class="list-stats-item">
                    <span class="lable"><?php echo Labels::getLabel('LBL_WIDTH', $siteLangId); ?></span>
                    <span class="value"><?php echo $op['op_product_width'] . ' ' . $unitType; ?></span>
                </li>
                <li class="list-stats-item">
                    <span class="lable"><?php echo Labels::getLabel('LBL_HEIGHT', $siteLangId); ?></span>
                    <span class="value"><?php echo $op['op_product_height'] . ' ' . $unitType; ?></span>
                </li>

            <?php } ?>

            <?php
            if (isset($order['pickupAddress']) && !empty($order['pickupAddress'])) {
                $address = $order['pickupAddress'];
            ?>
                <li class="list-stats-item list-stats-item-full">
                    <span class="separator"></span>
                    <span class="value"><?php echo Labels::getLabel('LBL_PICKUP_ADDRESS', $siteLangId); ?>:</span>
                </li>
                <li class="list-stats-item">
                    <span class="label"><?php echo Labels::getLabel('LBL_CONTACT_NAME', $siteLangId); ?> </span>
                    <span class="value"><?php echo $address['oua_name']; ?></span>
                </li>
                <?php if ($address['oua_address1'] != '') { ?>
                    <li class="list-stats-item list-stats-item-full">
                        <span class="label"><?php echo Labels::getLabel('LBL_ADDRESS_1', $siteLangId); ?> </span>
                        <span class="value"><?php echo $address['oua_address1']; ?></span>
                    </li>
                <?php } ?>
                <?php if ($address['oua_address2'] != '') { ?>
                    <li class="list-stats-item list-stats-item-full">
                        <span class="label"><?php echo Labels::getLabel('LBL_ADDRESS_2', $siteLangId); ?> </span>
                        <span class="value"><?php echo $address['oua_address2']; ?></span>
                    </li>
                <?php } ?>
                <?php if ($address['oua_city'] != '') { ?>
                    <li class="list-stats-item">
                        <span class="label"><?php echo Labels::getLabel('LBL_CITY', $siteLangId); ?> </span>
                        <span class="value"><?php echo $address['oua_city']; ?></span>
                    </li>
                <?php } ?>
                <?php if ($address['oua_state'] != '') { ?>
                    <li class="list-stats-item">
                        <span class="label"><?php echo Labels::getLabel('LBL_STATE', $siteLangId); ?> </span>
                        <span class="value"><?php echo $address['oua_state']; ?></span>
                    </li>
                <?php } ?>
                <?php if ($address['oua_zip'] != '') { ?>
                    <li class="list-stats-item">
                        <span class="label"><?php echo Labels::getLabel('LBL_ZIP', $siteLangId); ?> </span>
                        <span class="value"><?php echo $address['oua_zip']; ?></span>
                    </li>
                <?php } ?>
                <?php if ($address['oua_country'] != '') { ?>
                    <li class="list-stats-item">
                        <span class="label"><?php echo Labels::getLabel('LBL_COUNTRY', $siteLangId); ?> </span>
                        <span class="value"><?php echo $address['oua_country']; ?></span>
                    </li>
                <?php } ?>
                <?php if ($address['oua_phone'] != '') { ?>
                    <li class="list-stats-item">
                        <span class="label"><?php echo Labels::getLabel('LBL_PHONE', $siteLangId); ?> </span>
                        <span class="value"><span class="default-ltr"><?php echo ValidateElement::formatDialCode($address['oua_phone_dcode']) . $address['oua_phone']; ?></span></span>
                    </li>
                <?php } ?>
                <?php
                $pickupFromTime = $op['opshipping_time_slot_from'] ?? '';
                $pickupToTime = $op['opshipping_time_slot_to'] ?? '';
                if (!empty($pickupFromTime) && '00:00:00' != $pickupFromTime && !empty($pickupToTime) && '00:00:00' != $pickupToTime) { ?>
                    <li class="list-stats-item">
                        <span class="label"><?php echo Labels::getLabel('LBL_PICKUP_TIME', $siteLangId); ?> </span>
                        <span class="value"><?php echo date('H:i', strtotime($pickupFromTime)) . ' - ' . date('H:i', strtotime($pickupToTime)); ?></span>
                    </li>
                <?php } ?>
            <?php } ?>

            <?php
            if (isset($op['op_comments']) && !empty($op['op_comments'])) {
            ?>
                <li class="list-stats-item list-stats-item-full">
                    <span class="separator mb-0"></span>
                </li>
                <li class="list-stats-item">
                    <span class="label"><?php echo Labels::getLabel('LBL_CUSTOMER_COMMENTS', $siteLangId); ?> </span>
                    <span class="value"><?php echo $op['op_comments']; ?></span>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>