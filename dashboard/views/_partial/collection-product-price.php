  <div class="products__price"><?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?>
    <?php if ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) { ?>
      <span class="products__price_old"> <?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></span>
      <div class="product_off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?></div>
    <?php } ?>
  </div>