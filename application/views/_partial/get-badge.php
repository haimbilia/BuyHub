<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$bdgSelProdId = isset($bdgSelProdId) ? $bdgSelProdId : 0;
$bdgProdId = isset($bdgProdId) ? $bdgProdId : 0;
$bdgShopId = isset($bdgShopId) ? $bdgShopId : 0;
$bdgSize = isset($bdgSize) ? $bdgSize : 26;
$bdgExcludeCndType = isset($bdgExcludeCndType) && is_array($bdgExcludeCndType) ? $bdgExcludeCndType : [];
$frontReturn = isset($frontReturn) ? $frontReturn : false;

$obj = new Badge();
$badgeUrlArr = $obj->setSellerProdudtId($bdgSelProdId)
                    ->setProductId($bdgProdId)
                    ->setShopId($bdgShopId)
                    ->getBadgeUrl($siteLangId, $bdgSize);
$html = "";
if (is_array($badgeUrlArr) && !empty($badgeUrlArr)) {
    $html = '<div>';
        foreach ($badgeUrlArr as $bdgRow) { 
            if (!empty($bdgExcludeCndType) && in_array($bdgRow['conditionType'], $bdgExcludeCndType)) {
                continue;
            }
            $html .= '<img class="item__title_badge" src="' . $bdgRow['url'] . '" title="' . $bdgRow['name'] . '">';
        }
    $html .= '</div>';
}

if (false === $frontReturn) {
    echo $html;
}
