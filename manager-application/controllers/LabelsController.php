<?php

class LabelsController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewLanguageLabels();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('canEdit', $this->objPrivilege->canEditLanguageLabels($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_LABELS', $this->siteLangId));
        $this->getListingData();

        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'labels/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $data = FatApp::getPostedData();

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

        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $attr = [
            'lbl.*',
            'lng.*'
        ];

        $srch = Labels::getSearchObject(0, $attr, false);
        $srch->joinTable('tbl_languages', 'inner join', 'label_lang_id = language_id and language_active = ' . applicationConstants::ACTIVE, 'lng');

        $srch->addGroupBy('lbl.' . Labels::DB_TBL_PREFIX . 'key');
        $srch->addGroupBy('lbl.' . Labels::DB_TBL_PREFIX . 'id', 'DESC');

        $type = FatApp::getPostedData('label_type', FatUtility::VAR_INT, -1);
        if ($type > -1) {
            $srch->addCondition('label_type', '=', $type);
        }

        if (!empty($post['keyword'])) {
            $cond = $srch->addCondition('lbl.label_key', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('lbl.label_caption', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        $srch->addCondition('lbl.label_lang_id', '=', $this->siteLangId);

        $page = FatUtility::int($page);
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);

        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditLanguageLabels($this->admin_id, true));
    }

    public function langForm($labelType = Labels::TYPE_WEB, $autoFillLangData = 0)
    {
        $labelTypeArr = Labels::getTypeArr($this->siteLangId);

        if (!array_key_exists($labelType, $labelTypeArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $data = Labels::getAttributesById($recordId, array('label_key'));
        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $labelKey = $data['label_key'];

        $frm = $this->getLangForm($labelKey, $labelType);

        $srch = Labels::getSearchObject();
        $srch->addCondition('lbl.label_key', '=', $labelKey);
        if (0 < $autoFillLangData) {
            $srch->addCondition('lbl.label_lang_id', '=', FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1));
        }
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $record = FatApp::getDb()->fetchAll($srch->getResultSet(), 'label_lang_id');

        if ($record == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $arr = array();

        if (0 < $autoFillLangData) {
            $languages = Language::getAllNames();
            $siteDefaultLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
            unset($languages[$siteDefaultLangId]);
            foreach (array_keys($languages) as $langId) {
                $updateLangDataobj = new TranslateLangData(Labels::DB_TBL);
                $translatedData = $updateLangDataobj->directTranslate(['label_caption' => $record[$siteDefaultLangId]['label_caption']], $langId);
                if (false === $translatedData) {
                    LibHelper::exitWithError($updateLangDataobj->getError(), true);
                }
                $data = $record[$siteDefaultLangId];
                $data['label_lang_id'] = $langId;
                $data['label_caption'] = $translatedData[$langId]['label_caption'];
                $record[$langId] = $data;
            }
        }

        foreach ($record as $k => $v) {
            $arr['label_key'] = $v['label_key'];
            $arr['label_caption' . $k] = $v['label_caption'];
        }

        $arr['label_type'] = $labelType;
        $frm->fill($arr);

        $this->set('recordId', $recordId);
        $this->set('labelType', $labelType);
        $this->set('labelKey', $labelKey);
        $this->set('langFrm', $frm);
        $this->set('languages', Language::getAllNames());
        $this->set('formLayout', Language::getLayoutDirection($this->siteLangId));
        $this->_template->render(false, false);
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditLanguageLabels();
        $data = FatApp::getPostedData();

        $frm = $this->getLangForm($data['label_key'], $data['label_type']);
        $post = $frm->getFormDataFromArray($data);
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $labelKey = $post['label_key'];
        $labelType = FatApp::getPostedData('label_type', FatUtility::VAR_INT, Labels::TYPE_WEB);
        $labelTypeArr = Labels::getTypeArr($this->siteLangId);

        if (!array_key_exists($labelType, $labelTypeArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $srch = Labels::getSearchObject();
        $srch->addCondition('lbl.label_key', '=', $labelKey);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();

        $record = FatApp::getDb()->fetchAll($rs, 'label_lang_id');
        if ($record == false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            $keyValue = strip_tags(trim($post['label_caption' . $langId]));
            $data = array(
                'label_lang_id' => $langId,
                'label_key' => $labelKey,
                'label_caption' => $keyValue,
                'label_type' => $labelType,
            );
            $obj = new Labels();
            if (!$obj->addUpdateData($data)) {
                LibHelper::exitWithError($obj->getError(), true);
            }

            if (Labels::isAPCUcacheAvailable()) {
                $cacheKey = Labels::getAPCUcacheKey($labelKey, $langId);
                apcu_store($cacheKey, $keyValue);
            }
        }
        $this->updateJsonFile(Labels::TYPE_WEB);
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'label_key');
        }

        $fld = $frm->addTextBox(Labels::getLabel('LBL_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $frm->addSelectBox(Labels::getLabel('LBL_TYPE', $this->siteLangId), 'label_type', array('-1' => Labels::getLabel('LBL_SELECT_PLATFORM', $this->siteLangId)) + Labels::getTypeArr($this->siteLangId), -1, array(), '');

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);

        return $frm;
    }

    private function getLangForm($label_key, $label_type)
    {
        $frm = new Form('frmLabels');
        $frm->addHiddenField('', 'label_key', $label_key);
        $frm->addHiddenField('', 'label_type', $label_type);
        $languages = Language::getAllNames();
        $frm->addTextbox(Labels::getLabel('LBL_Key', $this->siteLangId), 'key', $label_key);
        foreach ($languages as $langId => $langName) {
            $fld = $frm->addTextArea($langName, 'label_caption' . $langId);
            $fld->requirements()->setRequired();
        }
        return $frm;
    }

    public function updateJsonFile($labelType = Labels::TYPE_WEB)
    {
        $languages = Language::getAllCodesAssoc();
        foreach ($languages as $langId => $langCode) {
            $resp = Labels::updateDataToFile($langId, $langCode, $labelType, true);
            if ($resp === false) {
                LibHelper::exitWithError(Labels::getLabel('MSG_Unable_to_update_file', $this->siteLangId), true);
            }
        }
        $message = Labels::getLabel('MSG_File_successfully_updated', $this->siteLangId);
        FatUtility::dieJsonSuccess($message);
    }

    protected function getFormColumns(): array
    {
        $labelsTblHeadingCols = CacheHelper::get('labelsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($labelsTblHeadingCols) {
            return json_decode($labelsTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'label_key' => Labels::getLabel('LBL_SYSTEM_CODE', $this->siteLangId),
            'label_caption' => Labels::getLabel('LBL_CAPTION', $this->siteLangId),
            'label_type' => Labels::getLabel('LBL_PLATFORM', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION', $this->siteLangId),
        ];
        CacheHelper::create('labelsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'listSerial',
            'label_key',
            'label_caption',
            'label_type',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_CONFIGURATION_&_MANAGEMENT', $this->siteLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => Labels::getLabel('LBL_MANAGE_LABELS', $this->siteLangId)]
                ];
        }
        return $this->nodes;
    }
}
