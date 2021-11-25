<?php

class TestimonialsController extends ListingBaseController
{
    protected $modelClass = 'Testimonial';
    protected $pageKey = 'MANAGE_TESTIMONIAL';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewTestimonial();
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
        $this->modelObj = (new ReflectionClass('Faq'))->newInstanceArgs($constructorArgs);
        $this->formLangFields = [
            'testimoniallang_testimonial_id',
            'testimoniallang_lang_id',
            'testimonial_title',
            'testimonial_text'
        ];
        $this->set('formTitle', Labels::getLabel('LBL_TESTIMONIAL_SETUP', $this->siteLangId));
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
            $this->set("canEdit", $this->objPrivilege->canEditTestimonial($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditTestimonial();
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
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_TITLE', $this->siteLangId));
        $this->checkEditPrivilege(true);
        $this->getListingData();
        
        $this->_template->addCss('css/cropper.css');
        $this->_template->addJs('js/cropper.js');
        $this->_template->addJs('js/cropper-main.js');
        $this->_template->render(true,true, '_partial/listing/index.php');
    }

    // public function search()
    // {
        

    //     $srch = Testimonial::getSearchObject($this->siteLangId, false);

    //     $srch->addMultipleFields(array('t.*', 't_l.testimonial_title', 't_l.testimonial_text'));
    //     $srch->addOrder('testimonial_active', 'desc');
    //     $srch->addOrder('testimonial_added_on', 'desc');
    //     $rs = $srch->getResultSet();
    //     $records = array();
    //     if ($rs) {
    //         $records = FatApp::getDb()->fetchAll($rs);
    //     }

    //     $this->set("arrListing", $records);
    //     $this->set('recordCount', $srch->recordCount());
    //     $this->_template->render(false, false);
    // }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'faq/search.php', true),
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
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $searchForm = $this->getSearchForm($fields);
        $post = $searchForm->getFormDataFromArray($data);
        $srch = Testimonial::getSearchObject($this->siteLangId, false);

        $srch->addMultipleFields(array('t.*', 't_l.testimonial_title', 't_l.testimonial_text'));
        $srch->addOrder('testimonial_active', 'desc');
        $srch->addOrder('testimonial_added_on', 'desc');
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
    
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        $this->set('sortBy', 'faq_display_order');
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->checkEditPrivilege(true);
    }


