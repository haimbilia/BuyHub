<?php if (false === SellerProduct::isPriceHidden($product['selprod_hide_price'], $product['shop_rfq_enabled'])) { ?>
    <div class="products-price">
        <span class="products-price-new"><?php echo trim(CommonHelper::displayMoneyFormat($product['theprice'], true, false, true, false, false, true)); ?></span>
        <?php if ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) { ?>
            <del class="products-price-old"><?php echo trim(CommonHelper::displayMoneyFormat($product['selprod_price'], true, false, true, false, false, true)); ?></del>
            <div class="products-price-off"><?php echo trim(CommonHelper::showProductDiscountedText($product, $siteLangId)); ?></div>
        <?php } ?>
    </div>
<?php } ?>