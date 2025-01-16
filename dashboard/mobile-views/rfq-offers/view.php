<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$log = [];
foreach ($arrListing as $row) {
    $lbl = '';
    if (RfqOffers::STATUS_ACCEPTED == $row['offer_status']) {
        $lbl = Labels::getLabel('MSG_THIS_OFFER_HAS_BEEN_ACCEPTED', $siteLangId);
    } else if (RfqOffers::STATUS_ACCEPTED == $row['offer_status']) {
        $lbl = Labels::getLabel('MSG_THIS_OFFER_HAS_BEEN_ACCEPTED', $siteLangId);
    }
    
    $uploadedTime = AttachedFile::setTimeParam($row['user_updated_on']);
    $userImageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'user', array($row['user_id'], ImageDimension::VIEW_MINI_THUMB, true), CONF_WEBROOT_FRONT_URL) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

    $log[] = [
        'offer_user_type' => $row['offer_user_type'],
        'offer_status' => $row['offer_status'],
        'offer_label' => $lbl,
        'qty' => CommonHelper::displayText($row['offer_quantity']),
        'offer_price_unit' => $row['rfq_quantity_unit'],
        'offer_price_unit_label' => applicationConstants::getWeightUnitName($siteLangId, $row['rfq_quantity_unit']),
        'offer_price' => CommonHelper::displayMoneyFormat($row['offer_price'], true, false, true, false, true),
        'offer_comments' => $row['offer_comments'],
        'user_image_url' => $userImageUrl,
        'user_name' => $row['user_name'],
        'offer_added_on' => FatDate::format($row['offer_added_on']),
    ];
}
$data = array(
    'log' => $log
);

if (empty($arrListing)) {
    $status = applicationConstants::OFF;
}
