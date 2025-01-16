<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="review-total">
    <div class="review-total-head">
        <h3 class="review-total-title dropdown-toggle-custom collapsed" data-bs-toggle="collapse" data-bs-target="#review-cart" aria-haspopup="true" aria-expanded="false">
            <?php echo Labels::getLabel('LBL_REVIEW_CART', $siteLangId); ?>
            <span class="count-items">
                <?php echo count($products) . ' ' . Labels::getLabel('LBL_ITEMS', $siteLangId); ?>
            </span>
            <i class="dropdown-toggle-custom-arrow"></i>
        </h3>
    </div>
    <div class="review-total-body collapse" id="review-cart">
        <ul class="list-cart">
            <?php
            if (count($products)) {
                foreach ($products as $product) {
                    $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
                    $productUrl = !$isAppUser ? UrlHelper::generateUrl('Products', 'View', array($product['selprod_id'])) : 'javascript:void(0)';
                    $shopUrl = !$isAppUser ? UrlHelper::generateUrl('Shops', 'View', array($product['shop_id'])) : 'javascript:void(0)';
                    $imageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $imageWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], 'WEBP' . ImageDimension::VIEW_THUMB, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp'); ?>


                    <li class="list-cart-item block-cart block-cart-sm">
                        <div class="block-cart-img">
                            <div class="products-img">
                                <a href="<?php echo $productUrl; ?>">
                                    <?php
                                    $pictureAttr = [
                                        'webpImageUrl' => [ImageDimension::VIEW_DESKTOP => $imageWebpUrl],
                                        'jpgImageUrl' => [ImageDimension::VIEW_DESKTOP => $imageUrl],
                                        'imageUrl' => $imageUrl,
                                        'ratio' => '3:4',
                                        'alt' => $product['product_name'],
                                        'siteLangId' => $siteLangId,
                                    ];

                                    $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                                    ?>
                                </a>
                            </div>
                        </div>
                        <div class="block-cart-detail">
                            <div class="block-cart-detail-top">
                                <div class="product-profile">
                                    <div class="product-profile-data">
                                        <a class="title" title="<?php echo $product['selprod_title']; ?>" href="<?php echo UrlHelper::generateUrl('Products', 'View', array($product['selprod_id'])); ?>">
                                            <?php echo $product['selprod_title']; ?>
                                        </a>
                                        <?php require(CONF_THEME_PATH . '_partial/collection/product-price.php'); ?>
                                        <div class="options">
                                            <?php if (isset($product['options']) && count($product['options'])) {
                                                $optionStr = '';
                                                foreach ($product['options'] as $option) {
                                                    $optionStr .= $option['optionvalue_name'] . '|';
                                                }
                                                echo rtrim($optionStr, '|');
                                            }

                                            echo ' | ' . Labels::getLabel('LBL_Quantity', $siteLangId) . ': ' . $product['quantity']; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
            <?php }
            } ?>
        </ul>
    </div>
    <!-- <div class="selected-panel-action">
        <a href="javascript:void(0);" onclick="viewOrder()" ; class="btn btn-brand btn-sm ripplelink">
            <?php // echo Labels::getLabel('LBL_View_Order', $siteLangId); 
            ?>
        </a>
    </div> -->
</div>