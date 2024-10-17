<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (isset($collection['categories']) && count($collection['categories'])) { ?>
    <section class="section" data-section="section">
        <div class="container">
            <div class="section-head category-product">
                <?php echo ($collection['collection_name'] != '') ? ' <div class="section-heading"><h2>' . $collection['collection_name'] . '</h2></div>' : ''; ?>
                <div class="section-action">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php
                        $x = 0;
                        foreach ($collection['categories'] as $key => $category) {
                            $x++; ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo 1 == $x ? 'active' : ''; ?>" data-bs-toggle="tab"
                                    data-bs-target="#tb-<?php echo $key . "-" . $collection['collection_id']; ?>" role="tab"
                                    aria-controls="tabpanel-<?php echo $key . "-" . $collection['collection_id']; ?>">
                                    <?php echo $category['catData']['prodcat_name']; ?>
                                </button>
                            </li>
                            <?php if (4 == $x) {
                                break;
                            }
                        } ?>
                    </ul>
                </div>
            </div>
            <div class="section-body">
                <div class="tab-content" role="tabpanel">
                    <?php $j = 0;
                    foreach ($collection['categories'] as $key => $category) {
                        $j++;
                        ?>
                        <div class="tab-pane fade category-product-layout-1  <?php echo 1 == $j ? 'show active' : ''; ?>"
                            id="tb-<?php echo $key . "-" . $collection['collection_id']; ?>"
                            data-view="<?php echo (0 < $collection['collection_primary_records'] ? $collection['collection_primary_records'] : 4); ?>">
                            <div class="product-listing">
                                <?php
                                $tRightRibbons = $category['tRightRibbons'];

                                $i = 1;
                                foreach ($category['products'] as $key => $product) {

                                    $selProdRibbons = [];
                                    if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                                        $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
                                    }
                                    ?>
                                    <div class="product-listing-item">
                                        <div
                                            class="products <?php echo (isset($layoutClass)) ? $layoutClass : ''; ?> <?php if ($product['selprod_stock'] <= 0) { ?> out-of-stock <?php } ?>">
                                            <div class="products-body">
                                                <?php if ($product['selprod_stock'] <= 0) { ?>
                                                    <div class="out-of-stock-txt">
                                                        <?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId); ?>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                if (!empty($selProdRibbons)) {
                                                    foreach ($selProdRibbons as $ribbRow) {
                                                        $this->includeTemplate('_partial/ribbon-ui.php', ['ribbRow' => $ribbRow], false);
                                                    }
                                                } ?>
                                                <?php if (true == $displayProductNotAvailableLable && array_key_exists('availableInLocation', $product) && 0 == $product['availableInLocation']) { ?>
                                                    <div class="not-available">
                                                        <svg class="svg">
                                                            <use
                                                                xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#linkedinfo">
                                                            </use>
                                                        </svg>
                                                        <?php echo Labels::getLabel('LBL_NOT_AVAILABLE', $siteLangId); ?>
                                                    </div>
                                                <?php } ?>

                                                <?php $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']); ?>
                                                <div class="products-img">
                                                    <a title="<?php echo $product['selprod_title']; ?>"
                                                        href="<?php echo !isset($product['promotion_id']) ? UrlHelper::generateUrl('Products', 'View', array($product['selprod_id'])) : UrlHelper::generateUrl('Products', 'track', array($product['promotion_record_id'])); ?>">
                                                        <?php
                                                        $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id']);
                                                        $pictureAttr = [
                                                            'webpImageUrl' => [ImageDimension::VIEW_DESKTOP => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "WEBP" . ImageDimension::VIEW_CLAYOUT2, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp')],
                                                            'jpgImageUrl' => [ImageDimension::VIEW_DESKTOP => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_CLAYOUT2, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg')],
                                                            'ratio' => '1:1',
                                                            'imageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_CLAYOUT2, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                                                            'alt' => (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $product['prodcat_name'],
                                                            'siteLangId' => $siteLangId,
                                                        ];

                                                        $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                                                        ?>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="products-foot">
                                                <a class="products-title" title="<?php echo $product['selprod_title']; ?>"
                                                    href="<?php echo UrlHelper::generateUrl('Products', 'View', array($product['selprod_id'])); ?>"><?php echo $product['selprod_title']; ?>
                                                </a>
                                                <?php include(CONF_THEME_PATH . '_partial/collection/product-price.php'); ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $i++;
                                } ?>
                            </div>
                        </div>
                        <?php if (4 == $j) {
                            break;
                        }
                    } ?>
                </div>
            </div>
            <?php if (count($collection['categories']) > 4) { ?>
                <div class="section-foot">
                    <a href="<?php echo UrlHelper::generateUrl('Collections', 'View', array($collection['collection_id'])); ?>"
                        class="link-underline"><?php echo Labels::getLabel('LBL_VIEW_ALL', $siteLangId); ?></a>
                </div>
            <?php } ?>

        </div>
    </section>
<?php } ?>