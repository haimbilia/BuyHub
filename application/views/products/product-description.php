<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="product-description">
    <?php if (!empty($product['brand_name'])) { ?>
        <div class="brand-title">
            <a class="" href="<?php echo UrlHelper::generateUrl('Brands', 'view', [$product['brand_id']]); ?>"><?php echo $product['brand_name']; ?></a>
        </div>
    <?php } ?>
    <div class="products-title">
        <h1 class="h1"> <?php echo $product['selprod_title']; ?> </h1>
    </div>
    <div class="reviews-wrap">
        <?php if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) { ?>
            <?php $label = (round($product['prod_rating']) > 0) ? round($product['totReviews'], 1) . ' ' . Labels::getLabel('LBL_Reviews', $siteLangId) : Labels::getLabel('LBL_No_Reviews', $siteLangId); ?>
            <div class="products-reviews">
                <div class="products__rating">
                    <i class="icn">
                        <svg class="svg" width="14" height="14">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                            </use>
                        </svg>
                    </i>
                    <span class="rate"><?php echo round($product['prod_rating'], 1); ?></span>
                </div>
                <a href="#itemRatings" class="totals-review nav-scroll-js"><?php echo $label; ?></a>
            </div>
        <?php } ?>
    </div>



    <div class="products-price">
        <span class="products-price-new"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?></span>
        <div> <?php if ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) { ?>
                <del class="products-price-old"><?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></del>
                <span class="products-price-off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span>
            <?php } ?>
        </div>
        <!-- Shop and SelProd Badge  -->
        <?php
        $selProdBadge = Badge::getSelprodBadges($siteLangId, [$product['selprod_id']]);
        $shopBadge = Badge::getShopBadges($siteLangId, [$product['shop_id']]);
        $badgesArr = array_merge($selProdBadge, $shopBadge);
        $this->includeTemplate('_partial/badge-ui.php', ['badgesArr' => $badgesArr, 'siteLangId' => $siteLangId], false);
        ?>
        <!-- Shop and SelProd Badge  -->
    </div>
    <?php if (FatApp::getConfig("CONF_PRODUCT_INCLUSIVE_TAX", FatUtility::VAR_INT, 0) && 0 == Tax::getActivatedServiceId()) { ?>
        <p class="tax-inclusive">
            <?php echo Labels::getLabel('LBL_Inclusive_All_Taxes', $siteLangId); ?>
        </p>
    <?php } ?>

    <!-- Volume Discounts -->
    <div class="block-detail">
        <?php
        if (isset($volumeDiscountRows) && !empty($volumeDiscountRows) && 0 < $currentStock) { ?>

            <ul class="<?php echo (count($volumeDiscountRows) > 1) ? '' : ''; ?> wholesale-slider">
                <?php foreach ($volumeDiscountRows as $volumeDiscountRow) {
                    $volumeDiscount = $product['theprice'] * ($volumeDiscountRow['voldiscount_percentage'] / 100);
                    $price = ($product['theprice'] - $volumeDiscount); ?>
                    <li class="wholesale-slider-item">

                        <div class="wholesale-slider-value">
                            <i class="wholesale-slider-icon">
                                <svg class="svg" width="14" height="14">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#patch-cent">
                                    </use>
                                </svg>

                            </i>
                            <?php echo ($volumeDiscountRow['voldiscount_min_qty']); ?>
                            <?php echo Labels::getLabel('LBL_Or_more', $siteLangId); ?>
                            (<?php echo $volumeDiscountRow['voldiscount_percentage'] . '%'; ?>)

                        </div>
                        <span class="wholesale-slider-price"><?php echo CommonHelper::displayMoneyFormat($price); ?>
                            /
                            <?php echo Labels::getLabel('LBL_Product', $siteLangId); ?></span>
                    </li>
                <?php } ?>
            </ul>

        <?php }  ?>
    </div>




    <!-- Option Rows -->
    <div class="block-detail">
        <?php if (!empty($optionRows)) { ?>
            <div class="row">
                <?php $selectedOptionsArr = $product['selectedOptionValues'];
                $count = 0;
                foreach ($optionRows as $key => $option) {
                    $selectedOptionValue = $option['values'][$selectedOptionsArr[$key]]['optionvalue_name'];
                    $selectedOptionColor = $option['values'][$selectedOptionsArr[$key]]['optionvalue_color_code'];
                    if ($option['option_is_color']) {
                        $selectedOptionColor = ("#" == $selectedOptionColor[0] ? $selectedOptionColor : "#" . $selectedOptionColor);
                    }
                ?>
                    <div class="col-md-6">
                        <h6 class="h6"><?php echo $option['option_name']; ?></h6>
                        <div class="dropdown dropdown-options">
                            <button class="btn btn-outline-gray dropdown-toggle" type="button" data-bs-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
                                <span>
                                    <?php if ($option['option_is_color']) { ?>
                                        <span class="colors" style="background-color:<?php echo $selectedOptionColor; ?>;"></span>
                                    <?php } ?>
                                    <?php echo $selectedOptionValue; ?>
                                </span>
                            </button>
                            <?php if ($option['values']) { ?>
                                <div class="dropdown-menu dropdown-menu-anim scroll scroll-y">
                                    <ul class="nav nav-block">
                                        <?php foreach ($option['values'] as $opVal) {
                                            $isAvailable = true;
                                            if (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) {
                                                $optionUrl = UrlHelper::generateUrl('Products', 'view', array($product['selprod_id']));
                                            } else {
                                                $optionUrl = Product::generateProductOptionsUrl($product['selprod_id'], $selectedOptionsArr, $option['option_id'], $opVal['optionvalue_id'], $product['product_id']);
                                                $optionUrlArr = explode("::", $optionUrl);
                                                if (is_array($optionUrlArr) && count($optionUrlArr) == 2) {
                                                    $optionUrl = $optionUrlArr[0];
                                                    $isAvailable = false;
                                                }
                                            } ?>
                                            <li class="nav__item <?php echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? ' is-active' : ' ';
                                                                    echo (!$optionUrl) ? ' is-disabled' : '';
                                                                    echo (!$isAvailable) ? 'not--available' : ''; ?>">
                                                <?php if ($option['option_is_color'] && $opVal['optionvalue_color_code'] != '') {
                                                    $color = ("#" == $opVal['optionvalue_color_code'][0] ? $opVal['optionvalue_color_code'] : "#" . $opVal['optionvalue_color_code']);
                                                ?>
                                                    <a data-optionValueId="<?php echo $opVal['optionvalue_id']; ?>" data-selectedOptionValues="<?php echo implode("_", $selectedOptionsArr); ?>" title="<?php echo $opVal['optionvalue_name'];
                                                                                                                                                                                                        echo (!$isAvailable) ? ' ' . Labels::getLabel('LBL_Not_Available', $siteLangId) : ''; ?>" class="dropdown-item nav__link <?php echo (!$option['option_is_color']) ? 'selector__link' : '';
                                                                                                                                                                                                                                                                                                                                    echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? ' ' : ' ';
                                                                                                                                                                                                                                                                                                                                    echo (!$optionUrl) ? ' is-disabled' : ''; ?>" href="<?php echo ($optionUrl) ? $optionUrl : 'javascript:void(0)'; ?>">
                                                        <span class="colors" style="background-color:<?php echo $color; ?>;"></span><?php echo $opVal['optionvalue_name']; ?></a>
                                                <?php } else { ?>
                                                    <a data-optionValueId="<?php echo $opVal['optionvalue_id']; ?>" data-selectedOptionValues="<?php echo implode("_", $selectedOptionsArr); ?>" title="<?php echo $opVal['optionvalue_name'];
                                                                                                                                                                                                        echo (!$isAvailable) ? ' ' . Labels::getLabel('LBL_Not_Available', $siteLangId) : ''; ?>" class="dropdown-item nav__link <?php echo (in_array($opVal['optionvalue_id'], $product['selectedOptionValues'])) ? '' : ' ';
                                                                                                                                                                                                                                                                                                                                    echo (!$optionUrl) ? ' is-disabled' : ''; ?>" href="<?php echo ($optionUrl) ? $optionUrl : 'javascript:void(0)'; ?>">
                                                        <?php echo $opVal['optionvalue_name'];  ?> </a>
                                                <?php } ?>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php $count++;
                } ?>
            </div>
        <?php } ?>
    </div>

    <!-- Add To Cart -->
    <div class="block-detail">
        <?php
        if (0 < $currentStock) {
            if (true == $displayProductNotAvailableLable && array_key_exists('availableInLocation', $product) && 0 == $product['availableInLocation']) {  ?>
                <div class="not-available">
                    <svg class="svg" width="16" height="16">
                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info">
                        </use>
                    </svg>
                    <?php echo Labels::getLabel('LBL_NOT_AVAILABLE_FOR_YOUR_LOCATION', $siteLangId); ?>
                </div>

                <?php } else {
                echo $frmBuyProduct->getFormTag();
                $qtyField =  $frmBuyProduct->getField('quantity');
                $qtyField->value = $product['selprod_min_order_qty'];
                $qtyField->addFieldTagAttribute('data-min-qty', $product['selprod_min_order_qty']);
                $qtyFieldName =  $qtyField->getCaption();
                if (strtotime($product['selprod_available_from']) <= strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))) { ?>
                    <div class="row align-items-end">
                        <div class="col-auto">
                            <label class="h6"><?php echo $qtyFieldName; ?></label>
                            <div class="qty-wrapper">
                                <div class="quantity" data-stock="<?php echo $product['selprod_stock']; ?>">
                                    <span class="decrease decrease-js not-allowed"><i class="icn">
                                            <svg class="svg" width="16" height="16">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#minus">
                                                </use>
                                            </svg>
                                        </i>
                                    </span>
                                    <div class="qty-input-wrapper" data-stock="<?php echo $product['selprod_stock']; ?>">
                                        <?php echo $frmBuyProduct->getFieldHtml('quantity'); ?>
                                    </div>
                                    <span class="increase increase-js"><i class="icn">
                                            <svg class="svg" width="16" height="16">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#plus">
                                                </use>
                                            </svg>
                                        </i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <label class="h6">&nbsp;</label>
                            <div class="buy-group">
                                <?php if (strtotime($product['selprod_available_from']) <= strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))) {
                                    //echo $frmBuyProduct->getFieldHtml('btnProductBuy');
                                    echo $frmBuyProduct->getFieldHtml('btnAddToCart');
                                }
                                echo $frmBuyProduct->getFieldHtml('selprod_id'); ?>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                </form>
            <?php echo $frmBuyProduct->getExternalJs();
            }
        } else { ?>
            <div class="tag--soldout tag--soldout-full">
                <h3>
                    <?php echo Labels::getLabel('LBL_Sold_Out', $siteLangId); ?></h3>
                <p>
                    <?php echo Labels::getLabel('LBL_This_item_is_currently_out_of_stock', $siteLangId); ?>
                </p>
            </div>
        <?php }

        if (strtotime($product['selprod_available_from']) > strtotime(FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d'))) { ?>
            <div class="tag--soldout tag--soldout-full">
                <h3><?php echo Labels::getLabel('LBL_Not_Available', $siteLangId); ?></h3>
                <p>
                    <?php echo str_replace('{available-date}', FatDate::Format($product['selprod_available_from']), Labels::getLabel('LBL_This_item_will_be_available_from_{available-date}', $siteLangId)); ?>
                </p>
            </div>
        <?php } ?>
    </div>



    <!-- Upsell Products -->
    <div class="block-detail">
        <?php if (count($upsellProducts) > 0) { ?>
            <div class="h6">
                <?php echo Labels::getLabel('LBL_Product_Add-ons', $siteLangId); ?>
            </div>
            <div class="addons-scrollbar scroll scroll-x">
                <ul class="list-addons list-addons--js">
                    <?php foreach ($upsellProducts as $usproduct) {
                        $cancelClass = '';
                        $uncheckBoxClass = '';
                        if ($usproduct['selprod_stock'] <= 0) {
                            $cancelClass = 'cancel cancelled--js';
                            $uncheckBoxClass = 'remove-add-on';
                        } ?>
                        <li class="addon--js <?php echo $cancelClass; ?>">
                            <div class="item">
                                <figure class="item__pic"><a title="<?php echo $usproduct['selprod_title']; ?>" href="<?php echo UrlHelper::generateUrl('products', 'view', array($usproduct['selprod_id'])) ?>"><img src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'product', array($usproduct['product_id'], 'MINI', $usproduct['selprod_id'])), CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo $usproduct['product_identifier']; ?>">
                                    </a>
                                </figure>
                                <div class="item__description">
                                    <div class="item__title"><a href="<?php echo UrlHelper::generateUrl('products', 'view', array($usproduct['selprod_id'])) ?>"><?php echo $usproduct['selprod_title'] ?></a>
                                    </div>
                                    <div class="item__price">
                                        <?php echo CommonHelper::displayMoneyFormat($usproduct['theprice']); ?>
                                    </div>
                                </div>
                                <?php if ($usproduct['selprod_stock'] <= 0) { ?>
                                    <div class="tag--soldout">
                                        <?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId); ?>
                                    </div>
                                <?php  } ?>
                            </div>

                            <div class="qty-wrapper">
                                <div class="quantity quantity-2" data-stock="<?php echo $usproduct['selprod_stock']; ?>">
                                    <span class="decrease decrease-js"><i class="icn">
                                            <svg class="svg" width="16" height="16">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#minus">
                                                </use>
                                            </svg>
                                        </i></span>
                                    <div class="qty-input-wrapper" data-stock="<?php echo $usproduct['selprod_stock']; ?>">
                                        <input type="text" value="1" data-page="product-view" placeholder="Qty" class="qty-input cartQtyTextBox productQty-js" data-lang="addons[<?php echo $usproduct['selprod_id'] ?>]" name="addons[<?php echo $usproduct['selprod_id'] ?>]">
                                    </div>
                                    <span class="increase increase-js"><i class="icn">
                                            <svg class="svg" width="16" height="16">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#plus">
                                                </use>
                                            </svg>
                                        </i></span>
                                </div>
                            </div>
                            <label class="checkbox">
                                <input <?php echo ($usproduct['selprod_stock'] > 0) ? 'checked="checked"' : ''; ?> type="checkbox" class="cancel <?php echo $uncheckBoxClass; ?>" name="check_addons" title="<?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>">
                            </label>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>
    </div>



</div>