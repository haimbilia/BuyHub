<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

$loggedUserId = UserAuthentication::getLoggedUserId(true);
$remainingWalletBalance = $userWalletBalance = User::getUserBalance($loggedUserId, true);

$cartTotal = $cartSummary['cartTotal'] ?? 0;
$discountTotal = $cartSummary['cartDiscounts']["coupon_discount_total"] ?? 0;
$totalRewardPoints = UserRewardBreakup::rewardPointBalance($loggedUserId);
$canBeUse = min($totalRewardPoints, CommonHelper::convertCurrencyToRewardPoint($cartTotal - $cartSummary['cartVolumeDiscount'] - $discountTotal));
$canBeUse = min($canBeUse, FatApp::getConfig('CONF_MAX_REWARD_POINT', FatUtility::VAR_INT, 0));
$canBeUseRPAmt = CommonHelper::displayMoneyFormat(CommonHelper::convertRewardPointToCurrency($canBeUse));

$productsCount = isset($productsCount) ? $productsCount : count($products);

$walletCharged = 0;
if ($userWalletBalance > 0 && $cartSummary['orderNetAmount'] > 0 && $cartSummary["cartWalletSelected"]) {
    $remainingWalletBalance = ($userWalletBalance - $cartSummary['orderNetAmount']);
    $remainingWalletBalance = ($remainingWalletBalance < 0) ? 0 : $remainingWalletBalance;

    $walletCharged = $userWalletBalance - $remainingWalletBalance;
}


$priceDetail = array(
    'userWalletBalance' => $userWalletBalance,
    'displayUserWalletBalance' => CommonHelper::displayMoneyFormat($userWalletBalance),
    'rewardPoints' => $totalRewardPoints,
    'canBeUseRP' => trim($canBeUse),
    'canBeUseRPAmt' => trim($canBeUseRPAmt),
    'walletCharged' => CommonHelper::displayMoneyFormat($walletCharged),
    'remainingWalletBalance' => $remainingWalletBalance,
    'displayRemainingWalletBalance' => CommonHelper::displayMoneyFormat($remainingWalletBalance),
    'orderNetAmount' => $cartSummary['orderNetAmount'],
);

$cartTotal = isset($cartSummary['cartTotal']) ? $cartSummary['cartTotal'] : 0;
$shippingTotal = isset($cartSummary['shippingTotal']) ? $cartSummary['shippingTotal'] : 0;
$cartTaxTotal = isset($cartSummary['cartTaxTotal']) ? $cartSummary['cartTaxTotal'] : 0;
$cartVolumeDiscount = isset($cartSummary['cartVolumeDiscount']) ? $cartSummary['cartVolumeDiscount'] : 0;
$coupon_discount_total = isset($cartSummary['cartDiscounts']['coupon_discount_total']) ? $cartSummary['cartDiscounts']['coupon_discount_total'] : 0;
$appliedRewardPointsDiscount = isset($cartSummary['cartRewardPoints']) ? $cartSummary['cartRewardPoints'] : 0;

$priceDetail['priceDetail'] = array(
    array(
        'key' => Labels::getLabel('LBL_ITEMS', $siteLangId),
        'value' => $productsCount
    ),
    array(
        'key' => Labels::getLabel('LBL_SUB_TOTAL', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($cartTotal)
    )
);

if (0 < $cartSummary['totalSaving'] && (!isset($cartPage) || false === $cartPage)) {
    $priceDetail['priceDetail'][] = array(
        'key' => Labels::getLabel('LBL_TOTAL_SAVING', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($cartSummary['totalSaving'])
    );
}

if (0 < $appliedRewardPointsDiscount) {
    $usedRPAmt = CommonHelper::convertRewardPointToCurrency($appliedRewardPointsDiscount);
    $priceDetail['priceDetail'][] = array(
        'key' => Labels::getLabel('LBL_REWARD_POINT_DISCOUNT', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($usedRPAmt)
    );
}
if (0 < $cartVolumeDiscount) {
    $priceDetail['priceDetail'][] = array(
        'key' => Labels::getLabel('LBL_VOLUME_DISCOUNT', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($cartVolumeDiscount)
    );
}
if (0 < $coupon_discount_total) {
    $priceDetail['priceDetail'][] = array(
        'key' => Labels::getLabel('LBL_DISCOUNT', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($coupon_discount_total)
    );
}

if (0 < $cartTaxTotal) {
    if (isset($cartSummary['taxOptions']) && !empty($cartSummary['taxOptions'])) {
        foreach ($cartSummary['taxOptions'] as $taxName => $taxVal) {
            $priceDetail['priceDetail'][] = array(
                'key' => $taxVal['title'],
                'value' => CommonHelper::displayMoneyFormat($taxVal['value'])
            );
        }
    } else {
        $priceDetail['priceDetail'][] = array(
            'key' => Labels::getLabel('LBL_TAX_CHARGES', $siteLangId),
            'value' => CommonHelper::displayMoneyFormat($cartTaxTotal)
        );
    }
}

if (0 < $shippingTotal) {
    $priceDetail['priceDetail'][] = array(
        'key' => Labels::getLabel('LBL_SHIPPING_CHARGES', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($shippingTotal)
    );
}

if (array_key_exists('roundingOff', $cartSummary) && $cartSummary['roundingOff'] != 0 && !isset($cartPage)) {
    $priceDetail['priceDetail'][] = array(
        'key' => (0 < $cartSummary['roundingOff']) ? Labels::getLabel('LBL_ROUNDING_UP', $siteLangId) : Labels::getLabel('LBL_ROUNDING_DOWN', $siteLangId),
        'value' => CommonHelper::displayMoneyFormat($cartSummary['roundingOff'])
    );
}

$orderNetAmount = $cartSummary['orderNetAmount'];
if (isset($cartPage) && true === $cartPage) {
    $orderNetAmount = $cartSummary['cartTotal'] - ((0 < $cartSummary['cartVolumeDiscount']) ? $cartSummary['cartVolumeDiscount'] : 0);
    $orderNetAmount = $orderNetAmount - ((isset($cartSummary['cartDiscounts']['coupon_discount_total']) && 0 < $cartSummary['cartDiscounts']['coupon_discount_total']) ? $cartSummary['cartDiscounts']['coupon_discount_total'] : 0);
}

$priceDetail['netPayable'] = array(
    'key' => Labels::getLabel('LBL_NET_PAYABLE', $siteLangId),
    'value' => CommonHelper::displayMoneyFormat($orderNetAmount)
);

if (!empty($data['cartSummary']['cartDiscounts'])) {
    $data['cartSummary']['cartDiscounts']['coupon_discount_total'] = CommonHelper::displayMoneyFormat($data['cartSummary']['cartDiscounts']['coupon_discount_total']);
} else {
    $data['cartSummary']['cartDiscounts'] = (object)array();
}

if (isset($data['cartSummary']['orderPaymentGatewayCharges'])) {
    $data['cartSummary']['orderPaymentGatewayCharges'] = CommonHelper::displayMoneyFormat($data['cartSummary']['orderPaymentGatewayCharges']);
}
$data = !empty($data) ? array_merge($data, $priceDetail) : $priceDetail;
