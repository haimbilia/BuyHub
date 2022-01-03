<?php

class EmailTemplatesController extends ListingBaseController
{
    protected string $pageKey = 'MANAGE_SMS_TEMPLATES';
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewEmailTemplates();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set("frmSearch", $frmSearch);
        $this->getListingData();
        $this->set('includeEditor', true);

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
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

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

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        $srch = EmailTemplates::getSearchObject(0, false);
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
        $this->set("canEdit", $this->objPrivilege->canEditEmailTemplates($this->admin_id, true));
    }

    public function sendTestMail()
    {
        $to = FatApp::getConfig("CONF_SITE_OWNER_EMAIL");
        $langId = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, 1);
        $tpl = FatApp::getPostedData('etpl_code', FatUtility::VAR_STRING, '');

        if (empty($tpl)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_TEMPLATE', $this->siteLangId), true);
        }

        if (false == (new FatMailer($langId, $tpl))->setTo($to)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_MAIL_NOT_SENT', $this->siteLangId), true);
        }

        $this->set('msg', Labels::getLabel('MSG_MAIL_SENT_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditEmailTemplates();
        $data = FatApp::getPostedData();

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = $data['lang_id'];
        } else {
            $lang_id = array_key_first($languages);
            $data['lang_id'] = $lang_id;
        }

        $frm = $this->getLangForm($data['etpl_code'], $lang_id);
        $post = $frm->getFormDataFromArray($data);
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
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

        if (!$etplObj->addUpdateData($data)) {
            LibHelper::exitWithError($etplObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(EmailTemplates::DB_TBL);
            if (false === $updateLangDataobj->updateTranslatedData($etplCode)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getLangForm($etplCode = '', $lang_id = 0)
    {
        $frm = new Form('frmEtplLang');
        $frm->addHiddenField('', 'etpl_code', $etplCode);

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', $languages, $lang_id, array(), '');
        } else {
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

        if (!empty($translatorSubscriptionKey) && 1 < count($languages) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        $frm->addHtml('', 'test_email', '');

        return $frm;
    }

    public function langForm($etplCode = '', $lang_id = 0, $autoFillLangData = 0)
    {
        $lang_id = FatUtility::int($lang_id);

        if ($etplCode == '' || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $langFrm = $this->getLangForm($etplCode, $lang_id);

        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(EmailTemplates::DB_TBL);
            $translatedData = $updateLangDataobj->getTranslatedData($etplCode, $lang_id);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
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
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditEmailTemplates();

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
            LibHelper::exitWithError($this->str_invalid_request, true);
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
            LibHelper::exitWithError($this->str_invalid_request, true);
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
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $etplObj = new EmailTemplates($etplCode);
        if (!$etplObj->activateEmailTemplate($status, $etplCode)) {
            LibHelper::exitWithError($etplObj->getError(), true);
        }
    }

    public function settingsForm($lang_id = 0, $autoFillLangData = 0)
    {
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
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setupSettings()
    {
        $this->objPrivilege->canEditEmailTemplates();
        $data = FatApp::getPostedData();

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = $data['lang_id'];
        } else {
            $lang_id = array_key_first($languages);
            $data['lang_id'] = $lang_id;
        }
        $frm = $this->getSettingsForm($lang_id);
        $post = $frm->getFormDataFromArray($data);
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $record = new Configurations();
        if (!$record->update($post)) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getSettingsForm($lang_id = 0)
    {

        $frm = new Form('frmEtplSettingsForm');

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', $languages, $lang_id, array(), '');
        } else {
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
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $allowedFileTypeArr = array(AttachedFile::FILETYPE_EMAIL_LOGO);

        if (!in_array($file_type, $allowedFileTypeArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('ERR_Please_Select_A_File', $this->siteLangId), true);
        }

        $fileHandlerObj = new AttachedFile();
        if (!$res = $fileHandlerObj->saveImage($_FILES['cropped_image']['tmp_name'], $file_type, 0, 0, $_FILES['cropped_image']['name'], -1, true, $lang_id, '', 0, $aspectRatio)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('lang_id', $lang_id);
        $this->set('msg', Labels::getLabel('SUC_File_Uploaded_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeEmailLogo($lang_id = 0)
    {
        $lang_id = FatUtility::int($lang_id);
        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_EMAIL_LOGO, 0, 0, 0, $lang_id)) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('SUC_Deleted_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function getFormColumns(): array
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

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'etpl_name',
            'etpl_status',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'index':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_SETTINGS', $this->siteLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => $pageTitle]
                ];
        }
        return $this->nodes;
    }
}
