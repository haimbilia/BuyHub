<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$returnRequestApproved = FatApp::getConfig("CONF_RETURN_REQUEST_APPROVED_ORDER_STATUS");
?>
<div class="card-body p-0 itemSummaryJs">
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
                    $shippingApiObj = (new Shipping($siteLangId))->getShippingApiObj(($shippingHanldedBySeller ? $op['opshipping_by_seller_user_id'] : 0)) ?? NULL;
                    $pickUpDetails = $shippingApiObj && $shippingApiObj->getKey('plugin_id') == $op['opshipping_plugin_id'] ? OrderProduct::getPickUpShedule($op['op_id']) : NULL;

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

                    $orderStatusLbl = Labels::getLabel('LBL_AWAITING_SHIPMENT', $siteLangId);
                    $opStatus = '';
                    if (!empty($op["thirdPartyorderInfo"]) && isset($op["thirdPartyorderInfo"]['orderStatus'])) {
                        $opStatus = $op["thirdPartyorderInfo"]['orderStatus'];
                        $opStatusLbl = strpos($opStatus, "_") ? str_replace('_', ' ', $opStatus) : $opStatus;
                    }

                    if (!empty($op['opship_tracking_url'])) {
                        $opStatusLbl = Labels::getLabel('LBL_SHIPPED', $siteLangId);
                    }

                    if ($store != $op['op_shop_name']) {
                        if (!empty($store)) { ?>
            </tbody>
            <tbody>
            <?php } ?>

            <tr>
                <td colspan="5">
                    <div class="sold_by">
                        <svg class="svg" width="20" height="20">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.yokart.svg#icon-store">
                            </use>
                        </svg> <?php echo $op['op_shop_name']; ?>
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

                    echo OrderProduct::getStatusHtml((int)$op["orderstatus_color_class"], $orderStatus); ?>
            </td>

            <td>
                <div class="text-nowrap unit-price">
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
                <?php
                    $fn = $displayShippingUserForm ? 'getShippingUsersForm' : 'getOrderCommentForm';
                    $fn = $fn . '(' . $op['order_id'] . ', ' . $op['op_id'] . ')';

                    $data = ['siteLangId' => $siteLangId];
                    $data['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'getItem(' . $op['order_id'] . ',' . $op['op_id'] . ')',
                                'title' => Labels::getLabel('MSG_VIEW_DETAIL', $siteLangId),
                            ],
                            'label' => '<i class="icn">
                                                        <svg class="svg" width="18" height="18">
                                                            <use
                                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#view">
                                                            </use>
                                                        </svg>
                                                    </i>',
                        ],
                    ];

                    if (Orders::canUpdateStatus($op)) {
                        $data['otherButtons'][] = [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => $fn,
                                'title' => Labels::getLabel('MSG_UPDATE_STATUS', $siteLangId),
                            ],
                            'label' => '<i class="icn">
                                                        <svg class="svg" width="18" height="18">
                                                            <use
                                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#form">
                                                            </use>
                                                        </svg>
                                                    </i>',
                        ];
                    }

                    $data['dropdownButtons']['otherButtons'] = [
                        [
                            'attr' => [
                                'href' => Fatutility::generateUrl('Orders', 'viewInvoice', [$op['op_id']]),
                                'target' => '_blank',
                                'title' => Labels::getLabel('MSG_PRINT_INVOICE', $siteLangId),
                            ],
                            'label' => '<i class="icn">
                                                        <svg class="svg" width="18" height="18">
                                                            <use
                                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#print">
                                                            </use>
                                                        </svg>
                                                    </i>' . Labels::getLabel('MSG_PRINT_INVOICE', $siteLangId),
                        ],
                        [
                            'attr' => [
                                'href' => Fatutility::generateUrl('Orders', 'viewBuyerOrderInvoice', [$op['order_id'], $op['op_id']]),
                                'target' => '_blank',
                                'title' => Labels::getLabel('LBL_PRINT_BUYER_INVOICE', $siteLangId),
                            ],
                            'label' => '<i class="icn">
                                                        <svg class="svg" width="18" height="18">
                                                            <use
                                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#print">
                                                            </use>
                                                        </svg>
                                                    </i>' . Labels::getLabel('LBL_PRINT_BUYER_INVOICE', $siteLangId),
                        ],
                        [
                            'attr' => [
                                'href' => 'javascript:void(0)',
                                'onclick' => 'getItemStatusHistory(' . $op['order_id'] . ',' . $op['op_id'] . ')',
                                'title' => Labels::getLabel('MSG_STATUS_HISTORY', $siteLangId),
                            ],
                            'label' => '<i class="icn">
                                                        <svg class="svg" width="18" height="18">
                                                            <use
                                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite-actions.svg#history">
                                                            </use>
                                                        </svg>
                                                    </i>' . Labels::getLabel('MSG_STATUS_HISTORY', $siteLangId),
                        ]
                    ];

                    if (
                        !in_array($op['op_status_id'], unserialize(FatApp::getConfig("CONF_COMPLETED_ORDER_STATUS"))) &&
                        $op['opshipping_fulfillment_type'] == Shipping::FULFILMENT_SHIP &&
                        !$shippingHanldedBySeller &&
                        is_object($shippingApiObj) &&
                        ('CashOnDelivery' == $op['plugin_code'] ||
                            Orders::ORDER_PAYMENT_PAID == $op['order_payment_status']
                        )
                    ) {
                        //$allowedForPlugin = in_array($shippingApiObj->keyName, ['EasyPost', 'Aramex']);

                        if (
                            1 < $op['opshipping_rate_id'] &&
                            (empty($op['opshipping_plugin_id']) ||
                                ($shippingApiObj->getKey('plugin_id') != $op['opshipping_plugin_id'] &&
                                    empty($op['opr_response'])
                                )
                            )
                        ) {
                            $data['dropdownButtons']['otherButtons'][] = [
                                'attr' => [
                                    'href' => 'javascript:void(0)',
                                    'onclick' => 'shippingRatesForm(' . $op['op_id'] . ')',
                                    'title' => Labels::getLabel('LBL_FETCH_SHIPPING_RATES', $siteLangId)
                                ],
                                'label' => '<i class="icn">
                                                            <svg class="svg" width="18" height="18">
                                                                <use
                                                                    xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#list-paper">
                                                                </use>
                                                            </svg>
                                                        </i>' . Labels::getLabel('LBL_FETCH_SHIPPING_RATES', $siteLangId),
                            ];
                        } else {
                            if ($shippingApiObj->getKey('plugin_id') == $op['opshipping_plugin_id']) {
                                if (empty($op['opr_response']) && empty($op['opship_tracking_number']) && $shippingApiObj->canGenerateLabelSeparately()) {
                                    $data['dropdownButtons']['otherButtons'][] = [
                                        'attr' => [
                                            'href' => 'javascript:void(0)',
                                            'onclick' => 'generateLabel(' . $op['op_id'] . ')',
                                            'title' => Labels::getLabel('LBL_GENERATE_LABEL', $siteLangId)
                                        ],
                                        'label' => '<i class="icn">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#print-label">
                                                                        </use>
                                                                    </svg>
                                                                </i>' . Labels::getLabel('LBL_GENERATE_LABEL', $siteLangId),
                                    ];
                                } elseif (!empty($op['opr_response'])) {
                                    $method = ($returnRequestApproved == $op["op_status_id"]) ? 'previewReturnLabel' : 'previewLabel';
                                    $title = ($returnRequestApproved == $op["op_status_id"]) ? 'LBL_PREVIEW_RETURN_LABEL' : 'LBL_PREVIEW_LABEL';
                                    $data['dropdownButtons']['otherButtons'][] = [
                                        'attr' => [
                                            'href' => UrlHelper::generateUrl("ShippingServices", $method, [$op['op_id']]),
                                            'target' => "_blank",
                                            'title' => Labels::getLabel($title, $siteLangId)
                                        ],
                                        'label' => '<i class="icn">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#export">
                                                                        </use>
                                                                    </svg>
                                                                </i>' . Labels::getLabel($title, $siteLangId),
                                    ];
                                }
                                if ((!empty($opStatus) && 'awaiting_shipment' == $opStatus && !empty($op['opr_response']) || ($shippingApiObj->canGenerateLabelFromShipment() || !empty($orderDetail['opship_tracking_number']))) && empty($op['opship_order_number'])) {
                                    if (true == $shippingApiObj->canGenerateLabelFromShipment()) {
                                        $label = Labels::getLabel('LBL_BUY_SHIPMENT_&_GENERATE_LABEL', $siteLangId);
                                    } else {
                                        $label = Labels::getLabel('LBL_PROCEED_TO_SHIPMENT', $siteLangId);
                                    }
                                    $data['dropdownButtons']['otherButtons'][] = [
                                        'attr' => [
                                            'href' => 'javascript:void(0)',
                                            'onclick' => 'proceedToShipment(' . $op['op_id'] . ')',
                                            'title' => $label
                                        ],
                                        'label' => '<i class="icn">
                                                                    <svg class="svg" width="18" height="18">
                                                                        <use
                                                                            xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#icon-shipping-pickup">
                                                                        </use>
                                                                    </svg>
                                                                </i>' . $label,
                                    ];
                                }

                                if ($op['orderstatus_id'] == $shippedOrderStatus &&  true === $shippingApiObj->canCreatePickup()) {
                                    if (!$pickUpDetails || 1 > $pickUpDetails['opsp_scheduled']) {
                                        $data['dropdownButtons']['otherButtons'][] = [
                                            'attr' => [
                                                'href' => 'javascript:void(0)',
                                                'onclick' => 'getPickupForm(' . $op['op_id'] . ')',
                                                'title' => Labels::getLabel('LBL_CREATE_PICKUP', $siteLangId)
                                            ],
                                            'label' => '<i class="icn">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#pickup">
                                                                            </use>
                                                                        </svg>
                                                                    </i>' . Labels::getLabel('LBL_CREATE_PICKUP', $siteLangId),
                                        ];
                                    } else {
                                        $data['dropdownButtons']['otherButtons'][] = [
                                            'attr' => [
                                                'href' => 'javascript:void(0)',
                                                'onclick' => 'cancelPickup(' . $op['op_id'] . ')',
                                                'title' => Labels::getLabel('LBL_CANCEL_PICKUP', $siteLangId)
                                            ],
                                            'label' => '<i class="icn">
                                                                        <svg class="svg" width="18" height="18">
                                                                            <use
                                                                                xlink:href="' . CONF_WEBROOT_URL . 'images/retina/sprite.yokart.svg#not-allowed">
                                                                            </use>
                                                                        </svg>
                                                                    </i>' . Labels::getLabel('LBL_CANCEL_PICKUP', $siteLangId),
                                        ];
                                    }
                                }
                            }
                        }
                    }

                    $this->includeTemplate('_partial/listing/listing-action-buttons.php', $data, false);
                ?>
            </td>
        </tr>
    <?php $store = $op['op_shop_name'];
                } ?>
            </tbody>
        </table>
    </div>
</div>