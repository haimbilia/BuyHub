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

        $placeholder = (Badge::TYPE_BADGE == $badgeType ? 'LBL_SEARCH_BY_BADGE_NAME' : 'LBL_SEARCH_BY_RIBBON_NAME');
        $this->set("keywordPlaceholder", Labels::getLabel($placeholder));

        $this->_template->addJs(array('js/jscolor.js', 'js/select2.js'));
        $this->_template->addCss(array('css/select2.min.css'));
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

        $userId = UserAuthentication::getLoggedUserId();

        $srch = new BadgeSearch($this->siteLangId);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $srch->joinTable(BadgeLinkCondition::DB_TBL, 'LEFT JOIN', 'blinkcond_badge_id = badge_id');
        $srch->joinTable(BadgeRequest::DB_TBL, 'LEFT JOIN', 'breq_blinkcond_id = blinkcond_id AND breq_user_id  = ' . $userId);
        $srch->addCondition('badge_active', '=', applicationConstants::YES);

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

        $conditionType = FatApp::getPostedData('badge_trigger_type');
        if ('' != $conditionType) {
            $srch->addCondition('badge_trigger_type', '=', $conditionType);
        } else if (Badge::APPROVAL_OPEN === $approval) {
            $srch->addCondition('badge_trigger_type', '=', Badge::COND_MANUAL);
        }

        $attr = array_merge(Badge::ATTR, Badge::LANG_ATTR, [
            '(CASE
                WHEN ' . Badge::DB_TBL_PREFIX . 'type = ' . Badge::TYPE_RIBBON . ' OR ' . Badge::DB_TBL_PREFIX . 'required_approval = ' . Badge::APPROVAL_OPEN . '
                THEN 1
                WHEN ' . Badge::DB_TBL_PREFIX . 'type = ' . Badge::TYPE_BADGE . ' AND ' . Badge::DB_TBL_PREFIX . 'trigger_type = ' . Badge::COND_AUTO . '
                THEN 0
                WHEN SUM(
                    IF(' . Badge::DB_TBL_PREFIX . 'required_approval = ' . Badge::APPROVAL_REQUIRED  . ' AND ' . BadgeLinkCondition::DB_TBL_PREFIX . 'id > 0 AND ' . BadgeRequest::DB_TBL_PREFIX . 'id IS NULL AND ' .  BadgeLinkCondition::DB_TBL_PREFIX . 'user_id = ' . $userId . ', 1, 0)
                    ) > 0
                THEN 1
                WHEN SUM(
                    IF(' . Badge::DB_TBL_PREFIX . 'required_approval = ' . Badge::APPROVAL_REQUIRED . ' AND ' . BadgeRequest::DB_TBL_PREFIX . 'status = ' . BadgeRequest::REQUEST_APPROVED . ' AND ' . BadgeRequest::DB_TBL_PREFIX . 'user_id = ' . $userId . ', 1, 0)
                    ) > 0
                THEN 1
                ELSE 0
            END) as canAccess',
            BadgeRequest::DB_TBL_PREFIX . 'id',
            BadgeRequest::DB_TBL_PREFIX . 'status',
            BadgeLinkCondition::DB_TBL_PREFIX . 'id',
            BadgeLinkCondition::DB_TBL_PREFIX . 'user_id',
            'COALESCE(badge_name,  badge_identifier) as badge_name'
        ]);
        $srch->addFld(Badge::DB_TBL_PREFIX . 'id');
        $srch->addGroupBy(Badge::DB_TBL_PREFIX . 'id');
        $this->setRecordCount(clone $srch, $pagesize, $page, $post, true);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields($attr);
        $srch->addOrder(Badge::DB_TBL_PREFIX . 'id', 'DESC');
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $approvalStatusArr = Badge::getApprovalStatusArr($this->siteLangId);

        $this->set("badgeType", $badgeType);
        $this->set("approvalStatusArr", $approvalStatusArr);
        $this->set("canEdit", $this->userPrivilege->canEditBadgeLinks($userId, true));
        $this->set("arrListing", $records);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    private function getSearchForm(int $badgeType)
    {
        $frm = new Form('frmSearch');
        $frm->addHiddenField('', 'badge_type');
        $frm->addHiddenField('', 'total_record_count');
        $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '');

        if (Badge::TYPE_BADGE == $badgeType) {
            $conditionTypeArr = Badge::getTriggerCondTypeArr($this->siteLangId);
            $frm->addSelectBox(Labels::getLabel('FRM_TRIGGER_TYPE', $this->siteLangId), 'badge_trigger_type', $conditionTypeArr, '', ['class' => 'badgeTriggerTypeJs']);

            $approvalArr = Badge::getApprovalStatusArr($this->siteLangId);
            $frm->addSelectBox(Labels::getLabel('FRM_APPROVAL', $this->siteLangId), 'badge_required_approval', $approvalArr, '', ['class' => 'badgeApprovalJs'], Labels::getLabel('LBL_SELECT_APPROVAL', $this->siteLangId));
        }

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm, 'btn btn-clear');
        return $frm;
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditBadgesAndRibbons();
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

    public function getBreadcrumbNodes($action)
    {
        if (FatUtility::isAjaxCall()) {
            return;
        }

        $badgeType = current(FatApp::getParameters());
        $className = Badge::TYPE_BADGE == $badgeType ? Labels::getLabel('LBL_BADGES', $this->siteLangId) : Labels::getLabel('LBL_RIBBONS', $this->siteLangId);

        $action = str_replace('-', '_', FatUtility::camel2dashed($action));        
        $this->nodes[] = array('title' => ucwords($className));
        $this->nodes[] = array('title' => ucwords(Labels::getLabel('BCN_' . $action)));
        return $this->nodes;
    }

    public function badgesInstructions(int $instrunctionType)
    {
        $pageData = '';
        $obj = new Extrapage();
        switch ($instrunctionType) {
            case Extrapage::SELLER_BADGES_INSTRUCTIONS:
                $pageData = $obj->getContentByPageType(Extrapage::SELLER_BADGES_INSTRUCTIONS, $this->siteLangId);
                break;
            case Extrapage::SELLER_RIBBONS_INSTRUCTIONS:
                $pageData = $obj->getContentByPageType(Extrapage::SELLER_RIBBONS_INSTRUCTIONS, $this->siteLangId);
                break;
        }
        $this->set('pageData', $pageData);
        $this->_template->render(false, false, NULL, false, false);
    }
}
