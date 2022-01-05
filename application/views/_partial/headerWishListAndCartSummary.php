<?php defined('SYSTEM_INIT') or die('Invalid Usage');
$user_is_buyer = 0;
if (UserAuthentication::isUserLogged()) {
    $user_is_buyer = User::getAttributesById(UserAuthentication::getLoggedUserId(), 'user_is_buyer');
}
if ($user_is_buyer > 0 || (!UserAuthentication::isUserLogged())) { ?>
    <button type="button" class="quick-nav-link button-cart" data-bs-toggle="offcanvas" data-bs-target="#side-cart" aria-controls="side-cart">
        <i class="icn">
            <svg class="svg" width="18" height="18">
                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite-header.svg#cart"></use>
            </svg>
        </i>
        <span class="txt">
            <?php echo Labels::getLabel("LBL_My_Bag", $siteLangId); ?>
            <span class="cart-qty"><?php echo (Cart::CART_MAX_DISPLAY_QTY < $totalCartItems) ? Cart::CART_MAX_DISPLAY_QTY . '+' : $totalCartItems; ?></span>
            <?php /* if (0 < $cartSummary['cartTotal']) { */ ?>
            <!-- <span class="cartValue"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal']); ?></span> -->
            <?php /* } */ ?>
        </span>
    </button>
    <div class="offcanvas offcanvas-end side-cart" tabindex="-1" id="side-cart" aria-labelledby="side-cartLabel">
        <div class="offcanvas-header side-cart_head">
            <h6>
                <strong><?php echo Labels::getLabel('LBL_ITEMS', $siteLangId); ?>(<?php echo $totalCartItems; ?>)</strong>
            </h6>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>

        </div>
        <?php if ($totalCartItems > 0) { ?>
            <div class="offcanvas-body side-cart_body">
                <div class="short-detail">
                    <ul class="list-cart">
                        <?php
                        if (count($products)) {
                            foreach ($products as $product) {
                                $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
                                $productUrl = UrlHelper::generateUrl('Products', 'View', array($product['selprod_id']));
                                $shopUrl = UrlHelper::generateUrl('Shops', 'View', array($product['shop_id']));
                                $imageUrl =  UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "EXTRA-SMALL", $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                                $imageWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "WEBPEXTRA-SMALL", $product['selprod_id'], 0, $siteLangId)) . $uploadedTime,   CONF_IMG_CACHE_TIME, '.webp');
                        ?>

                                <li class="list-cart-item <?php echo (!$product['in_stock']) ? 'disabled' : '';
                                                            echo ($product['is_digital_product']) ? 'digital_product_tab-js' : 'physical_product_tab-js'; ?>">
                                    <div class="block-img block-img-sm">
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
                                        <button class="btn-remove" type="button" onclick="cart.remove('<?php echo md5($product['key']); ?>')" title="<?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>">
                                            <?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>
                                        </button>
                                    </div>
                                    <div class="block-detail">
                                        <div class="block-detail-top">
                                            <div class="product-profile">
                                                <div class="product-profile-data">
                                                    <div class="category">
                                                        <a href="<?php echo $shopUrl; ?>"><?php echo $product['shop_name']; ?> </a>
                                                    </div>
                                                    <a class="title" title="<?php echo $product['product_name']; ?>" href="<?php echo $productUrl; ?>"><?php echo ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name']; ?></a>
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

                                                    <div class="products-price">
                                                        <span class="products-price-new">
                                                            <?php echo CommonHelper::displayMoneyFormat($product['theprice'] * $product['quantity']); ?>
                                                        </span>
                                                        <?php if ($product['special_price_found']) { ?>
                                                            <span class="products-price-off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span>
                                                        <?php } ?>
                                                    </div>
                                                </div>



                                            </div>

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
            <div class="offcanvas-foot side-cart_foot">
                <div class="cart-summary">
                    <ul>
                        <li>
                            <span class="label"><?php echo Labels::getLabel('LBL_Sub_Total', $siteLangId); ?></span>
                            <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal']); ?></span>
                        </li>
                        <?php if (0 < $cartSummary['cartVolumeDiscount']) { ?>
                            <li>
                                <span class="label"><?php echo Labels::getLabel('LBL_Volume_Discount', $siteLangId); ?></span>
                                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartVolumeDiscount']); ?></span>
                            </li>
                        <?php } ?>
                        <?php ?>
                        <?php $netChargeAmt = $cartSummary['cartTotal'] - ((0 < $cartSummary['cartVolumeDiscount']) ? $cartSummary['cartVolumeDiscount'] : 0); ?>
                        <li class="highlighted">
                            <span class="label"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?></span>
                            <span class="value"><?php echo CommonHelper::displayMoneyFormat($netChargeAmt); ?></span>
                        </li>
                    </ul>
                </div>

                <div class="buttons-group">
                    <a href="javascript:void(0);" onclick="cart.clear();" class="btn btn-outline-brand"><?php echo Labels::getLabel('LBL_CLEAR_CART', $siteLangId); ?> </a>
                    <a class="btn btn-brand" href="<?php echo UrlHelper::generateUrl('cart'); ?>"><?php echo Labels::getLabel('LBL_Proceed_To_Pay', $siteLangId); ?></a>
                </div>

            </div>
        <?php } else { ?>
            <div class="block--empty m-auto text-center"> <img class="block__img" src="<?php echo CONF_WEBROOT_URL; ?>images/retina/empty_cart.svg" alt="<?php echo Labels::getLabel('LBL_No_Record_Found', $siteLangId); ?>" width="80">
                <h4><?php echo Labels::getLabel('LBL_Your_Shopping_Bag_is_Empty', $siteLangId); ?></h4>
            </div>
        <?php } ?>
    </div>
<?php } ?>