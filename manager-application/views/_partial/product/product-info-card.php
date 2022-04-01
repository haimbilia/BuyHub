<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$displayOptions = $displayOptions ?? true;
$displayProductName = $displayProductName ?? false;
$canViewProducts = $canViewProducts ?? false;

if (!isset($product)) {
    $product = SellerProduct::getSelProdDataById($selProdId, true, ['selprod_id', 'selprod_product_id', 'product_updated_on', 'selprod_title', 'product_name', 'product_identifier']);
}

$uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
$imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['selprod_product_id'], ImageDimension::VIEW_SMALL, $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
$getproductAspectRatio = ImageDimension::getData(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_SMALL);
$productTitle = $product['selprod_title'] ?? $product['product_name'] ?? $product['product_identifier'];
?>

<div class="product-profile">
    <div class="product-profile__thumbnail" data-ratio="<?php echo $getproductAspectRatio[ImageDimension::VIEW_SMALL]['aspectRatio']; ?>">
        <a href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['selprod_product_id'], ImageDimension::VIEW_ORIGINAL, $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" data-featherlight="image">
            <img data-aspect-ratio="<?php echo $getproductAspectRatio[ImageDimension::VIEW_SMALL]['aspectRatio']; ?>" src="<?php echo $imgSrc; ?>"></a>
    </div>
    <div class="product-profile__data">
        <div class="title" title="<?php echo $productTitle; ?>" data-bs-toggle='tooltip' data-bs-placement='top'>
            <?php echo CommonHelper::subStringByWords($productTitle, 35); ?>
        </div>

        <?php if ($canViewProducts || $displayProductName) {
            if ($canViewProducts == true) { ?>
                <a href="javascript:void(0)" class="sub-title" onclick="redirectToProduct(<?php echo $product['selprod_product_id']; ?>);" class="product-profile">
                    <?php echo $product['product_name']; ?>
                </a>
            <?php } else { ?>
                <div class="sub-title"><?php echo $product['product_name']; ?></div>
        <?php }
        } ?>
        <?php if (true == $displayOptions) {
            $options = isset($options) ? $options : SellerProduct::getSellerProductOptions($product['selprod_id'], true, $siteLangId);
            if (0 < count($options) || isset($sellerName) || isset($shopName)) { ?>
                <ul class="list-options <?php echo isset($horizontalAlignOptions) && $horizontalAlignOptions ? 'list-options--horizontal' : 'list-options--vertical"'; ?>">
                    <?php foreach ($options as $option) { ?>
                        <li class="">
                            <span class="label"><?php echo $option['option_name']; ?>:</span>
                            <span class="value"><?php echo $option['optionvalue_name']; ?></span>
                        </li>
                    <?php
                    }
                    if (isset($sellerName)) {
                    ?>
                        <li class="">
                            <span class="label"><?php echo Labels::getLabel('LBL_SELLER', $siteLangId); ?>:</span>
                            <span class="value"><?php echo $sellerName; ?></span>
                        </li>
                    <?php }
                    if (isset($shopName)) {
                    ?>
                        <li class="seller-info">
                            <span class="label"><?php echo Labels::getLabel('LBL_SOLD_BY', $siteLangId); ?>:</span>
                            <span class="value"><?php echo $shopName; ?></span>
                        </li>
                    <?php } ?>
                </ul>
        <?php }
        } ?>
    </div>
</div>