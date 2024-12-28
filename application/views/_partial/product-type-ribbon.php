<?php defined('SYSTEM_INIT') or die('Invalid Usage');

if(in_array($productType, [Product::PRODUCT_TYPE_DIGITAL, Product::PRODUCT_TYPE_SERVICE])){ 
    $prodTypeLabel = $productType == Product::PRODUCT_TYPE_DIGITAL ? Labels::getLabel('LBL_DIGITAL_TAG', $siteLangId) : ($productType == Product::PRODUCT_TYPE_SERVICE ? Labels::getLabel('LBL_SERVICE_TAG', $siteLangId) : '');
    $prodTypeToolTip = $productType == Product::PRODUCT_TYPE_DIGITAL ? Labels::getLabel('LBL_DIGITAL_PRODUCT_TOOLTIP', $siteLangId) : ($productType == Product::PRODUCT_TYPE_SERVICE ? Labels::getLabel('LBL_SERVICE_PRODUCT_TOOLTIP', $siteLangId) : ''); ?>
    <div class="badge product-type" data-bs-toggle="tooltip" data-bs-original-title="<?php echo $prodTypeToolTip?>" ><?php echo $prodTypeLabel?></div>
<?php }