<?php

class BadgeLinksController extends AdminBaseController
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

        $this->_template->addJs(array('js/select2.js'));
        $this->_template->addCss(array('css/select2.min.css'));
        $this->includeDateTimeFiles();
        $this->_template->render();
    }

    public function bindRecordSet(array $linksResult)
    {
        if (false == $linksResult || empty($linksResult)) {
            return [];
        }

        $isMultiDimensional = (count(array_filter($linksResult, 'is_array')) > 0);
        $linksResult = $isMultiDimensional ? $linksResult : [$linksResult];

        foreach ($linksResult as &$record) {
            if (empty($record['badgelink_record_ids'])) {
                continue;
            }
            $recordIdsArr = json_decode($record['badgelink_record_ids'], true);
            switch ($record['badgelink_record_type']) {
                case BadgeLink::RECORD_TYPE_PRODUCT:
                    $obj = Product::getSearchObject($this->adminLangId);
                    $obj->addMultipleFields([
                        'GROUP_CONCAT(product_id) as badgelink_record_ids',
                        'GROUP_CONCAT(COALESCE( tp_l.product_name, tp.product_identifier ) SEPARATOR ", ") as record_names'
                    ]);
                    $obj->addCondition('product_id', 'IN', $recordIdsArr);
                    $result = FatApp::getDb()->fetch($obj->getResultSet());
                    $record = array_merge($record, $result);
                    break;
                case BadgeLink::RECORD_TYPE_SELLER_PRODUCT:
                    $obj = SellerProduct::getSearchObject($this->adminLangId);
                    $obj->addMultipleFields([
                        'GROUP_CONCAT(selprod_id) as badgelink_record_ids',
                        'GROUP_CONCAT(selprod_title SEPARATOR ", ") as record_names',
                        'GROUP_CONCAT( option_name ) as option_names',
                        'GROUP_CONCAT( optionvalue_name ) as option_value_names',
                        'spu.credential_username as seller',
                    ]);
                    $obj->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'spu.credential_user_id = sp.selprod_user_id', 'spu');
                    $obj->joinTable(SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, 'LEFT JOIN', 'selprod_id = selprodoption_selprod_id', 'spo');
                    $obj->joinTable(OptionValue::DB_TBL, 'LEFT JOIN', 'selprodoption_optionvalue_id = optionvalue_id', 'optv');
                    $obj->joinTable(Option::DB_TBL, 'LEFT JOIN', 'optionvalue_option_id = option_id', 'opt');
                    $obj->joinTable(Option::DB_TBL_LANG, 'LEFT JOIN', 'option_id = optionlang_option_id AND optionlang_lang_id = ' . $this->adminLangId, 'opt_l');
                    $obj->joinTable(OptionValue::DB_TBL_LANG, 'LEFT JOIN', 'optionvaluelang_optionvalue_id = optionvalue_id AND optionvaluelang_lang_id = ' . $this->adminLangId, 'optv_l');
                    $obj->addCondition('selprod_id', 'IN', $recordIdsArr);
                    $result = FatApp::getDb()->fetch($obj->getResultSet());
                    $record = array_merge($record, $result);
                    break;
                case BadgeLink::RECORD_TYPE_SHOP:
                    $obj = Shop::getSearchObject(false, $this->adminLangId);
                    $obj->addMultipleFields([
                        'GROUP_CONCAT(shop_id) as badgelink_record_ids',
                        'GROUP_CONCAT(COALESCE( s_l.shop_name, s.shop_identifier ) SEPARATOR ", ") as record_names'
                    ]);
                    $obj->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'shpu.credential_user_id = s.shop_user_id', 'shpu');
                    $obj->addCondition('shop_id', 'IN', $recordIdsArr);
                    $result = FatApp::getDb()->fetch($obj->getResultSet());
                    $record = array_merge($record, $result);
                    break;
            }
        }

        return $isMultiDimensional ? $linksResult : current($linksResult);
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

        $srch = BadgeLink::getBadgeLinksSearchObj($this->adminLangId);

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

        $recordType = $post['badgelink_record_type']; //Link Type
        if (!empty($recordType)) {
            $srch->addRecordTypesCondition([$recordType]);
        }

        $trigger = $post['record_condition']; //Trigger
        if (!empty($trigger)) {
            if (BadgeLink::REC_COND_AUTO == $trigger) {
                $srch->addCondition('badgelink_record_ids', '=', '');
            } else {
                $srch->addCondition('badgelink_record_ids', '!=', '');
            }
        }

        $conditionType = $post['badgelink_condition_type'];
        if (!empty($conditionType)) {
            $srch->addConditionTypesCondition([$conditionType]);
        }
        $records = $this->bindRecordSet(FatApp::getDb()->fetchAll($srch->getResultSet()));

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

        $dataToFill = [];
        $recordCondition = BadgeLink::REC_COND_AUTO;
        if ($badgeLinkId > 0) {
            $srch = BadgeLink::getBadgeLinksSearchObj($this->adminLangId);
            $srch->addCondition('badgelink_id', '=', $badgeLinkId);
            $dataToFill = $this->bindRecordSet(FatApp::getDb()->fetch($srch->getResultSet()));
            $this->recordData = $dataToFill;
            $recordCondition = BadgeLink::REC_COND_MANUAL;
            if (empty($dataToFill['badgelink_record_ids'])) {
                $recordCondition = BadgeLink::REC_COND_AUTO;
            }
            $dataToFill['record_condition'] = $recordCondition;
        }
        $frm = $this->getForm($recordCondition);
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

        $recordCondition = FatApp::getPostedData('record_condition', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordCondition);
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

        $frm->addSelectBox(Labels::getLabel('LBL_TYPE', $this->adminLangId), 'badge_type', Badge::getTypeArr($this->adminLangId));

        $frm->addSelectBox(Labels::getLabel('LBL_LINK_TYPE', $this->adminLangId), 'badgelink_record_type', BadgeLink::getRecordTypeArr($this->adminLangId));
        
        $frm->addSelectBox(Labels::getLabel('LBL_TRIGGER', $this->adminLangId), 'record_condition', BadgeLink::getRecordConditionArr($this->adminLangId));
        
        $frm->addSelectBox(Labels::getLabel('LBL_CONDITION_TYPE', $this->adminLangId), 'badgelink_condition_type', BadgeLink::getConditionTypesArr($this->adminLangId));

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getForm(int $recordCondition)
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'badgelink_id');
        $frm->addHiddenField('', 'badgelink_badge_id');
        $frm->addHiddenField('', 'badgelink_record_ids');

        $selectedRecords = $selectedBadge = $recordIds = [];
        $badgeId = '';
        if (is_array($this->recordData) && 0 < count($this->recordData) && isset($this->recordData['badgelink_record_ids'])) {
            $recordNames = explode(", ", $this->recordData['record_names']);
            $recordIds = explode(",", $this->recordData['badgelink_record_ids']);
            foreach ($recordIds as $index => $recordId) {
                $recordName = $recordNames[$index];
                if (BadgeLink::RECORD_TYPE_SELLER_PRODUCT == $this->recordData['badgelink_record_type'] && !empty($this->recordData['option_names'])) {
                    foreach (explode(',', $this->recordData['option_names']) as $index => $optionName) {
                        $optionValues = explode(',', $this->recordData['option_value_names']);
                        $recordName .= ' | ' . $optionName . ' : ' . $optionValues[$index];
                    }
                    $recordName .= ' | ' . $this->recordData['seller'];
                }
                $selectedRecords[$recordId] = $recordName;
            }
            $selectedBadge[$this->recordData['badgelink_badge_id']] = $this->recordData['badge_name'];
            $badgeId = $this->recordData['badgelink_badge_id'];
        }

        $typesArr = Badge::getTypeArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_BADGE_OR_RIBBON', $this->adminLangId), 'badge_type', $typesArr, '', [], '');

        $fld = $frm->addSelectBox(Labels::getLabel('LBL_NAME', $this->adminLangId), 'badge_name', $selectedBadge, $badgeId, ['placeholder' => Labels::getLabel('LBL_SEARCH...', $this->adminLangId)], '');
        $fld->requirement->setRequired(true);

        $recordCondition = BadgeLink::getRecordConditionArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_TRIGGER', $this->adminLangId), 'record_condition', $recordCondition, '', [], '');
        $fld->requirement->setRequired(true);

        $recordTypesArr = BadgeLink::getRecordTypeArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_LINK_TYPE', $this->adminLangId), 'badgelink_record_type', $recordTypesArr, '', [], '');
        $fld->requirement->setRequired(true);

        $conditionTypesArr = BadgeLink::getConditionTypesArr($this->adminLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('LBL_CONDITION_TYPE', $this->adminLangId), 'badgelink_condition_type', $conditionTypesArr);
        $fld->requirement->setRequired(true);

        $frm->addRequiredField(Labels::getLabel('LBL_CONDITION_FROM', $this->adminLangId), 'badgelink_condition_from');
        $frm->addRequiredField(Labels::getLabel('LBL_CONDITION_TO', $this->adminLangId), 'badgelink_condition_to');

        $fld = $frm->addSelectBox(Labels::getLabel('LBL_LINK_TO', $this->adminLangId), 'record_name', $selectedRecords, $recordIds, ['placeholder' => Labels::getLabel('LBL_SEARCH_RECORD', $this->adminLangId), 'multiple' => 'multiple'], '');
        if (BadgeLink::REC_COND_MANUAL == $recordCondition) {
            $fld->requirement->setRequired(true);
        }

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
