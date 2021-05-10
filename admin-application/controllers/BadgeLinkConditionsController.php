<?php

class BadgeLinkConditionsController extends AdminBaseController
{
    private $recordData = [];
    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();

        $this->objPrivilege->canViewBadgeLinks($this->admin_id);
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
            case 'form':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_BADGES_&_RIBBONS_LINKS', $this->adminLangId)]
                ];
        }
        return $this->nodes;
    }

    public function index()
    {
        $frmSearch = $this->getSearchForm();
        $this->set("canEdit", $this->objPrivilege->canEditBadgeLinks($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);

        $this->_template->addJs(array('js/select2.js', 'js/select2.customSelectionAdapter.min.js'));
        $this->_template->addCss(array('css/select2.min.css', 'css/select2.customSelectionAdapter.css'));
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

        $srch = BadgeLinkCondition::getBadgeLinksSearchObj($this->adminLangId);

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $cnd = $srch->addHaving('badge_name', 'LIKE', '%' . $keyword . '%');
        }

        $badgeType = $post['badge_type'];
        if (!empty($badgeType)) {
            $srch->addBadgeTypeCondition([$badgeType]);
        }

        $recordType = $post['blinkcond_record_type']; //Link Type
        if (!empty($recordType)) {
            $srch->addRecordTypesCondition([$recordType]);
        }

        $trigger = $post['record_condition']; //Trigger
        if (!empty($trigger)) {
            if (BadgeLinkCondition::REC_COND_AUTO == $trigger) {
                $srch->addHaving('badgelink_record_ids', 'IS', 'mysql_func_null','AND',true);
            } else {
                $srch->addHaving('badgelink_record_ids', 'IS NOT', 'mysql_func_null','AND',true);
            }
        }

        $conditionType = $post['blinkcond_condition_type'];
        if (!empty($conditionType)) {
            $srch->addConditionTypesCondition([$conditionType]);
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

    public function form(int $badgeLinkCondId, int $recordType)
    {
        $this->objPrivilege->canEditBadgeLinks();

        $dataToFill = [];
        $recordCondition = BadgeLinkCondition::REC_COND_AUTO;
        if ($badgeLinkCondId > 0) {
            $srch = BadgeLinkCondition::getBadgeLinksSearchObj($this->adminLangId, true);
            $srch->addCondition('blinkcond_id', '=', $badgeLinkCondId);

            /* Bind Records */
            $srch->joinProduct($this->adminLangId);
            $srch->joinSellerProduct($this->adminLangId);
            $srch->joinShop($this->adminLangId);
            /* Bind Records */
            $result = FatApp::getDb()->fetchAll($srch->getResultSet());
            foreach ($result as $badgeLink) {
                if (array_key_exists('badgelink_record_id', $badgeLink) && empty($badgeLink['badgelink_record_id'])) {
                    $dataToFill = $badgeLink;
                    break;
                }


                $recordId = $badgeLink['badgelink_record_id'];
                $recordName = $badgeLink['record_name'];
                $optionName = $badgeLink['option_name'];
                $optionValueName = $badgeLink['option_value_name'];
                $seller = $badgeLink['seller'];
                unset($badgeLink['badgelink_record_id'], $badgeLink['record_name'], $badgeLink['option_name'], $badgeLink['option_value_name'], $badgeLink['seller']);

                if (empty($dataToFill)) {
                    $dataToFill = $badgeLink;
                }

                if (BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT == $badgeLink['blinkcond_record_type']) {
                    $name = $recordName;
                    if (isset($dataToFill['records'][$recordId]['record_name'])) {
                        $name = $dataToFill['records'][$recordId]['record_name'];
                    }

                    $option = !empty($optionName) ? ' | ' .  $optionName . ' : ' . $optionValueName : '';
                    $recordName = $name . $option . ' | ' . $seller;
                }

                $dataToFill['records'][$recordId] = [
                    'badgelink_record_id' => $recordId,
                    'record_name' => $recordName
                ];
                $dataToFill['badgelink_record_ids'] = array_key_exists('badgelink_record_ids', $dataToFill) ? $dataToFill['badgelink_record_ids'] . ',' . $recordId : $recordId;
            }

            $fromDate = $toDate = "";
            if (!empty($dataToFill['blinkcond_from_date']) && 0 < strtotime($dataToFill['blinkcond_from_date'])) {
                $fromDate = date('Y-m-d H:i', strtotime($dataToFill['blinkcond_from_date']));
            }

            if (!empty($dataToFill['blinkcond_to_date']) && 0 < strtotime($dataToFill['blinkcond_to_date'])) {
                $toDate = date('Y-m-d H:i', strtotime($dataToFill['blinkcond_to_date']));
            }
            $dataToFill['blinkcond_from_date'] = $fromDate;
            $dataToFill['blinkcond_to_date'] = $toDate;
            
            $this->recordData = $dataToFill;
            $recordCondition = BadgeLinkCondition::REC_COND_MANUAL;
            if (empty($dataToFill['badgelink_record_ids'])) {
                $recordCondition = BadgeLinkCondition::REC_COND_AUTO;
            }
            $dataToFill['record_condition'] = $recordCondition;
        }
        $frm = $this->getForm($recordCondition);
        $frm->fill($dataToFill);

        $this->set('frm', $frm);
        $this->set('recordType', $recordType);
        $this->set('rowData', $dataToFill);
        $this->set('blinkcond_id', $badgeLinkCondId);

        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditBadgeLinks();

        $recordCondition = FatApp::getPostedData('record_condition', FatUtility::VAR_INT, 0);
        $conditionType = FatApp::getPostedData('blinkcond_condition_type', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordCondition, $conditionType);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $records = array_filter(FatApp::getPostedData('badgelink_record_id', FatUtility::VAR_INT, []));
        if (BadgeLinkCondition::REC_COND_MANUAL == $recordCondition && empty($records)) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_LINK_TO_IS_MANDATORY', $this->adminLangId));
        }
        
        $fromDate = FatApp::getPostedData('blinkcond_from_date', FatUtility::VAR_STRING, '');
        $toDate = FatApp::getPostedData('blinkcond_to_date', FatUtility::VAR_STRING, '');

        if (!empty($fromDate) && !empty($toDate) && $fromDate > $toDate) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_TO_DATE_MUST_BE_GREATER_THAN_OR_EQUAL_TO_FROM_DATE', $this->adminLangId));
        }

        if (BadgeLinkCondition::REC_COND_AUTO == $recordCondition) {
            $conditionType = FatApp::getPostedData('blinkcond_condition_type', FatUtility::VAR_INT, 0);
            switch ($conditionType) {
                case BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS:
                case BadgeLinkCondition::COND_TYPE_AVG_RATING:
                    $fromCond = FatApp::getPostedData('blinkcond_condition_from', FatUtility::VAR_INT, 0);
                    $toCond = FatApp::getPostedData('blinkcond_condition_to', FatUtility::VAR_INT, 0);
                    if (1 > $fromCond || 1 > $toCond || $fromCond > $toCond) {
                        FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_CONDITION_FROM_OR_TO_VALUE', $this->adminLangId));
                    }
                    break;
                case BadgeLinkCondition::COND_TYPE_ORDER_COMPLETION_RATE:
                case BadgeLinkCondition::COND_TYPE_RETURN_ACCEPTANCE:
                case BadgeLinkCondition::COND_TYPE_ORDER_CANCELLED:
                    $rate = FatApp::getPostedData('blinkcond_condition_from', FatUtility::VAR_INT, 0);
                    if (0 > $rate || 100 < $rate) {
                        FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_RATE_VALUE', $this->adminLangId));
                    }
                    $post['blinkcond_condition_from'] = $rate;
                    break;

                default:
                    FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_CONDITION_TYPE', $this->adminLangId));
                    break;
            }
        }

        $badgeLinkCondId = FatApp::getPostedData('blinkcond_id', FatUtility::VAR_INT, 0);
        $record = new BadgeLinkCondition($badgeLinkCondId);
        $record->assignValues($post);
        if (!$record->save()) {
            FatUtility::dieJsonError($record->getError());
        }

        $badgeLinkCondId = $record->getMainTableRecordId();
        if (BadgeLinkCondition::REC_COND_MANUAL == $recordCondition && !empty($records)) {
            $db = FatApp::getDb();
            $db->deleteRecords(BadgeLinkCondition::DB_TBL_BADGE_LINKS, array(
                'smt' => 'badgelink_blinkcond_id = ?',
                'vals' => [$badgeLinkCondId]
            ));
            foreach ($records as $recordId) {
                $linkData = array(
                    'badgelink_blinkcond_id' => $badgeLinkCondId,
                    'badgelink_record_id' => $recordId
                );
                $db->insertFromArray(BadgeLinkCondition::DB_TBL_BADGE_LINKS, $linkData);
            }
        }

        $recordType = FatApp::getPostedData('blinkcond_record_type', FatUtility::VAR_INT, 0);

        $this->set('recordType', $recordType);
        $this->set('blinkcond_id', $badgeLinkCondId);
        $this->set('msg', Labels::getLabel('MGS_ADDED_SUCCESSFULLY', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getSearchForm()
    {
        $frm = new Form('frmSearch');
        $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $this->adminLangId), 'keyword', '');

        $frm->addSelectBox(Labels::getLabel('LBL_TYPE', $this->adminLangId), 'badge_type', Badge::getTypeArr($this->adminLangId));

        $frm->addSelectBox(Labels::getLabel('LBL_LINK_TYPE', $this->adminLangId), 'blinkcond_record_type', BadgeLinkCondition::getRecordTypeArr($this->adminLangId));
        
        $frm->addSelectBox(Labels::getLabel('LBL_TRIGGER', $this->adminLangId), 'record_condition', BadgeLinkCondition::getRecordConditionArr($this->adminLangId));
        
        $frm->addSelectBox(Labels::getLabel('LBL_CONDITION_TYPE', $this->adminLangId), 'blinkcond_condition_type', BadgeLinkCondition::getConditionTypesArr($this->adminLangId));

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getForm(int $recordCondition, int $conditionType = 0)
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'blinkcond_id');
        $frm->addHiddenField('', 'blinkcond_badge_id');

        $selectedRecords = $selectedBadge = $recordIds = [];
        $badgeId = '';
        if (is_array($this->recordData) && 0 < count($this->recordData)) {
            if (isset($this->recordData['records'])) {
                $recordIds = explode(",", $this->recordData['badgelink_record_ids']);
                foreach ($this->recordData['records'] as $record) {
                    $selectedRecords[$record['badgelink_record_id']] = $record['record_name'];
                }
            }
            $selectedBadge[$this->recordData['blinkcond_badge_id']] = $this->recordData['badge_name'];
            $badgeId = $this->recordData['blinkcond_badge_id'];
        }

        $typesArr = Badge::getTypeArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_BADGE_OR_RIBBON', $this->adminLangId), 'badge_type', $typesArr, '', [], '');

        $fld = $frm->addSelectBox(Labels::getLabel('LBL_NAME', $this->adminLangId), 'badge_name', $selectedBadge, $badgeId, ['placeholder' => Labels::getLabel('LBL_SEARCH...', $this->adminLangId)], '');
        $fld->requirement->setRequired(true);

        $recordConditionArr = BadgeLinkCondition::getRecordConditionArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_TRIGGER', $this->adminLangId), 'record_condition', $recordConditionArr, '', [], '');
        $fld->requirement->setRequired(true);

        $recordTypesArr = BadgeLinkCondition::getRecordTypeArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_LINK_TYPE', $this->adminLangId), 'blinkcond_record_type', $recordTypesArr, '', [], '');
        $fld->requirement->setRequired(true);
        
        $frm->addTextBox(Labels::getLabel('LBL_FROM_DATE', $this->adminLangId), 'blinkcond_from_date', '', ['readonly' => 'readonly']);
        $frm->addTextBox(Labels::getLabel('LBL_TO_DATE', $this->adminLangId), 'blinkcond_to_date', '', ['readonly' => 'readonly']);

        $conditionTypesArr = BadgeLinkCondition::getConditionTypesArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_CONDITION_TYPE', $this->adminLangId), 'blinkcond_condition_type', $conditionTypesArr);
        $fld->requirement->setRequired((BadgeLinkCondition::REC_COND_AUTO == $recordCondition));

        $fld = $frm->addTextBox(Labels::getLabel('LBL_FROM', $this->adminLangId), 'blinkcond_condition_from');
        $fld->requirement->setRequired((BadgeLinkCondition::REC_COND_AUTO == $recordCondition));

        $rangeElements = [BadgeLinkCondition::COND_TYPE_DATE, BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS, BadgeLinkCondition::COND_TYPE_AVG_RATING];
        $fld = $frm->addTextBox(Labels::getLabel('LBL_TO', $this->adminLangId), 'blinkcond_condition_to');
        if (0 == $conditionType || in_array($conditionType, $rangeElements)) {
            $fld->requirement->setRequired((BadgeLinkCondition::REC_COND_AUTO == $recordCondition));
        }

        $fld = $frm->addSelectBox(Labels::getLabel('LBL_LINK_TO', $this->adminLangId), 'badgelink_record_id[]', $selectedRecords, $recordIds, ['placeholder' => Labels::getLabel('LBL_SEARCH_RECORD', $this->adminLangId), 'multiple' => 'multiple', 'class' => 'recordIds--js'], '');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE', $this->adminLangId));
        return $frm;
    }

    public function badgeUnlink()
    {
        $this->objPrivilege->canEditBadgeLinks();
        $blinkcond_id = FatApp::getPostedData('blinkcond_id', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('badge_active', FatUtility::VAR_INT, -1);
        if (1 > $blinkcond_id) {
            FatUtility::dieJsonError($this->str_invalid_request);
        }

        if (!BadgeLinkCondition::getAttributesById($blinkcond_id, ['blinkcond_id'])) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        $this->unlink($blinkcond_id);
        $this->set('msg', Labels::getLabel('MSG_DELETED_SUCCESSFULLY', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function bulkBadgesUnlink()
    {
        $this->objPrivilege->canEditBadgeLinks();

        $badgeLinkCondIdsArr = FatUtility::int(FatApp::getPostedData('badgeLinkIds'));
        if (empty($badgeLinkCondIdsArr)) {
            FatUtility::dieJsonError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId)
            );
        }

        foreach ($badgeLinkCondIdsArr as $blinkcond_id) {
            if (1 > $blinkcond_id) {
                continue;
            }

            $this->unlink($blinkcond_id);
        }
        $this->set('msg', Labels::getLabel('MSG_DELETED_SUCCESSFULLY', $this->adminLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function unlink(int $blinkcond_id)
    {
        if (1 > $blinkcond_id) {
            FatUtility::dieJsonError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId)
            );
        }

        $obj = new BadgeLinkCondition($blinkcond_id);
        if (!$obj->deleteRecord(false)) {
            FatUtility::dieJsonError($obj->getError());
        }
    }
}
