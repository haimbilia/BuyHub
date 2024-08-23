<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$shopName = $options = $otherInfo = $date = '';
if (isset($order)) {
    $prodUrl = 'javascript:fcom.displayErrorMessage(\'' . Labels::getLabel('ERR_THIS_PRODUCT_IS_NOT_AVAILABLE.') . '\')';
    if (isset($order['op_is_batch']) && $order['op_is_batch']) {
        $prodUrl = UrlHelper::generateUrl('Products', 'batch', array($order['op_selprod_id'] ?? 0), CONF_WEBROOT_FRONTEND);
        $imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'BatchProduct', array($order['op_selprod_id'], $siteLangId, ImageDimension::VIEW_MINI), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
    } else {
        if (Product::verifyProductIsValid($order['op_selprod_id']) == true) {
            $prodUrl = UrlHelper::generateUrl('Products', 'view', array($order['op_selprod_id']), CONF_WEBROOT_FRONTEND);
        }
        $imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($order['selprod_product_id'] ?? 0, ImageDimension::VIEW_MINI, $order['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . UrlHelper::getCacheTimestamp($siteLangId), CONF_IMG_CACHE_TIME, '.jpg');
    }
    // $productName = $order['op_product_name'];
    $productName = '';
    $productTitle = html_entity_decode($order['op_selprod_title'], ENT_QUOTES, 'utf-8');
    $brandName = $order['op_brand_name'];

    $str = Labels::getLabel('LBL_QTY:_{QTY}', $siteLangId);
    $options = isset($order['op_qty']) ? CommonHelper::replaceStringData($str, ['{QTY}' => $order['op_qty']]) : '';

    if ($order['op_selprod_options'] != '') {
        $options .= ' | ' . $order['op_selprod_options'];
    }

    $shopName = $order['op_shop_name'] ?? '';
    if (isset($order['totOrders']) && $order['totOrders'] > 1) {
        $otherInfo = Labels::getLabel('LBL_Part_combined_order', $siteLangId) . ' <a title="' . Labels::getLabel('LBL_View_Order_Detail', $siteLangId) . '" href="' . UrlHelper::generateUrl('Buyer', 'viewOrder', array($order['order_id'])) . '">' . $order['order_number'] . "</a>";
    }

    $date = isset($showDate) && $order['order_date_added']   ? FatDate::format($order['order_date_added']) : '';
} else {
    $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
    $prodUrl = UrlHelper::generateUrl('Products', 'view', array($product['selprod_id']), CONF_WEBROOT_FRONTEND);
    $imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['selprod_product_id'], ImageDimension::VIEW_MINI, $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

    $productName = html_entity_decode($product['product_name'] ?? $product['product_identifier'], ENT_QUOTES, 'utf-8');
    $productTitle = html_entity_decode($product['selprod_title'], ENT_QUOTES, 'utf-8');
    $brandName = $product['brand_name'] ?? '';
    if (is_array($product['options']) && count($product['options'])) {
        $count = count($product['options']);
        foreach ($product['options'] as $op) {
            $options .= $op['option_name'] . ': ' . wordwrap($op['optionvalue_name'], 150, "<br>\n");
            if ($count != 1) {
                $options .= ' | ';
            }
            $count--;
        }
    }
}

?>
<div class="product-profile">
    <figure class="product-profile__pic">
        <a href="<?php echo $prodUrl; ?>">
            <img src="<?php echo $imgSrc; ?>" <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_MINI); ?> title="<?php echo $productName; ?>" alt="<?php echo $productName; ?>">
        </a>
    </figure>
    <div class="product-profile__description">
        <?php if (!empty($date)) { ?>
            <div class="product-profile__date">
                <?php echo $date; ?>
            </div>
        <?php } ?>
        <?php if (!empty($productTitle)) { ?>
            <div class="product-profile__title prodNameJs">
                <a title="<?php echo CommonHelper::renderHtml($productTitle, true); ?>" href="<?php echo $prodUrl; ?>">
                    <?php echo CommonHelper::renderHtml($productTitle, true) . '<br>'; ?>
                </a>
            </div>
            <div class="product-profile__sub_title prodNameJs">
                <?php echo CommonHelper::renderHtml($productName, true); ?>
            </div>
        <?php } else { ?>
            <div class="product-profile__title prodNameJs">
                <a title="<?php echo CommonHelper::renderHtml($productName, true); ?>" href="<?php echo $prodUrl; ?>">
                    <?php echo CommonHelper::renderHtml($productName, true); ?>
                </a>
            </div>
        <?php } ?>
        <?php if (!empty($brandName)) { ?>
            <div class="product-profile__brand">
                <?php echo Labels::getLabel('Lbl_Brand', $siteLangId) ?>:
                <?php echo CommonHelper::renderHtml($brandName, true); ?>
            </div>
        <?php } ?>
        <?php if (!empty($options)) { ?>
            <div class="product-profile__options prodOptionsJs">
                <?php echo $options; ?>
            </div>
        <?php } ?>

        <?php if ('B' == $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) { ?>
            <?php if (!empty($shopName)) { ?>
                <div class="product-profile__sold_by">
                    <?php echo Labels::getLabel('LBL_Sold_By', $siteLangId) . ': ' . $shopName; ?>
                </div>
            <?php } ?>
            <?php if (!empty($otherInfo)) { ?>
                <div class="product-profile__specification">
                    <?php echo $otherInfo ?>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>