<?php defined('SYSTEM_INIT') or die('Invalid Usage.');



if (isset($collection['products']) && count($collection['products']) > 0) { ?>



    <section class="section bg-gray">
        <div class="container">
            <div class="section-head section-head-center">
                <div class="section-heading">
                    <h2><?php echo ($collection['collection_name'] != '') ?  $collection['collection_name'] : ''; ?></h2>
                </div>
                <?php if ($collection['totProducts'] > $collection['collection_primary_records']) { ?>
                    <div class="section-action"><a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>" class="link"><?php echo Labels::getLabel('LBL_View_More', $siteLangId); ?></a> </div>
                <?php } ?>
            </div>
            <div class="product-layout-2">

                <?php
                $tLeftRibbons = $collection['tLeftRibbons'];
                $tRightRibbons = $collection['tRightRibbons'];
                $gridKey = 1;
                foreach ($collection['products'] as $product) {
                    $selProdRibbons = [];
                    if (array_key_exists($product['selprod_id'], $tLeftRibbons)) {
                        $selProdRibbons[] = $tLeftRibbons[$product['selprod_id']];
                    }

                    if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                        $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
                    }
                ?>

                    <?php $layoutClass = 'product-item';
                    $displayProductNotAvailableLable = false;
                    if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0)) {
                        $displayProductNotAvailableLable = true;
                    }

                    include('product-layout-4-list.php');



                    $gridKey++;

                    ?>

                <?php } ?>





            </div>

        </div>
    </section>
<?php }
