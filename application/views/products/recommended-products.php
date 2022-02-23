<?php if ($recommendedProducts) { ?>
    <div class="container">
        <div class="section-head">
            <div class="section-heading">
                <h2><?php echo Labels::getLabel('LBL_Recommended_Products', $siteLangId); ?>
                </h2>
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
        <div class="js-carousel product-listing recommended-products" id="product-listing" data-view="4" data-slides="4,4,3,2,2" data-destroy="0,1,1,1,1" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
            <?php
            $tLeftRibbons = $recommendedProductsRibbons['tLeftRibbons'];
            $tRightRibbons = $recommendedProductsRibbons['tRightRibbons'];
            foreach ($recommendedProducts as $rProduct) {
                $selProdRibbons = [];
                if (array_key_exists($rProduct['selprod_id'], $tLeftRibbons)) {
                    $selProdRibbons[] = $tLeftRibbons[$rProduct['selprod_id']];
                }

                if (array_key_exists($rProduct['selprod_id'], $tRightRibbons)) {
                    $selProdRibbons[] = $tRightRibbons[$rProduct['selprod_id']];
                }

                $productUrl = UrlHelper::generateUrl('Products', 'View', array($rProduct['selprod_id'])); ?>
                <div class="item">
                    <div class="products">
                        <?php $this->includeTemplate('_partial/quick-view.php', ['product' => $rProduct,  'siteLangId' => $siteLangId], false); ?>
                        <div class="products-body">

                            <?php $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']); ?>
                            <div class="products-img">
                                <a title="<?php echo $rProduct['selprod_title']; ?>" href="<?php echo !isset($rProduct['promotion_id']) ? UrlHelper::generateUrl('Products', 'View', array($rProduct['selprod_id'])) : UrlHelper::generateUrl('Products', 'track', array($rProduct['promotion_record_id'])); ?>">
                                    <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_PRODUCT_IMAGE, $rProduct['product_id']); ?>
                                    <?php
                                    $pictureAttr = [
                                        'webpImageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($rProduct['product_id'], "WEBPCLAYOUT3", $rProduct['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp'),
                                        'jpgImageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($rProduct['product_id'], "CLAYOUT3", $rProduct['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                                        'ratio' => '1:1',
                                        'imageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($rProduct['product_id'], "CLAYOUT3", $rProduct['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                                        'siteLangId' => $siteLangId,
                                        'alt' => (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $rProduct['prodcat_name'],
                                    ];

                                    $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                                    ?>
                                </a>
                            </div>
                        </div>
                        <div class="products-foot">
                            <div class="products-category">
                                <a href="<?php echo UrlHelper::generateUrl('Category', 'View', array($rProduct['prodcat_id'])); ?>">
                                    <?php echo $rProduct['prodcat_name']; ?>
                                </a>
                            </div>
                            <div class="products-title"><a title="<?php echo $rProduct['selprod_title']; ?>" href="<?php echo UrlHelper::generateUrl('Products', 'View', array($rProduct['selprod_id'])); ?>"><?php echo (mb_strlen($rProduct['selprod_title']) > 50) ? mb_substr($rProduct['selprod_title'], 0, 50) . "..." : $rProduct['selprod_title']; ?>
                                </a></div>
                            <?php $this->includeTemplate('_partial/collection-product-price.php', array('product' => $rProduct, 'siteLangId' => $siteLangId), false); ?>
                        </div>
                    </div>
                </div>
            <?php
            } ?>
        </div>
    </div>

<?php }
