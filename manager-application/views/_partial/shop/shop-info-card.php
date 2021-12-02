<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$uploadedTime = AttachedFile::setTimeParam($shop['shop_updated_on']);
//$prodUrl = UrlHelper::generateUrl('Products', 'view', array($shop['selprod_id']), CONF_WEBROOT_FRONTEND);
$imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'shopLogo', array($shop['shop_id'], $siteLangId, 'THUMB'), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

?>
<a href="javascript:void(0)" class="product-profile" onclick="redirectUser(<?php echo $shop['shop_user_id']; ?>)">
    <div class="product-profile__thumbnail" data-ratio="1:1">
        <img data-aspect-ratio="1:1" src="<?php echo $imgSrc; ?>">
    </div>        
    <div class="product-profile__data">
        <div class="title"><?php echo $shop['shop_name']; ?></div>    
        <ul class="list-options <?php echo isset($horizontalAlignOptions) && $horizontalAlignOptions ? 'list-options--horizontal':'list-options--vertical"';?>">    
            <li>
                <span class="label"><?php echo Labels::getLabel('LBL_SELLER', $siteLangId);?>:</span>
                <span class="value"><?php echo $shop['user_name']?></span>
            </li>                        
        </ul>      
    </div>  
</a>