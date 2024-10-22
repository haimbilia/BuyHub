<?php
if (!empty($allShops)) {
    $i = 0;
    ?>
<ul class="collection-shops">
    <?php
        foreach ($allShops as $shop) { ?>

    <li class="collection-shops-item">
        <div class="shop">
            <div class="shop-head">
                <div class="shop-logo"> <img
                        src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopLogo', array($shop['shop_id'], $siteLangId, ImageDimension::VIEW_THUMB, 0, false), CONF_WEBROOT_URL), CONF_IMG_CACHE_TIME, '.jpg'); ?>"
                        alt="<?php echo $shop['shop_name']; ?>"
                        <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_SHOP_LOGO, ImageDimension::VIEW_THUMB); ?>>
                </div>
            </div>
            <div class="shop-body">
                <div class="shop-title"><a
                        href="<?php echo UrlHelper::generateUrl('shops', 'view', array($shop['shop_id'])); ?>"><?php echo $shop['shop_name']; ?></a>
                </div>
                <div class="shop-location">
                    <?php echo $shop['state_name']; ?>
                    <?php echo ($shop['country_name'] && $shop['state_name']) ? ', ' : ''; ?>
                    <?php echo $shop['country_name']; ?>
                </div>
            </div>
            <div class="shop-foot">
                <?php
                        $badgesArr = Badge::getShopBadges($siteLangId, [$shop['shop_id']]);
                        $this->includeTemplate('_partial/badge-ui.php', ['badgesArr' => $badgesArr, 'siteLangId' => $siteLangId], false);
                        ?>
                <?php if (0 < FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0) && round($shop['shopRating']) > 0) { ?>
                <div class="product-ratings">
                    <svg class="svg svg-star" width="14" height="14">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
                    </svg>
                    <span class="rate"><?php echo round($shop['shopRating'], 1); ?> </span>
                </div>
                <?php } ?>
                <a class="btn btn-outline-black btn-sm"
                    href="<?php echo UrlHelper::generateUrl('shops', 'view', array($shop['shop_id']), '', null, false, false, true, true); ?>">
                    <?php echo Labels::getLabel('LBL_View_Shop', $siteLangId); ?></a>

            </div>
        </div>
        <div class="product-wrapper">
            <div class="row">
                <?php
                        $displayProductNotAvailableLable = (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '')));

                        $tRightRibbons = $shop['tRightRibbons'];
                        foreach ($shop['products'] as $product) {
                            $selProdRibbons = [];

                            if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                                $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
                            }
                            ?>
                <div class="col-6 col-lg-3 mb-3 mb-md-0">
                    <?php include(CONF_THEME_PATH . '_partial/collection/product-layout-1-list.php'); ?>
                </div>
                <?php } ?>
            </div>
        </div>
    </li>
    <?php $i++;
        }
        ?>
</ul>
<?php
} else {
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId), false);
}

$postedData['page'] = (isset($page)) ? $page : 1;
echo FatUtility::createHiddenFormFromData($postedData, array(
    'name' => 'frmSearchShopsPaging'
));