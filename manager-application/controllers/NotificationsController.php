<?php

class NotificationsController extends ListingBaseController
{
    protected string $modelClass = 'Notification';
    protected $pageKey = 'MANAGE_NOTIFICATION';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewNotifications();
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void
    {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditNotifications($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditNotifications();
        }
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['newRecordBtn'] = false;
        $actionItemsData['performBulkAction'] = true;


        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->checkEditPrivilege(true);
        $this->getListingData();
        $this->_template->addJs(array('js/select2.js', 'notifications/page-js/index.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_NAME', $this->siteLangId));
        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, NUll, true),
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
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'notification_added_on');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'notification_added_on';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC));

        $searchForm = $this->getSearchForm($fields);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());
        $srch = Notification::getSearchObject();
        if (!AdminPrivilege::isAdminSuperAdmin($this->admin_id)) {
            $recordTypeArr = Notification::getAllowedRecordTypeArr($this->admin_id);
            $srch->addCondition('notification_record_type', 'IN', $recordTypeArr);
        }

        $srch->addCondition('n.' . Notification::DB_TBL_PREFIX . 'deleted', '=', applicationConstants::NO);

        if (0 < $post['label_key']) {
            $srch->addCondition('notification_label_key', '=', $post['label_key']);
        }

        $userId = FatApp::getPostedData('user_id', FatUtility::VAR_INT, 0);
        if (0 < $userId) {
            $srch->addCondition('notification_user_id', '=', $userId);
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
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
        $this->set('labelArr', Notification::getLabelKeyString($this->siteLangId));
        $this->checkEditPrivilege(true);
    }

    public function toggleBulkStatuses()
    {
        $this->checkEditPrivilege();
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordsArr = FatUtility::int(FatApp::getPostedData('record_ids'));
        if (empty($recordsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new Notification();
        if (!$obj->changeNotifyStatus($status, $recordsArr)) {
            LibHelper::exitWithError($obj->getError(), true);
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function notificationList()
    {
        $notifyObject = Notification::getSearchObject();
        if (!AdminPrivilege::isAdminSuperAdmin($this->admin_id)) {
            $recordTypeArr = Notification::getAllowedRecordTypeArr($this->admin_id);
            $notifyObject->addCondition('notification_record_type', 'IN', $recordTypeArr);
        }
        $notifyObject->addCondition('n.' . Notification::DB_TBL_PREFIX . 'deleted', '=', applicationConstants::NO);
        $notifyObject->addCondition('n.' . Notification::DB_TBL_PREFIX . 'marked_read', '=', applicationConstants::NO);
        $notifyObject->addMultipleFields(array('count(notification_id) as countOfRec'));
        $notifyObject->doNotCalculateRecords();
        $notifyObject->setPageSize(1);
        $notifyCountResult = FatApp::getDb()->fetch($notifyObject->getResultset());
        $notifyCount = FatUtility::int($notifyCountResult['countOfRec']);
        $this->set('notifyCount', CommonHelper::displayBadgeCount($notifyCount));

        $srch = Notification::getSearchObject();
        if (!AdminPrivilege::isAdminSuperAdmin($this->admin_id)) {
            $recordTypeArr = Notification::getAllowedRecordTypeArr($this->admin_id);
            $srch->addCondition('notification_record_type', 'IN', $recordTypeArr);
        }

        $srch->addOrder('n.notification_added_on', 'DESC');
        $srch->addCondition('n.notification_deleted', '=', applicationConstants::NO);
        $srch->addCondition('n.notification_marked_read', '=', applicationConstants::NO);

        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set('labelArr', Notification::getLabelKeyString($this->siteLangId));
        $this->set('arrListing', $records);

        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    protected function getSearchForm(array $fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $frm->addHiddenField('', 'page');
        $frm->addSelectBox(Labels::getLabel('FRM_USER_NAME', $this->siteLangId), 'user_id', []);
        $typeArr  = [];
        foreach (Notification::getLabelKeyString($this->siteLangId) as $key => $arr) {
            $typeArr[$key] = $arr[0];
        }

        $frm->addSelectBox(Labels::getLabel('FRM_NOTIFICATION_TYPE', $this->siteLangId), 'label_key', $typeArr);
        if (!empty($fields)) {
            $this->addSortingElements($frm, current($allowedKeysForSorting));
        }

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('notificationTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'notification' => Labels::getLabel('LBL_NOTIFICATION', $this->siteLangId),
            'notification_added_on' => Labels::getLabel('LBL_CREATED_ON', $this->siteLangId),
        ];
        CacheHelper::create('notificationTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'notification',
            'notification_added_on',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['notification'], Common::excludeKeysForSort());
    }
}
