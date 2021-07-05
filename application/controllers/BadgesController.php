<?php

class BadgesController extends SellerBaseController
{
    use BadgeRequestSetup;

    public function __construct($action)
    {
        parent::__construct($action);

        $this->userPrivilege->canViewBadgeLinks(UserAuthentication::getLoggedUserId());
    }

    public function list(int $badgeType)
    {
        $frmSearch = $this->getSearchForm($badgeType);
        $frmSearch->fill(['badge_type' => $badgeType]);

        $this->set("canEdit", $this->userPrivilege->canEditBadgeLinks(UserAuthentication::getLoggedUserId(), true));
        $this->set("frmSearch", $frmSearch);
        $this->set("badgeType", $badgeType);

        $this->_template->addJs(array('js/jscolor.js', 'js/select2.js'));
        $this->_template->addCss(array('custom/page-css/select2.min.css'));
        $this->_template->render();
    }

    public function search()
    {
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $badgeType = FatApp::getPostedData('badge_type', FatUtility::VAR_INT, 0);
        $searchForm = $this->getSearchForm($badgeType);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            FatUtility::dieJsonError(current($searchForm->getValidationErrors()));
        }

        $srch = new BadgeSearch($this->siteLangId);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $srch->joinTable(BadgeLinkCondition::DB_TBL, 'LEFT JOIN', 'blinkcond_badge_id = badge_id');
        $srch->joinTable(BadgeRequest::DB_TBL, 'LEFT JOIN', 'breq_blinkcond_id = blinkcond_id');

        $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('badge_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('badge_identifier', 'like', '%' . $keyword . '%');
        }

        $badgeType = $post['badge_type'];
        if (!empty($badgeType)) {
            $srch->addCondition(Badge::DB_TBL_PREFIX . 'type', '=',  $badgeType);
        }

        $approval = FatApp::getPostedData('badge_required_approval');
        if ('' != $approval) {
            $srch->addCondition('badge_type', '=', Badge::TYPE_BADGE);
            $srch->addCondition('badge_required_approval', '=', $approval);
        }

        $attr = array_merge(Badge::ATTR, Badge::LANG_ATTR, [
            '(CASE
                WHEN ' . Badge::DB_TBL_PREFIX . 'type = ' . Badge::TYPE_RIBBON . ' OR ' . Badge::DB_TBL_PREFIX . 'required_approval = ' . Badge::APPROVAL_OPEN . '
                THEN 1
                WHEN ' . Badge::DB_TBL_PREFIX . 'type = ' . Badge::TYPE_BADGE . ' AND ' . Badge::DB_TBL_PREFIX . 'condition_type = ' . Badge::COND_AUTO . '
                THEN 0
                WHEN (SUM(IF(' . Badge::DB_TBL_PREFIX . 'required_approval = ' . Badge::APPROVAL_REQUIRED  . ' AND ' . BadgeLinkCondition::DB_TBL_PREFIX . 'id > 0 AND ' . BadgeRequest::DB_TBL_PREFIX . 'id IS NULL, 1, 0))) > 0 OR (SUM(IF(' . Badge::DB_TBL_PREFIX . 'required_approval = ' . Badge::APPROVAL_REQUIRED . ' AND ' . BadgeRequest::DB_TBL_PREFIX . 'status = ' . BadgeRequest::REQUEST_APPROVED . ' AND ' . BadgeRequest::DB_TBL_PREFIX . 'user_id = ' . UserAuthentication::getLoggedUserId() . ', 1, 0)) > 0)
                THEN 1
                ELSE 0
            END) as canAccess'
        ]);
        $srch->addMultipleFields($attr);
        $srch->addGroupBy(Badge::DB_TBL_PREFIX . 'id');
        $srch->addOrder(Badge::DB_TBL_PREFIX . 'id', 'DESC');
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $approvalStatusArr = Badge::getApprovalStatusArr($this->siteLangId);

        $this->set("badgeType", $badgeType);
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

    private function getSearchForm(int $badgeType)
    {
        $frm = new Form('frmSearch');
        $frm->addHiddenField('', 'badge_type');
        $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $this->siteLangId), 'keyword', '');

        if (Badge::TYPE_BADGE == $badgeType) {
            $approvalArr = Badge::getApprovalStatusArr($this->siteLangId);
            $frm->addSelectBox(Labels::getLabel('LBL_APPROVAL', $this->siteLangId), 'badge_required_approval', $approvalArr);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->siteLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->siteLangId));
        return $frm;
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditBadges();
        $badgeIdsArr = FatUtility::int(FatApp::getPostedData('badgeIds'));
        if (empty($badgeIdsArr)) {
            FatUtility::dieJsonError($this->str_invalid_request);
        }

        foreach ($badgeIdsArr as $badge_id) {
            if (1 > $badge_id) {
                continue;
            }

            $obj = new Badge($badge_id);
            if (!$obj->deleteRecord(true)) {
                continue;
            }

            if (!FatApp::getDb()->deleteRecords(BadgeLinkCondition::DB_TBL_PREFIX, array('smt' => 'blinkcond_badge_id = ?', 'vals' => array($badge_id)))) {
                continue;
            }
        }
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }
}
