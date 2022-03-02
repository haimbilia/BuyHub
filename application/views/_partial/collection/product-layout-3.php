<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

if (isset($collection['products']) && count($collection['products'])) { ?>
    <section class="section bg-gray">
        <div class="container">
            <div class="section-head ">
                <div class="section-heading">
                    <h2><?php echo ($collection['collection_name'] != '') ? $collection['collection_name'] : ''; ?></h2>
                </div>
                <div class="section-action">
                    <div class="slider-controls">
                        <button class="btn btn-prev" type="button" data-href="#product-listing"> <span class=""></span>
                        </button>
                        <button class="btn btn-next" type="button" data-href="#product-listing"> <span class=""></span>
                        </button>
                    </div>
                </div>

            </div>
            <div class="product-listing js-carousel product-layout-3" id="product-listing" data-slides="4,4,3,2,2" data-destroy="0,1,1,1,1" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
                <?php
                $displayProductNotAvailableLable = (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, '')));

                $tLeftRibbons = $collection['tLeftRibbons'];
                $tRightRibbons = $collection['tRightRibbons'];
                foreach ($collection['products'] as $product) {
                    $selProdRibbons = [];
                    if (array_key_exists($product['selprod_id'], $tLeftRibbons)) {
                        $selProdRibbons[] = $tLeftRibbons[$product['selprod_id']];
                    }

                    if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                        $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
                    }
                    echo '<div class="item">';
                    include('product-layout-1-list.php');
                    echo '</div>';
                } ?>
            </div>
            <?php if ($collection['totProducts'] > 6) { ?>
                <div class="section-action"><a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>" class="link"><?php echo Labels::getLabel('LBL_View_More', $siteLangId); ?></a> </div>
            <?php }  ?>
        </div>
    </section>
<?php } ?>