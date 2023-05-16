<?php

class SlidesController extends ListingBaseController
{
    protected string $modelClass = 'Slides';
    protected $pageKey = 'MANAGE_SLIDES';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSlides();
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
            $this->set("canEdit", $this->objPrivilege->canEditSlides($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditSlides();
        }
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['statusButtons'] = true;
        $actionItemsData['deleteButton'] = true;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_SLIDE_TITLE', $this->siteLangId));
        $this->checkEditPrivilege(true);
        $this->getListingData();
        $this->set('tourStep', SiteTourHelper::getStepIndex());

        $this->set('autoTableColumWidth', false);
        $this->setCustomColumnWidth();
        $this->_template->addCss('css/cropper.css');
        $this->_template->addJs(['js/cropper.js', 'js/cropper-main.js', 'slides/page-js/index.js']);
        $this->includeFeatherLightJsCss();
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'slides/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));
        $data = FatApp::getPostedData();
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');

        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));

        $sortBy = Slides::DB_TBL_PREFIX . 'display_order';

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $searchForm = $this->getSearchForm($fields);
        $post = $searchForm->getFormDataFromArray($data);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];

        $srch = Slides::getSearchObject($this->siteLangId, false);
        $srch->addCondition('slide_type', '=', Slides::TYPE_SLIDE);
        $srch->addOrder($sortBy, $sortOrder);
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $condition = $srch->addCondition('slide_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('slide_title', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        $srch->addOrder(Slides::DB_TBL_PREFIX . 'active', 'ASC');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();

        $srch->addMultipleFields([
            'slide_id', 'slide_identifier', 'slide_type', 'slide_record_id', 'slide_url',
            'slide_target', 'slide_active', 'slide_display_order', 'slide_img_updated_on', 'slidelang_slide_id',
            'slidelang_lang_id', 'IFNULL(slide_title, slide_identifier) AS slide_title'
        ]);

        $records =  FatApp::getDb()->fetchAll($srch->getResultSet());
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', count($records));
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->checkEditPrivilege(true);
    }

    public function form()
    {
        $this->checkEditPrivilege(true);
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);
        $langId = $this->siteLangId;

        if (0 < $recordId) {
            $fields = [
                'slide_id', 'slide_identifier', 'slide_type', 'slide_record_id', 'slide_url',
                'slide_target', 'slide_active', 'slide_display_order', 'slide_img_updated_on', 'slidelang_slide_id',
                'slidelang_lang_id', 'IFNULL(slide_title, slide_identifier) AS slide_title'
            ];
            $data = Slides::getAttributesByLangId($langId, $recordId, $fields, applicationConstants::JOIN_RIGHT);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $universalImage = true;
        } else {
            $universalImage = false;
            $langId = array_key_first($languages);
        }

        $slideImage = AttachedFile::getAttachment(AttachedFile::FILETYPE_HOME_PAGE_BANNER, $recordId, 0, $langId, $universalImage);
        $this->set('image', $slideImage);
        $this->set('formTitle', Labels::getLabel('LBL_SLIDE_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getForm($recordId = 0)
    {
        $frm = new Form('frmSlide');
        $frm->addHiddenField('', 'slide_id', $recordId);
        $frm->addHiddenField('', 'lang_id', $this->siteLangId);
        $frm->addHiddenField('', 'slide_type', Slides::TYPE_SLIDE);
        $frm->addRequiredField(Labels::getLabel('FRM_SLIDE_TITLE', $this->siteLangId), 'slide_title');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_SLIDE_URL', $this->siteLangId), 'slide_url');
        $fld->setFieldTagAttribute('placeholder', 'http://');

        $linkTargetsArr = applicationConstants::getLinkTargetsArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_OPEN_IN', $this->siteLangId), 'slide_target', $linkTargetsArr, '', [], '');
        $frm->addCheckBox(Labels::getLabel('FRM_ACTIVATION_STATUS', $this->siteLangId), 'slide_active', applicationConstants::ACTIVE, [], true, applicationConstants::INACTIVE);
        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    public function setup()
    {
        $this->checkEditPrivilege();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['slide_id'];
        $slideId = Slides::getAttributesByIdentifier($post['slide_title'], 'slide_id');
        if (!empty($slideId) && $slideId != $recordId) {
            LibHelper::exitWithError(Labels::getLabel('ERR_SLIDE_TITLE_MUST_BE_UNIQUE', $this->siteLangId), true);
        }

        $post['slide_identifier'] = $post['slide_title'];

        $langData = [
            'slidelang_slide_id' => $recordId,
            'slidelang_lang_id' => $this->siteLangId,
            'slide_title' =>  $post['slide_title']
        ];

        unset($post['slide_id'], $post['slide_title']);

        $slideObj = new Slides($recordId);
        if (1 > $recordId) {
            $post['slide_display_order'] = $slideObj->getNextMaxOrder();
        }

        $slideObj->assignValues($post);

        if (!$slideObj->save()) {
            $msg = $slideObj->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }

        $recordId = $slideObj->getMainTableRecordId();

        if (!$slideObj->updateLangData($this->siteLangId, $langData)) {
            LibHelper::exitWithError($slideObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(Slides::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId, CommonHelper::getDefaultFormLangId())) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        if (0 < count($languages)) {
            foreach ($languages as $langId => $langName) {
                if (!Brand::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        }

        if ($newTabLangId == 0 && !$this->isMediaUploaded($recordId)) {
            $this->set('openMediaForm', true);
        }
        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($autoFillLangData = 0)
    {
        $this->checkEditPrivilege(true);
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        if (1 > $recordId || 1 > $langId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $langFrm = $this->getLangForm($langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(Slides::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId, CommonHelper::getDefaultFormLangId());
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = (array)Slides::getAttributesByLangId($langId, $recordId);
        }

        $langData['slide_id'] = $recordId;
        $langFrm->fill($langData);
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $universalImage = true;
        } else {
            $universalImage = false;
            $langId = array_key_first($languages);
        }

        $slideImage = AttachedFile::getAttachment(AttachedFile::FILETYPE_HOME_PAGE_BANNER, $recordId, 0, $langId, $universalImage);

        $this->set('image', $slideImage);
        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('formTitle', Labels::getLabel('LBL_SLIDE_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getLangForm($langId = 0)
    {
        $frm = new Form('frmSlideLang');
        $frm->addHiddenField('', 'slide_id');
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_SLIDE_TITLE', $langId), 'slide_title');
        return $frm;
    }

    public function langSetup()
    {
        $this->checkEditPrivilege();
        $post = FatApp::getPostedData();

        $recordId = $post['slide_id'];
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $langId = $post['lang_id'];
        } else {
            $langId = array_key_first($languages);
        }

        if ($recordId == 0 || $langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($langId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['slide_id']);
        unset($post['lang_id']);
        $data = array(
            'slidelang_slide_id' => $recordId,
            'slidelang_lang_id' => $langId,
            'slide_title' => $post['slide_title']
        );

        $slideObj = new Slides($recordId);
        if (!$slideObj->updateLangData($langId, $data)) {
            LibHelper::exitWithError($slideObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(Slides::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId, CommonHelper::getDefaultFormLangId())) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = Slides::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('slideId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function isMediaUploaded($recordId)
    {
        $attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_HOME_PAGE_BANNER, $recordId, 0);
        if (false !== $attachment && 0 < $attachment['afile_id']) {
            return true;
        }
        return false;
    }

    protected function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $obj = new Slides($recordId);
        if (!$obj->deleteRecord(true)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }


    public function uploadMedia()
    {
        $this->checkEditPrivilege();
        $fileType = FatApp::getPostedData('file_type', FatUtility::VAR_INT, 0);
        $recordId = FatApp::getPostedData('slide_id', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $slideScreen = FatApp::getPostedData('slide_screen', FatUtility::VAR_INT, 0);
        if (!$fileType || !$recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $file = $_FILES['cropped_image'];
        if (!is_uploaded_file($file['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId), true);
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->saveImage($file['tmp_name'], $fileType, $recordId, 0, $file['name'], -1, true, $langId, $file['type'], $slideScreen)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $universalImage = true;
            $langId = FatUtility::int($langId);
        } else {
            $universalImage = false;
            $langId = array_key_first($languages);
        }

        $cbgImage = AttachedFile::getAttachment($fileType, $recordId, 0, $langId, $universalImage, $slideScreen);
        $this->set('image', $cbgImage);
        $this->set('imageFunction', 'Slide');
        $this->set('file', $file['name']);
        $this->set('recordId', $recordId);
        $this->set('file_type', $fileType);
        $this->set('lang_id', $langId);
        $this->set('msg', $file['name'] . ' ' . Labels::getLabel('MSG_UPLOADED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeMedia()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $afileId = FatApp::getPostedData('afileId', FatUtility::VAR_INT, 0);
        $fileType = FatApp::getPostedData('fileType', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        $slideScreen = FatApp::getPostedData('slideScreen', FatUtility::VAR_INT, 0);

        if (0 == $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $fileHandlerObj = new AttachedFile($afileId);
        if ($langId == $this->siteLangId) {
            $fileHandlerObj->deleteFile($fileType, $recordId, 0, 0, 0, $slideScreen);
        }
        if (!$fileHandlerObj->deleteFile($fileType, $recordId, $afileId, 0, $langId, $slideScreen)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $universalImage = true;
            $langId = FatUtility::int($langId);
        } else {
            $universalImage = false;
            $langId = array_key_first($languages);
        }

        $cbgImage = AttachedFile::getAttachment($fileType, $recordId, 0, $langId, $universalImage, $slideScreen);
        $this->set('image', $cbgImage);
        $this->set('imageFunction', 'Slide');
        $this->set('msg', Labels::getLabel('MSG_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateOrder()
    {
        $this->checkEditPrivilege();
        $post = FatApp::getPostedData();
        if (!empty($post)) {
            $slideObj = new Slides();
            if (!$slideObj->updateOrder($post['record_ids'])) {
                LibHelper::exitWithError($slideObj->getError(), true);
            }
            LibHelper::exitWithSuccess(Labels::getLabel('MSG_ORDER_UPDATED_SUCCESSFULLY', $this->siteLangId), true);
        }
    }

    public function images()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        // $fileType = FatApp::getPostedData('imageType', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        $slideScreen = FatApp::getPostedData('slide_screen', FatUtility::VAR_INT, 1);
        $languages = Language::getAllNames();
        $slideDetail = Slides::getAttributesById($recordId);
        if (false == $slideDetail) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $image = AttachedFile::getAttachment(AttachedFile::FILETYPE_HOME_PAGE_BANNER, $recordId, 0, $langId, false, $slideScreen);
        $this->set('image', $image);
        $this->set('imageFunction', 'Slide');
        $this->set('file_type', ImageDimension::VIEW_THUMB);
        $this->set('recordId', $recordId);
        $this->set('langId', $langId);
        $this->checkEditPrivilege(true);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function media($recordId = 0, $langId = 0, $slideScreen = 1)
    {
        $recordId = FatUtility::int($recordId);
        $imageFrm = $this->getMediaForm($recordId);
        $languages = Language::getAllNames();
        if (count($languages) == 1) {
            $langId = array_key_first($languages);
        }

        $slideImage = AttachedFile::getAttachment(AttachedFile::FILETYPE_HOME_PAGE_BANNER, $recordId, 0, $langId, false, applicationConstants::SCREEN_DESKTOP);
        $slideDimensions = ImageDimension::getSlideData();

        $this->set('image', $slideImage);
        $this->set('recordId', $recordId);
        $this->set('slideDimensions', $slideDimensions);
        $this->set('imageFrm', $imageFrm);
        $this->set('languageCount', count($languages));
        $this->set('langId', $langId);
        $this->checkEditPrivilege(true);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }


    private function getMediaForm($recordId = 0)
    {
        $frm = new Form('frmSlideMedia');
        $languagesAssocArr = Language::getAllNames();
        $frm->addHiddenField('', 'slide_id', $recordId);
        if (count($languagesAssocArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', array(0 => Labels::getLabel('FRM_Universal', $this->siteLangId)) + $languagesAssocArr, '', array(), '');
        } else {
            $lang_id = array_key_first($languagesAssocArr);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }
        $screenArr = applicationConstants::getDisplaysArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel("FRM_DISPLAY_FOR", $this->siteLangId), 'slide_screen', $screenArr, '', array(), '');
        $frm->addHiddenField('', 'file_type', AttachedFile::FILETYPE_HOME_PAGE_BANNER);
        $frm->addHiddenField('', 'min_width', 2000);
        $frm->addHiddenField('', 'min_height', 666);
        $frm->addHTML('', 'slide_image', '');
        return $frm;
    }
    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getFormColumns(): array
    {
        $slideTblHeadingCols = CacheHelper::get('slideTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($slideTblHeadingCols) {
            return json_decode($slideTblHeadingCols, true);
        }

        $arr = [
            // 'dragdrop' => '',
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            /*  'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'slide_media' => Labels::getLabel('LBL_MEDIA', $this->siteLangId),
            'slide_title' => Labels::getLabel('LBL_TITLE', $this->siteLangId),
            'slide_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('slideTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    /**
     * getDefaultColumns
     *
     * @return array
     */
    protected function getDefaultColumns(): array
    {
        return [
            // 'dragdrop',
            'select_all',
            /*  'listSerial', */
            'slide_media',
            'slide_title',
            'slide_active',
            'action',
        ];
    }

    /**
     * setCustomColumnWidth
     *
     * @return void
     */
    protected function setCustomColumnWidth(): void
    {
        $arr = [
            /* 'dragdrop' => [
                'width' => '5%'
            ], */
            'select_all' => [
                'width' => '5%'
            ],
            /* 'listSerial' => [
                'width' => '5%'
            ], */
            'slide_media' => [
                'width' => '35%'
            ],
            'slide_title' => [
                'width' => '35%'
            ],
            'slide_active' => [
                'width' => '10%'
            ],
            'action' => [
                'width' => '10%'
            ],
        ];
        $this->set('tableHeadAttrArr', $arr);
    }

    /**
     * excludeKeysForSort
     *
     * @param  mixed $fields
     * @return array
     */
    protected function excludeKeysForSort($fields = []): array
    {
        return [];
    }
}
