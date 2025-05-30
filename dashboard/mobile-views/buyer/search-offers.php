<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

foreach ($offers as $key => &$offer) {
    $offer['offerImage'] = UrlHelper::generateFullUrl('Image', 'coupon', array($offer['coupon_id'], $siteLangId, ImageDimension::VIEW_NORMAL), CONF_WEBROOT_FRONTEND);
    $offer['coupon_min_order_value'] = CommonHelper::displayMoneyFormat($offer['coupon_min_order_value']);
    $offer['coupon_max_discount_value'] = CommonHelper::displayMoneyFormat($offer['coupon_max_discount_value']);
    $offer['coupon_discount_value'] = ($offer['coupon_discount_in_percent'] == applicationConstants::PERCENTAGE) ? $offer['coupon_discount_value'] : CommonHelper::displayMoneyFormat($offer['coupon_discount_value'], false, false, false);
}

$data = array(
    'offers' => array_values($offers),
);

if (empty($offers)) {
    $status = applicationConstants::OFF;
}
