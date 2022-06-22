<?php

class ShippingDurationsController extends ListingBaseController
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
        $this->canView = $this->objPrivilege->canViewShippingDurationLabels($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditShippingDurationLabels($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->objPrivilege->canViewShippingDurationLabels();
        $frmSearch = $this->getSearchForm();
        $this->set("frmSearch", $frmSearch);
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewShippingDurationLabels();

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = ShippingDurations::getSearchObject($this->siteLangId);

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cond = $srch->addCondition('sd.sduration_identifier', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('sd_l.sduration_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $srch->addOrder('sduration_id', 'DESC');

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

    public function form($sduration_id = 0)
    {
        $this->objPrivilege->canViewShippingDurationLabels();

        $sduration_id = FatUtility::int($sduration_id);
        $frm = $this->getForm();

        if (0 < $sduration_id) {
            $data = ShippingDurations::getAttributesById($sduration_id, array('sduration_id', 'sduration_identifier', 'sduration_from', 'sduration_to', 'sduration_days_or_weeks'));
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('sduration_id', $sduration_id);
        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditShippingDurationLabels();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $sduration_id = $post['sduration_id'];
        unset($post['sduration_id']);

        $record = new ShippingDurations($sduration_id);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;
        if ($sduration_id > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = ShippingDurations::getAttributesByLangId($langId, $sduration_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $sduration_id = $record->getMainTableRecordId();
            $newTabLangId = $this->siteLangId;
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('sdurationId', $sduration_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langform($sduration_id = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canViewShippingDurationLabels();

        $sduration_id = FatUtility::int($sduration_id);
        $lang_id = FatUtility::int($lang_id);

        if ($sduration_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $langFrm = $this->getLangForm($sduration_id, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(ShippingDurations::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($sduration_id, $lang_id);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = ShippingDurations::getAttributesByLangId($lang_id, $sduration_id);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('sduration_id', $sduration_id);
        $this->set('lang_id', $lang_id);
        $this->set('langFrm', $langFrm);
        $this->set('languages', Language::getAllNames());
        $this->set('formLayout', Language::getLayoutDirection($lang_id));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditShippingDurationLabels();
        $post = FatApp::getPostedData();

        $sduration_id = $post['sduration_id'];
        $lang_id = $post['lang_id'];

        if ($sduration_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($sduration_id, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        $data = array(
        'sdurationlang_sduration_id' => $sduration_id,
        'sdurationlang_lang_id' => $lang_id,
        'sduration_name' => $post['sduration_name'],
        );

        $obj = new ShippingDurations($sduration_id);
        if (!$obj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
        
        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(ShippingDurations::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($sduration_id)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = ShippingDurations::getAttributesByLangId($langId, $sduration_id)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('sdurationId', $sduration_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditShippingDurationLabels();

        $sduration_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($sduration_id < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($sduration_id);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditShippingDurationLabels();
        $sdurationIdsArr = FatUtility::int(FatApp::getPostedData('sduration_ids'));

        if (empty($sdurationIdsArr)) {
            LibHelper::exitWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true
            );
        }

        foreach ($sdurationIdsArr as $sduration_id) {
            if (1 > $sduration_id) {
                continue;
            }
            $this->markAsDeleted($sduration_id);
        }
        $this->set('msg', Labels::getLabel('MSG_RECORDS_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted($sduration_id)
    {
        $sduration_id = FatUtility::int($sduration_id);
        if (1 > $sduration_id) {
            LibHelper::exitWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true
            );
        }
        $obj = new ShippingDurations($sduration_id);
        if (!$obj->canRecordMarkDelete($sduration_id)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $obj->assignValues(array(ShippingDurations::tblFld('deleted') => 1));

        if (!$obj->save()) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    public function getSearchForm(array $fields = [])
    {
        $frm = new Form('frmshipDurationSearch');
        $f1 = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '');
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('BTN_CLEAR', $this->siteLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getForm()
    {
        $this->objPrivilege->canViewShippingDurationLabels();

        $frm = new Form('frmShippingDuration');
        $frm->addHiddenField('', 'sduration_id', 0);
        $fld = $frm->addRequiredField(Labels::getLabel('FRM_IDENTIFIER', $this->siteLangId), 'sduration_identifier');
        $fld->setUnique(ShippingDurations::DB_TBL, 'sduration_identifier', 'sduration_id', 'sduration_id', 'sduration_id');

        $arr = array();
        for ($i = 1; $i < 11; $i++) {
            $arr[$i] = $i;
        }

        $frm->addSelectbox(Labels::getLabel('FRM_FROM', $this->siteLangId), 'sduration_from', $arr, '', array(), '');
        $frm->addSelectbox(Labels::getLabel('FRM_TO', $this->siteLangId), 'sduration_to', $arr, '', array(), '');
        $frm->addSelectbox(Labels::getLabel('FRM_DURATION', $this->siteLangId), 'sduration_days_or_weeks', ShippingDurations::getShippingDurationDaysOrWeekArr($this->siteLangId), '', array(), '');

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    private function getLangForm($sduration_id = 0, $lang_id = 0)
    {
        $this->objPrivilege->canViewShippingDurationLabels();

        $sduration_id = FatUtility::int($sduration_id);
        $lang_id = FatUtility::int($lang_id);

        $frm = new Form('frmShippingDurationLang');
        $frm->addHiddenField('', 'sduration_id', $sduration_id);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getAllNames(), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_LABEL', $this->siteLangId), 'sduration_name');
        
        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }
}
