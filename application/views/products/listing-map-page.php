<?php defined('SYSTEM_INIT') or die('Invalid Usage.');
if (empty($products)) {
    $pSrchFrm = Common::getSiteSearchForm();
    // $pSrchFrm->fill(array('btnSiteSrchSubmit' => Labels::getLabel('LBL_Submit', $siteLangId)));
    $pSrchFrm->setFormTagAttribute('onsubmit', 'submitSiteSearch(this); return(false);');

    $this->includeTemplate('_partial/no-product-found.php', array('pSrchFrm' => $pSrchFrm, 'siteLangId' => $siteLangId, 'postedData' => $postedData), true);
    return;
}
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
    'viewType' => $viewType ?? '',
);
?>
<div class="section productsAndFiltersJs">
    <div class="container">
        <div class="collection-search">
            <?php
            include(CONF_THEME_PATH . 'products/products-list-map-view.php');
            ?>
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
    </div>
</div>
