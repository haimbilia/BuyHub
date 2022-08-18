<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (empty($products)) {
    $pSrchFrm = Common::getSiteSearchForm();
    // $pSrchFrm->fill(array('btnSiteSrchSubmit' => Labels::getLabel('LBL_Submit', $siteLangId)));
    $pSrchFrm->setFormTagAttribute('onsubmit', 'submitSiteSearch(this); return(false);');

    $this->includeTemplate('_partial/no-product-found.php', array('pSrchFrm' => $pSrchFrm, 'siteLangId' => $siteLangId, 'postedData' => $postedData), true);
    return;
}

$vtype = $postedData['vtype'] ?? false;

$frmProductSearch->setFormTagAttribute('onSubmit', 'searchProducts(this); return(false);');
$keywordFld = $frmProductSearch->getField('keyword');
// $keywordFld->addFieldTagAttribute('placeholder', Labels::getLabel('LBL_Search', $siteLangId));
// $keywordFld = $frmProductSearch->getField('keyword');
$keywordFld->overrideFldType("hidden");

$sortByFld = $frmProductSearch->getField('sortBy');
$sortByFld->addFieldTagAttribute('class', 'custom-select sorting-select');

$pageSizeFld = $frmProductSearch->getField('pageSize');
$pageSizeFld->addFieldTagAttribute('class', 'custom-select sorting-select');

