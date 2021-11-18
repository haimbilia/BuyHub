<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

// if(!isset($product)){
    $product = SellerProduct::getSelProdDataById($selProdId,$siteLangId,true,['selprod_id','selprod_product_id','product_updated_on','selprod_title','product_name','product_identifier']);    
// }

$uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
//$prodUrl = UrlHelper::generateUrl('Products', 'view', array($product['selprod_id']), CONF_WEBROOT_FRONTEND);
$imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['selprod_product_id'], "SMALL", $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
$productTitle = $product['selprod_title'] ?? $product['product_name'] ?? $product['product_identifier'] ;

if(!isset($options)){
    $options = SellerProduct::getSellerProductOptions($product['selprod_id'], true, $siteLangId);   
}
?>
<a href="javascript:void(0)" class="product-profile">
    <div class="product-profile__thumbnail" data-ratio="1:1">
        <img data-aspect-ratio="1:1" src="<?php echo $imgSrc; ?>">
    </div>        
    <div class="product-profile__data">
        <div class="title"><?php echo $productTitle; ?></div>
        <?php if(0 < count($options) || isset($sellerName)){ ?>
        <ul class="list-options <?php echo isset($horizontalAlignOptions) && $horizontalAlignOptions ? 'list-options--horizontal':'list-options--vertical"';?>">
        <?php foreach($options as $option){ ?>
            <li class="">
                <span class="label"><?php echo $option['option_name'];?>:</span>
                <span class="value"><?php echo $option['optionvalue_name'];?></span>
            </li>
            <?php } 
            if(isset($sellerName)){  ?> 
            <li class="">
                <span class="label"><?php echo Labels::getLabel('LBL_SELLER', $siteLangId);?>:</span>
                <span class="value"><?php echo $sellerName;?></span>
            </li>
            <?php } ?>                
        </ul>
        <?php } ?>
    </div>  
</a>