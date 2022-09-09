<?php

class BadgesController extends ListingBaseController
{
    protected string $modelClass = 'Badge';
    protected string $pageKey = 'MANAGE_BADGES';

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
        $this->set('formTitle', Labels::getLabel('LBL_BADGE_SETUP', $this->siteLangId));
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
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_BADGE_NAME', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(['js/cropper.js', 'js/cropper-main.js', 'badges/page-js/index.js']);
        $this->_template->addCss(['css/cropper.css']);
        $this->includeFeatherLightJsCss();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'badges/search.php', true),
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
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'badge_added_on');
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = 'badge_added_on';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING), applicationConstants::SORT_DESC);

        $srchFrm = $this->getSearchForm($fields);

        $postedData = FatApp::getPostedData();
        $post = $srchFrm->getFormDataFromArray($postedData);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = new BadgeSearch($this->siteLangId);
        $srch->addCondition(Badge::DB_TBL_PREFIX . 'type', '=', 'mysql_func_' . Badge::TYPE_BADGE, 'AND', true);
        $srch->addFld('*, COALESCE(badge_name,  badge_identifier) as badge_name');
        $keyword = $post['keyword'];
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('badge_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('badge_identifier', 'like', '%' . $keyword . '%');
        }

        $approval = FatApp::getPostedData('badge_required_approval');
        if ('' != $approval) {
            $srch->addCondition('badge_required_approval', '=', $approval);
        }

        $conditionType = FatApp::getPostedData('badge_trigger_type');
        if ('' != $conditionType) {
            $srch->addCondition('badge_trigger_type', '=', $conditionType);
        } else if (Badge::APPROVAL_OPEN === $approval) {
            $srch->addCondition('badge_trigger_type', '=', Badge::COND_MANUAL);
        }

        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();

        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $this->set("arrListing", FatApp::getDb()->fetchAll($srch->getResultSet()));
        $paginationArr = empty($postedData) ? $post : $postedData;
        $this->set('postedData', $paginationArr);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $approvalStatusArr = Badge::getApprovalStatusArr($this->siteLangId);
        $this->set("approvalStatusArr", $approvalStatusArr);
    }

    public function form()
    {
        $this->objPrivilege->canEditBadgesAndRibbons();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm();

        $dataToFill = [];
        if ($recordId > 0) {
            $dataToFill = Badge::getAttributesByLangId($this->siteLangId, $recordId, ['*', 'IFNULL(badge_name,badge_identifier) as badge_name'], applicationConstants::JOIN_RIGHT);
        }

        $dataToFill['logo_min_width'] = Badge::ICON_MIN_WIDTH;
        $dataToFill['logo_min_height'] = Badge::ICON_MIN_HEIGHT;
        $frm->fill($dataToFill);

        $this->set('frm', $frm);
        $this->set('recordId', $recordId);
        $this->set('formTitle', Labels::getLabel('LBL_BADGE_SETUP', $this->siteLangId));

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
        $badgeName = strlen($post['badge_name']);
        if (Badge::RIBB_TEXT_MIN_LEN > $badgeName || Badge::RIBB_TEXT_MAX_LEN < $badgeName) {
            $str = Labels::getLabel('ERR_BADGE_NAME_LENGTH_SHOULD_BETWEEN_{MIN-LENGTH}_TO_{MAX-LENGTH}_CHARS', $this->siteLangId);
            LibHelper::exitWithError(CommonHelper::replaceStringData($str, [
                '{MIN-LENGTH}' => Badge::RIBB_TEXT_MIN_LEN,
                '{MAX-LENGTH}' => Badge::RIBB_TEXT_MAX_LEN,
            ]), true);
        }

        $recordId = FatApp::getPostedData('badge_id', FatUtility::VAR_INT, 0);
        $dateCol = (1 > $recordId) ? 'badge_added_on' : 'badge_updated_on';
        $post[$dateCol] = date('Y-m-d H:i:s');

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

    protected function isMediaUploaded($recordId)
    {
        $attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_BADGE, $recordId, 0);
        if (false !== $attachment && 0 < $attachment['afile_id']) {
            return true;
        }
        return false;
    }

    protected function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'badge_added_on', applicationConstants::SORT_DESC);
        }
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '');
        $fld->overrideFldType('search');

        $conditionTypeArr = Badge::getTriggerCondTypeArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_TRIGGER_TYPE', $this->siteLangId), 'badge_trigger_type', $conditionTypeArr, '', ['class' => 'badgeTriggerTypeJs']);

        $approvalArr = Badge::getApprovalStatusArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_APPROVAL', $this->siteLangId), 'badge_required_approval', $approvalArr, '', ['class' => 'badgeApprovalJs']);

        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        return $frm;
    }

    private function getForm(int $conditionType = Badge::COND_MANUAL)
    {
        $frm = new Form('frm');
        $frm->addHiddenField('', 'badge_id');
        $frm->addHiddenField('', 'badge_type', Badge::TYPE_BADGE);
        $frm->addSelectBox(Labels::getLabel('FRM_TRIGGER_TYPE', $this->siteLangId), 'badge_trigger_type', Badge::getTriggerCondTypeArr($this->siteLangId), '', [], '');

        $fld = $frm->addRequiredField(Labels::getLabel('FRM_NAME', $this->siteLangId), 'badge_name');

        $requireApprovalArr = Badge::getApprovalStatusArr($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_APPROVAL', $this->siteLangId), 'badge_required_approval', $requireApprovalArr);
        $fld->requirement->setRequired(($conditionType == Badge::COND_MANUAL));

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

        $frm = new Form('frmBadgeLang');
        $frm->addHiddenField('', 'badge_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');

        $fld = $frm->addRequiredField(Labels::getLabel('FRM_NAME', $langId), 'badge_name');
        $fld->addFieldTagAttribute('maxlength', Badge::RIBB_TEXT_MAX_LEN);

        return $frm;
    }

    public function media($recordId)
    {
        $recordId = FatUtility::int($recordId);
        $recordId = Badge::getAttributesById($recordId, 'badge_id');

        if (false == $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $frm = $this->getMediaForm($recordId);
        $getBadgeDimensions = ImageDimension::getData(ImageDimension::TYPE_BADGE_ICON, ImageDimension::VIEW_THUMB);
        $getAspectRatio = $getBadgeDimensions[ImageDimension::VIEW_THUMB]['aspectRatio'];
        $arrRatio = explode(":", $getAspectRatio);
        if ($arrRatio) {
            $ratioJs = $arrRatio[0] . ' / ' . $arrRatio[1];
        } else {
            $ratioJs = '1' . ' / ' . '1';
        }
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('ratioJs', $ratioJs);
        $this->set('displayFooterButtons', false);
        $this->set('getBadgeDimensions', $getBadgeDimensions);
        $this->set('activeGentab', false);
        $this->set('formTitle', Labels::getLabel('LBL_BADGE_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function images($recordId, $langId = 0)
    {
        $this->checkEditPrivilege(true);
        $languages = Language::getAllNames();
        if (count($languages) <= 1) {
            $langId =  array_key_first($languages);
        }

        $recordId = FatUtility::int($recordId);
        if (!$recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        if (!$row = Badge::getAttributesById($recordId, 'badge_id')) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $images = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_BADGE, $recordId, 0, $langId, (1 == count($languages)), 0, 1);

        $this->set('languages', Language::getAllNames());
        $this->set('images', $images);
        $this->set('recordId', $recordId);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getMediaForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);
        $frm = new Form('frmBadgeMedia');
        $frm->addHiddenField('', 'badge_id', $recordId);
        $frm->addHiddenField('', 'file_type', AttachedFile::FILETYPE_BADGE);
        $frm->addHiddenField('', 'min_width');
        $frm->addHiddenField('', 'min_height');

        $languagesArr = applicationConstants::getAllLanguages();
        if (count($languagesArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', $languagesArr, '', array(), '');
        } else {
            $lang_id = array_key_first($languagesArr);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }

        $frm->addHtml('', 'badge_icon', '');
        return $frm;
    }

    public function uploadMedia()
    {
        $this->objPrivilege->canEditBadgesAndRibbons();
        $file_type = FatApp::getPostedData('file_type', FatUtility::VAR_INT, 0);
        $recordId = FatApp::getPostedData('badge_id', FatUtility::VAR_INT, 0);
        $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $slide_screen = FatApp::getPostedData('slide_screen', FatUtility::VAR_INT, 0);
        $afileId = FatApp::getPostedData('afile_id', FatUtility::VAR_INT, 0);
        if (!$file_type) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId), true);
        }

        Badge::deleteImagesWithOutBadgeId();

        $fileHandlerObj = new AttachedFile($afileId);
        if (!$res = $fileHandlerObj->saveImage(
            $_FILES['cropped_image']['tmp_name'],
            $file_type,
            $recordId,
            0,
            $_FILES['cropped_image']['name'],
            -1,
            true,
            $lang_id,
            $_FILES['cropped_image']['type'],
            $slide_screen
        )) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_IMAGE_UPLOADED_SUCCESSFULLY', $this->siteLangId));
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteImage($recordId, $afileId, $langId = 0, $slide_screen = 0)
    {
        $this->objPrivilege->canEditBadgesAndRibbons();
        $afileId = FatUtility::int($afileId);
        $recordId = FatUtility::int($recordId);
        $langId = FatUtility::int($langId);
        if (!$afileId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $fileType = AttachedFile::FILETYPE_BADGE;
        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile($fileType, $recordId, $afileId, 0, $langId, $slide_screen)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_IMAGE_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
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
        $tblHeadingCols = CacheHelper::get('badgesTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            /* 'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            Badge::DB_TBL_PREFIX . 'shape_type' => Labels::getLabel('LBL_IMAGE', $this->siteLangId),
            Badge::DB_TBL_PREFIX . 'name' => Labels::getLabel('LBL_NAME', $this->siteLangId),
            Badge::DB_TBL_PREFIX . 'trigger_type' => Labels::getLabel('LBL_TRIGGER_TYPE', $this->siteLangId),
            Badge::DB_TBL_PREFIX . 'required_approval' => Labels::getLabel('LBL_APPROVAL', $this->siteLangId),
            Badge::DB_TBL_PREFIX . 'added_on' => Labels::getLabel('LBL_ADDED_ON', $this->siteLangId),
            Badge::DB_TBL_PREFIX . 'active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('badgesTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /*  'listSerial', */
            Badge::DB_TBL_PREFIX . 'shape_type',
            Badge::DB_TBL_PREFIX . 'name',
            Badge::DB_TBL_PREFIX . 'trigger_type',
            Badge::DB_TBL_PREFIX . 'required_approval',
            Badge::DB_TBL_PREFIX . 'added_on',
            Badge::DB_TBL_PREFIX . 'active',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, [Badge::DB_TBL_PREFIX . 'shape_type', 'badge_required_approval'], Common::excludeKeysForSort());
    }
}
