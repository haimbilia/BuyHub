<?php

class PolicyPointsController extends ListingBaseController
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
        $this->canView = $this->objPrivilege->canViewPolicyPoints($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditPolicyPoints($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->objPrivilege->canViewPolicyPoints();
        $this->_template->addJs('js/import-export.js');
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewPolicyPoints();

        $srch = PolicyPoint::getSearchObject($this->siteLangId, false);

        $srch->addMultipleFields(array('pp.*', 'pp_l.ppoint_title' ));
        $srch->addOrder('ppoint_active', 'desc');
        $srch->addOrder('ppoint_id', 'desc');
        $rs = $srch->getResultSet();
        $records = array();
        if ($rs) {
            $records = FatApp::getDb()->fetchAll($rs);
        }

        $this->set("arrListing", $records);
        $this->set("policyPointTypeArr", PolicyPoint::getPolicyPointTypesArr($this->siteLangId));
        $this->set('recordCount', $srch->recordCount());
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }


    public function form($ppointId)
    {
        $this->objPrivilege->canViewPolicyPoints();

        $ppointId = FatUtility::int($ppointId);

        $frm = $this->getForm($ppointId);

        if (0 < $ppointId) {
            $data = PolicyPoint::getAttributesById($ppointId, array('ppoint_id', 'ppoint_identifier', 'ppoint_type', 'ppoint_active'));

            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('ppoint_id', $ppointId);
        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditPolicyPoints();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $ppointId = $post['ppoint_id'];
        unset($post['ppoint_id']);
        if ($ppointId == 0) {
            $post['ppoint_added_on'] = date('Y-m-d H:i:s');
        }
        $record = new PolicyPoint($ppointId);
        $record->assignValues($post);
        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;
        if ($ppointId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = PolicyPoint::getAttributesByLangId($langId, $ppointId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $ppointId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }
        $this->set('msg', $this->str_setup_successful);
        $this->set('ppointId', $ppointId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($ppointId = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canViewPolicyPoints();
        $ppointId = FatUtility::int($ppointId);
        $lang_id = FatUtility::int($lang_id);

        if ($ppointId == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $langFrm = $this->getLangForm($ppointId, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(PolicyPoint::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($ppointId, $lang_id);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = PolicyPoint::getAttributesByLangId($lang_id, $ppointId);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('ppointId', $ppointId);
        $this->set('lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditPolicyPoints();
        $post = FatApp::getPostedData();

        $ppointId = $post['ppoint_id'];
        $lang_id = $post['lang_id'];

        if ($ppointId == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($ppointId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['ppoint_id']);
        unset($post['lang_id']);

        $data = array(
        'ppointlang_lang_id' => $lang_id,
        'ppointlang_ppoint_id' => $ppointId,
        'ppoint_title' => $post['ppoint_title'],

        );

        $obj = new PolicyPoint($ppointId);

        if (!$obj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
        
        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(PolicyPoint::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($ppointId)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = PolicyPoint::getAttributesByLangId($langId, $ppointId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('ppointId', $ppointId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditPolicyPoints();
        $ppointId = FatApp::getPostedData('ppointId', FatUtility::VAR_INT, 0);
        if (0 >= $ppointId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = PolicyPoint::getAttributesById($ppointId, array('ppoint_id', 'ppoint_active'));

        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $status = ($data['ppoint_active'] == applicationConstants::ACTIVE) ? applicationConstants::INACTIVE : applicationConstants::ACTIVE;

        $this->updatePolicyPointStatus($ppointId, $status);

        FatUtility::dieJsonSuccess($this->str_update_record);
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditPolicyPoints();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $ppointIdsArr = FatUtility::int(FatApp::getPostedData('ppoint_ids'));
        if (empty($ppointIdsArr) || -1 == $status) {
            LibHelper::exitWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true
            );
        }

        foreach ($ppointIdsArr as $ppointId) {
            if (1 > $ppointId) {
                continue;
            }

            $this->updatePolicyPointStatus($ppointId, $status);
        }
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updatePolicyPointStatus($ppointId, $status)
    {
        $status = FatUtility::int($status);
        $ppointId = FatUtility::int($ppointId);
        if (1 > $ppointId || -1 == $status) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }

        $obj = new PolicyPoint($ppointId);
        if (!$obj->changeStatus($status)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditPolicyPoints();

        $ppoint_id = FatApp::getPostedData('ppointId', FatUtility::VAR_INT, 0);
        if ($ppoint_id < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $this->markAsDeleted($ppoint_id);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditPolicyPoints();
        $ppointIdsArr = FatUtility::int(FatApp::getPostedData('ppoint_ids'));

        if (empty($ppointIdsArr)) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }

        foreach ($ppointIdsArr as $ppoint_id) {
            if (1 > $ppoint_id) {
                continue;
            }
            $this->markAsDeleted($ppoint_id);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted($ppoint_id)
    {
        $ppoint_id = FatUtility::int($ppoint_id);
        if (1 > $ppoint_id) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }
        $ppointObj = new PolicyPoint($ppoint_id);
        if (!$ppointObj->canRecordMarkDelete($ppoint_id)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $ppointObj->assignValues(array(PolicyPoint::tblFld('deleted') => 1));
        if (!$ppointObj->save()) {
            LibHelper::exitWithError($ppointObj->getError(), true);
        }
    }

    private function getForm($ppointId = 0)
    {
        $this->objPrivilege->canViewPolicyPoints();
        $ppointId = FatUtility::int($ppointId);

        $frm = new Form('frmPolicyPoint');
        $frm->addHiddenField('', 'ppoint_id', $ppointId);
        $frm->addRequiredField(Labels::getLabel('LBL_Policy_Point_Identifier', $this->siteLangId), 'ppoint_identifier');

        $policyPointTypeArr = PolicyPoint::getPolicyPointTypesArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Type', $this->siteLangId), 'ppoint_type', $policyPointTypeArr, '', array(), '');

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), 'ppoint_active', $activeInactiveArr, '', array(), '');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->siteLangId));
        return $frm;
    }

    private function getLangForm($ppointId = 0, $lang_id = 0)
    {
        $this->objPrivilege->canViewPolicyPoints();
        $frm = new Form('frmPolicyPointLang');
        $frm->addHiddenField('', 'ppoint_id', $ppointId);
        $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->siteLangId), 'lang_id', Language::getAllNames(), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('LBL_Policy_Point_Title', $this->siteLangId), 'ppoint_title');
        
        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->siteLangId));
        return $frm;
    }
}
