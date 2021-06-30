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
            case 'list':
            case 'form':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_BIND_CONDITIONS', $this->adminLangId)]
                ];
        }
        return $this->nodes;
    }

    public function list(int $badgeId)
    {
        $badgeType = Badge::getAttributesById($badgeId, 'badge_type');
        $frmSearch = $this->getSearchForm($badgeType);
        $frmSearch->fill(['blinkcond_badge_id' => $badgeId, 'badge_type' => $badgeType]);
        $this->set("canEdit", $this->objPrivilege->canEditBadgeLinks($this->admin_id, true));
        
        $this->set('badgeName', $this->getBadgeName($badgeId));
        $this->set("frmSearch", $frmSearch);
        $this->set("badgeId", $badgeId);
        $this->set("badgeType", $badgeType);
        $this->_template->render();
    }

    public function records(int $badgeLinkCondId)
    {
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $page = ($page <= 0) ? 1 : $page;
        $srch = BadgeLinkCondition::getBadgeLinksSearchObj($this->adminLangId, true);
        /* Bind Records */
        $srch->joinProduct($this->adminLangId);
        $srch->joinSellerProduct($this->adminLangId);
        $srch->joinShop($this->adminLangId);
        /* Bind Records */
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        
        if (!empty($keyword)) {
            $srch->addHaving('record_name', 'LIKE', '%' . $keyword . '%');
        }

        $srch->addCondition('blinkcond_id', '=', $badgeLinkCondId);
        $srch->getResultSet();
        $result = FatApp::getDb()->fetchAll($srch->getResultSet());
        $records = [];
        foreach ($result as $badgeLink) {
            if (array_key_exists('badgelink_record_id', $badgeLink) && empty($badgeLink['badgelink_record_id'])) {
                break;
            }

            $recordId = $badgeLink['badgelink_record_id'];
            $recordName = $badgeLink['record_name'];
            $optionName = explode('|', $badgeLink['option_name']);
            $optionValueName = explode('|', $badgeLink['option_value_name']);
            $seller = $badgeLink['seller'];
            unset($badgeLink['badgelink_record_id'], $badgeLink['record_name'], $badgeLink['option_name'], $badgeLink['option_value_name'], $badgeLink['seller']);

            if (BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT == $badgeLink['blinkcond_record_type']) {
                $name = $recordName;
                if (isset($records[$recordId]['record_name'])) {
                    $name = $records[$recordId]['record_name'];
                }

                $option = '';
                foreach ($optionName as $index => $optname) {
                    $option .= !empty($optname) ? ' | ' .  $optname . ' : ' . (isset($optionValueName[$index]) ? $optionValueName[$index] : '') : '';
                }
                $recordName = $name . $option . ' | ' . $seller;
            }

            $records[$recordId] = [
                'badgelink_record_id' => $recordId,
                'record_name' => $recordName
            ];
        }

        $this->set('badgeLinkCondId', $badgeLinkCondId);
        $this->set('records', $records);
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('recordCount', $srch->recordCount());
        $this->set('pageCount', $srch->pages());
        $this->set('postedData', FatApp::getPostedData());
        $this->_template->render(false, false);
    }

    public function search()
    {
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        $badgeType = FatApp::getPostedData('badge_type');
        $searchForm = $this->getSearchForm($badgeType);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            FatUtility::dieJsonError(current($searchForm->getValidationErrors()));
        }

        $srch = BadgeLinkCondition::getBadgeLinksSearchObj($this->adminLangId);

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $badgeId = FatApp::getPostedData('blinkcond_badge_id', FatUtility::VAR_INT, 0);
        $srch->addCondition('blinkcond_badge_id', '=', $badgeId);

        if (!empty($badgeType)) {
            $srch->addHaving(Badge::DB_TBL_PREFIX . 'type', '=',  $badgeType);
        }

        $recordType = FatApp::getPostedData('blinkcond_record_type'); //Link Type
        if (!empty($recordType)) {
            $srch->addCondition(BadgeLinkCondition::DB_TBL_PREFIX . 'record_type', '=',  $recordType);
        }
        
        $position = FatApp::getPostedData('blinkcond_position');
        if (!empty($position)) {
            $srch->addCondition(BadgeLinkCondition::DB_TBL_PREFIX . 'position', '=',  $position);
        }

        $trigger = FatApp::getPostedData('record_condition'); //Trigger
        if (!empty($trigger)) {
            if (BadgeLinkCondition::REC_COND_AUTO == $trigger) {
                $srch->addHaving('badgelink_record_ids', 'IS', 'mysql_func_null', 'AND', true);
            } else {
                $srch->addHaving('badgelink_record_ids', 'IS NOT', 'mysql_func_null', 'AND', true);
            }
        }

        $conditionType = FatApp::getPostedData('blinkcond_condition_type');
        if (!empty($conditionType)) {
            $srch->addCondition(BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type', '=',  $conditionType);
        }
        $srch->addOrder(BadgeLinkCondition::DB_TBL_PREFIX . 'id', 'DESC');
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $this->set("canEdit", $this->objPrivilege->canEditBadgeLinks($this->admin_id, true));
        $this->set("badgeType", $badgeType);
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->_template->render(false, false);
    }

    public function form(int $badgeType, int $badgeId, int $badgeLinkCondId = 0)
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
                $optionName = explode('|', $badgeLink['option_name']);
                $optionValueName = explode('|', $badgeLink['option_value_name']);

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

                    $option = '';
                    foreach ($optionName as $index => $optname) {
                        $option .= !empty($optname) ? ' | ' .  $optname . ' : ' . (isset($optionValueName[$index]) ? $optionValueName[$index] : '') : '';
                    }
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

        if (Badge::TYPE_BADGE == $badgeType) {
            $frm = $this->getBadgeForm($recordCondition);
        } else if (Badge::TYPE_RIBBON == $badgeType) {
            $frm = $this->getRibbonForm($recordCondition);
        }

        $dataToFill['blinkcond_badge_id'] = $badgeId;
        $frm->fill($dataToFill);

        $position = array_key_exists('blinkcond_position', $dataToFill) ? $dataToFill['blinkcond_position'] : Badge::RIBB_POS_TRIGHT;
        $this->set('position', $position);
        $this->set('badgeData', $this->getBadgeData($badgeId));
        $this->set("canEdit", $this->objPrivilege->canEditBadgeLinks($this->admin_id, true));
        $this->set('frm', $frm);
        $this->set('badgeType', $badgeType);
        $this->set('badgeId', $badgeId);
        $this->set('rowData', $dataToFill);
        $this->set('blinkcond_id', $badgeLinkCondId);

        $this->_template->render(false, false);
    }

    private function getBadgeName(int $badgeId): string
    {
        $badgeSearch = new BadgeSearch($this->adminLangId);
        $badgeSearch->doNotCalculateRecords();
        $badgeSearch->addCondition('badge_id', '=', $badgeId);
        $badgeSearch->addMultipleFields(['badge_id', 'COALESCE(badge_name, badge_identifier) as badge_name']);
        $badgeSearch->getResultSet();
        $result = FatApp::getDb()->fetchAllAssoc($badgeSearch->getResultSet());
        return (string) current($result);
    }

    private function getBadgeData(int $badgeId): array
    {
        $badgeSearch = new BadgeSearch($this->adminLangId);
        $badgeSearch->doNotCalculateRecords();
        $badgeSearch->addCondition('badge_id', '=', $badgeId);
        $badgeSearch->addMultipleFields([
            'badge_id',
            'COALESCE(badge_name, badge_identifier) as badge_name',
            'badge_shape_type',
            'badge_color',
            'badge_display_inside',
        ]);
        $badgeSearch->getResultSet();
        return (array) FatApp::getDb()->fetch($badgeSearch->getResultSet());
    }

    public function conditionForm(int $badgeType, int $badgeId, int $badgeLinkCondId = 0)
    {
        $frmSearch = "";
        if (0 < $badgeLinkCondId) {
            $frmSearch = $this->getConditionForm();
            $frmSearch->fill(['blinkcond_id' => $badgeLinkCondId, 'blinkcond_badge_id' => $badgeId, 'badge_type' => $badgeType]);
        }

        $this->set('badgeName', $this->getBadgeName($badgeId));
        $this->set('badgeType', $badgeType);
        $this->set('badgeId', $badgeId);
        $this->set('badgeLinkCondId', $badgeLinkCondId);
        $this->set("canEdit", $this->objPrivilege->canEditBadgeLinks($this->admin_id, true));
        $this->set('frmSearch', $frmSearch);
        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->includeDateTimeFiles();
        $this->_template->render();
    }

    private function getConditionForm()
    {
        $frm = new Form('frmSearch');
        $frm->addHiddenField('', 'blinkcond_id');
        $frm->addHiddenField('', 'blinkcond_badge_id');
        $frm->addHiddenField('', 'badge_type');
        $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $this->adminLangId), 'keyword', '');

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    public function setup()
    {
        $this->objPrivilege->canEditBadgeLinks();

        $recordCondition = FatApp::getPostedData('record_condition', FatUtility::VAR_INT, 0);
        $conditionType = FatApp::getPostedData('blinkcond_condition_type', FatUtility::VAR_INT, 0);
        $badgeType = FatApp::getPostedData('badge_type', FatUtility::VAR_INT, 0);
        if (Badge::TYPE_BADGE == $badgeType) {
            $frm = $this->getBadgeForm($recordCondition);
        } else if (Badge::TYPE_RIBBON == $badgeType) {
            $frm = $this->getRibbonForm($recordCondition);
        }

        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $records = FatApp::getPostedData('record_ids', FatUtility::VAR_STRING, '');
        if (BadgeLinkCondition::REC_COND_MANUAL == $recordCondition) {
            if (empty($records)) {
                FatUtility::dieJsonError(Labels::getLabel('MSG_LINK_TO_IS_MANDATORY', $this->adminLangId));
            }
            $records = json_decode($records, true);
        }

        $fromDate = FatApp::getPostedData('blinkcond_from_date', FatUtility::VAR_STRING, '');
        $toDate = FatApp::getPostedData('blinkcond_to_date', FatUtility::VAR_STRING, '');

        if (!empty($fromDate) && !empty($toDate) && $fromDate > $toDate) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_TO_DATE_MUST_BE_GREATER_THAN_OR_EQUAL_TO_FROM_DATE', $this->adminLangId));
        }

        if (Badge::TYPE_BADGE == $badgeType) {
            if (BadgeLinkCondition::REC_COND_AUTO == $recordCondition) {
                $records = []; /* Records Binding Not Required. */

                $conditionType = FatApp::getPostedData('blinkcond_condition_type', FatUtility::VAR_INT, 0);
                switch ($conditionType) {
                    case BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS:
                    case BadgeLinkCondition::COND_TYPE_AVG_RATING_SELPROD:
                    case BadgeLinkCondition::COND_TYPE_AVG_RATING_SHOP:
                    case BadgeLinkCondition::COND_TYPE_ORDER_COMPLETION_RATE:
                        $type = (BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS == $conditionType) ? FatUtility::VAR_INT : FatUtility::VAR_FLOAT;
                        $fromCond = FatApp::getPostedData('blinkcond_from_value', $type, 0);
                        $toCond = FatApp::getPostedData('blinkcond_to_value', $type, 0);
                        $rateCondition = (BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS != $conditionType && 100 < $toCond);
                        if (1 > $fromCond || 1 > $toCond || $fromCond > $toCond || $rateCondition) {
                            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_CONDITION_FROM_OR_TO_VALUE', $this->adminLangId));
                        }
                        break;
                    case BadgeLinkCondition::COND_TYPE_RETURN_ACCEPTANCE:
                    case BadgeLinkCondition::COND_TYPE_ORDER_CANCELLED:
                        $rate = FatApp::getPostedData('blinkcond_from_value', FatUtility::VAR_FLOAT, 0);
                        if (0 > $rate || 100 < $rate) {
                            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_RATE_VALUE', $this->adminLangId));
                        }
                        $post['blinkcond_from_value'] = $rate;
                        break;

                    default:
                        FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_CONDITION_TYPE', $this->adminLangId));
                        break;
                }
            } else {
                unset(
                    $post['blinkcond_condition_type'],
                    $post['blinkcond_from_value'],
                    $post['blinkcond_to_value'],
                );
            }
        }

        $badgeLinkCondId = FatApp::getPostedData('blinkcond_id', FatUtility::VAR_INT, 0);
        $newRecord = (1 > $badgeLinkCondId);
        $record = new BadgeLinkCondition($badgeLinkCondId);
        $record->assignValues($post);
        if (!$record->save()) {
            FatUtility::dieJsonError($record->getError());
        }

        $badgeLinkCondId = $record->getMainTableRecordId();

        $recordType = FatApp::getPostedData('blinkcond_record_type', FatUtility::VAR_INT, 0);
        $badgeType = FatApp::getPostedData('badge_type', FatUtility::VAR_INT, 0);
        $position = FatApp::getPostedData('blinkcond_position', FatUtility::VAR_INT, 0);

        $msg = '';
        if (BadgeLinkCondition::REC_COND_MANUAL == $recordCondition && !empty($records)) {
            $db = FatApp::getDb();
            /* $db->deleteRecords(BadgeLinkCondition::DB_TBL_BADGE_LINKS, array(
                'smt' => 'badgelink_blinkcond_id = ?',
                'vals' => [$badgeLinkCondId]
            )); */
            foreach ($records as $recordId) {
                if (false === BadgeLinkCondition::isUnique($badgeType, $recordType, $recordId, $position)) {
                    if (empty($msg)) {
                        $msg = Labels::getLabel('MGS_UNABLE_TO_BIND_SOME_RECORDS._ALREADY_LINKED_WITH_OTHER_BADGE_LINK_RECORD', $this->adminLangId);
                    }
                    continue;
                }

                $linkData = array(
                    'badgelink_blinkcond_id' => $badgeLinkCondId,
                    'badgelink_record_id' => $recordId
                );
                $db->insertFromArray(BadgeLinkCondition::DB_TBL_BADGE_LINKS, $linkData);
            }
        }

        $msg = !empty($msg) ? $msg : ($newRecord ? Labels::getLabel('MGS_ADDED_SUCCESSFULLY', $this->adminLangId) : Labels::getLabel('MGS_UPDATED_SUCCESSFULLY', $this->adminLangId));

        $this->set('recordType', $recordType);
        $this->set('blinkcond_id', $badgeLinkCondId);
        $this->set('msg', $msg);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getSearchForm(int $badgeType)
    {
        $frm = new Form('frmSearch');
        $frm->addHiddenField('', 'blinkcond_badge_id');
        $frm->addHiddenField('', 'badge_type');

        $frm->addSelectBox(Labels::getLabel('LBL_LINK_TYPE', $this->adminLangId), 'blinkcond_record_type', BadgeLinkCondition::getRecordTypeArr($this->adminLangId));

        if (Badge::TYPE_BADGE == $badgeType) {
            $frm->addSelectBox(Labels::getLabel('LBL_TRIGGER', $this->adminLangId), 'record_condition', BadgeLinkCondition::getRecordConditionArr($this->adminLangId));
            $frm->addSelectBox(Labels::getLabel('LBL_CONDITION_TYPE', $this->adminLangId), 'blinkcond_condition_type', BadgeLinkCondition::getConditionTypesArr($this->adminLangId));
        } else {
            $frm->addSelectBox(Labels::getLabel('LBL_POSITION', $this->adminLangId), 'blinkcond_position', Badge::getRibbonPostionArr($this->adminLangId));
        }

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getCommonFields(int $recordCondition): object
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'blinkcond_id');
        $frm->addHiddenField('', 'blinkcond_badge_id');

        $selectedBadge = $recordIds = [];
        if (is_array($this->recordData) && 0 < count($this->recordData)) {
            if (isset($this->recordData['records'])) {
                $recordIds = array_unique(array_keys($this->recordData['records']));
            }
            $selectedBadge[$this->recordData['blinkcond_badge_id']] = $this->recordData['badge_name'];
        }
        $frm->addHiddenField('', 'record_ids', json_encode($recordIds));

        $frm->addTextBox(Labels::getLabel('LBL_FROM_DATE', $this->adminLangId), 'blinkcond_from_date', '', ['readonly' => 'readonly']);
        $frm->addTextBox(Labels::getLabel('LBL_TO_DATE', $this->adminLangId), 'blinkcond_to_date', '', ['readonly' => 'readonly']);

        $recordTypesArr = BadgeLinkCondition::getRecordTypeArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_LINK_TYPE', $this->adminLangId), 'blinkcond_record_type', $recordTypesArr);
        $fld->requirement->setRequired((BadgeLinkCondition::REC_COND_MANUAL == $recordCondition));

        $frm->addSelectBox(Labels::getLabel('LBL_LINK_TO', $this->adminLangId), 'badgelink_record_id', [], '', ['placeholder' => Labels::getLabel('LBL_SEARCH_RECORD', $this->adminLangId), 'class' => 'recordIds--js'], '');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE', $this->adminLangId));
        return $frm;
    }

    private function getBadgeForm(int $recordCondition)
    {
        $frm = $this->getCommonFields($recordCondition);
        $frm->addHiddenField('', 'badge_type', Badge::TYPE_BADGE);

        $recordConditionArr = BadgeLinkCondition::getRecordConditionArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_TRIGGER', $this->adminLangId), 'record_condition', $recordConditionArr, '', [], '');
        $fld->requirement->setRequired(true);

        $conditionTypesArr = BadgeLinkCondition::getConditionTypesArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_CONDITION_TYPE', $this->adminLangId), 'blinkcond_condition_type', $conditionTypesArr);
        $fld->requirement->setRequired((BadgeLinkCondition::REC_COND_AUTO == $recordCondition));

        $fld = $frm->addTextBox(Labels::getLabel('LBL_FROM', $this->adminLangId), 'blinkcond_from_value');
        $fld->requirement->setRequired((BadgeLinkCondition::REC_COND_AUTO == $recordCondition));

        $frm->addTextBox(Labels::getLabel('LBL_TO', $this->adminLangId), 'blinkcond_to_value');

        return $frm;
    }

    private function getRibbonForm(int $recordCondition)
    {
        $frm = $this->getCommonFields($recordCondition);
        $frm->addHiddenField('', 'badge_type', Badge::TYPE_RIBBON);
        $frm->addHiddenField('', 'record_condition', BadgeLinkCondition::REC_COND_MANUAL);

        $positionArr = Badge::getRibbonPostionArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_POSITION', $this->adminLangId), 'blinkcond_position', $positionArr, '', [], '');

        return $frm;
    }

    public function badgeUnlink()
    {
        $this->objPrivilege->canEditBadgeLinks();
        $blinkcond_id = FatApp::getPostedData('blinkcond_id', FatUtility::VAR_INT, 0);

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
        $this->removeLinkRecord($blinkcond_id);
    }

    public function unlinkRecord(int $blinkcond_id, int $record_id)
    {
        if (1 > $record_id) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_RECORD', $this->adminLangId));
        }
        $this->removeLinkRecord($blinkcond_id, $record_id);
    }

    private function removeLinkRecord(int $blinkcond_id, int $record_id = 0)
    {
        if (1 > $blinkcond_id) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId));
        }
        $smt = 'badgelink_blinkcond_id = ?';
        $vals = [$blinkcond_id];
        if (0 < $record_id) {
            $smt .= ' AND badgelink_record_id = ?';
            $vals[] = $record_id;
        }

        $db = FatApp::getDb();
        if (!$db->deleteRecords(
            BadgeLinkCondition::DB_TBL_BADGE_LINKS,
            [
                'smt' => $smt,
                'vals' => $vals
            ]
        )) {
            FatUtility::dieJsonError($db->getError());
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_SUCCESS', $this->adminLangId));
    }

    public function isUnique(int $badgeType, int $recordType, int $record_id, int $position = 0)
    {
        if (false === BadgeLinkCondition::isUnique($badgeType, $recordType, $record_id, $position)) {
            $msg = Labels::getLabel('MSG_THIS_RECORD_IS_LINKED_WITH_OTHER_BADGE_LINK_RECORD_WITH_SAME_POSITION.', $this->adminLangId);
            FatUtility::dieJsonError($msg);
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_UNIQUE', $this->adminLangId));
    }

    public function linkRecord(int $badgeType, int $blinkcond_id, int $record_id, int $position = 0)
    {
        if (1 > $blinkcond_id || 1 > $record_id) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_RECORD', $this->adminLangId));
        }

        $recordType = BadgeLinkCondition::getAttributesById($blinkcond_id, 'blinkcond_record_type');

        if (false === BadgeLinkCondition::isUnique($badgeType, $recordType, $record_id, $position)) {
            $msg = Labels::getLabel('MSG_THIS_RECORD_IS_LINKED_WITH_OTHER_BADGE_LINK_RECORD', $this->adminLangId);
            FatUtility::dieJsonError($msg);
        }

        $linkData = array(
            'badgelink_blinkcond_id' => $blinkcond_id,
            'badgelink_record_id' => $record_id
        );
        $db = FatApp::getDb();
        if (!$db->insertFromArray(BadgeLinkCondition::DB_TBL_BADGE_LINKS, $linkData)) {
            FatUtility::dieJsonError($db->getError());
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_SUCCESS', $this->adminLangId));
    }

    public function getRecordType(int $blinkcond_id)
    {
        $json = [
            'recordType' => (int) BadgeLinkCondition::getAttributesById($blinkcond_id, 'blinkcond_record_type')
        ];

        FatUtility::dieJsonSuccess($json);
    }
}
