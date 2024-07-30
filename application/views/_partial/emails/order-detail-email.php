<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$str = '<table width="100%" cellspacing="0" cellpadding="20" border="0" style="font-size: 14px;background: #f2f2f2;font-family: Arial, sans-serif;">
            <tr>
                <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="text-align:left">
                        <tr>
                            <td style="background-color: #' . FatApp::getConfig('CONF_EMAIL_TEMPLATE_COLOR_CODE' . $siteLangId, FatUtility::VAR_STRING, 'ff3a59') . ';padding: 10px 25px;">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">                                                             
                                    <tr>
                                        <td style="font-size: 14px;font-weight: $font-weight-boldest;color: #fff;">' . Labels::getLabel('Lbl_Order_No.', $siteLangId) . ' ' . $orderInfo['order_number'] . '</td>
                                        <td style="font-size: 14px;font-weight: $font-weight-boldest;color: #fff; text-align: right;">' . Labels::getLabel('Lbl_Order_Date.', $siteLangId) . ' ' . FatDate::format($orderInfo['order_date_added']) . '</td>
                                    </tr>
                                </table>                                                          
                            </td>
                        </tr> 
                        <tr>
                            <td>
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td>';
$taxCharged = 0;
$cartTotal = 0;
$total = 0;
$shippingTotal = 0;
$netAmount = 0;
$discountTotal = 0;
$volumeDiscountTotal = 0;
$rewardPointDiscount = 0;
$roundingOff = 0;
$selProdTotalSpecialPrice = 0;
foreach ($orderProductsData as $addrKey => $orderProducts) {
    $productHtml = '<table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #fff;padding: 10px 0;">';
    $pickupHtml = '';
    foreach ($orderProducts as $prodkey => $val) {
        
        if (isset($val["opshipping_fulfillment_type"]) || (isset($val["op_product_type"]) && ($val["op_product_type"] == Product::PRODUCT_TYPE_DIGITAL || $val["op_product_type"] == Product::PRODUCT_TYPE_SERVICE))) {
            $opCustomerBuyingPrice = CommonHelper::orderProductAmount($val, 'CART_TOTAL');
            $shippingPrice = CommonHelper::orderProductAmount($val, 'SHIPPING');
            $discountedPrice = CommonHelper::orderProductAmount($val, 'DISCOUNT');
            $taxCharged = $taxCharged + CommonHelper::orderProductAmount($val, 'TAX');
            $productTaxCharged = CommonHelper::orderProductAmount($val, 'TAX');
            $netAmount = $netAmount + CommonHelper::orderProductAmount($val, 'NETAMOUNT');
            $volumeDiscount =  CommonHelper::orderProductAmount($val, 'VOLUME_DISCOUNT');
            $volumeDiscountTotal = $volumeDiscountTotal + abs(CommonHelper::orderProductAmount($val, 'VOLUME_DISCOUNT'));
            $rewardPointDiscount = $rewardPointDiscount + abs(CommonHelper::orderProductAmount($val, 'REWARDPOINT'));

            $skuCodes = $val["op_selprod_sku"];
            $options = $val['op_selprod_options'];
            $roundingOff = $val['op_rounding_off'];
            $cartTotal = $cartTotal + $opCustomerBuyingPrice;
            $shippingTotal = $shippingTotal + $shippingPrice;
            $discountTotal = $discountTotal + abs($discountedPrice);
            $total =  $total + $opCustomerBuyingPrice + $shippingPrice;

            $selProdTotalSpecialPrice += $val['op_special_price'] * $val["op_qty"];

            $prodOrBatchUrl = 'javascript:void(0)';
            $prodOrBatchImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'product', array($val['selprod_product_id'], ImageDimension::VIEW_MINI, $val['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
            $productTaxChargedTxt = '';
            if (empty($val['taxOptions'])) {
                $productTaxChargedTxt = CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($val, 'TAX'));
            } else {
                foreach ($val['taxOptions'] as $key => $value) {
                    $productTaxChargedTxt .= '<p><strong>' . CommonHelper::displayTaxPercantage($value) . ':</strong> ' . CommonHelper::displayMoneyFormat($value['value']) . '</p>';
                    if (!isset($taxOptionsTotal[$key]['value'])) {
                        $taxOptionsTotal[$key]['value'] = 0;
                    }
                    $taxOptionsTotal[$key]['value'] += $value['value'];
                    $taxOptionsTotal[$key]['name'] = CommonHelper::displayTaxPercantage($value);
                }
            }

            $brandData = '';
            if (!empty($val["op_brand_name"])) {
                $brandData = Labels::getLabel('Lbl_Brand', $siteLangId) . ': ' . $val["op_brand_name"];
            }

            $fromTime = '';
            $toTime = '';
            $pickupDate = '';
            if ($val["opshipping_fulfillment_type"] == Shipping::FULFILMENT_PICKUP) {
                $fromTime = date('H:i', strtotime($val["opshipping_time_slot_from"]));
                $toTime = date('H:i', strtotime($val["opshipping_time_slot_to"]));
                $pickupDate =  FatDate::format($val["opshipping_date"]);
            }

            $productHtml .= '<tr>
                                                                            <td style="border-bottom:1px solid #ecf0f1;">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                    <tr>
                                                                                        <td style="width: 70px; padding: 10px;">
                                                                                            <a href=""' . $prodOrBatchUrl . '""><img src="' . $prodOrBatchImgUrl . '" alt="" title="" ' . HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_MINI) . ' /></a>
                                                                                        </td>
                                                                                        <td style="padding: 10px;">
                                                                                            <a href="' . $prodOrBatchUrl . '" style="color: #555555;font-size: 14px;font-weight: $font-weight-bold;text-decoration: none;">' . $val["op_product_name"] . '</a>
                                                                                            <table border="0" cellpadding="0" cellspacing="0" style="padding: 6px 0;">
                                                                                                <tr>
                                                                                                    <td style="color: #888888;font-size: 14px;">' . $brandData . '</td>
                                                                                                    <td style="color: #888888;font-size: 14px;padding:0 10px;">|</td>
                                                                                                    <td style="color: #888888;font-size: 14px;">' . Labels::getLabel('Lbl_Qty', $siteLangId) . ': ' . $val['op_qty'] . '</td>
                                                                                                </tr>
                                                                                            </table>
                                                                                            <div style="color: #555555;font-size: 14px;font-weight: $font-weight-bold;">' . Labels::getLabel('Lbl_By', $siteLangId) . ':' . $val["op_shop_name"] . '</div>
                                                                                        </td>
                                                                                        <td style="color: #555555;font-size: 14px;font-weight: $font-weight-bold; text-align:right;padding:0px 5px 0;">';
            $productHtml .= CommonHelper::displayMoneyFormat($opCustomerBuyingPrice + $shippingPrice + $productTaxCharged - abs($volumeDiscount) + $roundingOff);
            if (0 < $roundingOff) {
                $productHtml .= '(+' . $roundingOff . ')';
            }
            $productHtml .= '</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>';
        }
    }
    $productHtml .= '</table>';

    if (!empty($orderProducts['pickupAddress'])) {
        $pickUpAddressInfo = $orderProducts['pickupAddress']['oua_name'] . ', ';
        if ($orderProducts['pickupAddress']['oua_address1'] != '') {
            $pickUpAddressInfo .= $orderProducts['pickupAddress']['oua_address1'] . ', ';
        }

        if ($orderProducts['pickupAddress']['oua_address2'] != '') {
            $pickUpAddressInfo .= $orderProducts['pickupAddress']['oua_address2'];
        }

        if ($orderProducts['pickupAddress']['oua_city'] != '') {
            $pickUpAddressInfo .= ', ' . $orderProducts['pickupAddress']['oua_city'] . ', ';
        }

        if ($orderProducts['pickupAddress']['oua_zip'] != '') {
            $pickUpAddressInfo .= $orderProducts['pickupAddress']['oua_state'];
        }

        if ($orderProducts['pickupAddress']['oua_zip'] != '') {
            $pickUpAddressInfo .= '-' . $orderProducts['pickupAddress']['oua_zip'];
        }

        if ($orderProducts['pickupAddress']['oua_phone'] != '') {
            $pickUpAddressInfo .= ', ' . ValidateElement::formatDialCode($orderProducts['pickupAddress']['oua_phone_dcode']) . $orderProducts['pickupAddress']['oua_phone'];
        }

        $pickupHtml .= '<table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                        <tr>
                                                                            <td style="border-top:1px dashed #e2e5ec;background-color: #fff;padding: 15px 10px;background: #f8f8f8;border-bottom: 1px dashed #e2e5ec;">
                                                                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                                    <tr>
                                                                                        <td width="30%" style="color:#888888;font-weight:600;font-size:14px;padding:4px 0; vertical-align:top;">' . Labels::getLabel('LBL_Pickup_Address', $siteLangId) . ': </td>
                                                                                        <td style="color: #525252;font-size: 12px;padding:4px 0;">' . $pickUpAddressInfo . '</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="30%" style="color:#888888;font-weight:600;font-size:14px;padding:4px 0;vertical-align:top;">' . Labels::getLabel('LBL_Pickup_Date', $siteLangId) . ': </td>
                                                                                        <td style="color: #525252;font-size: 12px;padding:4px 0;">' . $pickupDate . ' ' . $fromTime . ' - ' . $toTime . '</td>
                                                                                    </tr>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </table>';
    }
    $str .= $productHtml . $pickupHtml;
}

$str .= '</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>';
$str .= '<tr>
                            <td style="background-color: #f2f2f2;padding: 20px 25px;">
                                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                    <tr>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('L_CART_TOTAL_(_QTY_*_Product_price_)', $siteLangId) . '</td>
                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . CommonHelper::displayMoneyFormat($cartTotal) . '</td>
                                    </tr>';
if ($shippingTotal > 0) {
    $str .= '<tr>
                                                    <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_SHIPPING', $siteLangId) . '</td>
                                                    <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . CommonHelper::displayMoneyFormat($shippingTotal) . '</td>
                                                </tr>';
}

if ($taxCharged > 0) {
    if (empty($taxOptionsTotal)) {
        $str .= '<tr>
                                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_Tax', $siteLangId) . '</td>
                                                        <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . CommonHelper::displayMoneyFormat($taxCharged) . '</td>
                                                    </tr>';
    } else {
        foreach ($taxOptionsTotal as $key => $val) {
            $str .= '<tr>
                                                            <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . CommonHelper::displayTaxPercantage($val) . '</td>
                                                            <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . CommonHelper::displayMoneyFormat($val['value']) . '</td>
                                                        </tr>';
        }
    }
}

if ($discountTotal != 0) {
    $str .= '<tr>
                                                    <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_Discount', $siteLangId) . '</td>
                                                    <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . CommonHelper::displayMoneyFormat($discountTotal) . '</td>
                                                </tr>';
}

if ($volumeDiscountTotal != 0) {
    $str .= '<tr>
                                                    <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_Volume/Loyalty_Discount', $siteLangId) . '</td>
                                                    <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . CommonHelper::displayMoneyFormat($volumeDiscountTotal) . '</td>
                                                </tr>';
}

if ($rewardPointDiscount != 0) {
    $str .= '<tr>
                                                    <td style="padding: color#000;font-size: 14px;padding: 5px 0;">' . Labels::getLabel('LBL_Reward_Point_Discount', $siteLangId) . '</td>
                                                    <td style="padding: color#000;font-size: 14px;padding: 5px 0;text-align: right;">' . CommonHelper::displayMoneyFormat($rewardPointDiscount) . '</td>
                                                </tr>';
}

if (array_key_exists('order_rounding_off', $orderInfo) && 0 != $orderInfo['order_rounding_off']) {
    $roundingLabel = (0 < $orderInfo['order_rounding_off']) ? Labels::getLabel('LBL_Rounding_Up', $siteLangId) : Labels::getLabel('LBL_Rounding_Down', $siteLangId);
    $str .= '<tr>
                                                    <td style="padding: color#000;font-size: 14px;padding: 5px 0 0 0;">' . $roundingLabel . '</td>
                                                    <td style="padding: color#000;font-size: 14px;padding: 5px 0 0 0;text-align: right;">' . CommonHelper::displayMoneyFormat($orderInfo['order_rounding_off']) . '</td>
                                                </tr>';
}

$totalSaving = $selProdTotalSpecialPrice + $discountTotal + $volumeDiscountTotal;
if (0 < $totalSaving) {
    $str .= '<tr>
                                                    <td style="padding: color#000;font-size: 16px;padding: 10px 0 0 0;font-weight: $font-weight-bold;">' . Labels::getLabel('LBL_TOTAL_SAVING', $siteLangId) . '</td>
                                                    <td style="padding: color#000;font-size: 16px;padding: 10px 0 0 0;font-weight: $font-weight-bold;text-align: right;">' . CommonHelper::displayMoneyFormat($totalSaving) . '</td>
                                                </tr>';
}
$str .= '<tr>
                                                <td style="padding: color#000;font-size: 16px;padding: 10px 0 0 0;font-weight: $font-weight-bold;">' . Labels::getLabel('LBL_ORDER_TOTAL', $siteLangId) . '</td>
                                                <td style="padding: color#000;font-size: 16px;padding: 10px 0 0 0;font-weight: $font-weight-bold;text-align: right;">' . CommonHelper::displayMoneyFormat($netAmount) . '</td>
                                            </tr>';

$str .= '
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>';

$billingInfo = $billingAddress['oua_name'] . '<br>';
if ($billingAddress['oua_address1'] != '') {
    $billingInfo .= $billingAddress['oua_address1'] . '<br>';
}

if ($billingAddress['oua_address2'] != '') {
    $billingInfo .= $billingAddress['oua_address2'] . '<br>';
}

if ($billingAddress['oua_city'] != '') {
    $billingInfo .= $billingAddress['oua_city'] . ', ';
}

if ($billingAddress['oua_zip'] != '') {
    $billingInfo .= $billingAddress['oua_state'];
}

if ($billingAddress['oua_zip'] != '') {
    $billingInfo .= '-' . $billingAddress['oua_zip'];
}

if ($billingAddress['oua_phone'] != '') {
    $billingInfo .= '<br>' . ValidateElement::formatDialCode($billingAddress['oua_phone_dcode']) . $billingAddress['oua_phone'];
}

$shippingInfo = '';
if (!empty($shippingAddress)) {
    $shippingInfo = $shippingAddress['oua_name'] . '<br>';
    if ($shippingAddress['oua_address1'] != '') {
        $shippingInfo .= $shippingAddress['oua_address1'] . '<br>';
    }

    if ($shippingAddress['oua_address2'] != '') {
        $shippingInfo .= $shippingAddress['oua_address2'] . '<br>';
    }

    if ($shippingAddress['oua_city'] != '') {
        $shippingInfo .= $shippingAddress['oua_city'] . ', ';
    }

    if ($shippingAddress['oua_zip'] != '') {
        $shippingInfo .= $shippingAddress['oua_state'];
    }

    if ($shippingAddress['oua_zip'] != '') {
        $shippingInfo .= '-' . $shippingAddress['oua_zip'];
    }

    if ($shippingAddress['oua_phone'] != '') {
        $shippingInfo .= '<br>' . ValidateElement::formatDialCode($shippingAddress['oua_phone_dcode']) . $shippingAddress['oua_phone'];
    }
}

$str .= '</table><br/><br/>';

$str .= '
<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border:1px solid #ddd; border-collapse:collapse;">
        <tbody>';
if (!empty($shippingAddress)) {
    $str .= '<tr>
                            <td style="padding:10px;background:#eee;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" bgcolor="#f0f0f0">
                                <strong>' . Labels::getLabel('LBL_Order_Billing_Details', $siteLangId) . '</strong>
                            </td>
                            <td style="padding:10px;background:#eee;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" bgcolor="#f0f0f0">
                                <strong>' . Labels::getLabel('LBL_Order_Shipping_Details', $siteLangId) . '</strong>
                            </td>
                        </tr>
                        <tr>
                            <td valign="top" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;">
                            ' . $billingInfo . '
                            </td>
                            <td valign="top" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;">                                               
                            ' . $shippingInfo . '
                            </td>
                        </tr>
                        ';
} else {
    $str .= '<tr>
                <td style="padding:10px;background:#eee;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" bgcolor="#f0f0f0">
                    <strong>' . Labels::getLabel('LBL_Order_Billing_Details', $siteLangId) . '</strong>
                </td>                                       
                </tr>
                <tr>
                    <td valign="top" style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;">
                    ' . $billingInfo . '
                    </td>                                      
                </tr>';
}
$str .= ' 
        </tbody>
    </table>';
echo $str;
