<?php defined('SYSTEM_INIT') or die('Invalid Usage');

if (User::isBuyer(true) || (!UserAuthentication::isUserLogged())) { ?>
    <!-- offcanvas-side-cart -->
    <div class="offcanvas offcanvas-side-cart offcanvas-end" tabindex="-1" id="side-cart" aria-labelledby="side-cartLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">
                <?php echo Labels::getLabel('LBL_ITEMS', $siteLangId); ?> <span class="count-items"> (<?php echo $totalCartItems; ?>) </span>
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>

        </div>
        <?php if ($totalCartItems > 0) { ?>
            <div class="offcanvas-body">
                <div class="short-detail">
                    <ul class="list-cart">
                        <?php
                        if (count($products)) {
                            foreach ($products as $product) {
                                $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
                                $productUrl = UrlHelper::generateUrl('Products', 'View', array($product['selprod_id']));
                                $shopUrl = UrlHelper::generateUrl('Shops', 'View', array($product['shop_id']));
                                $imageUrl =  UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_EXTRA_SMALL, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                $imageWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "WEBP" . ImageDimension::VIEW_EXTRA_SMALL, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime,   CONF_IMG_CACHE_TIME, '.webp');
                        ?>

                                <li class="list-cart-item block-cart block-cart-sm <?php echo (!$product['in_stock']) ? 'disabled' : '';
                                                                                    echo ($product['is_digital_product']) ? 'digital_product_tab-js' : 'physical_product_tab-js'; ?>">
                                    <div class="block-cart-img ">
                                        <div class="products-img">
                                            <a href="<?php echo $productUrl; ?>">
                                                <?php
                                                $pictureAttr = [
                                                    'siteLangId' => $siteLangId,
                                                    'webpImageUrl' => $imageWebpUrl,
                                                    'jpgImageUrl' => $imageUrl,
                                                    'imageUrl' => $imageUrl,
                                                    'alt' => $product['product_name'],
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
                                                    <a class="title" title="<?php echo $product['product_name']; ?>" href="<?php echo $productUrl; ?>"><?php echo ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name']; ?></a>
                                                    <div class="products-price">
                                                        <span class="products-price-new">
                                                            <?php echo CommonHelper::displayMoneyFormat($product['theprice'] * $product['quantity']); ?>
                                                        </span>
                                                        <?php if ($product['special_price_found']) { ?>
                                                            <span class="products-price-off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="options">
                                                        <?php
                                                        if (isset($product['options']) && count($product['options'])) {
                                                            $count = 0;
                                                            foreach ($product['options'] as $option) {
                                                        ?>
                                                                <?php echo ($count > 0) ? ' | ' : '';
                                                                echo $option['option_name'] . ':'; ?>
                                                                <?php echo $option['optionvalue_name']; ?>
                                                        <?php $count++;
                                                            }
                                                        } ?>
                                                        | <?php echo Labels::getLabel('LBL_Quantity:', $siteLangId) ?>
                                                        <?php echo $product['quantity']; ?> </div>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-cart-detail-bottom">
                                            <ul class="cart-action">
                                                <li class="cart-action-item">
                                                    <button class="btn btn-link" type="button" onclick="cart.remove('<?php echo md5($product['key']); ?>')" title="<?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>">
                                                        <?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>
                                                    </button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                        <?php
                            }
                        } else {
                            echo Labels::getLabel('LBL_Your_cart_is_empty', $siteLangId);
                        } ?>
                    </ul>
                </div>
            </div>
            <div class="offcanvas-foot">
                <ul class="cart-summary">
                    <li class="cart-summary-item">
                        <span class="label"><?php echo Labels::getLabel('LBL_Sub_Total', $siteLangId); ?></span>
                        <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal']); ?></span>
                    </li>
                    <?php if (0 < $cartSummary['cartVolumeDiscount']) { ?>
                        <li class="cart-summary-item">
                            <span class="label"><?php echo Labels::getLabel('LBL_Volume_Discount', $siteLangId); ?></span>
                            <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartVolumeDiscount']); ?></span>
                        </li>
                    <?php } ?>
                    <?php ?>
                    <?php $netChargeAmt = $cartSummary['cartTotal'] - ((0 < $cartSummary['cartVolumeDiscount']) ? $cartSummary['cartVolumeDiscount'] : 0); ?>
                    <li class="cart-summary-item highlighted">
                        <span class="label"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?></span>
                        <span class="value"><?php echo CommonHelper::displayMoneyFormat($netChargeAmt); ?></span>
                    </li>
                </ul>

                <div class="buttons-group">
                    <a href="javascript:void(0);" onclick="cart.clear();" class="btn btn-outline-gray"><?php echo Labels::getLabel('LBL_CLEAR_CART', $siteLangId); ?> </a>
                    <a class="btn btn-brand" href="<?php echo UrlHelper::generateUrl('cart'); ?>"><?php echo Labels::getLabel('LBL_Proceed_To_Pay', $siteLangId); ?></a>
                </div>

            </div>
        <?php } else { ?>
            <div class="block-empty m-auto text-center">
                <img class="block__img" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/empty_cart.svg" alt="<?php echo Labels::getLabel('LBL_No_Record_Found', $siteLangId); ?>" width="80">
                <h4>
                    <?php echo Labels::getLabel('LBL_Your_Shopping_Bag_is_Empty', $siteLangId); ?></h4>
            </div>
        <?php } ?>
    </div>
<?php } ?>