<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="product-description">
    <div class="product-description-inner">

        <!-- Title, Rating and Review -->
        <div class="products__title">
            <div>
                <h1> <?php echo $product['selprod_title']; ?> </h1>
                <div class="favourite-wrapper favourite-wrapper-detail ">
                    <?php
                    $includeRibbon = false;
                    include(CONF_THEME_PATH . '_partial/collection-ui.php'); ?>
                </div>
            </div>
            <?php if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) { ?>
                <?php $label = (round($product['prod_rating']) > 0) ? round($product['totReviews'], 1) . ' ' . Labels::getLabel('LBL_Reviews', $siteLangId) : Labels::getLabel('LBL_No_Reviews', $siteLangId); ?>
                <div class="products-reviews">
                    <div class="products__rating">
                        <i class="icn"><svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                </use>
                            </svg>
                        </i>
                        <span class="rate"><?php echo round($product['prod_rating'], 1); ?></span>
                    </div>
                    <a href="#itemRatings" class="totals-review link nav-scroll-js"><?php echo $label; ?></a>
                </div>
            <?php } ?>
        </div>

        <!-- Brand Row -->
        <div class="block-detail">
            <?php if (!empty($product['brand_name'])) { ?>
                <div class="brand-data"><span class="txt-gray-light"><?php echo Labels::getLabel('LBL_Brand', $siteLangId); ?>:</span>
                    <?php echo $product['brand_name']; ?></div>
            <?php } ?>

            <div class="products__price">
                <span class="original_price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?></span>
                <?php if ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) { ?>
                    <del class="products__price_old"><?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></del>
                    <span class="product_off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></span>
                <?php } ?>

                <?php
                $bdgSelProdId = $product['selprod_id'];
                $bdgProdId = $product['product_id'];
                $bdgShopId = $product['shop_id'];
                $bdgExcludeCndType = BadgeLinkCondition::SHOP_BADGES_COND_TYPES;
                include(CONF_THEME_PATH . '_partial/get-badge.php'); ?>
            </div>
            <?php if (FatApp::getConfig("CONF_PRODUCT_INCLUSIVE_TAX", FatUtility::VAR_INT, 0) && 0 == Tax::getActivatedServiceId()) { ?>
                <p class="tax-inclusive">
                    <?php echo Labels::getLabel('LBL_Inclusive_All_Taxes', $siteLangId); ?>
                </p>
            <?php } ?>
        </div>

        <div class="divider"></div>
        
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
                            <div class="h6"><?php echo $option['option_name']; ?></div>
                            <div class="dropdown dropdown-options">
                                <button class="btn btn-outline-gray dropdown-toggle" type="button" data-toggle="dropdown" data-display="static" aria-haspopup="true" aria-expanded="false">
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
                        <svg class="svg">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info">
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
                                                    <svg class="svg" width="16px" height="16px">
                                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#minus">
                                                        </use>
                                                    </svg>
                                                </i>
                                            </span>
                                            <div class="qty-input-wrapper" data-stock="<?php echo $product['selprod_stock']; ?>">
                                                <?php echo $frmBuyProduct->getFieldHtml('quantity'); ?>
                                            </div>
                                            <span class="increase increase-js"><i class="icn">
                                                    <svg class="svg" width="16px" height="16px">
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

        <!-- Volume Discounts -->
        <div class="block-detail">
            <?php
            if (isset($volumeDiscountRows) && !empty($volumeDiscountRows) && 0 < $currentStock) { ?>
                <div class="h6">
                    <?php echo Labels::getLabel('LBL_Wholesale_Price_(Piece)', $siteLangId); ?>:
                </div>
                <div class="<?php echo (count($volumeDiscountRows) > 1) ? 'js--discount-slider' : ''; ?> discount-slider" dir="<?php echo CommonHelper::getLayoutDirection(); ?>">
                    <?php foreach ($volumeDiscountRows as $volumeDiscountRow) {
                        $volumeDiscount = $product['theprice'] * ($volumeDiscountRow['voldiscount_percentage'] / 100);
                        $price = ($product['theprice'] - $volumeDiscount); ?>
                        <div class="item">
                            <div class="qty__value">
                                <?php echo ($volumeDiscountRow['voldiscount_min_qty']); ?>
                                <?php echo Labels::getLabel('LBL_Or_more', $siteLangId); ?>
                                (<?php echo $volumeDiscountRow['voldiscount_percentage'] . '%'; ?>)
                                <span class="item__price"><?php echo CommonHelper::displayMoneyFormat($price); ?>
                                    /
                                    <?php echo Labels::getLabel('LBL_Product', $siteLangId); ?></span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <script>
                    $("document").ready(function() {
                        $('.js--discount-slider').slick(getSlickSliderSettings(2, 1, langLbl
                            .layoutDirection, false, {
                                1199: 2,
                                1023: 2,
                                767: 2,
                                480: 2
                            }, false));
                    });
                </script>
            <?php }  ?>
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
                                                <svg class="svg" width="16px" height="16px">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#minus">
                                                    </use>
                                                </svg>
                                            </i></span>
                                        <div class="qty-input-wrapper" data-stock="<?php echo $usproduct['selprod_stock']; ?>">
                                            <input type="text" value="1" data-page="product-view" placeholder="Qty" class="qty-input cartQtyTextBox productQty-js" data-lang="addons[<?php echo $usproduct['selprod_id'] ?>]" name="addons[<?php echo $usproduct['selprod_id'] ?>]">
                                        </div>
                                        <span class="increase increase-js"><i class="icn">
                                                <svg class="svg" width="16px" height="16px">
                                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#plus">
                                                    </use>
                                                </svg>
                                            </i></span>
                                    </div>
                                </div>
                                <label class="checkbox">
                                    <input <?php echo ($usproduct['selprod_stock'] > 0) ? 'checked="checked"' : ''; ?> type="checkbox" class="cancel <?php echo $uncheckBoxClass; ?>" name="check_addons" title="<?php echo Labels::getLabel('LBL_Remove', $siteLangId); ?>">
                                    <i class="input-helper"></i> </label>


                            </li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</div>