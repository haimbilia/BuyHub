<?php

class BuyTogetherProductsController extends ListingBaseController {

    protected $pageKey = 'BUY_TOGETHER_PRODUCTS';

    public function __construct($action) {
        parent::__construct($action);
        $this->objPrivilege->canViewSellerProducts();
    }

    public function index() {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', HtmlHelper::getDefaultActionItems($fields));
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_PRODUCT_NAME', $this->siteLangId));
        $this->getListingData();
        $this->_template->addJs(['js/select2.js', 'js/tagify.min.js', 'js/tagify.polyfills.min.js', 'buy-together-products/page-js/index.js']);
        $this->_template->addCss(['css/select2.min.css', 'css/tagify.min.css']);
        $this->set('autoTableColumWidth', false);
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search() {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'buy-together-products/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData() {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $fields = $this->getFormColumns();
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

        $prodSrch = SellerProduct::searchUpsellProducts($this->siteLangId, 'upsell_sellerproduct_id');
        if ($keyword != '') {
            $cnd = $prodSrch->addCondition('product_name', 'like', '%' . $keyword. '%');
            $cnd->attachCondition('product_identifier', 'LIKE', '%' . $keyword . '%', 'OR');
        }
        $prodSrch->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'tuc.credential_user_id = selprod_user_id', 'tuc');
        $prodSrch->addMultipleFields([
            'credential_username',
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
        $prodSrch->addGroupBy('upsell_sellerproduct_id');
        $rs = $prodSrch->getResultSet();
        $upsellProds = FatApp::getDb()->fetchAll($rs, 'upsell_sellerproduct_id');
        $arrListing = array();
        foreach ($upsellProds as $key => $upsellProd) {
            $productId = $upsellProd['upsell_sellerproduct_id'];
            $srch = SellerProduct::searchUpsellProducts($this->siteLangId);
            $srch->addFld('if(upsell_sellerproduct_id = ' . $selProdId . ', 1 , 0) as priority');
            $srch->addOrder('priority', 'DESC');
            $srch->addCondition('upsell_sellerproduct_id', '=', $productId);
            $srch->addGroupBy('selprod_id');
            $srch->addGroupBy('upsell_sellerproduct_id');
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $arrListing[$productId] = FatApp::getDb()->fetchAll($rs);
            $arrListing[$productId]['credential_username'] = $upsellProd['credential_username'];
        }

        $this->set("arrListing", $arrListing);
        $this->set("productsList", $upsellProds);
        $this->set('pageCount', $prodSrch->pages());
        $this->set('recordCount', $prodSrch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        $this->set('frmSearch', $searchForm);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditSellerProducts($this->admin_id, true));
    }

    public function form() {
        $this->objPrivilege->canEditSellerProducts();
        $this->set('frm', $this->getForm());
        $this->set('includeTabs', false);
        $this->set('formTitle', Labels::getLabel('LBL_BIND_PRODUCTS', $this->siteLangId));
        $this->_template->render(false, false);
    }

    private function getForm() {
        $frm = new Form('frmBuyTogetherProduct');
        $frm->addHiddenField('', 'selprod_id', 0);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_PRODUCT', $this->siteLangId), 'product_name', []);
        $fld->requirement->setRequired(true);
        $frm->addSelectBox(Labels::getLabel('FRM_PRODUCT', $this->siteLangId), 'selected_products[]', [], '');
        return $frm;
    }

    public function setup() {
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
        if (!$sellerProdObj->addUpdateSellerUpsellProducts($recordId, $selectedProducts)) {
            LibHelper::exitWithError($sellerProdObj->getError(), true);
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function bindProduct() {
        $recordId = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        if (1 > $recordId) {
            LibHelper::exitWithError(Labels::getLabel("ERR_Please_Select_A_Valid_Product", $this->siteLangId), true);
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

    public function autoCompleteProducts() {
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = (2 > $page) ? 1 : $page;

        $post = FatApp::getPostedData();

        $srch = SellerProduct::getSearchObject($this->siteLangId);
        $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
        $srch->joinTable(Product::DB_TBL_LANG, 'LEFT JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $this->siteLangId, 'p_l');
        $srch->joinTable(User::DB_TBL_CRED, 'LEFT JOIN', 'tuc.credential_user_id = sp.selprod_user_id', 'tuc');
        $srch->joinTable(SellerProduct::DB_TBL_RELATED_PRODUCTS, 'LEFT JOIN', 'trp.related_sellerproduct_id = sp.selprod_id', 'trp');

        if (FatApp::getConfig("CONF_PRODUCT_BRAND_MANDATORY", FatUtility::VAR_INT, 1)) {
            $srch->joinTable(Brand::DB_TBL, 'INNER JOIN', 'tb.brand_id = product_brand_id and tb.brand_active = ' . applicationConstants::YES . ' and tb.brand_deleted = ' . applicationConstants::NO, 'tb');
        } else {
            $srch->joinTable(Brand::DB_TBL, 'LEFT JOIN', 'tb.brand_id = product_brand_id', 'tb');
            $srch->addDirectCondition("(case WHEN brand_id > 0 THEN (tb.brand_active = " . applicationConstants::YES . " AND tb.brand_deleted = " . applicationConstants::NO . ") else TRUE end)");
        }

        $srch->addOrder('product_name');
        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('product_name', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd = $cnd->attachCondition('selprod_title', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
            $cnd->attachCondition('product_identifier', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
        }

        if (!empty($post['selProdId']) && 0 < FatUtility::int($post['selProdId'])) {
            $selprod_user = SellerProduct::getAttributesById($post['selProdId'], array('selprod_user_id'));
            $srch->addCondition('selprod_user_id', '=', $selprod_user['selprod_user_id']);
            $srch->addCondition('selprod_id', '!=', $post['selProdId']);
        }

        if (array_key_exists('selprod_user_id', $post) && 0 < $post['selprod_user_id']) {
            $srch->addCondition('selprod_user_id', '=', $post['selprod_user_id']);
        }

        $srch->addCondition('trp.related_sellerproduct_id', 'IS', 'mysql_func_NULL', 'AND', true);

        $srch->addCondition(Product::DB_TBL_PREFIX . 'active', '=', applicationConstants::YES);
        $srch->addCondition(Product::DB_TBL_PREFIX . 'deleted', '=', applicationConstants::NO);
        $srch->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $srch->addCondition('selprod_active', '=', applicationConstants::ACTIVE);
        $srch->addMultipleFields(array('selprod_id as id', 'IFNULL(selprod_title ,product_name) as product_name', 'product_identifier', 'credential_username', 'selprod_price', 'selprod_stock'));

        $srch->addOrder('selprod_active', 'DESC');
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $db = FatApp::getDb();
        $rs = $srch->getResultSet();
        $products = array();
        if ($rs) {
            $products = $db->fetchAll($rs, 'id');
        }
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
                'name' => strip_tags(html_entity_decode($option['product_name'], ENT_QUOTES, 'UTF-8')) . $variantsStr . $userName,
                'product_identifier' => strip_tags(html_entity_decode($option['product_identifier'], ENT_QUOTES, 'UTF-8')),
                'price' => $option['selprod_price'],
                'stock' => $option['selprod_stock']
            );
        }
        die(json_encode(['pageCount' => $pageCount, 'products' => $json]));
    }

    public function deleteSelprodProduct($selprod_id, $relprod_id) {
        $selprod_id = FatUtility::int($selprod_id);
        $relprod_id = FatUtility::int($relprod_id);
        if (!$selprod_id || !$relprod_id) {
            Message::addErrorMessage(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
            FatApp::redirectUser($_SESSION['referer_page_url']);
        }

        $db = FatApp::getDb();
        if (!$db->deleteRecords(SellerProduct::DB_TBL_UPSELL_PRODUCTS, array('smt' => 'upsell_sellerproduct_id = ? AND upsell_recommend_sellerproduct_id = ?', 'vals' => array($selprod_id, $relprod_id)))) {
            Message::addErrorMessage(Labels::getLabel("LBL_" . $db->getError(), $this->siteLangId));
            FatApp::redirectUser($_SESSION['referer_page_url']);
        }

        $this->set('selprod_id', $selprod_id);
        $this->set('msg', Labels::getLabel('LBL_Record_Deleted', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getFormColumns(): array {
        $relatedProdsTblHeadingCols = CacheHelper::get('relatedProdsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($relatedProdsTblHeadingCols) {
            return json_decode($relatedProdsTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'product_name' => Labels::getLabel('LBL_Product_Name', $this->siteLangId),
            'upsell_products' => Labels::getLabel('LBL_BUY_TOGETHER_PRODUCTS', $this->siteLangId)
        ];
        CacheHelper::create('relatedProdsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array {
        return [
            'listSerial',
            'product_name',
            'upsell_products',
        ];
    }

    protected function excludeKeysForSort($fields = []): array {
        return array_diff($fields, ['upsell_products'], Common::excludeKeysForSort());
    }

}
