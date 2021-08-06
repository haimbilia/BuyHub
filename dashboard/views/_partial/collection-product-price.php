  <div class="products_price">
      <span class="products_price_new"> <?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?></span>
      <?php if ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) { ?>
      <span class="products_price_old">
          <?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></span>
      <div class="products_price_off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?>
      </div>
      <?php } ?>
  </div>