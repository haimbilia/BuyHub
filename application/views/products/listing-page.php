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
                $mobile_url = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'Banner', array($category['prodcat_id'], $siteLangId, 'MOBILE', applicationConstants::SCREEN_MOBILE)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . ",";
                break;
            case applicationConstants::SCREEN_IPAD:
                $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_CATEGORY_BANNER, $category['prodcat_id'], 0, 0, applicationConstants::SCREEN_IPAD);
                $tablet_url = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'Banner', array($category['prodcat_id'], $siteLangId, 'TABLET', applicationConstants::SCREEN_IPAD)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . ",";
                break;
            case applicationConstants::SCREEN_DESKTOP:
                $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_CATEGORY_BANNER, $category['prodcat_id'], 0, 0, applicationConstants::SCREEN_DESKTOP);
                $desktop_url = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Category', 'Banner', array($category['prodcat_id'], $siteLangId, 'DESKTOP', applicationConstants::SCREEN_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . ",";
                break;
        } ?>
    <?php } ?>
    <section class="bg-shop shop-banner">
        <picture>
            <source data-aspect-ratio="4:3" srcset="<?php echo rtrim($mobile_url, ','); ?>" media="(max-width: 767px)">
            <source data-aspect-ratio="4:3" srcset="<?php echo rtrim($tablet_url, ','); ?>" media="(max-width: 1024px)">
            <source data-aspect-ratio="4:1" srcset="<?php echo rtrim($desktop_url, ','); ?>">
            <img data-aspect-ratio="4:1" src="<?php echo $desktop_url; ?>" alt="<?php echo (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $pageTitle; ?>" title="<?php echo (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $pageTitle; ?>">
        </picture>

        <?php /* if (!empty($category['prodcat_description']) && array_key_exists('prodcat_description', $category)) { ?>
    <div class="page-category__content">
        <p><?php  echo FatUtility::decodeHtmlEntities($category['prodcat_description']); ?></p>
    </div>
    <?php } */ ?>
    </section>
    <?php }
if (array_key_exists('brand_id', $postedData) && $postedData['brand_id'] > 0) {
    $brandImgArr = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BRAND_IMAGE, $postedData['brand_id'], 0, $siteLangId);
    if (!empty($brandImgArr)) {
        foreach ($brandImgArr as $slideScreen) {
            $uploadedTime = AttachedFile::setTimeParam($slideScreen['afile_updated_at']);
            switch ($slideScreen['afile_screen']) {
                case applicationConstants::SCREEN_MOBILE:
                    $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BRAND_IMAGE, $postedData['brand_id'], 0, 0, applicationConstants::SCREEN_MOBILE);
                    $mobile_url = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'BrandImage', array($postedData['brand_id'], $siteLangId, 'MOBILE', 0, applicationConstants::SCREEN_MOBILE)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . ",";
                    break;
                case applicationConstants::SCREEN_IPAD:
                    $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BRAND_IMAGE, $postedData['brand_id'], 0, 0, applicationConstants::SCREEN_IPAD);
                    $tablet_url = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'BrandImage', array($postedData['brand_id'], $siteLangId, 'TABLET', 0, applicationConstants::SCREEN_IPAD)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . ",";
                    break;
                case applicationConstants::SCREEN_DESKTOP:
                    $fileRow = CommonHelper::getImageAttributes(AttachedFile::FILETYPE_BRAND_IMAGE, $postedData['brand_id'], 0, 0, applicationConstants::SCREEN_DESKTOP);
                    $desktop_url = UrlHelper::getCachedUrl(UrlHelper::generateFileUrl('Image', 'BrandImage', array($postedData['brand_id'], $siteLangId, 'DESKTOP', 0, applicationConstants::SCREEN_DESKTOP)) . $uploadedTime, CONF_IMG_CACHE_TIME, '.jpg') . ",";
                    break;
            }
        } ?>
        <section class="bg-shop shop-banner">
            <picture>
                <source data-aspect-ratio="4:3" srcset="<?php echo $mobile_url; ?>" media="(max-width: 767px)">
                <source data-aspect-ratio="4:3" srcset="<?php echo $tablet_url; ?>" media="(max-width: 1024px)">
                <source data-aspect-ratio="4:1" srcset="<?php echo $desktop_url; ?>">
                <img data-aspect-ratio="4:1" srcset="<?php echo $desktop_url; ?>" alt="<?php echo (!empty($fileRow['afile_attribute_alt'])) ? $fileRow['afile_attribute_alt'] : $pageTitle; ?>" title="<?php echo (!empty($fileRow['afile_attribute_title'])) ? $fileRow['afile_attribute_title'] : $pageTitle; ?>">
            </picture>
        </section>
    <?php } ?>
