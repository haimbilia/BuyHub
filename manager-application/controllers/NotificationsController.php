<?php

class NotificationsController extends ListingBaseController
{
    protected string $modelClass = 'Notification';
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewNotifications();
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
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
        $frmSearch = $this->getSearchForm();       
        $this->set("frmSearch", $frmSearch);
        $this->getListingData();
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

        $data = FatApp::getPostedData();

        $searchForm = $this->getSearchForm();

        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = Notification::getSearchObject();
        if (!AdminPrivilege::isAdminSuperAdmin($this->admin_id)) {
            $recordTypeArr = Notification::getAllowedRecordTypeArr($this->admin_id);
            $srch->addCondition('notification_record_type', 'IN', $recordTypeArr);
        }

        $srch->addCondition('n.' . Notification::DB_TBL_PREFIX . 'deleted', '=', applicationConstants::NO);

        // if (!empty($post['keyword'])) {
        //     $condition = $srch->addCondition('b.brand_identifier', 'like', '%' . $post['keyword'] . '%');
        //     $condition->attachCondition('b_l.brand_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        // }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        //echo $srch->getQuery();

        $srch->addOrder('n.notification_added_on', 'DESC');
  
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
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
        $srch = Notification::getSearchObject();

        if (!AdminPrivilege::isAdminSuperAdmin($this->admin_id)) {
            $recordTypeArr = Notification::getAllowedRecordTypeArr($this->admin_id);
            $srch->addCondition('notification_record_type', 'IN', $recordTypeArr);
        }

        $srch->addOrder('n.notification_added_on', 'DESC');
        $srch->addCondition('n.notification_deleted', '=', applicationConstants::NO);
        $srch->addCondition('n.notification_marked_read', '=', applicationConstants::NO);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set('labelArr', Notification::getLabelKeyString($this->siteLangId));
        $this->set('arrListing', $records);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    protected function getSearchForm(array $fields = [])
    {   
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');
        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

}
