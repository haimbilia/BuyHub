<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if ($relatedProductsRs) { ?>
    <section class="section" data-section="section">
        <div class="container">
            <header class="section-head">
                <div class="section-heading">
                    <h2><?php echo Labels::getLabel('LBL_Similar_Products', $siteLangId); ?>
                    </h2>
                </div>
                <div class="section-action">
                    <div class="slider-controls relatedprod">
                        <button class="btn btn-prev" type="button" data-href="#product-listing-rep"> <span class=""></span>
                        </button>
                        <button class="btn btn-next" type="button" data-href="#product-listing-rep"> <span class=""></span>
                        </button>
                    </div>
                </div>
            </header>
            <div class="section-body">
                <div class="js-carousel related-products" id="product-listing-rep" data-slides="5,4,3,2,2"
                    data-arrows="true" data-slickdots="false" data-arrowcontainer="relatedprod" data-dotscontainer="" data-customarrow="true"
                    dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
                    <?php
                    $tRightRibbons = $relatedProductsRibbons['tRightRibbons'];
                    foreach ($relatedProductsRs as $rProduct) {
                        $selProdRibbons = [];
                        if (array_key_exists($rProduct['selprod_id'], $tRightRibbons)) {
                            $selProdRibbons[] = $tRightRibbons[$rProduct['selprod_id']];
                        }
                        $productUrl = UrlHelper::generateUrl('Products', 'View', array($rProduct['selprod_id'])); ?>
                        <div class="js-carousel-item">
                            <div class="products">
                                <div class="products-body">
                                    <div class="badges-wrap">
                                        <?php $this->includeTemplate('_partial/product-type-ribbon.php', ['productType' => $rProduct['product_type'], 'siteLangId' => $siteLangId], false);
                                        if (!empty($selProdRibbons)) {
                                            foreach ($selProdRibbons as $ribbRow) {
                                                $this->includeTemplate('_partial/ribbon-ui.php', ['ribbRow' => $ribbRow], false);
                                            }
                                        } ?>
                                    </div>
                                    <?php $uploadedTime = AttachedFile::setTimeParam($rProduct['product_updated_on']); ?>
                                    <div class="products-img">
                                        <a title="<?php echo CommonHelper::renderHtml($rProduct['selprod_title'], true); ?>"
                                            href="<?php echo !isset($rProduct['promotion_id']) ? UrlHelper::generateUrl('Products', 'View', array($rProduct['selprod_id'])) : UrlHelper::generateUrl('Products', 'track', array($rProduct['promotion_record_id'])); ?>">
                                            <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_PRODUCT_IMAGE, $rProduct['product_id']); ?>
                                            <img <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_CLAYOUT1); ?>
                                                src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($rProduct['product_id'], ImageDimension::VIEW_CLAYOUT1, $rProduct['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>"
                                                alt="<?php echo (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $rProduct['prodcat_name']; ?>"
                                                title="<?php echo (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $rProduct['prodcat_name']; ?>">
                                        </a>
                                    </div>
                                </div>
                                <div class="products-foot">

                                    <a class="products-category"
                                        href="<?php echo UrlHelper::generateUrl('Category', 'View', array($rProduct['prodcat_id'])); ?>"><?php echo $rProduct['prodcat_name']; ?>
                                    </a>


                                    <a class="products-title"
                                        title="<?php echo CommonHelper::renderHtml($rProduct['selprod_title'], true); ?>"
                                        href="<?php echo UrlHelper::generateUrl('Products', 'View', array($rProduct['selprod_id'])); ?>"><?php echo (mb_strlen($rProduct['selprod_title']) > 50) ? mb_substr(CommonHelper::renderHtml($rProduct['selprod_title'], true), 0, 50) . "..." : CommonHelper::renderHtml($rProduct['selprod_title'], true); ?>
                                    </a>

                                    <?php $this->includeTemplate('_partial/collection-product-price.php', array('product' => $rProduct, 'siteLangId' => $siteLangId), false); ?>
                                </div>
                            </div>
                        </div>
                        <!--/product tile-->
                    <?php
                    } ?>
                </div>
            </div>
        </div>
    </section>
<?php } ?>
<script>
    $(document).ready(function() {       
        loadSlickSlider();
    });
</script>