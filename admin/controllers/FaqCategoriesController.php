<?php

class FaqCategoriesController extends ListingBaseController
{
    protected string $modelClass = 'FaqCategory';
    protected $pageKey = 'MANAGE_FAQ_CATEGORIES';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewFaqCategories();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['statusButtons'] = true;
        $actionItemsData['deleteButton'] = true;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_CATEGORY_NAME', $this->siteLangId));
        $this->checkEditPrivilege(true);
        $this->getListingData();
        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'faq-categories/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function getListingData()
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
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $searchForm = $this->getSearchForm($fields);
        $post = $searchForm->getFormDataFromArray($data);

        $srch = FaqCategory::getSearchObject($this->siteLangId);

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $condition = $srch->addCondition('fc.faqcat_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('fc_l.faqcat_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        // $srch->setPageNumber($page);
        // $srch->setPageSize($pageSize);
        $srch->addMultipleFields([
            'IFNULL(faqcat_name,faqcat_identifier) AS faqcat_name',
            'faqcat_id', 'faqcat_identifier', 'faqcat_active',
            'faqcat_type', 'faqcat_deleted', 'faqcat_display_order',
            'faqcat_featured', 'faqcatlang_faqcat_id', 'faqcatlang_lang_id',
        ]);
        $srch->doNotLimitRecords();
        $srch->doNotCalculateRecords();
        $srch->addOrder('faqcat_display_order', 'ASC');
        $srch->addOrder('faqcat_active', 'DESC');
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());
        $canViewFaq = $this->objPrivilege->canViewFaq(0, true);
        $this->set("canViewFaq", $canViewFaq);
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $this->set("activeInactiveArr", $activeInactiveArr);
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', count($records));
        $this->set('hidePaginationHtml', true);
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);

        // $this->set('sortBy', $sortBy);
        $this->set('sortBy', 'faqcat_display_order');
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->checkEditPrivilege(true);
    }

    public function form($recordId = 0)
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);
        $frm->fill(array('faqcat_id' => $recordId));

        if (0 < $recordId) {
            $data = FaqCategory::getAttributesByLangId($this->siteLangId, $recordId, array('faqcat_id', 'faqcat_identifier', 'faqcat_active', 'faqcat_type', 'faqcat_featured', 'IFNULL(faqcat_name, faqcat_identifier) AS faqcat_name'), applicationConstants::JOIN_RIGHT);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }
        $this->set('languages', Language::getAllNames());
        $this->set('faqcat_id', $recordId);
        $this->set('recordId', $recordId);
        $this->set('formTitle', Labels::getLabel('LBL_FAQ_CATEGORY_SETUP', $this->siteLangId));
        $this->set('frm', $frm);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    protected function getForm()
    {
        $this->checkEditPrivilege();
        $langId = $this->siteLangId;

        $frm = new Form('frmFaqCat');
        $frm->addHiddenField('', 'faqcat_id', '');
        $frm->addHiddenField('', 'lang_id', $this->siteLangId);
        $faqCatTypeArr = FaqCategory::getFaqCatTypeArr($langId);
        $frm->addRequiredField(Labels::getLabel('FRM_CATEGORY_NAME', $this->siteLangId), 'faqcat_name');
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        $frm->addSelectBox(Labels::getLabel('FRM_TYPE', $langId), 'faqcat_type', $faqCatTypeArr, '', array(), '');
        $frm->addCheckBox(Labels::getLabel('FRM_STATUS', $langId), 'faqcat_active', applicationConstants::ACTIVE, [], true, applicationConstants::INACTIVE);
        $languageArr = Language::getAllNames();
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    public function setup()
    {
        $this->checkEditPrivilege();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $newTabLangId = $this->siteLangId;
        $recordId = FatApp::getPostedData('faqcat_id', FatUtility::VAR_INT, 0);
        $record = new FaqCategory($recordId);
        if ($recordId == 0) {
            $display_order = $record->getMaxOrder();
            $post['faqcat_display_order'] = $display_order;
        }
        $record->setFldValue(FaqCategory::DB_TBL_PREFIX . 'identifier', $post['faqcat_name']);
        $record->assignValues($post);
        if (!$record->save()) {
            $msg = $record->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }
        $recordId = $record->getMainTableRecordId();

        $this->setLangData($record, [
            $record::tblFld('name') => $post[$record::tblFld('name')],
        ]);

        $newTabLangId = 0;
        $languages = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        if (0 < count($languages)) {
            foreach ($languages as $langId => $langName) {
                if (!FaqCategory::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        }

        $this->set('recordId', $recordId);
        $this->set('msg', $this->str_setup_successful);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($autoFillLangData = 0)
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        if ($recordId == 0 || $langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        if ($langId == 0) {
            $langId = $this->siteLangId;
        }
        $langData = FaqCategory::getAttributesByLangId($langId, $recordId);
        $faqCatLangFrm = $this->getLangForm($recordId, $langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(FaqCategory::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId, CommonHelper::getDefaultFormLangId());
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = FaqCategory::getAttributesByLangId($langId, $recordId);
        }

        $langData['faqcat_id'] = $recordId;
        $langData['lang_id'] = $langId;

        if ($langData) {
            $faqCatLangFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $faqCatLangFrm);
        $this->set('formTitle', Labels::getLabel('LBL_FAQ_CATEGORY_SETUP', $this->siteLangId));
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    protected function getLangForm($recordId = 0, $langId = 0)
    {
        $recordId = FatUtility::int($recordId);
        $langId = FatUtility::int($langId);
        $langId = 1 > $langId ? $this->siteLangId : $langId;

        if ($recordId == 0 || $langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $frm = new Form('frmFaqCatLang', array('id' => 'frmFaqCatLang'));
        $frm->addHiddenField('', 'faqcat_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_CATEGORY_NAME', $langId), 'faqcat_name');

        return $frm;
    }


    public function langSetup()
    {
        $this->checkEditPrivilege();
        $post = FatApp::getPostedData();
        $recordId = $post['faqcat_id'];
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $langId = $post['lang_id'];
        } else {
            $langId = array_key_first($languages);
        }

        if ($recordId == 0 || $langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($recordId, $langId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        $data = array(
            'faqcatlang_lang_id' => $langId,
            'faqcatlang_faqcat_id' => $recordId,
            'faqcat_name' => $post['faqcat_name'],
        );

        $faqcatObj = new FaqCategory($recordId);
        if (!$faqcatObj->updateLangData($langId, $data)) {
            LibHelper::exitWithError($faqcatObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(FaqCategory::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId, CommonHelper::getDefaultFormLangId())) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = $langId;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!FaqCategory::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('recordId', $recordId);
        $this->set('msg', $this->str_setup_successful);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->checkEditPrivilege();

        $faqcat_id = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($faqcat_id < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $res = FaqCategory::getAttributesById($faqcat_id, array('faqcat_id'));
        if ($res == false) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($faqcat_id);
        LibHelper::exitWithSuccess($this->str_delete_record, true);
    }

    public function deleteSelected()
    {
        $this->checkEditPrivilege();
        $faqcatIdsArr = FatUtility::int(FatApp::getPostedData('faqcat_ids'));

        if (empty($faqcatIdsArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($faqcatIdsArr as $faqcatId) {
            if (1 > $faqcatId) {
                continue;
            }
            $this->markAsDeleted($faqcatId);
        }
        $this->set('msg', Labels::getLabel('MSG_RECORDS_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateOrder()
    {
        $this->checkEditPrivilege();
        $post = FatApp::getPostedData();
        if (!empty($post)) {
            $faqCatObj = new FaqCategory();
            if (!$faqCatObj->updateOrder($post['faqcat'])) {
                LibHelper::exitWithError($faqCatObj->getError(), true);
            }
            LibHelper::exitWithSuccess(Labels::getLabel('MSG_ORDER_UPDATED_SUCCESSFULLY', $this->siteLangId), true);
        }
    }

    public function toggleBulkStatuses()
    {
        $this->checkEditPrivilege();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $faqcatIdsArr = FatUtility::int(FatApp::getPostedData('faqcat_ids'));
        if (empty($faqcatIdsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($faqcatIdsArr as $faqcatId) {
            if (1 > $faqcatId) {
                continue;
            }

            $this->updateFaqCatStatus($faqcatId, $status);
        }
        $this->set('msg', Labels::getLabel('MSG_STATUS_UPDATED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    private function updateFaqCatStatus($faqcatId, $status)
    {
        $status = FatUtility::int($status);
        $faqcatId = FatUtility::int($faqcatId);
        if (1 > $faqcatId || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $obj = new FaqCategory($faqcatId);
        if (!$obj->changeStatus($status)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    public function autoComplete()
    {
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE');
        $post = FatApp::getPostedData();

        $srch = FaqCategory::getSearchObject($this->siteLangId);
        $srch->addMultipleFields(array('faqcat_id, IFNULL(faqcat_name, faqcat_identifier) as faqcat_name'));

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cond = $srch->addCondition('faqcat_name', 'LIKE', '%' . $post['keyword'] . '%');
            $cond->attachCondition('faqcat_identifier', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
        }

        $excludeRecords = FatApp::getPostedData('excludeRecords', FatUtility::VAR_INT, []);
        $collectionId = FatApp::getPostedData('collection_id', FatUtility::VAR_INT, 0);
        $alreadyAdded = !empty($excludeRecords) ? array_flip($excludeRecords) : Collections::getRecords($collectionId);
        if (!empty($alreadyAdded) && 0 < count($alreadyAdded)) {
            $srch->addCondition('faqcat_id', 'NOT IN', array_keys($alreadyAdded));
        }

        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $posts = FatApp::getDb()->fetchAll($rs, 'faqcat_id');
        $json = array(
            'pageCount' => $srch->pages(),
            'results' => []
        );
        foreach ($posts as $key => $post) {
            $json['results'][] = array(
                'id' => $key,
                'text' => strip_tags(html_entity_decode($post['faqcat_name'], ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode($json));
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getFormColumns(): array
    {
        $faqCategoriesTblHeadingCols = CacheHelper::get('faqCategoriesTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($faqCategoriesTblHeadingCols) {
            return json_decode($faqCategoriesTblHeadingCols, true);
        }

        $arr = [
            'dragdrop' => '',
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
           /*  'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'faqcat_id' => Labels::getLabel('LBL_ID', $this->siteLangId),
            'faqcat_name' => Labels::getLabel('LBL_category_Name', $this->siteLangId),
            'faqcat_active' => Labels::getLabel('LBL_Status', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('faqCategoriesTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getDefaultColumns(): array
    {
        return [
            'dragdrop',
            'select_all',
            /* 'listSerial', */
            'faqcat_name',
            'faqcat_active',
            'action',
        ];
    }

    /**
     * Undocumented function
     *
     * @param array $fields
     * @return array
     */
    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['dragdrop', 'faqcat_name', 'faqcat_active'], Common::excludeKeysForSort());
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void
    {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditFaqCategories($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditFaqCategories();
        }
    }
}
