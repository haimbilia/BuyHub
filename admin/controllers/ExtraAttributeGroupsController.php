<?php

class ExtraAttributeGroupsController extends ListingBaseController
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

    public function index()
    {
        $this->objPrivilege->canViewExtraAttributes();
        $srchFrm = $this->getSearchForm();
        $this->set("frmSearch", $srchFrm);
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewExtraAttributes();
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $post = $searchForm->getFormDataFromArray($data);

        $extraAttrGroupObj = new ExtraAttributeGroup();
        $srch = $extraAttrGroupObj->getSearchObject();
        $srch->addFld('eag.*');

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cnd = $srch->addCondition('eattrgroup_identifier', 'like', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('eattrgroup_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $srch->joinTable(
            ExtraAttributeGroup::DB_TBL . '_lang',
            'LEFT OUTER JOIN',
            'eattrgrouplang_eattrgroup_id = eattrgroup_id AND eattrgrouplang_lang_id = ' . $this->siteLangId
        );
        $srch->addMultipleFields(array("eattrgroup_name"));

        $rs = $srch->getResultSet();

        $pageCount = $srch->pages();
        $records = array();
        if ($rs) {
            $records = FatApp::getDb()->fetchAll($rs);
        }

        $this->set("arrListing", $records);
        $this->set('pageCount', $pageCount);
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function form($eattrgroup_id = 0)
    {
        $this->objPrivilege->canEditExtraAttributes();

        $eattrgroup_id = FatUtility::int($eattrgroup_id);
        $extraAttrGroupsFrm = $this->getForm($eattrgroup_id);
        if (0 < $eattrgroup_id) {
            $data = ExtraAttributeGroup::getAttributesById($eattrgroup_id, array('eattrgroup_id', 'eattrgroup_identifier'));
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $extraAttrGroupsFrm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('eattrgroup_id', $eattrgroup_id);
        $this->set('extraAttrGroupsFrm', $extraAttrGroupsFrm);
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

        $eattrgroup_id = $post['eattrgroup_id'];
        unset($post['eattrgroup_id']);

        $record = new ExtraAttributeGroup($eattrgroup_id);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;
        if ($eattrgroup_id > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = ExtraAttributeGroup::getAttributesByLangId($langId, $eattrgroup_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $eattrgroup_id = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        $this->set('msg', Labels::getLabel('MSG_EXTRA_ATTRIBUTE_GROUP_SETUP_SUCCESSFUL.', $this->siteLangId));
        $this->set('eattrgroup_id', $eattrgroup_id);
        $this->set('lang_id', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($eattrgroup_id = 0)
    {
        $this->objPrivilege->canEditExtraAttributes();
        $eattrgroup_id = FatUtility::int($eattrgroup_id);

        $ExtraAttrGroupObj = new ExtraAttributeGroup();
        $frm = new Form('frmExtraAttributeGroup', array('id' => 'frmExtraAttributeGroup'));
        $frm->addHiddenField('', 'eattrgroup_id', 0);
        $frm->addRequiredField(Labels::getLabel('FRM_EXTRA_ATTRIBUTE_GROUP_IDENTIFIER', $this->siteLangId), 'eattrgroup_identifier');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    public function langForm($eattrgroup_id = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canEditExtraAttributes();

        $eattrgroup_id = FatUtility::int($eattrgroup_id);
        $lang_id = FatUtility::int($lang_id);

        if ($eattrgroup_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $extraAttrGroupLangFrm = $this->getLangForm($eattrgroup_id, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(ExtraAttributeGroup::DB_TBL);
            $translatedData = $updateLangDataobj->getTranslatedData($eattrgroup_id, $lang_id, CommonHelper::getDefaultFormLangId());
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = ExtraAttributeGroup::getAttributesByLangId($lang_id, $eattrgroup_id);
        }

        if ($langData) {
            $extraAttrGroupLangFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('eattrgroup_id', $eattrgroup_id);
        $this->set('eattrgroup_lang_id', $lang_id);
        $this->set('extraAttrGroupLangFrm', $extraAttrGroupLangFrm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditExtraAttributes();
        $post = FatApp::getPostedData();

        $eattrgroup_id = $post['eattrgroup_id'];
        $lang_id = $post['lang_id'];

        if ($eattrgroup_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($eattrgroup_id, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['eattrgroup_id']);
        unset($post['lang_id']);
        $data = array(
            'eattrgrouplang_eattrgroup_id' => $eattrgroup_id,
            'eattrgrouplang_lang_id' => $lang_id,
            'eattrgroup_name' => $post['eattrgroup_name'],
        );

        $extraAttributeGroupObj = new ExtraAttributeGroup($eattrgroup_id);
        if (!$extraAttributeGroupObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($extraAttributeGroupObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(ExtraAttributeGroup::DB_TBL);
            if (false === $updateLangDataobj->updateTranslatedData($eattrgroup_id, CommonHelper::getDefaultFormLangId())) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = ExtraAttributeGroup::getAttributesByLangId($langId, $eattrgroup_id)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', Labels::getLabel('MSG_EXTRA_ATTRIBUTE_GROUP_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('eattrgroup_id', $eattrgroup_id);
        $this->set('lang_id', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditExtraAttributes();
        $eattrgroup_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($eattrgroup_id < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $extraAttrGroupObj = new ExtraAttributeGroup($eattrgroup_id);
        if (!$extraAttrGroupObj->canRecordMarkDelete($eattrgroup_id)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $extraAttrGroupObj->assignValues(array(ExtraAttributeGroup::tblFld('deleted') => 1));
        if (!$extraAttrGroupObj->save()) {
            LibHelper::exitWithError($extraAttrGroupObj->getError(), true);
        }
        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    private function getLangForm($eattrgroup_id = 0, $lang_id = 0)
    {
        $frm = new Form('frmExtraAttributeGroupLang', array('id' => 'frmExtraAttributeGroupLang'));
        $frm->addHiddenField('', 'eattrgroup_id', $eattrgroup_id);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getAllNames(), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_EXTRA_ATTRIBUTE_GROUP_NAME', $this->siteLangId), 'eattrgroup_name');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }
}
