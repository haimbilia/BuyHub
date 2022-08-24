<?php

class BuyTogetherProductsController extends ListingBaseController
{

    protected $pageKey = 'BUY_TOGETHER_PRODUCTS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSellerProducts();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['formAction'] = 'deleteSelected';

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_PRODUCT_NAME', $this->siteLangId));
        $this->getListingData();
        $this->_template->addJs(['js/select2.js', 'js/tagify.min.js', 'js/tagify.polyfills.min.js', 'buy-together-products/page-js/index.js']);
        $this->_template->addCss(['css/select2.min.css', 'css/tagify.min.css']);
        $this->includeFeatherLightJsCss();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'buy-together-products/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $fields = $this->getFormColumns();
        $this->setCustomColumnWidth();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        if ('product_name' == $sortBy) {
            $sortBy = 'selprod_title';
        }
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $searchForm = $this->getSearchForm($fields);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());
        $selProdId = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);

        $prodSrch = new SearchBase(SellerProduct::DB_TBL_UPSELL_PRODUCTS);
        $prodSrch->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', SellerProduct::DB_TBL_PREFIX . 'id = ' . SellerProduct::DB_TBL_UPSELL_PRODUCTS_PREFIX . 'sellerproduct_id', 'sp');
        $prodSrch->joinTable(SellerProduct::DB_TBL . '_lang', 'LEFT JOIN', 'slang.' . SellerProduct::DB_TBL_LANG_PREFIX . 'selprod_id = ' . SellerProduct::DB_TBL_UPSELL_PRODUCTS_PREFIX . 'sellerproduct_id AND ' . SellerProduct::DB_TBL_LANG_PREFIX . 'lang_id = ' . $this->siteLangId, 'slang');
        $prodSrch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $prodSrch->joinTable(Product::DB_TBL_LANG, 'LEFT JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');

        if ($keyword != '') {
            $cnd = $prodSrch->addCondition('product_name', 'LIKE', '%' . $keyword . '%');
            $cnd = $cnd->attachCondition('selprod_title', 'LIKE', '%' . $keyword . '%', 'OR');
            $cnd->attachCondition('product_identifier', 'LIKE', '%' . $keyword . '%', 'OR');
        }

        $prodSrch->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'tuc.credential_user_id = selprod_user_id', 'tuc');
        $prodSrch->addGroupBy('upsell_sellerproduct_id');
        $this->setRecordCount(clone $prodSrch, $pageSize, $page, $post, true);
        $prodSrch->doNotCalculateRecords();

        $prodSrch->addMultipleFields([
            'credential_username',
            'upsell_sellerproduct_id',
            'selprod_id',
            'selprod_product_id',
            'product_updated_on',
            'selprod_title',
            'product_name',
            'product_identifier',
        ]);
        $prodSrch->setPageNumber($page);
        $prodSrch->setPageSize($pageSize);
        $prodSrch->addOrder($sortBy, $sortOrder);
        $rs = $prodSrch->getResultSet();
        $upsellProds = FatApp::getDb()->fetchAll($rs, 'upsell_sellerproduct_id');
        foreach ($upsellProds as $productId => $upsellProd) {
            $srch = SellerProduct::searchUpsellProducts($this->siteLangId, [], false);
            $srch->addFld('if(upsell_sellerproduct_id = ' . $selProdId . ', 1 , 0) as priority');
            $srch->addOrder('priority', 'DESC');
            $srch->addCondition('upsell_sellerproduct_id', '=', $productId);
            $srch->addGroupBy('selprod_id');
            $srch->addGroupBy('upsell_sellerproduct_id');
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $upsellProds[$productId]['products'] = FatApp::getDb()->fetchAll($rs);
            $upsellProds[$productId]['credential_username'] = $upsellProd['credential_username'];
        }

        $this->set("arrListing", $upsellProds);
        $this->set('postedData', $post);
        $this->set('frmSearch', $searchForm);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditSellerProducts($this->admin_id, true));
    }

    public function form()
    {
        $this->objPrivilege->canEditSellerProducts();
        $this->set('frm', $this->getForm());
        $this->set('includeTabs', false);
        $this->set('formTitle', Labels::getLabel('LBL_BIND_PRODUCTS', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getForm()
    {
        $frm = new Form('frmBuyTogetherProduct');
        $frm->addHiddenField('', 'selprod_user_id');
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_PRODUCT', $this->siteLangId), 'selprod_id', []);
        $fld->requirement->setRequired(true);
        $frm->addSelectBox(Labels::getLabel('FRM_PRODUCT', $this->siteLangId), 'selected_products[]', [], '');
        return $frm;
    }

    public function setup()
    {
        $this->objPrivilege->canEditSellerProducts();
        $post = FatApp::getPostedData();
        $recordId = FatUtility::int($post['selprod_id']);
        if (1 > $recordId) {
            LibHelper::exitWithError(Labels::getLabel("ERR_Please_Select_A_Valid_Product", $this->siteLangId), true);
        }

        if (!isset($post['selected_products']) || !is_array($post['selected_products']) || 1 > count($post['selected_products'])) {
            LibHelper::exitWithError(Labels::getLabel("ERR_MUST_SELECT_ATLEAST_ONE_PRODUCT_TO_BUY_TOGETHER", $this->siteLangId), true);
        }

        $selectedProducts = $post['selected_products'];
        unset($post['selprod_id']);
        $sellerProdObj = new SellerProduct();
        if (!$sellerProdObj->addUpdateSellerUpsellProducts($recordId, $selectedProducts, false)) {
            LibHelper::exitWithError($sellerProdObj->getError(), true);
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function bindProduct()
    {
        $recordId = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        if (1 > $recordId) {
            LibHelper::exitWithError(Labels::getLabel("ERR_PLEASE_SELECT_A_VALID_PRODUCT", $this->siteLangId), true);
        }
        $relatedProdId = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);

        $record = new TableRecord(SellerProduct::DB_TBL_UPSELL_PRODUCTS);
        $data = [
            SellerProduct::DB_TBL_UPSELL_PRODUCTS_PREFIX . 'sellerproduct_id' => $recordId,
            SellerProduct::DB_TBL_UPSELL_PRODUCTS_PREFIX . 'recommend_sellerproduct_id' => $relatedProdId
        ];
        $record->assignValues($data);
        if (!$record->addNew(array(), $data)) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function autoCompleteProducts()
    {
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = (2 > $page) ? 1 : $page;

        $post = FatApp::getPostedData();
        $srch = SellerProduct::getSearchObject($this->siteLangId);
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');
        $srch->joinTable(User::DB_TBL_CRED, 'LEFT JOIN', 'tuc.credential_user_id = sp.selprod_user_id', 'tuc');

        if (FatApp::getConfig("CONF_PRODUCT_BRAND_MANDATORY", FatUtility::VAR_INT, 1)) {
            $srch->joinTable(Brand::DB_TBL, 'INNER JOIN', 'tb.brand_id = product_brand_id and tb.brand_active = ' . applicationConstants::YES . ' and tb.brand_deleted = ' . applicationConstants::NO, 'tb');
        } else {
            $srch->joinTable(Brand::DB_TBL, 'LEFT JOIN', 'tb.brand_id = product_brand_id', 'tb');
            $srch->addDirectCondition("(case WHEN brand_id > 0 THEN (tb.brand_active = " . applicationConstants::YES . " AND tb.brand_deleted = " . applicationConstants::NO . ") else TRUE end)");
        }

        $srch->addOrder('product_name');
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cnd = $srch->addCondition('product_name', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('selprod_title', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
            $cnd->attachCondition('product_identifier', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
        }

        if (array_key_exists('selprod_user_id', $post) && 0 < $post['selprod_user_id']) {
            $srch->addCondition('selprod_user_id', '=', $post['selprod_user_id']);
        }

        $mainRecordId = FatApp::getPostedData('mainRecordId', FatUtility::VAR_INT, 0);
        if (0 < $mainRecordId) {
            $srch->addCondition('selprod_id', '!=', $mainRecordId);

            $prodSrch = new SearchBase(SellerProduct::DB_TBL_UPSELL_PRODUCTS);
            $prodSrch->doNotCalculateRecords();
            $prodSrch->doNotLimitRecords();
            $prodSrch->addFld('upsell_recommend_sellerproduct_id');
            $prodSrch->addCondition('upsell_sellerproduct_id', '=', $mainRecordId);
            $prodSrch->getResultSet();
            $srch->addDirectCondition('selprod_id NOT IN (' . $prodSrch->getQuery() . ')');
        }

        $excludeRecords = FatApp::getPostedData('excludeRecords', FatUtility::VAR_INT);
        if (!empty($excludeRecords) && is_array($excludeRecords)) {
            $srch->addCondition('selprod_id', 'NOT IN', $excludeRecords);
        }

        $srch->addCondition(Product::DB_TBL_PREFIX . 'active', '=', applicationConstants::YES);
        $srch->addCondition(Product::DB_TBL_PREFIX . 'deleted', '=', applicationConstants::NO);
        $srch->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $srch->addCondition('selprod_active', '=', applicationConstants::ACTIVE);
        $srch->addMultipleFields(array('selprod_id as id', 'COALESCE(selprod_title ,product_name, product_identifier) as product_name', 'product_identifier', 'credential_username', 'selprod_user_id'));

        $srch->addOrder('selprod_active', 'DESC');
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        $rs = $srch->getResultSet();
        $products = FatApp::getDb()->fetchAll($rs, 'id');

        $pageCount = $srch->pages();
        $json = array();
        foreach ($products as $key => $option) {
            $options = SellerProduct::getSellerProductOptions($key, true, $this->siteLangId);
            $variantsStr = '';
            array_walk($options, function ($item, $key) use (&$variantsStr) {
                $variantsStr .= ' | ' . $item['option_name'] . ' : ' . $item['optionvalue_name'];
            });
            $userName = isset($option["credential_username"]) ? " | " . $option["credential_username"] : '';
            $json[] = array(
                'id' => $key,
                'text' => strip_tags(html_entity_decode($option['product_name'], ENT_QUOTES, 'UTF-8')) . $variantsStr . $userName,
                'selprod_user_id' => $option['selprod_user_id']
            );
        }
        die(json_encode(['pageCount' => $pageCount, 'results' => $json]));
    }

    public function deleteSelprodProduct($selprod_id, $relprod_id)
    {
        $this->objPrivilege->canEditSellerProducts();
        $selprod_id = FatUtility::int($selprod_id);
        $relprod_id = FatUtility::int($relprod_id);
        if (!$selprod_id || !$relprod_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $db = FatApp::getDb();
        if (!$db->deleteRecords(SellerProduct::DB_TBL_UPSELL_PRODUCTS, array('smt' => 'upsell_sellerproduct_id = ? AND upsell_recommend_sellerproduct_id = ?', 'vals' => array($selprod_id, $relprod_id)))) {
            LibHelper::exitWithError($db->getError(), true);
        }

        $this->set('selprod_id', $selprod_id);
        $this->set('msg', Labels::getLabel('MSG_RECORD_DELETED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditSellerProducts();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);

        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditSellerProducts();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('record_ids'));

        if (empty($recordIdsArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            $this->markAsDeleted($recordId);
        }
        $this->set('msg', Labels::getLabel('MSG_RECORDS_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted(int $recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $db = FatApp::getDb();
        if (!$db->deleteRecords(SellerProduct::DB_TBL_UPSELL_PRODUCTS, array('smt' => 'upsell_sellerproduct_id = ?', 'vals' => array($recordId)))) {
            LibHelper::exitWithError($db->getError(), true);
        }
    }


    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('buyTogetherProdsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'product_name' => Labels::getLabel('LBL_Product_Name', $this->siteLangId),
            'upsell_products' => Labels::getLabel('LBL_BUY_TOGETHER_PRODUCTS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('buyTogetherProdsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }


    /**
     * setCustomColumnWidth
     *
     * @return void
     */
    protected function setCustomColumnWidth(): void
    {
        $arr = [
            /*  'listSerial' => [
                'width' => '5%'
            ], */
            'product_name' => [
                'width' => '30%'
            ],
            'upsell_products' => [
                'width' => '65%'
            ],
            'action' => [
                'width' => '5%'
            ],
        ];
        $this->set('tableHeadAttrArr', $arr);
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /* 'listSerial', */
            'product_name',
            'upsell_products',
            'action'
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['upsell_products'], Common::excludeKeysForSort());
    }
}
