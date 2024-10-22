<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (isset($collection['products']) && count($collection['products']) > 0) { ?>
    <section class="section" data-section="section">
        <div class="container">
            <div class="section-head">
                <div class="section-heading">
                    <h2><?php echo ($collection['collection_name'] != '') ? $collection['collection_name'] : ''; ?></h2>
                </div>
            </div>
            <div class="product-listing" data-view="4" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
                <?php
                $tRightRibbons = $collection['tRightRibbons'];
                foreach ($collection['products'] as $product) {
                    $selProdRibbons = [];
                    if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                        $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
                    }

                    if (isset($product['promotion_id']) && $product['promotion_id'] > 0) {
                        Promotion::updateImpressionData($product['promotion_id']);
                    }
                    ?>
                    <div class="product-listing-item">
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