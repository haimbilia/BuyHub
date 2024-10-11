<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (isset($collection['products']) && count($collection['products']) > 0) { ?>
    <section class="section" data-section="section">
        <div class="container">
            <div class="section-head">
                <div class="section-heading">
                    <h2><?php echo ($collection['collection_name'] != '') ? $collection['collection_name'] : ''; ?></h2>
                </div>
                <div class="section-action">
                    <?php if ($collection['totProducts'] > $collection['collection_primary_records']) { ?>
                        <a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>"
                            class="link-underline">
                            <?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?>
                        </a>
                    <?php } ?>
                    <div class="slider-controls">
                        <button class="btn btn-prev" type="button"
                            data-href="#product-listing-<?php echo $collection['collection_id']; ?>" aria-label="Previous">
                            <span></span>
                        </button>
                        <button class="btn btn-next" type="button"
                            data-href="#product-listing-<?php echo $collection['collection_id']; ?>" aria-label="Next">
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <?php
            $displayCount = (0 < $collection['collection_primary_records']) ? $collection['collection_primary_records'] : 4;
            $slidesCount = (Collections::TYPE_PRODUCT_LAYOUT6 == $collection['collection_layout_type']) ? '6,3,2,2' : min($displayCount, 6);
            ?>
            <div class="product-layout-1 product-listing js-carousel"
                id="product-listing-<?php echo $collection['collection_id']; ?>" data-slides="<?php echo $slidesCount; ?>"
                data-view="<?php echo $displayCount; ?>" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
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
                        include('product-layout-1-list.php'); ?>
                    </div>
                <?php } ?>
            </div>

        </div>
    </section>
<?php }