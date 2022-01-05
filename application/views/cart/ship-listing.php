<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$showAddToFavorite = true;
if (UserAuthentication::isUserLogged() && (!User::isBuyer())) {
    $showAddToFavorite = false;
}
?>
<div class="cart-blocks">
    <?php
    $productsCount = count($products);
    if ($productsCount) {
        uasort($products, function ($a, $b) {
            return  $b['fulfillment_type'] - $a['fulfillment_type'];
        });
    ?>
        <ul class="list-cart <?php echo (count($fulfillmentProdArr[Shipping::FULFILMENT_SHIP]) != $productsCount) ? '' : ''; ?>">
            <?php
            //if (count($fulfillmentProdArr[Shipping::FULFILMENT_SHIP]) > 0 && count($fulfillmentProdArr[Shipping::FULFILMENT_SHIP]) != $productsCount) { 
            if (count($fulfillmentProdArr[Shipping::FULFILMENT_SHIP]) != $productsCount) {
            ?>
                <li class="minus-space">
                    <div class="delivery-info">
                        <span> <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info">
                                </use>
                            </svg><?php echo Labels::getLabel('MSG_SOME_ITEMS_NOT_AVAILABLE_FOR_SHIPPING', $siteLangId); ?>
                            <?php if (count($fulfillmentProdArr[Shipping::FULFILMENT_PICKUP]) == $productsCount) { ?>
                                <a href="javascript:void(0);" onClick="listCartProducts(<?php echo Shipping::FULFILMENT_PICKUP; ?>);" class=""><?php echo Labels::getLabel('LBL_Pickup_Entire_Order', $siteLangId); ?></a>
                            <?php } ?>
                        </span>

                        <a class="btn-close" href="javascript:void(0);" onClick="removePickupOnlyProducts();">

                        </a>

                    </div>
                </li>
                <?php foreach ($products as $key => $product) {
                    if ($product['fulfillment_type'] != Shipping::FULFILMENT_PICKUP) {
                        continue;
                    }
                    $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
                    $productUrl = UrlHelper::generateUrl('Products', 'View', array($product['selprod_id']));
                    $shopUrl = UrlHelper::generateUrl('Shops', 'View', array($product['shop_id']));
                    $imageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "THUMB", $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                    $imageWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "WEBPTHUMB", $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
                    $productTitle =  ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name'];
                ?>
                    <li class="list-cart-item <?php echo md5($product['key']); ?> <?php echo (!$product['in_stock']) ? 'disabled' : ''; ?> list-saved-later">
                        <div class="block-img">
                            <div class="products-img">
                                <a href="<?php echo $productUrl; ?>">
                                    <?php
                                    $pictureAttr = [
                                        'webpImageUrl' => $imageWebpUrl,
                                        'jpgImageUrl' => $imageUrl,
                                        'imageUrl' => $imageUrl,
                                        'ratio' => '1:1',
                                        'alt' => $productTitle,
                                        'siteLangId' => $siteLangId,
                                    ];

                                    $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                                    ?>
                                </a>
                            </div>
                        </div>
                        <div class="block-detail">
                            <div class="block-detail-top">
                                <div class="product-profile">
                                    <div class="product-profile-data">
                                        <a class="title" href="<?php echo $productUrl; ?>"><?php echo $productTitle; ?></a>
                                        <div class="options">
                                            <p class="">
                                                <?php
                                                if (isset($product['options']) && count($product['options'])) {
                                                    foreach ($product['options'] as $key => $option) {
                                                        if (0 < $key) {
                                                            echo ' | ';
                                                        }
                                                        echo $option['option_name'] . ':'; ?> <span class="text--dark"><?php echo $option['optionvalue_name']; ?></span>
                                                <?php }
                                                } ?></p>
                                        </div>
                                        <p class="text-danger pt-2">
                                            <?php echo Labels::getLabel('LBL_NOT_AVAILABLE_FOR_SHIPPING', $siteLangId); ?></p>
                                    </div>
                                </div>

                                <div class="cart-action">
                                    <ul class="actions">
                                        <li>
                                            <a href="javascript:void(0)" onClick="moveToSaveForLater( '<?php echo md5($product['key']); ?>',<?php echo $product['selprod_id']; ?>, <?php echo Shipping::FULFILMENT_SHIP; ?> );">

                                                <i class="icn">
                                                    <svg class="svg" width="20" height="20">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#saveforlater">
                                                        </use>
                                                    </svg>

                                                </i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php } ?>
        </ul>
        <ul class="list-cart">
        <?php } ?>

        <?php foreach ($products as $product) {

            if ($product['fulfillment_type'] == Shipping::FULFILMENT_PICKUP) {
                continue;
            }
            $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
            $productUrl = UrlHelper::generateUrl('Products', 'View', array($product['selprod_id']));
            $shopUrl = UrlHelper::generateUrl('Shops', 'View', array($product['shop_id']));
            $imageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "THUMB", $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            $imageWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "WEBPTHUMB", $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
            $productTitle =  ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name'];
        ?>

            <li class="list-cart-item <?php echo md5($product['key']); ?> <?php echo (!$product['in_stock']) ? 'disabled' : ''; ?>">
                <div class="block-img">
                    <div class="products-img">
                        <a href="<?php echo $productUrl; ?>">
                            <?php
                            $pictureAttr = [
                                'webpImageUrl' => $imageWebpUrl,
                                'jpgImageUrl' => $imageUrl,
                                'imageUrl' => $imageUrl,
                                'ratio' => '1:1',
                                'alt' => $productTitle,
                                'siteLangId' => $siteLangId,
                            ];

                            $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                            ?>
                        </a>
                    </div>
                    <button class="btn-remove" type="button" onclick="cart.remove('<?php echo md5($product['key']); ?>','cart')" title="<?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>">
                        <?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>
                    </button>
                </div>
                <div class="block-detail">
                    <div class="block-detail-top">
                        <div class="item">
                            <div class="product-profile-data">

                                <a class="title" href="<?php echo $productUrl; ?>"><?php echo $productTitle; ?></a>

                                <div class="options">

                                    <?php
                                    if (isset($product['options']) && count($product['options'])) {
                                        foreach ($product['options'] as $key => $option) {
                                            if (0 < $key) {
                                                echo ' | ';
                                            }
                                            echo $option['option_name'] . ':'; ?> <span class="text-muted"><?php echo $option['optionvalue_name']; ?></span>
                                    <?php }
                                    } ?>

                                </div>
                            </div>
                        </div>
                        <div class="cart-action">
                            <ul class="actions">
                                <?php if ($showAddToFavorite) { ?>
                                    <li>
                                        <?php if (FatApp::getConfig('CONF_ADD_FAVORITES_TO_WISHLIST', FatUtility::VAR_INT, 1) == applicationConstants::NO) {
                                            if (empty($product['ufp_id'])) {  ?>
                                                <a href="javascript:void(0)" class="" onClick="addToFavourite( '<?php echo md5($product['key']); ?>',<?php echo $product['selprod_id']; ?> );" title="<?php echo Labels::getLabel('LBL_Move_to_wishlist', $siteLangId); ?>">
                                                    <svg class="svg" width="20" height="20">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#heart">
                                                        </use>
                                                    </svg>
                                                </a>
                                            <?php } else { ?>
                                                <a href="javascript:void(0)" class="is-active" title="<?php echo Labels::getLabel('LBL_Already_marked_as_favourites.', $siteLangId); ?>">
                                                    <i class="icn">
                                                        <svg class="svg" width="16" height="16">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#heart">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                </a>
                                            <?php }
                                        } else {
                                            if (empty($product['is_in_any_wishlist'])) { ?>
                                                <a href="javascript:void(0)" class="" onClick="moveToWishlist( <?php echo $product['selprod_id']; ?>, event, '<?php echo md5($product['key']); ?>' );" title="<?php echo Labels::getLabel('LBL_Move_to_wishlist', $siteLangId); ?>">

                                                    <svg class="svg" width="20" height="20">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#heart">
                                                        </use>
                                                    </svg>
                                                </a>
                                            <?php  } else { ?>
                                                <a class="favourite wishListLink-Js is-active" data-id="<?php echo $product['selprod_id']; ?>" href="javascript:void(0)" onClick="viewWishList(<?php echo $product['selprod_id']; ?>,this,event);" title="<?php echo Labels::getLabel('LBL_Remove_product_from_your_wishlist', $siteLangId); ?>">
                                                    <i class="icn">
                                                        <svg class="svg" width="16" height="16">
                                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#heart">
                                                            </use>
                                                        </svg>
                                                    </i>
                                                </a>
                                        <?php }
                                        } ?>
                                    </li>
                                <?php } ?>
                                <li>
                                    <a href="javascript:void(0)" onClick="moveToSaveForLater( '<?php echo md5($product['key']); ?>',<?php echo $product['selprod_id']; ?>, <?php echo Shipping::FULFILMENT_SHIP; ?> );" title="<?php echo Labels::getLabel('LBL_SAVE_FOR_LATER', $siteLangId); ?>">
                                        <svg class="svg" width="20" height="20">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#saveforlater">
                                            </use>
                                        </svg>
                                    </a>
                                </li>

                            </ul>

                        </div>
                    </div>
                    <div class="block-detail-bottom">
                        <div class="product-quantity">
                            <label class="form-label" for=""><?php echo Labels::getLabel('LBL_QTY', $siteLangId); ?></label>
                            <div class="quantity quantity-sm" data-stock="<?php echo $product['selprod_stock']; ?>">
                                <span class="decrease decrease-js <?php echo ($product['quantity'] <= $product['selprod_min_order_qty']) ? 'not-allowed' : ''; ?>">
                                    <i class="icn">
                                        <svg class="svg" width="10" height="10">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#minus">
                                            </use>
                                        </svg>
                                    </i></span>
                                <div class="qty-input-wrapper" data-stock="<?php echo $product['selprod_stock']; ?>">
                                    <input name="qty_<?php echo md5($product['key']); ?>" data-key="<?php echo md5($product['key']); ?>" class="qty-input cartQtyTextBox productQty-js" value="<?php echo $product['quantity']; ?>" type="text" />
                                </div>
                                <span class="increase increase-js <?php echo ($product['selprod_stock'] <= $product['quantity']) ? 'not-allowed' : ''; ?>">
                                    <i class="icn">
                                        <svg class="svg" width="10" height="10">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#plus">
                                            </use>
                                        </svg>
                                    </i>
                                </span>
                            </div>
                        </div>
                        <div class="products-price">
                            <?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?></div>
                    </div>
                </div>
            </li>
        <?php } ?>

        </ul>
    <?php } ?>
    <?php if (0 < count($saveForLaterProducts)) { ?>
        <h5 class="cart-title mt-5"><?php echo Labels::getLabel('LBL_Save_For_later', $siteLangId); ?>
            (<?php echo count($saveForLaterProducts); ?>)</h5>
        <ul class="list-cart">
            <?php foreach ($saveForLaterProducts as $product) {
                $productUrl = UrlHelper::generateUrl('Products', 'View', array($product['selprod_id']));
                $imageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "THUMB", $product['selprod_id'], 0, $siteLangId)), CONF_IMG_CACHE_TIME, '.jpg');
                $imageWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "WEBPTHUMB", $product['selprod_id'], 0, $siteLangId)), CONF_IMG_CACHE_TIME, '.webp');
                $productTitle =  ($product['selprod_title']) ? $product['selprod_title'] : $product['product_name'];
            ?>
                <li class="list-cart-item  <?php echo isset($product['key']) ? md5($product['key']) : ''; ?> <?php echo (!$product['in_stock']) ? 'disabled' : ''; ?>">
                    <div class="block-img">
                        <div class="products-img">
                            <a href="<?php echo $productUrl; ?>">
                                <?php
                                $pictureAttr = [
                                    'webpImageUrl' => $imageWebpUrl,
                                    'jpgImageUrl' => $imageUrl,
                                    'imageUrl' => $imageUrl,
                                    'ratio' => '1:1',
                                    'alt' => $productTitle,
                                    'siteLangId' => $siteLangId,
                                ];

                                $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                                ?>
                            </a>
                        </div>
                        <button class="btn-remove" type="button" onclick="removeFromWishlist(<?php echo $product['selprod_id']; ?>, <?php echo $product['uwlp_uwlist_id']; ?>, event)">
                            <?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>
                        </button>

                    </div>
                    <div class="block-detail">
                        <div class="block-detail-top">
                            <div class="product-profile">
                                <div class="product-profile-data">
                                    <a class="title" href="<?php echo $productUrl; ?>"><?php echo $productTitle; ?></a>
                                    <div class="options">
                                        <?php
                                        if (isset($product['options']) && count($product['options'])) {
                                            foreach ($product['options'] as $key => $option) {
                                                if (0 < $key) {
                                                    echo ' | ';
                                                }
                                                echo $option['option_name'] . ':'; ?> <span class="text--dark"><?php echo $option['optionvalue_name']; ?></span>
                                        <?php }
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-action">
                                <ul class="actions">
                                    <li>
                                        <a href="javascript:void(0)" onclick="moveToCart(<?php echo $product['selprod_id']; ?>, <?php echo $product['uwlp_uwlist_id']; ?>, event, <?php echo Shipping::FULFILMENT_SHIP; ?>)">
                                            <svg class="svg" width="20" height="20">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#cart">
                                                </use>
                                            </svg>
                                        </a>

                                    </li>

                                </ul>
                            </div>
                        </div>
                        <div class="block-detail-bottom">
                            <div class="products-price">
                                <?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?></div>
                        </div>

                    </div>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>
</div>