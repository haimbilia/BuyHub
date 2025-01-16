<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (empty($products)) {
    $pSrchFrm = Common::getSiteSearchForm();
    $pSrchFrm->setFormTagAttribute('onsubmit', 'submitSiteSearch(this); return(false);');

    $this->includeTemplate('_partial/no-product-found.php', array('pSrchFrm' => $pSrchFrm, 'siteLangId' => $siteLangId, 'postedData' => $postedData), true);
    return;
}
$productsData = array(
    'products' => $products,
    'tRightRibbons' => $tRightRibbons ?? [],
    'page' => $page,
    'pageCount' => $pageCount,
    'postedData' => $postedData,
    'recordCount' => $recordCount,
    'siteLangId' => $siteLangId,
    'pageSize' => $pageSize,
    'pageSizeArr' => $pageSizeArr,
    'viewType' => $viewType ?? '',
);
include(CONF_THEME_PATH . 'products/products-list-map-view.php');
?>
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