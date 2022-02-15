<div class="modal-header">
    <h5 class="modal-title"><?php echo Labels::getLabel('LBL_Catalog_info', $siteLangId); ?></h5>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-lg-6">
            <?php if ($productImagesArr) { ?>
                <div class="js-product-gallery product-gallery" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
                    <?php foreach ($productImagesArr as $afile_id => $image) {
                        $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'MEDIUM', 0, $image['afile_id']), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
                        $thumbImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($product['product_id'], 'THUMB', 0, $image['afile_id']), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg'); ?>
                        <?php if (isset($imageGallery) && $imageGallery) { ?>
                            <a href="<?php echo $mainImgUrl; ?>" class="gallery" rel="gallery">
                            <?php } ?>
                            <img src="<?php echo $mainImgUrl; ?>">
                            <?php if (isset($imageGallery) && $imageGallery) { ?>
                            </a>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?php } else {
                $mainImgUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array(0, 'MEDIUM', 0), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg'); ?>
                <div class="item__main"><img src="<?php echo $mainImgUrl; ?>"></div>
            <?php } ?>
        </div>
        <div class="col-lg-6">
            <div class="">
                <h3><?php echo $product['product_name']; ?></h3>
                <div class="product-description-inner">
                    <ul class="list-stats list-stats-double mt-4">
                        <li class="list-stats-item">
                            <span class="lable"><?php echo Labels::getLabel('LBL_Category', $siteLangId); ?>:</span>
                            <span class="value"><?php echo $product['prodcat_name']; ?></span>
                        </li>
                        <li class="list-stats-item">
                            <span class="lable"><?php echo Labels::getLabel('LBL_Brand', $siteLangId); ?>:</span>
                            <span class="value"><?php echo ($product['brand_name']) ? $product['brand_name'] : Labels::getLabel('LBL_N/A', $siteLangId); ?></span>
                        </li>
                        <li class="list-stats-item">
                            <span class="lable"><?php echo Labels::getLabel('LBL_Product_Model', $siteLangId); ?>:</span>
                            <span class="value"><?php echo $product['product_model']; ?></span>
                        </li>
                        <li class="list-stats-item">
                            <span class="lable"><?php echo Labels::getLabel('LBL_Minimum_Selling_Price', $siteLangId); ?>:</span>
                            <span class="value"><?php echo CommonHelper::displayMoneyFormat($product['product_min_selling_price']); ?></span>
                        </li>
                        <?php $saleTaxArr = Tax::getSaleTaxCatArr($siteLangId);
                        if (isset($product['ptt_taxcat_id']) && array_key_exists($product['ptt_taxcat_id'], $saleTaxArr)) { ?>
                            <li class="list-stats-item">
                                <span class="lable"><?php echo Labels::getLabel('LBL_Tax_Category', $siteLangId); ?>:</span>
                                <span class="value"><?php echo $saleTaxArr[$product['ptt_taxcat_id']]; ?></span>
                            </li>
                        <?php } ?>
                    </ul>
                    <?php if (count($productSpecifications) > 0) { ?>
                        <div class="mt-4">
                            <div class="h6"><?php echo Labels::getLabel('LBL_Specifications', $siteLangId); ?>:</div>
                            <div class="list list--specification">
                                <ul class="list-stats">
                                    <?php $count = 1;
                                    foreach ($productSpecifications as $key => $specification) {
                                        if ($count > 5) {
                                            continue;
                                        } ?>
                                        <li class="list-stats-item">
                                            <?php echo '<span>' . $specification['prodspec_name'] . " :</span> " . $specification['prodspec_value']; ?></li>
                                    <?php $count++;
                                    } ?>
                                    <?php /*if (count($productSpecifications)>5) { ?>
                                    <li class="link_li"><a href="javascript::void(0)"><?php echo Labels::getLabel('LBL_View_All_Details', $siteLangId); ?></a></li>
                                    <?php }*/ ?>
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
    if (layoutDirection == 'rtl') {
        $('.js-product-gallery').slick({
            dots: true,
            arrows: false,
            autoplay: false,
            pauseOnHover: false,
            slidesToShow: 1,
            draggable: true,
            rtl: true,
        });
    } else {
        $('.js-product-gallery').slick({
            dots: true,
            arrows: false,
            autoplay: false,
            pauseOnHover: false,
            slidesToShow: 1,
            draggable: true,
        });
    }
</script>