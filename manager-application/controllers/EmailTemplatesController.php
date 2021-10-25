<?php

class EmailTemplatesController extends AdminBaseController
{   

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewEmailTemplates();
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
            $this->set("canEdit", $this->objPrivilege->canEditEmailTemplates($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditEmailTemplates();
        }
    }

    /**
     * setModel - This function is used to set related model class and used by its parent class.
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setModel(array $constructorArgs = []): void
    {
        $this->modelObj = (new ReflectionClass('EmailTemplates'))->newInstanceArgs($constructorArgs);
    }

    // /**
    //  * setLangTemplateData - This function is use to automate load langform and save it. 
    //  *
    //  * @param  array $constructorArgs
    //  * @return void
    //  */
    // protected function setLangTemplateData(array $constructorArgs = []): void
    // {
    //     $this->checkEditPrivilege();
    //     $this->setModel($constructorArgs);
    //     $this->formLangFields = [$this->modelObj::tblFld('name')];
    //     $this->set('formTitle', Labels::getLabel('LBL_EMAIL_TEMPLATE_SETUP', $this->siteLangId));
    // }


    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set("frmSearch", $frmSearch);
        $this->set('pageTitle', Labels::getLabel('LBL_EMAIL_TEMPLATES', $this->siteLangId));
        $this->getListingData();
        $this->set('includeEditor', true);
        // $this->_template->addCss('css/cropper.css');
        //$this->_template->addJs(array('js/cropper.js', 'js/cropper-main.js', 'js/jscolor.js'));

