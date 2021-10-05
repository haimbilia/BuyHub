<?php

class ShopReportReasonsController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewShopReportReasons();
    }

    public function index()
    {
        $this->_template->render();
    }

    public function search()
    {
        $srch = ShopReportReason::getSearchObject($this->adminLangId);

        $srch->addMultipleFields(array('reportreason.*', 'reportreason_l.reportreason_title'));
        $srch->addOrder('reportreason_id', 'DESC');
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $this->set("arrListing", $records);
        $this->set('recordCount', $srch->recordCount());
        $this->_template->render(false, false);
    }


    public function form($reasonId)
    {
        $reasonId = FatUtility::int($reasonId);

        $frm = $this->getForm($reasonId);

        if (0 < $reasonId) {
            $data = ShopReportReason::getAttributesById($reasonId, array('reportreason_id', 'reportreason_identifier'));

            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('reportreason_id', $reasonId);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditShopReportReasons();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $reasonId = $post['reportreason_id'];
        unset($post['reportreason_id']);
        $record = new ShopReportReason($reasonId);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;
        if ($reasonId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = ShopReportReason::getAttributesByLangId($langId, $reasonId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $reasonId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }
        $this->set('msg', $this->str_setup_successful);
        $this->set('reasonId', $reasonId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($reasonId = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $reasonId = FatUtility::int($reasonId);
        $lang_id = FatUtility::int($lang_id);

        if ($reasonId == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $langFrm = $this->getLangForm($reasonId, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(ShopReportReason::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($reasonId, $lang_id);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = ShopReportReason::getAttributesByLangId($lang_id, $reasonId);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('reasonId', $reasonId);
        $this->set('lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->_template->render(false, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditShopReportReasons();
        $post = FatApp::getPostedData();

        $reasonId = $post['reportreason_id'];
        $languages = Language::getAllNames();
        
        if (count($languages) > 1) {
            $lang_id = $post['lang_id'];
        } else {
            $lang_id = array_key_first($languages);
            $post['lang_id'] = $lang_id;
        }

        if ($reasonId == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($reasonId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['reportreason_id']);
        unset($post['lang_id']);

        $data = array(
            'reportreasonlang_lang_id' => $lang_id,
            'reportreasonlang_reportreason_id' => $reasonId,
            'reportreason_title' => $post['reportreason_title'],
            // 'reportreason_description'=>$post['reportreason_description']
        );

        $reasonObj = new ShopReportReason($reasonId);

        if (!$reasonObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($reasonObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(ShopReportReason::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($reasonId)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = ShopReportReason::getAttributesByLangId($langId, $reasonId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('reasonId', $reasonId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($reasonId = 0)
    {
        $reasonId = FatUtility::int($reasonId);

        $frm = new Form('frmShopReportReason');
        $frm->addHiddenField('', 'reportreason_id', $reasonId);
        $frm->addRequiredField(Labels::getLabel('LBL_Reason_Identifier', $this->adminLangId), 'reportreason_identifier');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }

    private function getLangForm($reasonId = 0, $lang_id = 0)
    {
        $frm = new Form('frmShopReportReasonLang');
        $frm->addHiddenField('', 'reportreason_id', $reasonId);

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->adminLangId), 'lang_id', $languages, $lang_id, array(), '');
        } else {
            $lang_id = array_key_first($languages);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }


        $frm->addRequiredField(Labels::getLabel('LBL_Reason_Title', $this->adminLangId), 'reportreason_title');
        // $frm->addTextarea('Reason Description', 'reportreason_description');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->adminLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditShopReportReasons();

        $reasonId = FatApp::getPostedData('reasonId', FatUtility::VAR_INT, 0);
        if ($reasonId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($reasonId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditShopReportReasons();
        $reasonIdsArr = FatUtility::int(FatApp::getPostedData('reportreason_ids'));

        if (empty($reasonIdsArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($reasonIdsArr as $reasonId) {
            if (1 > $reasonId) {
                continue;
            }
            $this->markAsDeleted($reasonId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function markAsDeleted($reasonId)
    {
        $reasonId = FatUtility::int($reasonId);
        if (1 > $reasonId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $obj = new ShopReportReason($reasonId);
        if (!$obj->deleteRecord(true)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }
}
