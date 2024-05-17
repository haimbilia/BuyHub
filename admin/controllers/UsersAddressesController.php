<?php

class UsersAddressesController extends ListingBaseController
{
    protected $pageKey = 'USER_ADDRESSES';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
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
        $actionItemsData['searchFrmTemplate'] = 'users-addresses/search-form.php';

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->getListingData();

        $this->_template->addJs(array('js/select2.js', 'users-addresses/page-js/index.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->includeFeatherLightJsCss();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'users-addresses/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
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

        $userId = FatApp::getPostedData('addr_record_id', FatUtility::VAR_INT, 0);
        $srchFrm = $this->getSearchForm($fields);

        $postedData = FatApp::getPostedData();
        $post = $srchFrm->getFormDataFromArray($postedData);
        $post['addr_record_id'] = $userId;

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = new AddressSearch($this->siteLangId);
        $srch->joinUser();
        $srch->joinCountry();
        $srch->joinState();        
        $srch->addCondition('country_active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
        $srch->addCondition('state_active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
        $srch->addCondition('user_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $srch->addCondition(Address::tblFld('type'), '=', 'mysql_func_' . Address::TYPE_USER, 'AND', true);

        if (0 < $userId) {
            $srch->addCondition(Address::tblFld('record_id'), '=', 'mysql_func_' . $userId, 'AND', true);
        }

        $title = FatApp::getPostedData('addr_title', FatUtility::VAR_STRING, '');
        if (!empty($title)) {
            $srch->addCondition(Address::tblFld('title'), 'LIKE', '%' . $title . '%');
        }

        $srch->addMultipleFields(array('addr.*', 'state_code', 'country_code', 'country_code_alpha3', 'IFNULL(country_name, country_code) as country_name', 'IFNULL(state_name, state_identifier) as state_name', 'user_name', 'user_updated_on', 'user_id', 'credential_username', 'credential_email'));

        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

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
        $this->set('canEdit', $this->objPrivilege->canEditUsers($this->admin_id, true));
        $this->set('canVerify', $this->objPrivilege->canVerifyUsers($this->admin_id, true));
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $userId = FatApp::getPostedData('addr_record_id', FatUtility::VAR_INT, 0);

        $frm = $this->getForm($userId);
        $stateId = 0;
        if ($recordId > 0) {
            $address =  new Address($recordId, $this->siteLangId);
            $data = $address->getData(Address::TYPE_USER, $userId);
            if (empty($data)) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $stateId = $data['addr_state_id'];
            $frm->fill($data);
        }

        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('stateId', $stateId);
        $this->set('user_id', $userId);
        $this->set('includeTabs', false);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $stateId = FatApp::getPostedData('addr_state_id', FatUtility::VAR_INT, 0);
        $addr_id = FatApp::getPostedData('addr_id', FatUtility::VAR_INT, 0);
        $user_id = FatApp::getPostedData('addr_record_id', FatUtility::VAR_INT, 0);

        if (1 > $user_id) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $userObj = new User($user_id);
        $srch = $userObj->getUserSearchObj(array('user_parent'));
        $rs = $srch->getResultSet();
        $data = FatApp::getDb()->fetch($rs, 'user_id');

        if ($data === false || 0 < $data['user_parent']) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $addressObj = new Address($addr_id);

        $data_to_be_save = $post;
        $data_to_be_save['addr_record_id'] = $user_id;
        $data_to_be_save['addr_state_id'] = $stateId;
        $data_to_be_save['addr_type'] = Address::TYPE_USER;
        $data_to_be_save['addr_lang_id'] = $this->siteLangId;
        $addressObj->assignValues($data_to_be_save, true);
        if (!$addressObj->save()) {
            LibHelper::exitWithError($addressObj->getError(), true);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditUsers();

        $post = FatApp::getPostedData();
        if ($post == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $data = Address::getAttributesById($recordId);
        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }


    public function deleteSelected()
    {
        $this->objPrivilege->canEditAbusiveWords();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('addr_ids'));

        if (empty($recordIdsArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            $data = Address::getAttributesById($recordId);
            if (1 > $recordId || false === $data) {
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

        $address = new Address($recordId, $this->siteLangId);
        if (!$address->deleteRecord()) {
            LibHelper::exitWithError($address->getError(), true);
        }
    }

    private function getForm(int $userId = 0)
    {
        $frm = new Form('frmAddress');
        $frm->addHiddenField('', 'addr_id');
        if (0 < $userId) {
            $frm->addHiddenField('', 'addr_record_id', $userId);
        } else {
            $fld = $frm->addSelectBox(Labels::getLabel('FRM_USER', $this->siteLangId), 'addr_record_id', []);
            $fld->requirements()->setRequired(true);
        }

        $fld = $frm->addTextBox(Labels::getLabel('FRM_ADDRESS_TITLE', $this->siteLangId), 'addr_title');
        $fld->setFieldTagAttribute('placeholder', Labels::getLabel('FRM_E.g:_My_Office_Address', $this->siteLangId));

        $frm->addRequiredField(Labels::getLabel('FRM_CONTACT_PERSON_NAME', $this->siteLangId), 'addr_name');
        $phnFld = $frm->addTextBox(Labels::getLabel('FRM_PHONE', $this->siteLangId), 'addr_phone', '', array('class' => 'phoneJs ltr-right', 'placeholder' => ValidateElement::PHONE_NO_FORMAT, 'maxlength' => ValidateElement::PHONE_NO_LENGTH));
        $phnFld->requirements()->setRegularExpressionToValidate(ValidateElement::PHONE_REGEX);
        $phnFld->requirements()->setCustomErrorMessage(Labels::getLabel('FRM_PLEASE_ENTER_VALID_PHONE_NUMBER.', $this->siteLangId));

        $frm->addRequiredField(Labels::getLabel('FRM_ADDRESS_LINE1', $this->siteLangId), 'addr_address1');
        $frm->addTextBox(Labels::getLabel('FRM_ADDRESS_LINE2', $this->siteLangId), 'addr_address2');

        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesAssocArr($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_COUNTRY', $this->siteLangId), 'addr_country_id', $countriesArr, FatApp::getConfig('CONF_COUNTRY'), [], Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $fld->requirement->setRequired(true);

        $frm->addSelectBox(Labels::getLabel('FRM_STATE', $this->siteLangId), 'addr_state_id', array(), '', [], Labels::getLabel('FRM_SELECT', $this->siteLangId))->requirement->setRequired(true);
        $frm->addRequiredField(Labels::getLabel('FRM_CITY', $this->siteLangId), 'addr_city');
        $frm->addTextBox(Labels::getLabel('FRM_POSTAL_CODE', $this->siteLangId), 'addr_zip');
        $frm->addHiddenField('', 'addr_phone_dcode');


        return $frm;
    }

    protected function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'user_name');
        }

        $frm->addSelectBox(Labels::getLabel('FRM_USER_NAME', $this->siteLangId), 'addr_record_id', []);
        $frm->addTextBox(Labels::getLabel('FRM_ADDRESS_LABEL', $this->siteLangId), 'addr_title');


        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $usersAddressesTblHeadingCols = CacheHelper::get('usersAddressesTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($usersAddressesTblHeadingCols) {
            return json_decode($usersAddressesTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'user_name' => Labels::getLabel('LBL_User_Name', $this->siteLangId),
            'addr_title' => Labels::getLabel('LBL_ADDRESS_TITLE', $this->siteLangId),
            'user_address' => Labels::getLabel('LBL_Address', $this->siteLangId),
            'addr_phone' => Labels::getLabel('LBL_Phone', $this->siteLangId),
            'addr_is_default' => Labels::getLabel('LBL_Default', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];

        CacheHelper::create('usersAddressesTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /*  'listSerial', */
            'user_name',
            'addr_title',
            'user_address',
            'addr_phone',
            'addr_is_default',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['user_address', 'addr_phone'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_USERS', $this->siteLangId), 'href' => UrlHelper::generateUrl('Users')],
                    ['title' => Labels::getLabel('LBL_USERS_ADDRESSES', $this->siteLangId)]
                ];
                break;
            default:
                parent::getBreadcrumbNodes($action);
                break;
        }
        return $this->nodes;
    }
}
