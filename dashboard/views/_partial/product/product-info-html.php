<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');

$shopName = $options = $otherInfo = $date = '';
if (isset($order)) {
    $prodUrl = 'javascript:void(0)';
    if (isset($order['op_is_batch']) && $order['op_is_batch']) {
        $prodUrl = UrlHelper::generateUrl('Products', 'batch', array($order['op_selprod_id']), CONF_WEBROOT_FRONTEND);
        $imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'BatchProduct', array($order['op_selprod_id'], $siteLangId, "SMALL"), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
    } else {
        if (Product::verifyProductIsValid($order['op_selprod_id']) == true) {
            $prodUrl = UrlHelper::generateUrl('Products', 'view', array($order['op_selprod_id']), CONF_WEBROOT_FRONTEND);
        }
        $imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($order['selprod_product_id'], "SMALL", $order['op_selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg');
    }
    $productName = $order['op_product_name'];
    $productTitle = $order['op_selprod_title'];
    $brandName = $order['op_brand_name'];

    $options = isset($order['op_qty']) ? sprintf(Labels::getLabel('LBL_QTY:_%S', $siteLangId), $order['op_qty']) : '';

    if ($order['op_selprod_options'] != '') {
        $options .= ' | ' . $order['op_selprod_options'];
    }

    $shopName = $order['op_shop_name'] ?? '';
    if (isset($order['totOrders']) && $order['totOrders'] > 1) {
        $otherInfo = Labels::getLabel('LBL_Part_combined_order', $siteLangId) . ' <a title="' . Labels::getLabel('LBL_View_Order_Detail', $siteLangId) . '" href="' . UrlHelper::generateUrl('Buyer', 'viewOrder', array($order['order_id'])) . '">' . $order['order_no'] . "</a>";
    }

    $date = isset($showDate) && $order['order_date_added']   ? FatDate::format($order['order_date_added']) : '';
} else {
    $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
    $prodUrl = UrlHelper::generateUrl('Products', 'view', array($product['selprod_id']), CONF_WEBROOT_FRONTEND);
    $imgSrc = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['selprod_product_id'], "SMALL", $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');

    $productName = $product['product_name'];
    $productTitle = $product['selprod_title'];
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
<div class="item">
    <figure class="item__pic">
        <a href="<?php echo $prodUrl; ?>">
            <img src="<?php echo $imgSrc; ?>" title="<?php echo $productName; ?>" alt="<?php echo $productName; ?>">
        </a>
    </figure>
    <div class="item__description">
        <?php if (!empty($date)) { ?>
            <div class="item__date">
                <?php echo $date; ?>
            </div>
        <?php } ?>
        <?php if (!empty($productTitle)) { ?>
            <div class="item__title prodNameJs">
                <a title="<?php echo $productTitle; ?>" href="<?php echo $prodUrl; ?>">
                    <?php echo $productTitle . '<br>'; ?>
                </a>
            </div>
            <div class="item__sub_title prodNameJs">
                <?php echo $productName; ?>
            </div>
        <?php } else { ?>
            <div class="item__title prodNameJs">
                <a title="<?php echo $productName; ?>" href="<?php echo $prodUrl; ?>">
                    <?php echo $productName; ?>
                </a>
            </div>
        <?php } ?>
        <?php if (!empty($brandName)) { ?>
            <div class="item__brand">
                <?php echo Labels::getLabel('Lbl_Brand', $siteLangId) ?>:
                <?php echo $brandName; ?>
            </div>
        <?php } ?>
        <?php if (!empty($options)) { ?>
            <div class="item__options prodOptionsJs">
                <?php echo $options; ?>
            </div>
        <?php } ?>
        
        <?php if ('B' == $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab']) { ?>
            <?php if (!empty($shopName)) { ?>
                <div class="item__sold_by">
                    <?php echo Labels::getLabel('LBL_Sold_By', $siteLangId) . ': ' . $shopName; ?>
                </div>
            <?php } ?>
            <?php if (!empty($otherInfo)) { ?>
                <div class="item__specification">
                    <?php echo $otherInfo ?>
                </div>
            <?php } ?>
        <?php } ?>
    </div>
</div>