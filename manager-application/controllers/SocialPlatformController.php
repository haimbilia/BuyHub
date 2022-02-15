<?php

class SocialPlatformController extends ListingBaseController
{
    private $canView;
    private $canEdit;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewSocialPlatforms($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditSocialPlatforms($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->objPrivilege->canViewSocialPlatforms();
        $this->_template->addCss('css/cropper.css');
        $this->_template->addJs('js/cropper.js');
        $this->_template->addJs('js/cropper-main.js');
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewSocialPlatforms();

        $srch = SocialPlatform::getSearchObject($this->siteLangId, false);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('splatform_user_id', '=', 0);
        $srch->addOrder('splatform_id', 'DESC');
        $rs = $srch->getResultSet();

        $records = array();
        if ($rs) {
            $records = FatApp::getDb()->fetchAll($rs);
        }
        $this->set("arrListing", $records);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function form($splatform_id = 0)
    {
        $this->objPrivilege->canViewSocialPlatforms();

        $splatform_id = FatUtility::int($splatform_id);
        $frm = $this->getForm();

        if (0 < $splatform_id) {
            $data = SocialPlatform::getAttributesById($splatform_id);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('splatform_id', $splatform_id);
        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditSocialPlatforms();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $splatform_id = $post['splatform_id'];
        unset($post['splatform_id']);
        $data_to_be_save = $post;

        $recordObj = new SocialPlatform($splatform_id);
        $recordObj->assignValues($data_to_be_save, true);
        if (!$recordObj->save()) {
            LibHelper::exitWithError($recordObj->getError(), true);
        }

        $splatform_id = $recordObj->getMainTableRecordId();

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = SocialPlatform::getAttributesByLangId($langId, $splatform_id)) {
                $newTabLangId = $langId;
                break;
            }
        }
        if ($newTabLangId == 0 && !$this->isMediaUploaded($splatform_id)) {
            $this->set('openMediaForm', true);
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('splatformId', $splatform_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($splatform_id = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canViewSocialPlatforms();

        $splatform_id = FatUtility::int($splatform_id);
        $lang_id = FatUtility::int($lang_id);

        if ($splatform_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $langFrm = $this->getLangForm($splatform_id, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(SocialPlatform::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($splatform_id, $lang_id);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = SocialPlatform::getAttributesByLangId($lang_id, $splatform_id);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('splatform_id', $splatform_id);
        $this->set('splatform_lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditSocialPlatforms();
        $post = FatApp::getPostedData();
        $splatform_id = FatUtility::int($post['splatform_id']);
        
        $languages = Language::getAllNames();
        if(count($languages) > 1){
            $lang_id = $post['lang_id'];
        } else  {
            $lang_id = array_key_first($languages); 
            $post['lang_id'] = $lang_id;
        }
        
        if ($splatform_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $frm = $this->getLangForm($splatform_id, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['splatform_id']);
        unset($post['lang_id']);
        $data_to_update = array(
        'splatformlang_splatform_id' => $splatform_id,
        'splatformlang_lang_id' => $lang_id,
        'splatform_title' => $post['splatform_title'],
        );

        $socialObj = new SocialPlatform($splatform_id);
        if (!$socialObj->updateLangData($lang_id, $data_to_update)) {
            LibHelper::exitWithError($socialObj->getError(), true);
        }
        
        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(SocialPlatform::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($splatform_id)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = SocialPlatform::getAttributesByLangId($langId, $splatform_id)) {
                $newTabLangId = $langId;
                break;
            }
        }
        if ($newTabLangId == 0 && !$this->isMediaUploaded($splatform_id)) {
            $this->set('openMediaForm', true);
        }
        $this->set('msg', Labels::getLabel('LBL_Social_Platform_Setup_Successful', $this->siteLangId));
        $this->set('splatformId', $splatform_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function mediaForm($splatform_id)
    {
        $splatform_id = FatUtility::int($splatform_id);
        $splatformDetail = SocialPlatform::getAttributesById($splatform_id);
        if (false == $splatformDetail) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getMediaForm($splatform_id);

        if (!false == $splatformDetail) {
            $img = AttachedFile::getAttachment(AttachedFile::FILETYPE_SOCIAL_PLATFORM_IMAGE, $splatform_id);
            $this->set('img', $img);
        }

        $this->set('splatform_id', $splatform_id);
        $this->set('frm', $frm);
        $this->set('languages', Language::getAllNames());
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setUpImage($splatform_id)
    {
        $splatform_id = FatUtility::int($splatform_id);
        if (!$splatform_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (!is_uploaded_file($_FILES['cropped_image']['tmp_name'])) {
            LibHelper::exitWithError(Labels::getLabel('LBL_Please_select_a_file', $this->siteLangId), true);
        }

        $fileHandlerObj = new AttachedFile();
        $fileHandlerObj->deleteFile(AttachedFile::FILETYPE_SOCIAL_PLATFORM_IMAGE, $splatform_id);
        if (!$res = $fileHandlerObj->saveAttachment(
            $_FILES['cropped_image']['tmp_name'],
            AttachedFile::FILETYPE_SOCIAL_PLATFORM_IMAGE,
            $splatform_id,
            0,
            $_FILES['cropped_image']['name'],
            -1
        )
        ) {
            LibHelper::exitWithError($fileHandlerObj->getError(), true);
        }

        $this->set('file', $_FILES['cropped_image']['name']);
        $this->set('splatform_id', $splatform_id);
        $this->set('msg', $_FILES['cropped_image']['name'] . ' ' . Labels::getLabel('LBL_Uploaded_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function removeImage($splatform_id)
    {
        $splatform_id = FatUtility::int($splatform_id);
        if (!$splatform_id) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_SOCIAL_PLATFORM_IMAGE, $splatform_id)) {
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
        $this->objPrivilege->canViewSocialPlatforms();

        $frm = new Form('frmSocialPlatform');
        $frm->addHiddenField('', 'splatform_id', 0);
        $fld = $frm->addRequiredField(Labels::getLabel('FRM_IDENTIFIER', $this->siteLangId), 'splatform_identifier');
        $fld->setUnique(SocialPlatform::DB_TBL, 'splatform_identifier', 'splatform_id', 'splatform_id', 'splatform_id');

        $urlFld = $frm->addTextBox(Labels::getLabel('FRM_URL', $this->siteLangId), 'splatform_url');
		$urlFld->requirements()->setRegularExpressionToValidate(ValidateElement::URL_REGEX);
        $urlFld->requirements()->setCustomErrorMessage(Labels::getLabel('FRM_THIS_MUST_BE_AN_ABSOLUTE_URL', $this->siteLangId));
		$urlFld->requirements()->setRequired();
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_ICON_TYPE_FROM_CSS', $this->siteLangId), 'splatform_icon_class', SocialPlatform::getIconArr($this->siteLangId), '', [], Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $fld->htmlAfterField = '<small>' . Labels::getLabel('FRM_IF_YOU_HAVE_TO_ADD_A_PLATFORM_ICON_EXCEPT_THIS_SELECT_LIST', $this->siteLangId) . '</small>';

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'splatform_active', $activeInactiveArr, '', array(), '');

    
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('FRM_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    private function getLangForm($splatform_id = 0, $lang_id = 0)
    {
        $frm = new Form('frmSocialPlatformLang');
        $frm->addHiddenField('', 'splatform_id', $splatform_id);

        $languages = Language::getAllNames();
		if(count($languages) > 1){
			 $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', $languages, $lang_id, array(), '');
		} else  {
			$lang_id = array_key_first($languages); 
			$frm->addHiddenField('', 'lang_id', $lang_id);
		}
        
        $frm->addRequiredField(Labels::getLabel('FRM_TITLE', $this->siteLangId), 'splatform_title');
        
        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_UPDATE', $this->siteLangId));
        return $frm;
    }

    private function getMediaForm($splatform_id = 0)
    {
        $frm = new Form('frmSocialPlatformMedia');
        $frm->addHiddenField('', 'splatform_id', $splatform_id);
        $frm->addFileUpload(Labels::getLabel('FRM_UPLOAD', $this->siteLangId), 'image', array('accept' => 'image/*', 'data-frm' => 'frmSocialPlatformMedia'));
        return $frm;
    }
}
