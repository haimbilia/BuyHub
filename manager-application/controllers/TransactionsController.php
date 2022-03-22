<?php

class TransactionsController extends ListingBaseController {

    protected $pageKey = 'TRANSACTIONS';

    public function __construct($action) {
        parent::__construct($action);
        $this->set('canViewUsers', $this->objPrivilege->canViewUsers($this->admin_id, true));
    }

    public function index() {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['searchFrmTemplate'] = 'transactions/search-form.php';

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->getListingData();

        $this->_template->addJs(array('js/select2.js', 'transactions/page-js/index.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->includeFeatherLightJsCss();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search() {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'transactions/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function shippingTransactionSearch() {
        $this->getListingData('utxn_id', 'DESC');
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function getRows() {
        $this->getListingData('utxn_id', 'DESC');
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getListingData($customSortBy = false, $customOrder = false) {
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));

        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }
        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING), applicationConstants::SORT_DESC);
        $userId = FatApp::getPostedData('utxn_user_id', FatUtility::VAR_INT, 0);
        $srchFrm = $this->getSearchForm($fields);
        $postedData = FatApp::getPostedData();
        $post = $srchFrm->getFormDataFromArray($postedData);
        $post['utxn_user_id'] = $userId;
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $balSrch = Transactions::getSearchObject();
        $balSrch->doNotCalculateRecords();
        $balSrch->doNotLimitRecords();
        $balSrch->addMultipleFields(['utxn.utxn_id', "utxn_credit - utxn_debit as bal"]);
        if (0 < $userId) {
            $balSrch->addCondition('utxn_user_id', '=', $userId);
        }
        $balSrch->addCondition('utxn_status', '=', 1);
        $srch = Transactions::getSearchObject();
        $srch->joinTable(User::DB_TBL, 'LEFT JOIN', 'u.user_id = utxn.utxn_user_id', 'u');
        $srch->joinTable(User::DB_TBL_CRED, 'LEFT JOIN', 'uc.credential_user_id = u.user_id', 'uc');
        if (0 < $userId) {
            $srch->addCondition('utxn.utxn_user_id', '=', $userId);
        }
        $srch->addGroupBy('utxn.utxn_id');
        $this->setRecordCount(clone $srch, $pageSize, $page, $post, true);
        $srch->doNotCalculateRecords();
        
        $srch->joinTable('(' . $balSrch->getQuery() . ')', 'JOIN', 'tqupb.utxn_id <= utxn.utxn_id', 'tqupb');
        $srch->addMultipleFields(array('utxn.*', "SUM(tqupb.bal) balance", 'user_name', 'user_updated_on', 'user_id', 'credential_username', 'credential_email'));
        if ($customSortBy != false && $customOrder != false) {
            $srch->addOrder($customSortBy, $customOrder);
        } else {
            $srch->addOrder($sortBy, $sortOrder);
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $this->set("arrListing", FatApp::getDb()->fetchAll($srch->getResultSet()));
        $paginationArr = empty($postedData) ? $post : $postedData;
        $this->set('postedData', $paginationArr);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('statusArr', Transactions::getStatusArr($this->siteLangId));
        $this->set('canEdit', $this->objPrivilege->canEditUsers($this->admin_id, true));
    }

    protected function getSearchForm($fields = []) {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'utxn_id', applicationConstants::SORT_DESC);
        }

        $frm->addSelectBox(Labels::getLabel('FRM_USER', $this->siteLangId), 'utxn_user_id', []);
        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    public function form() {
        $this->objPrivilege->canEditUsers();
        $userId = FatApp::getPostedData('utxn_user_id', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($userId);
        $this->set('frm', $frm);
        $this->set('includeTabs', false);
        $this->set('userId', $userId);
        $this->set('formTitle', Labels::getLabel('LBL_USER_TRANSACTIONS_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getForm($userId = 0) {
        $frm = new Form('frmUserTransaction');
        if ($userId == 0) {
            $fld = $frm->addSelectBox(Labels::getLabel('FRM_USER', $this->siteLangId), 'utxn_user_id', [29]);
            $fld->requirements()->setRequired(true);
        } else {
            $frm->addHiddenField('', 'utxn_user_id', $userId);
        }

        $typeArr = Transactions::getCreditDebitTypeArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_TYPE', $this->siteLangId), 'type', $typeArr, '', [], Labels::getLabel('FRM_Select', $this->siteLangId))->requirements()->setRequired(true);
        $frm->addRequiredField(Labels::getLabel('FRM_AMOUNT', $this->siteLangId), 'amount')->requirements()->setFloatPositive();
        $frm->addTextArea(Labels::getLabel('FRM_DESCRIPTION', $this->siteLangId), 'description')->requirements()->setRequired();
        return $frm;
    }

    public function setup() {
        $this->objPrivilege->canEditUsers();
        $frm = $this->getForm();

        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $userId = FatApp::getPostedData('utxn_user_id', FatUtility::VAR_INT, 0);
        if (1 > $userId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $userObj = new User($userId);
        $user = $userObj->getUserInfo(array('user_parent'), false, false);

        if (!$user || 0 < $user['user_parent']) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $tObj = new Transactions();
        $data = array(
            'utxn_user_id' => $userId,
            'utxn_date' => date('Y-m-d H:i:s'),
            'utxn_comments' => $post['description'],
            'utxn_status' => Transactions::STATUS_COMPLETED
        );

        if ($post['type'] == Transactions::CREDIT_TYPE) {
            $data['utxn_credit'] = $post['amount'];
        }

        if ($post['type'] == Transactions::DEBIT_TYPE) {
            $data['utxn_debit'] = $post['amount'];
        }

        if (!$tObj->addTransaction($data)) {
            LibHelper::exitWithError($tObj->getError(), true);
        }

        /* send email to user[ */
        $emailNotificationObj = new EmailHandler();
        $emailNotificationObj->sendTxnNotification($tObj->getMainTableRecordId(), $this->siteLangId);
        /* ] */

        $this->set('userId', $userId);
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getFormColumns(): array {
        $transactionsTblHeadingCols = CacheHelper::get('transactionsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($transactionsTblHeadingCols) {
            return json_decode($transactionsTblHeadingCols, true);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'utxn_id' => Labels::getLabel('LBL_Transaction_Id', $this->siteLangId),
            'user_name' => Labels::getLabel('LBL_User_Name', $this->siteLangId),
            'utxn_date' => Labels::getLabel('LBL_Date', $this->siteLangId),
            'utxn_credit' => Labels::getLabel('LBL_Credit', $this->siteLangId),
            'utxn_debit' => Labels::getLabel('LBL_Debit', $this->siteLangId),
            'balance' => Labels::getLabel('LBL_Balance', $this->siteLangId),
            'utxn_comments' => Labels::getLabel('LBL_Description', $this->siteLangId),
            'utxn_status' => Labels::getLabel('LBL_Status', $this->siteLangId),
        ];

        CacheHelper::create('transactionsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array {
        return [
            'listSerial',
            'utxn_id',
            'user_name',
            'utxn_date',
            'utxn_credit',
            'utxn_debit',
            'balance',
            'utxn_comments',
            'utxn_status',
        ];
    }

    protected function excludeKeysForSort($fields = []): array {
        return array_diff($fields, ['utxn_comments'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action) {
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_USERS', $this->siteLangId), 'href' => UrlHelper::generateUrl('Users')],
                    ['title' => $pageTitle]
                ];
        }
        return $this->nodes;
    }

    public function getDescription() {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $this->set('description', Transactions::getAttributesById($recordId, 'utxn_comments'));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

}
