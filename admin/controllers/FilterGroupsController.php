<?php

class FilterGroupsController extends ListingBaseController
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
        $this->canView = $this->objPrivilege->canViewFilterGroups($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditFilterGroups($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->objPrivilege->canViewFilterGroups();
        $search = $this->getSearchForm();
        $this->set("search", $search);
        $this->_template->render();
    }

    public function search()
    {
        $this->objPrivilege->canViewFilterGroups();

        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $searchForm = $this->getSearchForm();
        $data = FatApp::getPostedData();
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $filterGroupObj = new FilterGroup();
        $srch = $filterGroupObj->getSearchObject();
        $srch->addFld('fg.*');

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $condition = $srch->addCondition('fg.filtergroup_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('fgl.filtergroup_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $srch->joinTable(
            FilterGroup::DB_TBL . '_lang',
            'LEFT OUTER JOIN',
            'fgl.filtergrouplang_filtergroup_id = fg.filtergroup_id AND fgl.filtergrouplang_lang_id = ' . $this->siteLangId,
            'fgl'
        );
        $srch->addMultipleFields(array("fgl.filtergroup_name"));

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
        $this->set('recordCount', $srch->recordCount());
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditFilterGroups();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $filtergroup_id = $post['filtergroup_id'];
        unset($post['filtergroup_id']);

        $record = new FilterGroup($filtergroup_id);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;
        if ($filtergroup_id > 0) {
            $filterGroupId = $filtergroup_id;
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = FilterGroup::getAttributesByLangId($langId, $filtergroup_id)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $filterGroupId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        $this->set('msg', Labels::getLabel('MSG_FILTER_GROUP_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('filterGroupId', $filterGroupId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditFilterGroups();
        $post = FatApp::getPostedData();

        $filtergroup_id = FatUtility::int($post['filtergroup_id']);
        $lang_id = FatUtility::int($post['lang_id']);

        if ($filtergroup_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($filtergroup_id, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['filtergroup_id']);
        unset($post['lang_id']);
        $data = array(
            'filtergrouplang_lang_id' => $lang_id,
            'filtergrouplang_filtergroup_id' => $filtergroup_id,
            'filtergroup_name' => $post['filtergroup_name'],
        );

        $filterGroupObj = new FilterGroup($filtergroup_id);
        if (!$filterGroupObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($filterGroupObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(FilterGroup::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($filtergroup_id)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = FilterGroup::getAttributesByLangId($langId, $filtergroup_id)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', Labels::getLabel('MSG_FILTER_GROUP_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('filterGroupId', $filtergroup_id);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function form($filtergroup_id = 0)
    {
        $this->objPrivilege->canEditFilterGroups();

        $filtergroup_id = FatUtility::int($filtergroup_id);
        $filterGroupsFrm = $this->getForm($filtergroup_id);

        if (0 < $filtergroup_id) {
            $data = FilterGroup::getAttributesById($filtergroup_id, array('filtergroup_id', 'filtergroup_identifier', 'filtergroup_active'));
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $filterGroupsFrm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('filtergroup_id', $filtergroup_id);
        $this->set('filterGroupsFrm', $filterGroupsFrm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getForm($filtergroup_id = 0)
    {
        $this->objPrivilege->canEditFilterGroups();
        $filtergroup_id = FatUtility::int($filtergroup_id);

        $action = Labels::getLabel('FRM_ADD_NEW', $this->siteLangId);
        if ($filtergroup_id > 0) {
            $action = Labels::getLabel('FRM_UPDATE', $this->siteLangId);
        }
        $filterGroupObj = new FilterGroup();
        $frm = new Form('frmFilterGroups', array('id' => 'frmFilterGroups'));
        $frm->addHiddenField('', 'filtergroup_id', 0);
        $frm->addRequiredField(Labels::getLabel('FRM_FILTER_GROUP_IDENTIFIER', $this->siteLangId), 'filtergroup_identifier');
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_FILTER_GROUP_ACTIVE', $this->siteLangId), 'filtergroup_active', $activeInactiveArr, '', array(), '');
        $frm->addSubmitButton('', 'btn_submit', $action);
        return $frm;
    }

    public function langForm($filtergroup_id = 0, $lang_id = 0, $autoFillLangData = 0)
    {
        $this->objPrivilege->canEditFilterGroups();

        $filtergroup_id = FatUtility::int($filtergroup_id);
        $lang_id = FatUtility::int($lang_id);

        if ($filtergroup_id == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $filterGroupLangFrm = $this->getLangForm($filtergroup_id, $lang_id);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(FilterGroup::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($filtergroup_id, $lang_id);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = FilterGroup::getAttributesByLangId($lang_id, $filtergroup_id);
        }

        if ($langData) {
            $filterGroupLangFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('filtergroup_id', $filtergroup_id);
        $this->set('filtergroup_lang_id', $lang_id);
        $this->set('filterGroupLangFrm', $filterGroupLangFrm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getLangForm($filtergroup_id = 0, $lang_id = 0)
    {
        $frm = new Form('frmFilterGroupLang', array('id' => 'frmFilterGroupLang'));
        $frm->addHiddenField('', 'filtergroup_id', $filtergroup_id);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', Language::getAllNames(), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_BRAND_NAME', $this->siteLangId), 'filtergroup_name');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_UPDATE', $this->siteLangId));
        return $frm;
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditFilterGroups();

        $filtergroup_id = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if ($filtergroup_id < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $filterGroupObj = new FilterGroup($filtergroup_id);
        if (!$filterGroupObj->canRecordMarkDelete($filtergroup_id)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $filterGroupObj->assignValues(array(FilterGroup::tblFld('deleted') => 1));
        if (!$filterGroupObj->save()) {
            LibHelper::exitWithError($filterGroupObj->getError(), true);
        }
        FatUtility::dieJsonSuccess($this->str_delete_record);
    }
}
