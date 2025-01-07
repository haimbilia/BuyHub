<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$colMdVal = isset($colMdVal) ? $colMdVal : 4;
$displayProductNotAvailableLable = false;
if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) {
    $displayProductNotAvailableLable = true;
}
$productsByShop = [];
$productsBySelProdCode = [];
if ($products) { ?>
    <div class="interactive-stores-list">
        <div class="stores">
            <div class="stores-body">
                <ul id="mapProducts--js">
                    <?php
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
                        $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id']);
                    ?>

                        <li data-shopId="<?php echo $product['shop_id']; ?>">
                            <a class="store" href="<?php echo $productUrl; ?>">
                                <div class="store__img">
                                    <img loading='lazy' <?php echo HtmlHelper::getImgDimParm(ImageDimension::TYPE_PRODUCTS, ImageDimension::VIEW_THUMB); ?> src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], ImageDimension::VIEW_THUMB, $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>" alt="<?php echo (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $product['prodcat_name']; ?>" title="<?php echo (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $product['prodcat_name']; ?>">
                                </div>
                                <div class="store__detail">
                                    <h6><?php echo (mb_strlen($product['selprod_title']) > 50) ? mb_substr($product['selprod_title'], 0, 50) . "..." : $product['selprod_title']; ?>
                                    </h6>
                                    <p class="location">
                                        <?php echo $product['prodcat_name']; ?>
                                    </p>
                                    <div class="store__detail-foot">
                                        <?php include(CONF_THEME_PATH . '_partial/collection/product-price.php'); ?>
                                    </div>

                                </div>
                            </a>
                            <a href="javascript:void(0);" class="link" onclick="viewMoreSeller('<?php echo $product['selprod_code']; ?>','<?php echo $product['selprod_id']; ?>')"><?php echo Labels::getLabel('LBL_MORE_SELLERS', $siteLangId); ?></a>

                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
<?php
    $searchFunction = 'goToProductListingSearchPage';
    if (isset($pagingFunc)) {
        $searchFunction = $pagingFunc;
    }
    $postedData['page'] = (isset($page)) ? $page : 1;
    $postedData['recordDisplayCount'] = $recordCount;
    echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmProductSearchPaging', 'id' => 'frmProductSearchPaging'));
    $pagingArr = array('pageCount' => $pageCount, 'page' => $postedData['page'], 'recordCount' => $recordCount, 'callBackJsFunc' => $searchFunction);
    $this->includeTemplate('_partial/pagination.php', $pagingArr, false);
} else {
    $arr['recordDisplayCount'] = $recordCount;
    echo FatUtility::createHiddenFormFromData($arr, array('name' => 'frmProductSearchPaging', 'id' => 'frmProductSearchPaging'));
    $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
    $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
}
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

foreach ($productsByShop as $shopId => &$marker) {
    $contentString = '<div class="seller-card">
                        <div class="seller_logo">
                            <img src="' . UrlHelper::generateFullUrl('image', 'shopLogo', [$shopId, $siteLangId, ImageDimension::VIEW_SMALL]) . '" ' . HtmlHelper::getImgDimParm(ImageDimension::TYPE_SHOP_LOGO, ImageDimension::VIEW_SMALL) . '>
                        </div>
                        <div class="seller_detail">
                        <div class="seller_title">' . $marker['shop_name'] . '</div>                
                        </div> 
                    </div>
            <ul class="gmap-list">';
    foreach ($marker['products'] as $product) {
        $amount = CommonHelper::displayMoneyFormat($product['theprice']);
        $contentString .= '<li>
                                <figure class="product-profile">
                                    <div class="product-profile-thumbnail"><img class="product-img" src="' . $product['img'] . '" alt="' . $product['name'] . '"></div>
                                    <div class="product-profile-data"><div class="title"><a href="' . $product['url'] . '">' . $product['name'] . '</a></div>
                                        <div class="price">' . $amount . '</div>
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
    $(function() {
        if (typeof map == 'undefined') {
            initMutipleMapMarker(markers, 'productMap--js', getCookie('_ykGeoLat'), getCookie('_ykGeoLng'),
                dragCallback);
        } else {
            clearMarkers();
            createMarkers(markers);
            clearMoreSellerMarkers();
        }
    });

    function viewMoreSeller(selprodCode, selprod_id) {
        if (!realtedMarkers.hasOwnProperty(selprodCode)) {
            return;
        }
        let relMarkers = realtedMarkers[selprodCode];

        if (relMarkers.length) {
            $.each(relMarkers, function(index, marker) {
                relMarkers[index]['isDefault'] = (marker.selprod_id == selprod_id ? 1 : 0);
            });
        }
        clearMoreSellerMarkers();
        clearMarkers();
        createCustomMarkers(relMarkers);
    }
</script>