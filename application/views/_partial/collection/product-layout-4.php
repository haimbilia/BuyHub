<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<?php if (isset($collection['products']) && count($collection['products']) > 0) { ?>
    <section class="section" data-section="section">
        <div class="container">
            <div class="section-head">
                <div class="section-heading">
                    <h2><?php echo ($collection['collection_name'] != '') ? $collection['collection_name'] : ''; ?></h2>
                </div>
                <?php if ($collection['totProducts'] > $collection['collection_primary_records']) { ?>
                    <div class="section-action">
                        <a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>"
                            class="link-underline">
                            <?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?>
                        </a>
                    </div>
                <?php } ?>
            </div>
            <div class="product-layout-4" data-view="<?php echo count($collection['products']); ?>" data-record="<?php echo $collection['collection_primary_records'];?>">
                <?php
                $tRightRibbons = $collection['tRightRibbons'];
                $count = 0;
                foreach ($collection['products'] as $product) {
                    $count++;
                    $selProdRibbons = [];
                    if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                        $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
                    }

                    $displayProductNotAvailableLable = false;
                    if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) {
                        $displayProductNotAvailableLable = true;
                    }

                    $productThumb = (in_array($count, [1, 4])) ? ImageDimension::VIEW_CLAYOUT4 : ImageDimension::VIEW_SMALL;
                    ?>
                    <div class="products-<?php echo $count; ?>">
                        <?php include ('product-layout-4-list.php'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>