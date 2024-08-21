<?php

class VolumeDiscountController extends ListingBaseController
{
    protected $pageKey = 'VOLUME_DISCOUNT';

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
        $actionItemsData['searchFrmTemplate'] = 'volume-discount/search-form.php';

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_PRODUCT_NAME', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(['js/select2.js', 'volume-discount/page-js/index.js']);
        $this->_template->addCss(['css/select2.min.css']);
        $this->includeFeatherLightJsCss();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'volume-discount/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

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

        $searchForm = $this->getSearchForm($fields);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $postedData = FatApp::getPostedData();
        $post = $searchForm->getFormDataFromArray($postedData);

        $selProdId = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $sellerId = FatApp::getPostedData('product_seller_id', FatUtility::VAR_INT, 0);

        $srch = SellerProduct::searchVolumeDiscountProducts($this->siteLangId, $selProdId, $keyword, $sellerId);
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(
            [
                'selprod_id', 'credential_username', 'voldiscount_min_qty', 'voldiscount_percentage', 'IFNULL(product_name, product_identifier) as product_name', 'selprod_title',
                'voldiscount_id', 'product_updated_on', 'selprod_product_id', 'user_id', 'user_updated_on', 'credential_email', 'user_name', 'IFNULL(shopLang.shop_name, shop.shop_identifier) as shop_name'
            ]
        );
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $sortByCol = ('product_name' == $sortBy) ? 'selprod_title' : $sortBy;
        $srch->addOrder($sortByCol, $sortOrder);
        $arrListing = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set("arrListing", $arrListing);
        $paginationArr = empty($postedData) ? $post : $postedData;
        $this->set('postedData', $paginationArr);
        $this->set('frmSearch', $searchForm);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditSellerProducts($this->admin_id, true));
    }

    protected function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $frm->addSelectBox(Labels::getLabel('FRM_SELLER', $this->siteLangId), 'product_seller_id', []);

        if (!empty($fields)) {
            $this->addSortingElements($frm, 'product_name');
        }
        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    public function form()
    {
        $this->set('frm', $this->getForm());
        $this->set('includeTabs', false);
        $this->set('formTitle', Labels::getLabel('LBL_BIND_VOLUME_DISCOUNT', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getForm()
    {
        $frm = new Form('frmSellerProductVolumeDiscount');
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_Product', $this->siteLangId), 'voldiscount_selprod_id', []);
        $fld->requirement->setRequired(true);

        $frm->addIntegerField(Labels::getLabel("FRM_MINIMUM_QUANTITY", $this->siteLangId), 'voldiscount_min_qty');
        $discountFld = $frm->addFloatField(Labels::getLabel("FRM_DISCOUNT_IN_(%)", $this->siteLangId), "voldiscount_percentage");
        $discountFld->requirements()->setPositive();

        $frm->addHiddenField('', 'voldiscount_id');
        return $frm;
    }

    public function setup()
    {
        $data = FatApp::getPostedData();

        if (empty($data)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $selprod_id = FatUtility::int($data['voldiscount_selprod_id']);
        if (1 > $selprod_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $qty = FatApp::getPostedData('voldiscount_min_qty', FatUtility::VAR_INT, 0);
        if (2 > $qty) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_MINIMUM_QUANTITY_SHOULD_BE_GREATER_THAN_1', $this->siteLangId));
        }

        $volDiscountId = $this->updateSelProdVolDiscount($selprod_id, 0, $data['voldiscount_min_qty'], $data['voldiscount_percentage']);
        if (!$volDiscountId) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Invalid_Response', $this->siteLangId), true);
        }

        $productName = SellerProduct::getProductDisplayTitle($data['voldiscount_selprod_id'], $this->siteLangId, true);

        $srch = SellerProduct::getSearchObject();
        $srch->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'tuc.credential_user_id = sp.selprod_user_id', 'tuc');
        $srch->addMultipleFields(array('credential_username'));
        $srch->addCondition('selprod_id', '=', $data['voldiscount_selprod_id']);
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        $data['credential_username'] = $row['credential_username'];
        $data['product_name'] = $productName;
        $this->set('data', $data);
        $this->set('volDiscountId', $volDiscountId);
        $json = array(
            'status' => true,
            'msg' => $this->str_update_record,
        );
        FatUtility::dieJsonSuccess($json);
    }

    public function updateColValue()
    {
        $volDiscountId = FatApp::getPostedData('voldiscount_id', FatUtility::VAR_INT, 0);
        if (1 > $volDiscountId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $attribute = FatApp::getPostedData('attribute', FatUtility::VAR_STRING, '');

        $columns = array('voldiscount_min_qty', 'voldiscount_percentage');
        if (!in_array($attribute, $columns)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $value = FatApp::getPostedData('value');
        if ('voldiscount_min_qty' == $attribute && 2 > $value) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_MINIMUM_QUANTITY_SHOULD_BE_GREATER_THAN_1', $this->siteLangId));
        }

        $otherColumns = array_values(array_diff($columns, [$attribute]));
        $otherColumnsValue = SellerProductVolumeDiscount::getAttributesById($volDiscountId, $otherColumns);
        if (empty($otherColumnsValue)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $selProdId = FatApp::getPostedData('selProdId', FatUtility::VAR_INT, 0);

        $dataToUpdate = array(
            'voldiscount_id' => $volDiscountId,
            'voldiscount_selprod_id' => $selProdId,
            $attribute => $value
        );
        $dataToUpdate += $otherColumnsValue;

        $volDiscountId = $this->updateSelProdVolDiscount($selProdId, $volDiscountId, $dataToUpdate['voldiscount_min_qty'], $dataToUpdate['voldiscount_percentage']);
        if (!$volDiscountId) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Invalid_Response', $this->siteLangId), true);
        }

        $json = array(
            'status' => true,
            'msg' => $this->str_update_record,
            'data' => array('value' => $value)
        );
        FatUtility::dieJsonSuccess($json);
    }

    private function updateSelProdVolDiscount($selprod_id, $voldiscount_id, $minQty, $perc)
    {
        $sellerProductRow = SellerProduct::getAttributesById($selprod_id, array('selprod_user_id', 'selprod_stock', 'selprod_min_order_qty'), false);
        if ($minQty > $sellerProductRow['selprod_stock']) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Quantity_cannot_be_more_than_the_Stock', $this->siteLangId), true);
        }

        if ($minQty < $sellerProductRow['selprod_min_order_qty']) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Quantity_cannot_be_less_than_the_Minimum_Order_Quantity', $this->siteLangId) . ': ' . $sellerProductRow['selprod_min_order_qty'], true);
        }

        if ($perc > 100 || 1 > $perc) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Invalid_Percentage', $this->siteLangId), true);
        }

        /* Check if volume discount for same quantity already exists [ */
        $tblRecord = new TableRecord(SellerProductVolumeDiscount::DB_TBL);
        $smt = 'voldiscount_selprod_id = ? AND voldiscount_min_qty = ? ';
        $smtValues = array($selprod_id, $minQty);

        if (0 < $voldiscount_id) {
            $smt .= 'AND voldiscount_id != ?';
            $smtValues[] = $voldiscount_id;
        }
        $condition = array(
            'smt' => $smt,
            'vals' => $smtValues
        );
        if ($tblRecord->loadFromDb($condition)) {
            $volDiscountRow = $tblRecord->getFlds();
            if ($volDiscountRow['voldiscount_id'] != $voldiscount_id) {
                LibHelper::exitWithError(Labels::getLabel('ERR_Volume_discount_for_this_quantity_already_added', $this->siteLangId), true);
            }
        }
        /* ] */

        $data_to_save = array(
            'voldiscount_selprod_id' => $selprod_id,
            'voldiscount_min_qty' => $minQty,
            'voldiscount_percentage' => $perc
        );

        if ($voldiscount_id > 0) {
            $data_to_save['voldiscount_id'] = $voldiscount_id;
        }

        $record = new TableRecord(SellerProductVolumeDiscount::DB_TBL);
        $record->assignValues($data_to_save);
        if (!$record->addNew(array(), $data_to_save)) {
            LibHelper::exitWithError($record->getError(), true);
        }

        return ($voldiscount_id > 0) ? $voldiscount_id : $record->getId();
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
        $srch->joinTable(SellerProduct::DB_TBL_RELATED_PRODUCTS, 'LEFT JOIN', 'trp.related_sellerproduct_id = sp.selprod_id', 'trp');

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

        if (!empty($post['selProdId']) && 0 < FatUtility::int($post['selProdId'])) {
            $selprod_user = SellerProduct::getAttributesById($post['selProdId'], array('selprod_user_id'));
            $srch->addCondition('selprod_user_id', '=', $selprod_user['selprod_user_id']);
            $srch->addCondition('selprod_id', '!=', $post['selProdId']);
        }

        if (array_key_exists('selprod_user_id', $post) && 0 < $post['selprod_user_id']) {
            $srch->addCondition('selprod_user_id', '=', $post['selprod_user_id']);
        }

        $srch->addCondition(Product::DB_TBL_PREFIX . 'active', '=', applicationConstants::YES);
        $srch->addCondition(Product::DB_TBL_PREFIX . 'deleted', '=', applicationConstants::NO);
        $srch->addCondition(Product::DB_TBL_PREFIX . 'type', '!=', Product::PRODUCT_TYPE_SERVICE);
        $srch->addCondition('selprod_deleted', '=', applicationConstants::NO);
        $srch->addCondition('selprod_active', '=', applicationConstants::ACTIVE);
        $srch->addMultipleFields(array('selprod_id as id', 'COALESCE(selprod_title ,product_name, product_identifier) as product_name', 'product_identifier', 'credential_username', 'selprod_price', 'selprod_stock'));

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
                'text' => strip_tags(html_entity_decode($option['product_name'], ENT_QUOTES, 'UTF-8')) . $variantsStr . $userName,
                'product_identifier' => strip_tags(html_entity_decode($option['product_identifier'], ENT_QUOTES, 'UTF-8')),
                'price' => $option['selprod_price'],
                'stock' => $option['selprod_stock']
            );
        }
        die(json_encode(['pageCount' => $pageCount, 'results' => $json]));
    }

    public function autoCompleteSeller()
    {
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = (2 > $page) ? 1 : $page;

        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $srch = User::getSearchObject(true);
        $srch->addCondition('user_is_supplier', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
        $srch->addCondition('credential_active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);

        $srch->addMultipleFields(
            [
                'credential_user_id as id',
                'CONCAT(credential_username, " (", credential_email, ")") as text'
            ]
        );
        if ('' != $keyword) {
            $srch->addCondition('credential_username', 'like', '%' . $keyword . '%');
            $srch->addCondition('credential_email', 'like', '%' . $keyword . '%', 'OR');
        }
        $srch->setPageSize($pageSize);
        $srch->setPageNumber($page);
        $sellers = FatApp::getDb()->fetchAll($srch->getResultSet());

        die(json_encode(['pageCount' => $srch->pages(), 'results' => $sellers]));
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditEmptyCartItems();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);
        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditEmptyCartItems();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('selprod_ids'));

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

    protected function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $volumeDiscountRow = SellerProductVolumeDiscount::getAttributesById($recordId);
        $sellerProductRow = SellerProduct::getAttributesById($volumeDiscountRow['voldiscount_selprod_id'], array('selprod_user_id'), false);
        if (!$volumeDiscountRow || !$sellerProductRow) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $volumeDiscountSelprodId = $volumeDiscountRow['voldiscount_selprod_id'];

        $db = FatApp::getDb();
        if (!$db->deleteRecords(SellerProductVolumeDiscount::DB_TBL, array('smt' => 'voldiscount_id = ? AND voldiscount_selprod_id = ?', 'vals' => array($recordId, $volumeDiscountSelprodId)))) {
            LibHelper::exitWithError(Labels::getLabel("ERR_" . $db->getError(), $this->siteLangId), true);
        }
    }

    protected function getFormColumns(): array
    {
        $volumeDiscountTblHeadingCols = CacheHelper::get('volumeDiscountTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($volumeDiscountTblHeadingCols) {
            return json_decode($volumeDiscountTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'product_name' => Labels::getLabel('LBL_PRODUCT_NAME', $this->siteLangId),
            'voldiscount_min_qty' => Labels::getLabel('LBL_MINIMUM_QUANTITY', $this->siteLangId),
            'voldiscount_percentage' => Labels::getLabel('LBL_DISCOUNT', $this->siteLangId) . ' (%)',
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('volumeDiscountTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /* 'listSerial', */
            'product_name',
            'voldiscount_min_qty',
            'voldiscount_percentage',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
