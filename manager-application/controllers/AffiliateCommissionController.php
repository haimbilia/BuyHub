<?php

class AffiliateCommissionController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewAffiliateCommissionSettings();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_AFFILIATE_COMMISSION', $this->siteLangId));
        $this->getListingData();
        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'affiliate-commission/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
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
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_STRING, FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        if (!in_array($pageSize, applicationConstants::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }

        $attr = array('afcs.*', 'affiliate_cred.credential_username', 'IFNULL(prd_cat_l.prodcat_name, prod_cat.prodcat_identifier) as prodcat_name', 'afcommsetting_id as listSerial');
        $srch = AffiliateCommission::getSearchObject($this->siteLangId);
        $srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'afcs.afcommsetting_user_id = affiliate_user.user_id', 'affiliate_user');
        $srch->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'affiliate_cred.credential_user_id = affiliate_user.user_id', 'affiliate_cred');

        $srch->joinTable(ProductCategory::DB_TBL, 'LEFT OUTER JOIN', 'prod_cat.prodcat_id = afcs.afcommsetting_prodcat_id', 'prod_cat');
        $srch->joinTable(ProductCategory::DB_TBL_LANG, 'LEFT OUTER JOIN', 'prod_cat.prodcat_id = prd_cat_l.prodcatlang_prodcat_id AND prd_cat_l.prodcatlang_lang_id = ' . $this->siteLangId, 'prd_cat_l');

        $srch->addMultipleFields($attr);

        if (!empty($post['keyword'])) {
            $cond = $srch->addCondition('affiliate_cred.credential_username', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('prodcat_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
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
        $this->set('canEdit', $this->objPrivilege->canEditAffiliateCommissionSettings($this->admin_id, true));
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $data = $catArr = $userArr = [];
        if ($recordId > 0) {
            $data = AffiliateCommission::getAttributesById(
                $recordId,
                array('afcommsetting_id', 'afcommsetting_prodcat_id', 'afcommsetting_user_id', 'afcommsetting_fees')
            );
            if ($data === false) {
                FatUtility::dieWithError($this->str_invalid_request);
            }

            if ($data['afcommsetting_user_id'] > 0) {
                $userObj = new User($data['afcommsetting_user_id']);
                $userData = $userObj->getUserInfo();
                $userName = isset($userData['credential_username']) ? $userData['credential_username'] : $userData['user_name'];
                $userArr[$data['afcommsetting_user_id']] =  $userName;
            }

            if ($data['afcommsetting_prodcat_id'] > 0) {
                $prodCat = new ProductCategory();
                $selectedCatName = $prodCat->getParentTreeStructure($data['afcommsetting_prodcat_id'], 0, '', $this->siteLangId);
                $catArr[$data['afcommsetting_prodcat_id']] = html_entity_decode($selectedCatName);
            }
        }

        $frm = $this->getForm($recordId, $userArr, $catArr);
        if (!empty($data)) {
            $frm->fill($data);
        }

        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formLayout', Language::getLayoutDirection($this->siteLangId));
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditAffiliateCommissionSettings();
        $recordId = FatApp::getPostedData('afcommsetting_id', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $post['afcommsetting_prodcat_id'] = FatApp::getPostedData('afcommsetting_prodcat_id', FatUtility::VAR_INT, 0);
        $post['afcommsetting_user_id'] = FatApp::getPostedData('afcommsetting_user_id', FatUtility::VAR_INT, 0);

        $recordId = FatApp::getPostedData('afcommsetting_id', FatUtility::VAR_INT, 0);
        $isMandatory = false;
        if ($recordId > 0) {
            $data = AffiliateCommission::getAttributesById($recordId, array('afcommsetting_is_mandatory'));
            if ($data['afcommsetting_is_mandatory']) {
                $isMandatory = true;
            }
        }

        if ($isMandatory) {
            $post['afcommsetting_prodcat_id'] = 0;
            $post['afcommsetting_user_id'] = 0;
        }

        if ($post['afcommsetting_id'] == 0) {
            $srch = AffiliateCommission::getSearchObject($this->siteLangId);
            $srch->addCondition('afcs.afcommsetting_user_id', '=', $post['afcommsetting_user_id']);
            $srch->addCondition('afcs.afcommsetting_prodcat_id', '=', $post['afcommsetting_prodcat_id']);
            $rs = $srch->getResultSet();
            $records = FatApp::getDb()->fetchAll($rs);
            if ($records) {
                Message::addErrorMessage(Labels::getLabel('MSG_Record_already_exists', $this->siteLangId));
                FatUtility::dieWithError(Message::getHtml());
            }
        }
        unset($post['afcommsetting_id']);
        $affCommSetObj = new AffiliateCommission($recordId);

        $affCommSetObj->assignValues($post);
        if (!$affCommSetObj->save()) {
            Message::addErrorMessage($affCommSetObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        $recordId = $affCommSetObj->getMainTableRecordId();
        if (!$recordId) {
            $recordId = FatApp::getDb()->getInsertId();
        }

        if (!$affCommSetObj->addAffiliateCommissionHistory($recordId)) {
            Message::addErrorMessage($affCommSetObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $this->set('msg', $this->str_update_record);
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function rowsData()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $srch = AffiliateCommission::getAffiliateCommissionHistoryObj($this->siteLangId);
        $srch->addCondition('tacsh.acsh_afcommsetting_id', '=', $recordId);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', FatApp::getPostedData());
    }

    public function viewLog()
    {
        $this->rowsData();
        $this->_template->render(false, false);
    }

    public function getRows()
    {
        $this->rowsData();
        $this->_template->render(false, false);
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditAffiliateCommissionSettings();

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
        $this->objPrivilege->canEditAffiliateCommissionSettings();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('afcommsetting_ids'));

        if (empty($recordIdsArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
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
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $row = AffiliateCommission::getAttributesById($recordId, array('afcommsetting_id', 'afcommsetting_is_mandatory'));
        if ($row == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        if ($row['afcommsetting_is_mandatory']) {
            LibHelper::exitWithError(Labels::getLabel("LBL_Default_record_cannot_be_deleted", $this->siteLangId), true);
        }
        FatApp::getDb()->deleteRecords(AffiliateCommission::DB_TBL, array('smt' => 'afcommsetting_id = ?', 'vals' => array($recordId)));
    }

    private function getForm($recordId = 0, $userArr = [], $catArr = [])
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmAffiliateCommission');
        $frm->addHiddenField('', 'afcommsetting_id', $recordId);
        $isMandatory = false;
        if ($recordId > 0) {
            $data = AffiliateCommission::getAttributesById($recordId, array('afcommsetting_is_mandatory'));
            $isMandatory = $data['afcommsetting_is_mandatory'];
        }

        if (!$isMandatory) {
            $frm->addSelectBox(Labels::getLabel('LBL_Category_Name', $this->siteLangId), 'afcommsetting_prodcat_id', $catArr, '', [], '');
            $frm->addSelectBox(Labels::getLabel('LBL_Affiliate_Name', $this->siteLangId), 'afcommsetting_user_id', $userArr, '', [], '');
        }

        $frm->addFloatField(Labels::getLabel('LBL_Affiliate_Commission_fees', $this->siteLangId), 'afcommsetting_fees');
        return $frm;
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_CONFIGURATION_&_MANAGEMENT', $this->siteLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => Labels::getLabel('LBL_AFFILIATE_COMMISSION', $this->siteLangId)]
                ];
        }
        return $this->nodes;
    }

    private function getFormColumns(): array
    {
        $affCommissionTblHeadingCols = CacheHelper::get('affCommissionTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($affCommissionTblHeadingCols) {
            return json_decode($affCommissionTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'afcommsetting_prodcat_id' => Labels::getLabel('LBL_Category', $this->siteLangId),
            'afcommsetting_user_id' => Labels::getLabel('LBL_Affiliate_User', $this->siteLangId),
            'afcommsetting_fees' => Labels::getLabel('LBL_Fees_[%]', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('affCommissionTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'afcommsetting_prodcat_id',
            'afcommsetting_user_id',
            'afcommsetting_fees',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
