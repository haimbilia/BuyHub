<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="card-body p-0 itemSummaryJs">
    <?php 
        $isOrderShipped = (!empty($order['products']) && Shipping::FULFILMENT_PICKUP != current($order['products'])['opshipping_fulfillment_type']);
        $col = $isOrderShipped ? 6 : 5;
    ?>
    <div class="table-responsive table-scrollable js-scrollable listingTableJs">
        <table class="table table-orders">
            <thead class="tableHeadJs">
                <tr>
                    <th><?php echo Labels::getLabel('LBL_ITEMS_SUMMARY', $siteLangId); ?></th>
                    <th><?php echo Labels::getLabel('LBL_SHIPPING_STATUS', $siteLangId); ?></th>
                    <th><?php echo Labels::getLabel('LBL_UNIT_PRICE', $siteLangId); ?></th>
                    <th><?php echo Labels::getLabel('LBL_TOTAL', $siteLangId); ?></th>
                    <th class="align-right"><?php echo Labels::getLabel('LBL_ACTION_BUTTONS', $siteLangId); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $store = "";
                foreach ($order['products'] as $op) {
                    $shippingHanldedBySeller = CommonHelper::canAvailShippingChargesBySeller($op['op_selprod_user_id'], $op['opshipping_by_seller_user_id']);
                    $displayShippingUserForm = (
                        (
                            (in_array(strtolower($op['plugin_code']), ['cashondelivery', 'payatstore'])) || 
                            (in_array($op['op_status_id'], $allowedShippingUserStatuses))
                        ) && 
                        $canEditSellerOrders && 
                        !$shippingHanldedBySeller && 
                        ($op['op_product_type'] == Product::PRODUCT_TYPE_PHYSICAL && 
                        $op['order_payment_status'] != Orders::ORDER_PAYMENT_CANCELLED)
                    );

                    $shippingCost = CommonHelper::orderProductAmount($op, 'SHIPPING');
                    $volumeDiscount = CommonHelper::orderProductAmount($op, 'VOLUME_DISCOUNT');
                    $total = CommonHelper::orderProductAmount($op, 'cart_total') + $shippingCost + $volumeDiscount;

                    $op['order_id'] = $order['order_id'];
                    $op['order_number'] = $order['order_number'];
                    $op['order_date_added'] = $order['order_date_added'];

                    if ($store != $op['op_shop_name']) { 
                        if (!empty($store)) { ?>
                            </tbody><tbody>
                        <?php } ?>

                        <tr>
                            <td colspan="4">
                                <div class="sold_by">
                                    <svg class="svg" width="20" height="20">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-store">
                                        </use>
                                    </svg> <?php echo $op['op_shop_name'] ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td>
                            <?php $this->includeTemplate('_partial/product/order-product-info-card.php', ['order' => $op, 'siteLangId' => $siteLangId, 'horizontalAlignOptions' => true], false); ?>
                        </td>
                        <td>
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

                            echo OrderProduct::getStatusHtml($op["orderstatus_color_class"], $orderStatus); ?>
                        </td>

                        <td>
                            <div class="text-nowrap">
                                <span>
                                    <?php echo CommonHelper::displayMoneyFormat($op["op_unit_price"], true, true); ?>
                                </span>    
                                <span><i class="fas fa-times"></i></span>    
                                <span>
                                    <?php echo $op['op_qty']; ?>
                                </span>    
                            </div>
                        </td>

                        <td>
                            <span class="currency-value" dir="ltr">
                                <?php echo CommonHelper::displayMoneyFormat($total, true, true, true, false, true); ?>
                            </span>
                        </td>
                        <td class="align-right">
                            <ul class="actions">
                                <li data-toggle="tooltip" data-placement="top" title="<?php echo Labels::getLabel('MSG_VIEW_DETAIL', $siteLangId); ?>">
                                    <a href="javascript:void(0)" onclick="getItem(<?php echo $op['order_id']; ?>, <?php echo $op['op_id']; ?>)">
                                        <svg class="svg" width="18" height="18">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-actions.svg#view">
                                            </use>
                                        </svg>
                                    </a>
                                </li>
                                <li data-toggle="tooltip" data-placement="top" title="<?php echo Labels::getLabel('MSG_STATUS_HISTORY', $siteLangId); ?>">
                                    <a href="javascript:void(0)" onclick="getItemStatusHistory(<?php echo $op['order_id']; ?>, <?php echo $op['op_id']; ?>)">
                                        <svg class="svg" width="18" height="18">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#timeline">
                                            </use>
                                        </svg>
                                    </a>
                                </li>
                                <li data-toggle="tooltip" data-placement="top" title="<?php echo Labels::getLabel('MSG_UPDATE_STATUS', $siteLangId); ?>">
                                    <?php 
                                    $fn = $displayShippingUserForm ? 'getShippingUsersForm' : 'getOrderCommentForm';
                                    $fn = $fn . '(' . $op['order_id'] . ', ' . $op['op_id'] . ')';
                                    ?>
                                    <a href="javascript:void(0)" onclick="<?php echo $fn; ?>">
                                        <svg class="svg" width="18" height="18">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-orders">
                                            </use>
                                        </svg>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                <?php 
                    $store = $op['op_shop_name'];
                } ?>
            </tbody>
        </table>
    </div>
</div>