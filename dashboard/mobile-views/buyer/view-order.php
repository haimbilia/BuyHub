<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$orderDetail['charges'] = !empty($orderDetail['charges']) ? $orderDetail['charges'] : (object)array();
$orderDetail['billingAddress'] = !empty($orderDetail['billingAddress']) ? $orderDetail['billingAddress'] : (object)array();
$orderDetail['shippingAddress'] = !empty($orderDetail['shippingAddress']) ? $orderDetail['shippingAddress'] : (object)array();
$orderDetail['order_net_amount'] = !empty($orderDetail['order_net_amount']) ? $orderDetail['order_net_amount'] : 0;
$orderDetail['pickupAddress'] =  isset($orderDetail['pickupAddress']) && !empty($orderDetail['pickupAddress']) ? $orderDetail['pickupAddress'] : (object)array();

if (!empty($orderDetail['charges'])) {
    $charges = array();
    $i = 0;
    foreach ($orderDetail['charges'] as $key => $value) {
        $charges[$key] = array_values($value);
        $i++;
    }
    $orderDetail['charges'] = $charges;
}

$childArr = array_values($arr);

$orderDetail['pickupDetail'] = (object)array();
if (0 < $opId) {
    $opDetail = current($childArr);
    if (Shipping::FULFILMENT_PICKUP == $opDetail['opshipping_fulfillment_type']) {
        $orderDetail['pickupDetail'] =  [
            'opshipping_date' => $opDetail['opshipping_date'],
            'opshipping_time_slot_from' => $opDetail['opshipping_time_slot_from'],
            'opshipping_time_slot_to' => $opDetail['opshipping_time_slot_to'],
        ];
    }
}

$cartTotal = $shippingCharges = $totalVolumeDiscount = $totalOrderDiscountTotal = $totalTax = 0;

$taxOptionsTotal = array();

$defaultOrderStatus = FatApp::getConfig('CONF_DEFAULT_REVIEW_STATUS', FatUtility::VAR_INT, 0);
$reviewAllowed = FatApp::getConfig('CONF_ALLOW_REVIEWS', FatUtility::VAR_INT, 0);

