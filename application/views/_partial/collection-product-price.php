  <div class="products__price">
      <span class="products__price_new"> <?php echo CommonHelper::displayMoneyFormat($product['theprice']); ?></span>
      <?php if ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) { ?>
      <del class="products__price_old"> <?php echo CommonHelper::displayMoneyFormat($product['selprod_price']); ?></del>
      <div class="products__price_off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?>
      </div>
      <?php } ?>
  </div>