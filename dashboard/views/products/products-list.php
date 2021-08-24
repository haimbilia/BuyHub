<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
$colMdVal = isset($colMdVal) ? $colMdVal : 4;
$displayProductNotAvailableLable = false;
if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0)) {
    $displayProductNotAvailableLable = true;
}

$vtype = $postedData['vtype'] ?? false;
$productListClass = '';
if ($vtype == 'list') {
    $productListClass = 'listing-products--list';
} elseif ($vtype == 'grid') {
    $productListClass = 'listing-products--grid';
}

?>
<div id="productsList" class="<?php echo $productListClass ?>">
    <?php
    if ($vtype == 'map') {
        include(CONF_THEME_PATH . 'products/products-list-map.php');
    } else {
    ?>
        <div class="product-listing" data-view="<?php echo $colMdVal; ?>">
            <?php if ($products) {
                $showActionBtns = !empty($showActionBtns) ? $showActionBtns : false;
                $isWishList = isset($isWishList) ? $isWishList : 0; ?>
                <?php foreach ($products as $product) {
                    $selProdRibbons = [];
                    if (array_key_exists($product['selprod_id'], $tLeftRibbons)) {
                        $selProdRibbons[] = $tLeftRibbons[$product['selprod_id']];
                    }

                    if (array_key_exists($product['selprod_id'], $tRightRibbons)) {
                        $selProdRibbons[] = $tRightRibbons[$product['selprod_id']];
                    }

                    $productUrl = UrlHelper::generateUrl('Products', 'View', array($product['selprod_id']), CONF_WEBROOT_FRONTEND); ?> <div class="items">
                        <!--product tile-->
                        <div class="products">
                            <?php $this->includeTemplate('_partial/quick-view.php', ['product' => $product,  'siteLangId' => $siteLangId], false); ?>
                            <?php if ($product['in_stock'] == 0) { ?>
                                <span class="tag--soldout"><?php echo Labels::getLabel('LBL_SOLD_OUT', $siteLangId); ?></span>
                            <?php  } ?>
                            <div class="products_body">
                                <?php if (true == $displayProductNotAvailableLable && array_key_exists('availableInLocation', $product) && 0 == $product['availableInLocation']) { ?>
                                    <div class="not-available"><svg class="svg">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#info">
                                            </use>
                                        </svg> <?php echo Labels::getLabel('LBL_NOT_AVAILABLE', $siteLangId); ?></div>
                                <?php } ?>
                                <div class="products_img">
                                    <?php $uploadedTime = AttachedFile::setTimeParam($product['product_updated_on']); ?>
                                    <a title="<?php echo $product['selprod_title']; ?>" href="<?php echo !isset($product['promotion_id']) ? UrlHelper::generateUrl('Products', 'View', array($product['selprod_id']), CONF_WEBROOT_FRONTEND) : UrlHelper::generateUrl('Products', 'track', array($product['promotion_record_id']), CONF_WEBROOT_FRONTEND) ?>">
                                        <?php $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_PRODUCT_IMAGE, $product['product_id']); ?>
                                        <?php
                                        $pictureAttr = [
                                            'webpImageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "WEBPCLAYOUT3", $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.webp'),
                                            'jpgImageUrl' => UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('image', 'product', array($product['product_id'], "CLAYOUT3", $product['selprod_id'], 0, $siteLangId), CONF_WEBROOT_FRONTEND) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg'),
                                            'alt' => (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $product['prodcat_name'],
                                            'data-ratio'=> "1:1",
                                            'title' => (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $product['prodcat_name']
                                        ];
                                        $this->includeTemplate('_partial/picture-tag.php', $pictureAttr, false);
                                        ?>                                        
                                    </a>
                                </div>
                            </div>
                            <div class="products_foot"> <?php /* if(round($product['prod_rating'])>0 && FatApp::getConfig("CONF_ALLOW_REVIEWS",FatUtility::VAR_INT,0)){ ?> <div class="products__rating">
                            <i class="icn"><svg class="svg">
                                    <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow" href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#star-yellow"></use>
                                </svg></i> <span class="rate"><?php echo round($product['prod_rating'],1);?></span> <?php if(round($product['prod_rating'])==0 ){  ?> <span class="be-first"> <a
                                    href="javascript:void(0)"><?php echo Labels::getLabel('LBL_Be_the_first_to_review_this_product', $siteLangId); ?> </a> </span> <?php } ?> </div> <?php } */ ?>
                                <div class="products_category">
                                    <a href="<?php echo UrlHelper::generateUrl('Category', 'View', array($product['prodcat_id']), CONF_WEBROOT_FRONTEND); ?>"><?php echo html_entity_decode($product['prodcat_name'], ENT_QUOTES, 'UTF-8'); ?> </a>
                                </div>
                                <div class="products_title"><a title="<?php echo $product['selprod_title']; ?>" href="<?php echo UrlHelper::generateUrl('Products', 'View', array($product['selprod_id']), CONF_WEBROOT_FRONTEND); ?>"><?php echo (mb_strlen($product['selprod_title']) > 50) ? mb_substr($product['selprod_title'], 0, 50) . "..." : $product['selprod_title']; ?>
                                    </a></div> <?php $this->includeTemplate('_partial/collection-product-price.php', array('product' => $product, 'siteLangId' => $siteLangId), false); ?>
                                    
                                    <?php $this->includeTemplate('_partial/collection-ui.php', array('product' => $product,  'siteLangId' => $siteLangId, 'showActionBtns' => $showActionBtns, 'isWishList' => $isWishList, 'selProdRibbons' => $selProdRibbons), false); ?>
                            </div>
                        </div>
                    </div>
                    <!--/product tile-->
                <?php } ?>
        </div> <?php
                $searchFunction = 'goToProductListingSearchPage';
                if (isset($pagingFunc)) {
                    $searchFunction =  $pagingFunc;
                }

                $postedData['page'] = (isset($page)) ? $page : 1;
                $postedData['recordDisplayCount'] = $recordCount;
                echo FatUtility::createHiddenFormFromData($postedData, array('name' => 'frmProductSearchPaging', 'id' => 'frmProductSearchPaging'));
                $pagingArr = array('pageCount' => $pageCount, 'page' => $postedData['page'], 'recordCount' => $recordCount, 'callBackJsFunc' => $searchFunction);
                $this->includeTemplate('_partial/pagination.php', $pagingArr, false); ?>
    <?php } else { ?>
</div> <?php
                $arr['recordDisplayCount'] = $recordCount;
                echo FatUtility::createHiddenFormFromData($arr, array('name' => 'frmProductSearchPaging', 'id' => 'frmProductSearchPaging'));
                $message = Labels::getLabel('LBL_No_Records_Found', $siteLangId);
                $this->includeTemplate('_partial/no-record-found.php', array('siteLangId' => $siteLangId, 'message' => $message)); ?>
<?php }
        } ?>
</div>