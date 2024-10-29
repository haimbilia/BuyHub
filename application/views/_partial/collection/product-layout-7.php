<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (isset($collection['products']) && count($collection['products']) > 0) { ?>
    <section class="section" data-section="product-layout-7">
        <div class="container">
            <header class="section-head">
                <div class="section-heading">
                    <h2><?php echo ($collection['collection_name'] != '') ? $collection['collection_name'] : ''; ?></h2>
                </div>
                <div class="section-action">
                    <?php if ($collection['totProducts'] > $collection['collection_primary_records']) { ?>
                        <a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>"
                            class="link-underline link-more">
                            <?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?>
                        </a>
                    <?php } ?>
                    <div class="slider-controls">
                        <button class="btn btn-prev slick-arrow" type="button"
                            data-href="#product-listing-<?php echo $collection['collection_id']; ?>" aria-label="#product-listing-<?php echo $collection['collection_id']; ?>">
                            <span></span>
                        </button>
                        <button class="btn btn-next slick-arrow" type="button"
                            data-href="#product-listing-<?php echo $collection['collection_id']; ?>" aria-label="#product-listing-<?php echo $collection['collection_id']; ?>">
                            <span></span>
                        </button>
                    </div>
                </div>
            </header>
            <?php
            $displayCount = (0 < $collection['collection_primary_records']) ? $collection['collection_primary_records'] : 4;
            $slidesCount = (Collections::TYPE_PRODUCT_LAYOUT6 == $collection['collection_layout_type']) ? '7,3,2,2' : min($displayCount, 7);
            ?>
            <div class="section-body">
                <div class="product-layout-5 js-carousel" id="product-listing-<?php echo $collection['collection_id']; ?>"
                    data-slides="<?php echo $slidesCount; ?>" data-view="<?php echo $displayCount; ?>"
                    dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
                    <?php
                    $tRightRibbons = $collection['tRightRibbons'];
                    foreach ($collection['products'] as $product) {
                        $selProdRibbons = [];
                        if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                            $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
                        }
                    ?>
                        <div class="js-carousel-item">
                            <?php
                            $displayProductNotAvailableLable = false;
                            if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) {
                                $displayProductNotAvailableLable = true;
                            }
                            $prodImgSize = ImageDimension::VIEW_MOBILE;
                            $i = 1;
                            include('product-layout-1-list.php'); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
<?php }