$canCancelOrder = true;
$canReturnRefund = true;
foreach ($childArr as &$childOrder) {
    $childOrder['orderstatus_color_code'] = applicationConstants::getClassColor((int)$childOrder['orderstatus_color_class']);
    $rating = isset($childOrder['prod_rating']) ? $childOrder['prod_rating'] : 0;
    $childOrder['prod_rating'] =  (1 == $defaultOrderStatus || (isset($childOrder['spreview_status']) && $childOrder['spreview_status'] == 1)) ? $rating : 0;
    $childOrder['reviewsAllowed'] =  $reviewAllowed;
    $childOrder['product_image_url'] = UrlHelper::generateFullUrl('image', 'product', array($childOrder['selprod_product_id'], ImageDimension::VIEW_THUMB, $childOrder['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND);

    if ($childOrder['op_product_type'] == Product::PRODUCT_TYPE_DIGITAL) {
        $canCancelOrder = (in_array($childOrder["op_status_id"], (array)Orders::getBuyerAllowedOrderCancellationStatuses(true))) ? 1 : 0;
        $canReturnRefund = (in_array($childOrder["op_status_id"], (array)Orders::getBuyerAllowedOrderReturnStatuses(true))) ? 1 : 0;
    } else {
        $canCancelOrder = (in_array($childOrder["op_status_id"], (array)Orders::getBuyerAllowedOrderCancellationStatuses())) ? 1 : 0;
        $canReturnRefund = (in_array($childOrder["op_status_id"], (array)Orders::getBuyerAllowedOrderReturnStatuses())) ? 1 : 0;
        $datediff = time() - strtotime($childOrder['order_date_added']);
        $daysSpent = $datediff / (60 * 60 * 24);
        $returnAge = $childOrder['op_selprod_return_age'];  
        $canReturnRefund =  $canReturnRefund && $returnAge > $daysSpent;
        $canCancelOrder = $canCancelOrder && $childOrder['op_selprod_cancellation_age'] > $daysSpent;
    }

    $childOrder['canCancelOrder'] = ($canCancelOrder && false === OrderCancelRequest::getCancelRequestById($childOrder['op_id']) ? 1 : 0);

    $childOrder['canReturnOrder'] = ($canReturnRefund && $childOrder['return_request'] == 0 && $childOrder['cancel_request'] == 0 ? 1 : 0);

    $canSubmitFeedback = Orders::canSubmitFeedback($childOrder['order_user_id'], $childOrder['order_id'], $childOrder['op_selprod_id']);
    $isValidForReview = in_array($childOrder["op_status_id"], SelProdReview::getBuyerAllowedOrderReviewStatuses());

    $childOrder['canSubmitFeedback'] = ($canSubmitFeedback && $isValidForReview) ? 1 : 0;

    $cartTotal = $cartTotal + CommonHelper::orderProductAmount($childOrder, 'cart_total');
    $shippingCharges = $shippingCharges + CommonHelper::orderProductAmount($childOrder, 'shipping');

    $volumeDiscount = CommonHelper::orderProductAmount($childOrder, 'VOLUME_DISCOUNT');
    $totalVolumeDiscount += $volumeDiscount;

    $rewardPointDiscount = CommonHelper::orderProductAmount($childOrder, 'REWARDPOINT');

    $orderDiscountTotal = CommonHelper::orderProductAmount($childOrder, 'DISCOUNT');
    $totalOrderDiscountTotal += $orderDiscountTotal;

    $childOrder['priceDetail'] = array(
        array(
            'key' => Labels::getLabel('LBL_Ordered_Quantity', $siteLangId),
            'value' => $childOrder['op_qty'],
        ),
        array(
            'key' => Labels::getLabel('LBL_Price', $siteLangId),
            'value' => CommonHelper::displayMoneyFormat($childOrder['op_unit_price']),
        )
    );

    if (0 < CommonHelper::orderProductAmount($childOrder, 'shipping')) {
        $childOrder['priceDetail'][] = array(
            'key' => Labels::getLabel('LBL_Shipping_Charges', $siteLangId),
            'value' => CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrder, 'shipping')),
        );
    }

    if (0 < $volumeDiscount) {
        $childOrder['priceDetail'][] = array(
            'key' => Labels::getLabel('LBL_Volume/Loyalty_Discount', $siteLangId),
            'value' => CommonHelper::displayMoneyFormat($volumeDiscount),
        );
    }


    $taxCharges = [];
    if (empty($childOrder['taxOptions'])) {
        $totalTax = CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrder, 'tax'));
        $childOrder['priceDetail'][] = array(
            'key' => Labels::getLabel('LBL_Tax_Charges', $siteLangId),
            'value' => $totalTax,
        );
    } else {
        foreach ($childOrder['taxOptions'] as $key => $val) {
            if (0 >= $val['value']) {
                continue;
            }

            $taxCharges[] = [
                'key' => CommonHelper::displayTaxPercantage($val, true),
                'value' => CommonHelper::displayMoneyFormat($val['value']),
            ];

            $taxOptionsTotal[$key]['key'] = CommonHelper::displayTaxPercantage($val);
            
            if (!isset($taxOptionsTotal[$key]['value'])) {
                $taxOptionsTotal[$key]['value'] = 0;
            }
            $taxOptionsTotal[$key]['value'] += $val['value'];
        }
        $childOrder['priceDetail'] = array_merge($childOrder['priceDetail'], $taxCharges);
    }

    if (0 != $orderDiscountTotal) {
        $childOrder['priceDetail'][] = array(
            'key' => Labels::getLabel('LBL_Discount', $siteLangId),
            'value' => CommonHelper::displayMoneyFormat($orderDiscountTotal),
        );
    }

    if (0 != $rewardPointDiscount) {
        $childOrder['priceDetail'][] = array(
            'key' => Labels::getLabel('LBL_Reward_Point_Discount', $siteLangId),
            'value' => CommonHelper::displayMoneyFormat($rewardPointDiscount),
        );
    }

    
    if (0 != $orderDetail['order_rounding_off']) {
        $childOrder['priceDetail'][] = array(
            'key' => (0 < $orderDetail['order_rounding_off']) ? Labels::getLabel('LBL_Rounding_Up', $siteLangId) : Labels::getLabel('LBL_Rounding_Down', $siteLangId),
            'value' => CommonHelper::displayMoneyFormat($orderDetail['order_rounding_off'])
        );
    }

    $childOrder['totalAmount'] = array(
        'key' => Labels::getLabel('LBL_Total', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($childOrder)),
    );

    $paymentMethodName = $childOrder['plugin_name'] ?: $childOrder['plugin_identifier'];
    if (0 < $childOrder['order_pmethod_id'] && 0 < $childOrder['order_is_wallet_selected']) {
        $paymentMethodName .= ' + ';
    }
    if (0 < $childOrder['order_is_wallet_selected']) {
        $paymentMethodName .= Labels::getLabel("LBL_Wallet", $siteLangId);
    }
    $childOrder['plugin_name'] = $paymentMethodName;

    $orderObj = new Orders($childOrder['order_id']);
    if ($childOrder['plugin_code'] == 'CashOnDelivery') {
        $processingStatuses = $orderObj->getAdminAllowedUpdateOrderStatuses(true);
    } else {
        $processingStatuses = $orderObj->getAdminAllowedUpdateOrderStatuses(false, $childOrder['op_product_type']);
    }
}

