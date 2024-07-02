<?php

class AbandonedCartProductsController extends ListingBaseController
{
    protected string $pageKey = 'MANAGE_ABANDONED_CART_PRODUCTS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewAbandonedCart();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtn'] = false;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->getListingData();

        $this->_template->addJs(array('js/select2.js', 'abandoned-cart-products/page-js/index.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->render(true, true, null, false, false);
    }

    public function search()
    {
        $loadPagination = FatApp::getPostedData('loadPagination', FatUtility::VAR_INT, 0);
        $this->getListingData($loadPagination);

        $jsonData = [
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];

        if (!$loadPagination || !FatUtility::isAjaxCall()) {
            $jsonData['listingHtml'] = $this->_template->render(false, false, 'abandoned-cart-products/search.php', true);
        }
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData($loadPagination = 0)
    {
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }
        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $searchForm = $this->getSearchForm($fields);
        $postedData = FatApp::getPostedData();
        $post = $searchForm->getFormDataFromArray($postedData);

        $selProdId = FatApp::getPostedData('abandonedcart_selprod_id', FatUtility::VAR_INT, 0);

        $srch = new AbandonedCartSearch();
        $srch->joinSellerProducts($this->siteLangId);
        $srch->addSubQueryCondition();
        $srch->addActionCondition();
        $srch->addMultipleFields(array(AbandonedCart::DB_TBL_PREFIX . 'selprod_id', 'selprod_title', 'count(' . AbandonedCart::DB_TBL_PREFIX . 'selprod_id' . ') as product_count'));
        $srch->addGroupBy(AbandonedCart::DB_TBL_PREFIX . 'selprod_id');

        if ($selProdId > 0) {
            $srch->addCondition(AbandonedCart::DB_TBL_PREFIX . 'selprod_id', '=', 'mysql_func_' . $selProdId, 'AND', true);
        }

        if ($loadPagination && FatUtility::isAjaxCall()) {
            $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        }

        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        $rs = $srch->getResultSet();
        $records = [];
        if (!$loadPagination) {
            $records = FatApp::getDb()->fetchAll($rs);
        }

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);

        $paginationArr = empty($postedData) ? $post : $postedData;
        $this->set('postedData', $paginationArr);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('actionArr', AbandonedCart::getActionArr($this->siteLangId));
    }

    public function getSearchForm(array $fields = [])
    {
        $frm = new Form('frmAbandonedCartSearch');
        $frm->addHiddenField('', 'page', 1);
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'selprod_title');
        }
        $frm->addSelectBox(Labels::getLabel('FRM_SELLER_PRODUCT', $this->siteLangId), 'abandonedcart_selprod_id', [], '', ['placeholder' => Labels::getLabel('FRM_SEARCH_BY_PRODUCT_NAME', $this->siteLangId)]);

        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('abdCartProdsFormTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            /*  'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'selprod_title' => Labels::getLabel('LBL_SELLER_PRODUCT', $this->siteLangId),
            'product_count' => Labels::getLabel('LBL_USER_COUNT', $this->siteLangId),
        ];

        CacheHelper::create('abdCartProdsFormTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            /*  'listSerial', */
            'selprod_title',
            'product_count'
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'index':
                $pageData = PageLanguageData::getAttributesByKey('MANAGE_ABANDONED_CART', $this->siteLangId);
                $abandonedCartTitle = $pageData['plang_title'] ?? Labels::getLabel('LBL_ABANDONED_CART', $this->siteLangId);
                $this->nodes = [
                    ['title' => $abandonedCartTitle, 'href' => UrlHelper::generateUrl('AbandonedCart')],
                    ['title' => Labels::getLabel('LBL_PRODUCTS', $this->siteLangId)]
                ];
        }
        return $this->nodes;
    }
}
