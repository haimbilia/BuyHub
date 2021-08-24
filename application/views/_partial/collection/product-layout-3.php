<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (isset($collection['products']) && count($collection['products'])) { ?>
    <section class="section bg-brand-light">
        <div class="container">
            <div class="section-head ">
                <div class="section__heading">
                    <h2><?php echo ($collection['collection_name'] != '') ? $collection['collection_name'] : ''; ?></h2>
                </div>
                <?php if ($collection['totProducts'] > 6) { ?>
                    <div class="section__action"><a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>" class="link"><?php echo Labels::getLabel('LBL_View_More', $siteLangId); ?></a> </div>
                <?php }  ?>
            </div>
            <div class="js-collection-corner collection-corner product-listing" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
                <?php
                $displayProductNotAvailableLable = false;
                if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0)) {
                    $displayProductNotAvailableLable = true;
                }
                foreach ($collection['products'] as $product) {
                    $selProdRibbons = [];
                    if (array_key_exists($product['selprod_id'], $tLeftRibbons)) {
                        $selProdRibbons[] = $tLeftRibbons[$product['selprod_id']];
                    }

                    if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                        $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
                    }

                    include('product-layout-1-list.php');
                } ?>
            </div>
        </div>
    </section>
<?php } ?>