$desktop_url = '';
$tablet_url = '';
$mobile_url = '';
$category['banner'] = isset($category['banner']) ? (array) $category['banner'] : array();
if (!empty($category['banner'])) {
    $desktop_url = UrlHelper::generateFileUrl('Category', 'Banner', array($category['prodcat_id'], $siteLangId, ImageDimension::VIEW_DESKTOP, applicationConstants::SCREEN_DESKTOP));
    $tablet_url = UrlHelper::generateFileUrl('Category', 'Banner', array($category['prodcat_id'], $siteLangId, ImageDimension::VIEW_TABLET, applicationConstants::SCREEN_MOBILE));
    $mobile_url = UrlHelper::generateFileUrl('Category', 'Banner', array($category['prodcat_id'], $siteLangId, ImageDimension::VIEW_MOBILE, applicationConstants::SCREEN_IPAD));
    $catBannerArr = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_CATEGORY_BANNER, $category['prodcat_id'], 0, $siteLangId);
    foreach ($catBannerArr as $slideScreen) {
        $uploadedTime = AttachedFile::setTimeParam($slideScreen['afile_updated_at']);
        switch ($slideScreen['afile_screen']) {
            case applicationConstants::SCREEN_MOBILE:
                $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_CATEGORY_BANNER, $category['prodcat_id'], 0, 0, applicationConstants::SCREEN_MOBILE);
                $mobile_url = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'Banner', array($category['prodcat_id'], $siteLangId, ImageDimension::VIEW_MOBILE, $fileRow['afile_id'], applicationConstants::SCREEN_MOBILE)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . ",";
                break;
            case applicationConstants::SCREEN_IPAD:
                $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_CATEGORY_BANNER, $category['prodcat_id'], 0, 0, applicationConstants::SCREEN_IPAD);
                $tablet_url = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'Banner', array($category['prodcat_id'], $siteLangId, ImageDimension::VIEW_TABLET, $fileRow['afile_id'], applicationConstants::SCREEN_IPAD)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . ",";
                break;
            case applicationConstants::SCREEN_DESKTOP:
                $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_CATEGORY_BANNER, $category['prodcat_id'], 0, 0, applicationConstants::SCREEN_DESKTOP);
                $desktop_url = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'Banner', array($category['prodcat_id'], $siteLangId, ImageDimension::VIEW_DESKTOP, $fileRow['afile_id'], applicationConstants::SCREEN_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . ",";
                break;
        }
    }
    if (!empty($catBannerArr)) { ?>
        <section class="bg-shop shop-banner">
            <picture>
                <source data-aspect-ratio="4:3" srcset="<?php echo rtrim($mobile_url, ','); ?>" media="(max-width: 767px)">
                <source data-aspect-ratio="4:3" srcset="<?php echo rtrim($tablet_url, ','); ?>" media="(max-width: 1024px)">
                <source data-aspect-ratio="4:1" srcset="<?php echo rtrim($desktop_url, ','); ?>">
                <img data-aspect-ratio="4:1" src="<?php echo rtrim($desktop_url, ','); ?>" alt="<?php echo (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $pageTitle; ?>" title="<?php echo (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $pageTitle; ?>">
            </picture>
        </section>
    <?php }
}
if (array_key_exists('brand_id', $postedData) && $postedData['brand_id'] > 0) {
    $brandImgArr = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BRAND_IMAGE, $postedData['brand_id'], 0, $siteLangId);
    if (!empty($brandImgArr)) {
        foreach ($brandImgArr as $slideScreen) {
            $uploadedTime = AttachedFile::setTimeParam($slideScreen['afile_updated_at']);
            switch ($slideScreen['afile_screen']) {
                case applicationConstants::SCREEN_MOBILE:
                    $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BRAND_IMAGE, $postedData['brand_id'], 0, 0, applicationConstants::SCREEN_MOBILE);
                    $mobile_url = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'BrandImage', array($postedData['brand_id'], $siteLangId, ImageDimension::VIEW_MOBILE, 0, applicationConstants::SCREEN_MOBILE)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . ",";
                    break;
                case applicationConstants::SCREEN_IPAD:
                    $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BRAND_IMAGE, $postedData['brand_id'], 0, 0, applicationConstants::SCREEN_IPAD);
                    $tablet_url = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'BrandImage', array($postedData['brand_id'], $siteLangId, ImageDimension::VIEW_TABLET, 0, applicationConstants::SCREEN_IPAD)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . ",";
                    break;
                case applicationConstants::SCREEN_DESKTOP:
                    $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BRAND_IMAGE, $postedData['brand_id'], 0, 0, applicationConstants::SCREEN_DESKTOP);
                    $desktop_url = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'BrandImage', array($postedData['brand_id'], $siteLangId, ImageDimension::VIEW_DESKTOP, 0, applicationConstants::SCREEN_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . ",";
                    break;
            }
        }

    ?>
        <section class="bg-shop shop-banner">
            <picture>
                <source data-aspect-ratio="4:3" srcset="<?php echo rtrim($mobile_url, ','); ?>" media="(max-width: 767px)">
                <source data-aspect-ratio="4:3" srcset="<?php echo rtrim($tablet_url, ','); ?>" media="(max-width: 1024px)">
                <source data-aspect-ratio="4:1" srcset="<?php echo rtrim($desktop_url, ','); ?>">
                <img data-aspect-ratio="4:1" srcset="<?php echo rtrim($desktop_url, ','); ?>" alt="<?php echo (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $pageTitle; ?>" title="<?php echo (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $pageTitle; ?>">
            </picture>
        </section>
    <?php } ?>
<?php } ?>
<?php

