<div class="modal-header">
    <h5 class="modal-title"><?php echo $product['product_name']; ?></h5>
</div>
<div class="modal-body">
    <div class="loaderContainerJs">
        <div class="row">
            <div class="col-lg-12">
                <?php if ($productImagesArr) { ?>
                    <div class="js-product-gallery product-gallery" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
                        <?php foreach ($productImagesArr as $afile_id => $image) {
                            $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_MEDIUM, 0, $image['afile_id']), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
                            $thumbImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, 0, $image['afile_id']), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg'); ?>
                            <?php if (isset($imageGallery) && $imageGallery) { ?>
                                <a href="<?php echo $mainImgUrl; ?>" class="gallery" rel="gallery">
                                <?php } ?>
                                <img src="<?php echo $mainImgUrl; ?>" <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_MEDIUM); ?>>
                                <?php if (isset($imageGallery) && $imageGallery) { ?>
                                </a>
                            <?php } ?>
                        <?php } ?>
                    </div>
                <?php } else {
                    $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, ImageDimension::VIEW_MEDIUM, 0), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg'); ?>
                    <div class="item__main"><img src="<?php echo $mainImgUrl; ?>" <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_MEDIUM); ?>></div>
                <?php } ?>
            </div>
            <div class="col-lg-12">
                <div class="mt-4">
                    <ul class="list-stats list-stats-double">
                        <li class="list-stats-item">
                            <span class="lable"><?php echo Labels::getLabel('LBL_Category', $siteLangId); ?></span>
                            <span class="value"><?php echo $product['prodcat_name']; ?></span>
                        </li>
                        <li class="list-stats-item">
                            <span class="lable"><?php echo Labels::getLabel('LBL_Brand', $siteLangId); ?></span>
                            <span class="value"><?php echo ($product['brand_name']) ? $product['brand_name'] : Labels::getLabel('LBL_N/A', $siteLangId); ?></span>
                        </li>
                        <?php if ($product['product_type'] != Product::PRODUCT_TYPE_SERVICE) { ?>
                            <li class="list-stats-item">
                                <span class="lable"><?php echo Labels::getLabel('LBL_Product_Model', $siteLangId); ?></span>
                                <span class="value"><?php echo $product['product_model']; ?></span>
                            </li>
                        <?php } ?>
                        <li class="list-stats-item">
                            <span class="lable"><?php echo Labels::getLabel('LBL_Minimum_Selling_Price', $siteLangId); ?></span>
                            <span class="value"><?php echo CommonHelper::displayMoneyFormat($product['product_min_selling_price']); ?></span>
                        </li>
                        <?php $saleTaxArr = Tax::getSaleTaxCatArr($siteLangId);
                        if (isset($product['ptt_taxcat_id']) && array_key_exists($product['ptt_taxcat_id'], $saleTaxArr)) { ?>
                            <li class="list-stats-item">
                                <span class="lable"><?php echo Labels::getLabel('LBL_Tax_Category', $siteLangId); ?></span>
                                <span class="value"><?php echo $saleTaxArr[$product['ptt_taxcat_id']]; ?></span>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php if (count($productSpecifications) > 0) { ?>
                        <div class="mt-4">
                            <div class="h6"><?php echo Labels::getLabel('LBL_Specifications', $siteLangId); ?></div>
                            <div class="list list--specification">
                                <ul class="list-stats list-stats-double">
                                    <?php $count = 1;
                                    foreach ($productSpecifications as $key => $specification) {
                                        if ($count > 5) {
                                            continue;
                                        } ?>
                                        <li class="list-stats-item">
                                            <span class="lable"><?php echo $specification['prodspec_name']; ?></span>
                                            <span class="value"><?php echo $specification['prodspec_value']; ?></span>
                                        </li>

                                    <?php $count++;
                                    } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    var layoutDirection = '<?php echo CommonHelper::getLayoutDirection(); ?>';
    var config = {
        dots: true,
        arrows: false,
        autoplay: true,
        pauseOnHover: false,
        slidesToShow: 1,
        draggable: true,
    };
    config['rtl'] = (layoutDirection == 'rtl');
    $('.js-product-gallery').not('.slick-initialized').slick(config);
    setTimeout(() => {
        $('.js-product-gallery').slick('setPosition');
    }, 500);
</script>