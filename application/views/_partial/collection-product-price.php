  <div class="products-price">
      <span class="products-price-new"> <?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?></span>
      <?php if ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) { ?>
          <del class="products-price-old"> <?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></del>
          <div class="products-price-off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?>
          </div>
      <?php } ?>
  </div>