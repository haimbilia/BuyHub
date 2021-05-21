<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
foreach ($sellers as $sellerDetail) {
    if (!isset($product) && isset($productsArr) && array_key_exists($sellerDetail['selprod_id'], $productsArr)) {
        $product = $productsArr[$sellerDetail['selprod_id']];
        $isProductShippedBySeller = Product::isProductShippedBySeller($product['product_id'], $product['product_seller_id'], $product['selprod_user_id']);
        $fulfillmentType = $product['selprod_fulfillment_type'];
        if (true == $isProductShippedBySeller) {
            if ($product['shop_fulfillment_type'] != Shipping::FULFILMENT_ALL) {
                $fulfillmentType = $product['shop_fulfillment_type'];
                $product['selprod_fulfillment_type'] = $fulfillmentType;
            }
        } else {
            $fulfillmentType = isset($product['product_fulfillment_type']) ? $product['product_fulfillment_type'] : Shipping::FULFILMENT_SHIP;
            $product['selprod_fulfillment_type'] = $fulfillmentType;
            if (FatApp::getConfig('CONF_FULFILLMENT_TYPE', FatUtility::VAR_INT, -1) != Shipping::FULFILMENT_ALL) {
                $fulfillmentType = FatApp::getConfig('CONF_FULFILLMENT_TYPE', FatUtility::VAR_INT, -1);
                $product['selprod_fulfillment_type'] = $fulfillmentType;
            }
        }

        if ($product['product_type'] == Product::PRODUCT_TYPE_DIGITAL) {
            $fulfillmentType = Shipping::FULFILMENT_ALL;
        }

        $codEnabled = false;
        $isProductShippedBySeller = Product::isProductShippedBySeller($product['product_id'], $product['product_seller_id'], $product['selprod_user_id']);
        if ($isProductShippedBySeller) {
            $walletBalance = User::getUserBalance($product['selprod_user_id']);
            $codEnabled = ($product['selprod_cod_enabled']);
            $codMinWalletBalance = -1;
            $shop_cod_min_wallet_balance = Shop::getAttributesByUserId($product['selprod_user_id'], 'shop_cod_min_wallet_balance');
            if ($shop_cod_min_wallet_balance > -1) {
                $codMinWalletBalance = $shop_cod_min_wallet_balance;
            } elseif (FatApp::getConfig('CONF_COD_MIN_WALLET_BALANCE', FatUtility::VAR_FLOAT, -1) > -1) {
                $codMinWalletBalance = FatApp::getConfig('CONF_COD_MIN_WALLET_BALANCE', FatUtility::VAR_FLOAT, -1);
            }
            if ($codMinWalletBalance > -1 && $codMinWalletBalance > $walletBalance) {
                $codEnabled = false;
            }
        } else {
            $codEnabled = ($product['product_cod_enabled']);
        }
    }
    ?>
    <li class="table-row <?php echo (array_key_exists('isActive', $sellerDetail) && true === $sellerDetail['isActive'] ? 'is-active' : ''); ?>">
        <div class="cell cell-1" data-label="<?php echo Labels::getLabel('LBL_SELLER', $siteLangId); ?>">
            <div class="item">
                <div class="item__pic item__pic-seller">
                    <a href="<?php echo UrlHelper::generateUrl('shops', 'view', array($sellerDetail['shop_id'])); ?>" title="<?php echo $sellerDetail['shop_name']; ?>">
                        <img src="<?php echo UrlHelper::generateUrl('image', 'shopLogo', array($sellerDetail['shop_id'], $siteLangId, 'SMALL')); ?>" alt="<?php echo $sellerDetail['shop_name']; ?>" title="<?php echo $sellerDetail['shop_name']; ?>">
                    </a>
                </div>
                <div class="item__description">
                    <div class="item__title">
                        <a href="<?php echo UrlHelper::generateUrl('shops', 'View', array($sellerDetail['shop_id'])); ?>"><?php echo $sellerDetail['shop_name']; ?></a>
                    </div>

                    <div class="item__location">
                        <i class="icn">
                            <svg class="svg" width="16px" height="16px">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#location">
                                </use>
                            </svg>
                        </i>
                        <?php echo $sellerDetail['shop_state_name'] . "," . $sellerDetail['shop_country_name']; ?>
                    </div>

                    <div class="products__rating -display-inline m-0">
                        <i class="icn">
                            <svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow">
                                </use>
                            </svg>
                        </i>
                        <?php 
                            $shop_rating = 0;
                            if (FatApp::getConfig("CONF_ALLOW_REVIEWS", FatUtility::VAR_INT, 0)) {
                                $shop_rating = SelProdRating::getSellerRating($sellerDetail['selprod_user_id']);
                                ?>
                                    <span class="rate"><?php echo round($shop_rating, 1); ?></span>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="cell cell-2" data-label="<?php echo Labels::getLabel('LBL_PRICE', $siteLangId); ?>">
            <div class="product-price">
                <span class="new_price">
                    <?php echo CommonHelper::displayMoneyFormat($sellerDetail['theprice']); ?>
                    <?php if ($sellerDetail['special_price_found'] && $sellerDetail['selprod_price'] > $sellerDetail['theprice']) { ?>
                        <del><?php echo CommonHelper::displayMoneyFormat($sellerDetail['selprod_price']); ?></del>
                </span>
                <br>
                <span class="off_price text-success">
                    <?php echo CommonHelper::showProductDiscountedText($sellerDetail, $siteLangId); ?>
                <?php } ?>
                </span>
            </div>
        </div>

        <?php $optionRows = isset($optionRows) ? $optionRows : SellerProduct::getFormattedOptions($sellerDetail['selprod_id'], $siteLangId); 
        if (!empty($optionRows)) { ?>
            <div class="cell cell-3" data-label="<?php echo Labels::getLabel('LBL_OPTIONS', $siteLangId); ?>">
                <?php include('selprod-options.php'); ?>
            </div>
        <?php } ?>

        <?php if ($product['product_type'] == Product::PRODUCT_TYPE_PHYSICAL) { ?>
            <div class="cell cell-4" data-label="<?php echo Labels::getLabel('LBL_SERVICES', $siteLangId); ?>">
                <?php include(CONF_THEME_PATH . '_partial/product/shipping-rates.php'); ?>
            </div>
        <?php } ?>
        <?php 
            $canAskQuestion = (!UserAuthentication::isUserLogged() || (UserAuthentication::isUserLogged() && ((User::isBuyer()) || (User::isSeller())) && (UserAuthentication::getLoggedUserId() != $sellerDetail['selprod_user_id'])));

            $canViewDetail = (!isset($currSelprodId) || $currSelprodId != $sellerDetail['selprod_id']);

        ?>
        <div class="cell cell-5" data-label="">
            <div class="actions">
                <?php if ($canAskQuestion) { ?>
                    <a href="<?php echo UrlHelper::generateUrl('shops', 'sendMessage', array($sellerDetail['shop_id'], $product['selprod_id'])); ?>" class="btn btn-link btn-sm">
                        <i class="icn">
                            <svg class="svg">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#ask-question">
                                </use>
                            </svg>

                        </i><?php echo Labels::getLabel('LBL_Ask_Question', $siteLangId); ?>
                    </a>
                <?php } ?>
                <?php if ($canViewDetail) { ?>
                    <a href="<?php echo UrlHelper::generateUrl('products', 'view', array($sellerDetail['selprod_id'])); ?>" class="btn btn-brand btn-sm">
                        <?php echo Labels::getLabel('LBL_VIEW_DETAIL', $siteLangId); ?>
                    </a>
                <?php } ?>
            </div>
        </div>
    </li>
<?php }
