<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (!empty($product['brand_name'])) { ?>
    <a class="brand-title" href="<?php echo UrlHelper::generateUrl('Brands', 'view', [$product['brand_id']]); ?>"><?php echo $product['brand_name']; ?></a>
<?php } ?>
<h1 class="product-title"> <?php echo $product['selprod_title']; ?> </h1>
<div class="products-price">
    <span class="products-price-new"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?></span>

    <?php if ($product['selprod_price'] > $product['theprice']) { ?>
        <del class="products-price-old"><?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></del>

        <span class="products-price-off">(<?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?>)</span>
    <?php } ?>

    <!-- Shop and SelProd Badge  -->
    <?php
    $selProdBadge = Badge::getSelprodBadges($siteLangId, [$product['selprod_id']]);
    $shopBadge = Badge::getShopBadges($siteLangId, [$product['shop_id']]);
    $badgesArr = array_merge($selProdBadge, $shopBadge);
    $this->includeTemplate('_partial/badge-ui.php', ['badgesArr' => $badgesArr, 'siteLangId' => $siteLangId], false);
    ?>
    <!-- Shop and SelProd Badge  -->
</div>