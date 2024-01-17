<?php if (1 > FatApp::getConfig('CONF_HIDE_PRICES', FatUtility::VAR_INT, 0)) { ?>
    <div class="products-price">
        <span class="products-price-new"> <?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?></span>
        <?php if ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) { ?>
            <span class="products-price-old">
                <?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></span>
            <div class="products-price-off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?>
            </div>
        <?php } ?>
    </div>
<?php } ?>