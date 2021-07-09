<?php

class BadgeLinkConditionsController extends SellerBaseController
{
    private $recordData = [];
    private $badgeLinkCondId = 0;

    public function __construct($action)
    {
        parent::__construct($action);

        $this->userPrivilege->canViewBadgeLinks(UserAuthentication::getLoggedUserId());
    }

    public function list(int $badgeId, int $badgeType)
    {
        $conditionType = Badge::getAttributesById($badgeId, 'badge_condition_type');
        $frmSearch = $this->getSearchForm($badgeType, $conditionType);
        $frmSearch->fill(['blinkcond_badge_id' => $badgeId, 'badge_type' => $badgeType]);
        $this->set("canEdit", $this->userPrivilege->canEditBadgeLinks(UserAuthentication::getLoggedUserId(), true));

        $this->set('conditionType', $conditionType);
        $this->set('badgeName', $this->getBadgeName($badgeId));
        $this->set("frmSearch", $frmSearch);
        $this->set("badgeId", $badgeId);
        $this->set("badgeType", $badgeType);
        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('custom/page-css/select2.min.css'));
        $this->_template->render();
    }

    public function records(int $badgeLinkCondId)
    {
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        $keyword = FatApp::getPostedData('keyword', FatUtility::VAR_STRING, '');
        $page = ($page <= 0) ? 1 : $page;
        $srch = BadgeLinkCondition::getBadgeLinksSearchObj($this->siteLangId, true);
        /* Bind Records */
        $srch->joinProduct($this->siteLangId);
        $srch->joinSellerProduct($this->siteLangId);
        $srch->joinShop($this->siteLangId);
        /* Bind Records */
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        if (!empty($keyword)) {
            $srch->addHaving('record_name', 'LIKE', '%' . $keyword . '%');
        }

        $srch->addCondition('blinkcond_id', '=', $badgeLinkCondId);
        $srch->getResultSet();
        $srch->addHaving('seller_id', '=', UserAuthentication::getLoggedUserId());
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
        $badgeId = FatApp::getPostedData('blinkcond_badge_id', FatUtility::VAR_INT, 0);
        if (1 > $badgeId) {
            $msg = (Badge::TYPE_BADGE == $badgeType) ? Labels::getLabel('MSG_INVALID_BADGE', $this->siteLangId) : Labels::getLabel('MSG_INVALID_RIBBON', $this->siteLangId);
            FatUtility::dieJsonError($msg);
        }
        $badgeConditionType = Badge::getAttributesById($badgeId, 'badge_condition_type');

        $searchForm = $this->getSearchForm($badgeType, $badgeConditionType);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 0);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            FatUtility::dieJsonError(current($searchForm->getValidationErrors()));
        }

        $srch = BadgeLinkCondition::getBadgeLinksSearchObj($this->siteLangId);
        $srch->joinUser();
        $srch->joinTable(BadgeRequest::DB_TBL, 'LEFT JOIN', 'breq_blinkcond_id = blinkcond_id');

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $srch->addCondition('blinkcond_badge_id', '=', $badgeId);

        if (!empty($badgeType)) {
            $srch->addCondition(Badge::DB_TBL_PREFIX . 'type', '=',  $badgeType);
        }

        $cnd = $srch->addCondition(BadgeLinkCondition::DB_TBL_PREFIX . 'user_id', '=', UserAuthentication::getLoggedUserId());
        $cnd->attachCondition(Badge::DB_TBL_PREFIX . 'condition_type', '=', Badge::COND_AUTO);

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
            $srch->addCondition('badge_condition_type', '=', $trigger);
        }

        $conditionType = FatApp::getPostedData('blinkcond_condition_type');
        if (!empty($conditionType)) {
            $srch->addCondition(BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type', '=',  $conditionType);
        }

        $srch->addDirectCondition("(
            CASE 
                WHEN breq_id IS NOT NULL
                THEN breq_status = " . BadgeRequest::REQUEST_APPROVED . "
                ELSE TRUE
            END
        )");

        $srch->addOrder(BadgeLinkCondition::DB_TBL_PREFIX . 'id', 'DESC');
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $recordCondition = Badge::getAttributesById($badgeId, 'badge_condition_type');
        $this->set('recordCondition', $recordCondition);
        $this->set('badgeConditionType', $badgeConditionType);
        $this->set("canEdit", $this->userPrivilege->canEditBadgeLinks(UserAuthentication::getLoggedUserId(), true));
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
        $this->userPrivilege->canEditBadgeLinks();
        $this->badgeLinkCondId = $badgeLinkCondId;
        
        $dataToFill = [];
        $recordCondition = BadgeLinkCondition::REC_COND_AUTO;

        if ($this->badgeLinkCondId > 0) {
            $srch = BadgeLinkCondition::getBadgeLinksSearchObj($this->siteLangId, true);
            $srch->addCondition('blinkcond_id', '=', $this->badgeLinkCondId);

            /* Bind Records */
            $srch->joinProduct($this->siteLangId);
            $srch->joinSellerProduct($this->siteLangId);
            $srch->joinShop($this->siteLangId);
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

        }

        $recordCondition = Badge::getAttributesById($badgeId, 'badge_condition_type');

        if (Badge::TYPE_BADGE == $badgeType) {
            $frm = $this->getBadgeForm($recordCondition);
        } else if (Badge::TYPE_RIBBON == $badgeType) {
            $frm = $this->getRibbonForm($recordCondition);
        }

        $dataToFill['record_condition'] = $recordCondition;
        $dataToFill['blinkcond_badge_id'] = $badgeId;
        $frm->fill($dataToFill);

        $position = array_key_exists('blinkcond_position', $dataToFill) ? $dataToFill['blinkcond_position'] : Badge::RIBB_POS_TRIGHT;
        $this->set('position', $position);
        $this->set('recordCondition', $recordCondition);
        $this->set('badgeData', $this->getBadgeData($badgeId));
        $this->set("canEdit", $this->userPrivilege->canEditBadgeLinks(UserAuthentication::getLoggedUserId(), true));
        $this->set('frm', $frm);
        $this->set('badgeType', $badgeType);
        $this->set('badgeId', $badgeId);
        $this->set('rowData', $dataToFill);
        $this->set('blinkcond_id', $this->badgeLinkCondId);

        $this->_template->render(false, false);
    }

    private function getBadgeName(int $badgeId): string
    {
        $badgeSearch = new BadgeSearch($this->siteLangId);
        $badgeSearch->doNotCalculateRecords();
        $badgeSearch->addCondition('badge_id', '=', $badgeId);
        $badgeSearch->addMultipleFields(['badge_id', 'COALESCE(badge_name, badge_identifier) as badge_name']);
        $badgeSearch->getResultSet();
        $result = FatApp::getDb()->fetchAllAssoc($badgeSearch->getResultSet());
        return (string) current($result);
    }

    private function getBadgeData(int $badgeId): array
    {
        $badgeSearch = new BadgeSearch($this->siteLangId);
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
        if (Badge::TYPE_BADGE == $badgeType && 1 > Badge::canAccess($badgeId, UserAuthentication::getLoggedUserId())) {
            Message::addErrorMessage(Labels::getLabel('MSG_ACCESS_RESTRICTED', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Badges', 'list', [Badge::TYPE_BADGE]));
        }

        $frmSearch = "";
        if (0 < $badgeLinkCondId) {
            $frmSearch = $this->getSearchConditionForm();
            $frmSearch->fill(['blinkcond_id' => $badgeLinkCondId, 'blinkcond_badge_id' => $badgeId, 'badge_type' => $badgeType]);
        }

        $this->set('badgeName', $this->getBadgeName($badgeId));
        $this->set('badgeType', $badgeType);
        $this->set('badgeId', $badgeId);
        $this->set('badgeLinkCondId', $badgeLinkCondId);
        $this->set("canEdit", $this->userPrivilege->canEditBadgeLinks(UserAuthentication::getLoggedUserId(), true));
        $this->set('frmSearch', $frmSearch);

        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('custom/page-css/select2.min.css'));
        $this->includeDateTimeFiles();
        $this->_template->render();
    }

    private function getSearchConditionForm()
    {
        $frm = new Form('frmSearch');
        $frm->addHiddenField('', 'blinkcond_id');
        $frm->addHiddenField('', 'blinkcond_badge_id');
        $frm->addHiddenField('', 'badge_type');
        $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $this->siteLangId), 'keyword', '');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->siteLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->siteLangId));
        return $frm;
    }

    public function setup()
    {
        $this->userPrivilege->canEditBadgeLinks();

        $recordCondition = FatApp::getPostedData('record_condition', FatUtility::VAR_INT, 0);
        $badgeType = FatApp::getPostedData('badge_type', FatUtility::VAR_INT, 0);
        $badgeLinkCondId = FatApp::getPostedData('blinkcond_id', FatUtility::VAR_INT, 0);
        $position = FatApp::getPostedData('blinkcond_position', FatUtility::VAR_INT, 0);
        if (Badge::TYPE_BADGE == $badgeType) {
            $frm = $this->getBadgeForm($recordCondition);
        } else if (Badge::TYPE_RIBBON == $badgeType) {
            $frm = $this->getRibbonForm($recordCondition);
        }

        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $recordType = FatApp::getPostedData('blinkcond_record_type', FatUtility::VAR_INT, 0);
        $records = FatApp::getPostedData('record_ids', FatUtility::VAR_STRING, '');

        if (BadgeLinkCondition::REC_COND_MANUAL == $recordCondition) {
            if (empty($records)) {
                FatUtility::dieJsonError(Labels::getLabel('MSG_LINK_TO_IS_MANDATORY', $this->siteLangId));
            }
            $records = json_decode($records, true);
        }

        $fromDate = FatApp::getPostedData('blinkcond_from_date', FatUtility::VAR_STRING, '');
        $toDate = FatApp::getPostedData('blinkcond_to_date', FatUtility::VAR_STRING, '');

        if (!empty($fromDate) && !empty($toDate) && $fromDate > $toDate) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_TO_DATE_MUST_BE_GREATER_THAN_OR_EQUAL_TO_FROM_DATE', $this->siteLangId));
        }

        $userId = UserAuthentication::getLoggedUserId();
        $badgeId = FatApp::getPostedData('blinkcond_badge_id', FatUtility::VAR_INT, 0);
        if (false === BadgeLinkCondition::isUnique($badgeId, $userId, $recordType, $position, $badgeLinkCondId)) {
            $msg = Labels::getLabel('MSG_BADGE_CONDITION_ALREADY_BOUND_FOR_SAME_LINK_TYPE.', $this->siteLangId);
            if (Badge::TYPE_RIBBON == $badgeType) {
                $msg = Labels::getLabel('MSG_RIBBON_CONDITION_ALREADY_BOUND_FOR_SAME_LINK_TYPE_AND_SAME_POSITION.', $this->siteLangId);
            }
            FatUtility::dieJsonError($msg);
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
                        $fromCond = FatApp::getPostedData('blinkcond_condition_from', $type, 0);
                        $toCond = FatApp::getPostedData('blinkcond_condition_to', $type, 0);
                        $rateCondition = (BadgeLinkCondition::COND_TYPE_COMPLETED_ORDERS != $conditionType && 100 < $toCond);
                        if (1 > $fromCond || 1 > $toCond || $fromCond > $toCond || $rateCondition) {
                            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_CONDITION_FROM_OR_TO_VALUE', $this->siteLangId));
                        }
                        break;
                    case BadgeLinkCondition::COND_TYPE_RETURN_ACCEPTANCE:
                    case BadgeLinkCondition::COND_TYPE_ORDER_CANCELLED:
                        $rate = FatApp::getPostedData('blinkcond_condition_from', FatUtility::VAR_FLOAT, 0);
                        if (0 > $rate || 100 < $rate) {
                            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_RATE_VALUE', $this->siteLangId));
                        }
                        $post['blinkcond_condition_from'] = $rate;
                        break;

                    default:
                        FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_CONDITION_TYPE', $this->siteLangId));
                        break;
                }
            } else {
                unset(
                    $post['blinkcond_condition_type'],
                    $post['blinkcond_condition_from'],
                    $post['blinkcond_condition_to'],
                );
            }
        }

        $newRecord = (1 > $badgeLinkCondId);
        $post['blinkcond_user_id'] = UserAuthentication::getLoggedUserId();

        $record = new BadgeLinkCondition($badgeLinkCondId);
        $record->assignValues($post);
        if (!$record->save()) {
            FatUtility::dieJsonError($record->getError());
        }

        $badgeLinkCondId = $record->getMainTableRecordId();

        $msg = '';
        if (BadgeLinkCondition::REC_COND_MANUAL == $recordCondition && !empty($records)) {
            $db = FatApp::getDb();
            foreach ($records as $recordId) {
                $linkData = array(
                    'badgelink_blinkcond_id' => $badgeLinkCondId,
                    'badgelink_record_id' => $recordId
                );
                $db->insertFromArray(BadgeLinkCondition::DB_TBL_BADGE_LINKS, $linkData);
            }
        }

        $msg = !empty($msg) ? $msg : ($newRecord ? Labels::getLabel('MGS_ADDED_SUCCESSFULLY', $this->siteLangId) : Labels::getLabel('MGS_UPDATED_SUCCESSFULLY', $this->siteLangId));

        $this->set('recordType', $recordType);
        $this->set('blinkcond_id', $badgeLinkCondId);
        $this->set('msg', $msg);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getSearchForm(int $badgeType, int $conditionType)
    {
        $frm = new Form('frmSearch');
        $frm->addHiddenField('', 'blinkcond_badge_id');
        $frm->addHiddenField('', 'badge_type');
        $frm->addHiddenField('', 'record_condition', $conditionType);
        if (Badge::COND_MANUAL == $conditionType) {
            $frm->addSelectBox(Labels::getLabel('LBL_LINK_TYPE', $this->siteLangId), 'blinkcond_record_type', BadgeLinkCondition::getRecordTypeArr($this->siteLangId));
        } else {
            $frm->addSelectBox(Labels::getLabel('LBL_CONDITION', $this->siteLangId), 'blinkcond_condition_type', BadgeLinkCondition::getConditionTypesArr($this->siteLangId));
        }

        if (Badge::TYPE_RIBBON == $badgeType) {
            $frm->addSelectBox(Labels::getLabel('LBL_POSITION', $this->siteLangId), 'blinkcond_position', Badge::getRibbonPostionArr($this->siteLangId));
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->siteLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->siteLangId));
        return $frm;
    }

    private function getCommonFields(int $recordCondition): object
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'blinkcond_id');
        $frm->addHiddenField('', 'blinkcond_badge_id');
        $frm->addHiddenField('', 'record_condition');
        if (0 < $this->badgeLinkCondId) {
            $frm->addHiddenField('', 'blinkcond_record_type');
        }

        $selectedBadge = $recordIds = [];
        if (is_array($this->recordData) && 0 < count($this->recordData)) {
            if (isset($this->recordData['records'])) {
                $recordIds = array_unique(array_keys($this->recordData['records']));
            }
            $selectedBadge[$this->recordData['blinkcond_badge_id']] = $this->recordData['badge_name'];
        }
        $frm->addHiddenField('', 'record_ids', json_encode($recordIds));

        $frm->addTextBox(Labels::getLabel('LBL_FROM_DATE', $this->siteLangId), 'blinkcond_from_date', '', ['readonly' => 'readonly']);
        $frm->addTextBox(Labels::getLabel('LBL_TO_DATE', $this->siteLangId), 'blinkcond_to_date', '', ['readonly' => 'readonly']);
        
        if (1 > $this->badgeLinkCondId) {
            $recordTypesArr = BadgeLinkCondition::getRecordTypeArr($this->siteLangId);
            $fld = $frm->addSelectBox(Labels::getLabel('LBL_LINK_TYPE', $this->siteLangId), 'blinkcond_record_type', $recordTypesArr);
            $fld->requirement->setRequired((BadgeLinkCondition::REC_COND_MANUAL == $recordCondition));
        }

        $frm->addSelectBox(Labels::getLabel('LBL_LINK_TO', $this->siteLangId), 'badgelink_record_id', [], '', ['placeholder' => Labels::getLabel('LBL_SEARCH_RECORD', $this->siteLangId), 'class' => 'recordIds--js'], '');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE', $this->siteLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->siteLangId));
        return $frm;
    }

    private function getBadgeForm(int $recordCondition)
    {
        $frm = $this->getCommonFields($recordCondition);
        $frm->addHiddenField('', 'badge_type', Badge::TYPE_BADGE);

        $conditionTypesArr = BadgeLinkCondition::getConditionTypesArr($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_CONDITION_TYPE', $this->siteLangId), 'blinkcond_condition_type', $conditionTypesArr);
        $fld->requirement->setRequired((BadgeLinkCondition::REC_COND_AUTO == $recordCondition));

        $fld = $frm->addTextBox(Labels::getLabel('LBL_FROM', $this->siteLangId), 'blinkcond_condition_from');
        $fld->requirement->setRequired((BadgeLinkCondition::REC_COND_AUTO == $recordCondition));

        $frm->addTextBox(Labels::getLabel('LBL_TO', $this->siteLangId), 'blinkcond_condition_to');
        return $frm;
    }

    private function getRibbonForm(int $recordCondition)
    {
        $frm = $this->getCommonFields($recordCondition);
        $frm->addHiddenField('', 'badge_type', Badge::TYPE_RIBBON);

        $positionArr = Badge::getRibbonPostionArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_POSITION', $this->siteLangId), 'blinkcond_position', $positionArr, '', [], '');

        return $frm;
    }

    public function unlinkRecord(int $blinkcond_id, int $record_id)
    {
        if (1 > $record_id) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_RECORD', $this->siteLangId));
        }
        $this->removeLinkRecord($blinkcond_id, $record_id);
    }

    private function removeLinkRecord(int $blinkcond_id, int $record_id = 0)
    {
        if (1 > $blinkcond_id) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
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
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_SUCCESS', $this->siteLangId));
    }

    public function linkRecord(int $badgeType, int $blinkcond_id, int $record_id, int $position = 0)
    {
        if (1 > $blinkcond_id || 1 > $record_id) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_RECORD', $this->siteLangId));
        }

        $recordType = BadgeLinkCondition::getAttributesById($blinkcond_id, 'blinkcond_record_type');
        $linkData = array(
            'badgelink_blinkcond_id' => $blinkcond_id,
            'badgelink_record_id' => $record_id
        );
        $db = FatApp::getDb();
        if (!$db->insertFromArray(BadgeLinkCondition::DB_TBL_BADGE_LINKS, $linkData)) {
            FatUtility::dieJsonError($db->getError());
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_SUCCESS', $this->siteLangId));
    }

    public function getRecordType(int $blinkcond_id)
    {
        $json = [
            'recordType' => (int) BadgeLinkCondition::getAttributesById($blinkcond_id, 'blinkcond_record_type')
        ];

        FatUtility::dieJsonSuccess($json);
    }
}
