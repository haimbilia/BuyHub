<?php

class ExtraAttributesController extends ListingBaseController
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
        $this->canView = $this->objPrivilege->canViewExtraAttributes($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditExtraAttributes($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index($eattrgroup_id = 0)
    {
        $this->objPrivilege->canViewExtraAttributes();
        $eattrgroup_id = FatUtility::int($eattrgroup_id);
        if ($eattrgroup_id <= 0) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }

        $extraAttrGroupdata = ExtraAttributeGroup::getAttributesById($eattrgroup_id, array('eattrgroup_id', 'eattrgroup_identifier'));
        if ($extraAttrGroupdata === false) {
            LibHelper::exitWithError($this->str_invalid_request_id);
        }

        $frmSearch = $this->getSearchForm($eattrgroup_id);
        $this->set("frmSearch", $frmSearch);
        $this->set("eattrgroup_id", $eattrgroup_id);
        $this->set("extraAttrGroupdata", $extraAttrGroupdata);
        $this->_template->render();
    }


    public function search()
    {
        $this->objPrivilege->canViewExtraAttributes();
        $data = FatApp::getPostedData();
        $eattrgroup_id = FatUtility::int($data['eattrgroup_id']);
        if ($eattrgroup_id <= 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $searchForm = $this->getSearchForm($eattrgroup_id);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $post = $searchForm->getFormDataFromArray($data);

        $extraAttrObj = new ExtraAttribute();
        $srch = $extraAttrObj->getSearchObject();
        $srch->addFld('ea.*');

        $srch->addCondition('eattribute_eattrgroup_id', '=', $eattrgroup_id);

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cnd = $srch->addCondition('eattribute_identifier', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('eattribute_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $srch->joinTable(
            ExtraAttribute::DB_TBL . '_lang',
            'LEFT OUTER JOIN',
            'eattributelang_eattribute_id = eattribute_id AND eattributelang_lang_id = ' . $this->siteLangId
        );
        $srch->addMultipleFields(array("eattribute_name"));

        $rs = $srch->getResultSet();

        $pageCount = $srch->pages();
        $records = array();
        if ($rs) {
            $records = FatApp::getDb()->fetchAll($rs);
        }

        $this->set("arrListing", $records);
        $this->set('pageCount', $pageCount);
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function form($eattrgroup_id, $eattribute_id = 0)
    {
        $this->objPrivilege->canEditExtraAttributes();

        $eattrgroup_id = FatUtility::int($eattrgroup_id);
        if ($eattrgroup_id <= 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $eattribute_id = FatUtility::int($eattribute_id);
        $extraAttributeFrm = $this->getForm($eattrgroup_id, $eattribute_id);

        if (0 < $eattribute_id) {
            $extraAttrObj = new ExtraAttribute();
            $data = $extraAttrObj->getAttributesByIdAndGroupId($eattrgroup_id, $eattribute_id, array('eattribute_id', 'eattribute_eattrgroup_id', 'eattribute_identifier'));
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $extraAttributeFrm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('eattribute_id', $eattribute_id);
        $this->set('eattrgroup_id', $eattrgroup_id);
        $this->set('extraAttributeFrm', $extraAttributeFrm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditExtraAttributes();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $eattrgroup_id = FatUtility::int($post['eattribute_eattrgroup_id']);
        $eattribute_id = FatUtility::int($post['eattribute_id']);
        unset($post['eattribute_id']);

        if (0 < $eattribute_id) {
            $extraAttrObj = new ExtraAttribute();
            $data = $extraAttrObj->getAttributesByIdAndGroupId($eattrgroup_id, $eattribute_id, array('eattribute_id'));
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request_id, true);
            }
        }

        $record = new ExtraAttribute($eattribute_id);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }


        $newTabLangId = 0;
        if ($eattribute_id > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = ExtraAttribute::getAttributesByLangId($langId, $eattribute_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $eattribute_id = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        $this->set('msg', Labels::getLabel('MSG_ATTRIBUTE_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('eattrgroup_id', $eattrgroup_id);
        $this->set('eattribute_id', $eattribute_id);
        $this->set('lang_id', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($eattrgroup_id = 0, $eattribute_id = 0)
    {
        $this->objPrivilege->canEditExtraAttributes();
        $eattrgroup_id = FatUtility::int($eattrgroup_id);
        $eattribute_id = FatUtility::int($eattribute_id);

        $frm = new Form('frmExtraAttribute', array('id' => 'frmExtraAttribute'));
        $frm->addHiddenField('', 'eattribute_id', $eattribute_id);
        $frm->addHiddenField('', 'eattribute_eattrgroup_id', $eattrgroup_id);
        $frm->addRequiredField(Labels::getLabel('FRM_ATTRIBUTE_IDENTIFIER', $this->siteLangId), 'eattribute_identifier');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    public function langForm($eattribute_id = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canEditExtraAttributes();

        $eattribute_id = FatUtility::int($eattribute_id);
        $lang_id = FatUtility::int($lang_id);

        if ($eattribute_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $data = ExtraAttribute::getAttributesById($eattribute_id);
        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $eattribute_eattrgroup_id = $data['eattribute_eattrgroup_id'];

        $extraAttributeLangFrm = $this->getLangForm($eattribute_id, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(ExtraAttribute::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($eattribute_id, $lang_id);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = ExtraAttribute::getAttributesByLangId($lang_id, $eattribute_id);
        }
        $langData['eattribute_eattrgroup_id'] = $eattribute_eattrgroup_id;
        if ($langData) {
            $extraAttributeLangFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('eattribute_id', $eattribute_id);
        $this->set('eattribute_eattrgroup_id', $eattribute_eattrgroup_id);
        $this->set('attribute_lang_id', $lang_id);
        $this->set('extraAttributeLangFrm', $extraAttributeLangFrm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditExtraAttributes();
        $frm = $this->getLangForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        $eattribute_id = FatUtility::int($post['eattribute_id']);
        $lang_id = FatUtility::int($post['lang_id']);
        $eattribute_eattrgroup_id = FatUtility::int($post['eattribute_eattrgroup_id']);

        if ($eattribute_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = array(
            'eattributelang_lang_id' => $lang_id,
            'eattributelang_eattribute_id' => $eattribute_id,
            'eattribute_name' => $post['eattribute_name'],
        );

        $extraAttrObj = new ExtraAttribute($eattribute_id);
        if (!$extraAttrObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($extraAttrObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(ExtraAttribute::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($eattribute_id)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = ExtraAttribute::getAttributesByLangId($langId, $eattribute_id)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', Labels::getLabel('MSG_ATTRIBUTE_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('eattribute_id', $eattribute_id);
        $this->set('lang_id', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditExtraAttributes();
        $eattribute_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($eattribute_id < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $extraAttrObj = new ExtraAttribute($eattribute_id);
        if (!$extraAttrObj->canDeleteRecord($eattribute_id)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        if (!$extraAttrObj->deleteRecord()) {
            LibHelper::exitWithError($extraAttrObj->getError(), true);
        }
        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    private function getLangForm($eattribute_id = 0, $lang_id = 0)
    {
        $frm = new Form('frmExtraAttributeLang', array('id' => 'frmExtraAttributeLang'));
        $frm->addHiddenField('', 'eattribute_id', $eattribute_id);
        $frm->addHiddenField('', 'eattribute_eattrgroup_id', 0);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getAllNames(), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_ATTRIBUTE_NAME', $this->siteLangId), 'eattribute_name');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    public function getSearchForm($eattrgroup_id = 0)
    {
        $frm = new Form('frmSearch', array('id' => 'frmSearch'));
        $frm->addHiddenField('', 'eattrgroup_id', $eattrgroup_id);
        $f1 = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '');
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('BTN_CLEAR', $this->siteLangId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }
}
