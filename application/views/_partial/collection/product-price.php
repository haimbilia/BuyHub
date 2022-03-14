  <div class="products-price">
      <span class="products-price-new"><?php echo trim(CommonHelper::displayMoneyFormat($product['theprice'])); ?></span>
      <?php if ($product['special_price_found'] && $product['selprod_price'] > $product['theprice']) { ?>
          <del class="products-price-old"><?php echo trim(CommonHelper::displayMoneyFormat($product['selprod_price'])); ?></del>
          <div class="products-price-off"><?php echo trim(CommonHelper::showProductDiscountedText($product, $siteLangId)); ?></div>
      <?php } ?>
      <?php /* if($product['selprod_sold_count']>0){?>
      <span class="products__price_sold"><?php echo $product['selprod_sold_count'];?>
          <?php echo Labels::getLabel('LBL_Sold',$siteLangId);?></span>
      <?php } */ ?>
  </div>