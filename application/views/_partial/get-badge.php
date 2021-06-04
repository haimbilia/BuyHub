<?php defined('SYSTEM_INIT') or die('Invalid Usage');

$bdgSelProdId = isset($bdgSelProdId) ? $bdgSelProdId : 0;
$bdgProdId = isset($bdgProdId) ? $bdgProdId : 0;
$bdgShopId = isset($bdgShopId) ? $bdgShopId : 0;
$bdgSize = isset($bdgSize) ? $bdgSize : 26;
$bdgExcludeCndType = isset($bdgExcludeCndType) && is_array($bdgExcludeCndType) ? $bdgExcludeCndType : [];

$obj = new Badge();
$badgeUrlArr = $obj->setSellerProdudtId($bdgSelProdId)
                    ->setProductId($bdgProdId)
                    ->setShopId($bdgShopId)
                    ->getBadgeUrl($siteLangId, $bdgSize);

if (is_array($badgeUrlArr) && !empty($badgeUrlArr)) { ?>
    <div>
        <?php foreach ($badgeUrlArr as $row) { 
            if (!empty($bdgExcludeCndType) && in_array($row['conditionType'], $bdgExcludeCndType)) {
                continue;
            } ?>
            <img class="item__title_badge" src="<?php echo $row['url']; ?>" title="<?php echo $row['name']; ?>">
        <?php } ?>
    </div>
<?php }