$data = array(
    'orderDetail' => $orderDetail,
    'childOrderDetail' => $childArr,
    'orderStatuses' => !empty($orderStatuses) ? $orderStatuses : (object)array(),
    'primaryOrder' => $primaryOrder,
    'digitalDownloads' => !empty($digitalDownloads) ? $digitalDownloads : (object)array(),
    'digitalDownloadLinks' => !empty($digitalDownloadLinks) ? $digitalDownloadLinks : (object)array(),
    'languages' => !empty($languages) ? $languages : (object)array(),
    'yesNoArr' => $yesNoArr,
);

if (!$primaryOrder) {
    $data['orderSummary'] = [
        [
            'key' => Labels::getLabel('LBL_CART_TOTAL', $siteLangId),
            'value' => $cartTotal,
        ]
    ];

    if (0 < $shippingCharges) {
        $data['orderSummary'][] = [
            'key' => Labels::getLabel('LBL_Shipping_Charges', $siteLangId),
            'value' => $shippingCharges,
        ];
    }

    if (!empty($taxOptionsTotal)) {
        $data['orderSummary'] = array_merge($data['orderSummary'], $taxOptionsTotal);
    } else {
        $data['orderSummary'][] = [
            'key' => Labels::getLabel('LBL_TAX_CHARGES', $siteLangId),
            'value' => $totalTax,
        ];
    }

    if (0 != $totalOrderDiscountTotal) {
        $data['orderSummary'][] = [
            'key' => Labels::getLabel('LBL_Discount', $siteLangId),
            'value' => $totalOrderDiscountTotal,
        ];
    }

    if (0 != $totalVolumeDiscount) {
        $data['orderSummary'][] = [
            'key' => Labels::getLabel('LBL_Volume/Loyalty_Discount', $siteLangId),
            'value' => $totalVolumeDiscount,
        ];
    }

    if (0 != $orderDetail['order_reward_point_value']) {
        $data['orderSummary'][] = [
            'key' => Labels::getLabel('LBL_REWARD_POINTS', $siteLangId),
            'value' => $orderDetail['order_reward_point_value'],
        ];
    }

    if (0 < $orderDetail['order_net_amount']) {
        $data['orderSummary'][] = [
            'key' => Labels::getLabel('LBL_Total', $siteLangId),
            'value' => $orderDetail['order_net_amount'],
        ];
    }
    $data['orderSummary'] = !empty($data['orderSummary']) ? array_values($data['orderSummary']) : [];
    array_walk($data['orderSummary'], function (&$val) {
        $val['value'] = CommonHelper::displayMoneyFormat($val['value'], true, false, true, false, true);
    });
}

if (empty($orderDetail)) {
    $status = applicationConstants::OFF;
}
