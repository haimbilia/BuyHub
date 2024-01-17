<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$count = 1;
$shopTotalReviews = $shopTotalReviews ?? 0;
foreach ($sellers as $key => $sellerDetail) {
    $isActive = array_key_exists('isActive', $sellerDetail) && true === $sellerDetail['isActive'];
    if ($count > Product::VIEW_MORE_SELLER_COUNT) { ?>
        <li class="more-sellers-item more-link">
            <a href="<?php echo UrlHelper::generateUrl('products', 'sellers', array($sellerDetail['selprod_id'])); ?>" class="link-underline">
                <?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?>
            </a>
        </li>
    <?php break;
    }
    $shopTotalReviews = $sellerDetail['shopTotalReviews'] ?? $shopTotalReviews;
    if (1 == $count && !array_key_exists('isActive', $sellerDetail)) {
        echo '<li class="more-sellers-head">' . Labels::getLabel('LBL_MORE_SELLERS', $siteLangId) . '</li>';
    }
    ?>
    <li class="more-sellers-item <?php echo ($isActive ? 'is-active' : ''); ?>">
        <div class="sold-price"><?php echo CommonHelper::displayMoneyFormat($sellerDetail['theprice']); ?></div>
        <div class="sold-by">
            <span class="sold-by-txt"><?php echo Labels::getLabel('LBL_SOLD_BY', $siteLangId); ?></span>
            <a class="sold-by-name" href="<?php echo UrlHelper::generateFullUrl('Products', 'View', array($sellerDetail['selprod_id'])); ?>" title="<?php echo $sellerDetail['shop_name']; ?>">
                <?php echo $sellerDetail['shop_name']; ?>
            </a>
        </div>
        <?php
        $badgesArr = Badge::getShopBadges($siteLangId, [$sellerDetail['shop_id']]);
        $this->includeTemplate('_partial/badge-ui.php', ['badgesArr' => $badgesArr, 'siteLangId' => $siteLangId], false);
        if ($shopTotalReviews > 0) {
        ?>
            <div class="shop-wrap">
                <div class="product-ratings">
                    <svg class="svg" width="14" height="14">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                        </use>
                    </svg>
                    <?php
                    $shop_rating = 0;
                    if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) {
                        $shop_rating = SelProdRating::getSellerRating($sellerDetail['selprod_user_id'], true);
                    ?>
                        <span class="rate"><?php echo round($shop_rating, 1); ?></span>
                    <?php
                    }
                    ?>
                    <a href="<?php echo UrlHelper::generateUrl('reviews', 'shop', array($sellerDetail['shop_id'])); ?>" class="totals-review"><?php echo $shopTotalReviews; ?>
                        <?php echo Labels::getLabel('LBL_REVIEWS', $siteLangId); ?>
                    </a>
                </div>
            </div>
        <?php }
        if (false === $isActive && 1 > FatApp::getConfig('CONF_HIDE_PRICES', FatUtility::VAR_INT, 0)) { ?>
            <button class="btn btn-outline-black btn-sm btnAddToCart--js" data-id='<?php echo $sellerDetail['selprod_id']; ?>' data-min-qty="<?php echo $sellerDetail['selprod_min_order_qty']; ?>" type="button"><?php echo Labels::getLabel('BTN_ADD_TO_CART', $siteLangId); ?></button>
        <?php } ?>
    </li>
<?php $count++;
}
