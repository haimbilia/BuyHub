<?php

class BadgeLinksController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();

        $this->objPrivilege->canViewBadgeLinks($this->admin_id);
    }

    public function index()
    {
        $frmSearch = $this->getSearchForm();
        $this->set("canEdit", $this->objPrivilege->canEditBadgeLinks($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);

        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->includeDateTimeFiles();
        $this->_template->render();
    }

    public function search()
    {
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            FatUtility::dieJsonError(current($searchForm->getValidationErrors()));
        }

        $srch = new BadgeLinkSearch($this->adminLangId);
        $srch->addMultipleFields([
            Badge::DB_TBL_PREFIX . 'name',
            Badge::DB_TBL_PREFIX . 'type',
            BadgeLink::DB_TBL_PREFIX . 'record_name',
            BadgeLink::DB_TBL_PREFIX . 'record_type',
            BadgeLink::DB_TBL_PREFIX . 'condition_type',
            BadgeLink::DB_TBL_PREFIX . 'condition_from',
            BadgeLink::DB_TBL_PREFIX . 'condition_to'
        ]);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $srch->joinBadge($this->adminLangId);
        /* $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('badgelink_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('badgelink_identifier', 'like', '%' . $keyword . '%');
        } */

        $recordType = $post['badgelink_record_type'];
        if (!empty($recordType)) {
            $srch->addRecordTypesCondition([$recordType]);
        }

        $badgeLinkConditionType = $post['badgelink_condition_type'];
        if (!empty($badgeLinkConditionType)) {
            $srch->addConditionTypesCondition([$badgeLinkConditionType]);
        }
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set("canEdit", $this->objPrivilege->canEditBadgeLinks($this->admin_id, true));
        $this->set("arr_listing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    public function form(int $badgeLinkId)
    {
        $this->objPrivilege->canEditBadgeLinks();
        $frm = $this->getForm();

        $dataToFill = [];
        if ($badgeLinkId > 0) {
            // $srch = new BadgeLink($badgeLinkId);
            
        }
        $frm->fill($dataToFill);

        $this->set('frm', $frm);
        $this->set('badgelink_id', $badgeLinkId);

        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditBadgeLinks();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $badgeLinkId = FatApp::getPostedData('badgelink_id', FatUtility::VAR_INT, 0);

        $record = new BadgeLink($badgeLinkId);
        $record->assignValues($post);
        if (!$record->save()) {
            FatUtility::dieJsonError($record->getError());
        }

        $badgeLinkId = $record->getMainTableRecordId();

        $this->set('badgelink_id', $badgeLinkId);
        $this->set('msg', Labels::getLabel('MGS_ADDED_SUCCESSFULLY', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getSearchForm()
    {
        $frm = new Form('frmSearch');
        $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $this->adminLangId), 'keyword', '');

        $recordTypesArr = BadgeLink::getRecordTypeArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_RECORD_TYPE', $this->adminLangId), 'badgelink_record_type', $recordTypesArr);

        $conditionTypesArr = BadgeLink::getConditionTypesArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_CONDITION_TYPE', $this->adminLangId), 'badgelink_condition_type', $conditionTypesArr);

        $frm->addTextBox(Labels::getLabel('LBL_CONDITION_FROM', $this->adminLangId), 'badgelink_condition_from');
        $frm->addTextBox(Labels::getLabel('LBL_CONDITION_FROM', $this->adminLangId), 'badgelink_condition_to');

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getForm()
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'badgelink_id');
        $frm->addHiddenField('', 'badgelink_badge_id');
        $frm->addHiddenField('', 'badgelink_record_id');

        $fld = $frm->addSelectBox(Labels::getLabel('LBL_BADGE_OR_RIBBON', $this->adminLangId), 'badge_name', [], '', ['placeholder' => Labels::getLabel('LBL_SEARCH_BADGE_OR_RIBBON', $this->adminLangId)], '');
        $fld->requirement->setRequired(true);

        $recordTypesArr = BadgeLink::getRecordTypeArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_RECORD_TYPE', $this->adminLangId), 'badgelink_record_type', $recordTypesArr, '', [], '');
        $fld->requirement->setRequired(true);

        $fld = $frm->addSelectBox(Labels::getLabel('LBL_RECORD_NAME', $this->adminLangId), 'record_name', [], '', ['placeholder' => Labels::getLabel('LBL_SEARCH_RECORD', $this->adminLangId)], '');
        $fld->requirement->setRequired(true);
        
        $conditionTypesArr = BadgeLink::getConditionTypesArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_CONDITION_TYPE', $this->adminLangId), 'badgelink_condition_type', $conditionTypesArr);
        $fld->requirement->setRequired(true);

        $frm->addRequiredField(Labels::getLabel('LBL_CONDITION_FROM', $this->adminLangId), 'badgelink_condition_from');
        $frm->addRequiredField(Labels::getLabel('LBL_CONDITION_TO', $this->adminLangId), 'badgelink_condition_to');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE', $this->adminLangId));
        return $frm;
    }

    public function badgeUnlink()
    {
        $this->objPrivilege->canEditBadgeLinks();
        $badgelink_id = FatApp::getPostedData('badgelink_id', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('badge_active', FatUtility::VAR_INT, -1);
        if (1 > $badgelink_id) {
            FatUtility::dieJsonError($this->str_invalid_request);
        }

        if (!BadgeLink::getAttributesById($badgelink_id, ['badgelink_id'])) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        $this->unlink($badgelink_id);
        $this->set('msg', Labels::getLabel('MSG_UNLINKED_SUCCESSFULLY', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function bulkBadgesUnlink()
    {
        $this->objPrivilege->canEditBadgeLinks();

        $badgeLinkIdsArr = FatUtility::int(FatApp::getPostedData('badgeLinkIds'));
        if (empty($badgeLinkIdsArr)) {
            FatUtility::dieJsonError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId)
            );
        }

        foreach ($badgeLinkIdsArr as $badgelink_id) {
            if (1 > $badgelink_id) {
                continue;
            }

            $this->unlink($badgelink_id);
        }
        $this->set('msg', Labels::getLabel('MSG_UNLINKED_SUCCESSFULLY', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function unlink(int $badgelink_id)
    {
        if (1 > $badgelink_id) {
            FatUtility::dieJsonError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId)
            );
        }

        $brandObj = new BadgeLink($badgelink_id);
    }
}
