<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (isset($collection['products']) && count($collection['products']) > 0) { ?>
    <section class="section" data-section="section">
        <div class="container">
            <div class="section-head">
                <div class="section-heading">
                    <h2><?php echo ($collection['collection_name'] != '') ? $collection['collection_name'] : ''; ?></h2>
                </div>
                <div class="section-action">
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
            <div class="product-layout-1 product-listing js-carousel"
                id="product-listing-<?php echo $collection['collection_id']; ?>" data-slides="4,3,2,2" data-view="4"
                dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
                <?php
                $tRightRibbons = $collection['tRightRibbons'];
                foreach ($collection['products'] as $product) {
                    $selProdRibbons = [];
                    if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                        $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
                    }
                    ?>
                    <div class="item">
                        <?php
                        $displayProductNotAvailableLable = false;
                        if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) {
                            $displayProductNotAvailableLable = true;
                        }
                        include ('product-layout-1-list.php'); ?>
                    </div>
                <?php } ?>
            </div>
            <?php if ($collection['totProducts'] > $collection['collection_primary_records']) { ?>
                <div class="section-foot">
                    <a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>"
                        class="link-underline">
                        <?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?>
                    </a>
                </div>
            <?php } ?>
        </div>
    </section>
<?php }
