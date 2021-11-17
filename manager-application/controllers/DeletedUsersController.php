<?php

class DeletedUsersController extends ListingBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewUsers();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey('MANAGE_DELETED_USERS', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtn'] = false;
        $actionItemsData['searchFrmTemplate'] = 'deleted-users/search-form.php';

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->getListingData();

        $this->_template->addJs(array('js/select2.js', 'deleted-users/page-js/index.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'deleted-users/search.php', true),
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

        $userId = FatApp::getPostedData('user_id', FatUtility::VAR_INT, 0);
        $srchFrm = $this->getSearchForm($fields);
        
        $postedData = FatApp::getPostedData();
        $post = $srchFrm->getFormDataFromArray($postedData);
        $post['user_id'] = $userId;

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $userObj = new User();
        $srch = $userObj->getUserSearchObj(null, true, false);
        $srch->addCondition('user_deleted', '=', applicationConstants::YES);

        if (0 < $userId) {
            $srch->addCondition('user_id', '=', $userId);
        }

        $type = FatApp::getPostedData('type', FatUtility::VAR_STRING, 0);

        switch ($type) {
            case User::USER_TYPE_SELLER:
                $srch->addCondition('u.user_is_supplier', '=', applicationConstants::YES);
                break;
            case User::USER_TYPE_BUYER:
                $srch->addCondition('u.user_is_buyer', '=', applicationConstants::YES);
                break;
            case User::USER_TYPE_ADVERTISER:
                $srch->addCondition('u.user_is_advertiser', '=', applicationConstants::YES);
                break;
            case User::USER_TYPE_AFFILIATE:
                $srch->addCondition('u.user_is_affiliate', '=', applicationConstants::YES);
                break;
            case User::USER_TYPE_BUYER_SELLER:
                $srch->addCondition('u.user_is_supplier', '=', applicationConstants::YES);
                $srch->addCondition('u.user_is_buyer', '=', applicationConstants::YES);
                break;
        }

        $srch->addCondition('u.user_is_shipping_company', '=', applicationConstants::NO);

        $user_regdate_from = FatApp::getPostedData('user_regdate_from', FatUtility::VAR_DATE, '');
        if (!empty($user_regdate_from)) {
            $srch->addCondition('user_regdate', '>=', $user_regdate_from . ' 00:00:00');
        }

        $user_regdate_to = FatApp::getPostedData('user_regdate_to', FatUtility::VAR_DATE, '');
        if (!empty($user_regdate_to)) {
            $srch->addCondition('user_regdate', '<=', $user_regdate_to . ' 23:59:59');
        }

        $srch->addMultipleFields(array('user_is_buyer', 'user_is_supplier', 'user_is_advertiser', 'user_is_affiliate', 'user_registered_initially_for', 'user_updated_on'));

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

    public function restore()
    {
        $this->objPrivilege->canEditUsers();
        $post = FatApp::getPostedData();
        if ($post == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $user_id = FatUtility::int($post['user_id']);
        if (1 > $user_id) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $userObj = new User($user_id);
        $userObj->assignValues(array('user_deleted' => applicationConstants::NO));
        if (!$userObj->save()) {
            LibHelper::exitWithError($userObj->getError(), true);
        }
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'user_id');
        }

        $frm->addSelectBox(Labels::getLabel('FRM_USER_NAME', $this->siteLangId), 'user_id', []);

        $frm->addDateField(Labels::getLabel('FRM_REG._DATE_FROM', $this->siteLangId), 'user_regdate_from', '', array('readonly' => 'readonly'));
        $frm->addDateField(Labels::getLabel('FRM_REG._DATE_TO', $this->siteLangId), 'user_regdate_to', '', array('readonly' => 'readonly'));

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm, 'btn btn-outline-brand');
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $deletedUsersTblHeadingCols = CacheHelper::get('deletedUsersTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($deletedUsersTblHeadingCols) {
            return json_decode($deletedUsersTblHeadingCols);
        }

        $arr = [
            'user_id' => Labels::getLabel('LBL_User_Id', $this->siteLangId),
            'user_name' => Labels::getLabel('LBL_User_Name', $this->siteLangId),
            'user_is_buyer' => Labels::getLabel('LBL_Buyer', $this->siteLangId),
            'user_is_supplier' => Labels::getLabel('LBL_Seller', $this->siteLangId),
            'user_is_advertiser' => Labels::getLabel('LBL_Advertiser', $this->siteLangId),
            'user_is_affiliate' => Labels::getLabel('LBL_Affiliate', $this->siteLangId),
            'user_regdate' => Labels::getLabel('LBL_Reg._Date', $this->siteLangId),
            'credential_verified' => Labels::getLabel('LBL_verified', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];

        CacheHelper::create('deletedUsersTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'user_id',
            'user_name',
            'user_is_buyer',
            'user_is_supplier',
            'user_is_advertiser',
            'user_is_affiliate',
            'user_regdate',
            'credential_verified',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['type'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_USERS', $this->siteLangId), 'href' => UrlHelper::generateUrl('Users')],
                    ['title' => Labels::getLabel('LBL_DELETED_USERS', $this->siteLangId)]
                ];
        }
        return $this->nodes;
    }
}