        $this->_template->render();
    }   

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'email-templates/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    } 

    private function getListingData()
    {
        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_STRING, FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        if (!in_array($pageSize, applicationConstants::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }
        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_ASC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $searchForm = $this->getSearchForm($fields);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        $srch = EmailTemplates::getSearchObject();
        $srch->addOrder(EmailTemplates::DB_TBL_PREFIX . 'lang_id', 'ASC');
        $srch->addGroupBy(EmailTemplates::DB_TBL_PREFIX . 'code');

        if (!empty($post['keyword'])) {
            $cond = $srch->addCondition('etpl_code', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('etpl_name', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cond->attachCondition('etpl_subject', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);      
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->siteLangId));
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);

        $this->set('frmSearch', $searchForm);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->checkEditPrivilege(true);
    }

    public function sendTestMail()
    {
        $to = FatApp::getConfig("CONF_SITE_OWNER_EMAIL");
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 1);
        $tpl = FatApp::getPostedData('etpl_code', FatUtility::VAR_STRING, '');

        if (empty($tpl)) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_INVALID_TEMPLATE', $this->siteLangId));
        }

        if (!EmailHandler::sendMailTpl($to, $tpl, $langId)) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_MAIL_NOT_SENT', $this->siteLangId));
        }

        $this->set('msg', Labels::getLabel('LBL_Mail_Sent_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function testEmailTemplate($tpl)
    {
        $to = FatApp::getConfig("CONF_SITE_OWNER_EMAIL");
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 1);
        if (!EmailHandler::sendMailTpl($to, $tpl, $langId)) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_MAIL_NOT_SENT', $this->siteLangId));
        }

        $this->set('msg', Labels::getLabel('LBL_MAIL_SENT', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditEmailTemplates();
        $data = FatApp::getPostedData();

        $languages = Language::getAllNames();
		if(count($languages) > 1){
			 $lang_id =$data['lang_id'];
             
		} else  {
			$lang_id = array_key_first($languages); 
            $data['lang_id'] = $lang_id;
		}

        $frm = $this->getLangForm($data['etpl_code'], $lang_id);
        $post = $frm->getFormDataFromArray($data);
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $etplCode = $post['etpl_code'];

        $data = [
            'etpl_lang_id' => $lang_id,
            'etpl_code' => $etplCode,
            'etpl_name' => $post['etpl_name'],
            'etpl_subject' => $post['etpl_subject'],
            'etpl_body' => $post['etpl_body'],
        ];

        $etplCode = $data['etpl_code'];
        $etplObj = new EmailTemplates($etplCode);
        /*
        $record =  $etplObj->getEtpl($etplCode, $lang_id);
        if($record == false){
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieJsonError( Message::getHtml() );
        } */

        if (!$etplObj->addUpdateData($data)) {
            Message::addErrorMessage($etplObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(EmailTemplates::DB_TBL);
            if (false === $updateLangDataobj->updateTranslatedData($etplCode)) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getLangForm($etplCode = '', $lang_id = 0)
    {
        $this->objPrivilege->canViewEmailTemplates();
        $frm = new Form('frmEtplLang');
        $frm->addHiddenField('', 'etpl_code', $etplCode);
        
        $languages = Language::getAllNames();
		if(count($languages) > 1){
			 $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', $languages, $lang_id, array(), '');
		} else  {
			$lang_id = array_key_first($languages); 
			$frm->addHiddenField('', 'lang_id', $lang_id);
		}

		$frm->addRequiredField(Labels::getLabel('FRM_Name', $this->siteLangId), 'etpl_name');
        $frm->addRequiredField(Labels::getLabel('FRM_Subject', $this->siteLangId), 'etpl_subject');
        $fld = $frm->addHtmlEditor(Labels::getLabel('FRM_Body', $this->siteLangId), 'etpl_body');
        $fld->requirements()->setRequired(true);
        $frm->addHtml(Labels::getLabel('FRM_REPLACEMENT_VARS', $this->siteLangId), 'etpl_replacements', '');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('FRM_Save_Changes', $this->siteLangId));
        $fldTestEmail = $frm->addButton("", "test_email", Labels::getLabel('FRM_SEND_TEST_EMAIL', $this->siteLangId));
        $fld_submit->attachField($fldTestEmail);
        return $frm;
    }

    public function langForm($etplCode = '', $lang_id = 0, $autoFillLangData = 0)
    {      

        $lang_id = FatUtility::int($lang_id);

        if ($etplCode == '' || $lang_id == 0) {
            FatUtility::dieWithError($this->str_invalid_request);
        }

        $langFrm = $this->getLangForm($etplCode, $lang_id);

        
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(EmailTemplates::DB_TBL);
            $translatedData = $updateLangDataobj->getTranslatedData($etplCode, $lang_id);
            if (false === $translatedData) {
                Message::addErrorMessage($updateLangDataobj->getError());
                FatUtility::dieWithError(Message::getHtml());
            }
            $langData = current($translatedData);
        } else {
            $etplObj = new EmailTemplates($etplCode);
            $langData = $etplObj->getEtpl($etplCode, $lang_id);
    
        }       

        if ($langData) {
            $langFrm->fill($langData);
        }
        if (is_array($langData) && array_key_exists('etpl_replacements', $langData) && $langData['etpl_replacements'] == '') {
            $etplData = $etplObj->getEtpl($etplCode);
            $langFrm->getField('etpl_replacements')->value = $etplData['etpl_replacements'];
        }
        $this->set('languages', Language::getAllNames());
        $this->set('etplCode', $etplCode);
        $this->set('lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->_template->render(false, false);
        //$this->_template->render(false, false, '_partial/listing/lang-form.php');
    } 

    public function updateStatus()
    {
        $this->checkEditPrivilege();

        $etplCode = FatApp::getPostedData('etplCode', FatUtility::VAR_STRING, '');
        if ($etplCode == '') {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (!in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
      
        $etplObj = new EmailTemplates($etplCode);
        $records = $etplObj->getEtpl($etplCode);

        if ($records == false) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieWithError(Message::getHtml());
        }

        $this->updateEmailTplStatus($etplCode, $status);

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditEmailTemplates();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $etplCodesArr = FatApp::getPostedData('etpl_codes');
        if (empty($etplCodesArr) || -1 == $status) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }       
        foreach ($etplCodesArr as $etplCode) {
            if (empty($etplCode)) {
                continue;
            }      

            $this->updateEmailTplStatus($etplCode, $status);
        }
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateEmailTplStatus($etplCode, $status)
    {
        $status = FatUtility::int($status);
        if (empty($etplCode) || -1 == $status) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId)
            );
        }
        $etplObj = new EmailTemplates($etplCode);
        if (!$etplObj->activateEmailTemplate($status, $etplCode)) {
            Message::addErrorMessage($etplObj->getError());
            FatUtility::dieWithError(Message::getHtml());
        }
    }

    public function settingsForm($lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canViewEmailTemplates();

        $lang_id = FatUtility::int($lang_id);

        if ($lang_id == 0) {
            $lang_id = $this->siteLangId;
        }

        $settingFrm = $this->getSettingsForm($lang_id);
        $emailLogo = AttachedFile::getAttachment(AttachedFile::FILETYPE_EMAIL_LOGO, 0, 0, $lang_id);
        $this->set('logoImage', $emailLogo);
        $this->set('languages', Language::getAllNames());
        $this->set('lang_id', $lang_id);
        $this->set('settingFrm', $settingFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->_template->render(false, false);
    }

    public function setupSettings()
    {
        $this->objPrivilege->canEditEmailTemplates();
        $data = FatApp::getPostedData();

        $languages = Language::getAllNames();
		if(count($languages) > 1){
			 $lang_id = $data['lang_id'];
             
		} else  {
			$lang_id = array_key_first($languages); 
            $data['lang_id'] = $lang_id;
		}
        $frm = $this->getSettingsForm($lang_id);
        $post = $frm->getFormDataFromArray($data);
        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $record = new Configurations();
        if (!$record->update($post)) {
            Message::addErrorMessage($record->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getSettingsForm($lang_id = 0)
    {
        $this->objPrivilege->canViewEmailTemplates();

        $frm = new Form('frmEtplSettingsForm');

        $languages = Language::getAllNames();
		if(count($languages) > 1){
			 $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', $languages, $lang_id, array(), '');
		} else  {
			$lang_id = array_key_first($languages); 
			$frm->addHiddenField('', 'lang_id', $lang_id);
		}
       
        $fld = $frm->addTextBox(Labels::getLabel('FRM_Header_Background_color', $this->siteLangId), 'CONF_EMAIL_TEMPLATE_COLOR_CODE' . $lang_id, FatApp::getConfig('CONF_EMAIL_TEMPLATE_COLOR_CODE' . $lang_id, FatUtility::VAR_STRING, ''));
        $fld->addFieldTagAttribute('class', 'jscolor');

        $ratioArr = AttachedFile::getRatioTypeArray($this->siteLangId);
        //$frm->addSelectBox(Labels::getLabel('FRM_Logo_Ratio', $this->siteLangId), 'CONF_EMAIL_TEMPLATE_LOGO_RATIO', $ratioArr, AttachedFile::RATIO_TYPE_SQUARE, array(), '');
        $frm->addRadioButtons(Labels::getLabel('FRM_Logo_Ratio', $this->siteLangId), 'CONF_EMAIL_TEMPLATE_LOGO_RATIO', $ratioArr, AttachedFile::RATIO_TYPE_SQUARE);
        $frm->addHiddenField('', 'file_type', AttachedFile::FILETYPE_EMAIL_LOGO);
        $frm->addHiddenField('', 'logo_min_width');
        $frm->addHiddenField('', 'logo_min_height');
        $frm->addFileUpload(Labels::getLabel('FRM_Upload', $this->siteLangId), 'email_logo', array('accept' => 'image/*', 'data-frm' => 'frmEtplSettingsForm'));
        $fld = $frm->addHtmlEditor(Labels::getLabel('FRM_Footer_Content', $this->siteLangId), 'CONF_EMAIL_TEMPLATE_FOOTER_HTML' . $lang_id, FatApp::getConfig('CONF_EMAIL_TEMPLATE_FOOTER_HTML' . $lang_id, FatUtility::VAR_STRING, ''));
        $fld->requirements()->setRequired(true);


        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('FRM_Save_Changes', $this->siteLangId));
        return $frm;
    }

    public function uploadLogo()
    {
        $this->objPrivilege->canEditShops();
        $post = FatApp::getPostedData();
        $file_type = FatApp::getPostedData('file_type', FatUtility::VAR_INT, 0);
        $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 0);
        $aspectRatio = FatApp::getPostedData('ratio_type', FatUtility::VAR_INT, 0);

        if (!$file_type) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieJsonError(Message::getHtml());
        }

        $allowedFileTypeArr = array(AttachedFile::FILETYPE_EMAIL_LOGO);

        if (!in_array($file_type, $allowedFileTypeArr)) {
            Message::addErrorMessage($this->str_invalid_request);
            FatUtility::dieJsonError(Message::getHtml());
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            Message::addErrorMessage(Labels::getLabel('LBL_Please_Select_A_File', $this->siteLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $fileHandlerObj = new AttachedFile();
        if (!$res = $fileHandlerObj->saveImage($_FILES['cropped_image']['tmp_name'], $file_type, 0, 0, $_FILES['cropped_image']['name'], -1, true, $lang_id, '', 0, $aspectRatio)) {
            Message::addErrorMessage($fileHandlerObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $this->set('lang_id', $lang_id);
        $this->set('msg', Labels::getLabel('LBL_File_Uploaded_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeEmailLogo($lang_id = 0)
    {
        $lang_id = FatUtility::int($lang_id);
        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_EMAIL_LOGO, 0, 0, 0, $lang_id)) {
            Message::addErrorMessage($fileHandlerObj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }

        $this->set('msg', Labels::getLabel('MSG_Deleted_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getFormColumns(): array
    {
        $emptyCartItemsTblHeadingCols = CacheHelper::get('emptyCartItemsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($emptyCartItemsTblHeadingCols) {
            return json_decode($emptyCartItemsTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'etpl_name' => Labels::getLabel('LBL_NAME', $this->siteLangId),
            'etpl_status' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('emailTemplatesTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'etpl_name',
            'etpl_status',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['etpl_status'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
                $this->nodes = [           
                    ['title' => Labels::getLabel('LBL_EMAIL_TEMPLATES', $this->siteLangId)]
                ];
        }
        return $this->nodes;
    }
}
