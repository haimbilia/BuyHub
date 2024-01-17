<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (!empty($product['brand_name'])) { ?>
    <a class="brand-title" href="<?php echo UrlHelper::generateUrl('Brands', 'view', [$product['brand_id']]); ?>"><?php echo $product['brand_name']; ?></a>
<?php } ?>
<h1 class="product-title"> <?php echo $product['selprod_title']; ?> </h1>
<?php
$productCondArr = Product::getConditionArr($siteLangId);
unset($productCondArr[Product::CONDITION_NEW]);
if (array_key_exists($product['selprod_condition'], $productCondArr)) { ?>
    <div class="product-type">
        <?php
        echo $productCondArr[$product['selprod_condition']]; ?>
    </div>
<?php
}
$selProdBadge = Badge::getSelprodBadges($siteLangId, [$product['selprod_id']]);
$shopBadge = Badge::getShopBadges($siteLangId, [$product['shop_id']]);
$badgesArr = $selProdBadge + $shopBadge;
$this->includeTemplate('_partial/badge-ui.php', ['badgesArr' => $badgesArr, 'siteLangId' => $siteLangId], false);
require(CONF_THEME_PATH . '_partial/collection/product-price.php');