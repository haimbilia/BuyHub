<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (isset($collection['products']) && count($collection['products']) > 0) { ?>
    <section class="section">
        <div class="container">
            <div class="section-head section-head-center">
                <div class="section__heading">
                    <h2><?php echo ($collection['collection_name'] != '') ?  $collection['collection_name'] : ''; ?></h2>
                </div>
                <?php if ($collection['totProducts'] > $collection['collection_primary_records']) { ?>
                    <div class="section__action"><a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>" class="link"><?php echo Labels::getLabel('LBL_View_More', $siteLangId); ?></a> </div>
                <?php } ?>
            </div>
            <div class="product-layout-1">
                <?php
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
                ?>

                    <?php $layoutClass = 'product-item';
                    $displayProductNotAvailableLable = false;
                    if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0)) {
                        $displayProductNotAvailableLable = true;
                    }
                    include('product-layout-1-list.php'); ?>

                <?php } ?>
            </div>
        </div>
    </section>
    <section class="section bg-gray">
        <div class="container">
            <div class="section-head section-head-center">
                <div class="section__heading">
                    <h2><?php echo ($collection['collection_name'] != '') ?  $collection['collection_name'] : ''; ?></h2>
                </div>
                <?php if ($collection['totProducts'] > $collection['collection_primary_records']) { ?>
                    <div class="section__action"><a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>" class="link"><?php echo Labels::getLabel('LBL_View_More', $siteLangId); ?></a> </div>
                <?php } ?>
            </div>
            <div class="product-layout-2">
                <div class="grid grid-1">
                    <div class="products">
                        <div class="products-body">
                            <a title="Levis Women Tshirt XXL" href="/yokart/women-121" tabindex="0">
                                <picture class="product-img" data-ratio="1:1">
                                    <source type="image/webp" srcset="" title="">
                                    <img loading="lazy" data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product-16.jpg" alt="" title="">
                                </picture>
                            </a>
                        </div>
                        <div class="products-foot">
                            <div class="">
                                <div class="label">New Season</div>
                                <div class="products-category">
                                    <a href="/yokart/tops-tshirts" tabindex="0">Tops &amp;
                                        T-shirts </a>
                                </div>
                                <div class="products-title"><a title="Levis Women Tshirt XXL" href="/yokart/women-121" tabindex="0">Levis
                                        Women Tshirt XXL </a></div>
                                <div class="products-price">
                                    <span class="products-price-new">$815.00</span>
                                    <del class="products-price-old"> $840.00</del>
                                    <span class="products-price-off">3% Off</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="grid grid-2">
                    <div class="products">
                        <div class="products-body">
                            <a title="Levis Women Tshirt XXL" href="/yokart/women-121" tabindex="0">
                                <picture class="product-img" data-ratio="1:1">
                                    <source type="image/webp" srcset="" title="">
                                    <img loading="lazy" data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product-16.jpg" alt="" title="">
                                </picture>
                            </a>
                        </div>
                        <div class="products-foot">
                            <div class="">
                                <div class="label">New Season</div>
                                <div class="products-category">
                                    <a href="/yokart/tops-tshirts" tabindex="0">Tops &amp;
                                        T-shirts </a>
                                </div>
                                <div class="products-title"><a title="Levis Women Tshirt XXL" href="/yokart/women-121" tabindex="0">Levis
                                        Women Tshirt XXL </a></div>
                                <div class="products-price">
                                    <span class="products-price-new">$815.00</span>
                                    <del class="products-price-old"> $840.00</del>
                                    <span class="products-price-off">3% Off</span>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="grid grid-3">
                    <div class="products">
                        <div class="products-body">
                            <a title="Levis Women Tshirt XXL" href="/yokart/women-121" tabindex="0">
                                <picture class="product-img" data-ratio="1:1">
                                    <source type="image/webp" srcset="" title="">
                                    <img loading="lazy" data-aspect-ratio="1:1" src="<?php echo CONF_WEBROOT_URL; ?>images/products/product-16.jpg" alt="" title="">
                                </picture>
                            </a>
                        </div>
                        <div class="products-foot">
                            <div class="">
                                <div class="label">New Season</div>
                                <div class="products-category">
                                    <a href="/yokart/tops-tshirts" tabindex="0">Tops &amp;
                                        T-shirts </a>
                                </div>
                                <div class="products-title"><a title="Levis Women Tshirt XXL" href="/yokart/women-121" tabindex="0">Levis
                                        Women Tshirt XXL </a></div>
                                <div class="products-price">
                                    <span class="products-price-new">$815.00</span>
                                    <del class="products-price-old"> $840.00</del>
                                    <span class="products-price-off">3% Off</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
<?php }
