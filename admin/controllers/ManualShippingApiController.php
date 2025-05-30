<?php

class ManualShippingApiController extends ListingBaseController
{
    private $canView;
    private $canEdit;
    
    public function __construct($action)
    {
        $ajaxCallArray = array('deleteRecord', 'form', 'langForm', 'search', 'setup', 'langSetup');
        if (!FatUtility::isAjaxCall() && in_array($action, $ajaxCallArray)) {
            die($this->str_invalid_Action);
        }
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewManualShippingApi($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditManualShippingApi($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }
    
    public function index()
    {
        $this->objPrivilege->canViewManualShippingApi();
        $frmSearch = $this->getSearchForm();
        $this->set("frmSearch", $frmSearch);
        $this->_template->render();
    }
    
    public function search()
    {
        $this->objPrivilege->canViewManualShippingApi();
        
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        
        $state_id = isset($data['state_id']) ? FatUtility::int($data['state_id']) : 0;
        
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        
        $obj = new ManualShippingApi();
        $srch = $obj->getListingObj($this->siteLangId, array('msa.*', 'msa_l.mshipapi_comment'));
        
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cond = $srch->addCondition('sd.sduration_identifier', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('sd_l.sduration_name', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cond->attachCondition('msa.mshipapi_zip', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cond->attachCondition('msa.mshipapi_cost', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cond->attachCondition('msa.mshipapi_volume_upto', 'like', '%' . $post['keyword'] . '%', 'OR');
            $cond->attachCondition('msa.mshipapi_weight_upto', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        
        $country_id = FatUtility::int($post['country_id']);
        if ($country_id > -1) {
            $srch->addCondition('c.country_id', '=', $country_id);
        }
        
        $sduration_id = FatUtility::int($post['sduration_id']);
        if ($sduration_id > -1) {
            $srch->addCondition('sd.sduration_id', '=', $sduration_id);
        }
        
        if ($state_id > 0) {
            $srch->addCondition('s.state_id', '=', $state_id);
        }
        
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $records = array();
        if ($rs) {
            $records = FatApp::getDb()->fetchAll($rs);
        }
        
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
    
    public function form($mshipapi_id = 0)
    {
        $this->objPrivilege->canViewManualShippingApi();
    
        $mshipapi_id = FatUtility::int($mshipapi_id);
        $frm = $this->getForm();

        $stateId = 0;
        if (0 < $mshipapi_id) {
            $data = ManualShippingApi::getAttributesById($mshipapi_id);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
            $stateId = $data['mshipapi_state_id'];
        }
    
        $this->set('languages', Language::getAllNames());
        $this->set('mshipapi_id', $mshipapi_id);
        $this->set('stateId', $stateId);
        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
    
    public function setup()
    {
        $this->objPrivilege->canEditManualShippingApi();

        $post = FatApp::getPostedData();
        
        $mshipapi_state_id = 0;
        if (isset($post['mshipapi_state_id'])) {
            $mshipapi_state_id = FatUtility::int($post['mshipapi_state_id']);
        }
        
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray($post);
        
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
        
        $post['mshipapi_state_id'] = $mshipapi_state_id;
        $mshipapi_id = $post['mshipapi_id'];
        unset($post['mshipapi_id']);
        
        $record = new ManualShippingApi($mshipapi_id);
        $record->assignValues($post);
        
        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }
        
        $newTabLangId = 0;
        if ($mshipapi_id > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = ManualShippingApi::getAttributesByLangId($langId, $mshipapi_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $mshipapi_id = $record->getMainTableRecordId();
            $newTabLangId = $this->siteLangId;
        }
        
        $this->set('msg', $this->str_setup_successful);
        $this->set('mshipapiId', $mshipapi_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }
    
    public function langForm($mshipapi_id = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canViewManualShippingApi();
        
        $mshipapi_id = FatUtility::int($mshipapi_id);
        $lang_id = FatUtility::int($lang_id);
        
        if ($mshipapi_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        
        $langFrm = $this->getLangForm($mshipapi_id, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(ManualShippingApi::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($mshipapi_id, $lang_id);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = ManualShippingApi::getAttributesByLangId($lang_id, $mshipapi_id);
        }
        
        if ($langData) {
            $langFrm->fill($langData);
        }
        
        $this->set('mshipapi_id', $mshipapi_id);
        $this->set('lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('languages', Language::getAllNames());
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
    
    public function langSetup()
    {
        $this->objPrivilege->canEditManualShippingApi();
        $post = FatApp::getPostedData();
        
        $mshipapi_id = $post['mshipapi_id'];
        $lang_id = $post['lang_id'];
        
        if ($mshipapi_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        
        $frm = $this->getLangForm($mshipapi_id, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        
        $data = array(
        'mshipapilang_mshipapi_id' => $mshipapi_id,
        'mshipapilang_lang_id' => $lang_id,
        'mshipapi_comment' => $post['mshipapi_comment'],
        );
        
        $obj = new ManualShippingApi($mshipapi_id);
        if (!$obj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
        
        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(ManualShippingApi::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($mshipapi_id)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = ManualShippingApi::getAttributesByLangId($langId, $mshipapi_id)) {
                $newTabLangId = $langId;
                break;
            }
        }
        
        $this->set('msg', $this->str_setup_successful);
        $this->set('mshipapiId', $mshipapi_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }
    
    public function deleteRecord()
    {
        $this->objPrivilege->canEditManualShippingApi();
        
        $mshipapi_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($mshipapi_id < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $obj = new ManualShippingApi($mshipapi_id);
        if (!$obj->canRecordDelete($mshipapi_id)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        
        if (!$obj->deleteRecord(true)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
        
        FatUtility::dieJsonSuccess($this->str_delete_record);
    }
    
    public function getSearchForm(array $fields = [])
    {
        $frm = new Form('frmManualShippingSearch');
        $f1 = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '');
        
        $shipDurationObj = new ShippingDurations();
        $durationArr = $shipDurationObj->getShippingDurationAssoc($this->siteLangId);
        $frm->addSelectbox(Labels::getLabel('FRM_DURATION', $this->siteLangId), 'sduration_id', array( -1 => 'Does not Matter' ) + $durationArr, '', array(), '');
        
        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesAssocArr($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_COUNTRY', $this->siteLangId), 'country_id', array( -1 => 'Does not Matter' ) + $countriesArr, '', array(), '');
        
        $frm->addSelectBox(Labels::getLabel('FRM_STATE', $this->siteLangId), 'state_id', array(), '', [], Labels::getLabel('LBL_Select', $this->siteLangId));
        
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);/*clearBtn*/
        return $frm;
    }
    
    private function getForm()
    {
        $this->objPrivilege->canViewManualShippingApi();
        
        $shipDurationObj = new ShippingDurations();
        $durationArr = $shipDurationObj->getShippingDurationAssoc($this->siteLangId);
        
        $frm = new Form('frmManualShipping');
        $frm->addHiddenField('', 'mshipapi_id', 0);
        $frm->addSelectbox(Labels::getLabel('FRM_DURATION', $this->siteLangId), 'mshipapi_sduration_id', $durationArr)->requirement->setRequired(true);
        $frm->addFloatField(Labels::getLabel('FRM_VOLUME_UPTO', $this->siteLangId), 'mshipapi_volume_upto');
        $frm->addFloatField(Labels::getLabel('FRM_WEIGHT_UPTO', $this->siteLangId), 'mshipapi_weight_upto');
        $frm->addFloatField(Labels::getLabel('FRM_COST', $this->siteLangId), 'mshipapi_cost');
        
        $countryObj = new Countries();
        $countriesArr = $countryObj->getCountriesAssocArr($this->siteLangId);
        $fld = $frm->addSelectBox(Labels::getLabel('FRM_COUNTRY', $this->siteLangId), 'mshipapi_country_id', $countriesArr, '', [], Labels::getLabel('FRM_SELECT', $this->siteLangId));
        
        $frm->addSelectBox(Labels::getLabel('FRM_STATE', $this->siteLangId), 'mshipapi_state_id', array(), '', [], Labels::getLabel('FRM_SELECT', $this->siteLangId));
        $frm->addTextbox(Labels::getLabel('FRM_POSTAL_CODE', $this->siteLangId), 'mshipapi_zip');
                
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }
    
    private function getLangForm($mshipapi_id = 0, $lang_id = 0)
    {
        $this->objPrivilege->canViewManualShippingApi();
        
        $mshipapi_id = FatUtility::int($mshipapi_id);
        $lang_id = FatUtility::int($lang_id);
        
        $frm = new Form('frmManualShippingLang');
        $frm->addHiddenField('', 'mshipapi_id', $mshipapi_id);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getAllNames(), $lang_id, array(), '');
        $frm->addTextarea(Labels::getLabel('FRM_COMMENTS', $this->siteLangId), 'mshipapi_comment');
        
        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }
}
