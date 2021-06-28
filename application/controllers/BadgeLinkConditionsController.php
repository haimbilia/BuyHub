<?php

class BadgeLinkConditionsController extends SellerBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);

        $this->userPrivilege->canViewBadgeLinks(UserAuthentication::getLoggedUserId());
    }
    
    public function index()
    {
        $frmSearch = $this->getSearchForm();
        $this->set("canEdit", $this->userPrivilege->canEditBadgeLinks(UserAuthentication::getLoggedUserId(), true));
        $this->set("frmSearch", $frmSearch);

        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('custom/page-css/select2.min.css'));
        $this->includeDateTimeFiles();
        $this->_template->render();
    }

    public function search()
    {
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            FatUtility::dieJsonError(current($searchForm->getValidationErrors()));
        }

        $srch = BadgeLinkCondition::getBadgeLinksSearchObj($this->siteLangId);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $srch->addCondition('badge_name', 'LIKE', '%' . $keyword . '%');
        }

        $badgeType = $post['badge_type'];
        if (!empty($badgeType)) {
            $srch->addCondition(Badge::DB_TBL_PREFIX . 'type', '=',  $badgeType);
        }

        $recordType = $post['blinkcond_record_type']; //Link Type
        if (!empty($recordType)) {
            $srch->addCondition(BadgeLinkCondition::DB_TBL_PREFIX . 'record_type', '=',  $recordType);
        }
        
        $trigger = $post['record_condition']; //Trigger
        if (!empty($trigger)) {
            if (BadgeLinkCondition::REC_COND_AUTO == $trigger) {
                $srch->addCondition('badgelink_record_ids', 'IS', 'mysql_func_null', 'AND', true);
            } else {
                $srch->addCondition('badgelink_record_ids', 'IS NOT', 'mysql_func_null', 'AND', true);
            }
        }
        
        $conditionType = $post['blinkcond_condition_type'];
        if (!empty($conditionType)) {
            $srch->addCondition(BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type', '=',  $conditionType);
        }

        $srch->addCondition(BadgeLinkCondition::DB_TBL_PREFIX . 'record_type', '!=',  BadgeLinkCondition::RECORD_TYPE_SHOP);

        $srch->addOrder(BadgeLinkCondition::DB_TBL_PREFIX . 'id', 'DESC');
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $approvalStatusArr = Badge::getApprovalStatusArr($this->siteLangId);
        
        $this->set("approvalStatusArr", $approvalStatusArr);
        $this->set("canEdit", $this->userPrivilege->canEditBadgeLinks(UserAuthentication::getLoggedUserId(), true));
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    private function getSearchForm()
    {
        $frm = new Form('frmSearch');
        $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $this->siteLangId), 'keyword', '');

        $frm->addSelectBox(Labels::getLabel('LBL_TYPE', $this->siteLangId), 'badge_type', Badge::getTypeArr($this->siteLangId));

        $linkType = BadgeLinkCondition::getRecordTypeArr($this->siteLangId);
        unset($linkType[BadgeLinkCondition::RECORD_TYPE_SHOP]);
        $frm->addSelectBox(Labels::getLabel('LBL_LINK_TYPE', $this->siteLangId), 'blinkcond_record_type', $linkType);

        $frm->addSelectBox(Labels::getLabel('LBL_TRIGGER', $this->siteLangId), 'record_condition', BadgeLinkCondition::getRecordConditionArr($this->siteLangId));

        $frm->addSelectBox(Labels::getLabel('LBL_CONDITION_TYPE', $this->siteLangId), 'blinkcond_condition_type', BadgeLinkCondition::getConditionTypesArr($this->siteLangId));

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->siteLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->siteLangId));
        return $frm;
    }
}
