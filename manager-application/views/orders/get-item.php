<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$op = current($order['products']);

$shippingCost = CommonHelper::orderProductAmount($op, 'SHIPPING');
$volumeDiscount = CommonHelper::orderProductAmount($op, 'VOLUME_DISCOUNT');
$total = CommonHelper::orderProductAmount($op, 'cart_total') + $shippingCost + $volumeDiscount;

$op['order_id'] = $order['order_id'];
$op['order_number'] = $order['order_number'];
$op['order_date_added'] = $order['order_date_added'];

$isOrderShipped = (Shipping::FULFILMENT_PICKUP != $op['opshipping_fulfillment_type']);
?>

<div class="modal-header">
    <h5 class="modal-title">
        <?php echo $op['op_selprod_title']; ?>
    </h5>
</div>
<div class="modal-body opDetailsJs<?php echo $op['op_id']; ?>">
    <div class="form-edit-body loaderContainerJs">
        <ul class="list-text">
            <li>
                <span class="lable"><?php echo Labels::getLabel('LBL_INVOICE_NUMBER', $siteLangId); ?>:</span>
                <span class="value"><?php echo $op['op_invoice_number'] ?></span>
            </li>
            <li>
                <span class="lable"><?php echo Labels::getLabel('LBL_STORE', $siteLangId); ?>:</span>
                <span class="value"><?php echo $op['op_shop_name'] ?></span>
            </li>
            <li>
                <span class="lable"><?php echo Labels::getLabel('LBL_SHIPPING_STATUS', $siteLangId); ?>:</span>
                <span class="value">
                    <?php
                        $orderStatus = ucwords($op['orderstatus_name']);
                        if (Orders::ORDER_PAYMENT_CANCELLED == $order["order_payment_status"]) {
                            $orderStatus = Labels::getLabel('LBL_CANCELLED', $siteLangId);
                        } else {
                            $paymentMethodCode = Plugin::getAttributesById($order['order_pmethod_id'], 'plugin_code');
                            if (in_array(strtolower($paymentMethodCode), ['cashondelivery', 'payatstore'])) {
                                if ($orderStatus != $order['plugin_name']) {
                                    $orderStatus .= " - " . $order['plugin_name'];
                                }
                            }
                        }

                        echo OrderProduct::getStatusHtml($op["orderstatus_color_class"], $orderStatus);
                    ?>
                </span>
            </li>
            <li>
                <span class="lable"><?php echo Labels::getLabel('LBL_UNIT_PRICE', $siteLangId); ?>:</span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($op["op_unit_price"], true, true); ?></span>
            </li>
            <li>
                <span class="lable"><?php echo Labels::getLabel('LBL_QUANTITY', $siteLangId); ?>:</span>
                <span class="value"><?php echo $op['op_qty']; ?></span>
            </li>

            <?php if ($isOrderShipped) { ?>
                <li>
                    <span class="lable"><?php echo Labels::getLabel('LBL_SHIPPING', $siteLangId); ?>:</span>
                    <span class="value"><?php echo CommonHelper::displayMoneyFormat($shippingCost, true, true); ?></span>
                </li>
            <?php } ?>
            <li>
                <span class="lable"><?php echo Labels::getLabel('LBL_VOLUME_DISCOUNT', $siteLangId); ?>:</span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($volumeDiscount, true, true); ?></span>
            </li>
            <li>
                <span class="lable"><?php echo Labels::getLabel('LBL_TOTAL', $siteLangId); ?>:</span>
                <span class="value"<?php echo CommonHelper::displayMoneyFormat($total, true, true, true, false, true); ?></span>
            </li>
        </ul>
    </div>
</div>