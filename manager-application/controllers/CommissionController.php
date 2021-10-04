<?php

class CommissionController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewCommissionSettings();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_COMMISSION', $this->adminLangId));
        $this->getListingData();

        $this->_template->render();
    }

    private function getListingData()
    {
        $db = FatApp::getDb();
        $post = FatApp::getPostedData();

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_ASC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);

        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_STRING, FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        if (!in_array($pageSize, applicationConstants::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }

        $attr = array(
            'tcs.*',
            'IFNULL(tp_l.product_name,tp.product_identifier)as product_name',
            'IFNULL(tpc_l.prodcat_name,tpc.prodcat_identifier)as prodcat_name',
            'CONCAT(COALESCE(s_l.shop_name, shop.shop_identifier), " ( ", tuc.credential_username, " )") as vendor',
            'commsetting_id as listSerial'
        );
        $srch = Commission::getCommissionSettingsObj($this->adminLangId, 0, $attr);
        $srch->joinTable(Shop::DB_TBL, 'LEFT OUTER JOIN', 'shop_user_id = if(tu.user_parent > 0, user_parent, tu.user_id)', 'shop');
        $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT OUTER JOIN', 'shop.shop_id = s_l.shoplang_shop_id AND shoplang_lang_id = ' . $this->adminLangId, 's_l');

        if (!empty($post['keyword'])) {
            $cond = $srch->addCondition('prodcat_identifier', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('tuc.credential_username', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cond->attachCondition('product_identifier', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $arrListing = $db->fetchAll($rs);

        $this->set("arrListing", $arrListing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditCountries($this->admin_id, true));
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'commission/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function form()
    {
        $this->objPrivilege->canEditCommissionSettings();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);

        if (0 < $recordId) {
            $data = Commission::getAttributesById(
                $recordId,
                array('commsetting_id', 'commsetting_product_id', 'commsetting_user_id', 'commsetting_prodcat_id', 'commsetting_fees')
            );
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }

            if ($data['commsetting_user_id'] > 0) {
                $userObj = new User($data['commsetting_user_id']);
                $res = $userObj->getUserInfo();
                $data['user_name'] = isset($res['credential_username']) ? $res['credential_username'] : '';
            }

            if ($data['commsetting_product_id'] > 0) {
                $prodObj = Product::getSearchObject($this->adminLangId);
                $prodObj->addCondition('product_id', '=', $data['commsetting_product_id']);
                $prodObj->addMultipleFields(array('IFNULL(product_name,product_identifier) as product_name'));
                $prodObj->doNotCalculateRecords();
                $prodObj->setPageSize(1);
                $rs = $prodObj->getResultSet();
                $db = FatApp::getDb();
                $row = $db->fetch($rs);
                $data['product'] = isset($row['product_name']) ? $row['product_name'] : '';
            }

            if ($data['commsetting_prodcat_id'] > 0) {
                $prodCat = new ProductCategory();
                $selectedCatName = $prodCat->getParentTreeStructure($data['commsetting_prodcat_id'], 0, '', $this->adminLangId);
                $data['category_name'] = html_entity_decode($selectedCatName);
            }

            $frm->fill($data);
        }

        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formLayout', Language::getLayoutDirection($this->adminLangId));
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditCommissionSettings();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['commsetting_id'];
        unset($post['commsetting_id']);

        $isMandatory = false;
        if ($data = Commission::getAttributesById($recordId, array('commsetting_is_mandatory'))) {
            $isMandatory = $data['commsetting_is_mandatory'];
        }

        if (false == $isMandatory && 1 < $recordId && (empty($post['commsetting_prodcat_id']) && empty($post['commsetting_user_id']) && empty($post['commsetting_product_id']))) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Please_add_commission_corresponding_to_product,_category_or_user', $this->adminLangId), true);
        }

        if ($isMandatory) {
            $post['commsetting_product_id'] = 0;
            $post['commsetting_user_id'] = 0;
            $post['commsetting_prodcat_id'] = 0;
        }

        $record = new Commission($recordId);
        if (!$record->addUpdateData($post)) {
            LibHelper::exitWithError($record->getError(), true);
        }
        $insertId = $record->getMainTableRecordId();
        if (!$insertId) {
            $insertId = FatApp::getDb()->getInsertId();
        }

        if (!$record->addCommissionHistory($insertId)) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('msg', Labels::getLabel('LBL_UPDATED_SUCCESSFULLY', $this->adminLangId));
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function viewLog()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $post = FatApp::getPostedData();
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : $post['page'];
        $page = (empty($page) || $page <= 0) ? 1 : FatUtility::int($page);

        $srch = Commission::getCommissionHistorySettingsObj($this->adminLangId);
        $srch->addCondition('tcsh.csh_commsetting_id', '=', $recordId);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
       
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditCommissionSettings();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $row = Commission::getAttributesById($recordId, array('commsetting_id', 'commsetting_is_mandatory'));
        if ($row == false || ($row != false && $row['commsetting_is_mandatory'] == 1)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);

        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditCommissionSettings();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('commsetting_ids'));

        if (empty($recordIdsArr)) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId), true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            $this->markAsDeleted($recordId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId), true);
        }
        $obj = new Commission($recordId);
        $obj->assignValues(array('commsetting_deleted' => 1));
        if (!$obj->save()) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    public function userAutoComplete()
    {
        $userObj = new User();
        $srch = $userObj->getUserSearchObj(array('u.user_name', 'u.user_id', 'credential_username', 'COALESCE(s_l.shop_name, shop.shop_identifier) as shop_name'));
        $srch->joinTable(Shop::DB_TBL, 'LEFT OUTER JOIN', 'shop_user_id = if(u.user_parent > 0, user_parent, u.user_id)', 'shop');
        $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT OUTER JOIN', 'shop.shop_id = s_l.shoplang_shop_id AND shoplang_lang_id = ' . $this->adminLangId, 's_l');
        $srch->addCondition('user_is_supplier', '=', 1);

        $post = FatApp::getPostedData();
        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('u.user_name', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('uc.credential_username', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('shop.shop_identifier', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('s_l.shop_name', 'LIKE', '%' . $post['keyword'] . '%');
        }

        $rs = $srch->getResultSet();
        $users = FatApp::getDb()->fetchAll($rs, 'user_id');

        $json = array();
        foreach ($users as $key => $user) {
            $shopName = $user['shop_name'];
            $json[] = array(
                'id' => $key,
                'name' => $shopName . ' ( ' . strip_tags(html_entity_decode($user['credential_username'], ENT_QUOTES, 'UTF-8')) . ' )'
            );
        }
        die(json_encode($json));
    }

    public function productAutoComplete()
    {
        $srch = Product::getSearchObject($this->adminLangId);

        $post = FatApp::getPostedData();
        if (!empty($post['keyword'])) {
            $srch->addCondition('product_name', 'LIKE', '%' . $post['keyword'] . '%');
        }

        $srch->setPageSize(10);
        $srch->addMultipleFields(array('product_id', 'IFNULL(product_name,product_identifier) as product_name'));
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        $products = $db->fetchAll($rs, 'product_id');
        $json = array();
        foreach ($products as $key => $product) {
            $json[] = array(
                'id' => $key,
                'name' => strip_tags(html_entity_decode($product['product_name'], ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode($json));
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);
        $isMandatory = false;
        if ($data = Commission::getAttributesById($recordId, array('commsetting_is_mandatory'))) {
            $isMandatory = $data['commsetting_is_mandatory'];
        }
        $frm = new Form('frmCommission');
        $frm->addHiddenField('', 'commsetting_id', $recordId);

        if (!$isMandatory) {
            $frm->addTextBox(Labels::getLabel('LBL_Category_Name', $this->adminLangId), 'category_name');
            $frm->addTextBox(Labels::getLabel('LBL_Seller', $this->adminLangId), 'user_name');
            $frm->addTextBox(Labels::getLabel('LBL_Product', $this->adminLangId), 'product');

            $frm->addHiddenField('', 'commsetting_user_id', 0);
            $frm->addHiddenField('', 'commsetting_product_id', 0);
            $frm->addHiddenField('', 'commsetting_prodcat_id', 0);
        }

        $fld = $frm->addFloatField(Labels::getLabel('LBL_Commission_fees_(%)', $this->adminLangId), 'commsetting_fees');
        $fld->requirements()->setRange('0', '100');
        // $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword', '');

        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        return $frm;
    }

    private function getFormColumns(): array
    {
        $commissionTblHeadingCols = CacheHelper::get('commissionTblHeadingCols' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($commissionTblHeadingCols) {
            return json_decode($commissionTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->adminLangId),
            'listSerial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'commsetting_prodcat_id' => Labels::getLabel('LBL_Category', $this->adminLangId),
            'commsetting_user_id' => Labels::getLabel('LBL_Seller', $this->adminLangId),
            'commsetting_product_id' => Labels::getLabel('LBL_Product', $this->adminLangId),
            'commsetting_fees' => Labels::getLabel('LBL_Fees_[%]', $this->adminLangId),
            'action' => Labels::getLabel('LBL_Action', $this->adminLangId),
        ];
        CacheHelper::create('commissionTblHeadingCols' . $this->adminLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'commsetting_prodcat_id',
            'commsetting_user_id',
            'commsetting_product_id',
            'commsetting_fees',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_SETTINGS', $this->adminLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => Labels::getLabel('LBL_COMMISSION', $this->adminLangId)]
                ];
        }
        return $this->nodes;
    }
}
