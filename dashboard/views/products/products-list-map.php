<?php
defined('SYSTEM_INIT') or die('Invalid Usage.');
$colMdVal = isset($colMdVal) ? $colMdVal : 4;
$displayProductNotAvailableLable = false;
if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0)) {
    $displayProductNotAvailableLable = true;
}
?>

<?php
    $productsByShop = [];
    if ($products) {
        ?>
<div class="interactive-stores__list stores">

    <div class="stores-body scroll scroll-y">
        <ul id="mapProducts--js">
            <?php
                    foreach ($products as $product) {
                        $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
                        $productUrl = !isset($product['promotion_id']) ? UrlHelper::generateFullUrl('Products', 'View', array($product['selprod_id']), CONF_WEBROOT_FRONTEND) : UrlHelper::generateFullUrl('Products', 'track', array($product['promotion_record_id']), CONF_WEBROOT_FRONTEND);
                        $img = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "PRODUCT_LAYOUT_1", $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg');
                        $productsByShop[$product['shop_id']]['lat'] = $product['shop_lat'];
                        $productsByShop[$product['shop_id']]['lng'] = $product['shop_lng'];
                        $productsByShop[$product['shop_id']]['products'][$product['selprod_id']] = ['url' => $productUrl, 'name' => ((mb_strlen($product['selprod_title']) > 30) ? mb_substr($product['selprod_title'], 0, 50) . "..." : $product['selprod_title']), 'img' => $img];
                        $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id']);
                        ?>

            <li data-shopId="<?php echo $product['shop_id']; ?>">
                <a class="store" href="<?php echo $productUrl; ?>">
                    <div class="store__img">
                        <img loading='lazy' data-ratio="1:1"
                            src="<?php echo UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "PRODUCT_LAYOUT_1", $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); ?>"
                            alt="<?php echo (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $product['prodcat_name']; ?>"
                            title="<?php echo (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $product['prodcat_name']; ?>">
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
            </li>
            <?php } ?>

        </ul>
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
        ?>
<?php
    } else {
        $arr['recordDisplayCount'] = $recordCount;
        echo FatUtility::createHiddenFormFromData($arr, array('name' => 'frmProductSearchPaging', 'id' => 'frmProductSearchPaging'));
        $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
        $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message));
    }
    ?>

<?php


 foreach($moreSellersProductsArr as $product){
    $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']);
    $productUrl = !isset($product['promotion_id']) ? UrlHelper::generateFullUrl('Products', 'View', array($product['selprod_id']), CONF_WEBROOT_FRONTEND) : UrlHelper::generateFullUrl('Products', 'track', array($product['promotion_record_id']), CONF_WEBROOT_FRONTEND);
    $img = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "PRODUCT_LAYOUT_1", $product['selprod_id'], 0, $siteLangId)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'); 
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