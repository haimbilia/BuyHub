<?php

class RewardsController extends AdminBaseController
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

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('languages', Language::getAllNames());
        $this->set('pageTitle', Labels::getLabel('LBL_Manage_User_Reward_Points', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'rewards/search.php', true),
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
        
        $userId = FatApp::getPostedData('urp_user_id', FatUtility::VAR_INT, 0);
        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $post['urp_user_id'] = $userId;

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = new UserRewardSearch();
        $srch->joinUser();
        $srch->addMultipleFields(['urp.*', 'user_name', 'urp.urp_id as listSerial', 'user_updated_on', 'user_id', 'credential_username', 'credential_email']);

        if (0 < $userId) {
            $srch->addCondition('urp.urp_user_id', '=', $userId);
        }

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
        $this->set('postedData', $post);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditUsers($this->admin_id, true));
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }

        $frm->addSelectBox(Labels::getLabel('FRM_USER', $this->siteLangId), 'urp_user_id', []);

        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    public function form()
    {
        $this->objPrivilege->canEditUsers();
        $frm = $this->getForm();
        $this->set('frm', $frm);
        $this->set('includeTabs', false);
        $this->set('formTitle', Labels::getLabel('LBL_USER_REWARDS_POINT_SETUP', $this->siteLangId));
        $this->_template->render(false, false);
    }

    private function getForm()
    {
        $frm = new Form('frmUserRewardPoints');
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_USER', $this->siteLangId), 'urp_user_id', []);
        $fld->requirements()->setRequired(true);
        $frm->addRequiredField(Labels::getLabel('FRM_POINTS', $this->siteLangId), 'urp_points')->requirements()->setIntPositive();
        $fld = $frm->addTextBox(Labels::getLabel('FRM_VALIDITY_IN_DAYS', $this->siteLangId), 'validity');
        $fld->requirements()->setIntPositive();
        $frm->addTextArea(Labels::getLabel('FRM_COMMENTS', $this->siteLangId), 'urp_comments')->requirements()->setRequired();
        $fld->htmlAfterField = '<span class="form-text text-muted">' . Labels::getLabel('FRM_LEAVE_THIS_FIELD_EMPTY_EVER_VALID_REWARD_POINTS.', $this->siteLangId) . '</span>';
        return $frm;
    }

    public function setup()
    {
        $this->objPrivilege->canEditUsers();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $userId = FatApp::getPostedData('urp_user_id', FatUtility::VAR_INT, 0);
        if (1 > $userId) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_USER', $this->siteLangId), true);
        }

        $userObj = new User($userId);
        $user = $userObj->getUserInfo(array('user_parent'), false, false);
        if (!$user || 0 < $user['user_parent']) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new UserRewards();
        $post['urp_date_added'] = date('Y-m-d H:i:s');
        if (!empty($post['validity']) && $validity = FatUtility::int($post['validity'])) {
            $post['urp_date_expiry'] = date('Y-m-d H:i:s', strtotime("+$validity days"));
        }

        $post['urp_user_id'] = $userId;
        $obj->assignValues($post);
        if (!$obj->save($post)) {
            LibHelper::exitWithError($obj->getError(), true);
        }

        /* send email to user[ */
        $urpId = $obj->getMainTableRecordId();
        $emailObj = new EmailHandler();
        $emailObj->sendRewardPointsNotification($this->siteLangId, $urpId);
        /* ] */

        $this->set('userId', $userId);
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getFormColumns(): array
    {
        $rewardsTblHeadingCols = CacheHelper::get('rewardsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($rewardsTblHeadingCols) {
            return json_decode($rewardsTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'user_name' => Labels::getLabel('LBL_User_Name', $this->siteLangId),
            'urp_date_added' => Labels::getLabel('LBL_Valid_from', $this->siteLangId),
            'urp_date_expiry' => Labels::getLabel('LBL_Valid_till', $this->siteLangId),
            'urp_points' => Labels::getLabel('LBL_Points', $this->siteLangId),
            'urp_comments' => Labels::getLabel('LBL_Comments', $this->siteLangId),
        ];

        CacheHelper::create('rewardsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'listSerial',
            'user_name',
            'urp_date_added',
            'urp_date_expiry',
            'urp_points',
            'urp_comments',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['urp_comments'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_USERS', $this->siteLangId), 'href' => UrlHelper::generateUrl('Users')],
                    ['title' => Labels::getLabel('LBL_REWARDS', $this->siteLangId)]
                ];
        }
        return $this->nodes;
    }
}
