<?php

class BadgeLinkConditionsController extends ListingBaseController
{
    protected string $pageKey = 'MANAGE_BADGES';

    private array $recordData = [];
    private array $badgeData = [];
    private int $badgeLinkCondId = 0;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBadgeLinks();
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
            $this->set("canEdit", $this->objPrivilege->canEditBadgeLinks($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditBadgeLinks();
        }
    }

    private function validateBadge(int $badgeId)
    {
        if (1 > $badgeId) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_BADGE', $this->siteLangId), false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('Badges'));
        }

        $this->badgeData = $this->getBadgeData($badgeId);
        if (!$this->badgeData || Badge::TYPE_BADGE != $this->badgeData['badge_type']) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_BADGE', $this->siteLangId), false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('Badges'));
        }
    }

    public function index(int $badgeId)
    {
        $this->validateBadge($badgeId);
        FatApp::redirectUser(UrlHelper::generateUrl('Badges', 'list', [$badgeId]));
    }

    public function list(int $badgeId)
    {
        $this->getListingData($badgeId);
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields, $this->badgeData['badge_condition_type']);
        $frmSearch->fill(['blinkcond_badge_id' => $badgeId]);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $str = Labels::getLabel('LBL_{BADGE-NAME}_BADGE_CONDITIONS', $this->siteLangId);
        $pageTitle = CommonHelper::replaceStringData($str, ['{BADGE-NAME}' => $this->badgeData['badge_name']]);

        $pageTitle = $pageData['plang_title'] ?? $pageTitle;

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['formAction'] = 'deleteSelected';
        $actionItemsData['newRecordBtnAttrs'] = [
            'attr' => [
                'onclick' => 'editConditionRecord(' . $badgeId . ', 0, ' . (int)(Badge::COND_AUTO == $this->badgeData['badge_condition_type']) . ')'
            ]
        ];

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());


        $this->_template->addJs(['js/select2.js', 'js/tagify.min.js', 'js/tagify.polyfills.min.js', 'badge-link-conditions/page-js/list.js']);
        $this->_template->addCss(['css/select2.min.css']);

        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'badge-link-conditions/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData($badgeId = 0)
    {
        $badgeId = FatApp::getPostedData('blinkcond_badge_id', FatUtility::VAR_INT, $badgeId);
        $this->validateBadge($badgeId);
        $this->checkEditPrivilege(true);

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        if (Badge::COND_AUTO == $this->badgeData['badge_condition_type']) {
            unset($fields['cond_seller_name'], 
                $fields[BadgeLinkCondition::DB_TBL_PREFIX . 'record_type']);
        } else {
            unset($fields[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type'], 
                $fields[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_from'], 
                $fields[BadgeLinkCondition::DB_TBL_PREFIX . 'condition_to']);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING), applicationConstants::SORT_DESC);

        $srchFrm = $this->getSearchForm($fields);

        $postedData = FatApp::getPostedData();
        $post = $srchFrm->getFormDataFromArray($postedData);
        $post['blinkcond_badge_id'] = $badgeId;

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = BadgeLinkCondition::getBadgeLinksSearchObj($this->siteLangId);
        $srch->joinTable(Shop::DB_TBL, 'LEFT JOIN', 'blnku.user_id = shp.shop_user_id', 'shp');
        $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT JOIN', 'shp.shop_id = shp_l.shoplang_shop_id AND shp_l.shoplang_lang_id = ' . $this->siteLangId, 'shp_l');
        $srch->addFld('shop_id, COALESCE(shp_l.shop_name, shp.shop_identifier) as shop_name, shop_updated_on, blnku.user_name');
        $srch->addCondition('blinkcond_badge_id', '=', $badgeId);

        if (!empty($badgeType)) {
            $srch->addCondition(Badge::DB_TBL_PREFIX . 'type', '=',  $badgeType);
        }

        $conditionSellerId = FatApp::getPostedData('blinkcond_user_id');
        if (!empty($conditionSellerId)) {
            $srch->addCondition(BadgeLinkCondition::DB_TBL_PREFIX . 'user_id', '=',  $conditionSellerId);
        }

        $recordType = FatApp::getPostedData('blinkcond_record_type'); //Link Type
        if (!empty($recordType)) {
            $srch->addCondition(BadgeLinkCondition::DB_TBL_PREFIX . 'record_type', '=',  $recordType);
        }

        $trigger = FatApp::getPostedData('record_condition'); //Trigger
        if (!empty($trigger)) {
            $srch->addCondition('badge_condition_type', '=', $trigger);
        }

        $conditionType = FatApp::getPostedData('blinkcond_condition_type');
        if (!empty($conditionType)) {
            $srch->addCondition(BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type', '=',  $conditionType);
        }
        
        $fromDate = FatApp::getPostedData('blinkcond_from_date');
        if (!empty($fromDate)) {
            $srch->addCondition('blnk.blinkcond_from_date', '>=', $fromDate);
        }
        
        $toDate = FatApp::getPostedData('blinkcond_to_date');
        if (!empty($toDate)) {
            $srch->addCondition('blnk.blinkcond_to_date', '<=', $toDate);
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);

        $paginationArr = empty($postedData) ? $post : $postedData;
        $this->set('postedData', $paginationArr);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
    }

    public function form(int $badgeId)
    {
        $this->objPrivilege->canEditBadgeLinks();
        $blinkCondId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $this->validateBadge($badgeId);
        $this->checkEditPrivilege(true);
        $this->badgeLinkCondId = $blinkCondId;

        $dataToFill = [];
        $recordType = 0;
        $sellerId = 0;
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
                $recordType = $badgeLink['blinkcond_record_type'];
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

                if (BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT == $recordType) {
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

                $dataToFill['records'][$recordId] = $recordName;
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
            $sellerId = $dataToFill['blinkcond_user_id'];
        }

        $dataToFill['record_condition'] = $this->badgeData['badge_condition_type'];
        $dataToFill['blinkcond_badge_id'] = $badgeId;

        $frm = $this->getForm($this->badgeData['badge_condition_type']);
        $frm->fill($dataToFill);
        
        $this->set('sellerId', $sellerId);
        $this->set('recordType', $recordType);
        $this->set('frm', $frm);
        $this->set('recordId', $this->badgeLinkCondId);
        $this->set('badgeId', $badgeId);
        $this->set('triggerType', $this->badgeData['badge_condition_type']);
        $this->set('includeTabs', false);
        $this->set('formTitle', Labels::getLabel('LBL_BADGE_CONDITION_SETUP', $this->siteLangId));


        $this->_template->render(false, false);
    }

    private function getForm(int $recordCondition)
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'blinkcond_badge_id');
        $frm->addHiddenField('', 'badge_type', Badge::TYPE_BADGE);
        $frm->addHiddenField('', 'blinkcond_id');
        $frm->addHiddenField('', 'blinkcond_badge_id');
        $frm->addHiddenField('', 'record_condition');

        if (Badge::COND_MANUAL == $recordCondition) {            
            $frm->addDateField(Labels::getLabel('LBL_FROM_DATE', $this->siteLangId), 'blinkcond_from_date', '', ['readonly' => 'readonly']);
            $frm->addDateField(Labels::getLabel('LBL_TO_DATE', $this->siteLangId), 'blinkcond_to_date', '', ['readonly' => 'readonly']);
            
            if (1 > $this->badgeLinkCondId) {
                $fld = $frm->addSelectBox(Labels::getLabel('LBL_SELLER', $this->siteLangId), 'blinkcond_user_id', [], '', ['placeholder' => Labels::getLabel('LBL_SEARCH_SELLER', $this->siteLangId)]);
                $fld->requirement->setRequired(true);
            
                $recordTypesArr = BadgeLinkCondition::getRecordTypeArr($this->siteLangId);
                $fld = $frm->addSelectBox(Labels::getLabel('LBL_RECORD_TYPE', $this->siteLangId), 'blinkcond_record_type', $recordTypesArr, '', [], '');
                $fld->requirement->setRequired(true);
                
            }

            $recordType = $this->recordData['blinkcond_record_type'] ?? '';
            if (BadgeLinkCondition::RECORD_TYPE_SHOP != $recordType) {
                $records = $this->recordData['records'] ?? [];
                $frm->addSelectBox(Labels::getLabel('LBL_SELECT_RECORDS', $this->siteLangId), 'badgelink_record_ids[]', $records, array_keys($records), ['placeholder' => Labels::getLabel('LBL_SEARCH_RECORD', $this->siteLangId)], '');
            }
        } else {
            $conditionTypesArr = BadgeLinkCondition::getConditionTypesArr($this->siteLangId);
            $fld = $frm->addSelectBox(Labels::getLabel('LBL_CONDITION_TYPE', $this->siteLangId), 'blinkcond_condition_type', $conditionTypesArr, '', [], '');
            $fld->requirement->setRequired(true);

            $fld = $frm->addTextBox(Labels::getLabel('LBL_FROM', $this->siteLangId), 'blinkcond_condition_from');
            $fld->requirement->setRequired(true);

            $frm->addTextBox(Labels::getLabel('LBL_TO', $this->siteLangId), 'blinkcond_condition_to');
        }
        return $frm;
    }

    public function setup()
    {
        $this->objPrivilege->canEditBadgeLinks();

        $recordCondition = FatApp::getPostedData('record_condition', FatUtility::VAR_INT, 0);
        $badgeType = FatApp::getPostedData('badge_type', FatUtility::VAR_INT, 0);
        $blinkCondId = FatApp::getPostedData('blinkcond_id', FatUtility::VAR_INT, 0);
        $sellerId = FatApp::getPostedData('blinkcond_user_id', FatUtility::VAR_INT, 0);

        $this->badgeLinkCondId = $blinkCondId;

        if (1 > $this->badgeLinkCondId && 1 > $sellerId && Badge::COND_MANUAL == $recordCondition) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_USER_SELECTION', $this->siteLangId), true);
        }

        $frm = $this->getForm($recordCondition);

        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $records = FatApp::getPostedData('badgelink_record_ids', FatUtility::VAR_STRING, '');
        $recordType = FatApp::getPostedData('blinkcond_record_type', FatUtility::VAR_INT, 0);
        if (0 < $this->badgeLinkCondId) {
            $recordType = BadgeLinkCondition::getAttributesById($this->badgeLinkCondId, 'blinkcond_record_type');
        }

        if (Badge::COND_MANUAL == $recordCondition && 1 > $recordType) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_RECORD_TYPE', $this->siteLangId), true);
        }

        if (1 > $this->badgeLinkCondId && BadgeLinkCondition::RECORD_TYPE_SHOP == $recordType) {
            $shopId = Shop::getAttributesByUserId($sellerId, 'shop_id');
            if (false === $shopId || 1 > $shopId) {
                LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_SHOP', $this->siteLangId), true);
            }
            $records = [$shopId];
        }

        if (Badge::COND_MANUAL == $recordCondition && BadgeLinkCondition::RECORD_TYPE_SHOP != $recordType) {
            if (empty($records)) {
                LibHelper::exitWithError(Labels::getLabel('ERR_RECORDS_FIELD_IS_MANDATORY', $this->siteLangId), true);
            }
        }

        $fromDate = FatApp::getPostedData('blinkcond_from_date', FatUtility::VAR_STRING, '');
        $toDate = FatApp::getPostedData('blinkcond_to_date', FatUtility::VAR_STRING, '');

        if (!empty($fromDate) && !empty($toDate) && $fromDate > $toDate) {
            LibHelper::exitWithError(Labels::getLabel('ERR_TO_DATE_MUST_BE_GREATER_THAN_OR_EQUAL_TO_FROM_DATE', true, $this->siteLangId));
        }

        $badgeId = FatApp::getPostedData('blinkcond_badge_id', FatUtility::VAR_INT, 0);
        $conditionType = FatApp::getPostedData('blinkcond_condition_type', FatUtility::VAR_INT, 0);

        if (Badge::COND_AUTO == $recordCondition && false === BadgeLinkCondition::isUniqueAuto($badgeId, $conditionType, $blinkCondId)) {
            $msg = Labels::getLabel('ERR_BADGE_CONDITION_ALREADY_BOUND_FOR_CONDITION_TYPE.', $this->siteLangId);
            LibHelper::exitWithError($msg, true);
        } else if (false === BadgeLinkCondition::isUnique($badgeId, $sellerId, $recordType, 0, $blinkCondId)) {
            $msg = Labels::getLabel('ERR_BADGE_CONDITION_ALREADY_BOUND_FOR_SAME_LINK_TYPE.', $this->siteLangId);
            if (Badge::TYPE_RIBBON == $badgeType) {
                $msg = Labels::getLabel('ERR_RIBBON_CONDITION_ALREADY_BOUND_FOR_SAME_LINK_TYPE_AND_SAME_POSITION.', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }

        if (Badge::COND_AUTO == $recordCondition) {
            $records = []; /* Records Binding Not Required. */
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
                        LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_CONDITION_FROM_OR_TO_VALUE', $this->siteLangId), true);
                    }
                    break;
                case BadgeLinkCondition::COND_TYPE_RETURN_ACCEPTANCE:
                case BadgeLinkCondition::COND_TYPE_ORDER_CANCELLED:
                    $rate = FatApp::getPostedData('blinkcond_condition_from', FatUtility::VAR_FLOAT, 0);
                    if (0 > $rate || 100 < $rate) {
                        LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_RATE_VALUE', $this->siteLangId), true);
                    }
                    $post['blinkcond_condition_from'] = $rate;
                    break;

                default:
                    LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_CONDITION_TYPE', $this->siteLangId), true);
                    break;
            }
        } else {
            unset(
                $post['blinkcond_condition_type'],
                $post['blinkcond_condition_from'],
                $post['blinkcond_condition_to'],
            );
        }

        $newRecord = (1 > $blinkCondId);
        if ($newRecord) {
            $post['blinkcond_user_id'] = $sellerId;
        }

        $record = new BadgeLinkCondition($blinkCondId);
        $record->assignValues($post);
        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $blinkCondId = $record->getMainTableRecordId();

        $msg = '';
        if (Badge::COND_MANUAL == $recordCondition && !empty($records)) {
            $db = FatApp::getDb();
            foreach ($records as $recordId) {
                if (false === BadgeLinkCondition::isUniqueRecord($badgeType, $recordType, $recordId)) {
                    if (empty($msg)) {
                        $msg = Labels::getLabel('ERR_UNABLE_TO_BIND_SOME_RECORDS._ALREADY_LINKED_WITH_OTHER_BADGE_LINK_RECORD', $this->siteLangId);
                    }
                    continue;
                }

                $linkData = array(
                    'badgelink_blinkcond_id' => $blinkCondId,
                    'badgelink_record_id' => $recordId
                );
                $db->insertFromArray(BadgeLinkCondition::DB_TBL_BADGE_LINKS, $linkData);
            }
        }

        $msg = !empty($msg) ? $msg : ($newRecord ? Labels::getLabel('MGS_ADDED_SUCCESSFULLY', $this->siteLangId) : Labels::getLabel('MGS_UPDATED_SUCCESSFULLY', $this->siteLangId));

        $this->set('recordType', $recordType);
        $this->set('blinkcond_id', $this->badgeLinkCondId);
        $this->set('msg', $msg);
        $this->_template->render(false, false, 'json-success.php');
    }
    
    private function getBadgeData(int $badgeId, array $attr = []): array
    {
        if (empty($attr)) {
            $attr = [
                'badge_id',
                'COALESCE(badge_name, badge_identifier) as badge_name',
                'badge_type',
                'badge_condition_type',
                'badge_shape_type',
                'badge_color',
                'badge_display_inside',
            ];
        }
        $badgeSearch = new BadgeSearch($this->siteLangId);
        $badgeSearch->doNotCalculateRecords();
        $badgeSearch->setPageSize(1);
        $badgeSearch->addCondition('badge_id', '=', $badgeId);
        $badgeSearch->addMultipleFields($attr);
        $badgeSearch->getResultSet();
        return (array) FatApp::getDb()->fetch($badgeSearch->getResultSet());
    }

    protected function getSearchForm(array $fields = [], int $conditionType = Badge::COND_MANUAL)
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'blinkcond_id', applicationConstants::SORT_DESC);
        }
        $frm->addHiddenField('', 'blinkcond_badge_id');
        $frm->addHiddenField('', 'record_condition', $conditionType);

        if (Badge::COND_MANUAL == $conditionType) {
            $frm->addSelectBox(Labels::getLabel('LBL_SELLER', $this->siteLangId), 'blinkcond_user_id', [], '', ['placeholder' => Labels::getLabel('LBL_SEARCH_SELLER', $this->siteLangId)]);
            $frm->addSelectBox(Labels::getLabel('LBL_RECORD_TYPE', $this->siteLangId), 'blinkcond_record_type', BadgeLinkCondition::getRecordTypeArr($this->siteLangId));
        } else {
            $frm->addSelectBox(Labels::getLabel('LBL_CONDITION', $this->siteLangId), 'blinkcond_condition_type', BadgeLinkCondition::getConditionTypesArr($this->siteLangId));
        }
        $frm->addDateField(Labels::getLabel('LBL_CONDITION_FROM', $this->siteLangId), 'blinkcond_from_date');
        $frm->addDateField(Labels::getLabel('LBL_CONDITION_TO', $this->siteLangId), 'blinkcond_from_to');

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    public function deleteRecord()
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (!BadgeLinkCondition::getAttributesById($recordId, ['blinkcond_id'])) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteSelected()
    {
        $this->checkEditPrivilege();

        $recordIdsArr = FatUtility::int(FatApp::getPostedData('badgeLinkIds'));
        if (empty($recordIdsArr)) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }

            $this->markAsDeleted($recordId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted(int $recordId)
    {
        if (1 > $recordId) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }

        $obj = new BadgeLinkCondition($recordId);
        if (!$obj->deleteRecord(false)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
        $this->removeLinkRecord($recordId);
    }
  
    public function isUnique(int $badgeType, int $recordType, int $record_id, int $position = 0)
    {
        if (false === BadgeLinkCondition::isUniqueRecord($badgeType, $recordType, $record_id, $position)) {
            $msg = Labels::getLabel('ERR_THIS_RECORD_IS_LINKED_WITH_OTHER_BADGE_LINK_RECORD_WITH_SAME_POSITION.', $this->siteLangId);
            LibHelper::exitWithError($msg, true);
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_UNIQUE', $this->siteLangId));
    }

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('badgesTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'cond_seller_name' => Labels::getLabel('LBL_SELLER', $this->siteLangId),
            BadgeLinkCondition::DB_TBL_PREFIX . 'record_type' => Labels::getLabel('LBL_RECORD_TYPE', $this->siteLangId),
            BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type' => Labels::getLabel('LBL_CONDITION_TYPE', $this->siteLangId),
            BadgeLinkCondition::DB_TBL_PREFIX . 'condition_from' => Labels::getLabel('LBL_CONDITION_FROM', $this->siteLangId),
            BadgeLinkCondition::DB_TBL_PREFIX . 'condition_to' => Labels::getLabel('LBL_CONDITION_TO', $this->siteLangId),
            BadgeLinkCondition::DB_TBL_PREFIX . 'from_date' => Labels::getLabel('LBL_VAILD_FROM', $this->siteLangId),
            BadgeLinkCondition::DB_TBL_PREFIX . 'to_date' => Labels::getLabel('LBL_VALID_TO', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('badgesTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'cond_seller_name',
            BadgeLinkCondition::DB_TBL_PREFIX . 'record_type',
            BadgeLinkCondition::DB_TBL_PREFIX . 'condition_type',
            BadgeLinkCondition::DB_TBL_PREFIX . 'condition_from',
            BadgeLinkCondition::DB_TBL_PREFIX . 'condition_to',
            BadgeLinkCondition::DB_TBL_PREFIX . 'from_date',
            BadgeLinkCondition::DB_TBL_PREFIX . 'to_date',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, [Badge::DB_TBL_PREFIX . 'shape_type'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $params = FatApp::getParameters();
        $this->validateBadge(current($params));
        $str = Labels::getLabel('LBL_BADGE_-_{BADGE-NAME}', $this->siteLangId);
        $badgeName = HtmlHelper::getStatusHtml(HtmlHelper::PRIMARY, $this->badgeData['badge_name']);
        $pageTitle = CommonHelper::replaceStringData($str, ['{BADGE-NAME}' =>  $badgeName]);

        $pageTitle = $pageData['plang_title'] ?? $pageTitle;
        switch ($action) {
            case 'list':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_BADGES', $this->siteLangId), 'href' => UrlHelper::generateUrl('Badges')],
                    ['title' => $pageTitle]
                ];
        }
        return $this->nodes;
    }
}
