<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($couponsList as $key => &$offer) {
    $offer['offerImage'] = UrlHelper::generateFullUrl('Image', 'coupon', array($offer['coupon_id'], $siteLangId, ImageDimension::VIEW_NORMAL));
    $offer['coupon_min_order_value'] = CommonHelper::displayMoneyFormat($offer['coupon_min_order_value'], false, false, false);
    $offer['coupon_max_discount_value'] = CommonHelper::displayMoneyFormat($offer['coupon_max_discount_value'], false, false, false);
    $offer['coupon_discount_value'] = ($offer['coupon_discount_in_percent'] == applicationConstants::PERCENTAGE) ? $offer['coupon_discount_value'] : CommonHelper::displayMoneyFormat($offer['coupon_discount_value'], false, false, false);
}

$data = array(
    'couponsList' => array_values($couponsList),
);

if (empty($couponsList)) {
    $status = applicationConstants::OFF;
    $msg = Labels::getLabel('MSG_NO_VALID_COUPONS_AVAILABLE', $siteLangId);;
}
