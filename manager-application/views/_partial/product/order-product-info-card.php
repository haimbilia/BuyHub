<?php defined('SYSTEM_INIT') or die('Invalid Usage.');

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

$options = $order['op_selprod_options'] ?? '';
$options = explode(SellerProduct::MULTIPLE_OPTION_SEPARATOR, $options);

$shopName = $order['op_shop_name'] ?? '';
if (isset($order['totOrders']) && $order['totOrders'] > 1) {
    $otherInfo = Labels::getLabel('LBL_Part_combined_order', $siteLangId) . ' <a title="' . Labels::getLabel('LBL_View_Order_Detail', $siteLangId) . '" href="' . UrlHelper::generateUrl('Buyer', 'viewOrder', array($order['order_id'])) . '">' . $order['order_number'] . "</a>";
}

$date = isset($showDate) && $order['order_date_added']   ? FatDate::format($order['order_date_added']) : '';

$includeInvoiceNo = $includeInvoiceNo ?? true;
?>

<div class="product-profile">
    <div class="product-profile__thumbnail" data-ratio="1:1">
        <img data-aspect-ratio="1:1" src="<?php echo $imgSrc; ?>" title="<?php echo $productName; ?>" alt="<?php echo $productName; ?>">
    </div>
    <div class="product-profile__data">
        <?php if (true === $includeInvoiceNo) { ?>
            <div class="invoice-number">
                <i class="far fa-file-alt"></i>
                <?php echo $order['op_invoice_number']; ?>
            </div>
        <?php } ?>

        <div class="title"><?php echo $productTitle; ?></div>
        <?php if (!empty($options)) { ?>
            <ul class="list-options <?php echo isset($horizontalAlignOptions) && $horizontalAlignOptions ? 'list-options--horizontal' : 'list-options--vertical"'; ?>">
                <?php foreach ($options as $option) { 
                    $option = explode(SellerProduct::OPTION_NAME_SEPARATOR, $option);
                    if (empty(array_filter($option))) {
                        continue;
                    }
                    ?>
                    <li>
                        <span class="label"><?php echo $option[0]; ?>:</span>
                        <span class="value"><?php echo $option[1]; ?></span>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>
</div>