<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$displayOptions = $displayOptions ?? true;
$displayProductName = $displayProductName ?? false;
$canViewProducts = $canViewProducts ?? false;
$redirectSelprod = $redirectSelprod ?? true;

if (!isset($product)) {
    $product = SellerProduct::getSelProdDataById($selProdId, true, ['selprod_id', 'selprod_product_id', 'product_updated_on', 'selprod_title', 'product_name', 'product_identifier']);
}

$uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
$imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['selprod_product_id'], ImageDimension::VIEW_SMALL, $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
$productTitle = $product['selprod_title'] ?? $product['product_name'] ?? $product['product_identifier'];
?>
<div class="product-profile">
    <div class="product-profile__thumbnail">
        <a href="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['selprod_product_id'], ImageDimension::VIEW_ORIGINAL, $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" data-featherlight="image">
            <img <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_SMALL); ?> src="<?php echo $imgSrc; ?>" <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_SMALL); ?>></a>
    </div>
    <div class="product-profile__data">
        <?php if ($redirectSelprod) { ?>
            <a href="javascript:void(0)" onclick="redirectToSellerProduct(<?php echo $product['selprod_id']; ?>);">
            <?php } ?>
            <div class="title" data-html="true" tabindex="0" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-trigger="hover focus" data-popover-html="#options-<?php echo $product['selprod_id']; ?>">
                <?php echo CommonHelper::subStringByWords($productTitle, 35); ?>
            </div>
            <?php if ($redirectSelprod) { ?>
            </a>
        <?php } ?>
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
            $options = count($options) ? $options : [];

            if ($options) { ?>
                <ul class="list-options list-options--horizontal mt-4">
                    <?php foreach ($options as $option) { ?>
                        <li class="">
                            <span class="value"><?php echo $option['optionvalue_name']; ?></span>
                        </li>
                    <?php
                    }
                    ?>
                </ul>
            <?php
            }

            if (isset($sellerName) || isset($shopName)) { ?>
                <ul class="list-options list-options--vertical">
                    <?php if (isset($sellerName)) {
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
        }
        ?>
        <div class="hidden" id="options-<?php echo $product['selprod_id']; ?>">
            <p><strong><?php echo $productTitle; ?></strong></p>
            <?php if (true == $displayOptions && $options) { ?>
                <ul class="list-popover">
                    <?php
                    foreach ($options as $option) {
                        echo '<li class="list-popover-item">
                                <span class="lable">' . $option['option_name'] . ':</span>
                                <span class="value">' . $option['optionvalue_name'] . '</span>
                            </li>';
                    }
                    ?>
                </ul>
            <?php } ?>
        </div>
    </div>
</div>