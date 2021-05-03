<?php

use PhpParser\Node\Stmt\Label;

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

    private function getBadgeLinksObj()
    {
        $srch = new BadgeLinkSearch($this->adminLangId);
        $srch->addMultipleFields([
            BadgeLink::DB_TBL_PREFIX . 'id',
            BadgeLink::DB_TBL_PREFIX . 'badge_id',
            'badge_name',
            'badge_type',
            BadgeLink::DB_TBL_PREFIX . 'record_id',
            '(CASE 
                WHEN ' . BadgeLink::DB_TBL_PREFIX . 'record_type = ' . BadgeLink::RECORD_TYPE_PRODUCT . ' 
                    THEN COALESCE( p_l.product_name, p.product_identifier )
                WHEN ' . BadgeLink::DB_TBL_PREFIX . 'record_type = ' . BadgeLink::RECORD_TYPE_SELLER_PRODUCT . '  
                    THEN selprod_title
                WHEN ' . BadgeLink::DB_TBL_PREFIX . 'record_type = ' . BadgeLink::RECORD_TYPE_SHOP . ' 
                    THEN COALESCE( shp_l.shop_name, shp.shop_identifier )
                ELSE TRUE
            END) as record_name',
            BadgeLink::DB_TBL_PREFIX . 'record_type',
            BadgeLink::DB_TBL_PREFIX . 'condition_type',
            BadgeLink::DB_TBL_PREFIX . 'condition_from',
            BadgeLink::DB_TBL_PREFIX . 'condition_to',
            '(CASE 
                WHEN ' . BadgeLink::DB_TBL_PREFIX . 'record_type = ' . BadgeLink::RECORD_TYPE_SELLER_PRODUCT . '  
                    THEN GROUP_CONCAT( option_name )
                ELSE ""
            END) as option_names',
            '(CASE 
                WHEN ' . BadgeLink::DB_TBL_PREFIX . 'record_type = ' . BadgeLink::RECORD_TYPE_SELLER_PRODUCT . '  
                    THEN GROUP_CONCAT( optionvalue_name )
                ELSE ""
            END) as option_value_names',
            '(CASE 
                WHEN ' . BadgeLink::DB_TBL_PREFIX . 'record_type = ' . BadgeLink::RECORD_TYPE_SELLER_PRODUCT . '
                    THEN spu.credential_username
                WHEN ' . BadgeLink::DB_TBL_PREFIX . 'record_type = ' . BadgeLink::RECORD_TYPE_SHOP . '
                    THEN shpu.credential_username
                ELSE ""
            END) as seller'
        ]);
        $srch->joinBadge($this->adminLangId);
        $srch->joinProduct($this->adminLangId);
        $srch->joinSellerProduct($this->adminLangId);
        $srch->joinShop($this->adminLangId);
        $srch->addGroupBy('badgelink_id');
        return $srch;
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

        $srch = $this->getBadgeLinksObj();

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $cnd = $srch->addHaving('badge_name', 'LIKE', '%' . $keyword . '%');
            $cnd->attachCondition('record_name', 'LIKE', '%' . $keyword . '%', 'OR');
            $cnd->attachCondition('option_names', 'LIKE', '%' . $keyword . '%', 'OR');
            $cnd->attachCondition('option_value_names', 'LIKE', '%' . $keyword . '%', 'OR');
        }

        $recordType = $post['badgelink_record_type'];
        if (!empty($recordType)) {
            $srch->addRecordTypesCondition([$recordType]);
        }

        $badgeLinkConditionType = $post['badgelink_condition_type'];
        if (!empty($badgeLinkConditionType)) {
            $srch->addConditionTypesCondition([$badgeLinkConditionType]);
        }

        $badgeType = $post['badge_type'];
        if (!empty($badgeType)) {
            $srch->addBadgeTypeCondition([$badgeType]);
        }

        $badgeType = $post['badge_type'];
        if (!empty($badgeType)) {
            $srch->addBadgeTypeCondition([$badgeType]);
        }

        $conditionFrom = $post['badgelink_condition_from'];
        if (!empty($conditionFrom)) {
            $srch->addFromCondition($conditionFrom);
        }

        $conditionTo = $post['badgelink_condition_to'];
        if (!empty($conditionTo)) {
            $srch->addToCondition($conditionTo);
        }
        
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $this->set("canEdit", $this->objPrivilege->canEditBadgeLinks($this->admin_id, true));
        $this->set("arr_listing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    public function form(int $badgeLinkId, int $recordType)
    {
        $this->objPrivilege->canEditBadgeLinks();
        $frm = $this->getForm();

        $dataToFill = [];
        if ($badgeLinkId > 0) {
            $srch = $this->getBadgeLinksObj();
            $srch->addCondition('badgelink_id', '=', $badgeLinkId);
            $dataToFill = FatApp::getDb()->fetch($srch->getResultSet());
        }
        $frm->fill($dataToFill);

        $this->set('frm', $frm);
        $this->set('recordType', $recordType);
        $this->set('rowData', $dataToFill);
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

        $conditionType = FatApp::getPostedData('badgelink_condition_type', FatUtility::VAR_INT, 0);
        switch ($conditionType) {
            case BadgeLink::CONDITION_TYPE_DATE:
                $format = 'Y-m-d H:i';
                $fromCond = FatApp::getPostedData('badgelink_condition_from', FatUtility::VAR_STRING, '');
                $toCond = FatApp::getPostedData('badgelink_condition_to', FatUtility::VAR_STRING, '');
                
                /* e.g. DateTime::createFromFormat('Y-m-d H:i', '2021-03-05 13:30'); */
                $from = DateTime::createFromFormat($format, $fromCond);
                $to = DateTime::createFromFormat($format, $toCond);
                if (!$from || $from->format($format) !== $fromCond || !$to || $to->format($format) !== $toCond || $fromCond > $toCond) {
                    FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_CONDITION_FROM_OR_TO_VALUE', $this->adminLangId));
                }
                break;
            case BadgeLink::CONDITION_TYPE_ORDER:
            case BadgeLink::CONDITION_TYPE_RATING:
                $fromCond = FatApp::getPostedData('badgelink_condition_from', FatUtility::VAR_INT, 0);
                $toCond = FatApp::getPostedData('badgelink_condition_to', FatUtility::VAR_INT, 0);
                if (1 > $fromCond || 1 > $toCond || $fromCond > $toCond) {
                    FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_CONDITION_FROM_OR_TO_VALUE', $this->adminLangId));
                }
                break;
            
            default:
                FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_CONDITION_TYPE', $this->adminLangId));
                break;
        }

        $badgeLinkId = FatApp::getPostedData('badgelink_id', FatUtility::VAR_INT, 0);
        
        $record = new BadgeLink($badgeLinkId);
        $record->assignValues($post);
        if (!$record->save()) {
            FatUtility::dieJsonError($record->getError());
        }
        
        $badgeLinkId = $record->getMainTableRecordId();
        $recordType = FatApp::getPostedData('badgelink_record_type', FatUtility::VAR_INT, 0);

        $this->set('recordType', $recordType);
        $this->set('badgelink_id', $badgeLinkId);
        $this->set('msg', Labels::getLabel('MGS_ADDED_SUCCESSFULLY', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getSearchForm()
    {
        $frm = new Form('frmSearch');
        $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $this->adminLangId), 'keyword', '');

        $badgeTypes = Badge::getTypeArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_TYPE', $this->adminLangId), 'badge_type', $badgeTypes);

        $recordTypesArr = BadgeLink::getRecordTypeArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_RECORD_TYPE', $this->adminLangId), 'badgelink_record_type', $recordTypesArr);

        $conditionTypesArr = BadgeLink::getConditionTypesArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_CONDITION_TYPE', $this->adminLangId), 'badgelink_condition_type', $conditionTypesArr);

        $frm->addTextBox(Labels::getLabel('LBL_CONDITION_FROM', $this->adminLangId), 'badgelink_condition_from');
        $frm->addTextBox(Labels::getLabel('LBL_CONDITION_TO', $this->adminLangId), 'badgelink_condition_to');

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

        $fld = $frm->addSelectBox(Labels::getLabel('LBL_BADGE_OR_RIBBON', $this->adminLangId), 'badge_name', [], '4', ['placeholder' => Labels::getLabel('LBL_SEARCH_BADGE_OR_RIBBON', $this->adminLangId)], '');
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
        $this->set('msg', Labels::getLabel('MSG_DELETED_SUCCESSFULLY', $this->adminLangId));
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
        $this->set('msg', Labels::getLabel('MSG_DELETED_SUCCESSFULLY', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function unlink(int $badgelink_id)
    {
        if (1 > $badgelink_id) {
            FatUtility::dieJsonError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId)
            );
        }

        $obj = new BadgeLink($badgelink_id);
        if (!$obj->deleteRecord(false)) {
            FatUtility::dieJsonError($obj->getError());
        }
    }
}
