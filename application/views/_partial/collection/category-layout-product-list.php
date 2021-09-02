<div id="tabUl" class="tabs tabs--flat-js justify-content-md-center tabs--mobileview">
    <ul>
        <?php foreach ($collection['categories'] as $key => $category) { ?>
            <li class=""><a href="#tb-<?php echo $key . "-" . $collection['collection_id'];; ?>"><?php echo $category['catData']['prodcat_name']; ?></a>
            </li>
        <?php } ?>
    </ul>
</div>
<?php foreach ($collection['categories'] as $key => $category) { ?>

    <div id="tb-<?php echo $key . "-" . $collection['collection_id'];; ?>" class="tabs-content tabs-content-js" style="display: block;">
        <div class="ft-pro-wrapper">
            <?php
            $tLeftRibbons = $category['tLeftRibbons'];
            $tRightRibbons = $category['tRightRibbons'];

            $i = 1;
            foreach ($category['products'] as $key => $product) { 
                $selProdRibbons = [];
                if (array_key_exists($product['selprod_id'], $tLeftRibbons)) {
                    $selProdRibbons[] = $tLeftRibbons[$product['selprod_id']];
                }

                if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                    $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
                }
            ?>
                <div class="items">
                    <?php $prodImgSize = 'MEDIUM'; ?>

                    <!--product tile-->
                    <div class="products <?php echo (isset($layoutClass)) ? $layoutClass : ''; ?> <?php if ($product['selprod_stock'] <= 0) { ?> item--sold  <?php } ?>">
                        <?php if ($product['selprod_stock'] <= 0) { ?>
                            <span class="tag--soldout"><?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId); ?></span>
                        <?php  } ?>

                        <div class="products_body">
                            <?php if (true == $displayProductNotAvailableLable && array_key_exists('availableInLocation', $product) && 0 == $product['availableInLocation']) { ?>
                                <div class="not-available"><svg class="svg">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info">
                                        </use>
                                    </svg> <?php echo Labels::getLabel('LBL_NOT_AVAILABLE', $siteLangId); ?></div>
                            <?php } ?>
                            <?php include(CONF_THEME_PATH . '_partial/collection-ui.php'); ?>
                            <?php $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']); ?>
                            <div class="products_img">
                                <a title="<?php echo $product['selprod_title']; ?>" href="<?php echo !isset($product['promotion_id']) ? UrlHelper::generateUrl('Products', 'View', array($product['selprod_id'])) : UrlHelper::generateUrl('Products', 'track', array($product['promotion_record_id'])); ?>">
                                    <?php
                                    $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id']);
                                    $pictureAttr = [
                                        'webpImageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], (isset($prodImgSize) && isset($i) && ($i == 1)) ? $prodImgSize : "WEBPCLAYOUT3", $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp'),
                                        'jpgImageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], (isset($prodImgSize) && isset($i) && ($i == 1)) ? $prodImgSize : "CLAYOUT3", $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                                        'ratio' => '1:1',
                                        'alt' => (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $product['prodcat_name'],
                                        'siteLangId' => $siteLangId,
                                    ];

                                    $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                                    ?>
                                </a>
                            </div>
                        </div>
                        <div class="products_foot">
                            <div class="products_title">
                                <a title="<?php echo $product['selprod_title']; ?>" href="<?php echo UrlHelper::generateUrl('Products', 'View', array($product['selprod_id'])); ?>"><?php echo $product['selprod_title']; ?>
                                </a>
                            </div>
                            <?php include(CONF_THEME_PATH . '_partial/collection/product-price.php'); ?>
                        </div>
                    </div>
                    <!--/product tile-->

                </div>
            <?php $i++;
            } ?>
        </div>

    </div>
<?php }
