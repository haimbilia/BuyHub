<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>


<div class="interactive-stores">
    <div class="interactive-stores-map">
        <div class="map-loader ccis-loading">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="50px" height="50px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                <path fill="#fff" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
                    <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite">
                    </animateTransform>
                </path>
            </svg>
        </div>
        <div class="canvas-map" id="productMap--js">
            <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m26!1m12!1m3!1d13727.153581462415!2d76.71911913274683!3d30.66808660655374!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m11!3e6!4m3!3m2!1d30.6799346!2d76.7220969!4m5!1s0x390feef5b90fc51b%3A0x7541e61fcad7e6c4!2sablysoft%20map!3m2!1d30.6552491!2d76.726384!5e0!3m2!1sen!2sin!4v1645102385317!5m2!1sen!2sin" style="border:0;" allowfullscreen="" loading="lazy"></iframe> -->
        </div>
    </div>
    <div class="interactive-stores-list stores">
        <?php $this->includeTemplate('products/products-list.php', $productsData, false); ?>
    </div>
</div>
<?php
$productsByShop = [];
foreach ($products as $product) {
    $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
    $productUrl = !isset($product['promotion_id']) ? UrlHelper::generateFullUrl('Products', 'View', array($product['selprod_id']), CONF_WEBROOT_FRONTEND) : UrlHelper::generateFullUrl('Products', 'track', array($product['promotion_record_id']), CONF_WEBROOT_FRONTEND);
    $img = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
    $productsByShop[$product['shop_id']]['lat'] = $product['shop_lat'];
    $productsByShop[$product['shop_id']]['lng'] = $product['shop_lng'];
    $productsByShop[$product['shop_id']]['products'][$product['selprod_id']] = ['url' => $productUrl, 'name' => ((mb_strlen($product['selprod_title']) > 30) ? mb_substr($product['selprod_title'], 0, 50) . "..." : $product['selprod_title']), 'img' => $img];
    $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id']);
}

foreach ($moreSellersProductsArr as $product) {
    $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
    $productUrl = !isset($product['promotion_id']) ? UrlHelper::generateFullUrl('Products', 'View', array($product['selprod_id']), CONF_WEBROOT_FRONTEND) : UrlHelper::generateFullUrl('Products', 'track', array($product['promotion_record_id']), CONF_WEBROOT_FRONTEND);
    $img = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
    $productsByShop[$product['shop_id']]['lat'] = $product['shop_lat'];
    $productsByShop[$product['shop_id']]['lng'] = $product['shop_lng'];
    $productsByShop[$product['shop_id']]['products'][$product['selprod_id']] = ['url' => $productUrl, 'name' => ((mb_strlen($product['selprod_title']) > 30) ? mb_substr($product['selprod_title'], 0, 50) . "..." : $product['selprod_title']), 'img' => $img];
}


foreach ($productsByShop as &$marker) {
    $contentString = '<ul class="gmap-list">';
    foreach ($marker['products'] as $product) {
        $contentString .= '<li>
            <div class="product-profile">
                <div class="product-profile__thumbnail"><img class="product-img" src="' . $product['img'] . '" alt=""></div>
                <div class="product-profile__data"><div class="title"><a href="' . $product['url'] . '"><strong>' . $product['name'] . '</strong></a></div></div>
            </div>
            </li>';
    }
    $contentString .= '</ul>';
    unset($marker['products']);
    $marker['content'] = $contentString;
}
?>
<script>
    var markers = <?php echo json_encode($productsByShop); ?>;
    $(document).ready(function() {
        if (typeof map == 'undefined') {
            initMutipleMapMarker(markers, 'productMap--js', getCookie('_ykGeoLat'), getCookie('_ykGeoLng'),
                dragCallback);
        } else {
            clearMarkers();
            createMarkers(markers);
        }
    });
</script>