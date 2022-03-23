<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>
<div class="cart-total-head">
    <h3 class="cart-total-title">
        <?php echo Labels::getLabel('LBL_PRICE_SUMMARY', $siteLangId); ?> </h3>
</div>
<div class="cart-total-body">
    <ul class="cart-summary">
        <li class="cart-summary-item">
            <span class="label"><?php echo Labels::getLabel('LBL_Sub_Total', $siteLangId); ?></span> <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartTotal']); ?></span>
        </li>
        <?php if ($cartSummary['cartVolumeDiscount']) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Loyalty/Volume_Discount', $siteLangId); ?>
                </span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartVolumeDiscount']); ?></span>
            </li>
        <?php } ?>
        <?php if (FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0) && !empty($cartSummary['cartDiscounts'])) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total']); ?></span>
            </li>
        <?php } ?>
        <?php if (/* 0 < $shippingAddress && */isset($cartSummary['taxOptions'])) {
            foreach ($cartSummary['taxOptions'] as $taxName => $taxVal) { ?>
                <li class="cart-summary-item">
                    <span class="label"><?php echo $taxVal['title']; ?></span>
                    <span class="value"><?php echo CommonHelper::displayMoneyFormat($taxVal['value']); ?></span>
                </li>
        <?php }
        } ?>
        <?php if (!FatApp::getConfig('CONF_TAX_AFTER_DISOCUNT', FatUtility::VAR_INT, 0) && !empty($cartSummary['cartDiscounts'])) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Discount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['cartDiscounts']['coupon_discount_total']); ?></span>
            </li>
        <?php } ?>
        <?php if ($cartSummary['originalShipping']) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Delivery_Charges', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['shippingTotal']); ?></span>
            </li>
        <?php  } ?>
        <?php if (!empty($cartSummary['cartRewardPoints'])) {
            $appliedRewardPointsDiscount = CommonHelper::convertRewardPointToCurrency($cartSummary['cartRewardPoints']);
        ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_Reward_point_discount', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($appliedRewardPointsDiscount); ?></span>
            </li>
        <?php } ?>
        <?php if (array_key_exists('roundingOff', $cartSummary) && $cartSummary['roundingOff'] != 0) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo (0 < $cartSummary['roundingOff']) ? Labels::getLabel('LBL_Rounding_Up', $siteLangId) : Labels::getLabel('LBL_Rounding_Down', $siteLangId); ?></span>
                <span class="value"><?php echo CommonHelper::displayMoneyFormat($cartSummary['roundingOff']); ?></span>
            </li>
        <?php } ?>
        <?php if (0 < $cartSummary['totalSaving']) { ?>
            <li class="cart-summary-item">
                <span class="label"><?php echo Labels::getLabel('LBL_TOTAL_SAVING', $siteLangId); ?></span>
                <span class="value text-success"><?php echo CommonHelper::displayMoneyFormat($cartSummary['totalSaving']); ?></span>
            </li>
        <?php } ?>
        <?php $orderNetAmt = $cartSummary['orderNetAmount'];
        /* if (0 == $shippingAddress) $orderNetAmt = $orderNetAmt - $cartSummary['cartTaxTotal'];  */ ?>
        <li class="cart-summary-item highlighted">
            <span class="label"><?php echo Labels::getLabel('LBL_Net_Payable', $siteLangId); ?></span>
            <span class="value"><?php echo CommonHelper::displayMoneyFormat($orderNetAmt); ?></span>
        </li>
        <?php if (CommonHelper::getCurrencyId() != FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)) { ?>
            <p class="form-text text-muted mt-1"><?php echo CommonHelper::currencyDisclaimer($siteLangId, $orderNetAmt); ?> </p>
        <?php } ?>

    </ul>
</div>
<div class="cart-total-foot">
    <div class="cart-action">
        <?php if ($cartHasPhysicalProduct) { ?>
            <button class="btn btn-brand btn-block" type="button" onclick="setUpShippingMethod();">
                <?php echo Labels::getLabel('LBL_Continue', $siteLangId); ?>
            </button>
        <?php } else { ?>
            <button class="btn btn-brand btn-block" type="button" onclick="loadPaymentSummary();">
                <?php echo Labels::getLabel('LBL_Continue', $siteLangId); ?>
            </button>
        <?php } ?>
    </div>
</div>
<?php /*  ?><p class="earn-points"><svg class="svg" width="20" height="20">
            <use xlink:href="../images/retina/sprite.svg#rewards" href="../images/retina/sprite.svg#rewards">
            </use>
        </svg> You will earn 575 points </p> <?php */ ?>

<!-- <h5 class="h5">
    <?php echo Labels::getLabel('LBL_Order_Summary', $siteLangId); ?> - <?php echo count($products); ?>
    <?php echo Labels::getLabel('LBL_item(s)', $siteLangId); ?>
</h5>
<div class="order-summary_list">
    <ul class="list-cart">
        <?php foreach ($products as $product) {
            $productUrl = UrlHelper::generateUrl('Products', 'View', array($product['selprod_id']));
            $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
            $imageUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
            $imageWebpUrl = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], 'WEBP' . ImageDimension::VIEW_THUMB, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp');
        ?>
            <li class="list-cart-item block-cart">
                <div class="block-img block-img-sm">
                    <div class="products-img">
                        <a href="<?php echo $productUrl; ?>">
                            <?php
                            $pictureAttr = [
                                'webpImageUrl' => $imageWebpUrl,
                                'jpgImageUrl' => $imageUrl,
                                'imageUrl' => $imageUrl,
                                'ratio' => '1:1',
                                'alt' => $product['product_name'],
                                'siteLangId' => $siteLangId,
                            ];

                            $this->includeTemplate('_partial/picture-tag.php', $pictureAttr);
                            ?>
                        </a>
                    </div> <span class="product-qty"><?php echo $product['quantity']; ?></span>
                </div>
                <div class="block-cart-detail">
                    <div class="block-cart-detail-top">
                        <div class="product-profile">
                            <div class="product-profile-data">
                                <a class="title" href="<?php echo $productUrl; ?>" title="<?php echo $product['product_name'] ?>"><?php echo $product['selprod_title'] ?></a>
                                <div class="options">
                                    <?php if (isset($product['options']) && count($product['options'])) {
                                        $optionStr = '';
                                        foreach ($product['options'] as $key => $option) {
                                            $optionStr .= $option['optionvalue_name'] . '|';
                                        }
                                        echo rtrim($optionStr, '|');
                                    } ?>
                                </div>
                                <div class="products-price">
                                    <?php echo CommonHelper::displayMoneyFormat($product['theprice'] * $product['quantity']); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </li>
        <?php } ?>
    </ul>
</div> -->

<?php /*?><div class="place-order">
    <p>By placing an order, you agree to Yokart.com's <a href=""> Terms & Conditions</a> and
        <a href=""> Privacy Policy </a>
    </p>
    <button class="btn btn-brand btn-lg btn-block"></span>Place Order</button>
</div> <?php */ ?>