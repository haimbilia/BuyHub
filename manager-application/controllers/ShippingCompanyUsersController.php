<?php

class ShippingCompanyUsersController extends ListingBaseController {

    protected $modelClass = 'User';
    protected $pageKey = 'MANAGE_SHIPPING_COMPANY_USERS';

    public function __construct($action) {
        parent::__construct($action);
        $this->objPrivilege->canViewShippingCompanyUsers();
    }

    public function index() {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $actionItemsData = array_merge(HtmlHelper::getDefaultActionItems($fields, $this->modelObj));
        $this->set('actionItemsData', $actionItemsData);
        $this->set('canEdit', $this->objPrivilege->canEditShippingCompanyUsers($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->_template->addJs('shipping-company-users/page-js/index.js');
        $this->getListingData();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search() {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'shipping-company-users/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData() {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $data = FatApp::getPostedData();
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $searchForm = $this->getSearchForm($fields);

        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $userObj = new User();
        $srch = $userObj->getUserSearchObj();
        $srch->addOrder('u.user_id', 'DESC');
        $srch->addCondition('u.user_is_shipping_company', '=', applicationConstants::YES);

        $keyword = FatApp::getPostedData('keyword', null, '');
        if (!empty($keyword)) {
            $srch->addCondition('u.user_name', 'LIKE', '%' . $post['keyword'] . '%')
                    ->attachCondition('uc.credential_username', 'LIKE', '%' . $post['keyword'] . '%');
        }
        $srch->addOrder($sortBy, $sortOrder);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditBrands($this->admin_id, true));
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void {
        $this->objPrivilege->canEditShippingCompanyUsers();
        $this->setModel($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->set('formTitle', Labels::getLabel('LBL_SHIPPING_COMPANY_USER_SETUP', $this->siteLangId));
        $this->checkMediaExist = true;
    }

    public function form() {
        $this->objPrivilege->canEditShippingCompanyUsers();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getUserForm($recordId, User::USER_TYPE_SHIPPING_COMPANY);
        $fldCredentialUserName = $frm->getField('credential_username');
        $fldCredentialUserName->requirements()->setRequired(true);
        $fldCredentialUserName->setUnique('tbl_user_credentials', 'credential_username', 'credential_user_id', 'user_id', 'user_id');

        $fldCredentialEmail = $frm->getField('credential_email');
        $fldCredentialEmail->requirements()->setRequired(true);
        $fldCredentialEmail->setUnique('tbl_user_credentials', 'credential_email', 'credential_user_id', 'user_id', 'user_id');

        $fldUserType = $frm->getField('user_type');
        $fldUserType->value = User::USER_TYPE_SHIPPING_COMPANY;

        if (0 < $recordId) {
            $userObj = new User($recordId);
            $srch = $userObj->getUserSearchObj();
            $srch->addMultipleFields(array('u.*'));
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $rs = $srch->getResultSet();
            $data = FatApp::getDb()->fetch($rs, 'user_id');
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $stateId = $data['user_state_id'];
            $frm->fill($data);
        }
        $this->set('languages', []);
        $this->set('stateId', $stateId);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup() {
        $this->objPrivilege->canEditShippingCompanyUsers();
        $frm = $this->getUserForm(0, User::USER_TYPE_SHIPPING_COMPANY);

        $post = FatApp::getPostedData();
        $post = $frm->getFormDataFromArray($post);
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $post['user_is_shipping_company'] = 1;
        $post['user_is_supplier'] = 0;
        $post['user_is_buyer'] = 0;
        $post['user_is_advertiser'] = 0;
        $post['user_is_affiliate'] = 0;
        $post['user_preferred_dashboard'] = 1;
        $post['user_state_id'] = FatApp::getPostedData('user_state_id', FatUtility::VAR_INT, 0);
        $user_id = FatApp::getPostedData('user_id', FatUtility::VAR_INT, 0);
        $userObj = new User($user_id);
        $userObj->assignValues($post);
        if (!$userObj->save()) {
            LibHelper::exitWithError($userObj->getError(), true);
        }

        $user_id = $userObj->getMainTableRecordId();
        if ($post['user_id'] <= 0) {
            $post['user_password'] = CommonHelper::getRandomPassword(10);
            if (!$userObj->setLoginCredentials($post['credential_username'], $post['credential_email'], $post['user_password'], 1, 1)) {
                LibHelper::exitWithError(Labels::getLabel("MSG_LOGIN_CREDENTIALS_COULD_NOT_BE_SET", $this->adminLangId), true);
            }
        }
        $this->set('msg', Labels::getLabel("SUC_SETUP_SUCCESSFUL", $this->siteLangId));
        $this->set('userId', $user_id);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function getSearchForm($fields = []) {
        $frm = new Form('frmRecordSearch');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', array('class' => 'search-input'));
        $fld->overrideFldType('search');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'brand_requested_on');
        }
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    private function getFormColumns(): array {
        $shopsTblHeadingCols = CacheHelper::get('shippingUserTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($shopsTblHeadingCols) {
            return json_decode($shopsTblHeadingCols);
        }
        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'credential_username' => Labels::getLabel('LBL_USERNAME', $this->siteLangId),
            'user_name' => Labels::getLabel('LBL_NAME', $this->siteLangId),
            'credential_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => '',
        ];
        CacheHelper::create('shippingUserTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array {
        return [
            'select_all',
            'listSerial',
            'credential_username',
            'user_name',
            'credential_active',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array {
        return array_diff($fields, ['brand_logo', 'brand_name', 'sbrandreq_status'], Common::excludeKeysForSort());
    }

}