<?php } ?>
<?php $this->includeTemplate('_partial/productsSearchForm.php', array('frmProductSearch' => $frmProductSearch, 'siteLangId' => $siteLangId, 'recordCount' => $recordCount, 'pageTitle' => (isset($pageTitle)) ? $pageTitle : 'Products'), false);  ?>
<section class="section">
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
                            </h1>
                            <span class="total-products">
                                <?php echo isset($scollection_name) && !empty($scollection_name) ? $scollection_name : ''; ?>
                                <span class="hide_on_no_product">
                                    <span id="total_records"><?php echo $recordCount; ?></span>
                                    <?php echo Labels::getLabel('LBL_ITEM(S)', $siteLangId); ?>
                                </span>
                            </span>

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
                                <?php echo $frmProductSearch->getFieldHtml('sortBy'); ?></li>
                            <!-- <li class="page-views">
                                <a href="javascript:void(0);" data-vtype="grid" class="listing-view-toggle--js <?php echo $vtype == 'grid' ? 'active' : ''; ?>">
                                    <i class="icn">
                                        <svg class="svg" width="18" height="18">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#gridview">
                                            </use>
                                        </svg>
                                    </i>
                                </a>
                            </li> -->
                            <!-- <li class="page-views">
                                <a href="javascript:void(0);" data-vtype="list" class="listing-view-toggle--js <?php echo $vtype == 'list' ? 'active' : ''; ?>">
                                    <i class="icn">
                                        <svg class="svg" width="18" height="18">
                                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#listview">
                                            </use>
                                        </svg>
                                    </i>
                                </a>
                            </li> -->
                            <?php if ($vtype && FatApp::getConfig('CONF_ENABLE_GEO_LOCATION', FatUtility::VAR_INT, 0) && !empty(FatApp::getConfig('CONF_GOOGLEMAP_API_KEY', FatUtility::VAR_STRING, ''))) { ?>
                                <li class="page-sort-item">
                                    <button class="btn btn-outline-black btn-map-view <?php echo $vtype == 'map' ? 'active' : ''; ?>" type="button" data-vtype="map">
                                        <?php echo Labels::getLabel('LBL_MAP_VIEW', $siteLangId); ?> <span class="toggle-icon"></span>
                                    </button>
                                </li>
                            <?php } ?>

                            <li class="page-sort-item">
                                <button class="btn btn-outline-black btn-filters" type="button">
                                    <?php echo Labels::getLabel('LBL_ALL_FILTERS', $siteLangId); ?>
                                    <svg class="svg" width="18" height="18">
                                        <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#filter"></use>
                                    </svg>
                                </button>
                            </li>
                        </ul>
                        <?php echo $frmProductSearch->getFieldHtml('pageSize'); ?>
                    </div>

                </div>
            </div>
            <?php
            $productsData = array(
                'products' => $products,
                'tLeftRibbons' => $tLeftRibbons ?? [],
                'tRightRibbons' => $tRightRibbons ?? [],
                'moreSellersProductsArr' => isset($moreSellersProductsArr) ? $moreSellersProductsArr : [],
                'page' => $page,
                'pageCount' => $pageCount,
                'postedData' => $postedData,
                'recordCount' => $recordCount,
                'siteLangId' => $siteLangId,
                'pageSize' => $pageSize,
                'pageSizeArr' => $pageSizeArr,
            );
            if (!isset($postedData['vtype']) || (isset($postedData['vtype']) && $postedData['vtype'] != "map")) { ?>
                <div class="collection-listing filter-left">
                    <aside class="collection-sidebar productFilters-js" id="collection-sidebar" data-close-on-click-outside="collection-sidebar">
                    </aside>
                    <main class="collection-content">


                        <?php
                        if (false && isset($postedData['vtype']) && $postedData['vtype'] == "map") { ?>
                            <div class="interactive-stores">
                                <div class="interactive-stores-map">
                                    <div class="map-loader is-loading">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="50px" height="50px" viewBox="0 0 50 50" style="enable-background:new 0 0 50 50;" xml:space="preserve">
                                            <path fill="#fff" d="M43.935,25.145c0-10.318-8.364-18.683-18.683-18.683c-10.318,0-18.683,8.365-18.683,18.683h4.068c0-8.071,6.543-14.615,14.615-14.615c8.072,0,14.615,6.543,14.615,14.615H43.935z">
                                                <animateTransform attributeType="xml" attributeName="transform" type="rotate" from="0 25 25" to="360 25 25" dur="0.6s" repeatCount="indefinite">
                                                </animateTransform>
                                            </path>
                                        </svg>
                                    </div>
                                    <div class="canvas-map" id="productMap--js"> </div>
                                </div>
                                <?php $this->includeTemplate('products/products-list.php', $productsData, false); ?>
                            </div>
                        <?php } else { ?>
                            <div class="">
                                <?php $this->includeTemplate('products/products-list.php', $productsData, false); ?>
                            </div>
                        <?php } ?>
                    </main> <button class="btn btn-float link__filter btn--filters-control" data-trigger="collection-sidebar">

                        <svg class="svg" width="18" height="18">
                            <use xlink:href="<?php echo CONF_WEBROOT_URL; ?>images/retina/sprite.svg#filter"></use>
                        </svg>

                    </button>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
    if (isset($postedData['vtype']) && $postedData['vtype'] == "map") {
        include(CONF_THEME_PATH . 'products/products-list-map-view.php');
        //$this->includeTemplate('products/products-list-map-view.php', $productsData, false)

    } ?>
</section>


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
<div class="gap"></div>
<script>
    $(function () {
        $currentPageUrl = "<?php echo html_entity_decode($canonicalUrl, ENT_QUOTES, 'utf-8'); ?>";
        $productSearchPageType = '<?php echo $productSearchPageType; ?>';
        $recordId = <?php echo $recordId; ?>;
        /* bannerAdds('<?php echo $bannerListigUrl; ?>'); */
        loadProductListingfilters(document.frmProductSearch);
    });
</script>