$this->includeTemplate('_partial/productsSearchForm.php', array('frmProductSearch' => $frmProductSearch, 'siteLangId' => $siteLangId, 'recordCount' => $recordCount, 'pageTitle' => (isset($pageTitle)) ? $pageTitle : 'Products'), false);  ?>
<div class="section productsAndFiltersJs">
    <div class="container">
        <div class="collection-search">
            <div class="collection-search-head">
                <div class="collection-search-top">
                    <?php if (isset($showBreadcrumb) && $showBreadcrumb) { ?>
                        <div class="breadcrumb">
                            <?php $this->includeTemplate('_partial/custom/header-breadcrumb.php'); ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="collection-search-bottom">
                    <?php if (isset($pageTitle)) { ?>
                        <div class="collection-search-title">
                            <h1 class="h1">
                                <?php $keywordStr = '';
                                if (isset($keyword) && !empty($keyword)) {
                                    $short_keyword = (mb_strlen($keyword) > 20) ? mb_substr($keyword, 0, 20) . "..." : $keyword;
                                    $keywordStr = '<span title="' . $keyword . '" class="search-results">"' . $short_keyword . '"</span>';
                                }
                                echo $pageTitle; ?> <?php echo $keywordStr; ?>
                                <span class="total-products">
                                    <?php echo isset($scollection_name) && !empty($scollection_name) ? $scollection_name : ''; ?>
                                    <span class="hide_on_no_product">
                                        <span id="total_records"><?php echo $recordCount; ?></span>
                                        <?php echo Labels::getLabel('LBL_ITEM(S)', $siteLangId); ?>
                                    </span>
                                </span>
                            </h1>


                        </div>
                    <?php } ?>

                    <div id="top-filters" class="collection-search-toolbar hide_on_no_product">
                        <ul class="page-sort">
                            <li class="page-sort-item">
                                <?php if (!(UserAuthentication::isUserLogged()) || (UserAuthentication::isUserLogged() && (User::isBuyer()))) { ?>
                                    <button class="btn btn-black btn-filters-control saveSearch-js" type="button" onclick="saveProductSearch()">
                                        <span class="txt"><?php echo Labels::getLabel('LBL_Save_Search', $siteLangId); ?></span></button>
                                <?php } ?>
                            </li>
                            <li class="page-sort-item">
                                <?php echo $frmProductSearch->getFieldHtml('sortBy'); ?>
                            </li>
                            <?php if (FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>
                                <li class="page-sort-item">
                                    <button class="btn btn-outline-black btn-map-view <?php echo $vtype == 'map' ? 'active' : ''; ?>" type="button" onclick="toogleMapView();">
                                        <?php echo Labels::getLabel('LBL_MAP_VIEW', $siteLangId); ?> <span class="toggle-icon"></span>
                                    </button>
                                </li>
                                <?php if ($vtype == "map") { ?>
                                    <li class="page-sort-item">
                                        <button class="btn btn-outline-black btn-icon btn-filters" type="button" data-bs-toggle="offcanvas" data-bs-target="#filters-right">
                                            <?php echo Labels::getLabel('LBL_ALL_FILTERS', $siteLangId); ?>
                                            <svg class="svg" width="18" height="18">
                                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#filter"></use>
                                            </svg>
                                            <span class="dot-count" id="mapFilterJs"></span>
                                        </button>
                                    </li>
                            <?php }
                            } ?>
                        </ul>
                        <?php /* echo $frmProductSearch->getFieldHtml('pageSize'); */ ?>
                    </div>

                </div>
            </div>
            <?php
            $productsData = array(
                'products' => $products,
                'tRightRibbons' => $tRightRibbons ?? [],
                /*'moreSellersProductsArr' => isset($moreSellersProductsArr) ? $moreSellersProductsArr : [],*/
                'page' => $page,
                'pageCount' => $pageCount,
                'postedData' => $postedData,
                'recordCount' => $recordCount,
                'siteLangId' => $siteLangId,
                'pageSize' => $pageSize,
                'pageSizeArr' => $pageSizeArr,
            );
            if ($vtype != "map") { ?>
                <div class="collection-listing filter-left">
                    <aside class="collection-sidebar productFiltersJs" data-close-on-click-outside="collection-sidebar">
                    </aside>
                    <main class="collection-content">
                        <div class="">
                            <?php $this->includeTemplate('products/products-list.php', $productsData, false); ?>
                        </div>
                        <button class="btn btn-float link__filter btn--filters-control" data-bs-toggle="offcanvas" data-bs-target="#filters-right">
                            <svg class="svg" width="18" height="18">
                                <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#filter"></use>
                            </svg>
                            <span class="dot-count" id="mapFilterJs"></span>
                        </button>
                    </main>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
    if ($vtype == "map") {
        include(CONF_THEME_PATH . 'products/products-list-map-view.php');
    } ?>
</div>
<section>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col--left col--left-adds">
                <div class="wrapper--adds">
                    <div class="grids" id="searchPageBanners">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(function() {
        $currentPageUrl = "<?php echo html_entity_decode($canonicalUrl, ENT_QUOTES, 'utf-8'); ?>";
        $productSearchPageType = '<?php echo $productSearchPageType; ?>';
        $recordId = <?php echo $recordId; ?>;
        /* bannerAdds('<?php echo $bannerListigUrl; ?>'); */
        loadProductListingfilters(document.frmProductSearch);
    });
</script>