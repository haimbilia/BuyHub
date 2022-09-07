<?php

class RibbonsController extends ListingBaseController
{
    protected string $modelClass = 'Badge';
    protected string $pageKey = 'MANAGE_RIBBONS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBadgesAndRibbons();
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
            $this->set("canEdit", $this->objPrivilege->canEditBadgesAndRibbons($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditBadgesAndRibbons();
        }
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->checkEditPrivilege();
        $this->setModel($constructorArgs);
        $this->formLangFields = [
            $this->modelObj::tblFld('name')
        ];
        $this->set('formTitle', Labels::getLabel('LBL_RIBBON_SETUP', $this->siteLangId));
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['statusButtons'] = true;
        $actionItemsData['deleteButton'] = true;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_RIBBON_NAME', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(['js/jscolor.js', 'ribbons/page-js/index.js']);

        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'ribbons/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $this->checkEditPrivilege(true);

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'badge_id');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'badge_id';
        }
        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING), applicationConstants::SORT_DESC);

        $srchFrm = $this->getSearchForm($fields);

        $postedData = FatApp::getPostedData();
        $post = $srchFrm->getFormDataFromArray($postedData);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = new BadgeSearch($this->siteLangId);
        $srch->addCondition(Badge::DB_TBL_PREFIX . 'type', '=', Badge::TYPE_RIBBON);
        $srch->addFld('*, COALESCE(badge_name,  badge_identifier) as badge_name');

        $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('badge_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('badge_identifier', 'like', '%' . $keyword . '%');
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

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

        $approvalStatusArr = Badge::getApprovalStatusArr($this->siteLangId);
        $this->set("approvalStatusArr", $approvalStatusArr);
    }

    protected function getSearchForm(array $fields = [])
    {
        $fields = $this->getFormColumns();

        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        if (!empty($fields)) {
            $this->addSortingElements($frm, 'badge_id', applicationConstants::SORT_DESC);
        }

        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    public function form()
    {
        $this->objPrivilege->canEditBadgesAndRibbons();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm();

        $dataToFill = [];
        if ($recordId > 0) {
            $dataToFill = Badge::getAttributesByLangId($this->siteLangId, $recordId, ['*','IFNULL(badge_name,badge_identifier) as badge_name'], applicationConstants::JOIN_RIGHT);
        }

        $frm->fill($dataToFill);

        $this->set('frm', $frm);
        $this->set('recordId', $recordId);
        $this->set('formTitle', Labels::getLabel('LBL_RIBBON_SETUP', $this->siteLangId));

        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditBadgesAndRibbons();
        $approvalType = FatApp::getPostedData('badge_required_approval', FatUtility::VAR_INT, 0);

        $frm = $this->getForm($approvalType);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $ribbName = strlen($post['badge_name']);
        if (Badge::RIBB_TEXT_MIN_LEN > $ribbName || Badge::RIBB_TEXT_MAX_LEN < $ribbName) {
            $str = Labels::getLabel('ERR_RIBBON_NAME_LENGTH_SHOULD_BETWEEN_{MIN-LENGTH}_TO_{MAX-LENGTH}_CHARS', $this->siteLangId);
            LibHelper::exitWithError(CommonHelper::replaceStringData($str, [
                '{MIN-LENGTH}' => Badge::RIBB_TEXT_MIN_LEN,
                '{MAX-LENGTH}' => Badge::RIBB_TEXT_MAX_LEN,
            ]), true);
        }

        $recordId = FatApp::getPostedData('badge_id', FatUtility::VAR_INT, 0);

        $post['badge_shape_type'] = Badge::SHAPE_RECTANGLE;
        $post['badge_display_inside'] = applicationConstants::YES;

        $record = new Badge($recordId);
        $record->setFldValue(Badge::DB_TBL_PREFIX . 'identifier', $post['badge_name']);
        $record->assignValues($post);
        if (!$record->save()) {
            $msg = $record->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }
        $recordId = $record->getMainTableRecordId();

        $this->setLangData($record, [
            $record::tblFld('name') => $post[$record::tblFld('name')],
        ]);

        $this->set('badge_id', $recordId);
        $this->set('msg', Labels::getLabel('MGS_SETUP_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm()
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'badge_id');
        $frm->addHiddenField('', 'badge_type', Badge::TYPE_RIBBON);

        $frm->addRequiredField(Labels::getLabel('FRM_NAME', $this->siteLangId), 'badge_name');
        
        $themeColorInverse = FatApp::getConfig('CONF_THEME_COLOR_INVERSE', FatUtility::VAR_STRING, "#FFF");
        $frm->addRequiredField(Labels::getLabel('FRM_TEXT_COLOR', $this->siteLangId), 'badge_text_color', $themeColorInverse, ['class' => 'jscolor']);
        
        $themeColor = FatApp::getConfig('CONF_THEME_COLOR', FatUtility::VAR_STRING, "#FF3A59");
        $frm->addRequiredField(Labels::getLabel('FRM_BACKGROUND_COLOR', $this->siteLangId), 'badge_color', $themeColor, ['class' => 'jscolor']);

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'badge_active', $activeInactiveArr, '', array(), '');
        $fld->requirement->setRequired(true);

        $languageArr = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 0 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    protected function getLangForm($recordId = 0, $langId = 0)
    {
        $recordId = FatUtility::int($recordId);
        $langId = FatUtility::int($langId);
        $langId = 1 > $langId ? $this->siteLangId : $langId;

        $frm = new Form('frmRibbonLang');
        $frm->addHiddenField('', 'badge_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');

        $frm->addRequiredField(Labels::getLabel('FRM_NAME', $langId), 'badge_name');

        return $frm;
    }

    public function updateStatus()
    {
        $this->checkEditPrivilege();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);

        if (1 > $recordId || 0 > $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (!Badge::getAttributesById($recordId, 'badge_id')) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->changeStatus($recordId, $status);
        $this->set('msg', Labels::getLabel('MSG_STATUS_UPDATED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditBadgesAndRibbons();

        $recordIdsArr = FatUtility::int(FatApp::getPostedData('badge_ids'));
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        if (empty($recordIdsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }

            $this->changeStatus($recordId, $status);
        }
        $this->set('msg', Labels::getLabel('MSG_STATUS_UPDATED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditAbusiveWords();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        if (false === Badge::getAttributesById($recordId, 'badge_id')) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditBadgesAndRibbons();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('badge_ids'));
        if (empty($recordIdsArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            $this->markAsDeleted($recordId);
        }
        $this->set('msg', Labels::getLabel('MSG_RECORDS_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $obj = new Badge($recordId);
        if (!$obj->deleteRecord(true)) {
            LibHelper::exitWithError($obj->getError(), true);
        }

        $db = FatApp::getDb();
        if (!$db->deleteRecords(BadgeLinkCondition::DB_TBL, array('smt' => 'blinkcond_badge_id = ?', 'vals' => array($recordId)))) {
            LibHelper::exitWithError($db->getError(), true);
        }
    }

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('ribbonsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
         /*    'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            Badge::DB_TBL_PREFIX . 'shape_type' => Labels::getLabel('LBL_IMAGE', $this->siteLangId),
            Badge::DB_TBL_PREFIX . 'name' => Labels::getLabel('LBL_NAME', $this->siteLangId),
            Badge::DB_TBL_PREFIX . 'active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('ribbonsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /* 'listSerial', */
            Badge::DB_TBL_PREFIX . 'shape_type',
            Badge::DB_TBL_PREFIX . 'name',
            Badge::DB_TBL_PREFIX . 'active',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, [Badge::DB_TBL_PREFIX . 'shape_type'], Common::excludeKeysForSort());
    }
}
