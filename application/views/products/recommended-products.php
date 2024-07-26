<?php

use PHPUnit\Framework\Constraint\IsTrue;

defined('SYSTEM_INIT') or die('Invalid Usage.');

if ($recommendedProducts) { ?>
    <section class="section" data-section="section">
        <div class="container">
            <div class="section-head">
                <div class="section-heading">
                    <h2><?php echo Labels::getLabel('LBL_Recommended_Products', $siteLangId); ?></h2>
                </div>
                <div class="section-action">
                    <div class="slider-controls">
                        <button class="btn btn-prev" type="button" data-href="#product-listing-rp"> <span class=""></span>
                        </button>
                        <button class="btn btn-next" type="button" data-href="#product-listing-rp"> <span class=""></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="js-carousel product-listing recommended-products" id="product-listing-rp" data-slides="4,4,3,2"
                dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
                <?php
                $tRightRibbons = $recommendedProductsRibbons['tRightRibbons'];
                foreach ($recommendedProducts as $rProduct) {
                    $selProdRibbons = [];
                    if (array_key_exists($rProduct['selprod_id'], $tRightRibbons)) {
                        $selProdRibbons[] = $tRightRibbons[$rProduct['selprod_id']];
                    }

                    $productUrl = UrlHelper::generateUrl('Products', 'View', array($rProduct['selprod_id'])); ?>
                    <div class="item">
                        <div class="products">
                            <div class="products-body">
                                <?php
                                if (!empty($selProdRibbons)) {
                                    foreach ($selProdRibbons as $ribbRow) {
                                        $this->includeTemplate('_partial/ribbon-ui.php', ['ribbRow' => $ribbRow], false);
                                    }
                                } ?>
                                <?php $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']); ?>
                                <div class="products-img">
                                    <a title="<?php echo CommonHelper::renderHtml($rProduct['selprod_title'], true); ?>"
                                        href="<?php echo !isset($rProduct['promotion_id']) ? UrlHelper::generateUrl('Products', 'View', array($rProduct['selprod_id'])) : UrlHelper::generateUrl('Products', 'track', array($rProduct['promotion_record_id'])); ?>">
                                        <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_PRODUCT_IMAGE, $rProduct['product_id']); ?>
                                        <?php
                                        $pictureAttr = [
                                            'webpImageUrl' => [ImageDimension::VIEW_DESKTOP => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($rProduct['product_id'], 'WEBP' . ImageDimension::VIEW_CLAYOUT1, $rProduct['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp')],
                                            'jpgImageUrl' => [ImageDimension::VIEW_DESKTOP => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($rProduct['product_id'], ImageDimension::VIEW_CLAYOUT1, $rProduct['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg')],
                                            'ratio' => '1:1',
                                            'imageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($rProduct['product_id'], ImageDimension::VIEW_CLAYOUT1, $rProduct['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
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
                                    <a
                                        href="<?php echo UrlHelper::generateUrl('Category', 'View', array($rProduct['prodcat_id'])); ?>">
                                        <?php echo CommonHelper::renderHtml($rProduct['prodcat_name'], true); ?>
                                    </a>
                                </div>
                                <div class="products-title"><a
                                        title="<?php echo CommonHelper::renderHtml($rProduct['selprod_title'], true); ?>"
                                        href="<?php echo UrlHelper::generateUrl('Products', 'View', array($rProduct['selprod_id'])); ?>"><?php echo (mb_strlen($rProduct['selprod_title']) > 50) ? mb_substr(CommonHelper::renderHtml($rProduct['selprod_title'], true), 0, 50) . "..." : CommonHelper::renderHtml($rProduct['selprod_title'], true); ?>
                                    </a></div>
                                <?php $this->includeTemplate('_partial/collection-product-price.php', array('product' => $rProduct, 'siteLangId' => $siteLangId), false); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                } ?>
            </div>
        </div>
    </section>
<?php }
