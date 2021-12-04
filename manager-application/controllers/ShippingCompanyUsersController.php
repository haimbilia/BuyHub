<?php

class ShippingCompanyUsersController extends ListingBaseController {

    protected string $modelClass = 'User';
    protected $pageKey = 'SHIPPING_COMPANY_USERS';

    public function __construct($action) {
        parent::__construct($action);
        $this->objPrivilege->canViewShippingCompanyUsers();
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditShippingCompanyUsers($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditShippingCompanyUsers();
        }
    }

    public function index() {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $actionItemsData = array_merge(HtmlHelper::getDefaultActionItems($fields, $this->modelObj), ['statusButtons' => true, 'performBulkAction' => true]);
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
        $this->set('includeTabs', false);
        $this->set('languages', []);
        $this->set('stateId', $stateId ?? 0);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup() {
        $this->objPrivilege->canEditShippingCompanyUsers();
        $frm = $this->getUserForm(0, User::USER_TYPE_SHIPPING_COMPANY);

        $post = FatApp::getPostedData();
        $post = $frm->getFormDataFromArray($post, ['user_state_id']);
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
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
        FatApp::getDB()->startTransaction();
        if (!$userObj->save()) {
            FatApp::getDB()->rollbackTransaction();
            LibHelper::exitWithError($userObj->getError(), true);
        }

        $user_id = $userObj->getMainTableRecordId();
        if ($post['user_id'] <= 0) {
            $post['user_password'] = CommonHelper::getRandomPassword(10);
            if (!$userObj->setLoginCredentials($post['credential_username'], $post['credential_email'], $post['user_password'], 1, 1)) {
                FatApp::getDB()->rollbackTransaction();
                LibHelper::exitWithError(Labels::getLabel("ERR_LOGIN_CREDENTIALS_COULD_NOT_BE_SET", $this->siteLangId), true);
            }
        }
        FatApp::getDB()->commitTransaction();
        $this->set('msg', Labels::getLabel("SUC_SETUP_SUCCESSFUL", $this->siteLangId));
        $this->set('userId', $user_id);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateStatus() {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 == $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (!in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $this->updateUserStatus($recordId, $status);
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkStatuses() {
        $this->checkEditPrivilege();
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordsArr = FatUtility::int(FatApp::getPostedData('record_ids'));
        if (empty($recordsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordsArr as $userId) {
            if (1 > $userId) {
                continue;
            }
            $this->updateUserStatus($userId, $status);
        }
        Product::updateMinPrices();
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateUserStatus($userId, $status) {
        $status = FatUtility::int($status);
        $userId = FatUtility::int($userId);
        if (1 > $userId || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $userObj = new User($userId);
        if (!$userObj->activateAccount($status)) {
            LibHelper::exitWithError($userObj->getError(), true);
        }
    }

    protected function getUserForm($user_id = 0, $userType = 0) {
        $user_id = FatUtility::int($user_id);
        $userType = FatUtility::int($userType);

        $frm = new Form('frmUser', array('id' => 'frmUser'));
        $frm->addHiddenField('', 'user_id', $user_id);
        $frm->addHiddenField('', 'user_type');
        $frm->addTextBox(Labels::getLabel('LBL_Username', $this->siteLangId), 'credential_username', '');
        $frm->addRequiredField(Labels::getLabel('LBL_Customer_name', $this->siteLangId), 'user_name');
        $frm->addDateField(Labels::getLabel('LBL_Date_of_birth', $this->siteLangId), 'user_dob', '', array('readonly' => 'readonly', 'class' => 'field--calender'));
        $frm->addHiddenField('', 'user_phone_dcode');
        $phnFld = $frm->addTextBox(Labels::getLabel('LBL_Phone', $this->siteLangId), 'user_phone', '', array('class' => 'phoneJs ltr-right', 'placeholder' => ValidateElement::PHONE_NO_FORMAT, 'maxlength' => ValidateElement::PHONE_NO_LENGTH));
        $phnFld->requirements()->setRegularExpressionToValidate(ValidateElement::PHONE_REGEX);
        $frm->addEmailField(Labels::getLabel('LBL_Email', $this->siteLangId), 'credential_email', '');

        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesAssocArr($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_Country', $this->siteLangId), 'user_country_id', $countriesArr, FatApp::getConfig('CONF_COUNTRY', FatUtility::VAR_INT, 223), array(), Labels::getLabel('LBL_Select', $this->siteLangId));
        $fld->requirement->setRequired(true);

        $frm->addSelectBox(Labels::getLabel('LBL_State', $this->siteLangId), 'user_state_id', array(), '', [], Labels::getLabel('LBL_Select', $this->siteLangId))->requirement->setRequired(true);
        $frm->addTextBox(Labels::getLabel('LBL_City', $this->siteLangId), 'user_city');

        switch ($userType) {
            case User::USER_TYPE_SHIPPING_COMPANY:
                $frm->addTextBox(Labels::getLabel('LBL_Tracking_Site_Url', $this->siteLangId), 'user_order_tracking_url');
                break;
        }
        return $frm;
    }

    public function getSearchForm($fields = []) {
        $frm = new Form('frmRecordSearch');
        $frm->setFormTagAttribute('class', 'actionButtonsJs');
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
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
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
        return array_diff($fields, ['credential_username'], Common::excludeKeysForSort());
    }

}
