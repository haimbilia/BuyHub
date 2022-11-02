  <div class="products-price">
      <span class="products-price-new"> <?php echo CommonHelper::displayMoneyFormat($product['theprice'], true, false, true, false, false, true); ?></span>
      <?php if ($product['selprod_price'] > $product['theprice']) { ?>
          <del class="products-price-old"> <?php echo CommonHelper::displayMoneyFormat($product['selprod_price'], true, false, true, false, false, true); ?></del>
          <div class="products-price-off"><?php echo CommonHelper::showProductDiscountedText($product, $siteLangId); ?>
          </div>
      <?php } ?>
  </div>