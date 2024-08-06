<?php

class SpecialPriceController extends ListingBaseController
{
    protected string $modelClass = 'SellerProduct';
    protected $pageKey = 'SPECIAL_PRICE';

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

        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['searchFrmTemplate'] = 'special-price/search-form.php';

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_PRODUCT_NAME', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(['js/select2.js', 'special-price/page-js/index.js']);
        $this->_template->addCss(['css/select2.min.css']);
        $this->includeFeatherLightJsCss();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'special-price/search.php', true),
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

        $srch = SellerProduct::searchSpecialPriceProductsObj($this->siteLangId, $selProdId, $keyword, $sellerId);
        $srch->addMultipleFields(
            array(
                'selprod_id', 'credential_username', 'selprod_price', 'date(splprice_start_date) as splprice_start_date', 'splprice_end_date', 'IFNULL(product_name, product_identifier) as product_name',
                'selprod_title', 'splprice_id', 'splprice_price', 'selprod_product_id', 'product_updated_on', 'user_id', 'user_updated_on', 'credential_email', 'user_name', 'IFNULL(shopLang.shop_name, shop.shop_identifier) as shop_name'
            )
        );
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
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
        $this->set('formTitle', Labels::getLabel('LBL_BIND_SPECIAL_PRICE', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getForm()
    {
        $frm = new Form('frmSellerProductSpecialPrice');
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_Product', $this->siteLangId), 'product_name', []);
        $fld->requirement->setRequired(true);
        $fld = $frm->addFloatField(Labels::getLabel('FRM_Special_Price', $this->siteLangId) . CommonHelper::concatCurrencySymbolWithAmtLbl(), 'splprice_price');
        $fld->requirements()->setPositive();
        $fld = $frm->addDateField(Labels::getLabel('FRM_Price_Start_Date', $this->siteLangId), 'splprice_start_date', '', array('readonly' => 'readonly', 'class' => 'field--calender'));
        $fld->requirements()->setRequired();

        $fld = $frm->addDateField(Labels::getLabel('FRM_Price_End_Date', $this->siteLangId), 'splprice_end_date', '', array('readonly' => 'readonly', 'class' => 'field--calender'));
        $fld->requirements()->setRequired();
        $fld->requirements()->setCompareWith('splprice_start_date', 'ge', Labels::getLabel('FRM_Price_Start_Date', $this->siteLangId));

        $frm->addHiddenField('', 'splprice_selprod_id');
        $frm->addHiddenField('', 'splprice_id');
        return $frm;
    }

    public function setup()
    {
        $data = FatApp::getPostedData();
        if (empty($data)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $splPriceId = $this->updateSelProdSplPrice($data, true);
        if (!$splPriceId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        // last Param of getProductDisplayTitle function used to get title in html form.
        $productName = SellerProduct::getProductDisplayTitle($data['splprice_selprod_id'], $this->siteLangId, true);

        $srch = SellerProduct::getSearchObject();
        $srch->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'tuc.credential_user_id = sp.selprod_user_id', 'tuc');
        $srch->addMultipleFields(array('credential_username', 'selprod_price'));
        $srch->addCondition('selprod_id', '=', $data['splprice_selprod_id']);
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        $data['credential_username'] = $row['credential_username'];
        $data['selprod_price'] = $row['selprod_price'];
        $data['product_name'] = $productName;

        $this->set('data', $data);
        $this->set('splPriceId', $splPriceId);
        $json = array(
            'status' => true,
            'msg' => $this->str_update_record,
        );
        FatUtility::dieJsonSuccess($json);
    }

    public function updateColValue()
    {
        $splPriceId = FatApp::getPostedData('splprice_id', FatUtility::VAR_INT, 0);
        if (1 > $splPriceId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $attribute = FatApp::getPostedData('attribute', FatUtility::VAR_STRING, '');

        $columns = array('splprice_start_date', 'splprice_end_date', 'splprice_price');
        if (!in_array($attribute, $columns)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $otherColumns = array_values(array_diff($columns, [$attribute]));
        $otherColumnsValue = SellerProductSpecialPrice::getAttributesById($splPriceId, $otherColumns);
        if (empty($otherColumnsValue)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $value = FatApp::getPostedData('value');
        $selProdId = FatApp::getPostedData('selProdId', FatUtility::VAR_INT, 0);

        $dataToUpdate = array(
            'splprice_selprod_id' => $selProdId,
            'splprice_id' => $splPriceId,
            $attribute => $value,
        );

        $dataToUpdate += $otherColumnsValue;

        if (!$this->updateSelProdSplPrice($dataToUpdate)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_SOMETHING_WENT_WRONG._PLEASE_TRY_AGAIN.', $this->siteLangId), true);
        }

        Product::updateMinPrices(SellerProduct::getAttributesById($selProdId,'selprod_product_id'));

        if ('splprice_price' == $attribute) {
            $value = CommonHelper::displayMoneyFormat($value, true, true);
        }
        $json = array(
            'status' => true,
            'msg' => $this->str_update_record,
            'data' => ['value' => $value]
        );
        FatUtility::dieJsonSuccess($json);
    }

    private function updateSelProdSplPrice($post, $return = false)
    {
        $selprod_id = !empty($post['splprice_selprod_id']) ? FatUtility::int($post['splprice_selprod_id']) : 0;
        $splprice_id = !empty($post['splprice_id']) ? FatUtility::int($post['splprice_id']) : 0;

        if (1 > $selprod_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (strtotime($post['splprice_start_date']) > strtotime($post['splprice_end_date'])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Invalid_Dates', $this->siteLangId), true);
        }

        /* $prodSrch = new ProductSearch(0);
        $prodSrch->joinSellerProducts(0,'',[], false);
        $prodSrch->addCondition('selprod_id', '=', $selprod_id);
        $prodSrch->addMultipleFields(array('product_min_selling_price', 'selprod_price'));
        $prodSrch->doNotCalculateRecords();
        $prodSrch->setPageSize(1);       
        $rs = $prodSrch->getResultSet();
        $product = FatApp::getDb()->fetch($rs);        
        if (!isset($post['splprice_price']) || $post['splprice_price'] < $product['product_min_selling_price'] || $post['splprice_price'] > $product['selprod_price']) {

            $str = Labels::getLabel('ERR_PRICE_MUST_BETWEEN_MIN_SELLING_PRICE_{MINSELLINGPRICE}_AND_SELLING_PRICE_{SELLINGPRICE}', $this->siteLangId);
            $minSellingPrice = CommonHelper::displayMoneyFormat($product['product_min_selling_price'], false, true, true);
            $sellingPrice = CommonHelper::displayMoneyFormat($product['selprod_price'], false, true, true);

            $message = CommonHelper::replaceStringData($str, array('{MINSELLINGPRICE}' => $minSellingPrice, '{SELLINGPRICE}' => $sellingPrice));
            LibHelper::exitWithError($message);
        } */

        /* Check if same date already exists [ */
        $tblRecord = new TableRecord(SellerProduct::DB_TBL_SELLER_PROD_SPCL_PRICE);

        $smt = 'splprice_selprod_id = ? AND ';
        $smt .= '(
                    ((splprice_start_date between ? AND ?) OR (splprice_end_date between ? AND ?))
                    OR
                    ((? BETWEEN splprice_start_date AND splprice_end_date) OR (? BETWEEN  splprice_start_date AND splprice_end_date))
                )';
        $smtValues = array(
            $selprod_id,
            $post['splprice_start_date'],
            $post['splprice_end_date'],
            $post['splprice_start_date'],
            $post['splprice_end_date'],
            $post['splprice_start_date'],
            $post['splprice_end_date'],
        );

        if (0 < $splprice_id) {
            $smt .= 'AND splprice_id != ?';
            $smtValues[] = $splprice_id;
        }
        $condition = array(
            'smt' => $smt,
            'vals' => $smtValues
        );

        if ($tblRecord->loadFromDb($condition)) {
            $specialPriceRow = $tblRecord->getFlds();
            if ($specialPriceRow['splprice_id'] != $splprice_id) {
                LibHelper::exitWithError(Labels::getLabel('ERR_SPECIAL_PRICE_FOR_THIS_DATE_ALREADY_ADDED', $this->siteLangId), true);
            }
        }
        /* ] */

        $data_to_save = array(
            'splprice_selprod_id' => $selprod_id,
            'splprice_start_date' => $post['splprice_start_date'],
            'splprice_end_date' => $post['splprice_end_date'],
            'splprice_price' => $post['splprice_price'],
        );

        if (0 < $splprice_id) {
            $data_to_save['splprice_id'] = $splprice_id;
        }

        $sellerProdObj = new SellerProduct();

        // Return Special Price ID if $return is true else it will return bool value.
        $splPriceId = $sellerProdObj->addUpdateSellerProductSpecialPrice($data_to_save, $return);
        if (false === $splPriceId) {
            LibHelper::exitWithError($sellerProdObj->getError(), true);
        }

        return $splPriceId;
    }    

    public function autoCompleteSeller()
    {
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = (2 > $page) ? 1 : $page;

        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $srch = User::getSearchObject(true);
        $srch->addCondition('user_is_supplier', '=', applicationConstants::YES);
        $srch->addCondition('credential_active', '=', applicationConstants::ACTIVE);

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
        $specialPriceRow = SellerProduct::getSellerProductSpecialPriceById($recordId);
        if (empty($specialPriceRow) || 1 > count($specialPriceRow)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Already_Deleted', $this->siteLangId), true);
        }

        $sellerProdObj = new SellerProduct($specialPriceRow['selprod_id']);
        if (!$sellerProdObj->deleteSellerProductSpecialPrice($recordId, $specialPriceRow['selprod_id'])) {
            LibHelper::exitWithError($sellerProdObj->getError(), true);
        }
    }

    protected function getFormColumns(): array
    {
        $splPriceTblHeadingCols = CacheHelper::get('splPriceTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($splPriceTblHeadingCols) {
            return json_decode($splPriceTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'product_name' => Labels::getLabel('LBL_Product_Name', $this->siteLangId),
            'selprod_price' => Labels::getLabel('LBL_SELLING_PRICE', $this->siteLangId),
            'splprice_price' => Labels::getLabel('LBL_Special_Price', $this->siteLangId),
            'splprice_start_date' => Labels::getLabel('LBL_Start_Date', $this->siteLangId),
            'splprice_end_date' => Labels::getLabel('LBL_End_Date', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('splPriceTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /* 'listSerial', */
            'product_name',
            'selprod_price',
            'splprice_price',
            'splprice_start_date',
            'splprice_end_date',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
