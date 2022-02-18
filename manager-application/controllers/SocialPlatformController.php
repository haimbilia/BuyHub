<?php

class SocialPlatformController extends ListingBaseController
{

    protected string $modelClass = 'SocialPlatform';
    protected $pageKey = 'SOCIAL_PLATFORM';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSocialPlatforms();      
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
            $this->set("canEdit", $this->objPrivilege->canEditSocialPlatforms($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditSocialPlatforms();
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
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->set('formTitle', Labels::getLabel('LBL_SOCIAL_PLATFORM_SETUP', $this->siteLangId));
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $actionItemsData['deleteButton'] = true;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->getListingData();

        $this->_template->addCss('css/cropper.css');
        $this->_template->addJs(['js/cropper.js', 'js/cropper-main.js','social-platform/page-js/index.js']);
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_TITLE', $this->siteLangId));       
        $this->_template->render(true, true, '_partial/listing/index.php');        
    }    

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'social-platform/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $data = FatApp::getPostedData();

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) + $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields = FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $searchForm = $this->getSearchForm($fields);

        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = SocialPlatform::getSearchObject($this->siteLangId, false);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('splatform_user_id', '=', 0);
        //splatform_id
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("arrListing", $records);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);       
        $this->checkEditPrivilege(true);
    }
    
    public function form()
    {       
        $this->checkEditPrivilege();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
       
        $frm = $this->getForm();

        if (0 < $recordId) {
            $data = SocialPlatform::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $recordId, array('*', 'IFNULL(splatform_title,splatform_identifier) as splatform_title'), applicationConstants::JOIN_RIGHT);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }
      
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->checkEditPrivilege();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['splatform_id'];        
        $data = $post;
        $data['splatform__identifier'] = $data['splatform_title'];

        $recordObj = new SocialPlatform($recordId);
        $recordObj->assignValues($data, true);
        if (!$recordObj->save()) {
            LibHelper::exitWithError($recordObj->getError(), true);
        }

        $this->setLangData($recordObj, [$recordObj::tblFld('title') => $data[$recordObj::tblFld('title')]]);
       
        $this->_template->render(false, false, 'json-success.php');
    } 
   
    public function media($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request);
        }

        $data = SocialPlatform::getAttributesById($recordId);
        if (false == $data) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getMediaForm($recordId);

        $image = AttachedFile::getAttachment(AttachedFile::FILETYPE_SOCIAL_PLATFORM_IMAGE, $recordId);
        $this->set('image', $image);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);       
        $this->checkEditPrivilege(true);
        $this->set('html', $this->_template->render(false, false, NULL, true));      
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function uploadMedia()
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('splatform_id', FatUtility::VAR_INT, 0);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_SELECT_A_FILE', $this->siteLangId), true);
        }

        $fileHandlerObj = new AttachedFile();
        $fileHandlerObj->deleteFile(AttachedFile::FILETYPE_SOCIAL_PLATFORM_IMAGE, $recordId);
        if (!$fileHandlerObj->saveAttachment(
            $_FILES['cropped_image']['tmp_name'],
            AttachedFile::FILETYPE_SOCIAL_PLATFORM_IMAGE,
            $recordId,
            0,
            $_FILES['cropped_image']['name'],
            -1
        )) {
            LibHelper::exitWithError($fileHandlerObj->getError());
        }

        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('recordId', $recordId);
        $this->set('msg', $_FILES['cropped_image']['name'] . ' ' . Labels::getLabel('MSG_FILE_UPLOADED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeMedia()
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request);
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_SOCIAL_PLATFORM_IMAGE, $recordId)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('LBL_Deleted_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditSocialPlatforms();

        $splatform_id = FatApp::getPostedData('splatformId', FatUtility::VAR_INT, 0);
        if ($splatform_id < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($splatform_id);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditSocialPlatforms();
        $splatformIdsArr = FatUtility::int(FatApp::getPostedData('splatform_ids'));

        if (empty($splatformIdsArr)) {
            LibHelper::exitWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true
            );
        }

        foreach ($splatformIdsArr as $splatform_id) {
            if (1 > $splatform_id) {
                continue;
            }
            $this->markAsDeleted($splatform_id);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted($splatform_id)
    {
        $splatform_id = FatUtility::int($splatform_id);
        if (1 > $splatform_id) {
            LibHelper::exitWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true
            );
        }
        $obj = new SocialPlatform($splatform_id);
        if (!$obj->deleteRecord(true)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditSocialPlatforms();
        $splatformId = FatApp::getPostedData('splatformId', FatUtility::VAR_INT, 0);
        if (0 >= $splatformId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = SocialPlatform::getAttributesById($splatformId, array('splatform_id', 'splatform_active'));

        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $status = ($data['splatform_active'] == applicationConstants::ACTIVE) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

        $this->updateSocialPlatformStatus($splatformId, $status);

        FatUtility::dieJsonSuccess($this->str_update_record);
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditSocialPlatforms();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $splatformIdsArr = FatUtility::int(FatApp::getPostedData('splatform_ids'));
        if (empty($splatformIdsArr) || -1 == $status) {
            LibHelper::exitWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true
            );
        }

        foreach ($splatformIdsArr as $splatformId) {
            if (1 > $splatformId) {
                continue;
            }

            $this->updateSocialPlatformStatus($splatformId, $status);
        }
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateSocialPlatformStatus($splatformId, $status)
    {
        $status = FatUtility::int($status);
        $splatformId = FatUtility::int($splatformId);
        if (1 > $splatformId || -1 == $status) {
            LibHelper::exitWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true
            );
        }

        $socialPlatObj = new SocialPlatform($splatformId);
        if (!$socialPlatObj->changeStatus($status)) {
            LibHelper::exitWithError($socialPlatObj->getError(), true);
        }
    }

    private function isMediaUploaded($splatformId)
    {
        if ($attachment = AttachedFile::getAttachment(AttachedFile::FILETYPE_SOCIAL_PLATFORM_IMAGE, $splatformId, 0)) {
            return true;
        }
        return false;
    }

    private function getForm()
    {       
        $frm = new Form('frmSocialPlatform');
        $frm->addHiddenField('', 'splatform_id');
        $fld = $frm->addRequiredField(Labels::getLabel('FRM_TITLE', $this->siteLangId), 'splatform_title');
       // $fld->setUnique(SocialPlatform::DB_TBL, 'splatform_identifier', 'splatform_id', 'splatform_id', 'splatform_id');

        $urlFld = $frm->addTextBox(Labels::getLabel('FRM_URL', $this->siteLangId), 'splatform_url');
		$urlFld->requirements()->setRegularExpressionToValidate(ValidateElement::URL_REGEX);
        $urlFld->requirements()->setCustomErrorMessage(Labels::getLabel('FRM_THIS_MUST_BE_AN_ABSOLUTE_URL', $this->siteLangId));
		$urlFld->requirements()->setRequired();

        $fld = $frm->addSelectBox(Labels::getLabel('FRM_ICON_TYPE_FROM_CSS', $this->siteLangId), 'splatform_icon_class', SocialPlatform::getIconArr($this->siteLangId), '', [], Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $fld->htmlAfterField = '<small>' . Labels::getLabel('FRM_IF_YOU_HAVE_TO_ADD_A_PLATFORM_ICON_EXCEPT_THIS_SELECT_LIST', $this->siteLangId) . '</small>';
        
        $frm->addCheckBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'splatform_active', applicationConstants::ACTIVE, array(), true, applicationConstants::INACTIVE);

        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    protected function getLangForm($recordId = 0, $langId = 0)
    {
        $frm = new Form('frmSocialPlatformLang');
        $frm->addHiddenField('', 'splatform_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_TITLE', $this->siteLangId), 'splatform_title');
        return $frm;
    }

    private function getMediaForm($splatform_id = 0)
    {
        $frm = new Form('frmSocialPlatformMedia');
        $frm->addHiddenField('', 'splatform_id', $splatform_id);
        $frm->addHtml('', 'image', '');       
        return $frm;
    }    

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('socialPlatformTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'splatform_identifier' => Labels::getLabel('LBL_Title', $this->siteLangId),
            'splatform_url' => Labels::getLabel('LBL_URL', $this->siteLangId),          
            'splatform_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('socialPlatformTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',         
            'splatform_identifier',
            'splatform_url',
            'splatform_active',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['splatform_url'], Common::excludeKeysForSort());
    }
}
