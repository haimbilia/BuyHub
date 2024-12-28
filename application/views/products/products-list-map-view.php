<?php defined('SYSTEM_INIT') or die('Invalid Usage.'); ?>

<div class="interactive-stores">
    <div class="interactive-stores-map">
        <div class="map-loader ccis-loading">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                y="0px" width="50px" height="50px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;"
                xml:space="preserve">
                <path fill="#fff"
                    d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
                    <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25"
                        to="360 25 25" dur="0.6s" repeatCount="indefinite">
                    </animateTransform>
                </path>
            </svg>
        </div>
        <div class="canvas-map" id="productMapJs">
        </div>
    </div>
    <div class="interactive-stores-list">
        <?php
        $this->includeTemplate('products/products-map-list-left.php', $productsData, false);
        ?>
    </div>

    <button type="button" class="btn-list" data-bs-dismiss="modal" aria-label="Close">
        <svg class="svg" width="16" height="16" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
            fill="currentColor">
            <path
                d="M8 4H21V6H8V4ZM3 3.5H6V6.5H3V3.5ZM3 10.5H6V13.5H3V10.5ZM3 17.5H6V20.5H3V17.5ZM8 11H21V13H8V11ZM8 18H21V20H8V18Z">
            </path>
        </svg>
        <span class="btn-txt">List View</span>

    </button>
</div>
<?php
$productsByShop = [];
$productsBySelProdCode = [];

foreach ($products as $product) {
    $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
    $productUrl = !isset($product['promotion_id']) ? UrlHelper::generateFullUrl('Products', 'View', array($product['selprod_id'])) : UrlHelper::generateFullUrl('Products', 'track', array($product['promotion_record_id']));
    $img = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
    $productsByShop[$product['shop_id']]['lat'] = $product['shop_lat'];
    $productsByShop[$product['shop_id']]['lng'] = $product['shop_lng'];
    $productsByShop[$product['shop_id']]['shop_name'] = $product['shop_name'];
    $productsByShop[$product['shop_id']]['products'][$product['selprod_id']] = [
        'url' => $productUrl,
        'name' => ((mb_strlen($product['selprod_title']) > 30) ? mb_substr($product['selprod_title'], 0, 50) . "..." : $product['selprod_title']),
        'img' => $img,
        'theprice' => $product['theprice'],
        'shop_id' => $product['shop_id'],
    ];
}

/*
foreach ($moreSellersProductsArr as $product) {
    $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
    $productUrl = !isset($product['promotion_id']) ? UrlHelper::generateFullUrl('Products', 'View', array($product['selprod_id'])) : UrlHelper::generateFullUrl('Products', 'track', array($product['promotion_record_id']));
    $img = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
    $productsBySelProdCode[$product['selprod_code']][] = [
        'lat' => $product['shop_lat'],
        'lng' => $product['shop_lng'],
        'shop_id' => $product['shop_id'],
        'selprod_id' => $product['selprod_id'],
        'content' => '<ul class="gmap-list">
                <li>
                    <div class="product-profile">
                        <div class="product-profile-thumbnail"><img class="product-img" src="' . $img . '" alt=""></div>
                        <div class="product-profile-data"><div class="title"><a href="' . $productUrl . '"><strong>' . ((mb_strlen($product['selprod_title']) > 30) ? mb_substr($product['selprod_title'], 0, 50) . "..." : $product['selprod_title']) . '</strong></a></div></div>
                    </div>
                </li>
            </ul>',
        'amount' =>  CommonHelper::displayMoneyFormat($product['theprice']),
    ];
}
*/

foreach ($productsByShop as &$marker) {
    $contentString = '<div class="seller-card">
                <div class="seller-card-thumbnail">
                    <img class="seller-card-img" src="' . UrlHelper::generateFullUrl('image', 'shopLogo', [$product['shop_id'], $siteLangId, ImageDimension::VIEW_SMALL]) . '" ' . HtmlHelper::getImgDimParm(ImageDimension::TYPE_SHOP_LOGO, ImageDimension::VIEW_SMALL) . '>
                </div>
                <div class="seller-card-data">
                <div class="seller-card-title">' . $marker['shop_name'] . '</div>                
                </div> 
            </div>
            <ul class="gmap-list">';
    foreach ($marker['products'] as $product) {
        $amount = CommonHelper::displayMoneyFormat($product['theprice']);
        $contentString .= '<li  class="gmap-list-item">
            <figure class="product-profile">
            <div class="product-profile-thumbnail"><img class="product-img" width="36" height="auto" src="' . $product['img'] . '" alt="' . $product['name'] . '" ' . HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_THUMB) . '></div>
            <div class="product-profile-data"><div class="title"><a href="' . $product['url'] . '" title="' . $product['name'] . '">' . $product['name'] . '</a><div class="price">' . $amount . '</div></div>
                
            </div>
            </figure>
            </li>';
    }
    $contentString .= '</ul>';
    unset($marker['products']);
    $marker['content'] = $contentString;
}
?>
<script>
    var markers = <?php echo json_encode($productsByShop); ?>;
    var realtedMarkers = <?php echo json_encode($productsBySelProdCode); ?>;
    $(function () {
        initMutipleMapMarker(markers, 'productMapJs', getCookie('_ykGeoLat'), getCookie('_ykGeoLng'),
            dragCallback);

    });

    function viewMoreSeller(selprodCode, selprod_id) {
        if (!realtedMarkers.hasOwnProperty(selprodCode)) {
            return;
        }
        let relMarkers = realtedMarkers[selprodCode];

        if (relMarkers.length) {
            $.each(relMarkers, function (index, marker) {
                relMarkers[index]['isDefault'] = (marker.selprod_id == selprod_id ? 1 : 0);
            });
        }
        clearMoreSellerMarkers();
        clearMarkers();
        createCustomMarkers(relMarkers);
    }
</script>