    public function form($testimonialId)
    {
        $testimonialId = FatUtility::int($testimonialId);

        $frm = $this->getForm($testimonialId);

        if (0 < $testimonialId) {
            $data = Testimonial::getAttributesById($testimonialId, array('testimonial_id', 'testimonial_identifier', 'testimonial_active', 'testimonial_user_name'));

            if ($data === false) {
                FatUtility::dieWithError($this->str_invalid_request);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('testimonial_id', $testimonialId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditTestimonial();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $testimonialId = $post['testimonial_id'];
        unset($post['testimonial_id']);
        if ($testimonialId == 0) {
            $post['testimonial_added_on'] = date('Y-m-d H:i:s');
        }
        $record = new Testimonial($testimonialId);
        $record->assignValues($post);
        if (!$record->save()) {
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $newTabLangId = 0;
        if ($testimonialId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = Testimonial::getAttributesByLangId($langId, $testimonialId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $testimonialId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }
        if ($newTabLangId == 0 && !$this->isMediaUploaded($testimonialId)) {
            $this->set('openMediaForm', true);
        }
        $this->set('msg', $this->str_setup_successful);
        $this->set('testimonialId', $testimonialId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($testimonialId = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        
        $testimonialId = FatUtility::int($testimonialId);
        $lang_id = FatUtility::int($lang_id);

        if ($testimonialId == 0 || $lang_id == 0) {
            FatUtility::dieWithError($this->str_invalid_request);
        }

        $langFrm = $this->getLangForm($testimonialId, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(Testimonial::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($testimonialId, $lang_id);
            if (false === $translatedData) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
            $langData = current($translatedData);
        } else {
            $langData = Testimonial::getAttributesByLangId($lang_id, $testimonialId);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('testimonialId', $testimonialId);
        $this->set('lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->_template->render(false, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditTestimonial();
        $post = FatApp::getPostedData();

        $testimonialId = $post['testimonial_id'];
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = $post['lang_id'];
        } else {
            $lang_id = array_key_first($languages);
            $post['lang_id'] = $lang_id;
        }


        if ($testimonialId == 0 || $lang_id == 0) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieWithError(Message::getHtml());
        }

        $frm = $this->getLangForm($testimonialId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['testimonial_id']);
        unset($post['lang_id']);

        $data = array(
            'testimoniallang_lang_id' => $lang_id,
            'testimoniallang_testimonial_id' => $testimonialId,
            'testimonial_title' => $post['testimonial_title'],
            'testimonial_text' => $post['testimonial_text']
        );

        $obj = new Testimonial($testimonialId);

        if (!$obj->updateLangData($lang_id, $data)) {
            Message::addErrorMessage($obj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(Testimonial::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($testimonialId)) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = Testimonial::getAttributesByLangId($langId, $testimonialId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        if ($newTabLangId == 0 && !$this->isMediaUploaded($testimonialId)) {
            $this->set('openMediaForm', true);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('testimonialId', $testimonialId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    // public function changeStatus()
    // {
    //     $this->objPrivilege->canEditTestimonial();
    //     $testimonialId = FatApp::getPostedData('testimonialId', FatUtility::VAR_INT, 0);
    //     if (0 >= $testimonialId) {
    //         Message::addErrorMessage($this->str_invalid_request_id);
    //         FatUtility::dieWithError(Message::getHtml());
    //     }

    //     $data = Testimonial::getAttributesById($testimonialId, array('testimonial_id', 'testimonial_active'));

    //     if ($data == false) {
    //         Message::addErrorMessage($this->str_invalid_request);
    //         FatUtility::dieWithError(Message::getHtml());
    //     }

    //     $status = ($data['testimonial_active'] == applicationConstants::ACTIVE) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

    //     $this->updateTestimonialStatus($testimonialId, $status);

    //     FatUtility::dieJsonSuccess($this->str_update_record);
    // }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditTestimonial();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $testimonialIdsArr = FatUtility::int(FatApp::getPostedData('testimonial_ids'));
        if (empty($testimonialIdsArr) || -1 == $status) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }

        foreach ($testimonialIdsArr as $testimonialId) {
            if (1 > $testimonialId) {
                continue;
            }

            $this->updateTestimonialStatus($testimonialId, $status);
        }
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateTestimonialStatus($testimonialId, $status)
    {
        $status = FatUtility::int($status);
        $testimonialId = FatUtility::int($testimonialId);
        if (1 > $testimonialId || -1 == $status) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }

        $obj = new Testimonial($testimonialId);
        if (!$obj->changeStatus($status)) {
            Message::addErrorMessage($obj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditTestimonial();

        $testimonial_id = FatApp::getPostedData('testimonialId', FatUtility::VAR_INT, 0);
        if ($testimonial_id < 1) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieJsonError(Message::getHtml());
        }
        $this->markAsDeleted($testimonial_id);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditTestimonial();
        $testimonialIdsArr = FatUtility::int(FatApp::getPostedData('testimonial_ids'));

        if (empty($testimonialIdsArr)) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }

        foreach ($testimonialIdsArr as $testimonial_id) {
            if (1 > $testimonial_id) {
                continue;
            }
            $this->markAsDeleted($testimonial_id);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function markAsDeleted($testimonial_id)
    {
        $testimonial_id = FatUtility::int($testimonial_id);
        if (1 > $testimonial_id) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }
        $testimonialObj = new Testimonial($testimonial_id);
        if (!$testimonialObj->canRecordMarkDelete($testimonial_id)) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieJsonError(Message::getHtml());
        }

        $testimonialObj->assignValues(array(Testimonial::tblFld('deleted') => 1));
        if (!$testimonialObj->save()) {
            Message::addErrorMessage($testimonialObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
    }


    public function media($testimonialId = 0)
    {
        $this->objPrivilege->canEditTestimonial();
        $testimonialId = FatUtility::int($testimonialId);

        $testimonialMediaFrm = $this->getMediaForm($testimonialId);
        $testimonialImages = AttachedFile::getMultipleAttachments(AttachedFile::FILETYPE_TESTIMONIAL_IMAGE, $testimonialId, 0, -1);
        //$bannerTypeArr = applicationConstants::bannerTypeArr();

        $this->set('languages', Language::getAllNames());
        $this->set('testimonialId', $testimonialId);
        $this->set('testimonialMediaFrm', $testimonialMediaFrm);
        $this->set('testimonialImages', $testimonialImages);
        $this->_template->render(false, false);
    }

    public function getMediaForm($testimonialId)
    {
        $frm = new Form('frmTestimonialMedia');
        $frm->addHiddenField('', 'testimonial_id', $testimonialId);
        $frm->addHiddenField('', 'file_type', AttachedFile::FILETYPE_TESTIMONIAL_IMAGE);
        $frm->addFileUpload(Labels::getLabel('LBL_Upload', $this->siteLangId), 'testimonial_image', array('accept' => 'image/*', 'data-frm' => 'frmTestimonialMedia'));
        $frm->addHtml('', 'testimonial_image_display_div', '');

        return $frm;
    }

    public function uploadTestimonialMedia()
    {
        $this->objPrivilege->canEditTestimonial();
        $post = FatApp::getPostedData();
        if (empty($post)) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_Invalid_Request_Or_File_not_supported', $this->siteLangId));
        }
        $testimonialId = FatApp::getPostedData('testimonial_id', FatUtility::VAR_INT, 0);
        $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        if (!$testimonialId) {
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_Please_Select_A_File', $this->siteLangId));
        }

        $fileHandlerObj = new AttachedFile();
        $fileHandlerObj->deleteFile($fileHandlerObj::FILETYPE_TESTIMONIAL_IMAGE, $testimonialId, 0, 0, $lang_id);

        if (!$res = $fileHandlerObj->saveImage(
            $_FILES['cropped_image']['tmp_name'],
            $fileHandlerObj::FILETYPE_TESTIMONIAL_IMAGE,
            $testimonialId,
            0,
            $_FILES['cropped_image']['name'],
            -1,
            $unique_record = false,
            $lang_id
        )) {
            FatUtility::dieJsonError($fileHandlerObj->getError());
        }

        $this->set('testimonialId', $testimonialId);
        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('msg', $_FILES['cropped_image']['name'] . Labels::getLabel('MSG_File_Uploaded_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeTestimonialImage($testimonialId = 0, $lang_id = 0)
    {
        $testimonialId = FatUtility::int($testimonialId);
        $lang_id = FatUtility::int($lang_id);
        if (!$testimonialId) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieJsonError(Message::getHtml());
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_TESTIMONIAL_IMAGE, $testimonialId, 0, 0, $lang_id)) {
            Message::addErrorMessage($fileHandlerObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $this->set('msg', Labels::getLabel('MSG_Deleted_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($testimonialId = 0)
    {
        
        $testimonialId = FatUtility::int($testimonialId);

        $frm = new Form('frmTestimonial');
        $frm->addHiddenField('', 'testimonial_id', $testimonialId);
        $frm->addRequiredField(Labels::getLabel('LBL_Testimonial_Identifier', $this->siteLangId), 'testimonial_identifier');
        $frm->addRequiredField(Labels::getLabel('LBL_Testimonial_User_Name', $this->siteLangId), 'testimonial_user_name');

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), 'testimonial_active', $activeInactiveArr, '', array(), '');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->siteLangId));
        return $frm;
    }

    private function getLangForm($testimonialId = 0, $lang_id = 0)
    {
        
        $frm = new Form('frmTestimonialLang');
        $frm->addHiddenField('', 'testimonial_id', $testimonialId);

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->siteLangId), 'lang_id', $languages, $lang_id, array(), '');
        } else {
            $lang_id = array_key_first($languages);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }

        $frm->addRequiredField(Labels::getLabel('LBL_Testimonial_Title', $this->siteLangId), 'testimonial_title');
        $fld = $frm->addTextarea(Labels::getLabel('LBL_Testimonial_Text', $this->siteLangId), 'testimonial_text');
        $fld->requirements()->setRequired();

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->siteLangId));
        return $frm;
    }

    private function isMediaUploaded($testimonialId)
    {
        if ($attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_TESTIMONIAL_IMAGE, $testimonialId, 0)) {
            return true;
        }
        return false;
    }

    public function autoComplete()
    {
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE');
        $post = FatApp::getPostedData();

        $srch = Testimonial::getSearchObject($this->siteLangId, false);
        $srch->addMultipleFields(array('testimonial_id', 'IFNULL(testimonial_title, testimonial_identifier) as testimonial_title'));

        if (!empty($post['keyword'])) {
            $cond = $srch->addCondition('testimonial_title', 'LIKE', '%' . $post['keyword'] . '%');
            $cond->attachCondition('testimonial_identifier', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
        }

        $collectionId = FatApp::getPostedData('collection_id', FatUtility::VAR_INT, 0);
        $alreadyAdded = Collections::getRecords($collectionId);
        if (!empty($alreadyAdded) && 0 < count($alreadyAdded)) {
            $srch->addCondition('testimonial_id', 'NOT IN', array_keys($alreadyAdded));
        }

        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        $posts = $db->fetchAll($rs, 'testimonial_id');
        $json = array();
        foreach ($posts as $key => $post) {
            $json[] = array(
                'id' => $key,
                'name' => strip_tags(html_entity_decode($post['testimonial_title'], ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode($json));
    }

     /**
     * Undocumented function
     *
     * @return array
     */
    protected function getFormColumns(): array
    {
        $testimonialTblHeadingCols = CacheHelper::get('testimonialTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($testimonialTblHeadingCols) {
            return json_decode($testimonialTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'testimonial_title' => Labels::getLabel('LBL_TESTIMONIAL_TITLE', $this->siteLangId),
            'testimonial_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('testimonialTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'testimonial_title',
            'testimonial_active',
            'action',
        ];
    }

    /**
     * Undocumented function
     *
     * @param array $fields
     * @return array
     */
    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['testimonial_id', 'testimonial_active'], Common::excludeKeysForSort());
    }
}
