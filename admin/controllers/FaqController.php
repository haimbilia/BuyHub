<?php

class FaqController extends ListingBaseController
{
    protected string $modelClass = 'Faq';
    protected $pageKey = 'MANAGE_FAQ';
    protected $faqCatId;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewFaq();
    }

    public function index()
    {
        FatApp::redirectUser(UrlHelper::generateUrl('FaqCategories'));
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->checkEditPrivilege();
        $this->setModel($constructorArgs);
        $this->formLangFields = [
            'faqlang_lang_id',
            'faqlang_faq_id',
            'faq_title',
            'faq_content'
        ];
        $this->set('formTitle', Labels::getLabel('LBL_FAQ_SETUP', $this->siteLangId));
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
            $this->set("canEdit", $this->objPrivilege->canEditFaq($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditFaq();
        }
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'faq/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function list()
    {
        $this->checkEditPrivilege(true);
        $faqCatId = FatApp::getPostedData('faqCatId', FatUtility::VAR_INT, 0);
        if (1 > $faqCatId) {
            Message::addErrorMessage($this->str_invalid_request);
            FatApp::redirectUser(UrlHelper::generateUrl('FaqCategories'));
        }
        $this->faqCatId = $faqCatId;

        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $faqCategory = FaqCategory::getAttributesByLangId($this->siteLangId, $faqCatId, 'faqcat_name', applicationConstants::JOIN_RIGHT);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $faqCategory ? Labels::getLabel('LBL_FAQ_CATEGORY', $this->siteLangId) . ' : ' . $faqCategory : LibHelper::getControllerName(true);
        $this->setModel();
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_FAQ_TITLE', $this->siteLangId));
        $this->getListingData();

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['statusButtons'] = false;
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['newRecordBtnAttrs'] = [
            'attr' => [
                'onclick' => 'addNewFaq(' . $faqCatId . ')',
            ]
        ];
        $this->set('actionItemsData', $actionItemsData);
        $this->_template->addJs('faq/page-js/list.js');
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function getSearchForm($fields = [])
    {
        $fields = $this->getFormColumns();
        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'faqCatId', $this->faqCatId);
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        if (!empty($fields)) {
            $this->addSortingElements($frm, 'faq_display_order');
        }

        HtmlHelper::addSearchButton($frm);
        return $frm;
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
        $searchForm = $this->getSearchForm($fields);
        $post = $searchForm->getFormDataFromArray($data);
        $srch = Faq::getSearchObject($this->siteLangId);
        $srch->addMultipleFields(['f.*', 'COALESCE(f_l.faq_title, f.faq_identifier) as faq_title']);

        $faqCatId = FatApp::getPostedData('faqCatId', FatUtility::VAR_INT, 0);
        if ($faqCatId && $faqCatId > 0) {
            $srch->addCondition('faq_faqcat_id', '=', $faqCatId);
        }
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $condition = $srch->addCondition('f.faq_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('f_l.faq_title', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : FatUtility::int($data['page']);
        $srch->addOrder('faq_display_order', 'ASC');
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        $this->set('sortBy', 'faq_display_order');
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('siteLangId', $this->siteLangId);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->checkEditPrivilege(true);
    }

    public function form()
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $faqCatId = FatApp::getPostedData('faqCatId', FatUtility::VAR_INT, 0);

        if ($faqCatId < 1) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $frm = $this->getForm($faqCatId);

        if (0 < $recordId) {
            $srch = Faq::getSearchObject($this->siteLangId);
            $srch->addCondition('faq_faqcat_id', '=', $faqCatId);
            $srch->addCondition('faq_id', '=', $recordId);
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $rs = $srch->getResultSet();
            $data = FatApp::getDb()->fetch($rs);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $data['faqCatId'] = $faqCatId;
            $data['faq_title'] = !empty($data['faq_title']) ? $data['faq_title'] : $data['faq_identifier'];
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('faqCatId', $faqCatId);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_FAQ_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getForm(int $faqCatId = 0)
    {
        $frm = new Form('frmFaq');
        $frm->addHiddenField('', 'faqCatId', $faqCatId);
        $frm->addHiddenField('', 'faq_id', 0);
        $frm->addHiddenField('', 'lang_id', $this->siteLangId);
        $frm->addRequiredField(Labels::getLabel('FRM_FAQ_TITLE', $this->siteLangId), 'faq_title');
        $frm->addTextArea(Labels::getLabel('FRM_CONTENT', $this->siteLangId), 'faq_content');
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addCheckBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'faq_active', applicationConstants::ACTIVE, [], true, applicationConstants::INACTIVE);

        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        $languages = Language::getAllNames();
        if (!empty($translatorSubscriptionKey) && 1 < count($languages)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        /* $frm->addCheckBox(Labels::getLabel('LBL_FEATURED',$this->siteLangId), 'faq_featured', 1, array(),false,0); */

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

        $faqCatId = FatUtility::int($post['faqCatId']);
        $recordId = FatUtility::int($post['faq_id']);
        $langId = FatUtility::int($post['lang_id']);

        $record = new Faq($recordId);

        if ($recordId == 0) {
            $display_order = $record->getMaxOrder();
            $post['faq_display_order'] = $display_order;
        }

        $post['faq_faqcat_id'] = $faqCatId;
        $post['faq_identifier'] = $post['faq_title'];
        unset($post['faqcat_id'], $post['faq_id'], $post['lang_id']);

        $langData = [
            'faqlang_faq_id' => $recordId,
            'faqlang_lang_id' => $langId,
            'faq_title' => $post['faq_title'],
            'faq_content' => $post['faq_content'],
        ];

        $record->assignValues($post);
        if (!$record->save()) {
            $msg = $record->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }
        $recordId = $record->getMainTableRecordId();


        if (!$record->updateLangData($langId, $langData)) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData($record::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId, CommonHelper::getDefaultFormLangId())) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        if (0 < count($languages)) {
            foreach ($languages as $langId => $langName) {
                if (!Brand::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        }

        $this->set('msg', Labels::getLabel('MSG_CATEGORY_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('recordId', $recordId);
        $this->set('faqCatId', $faqCatId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($autoFillLangData = 0)
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);
        if ($recordId == 0 || $langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(Faq::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId, CommonHelper::getDefaultFormLangId());
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = Faq::getAttributesByLangId($langId, $recordId, null, applicationConstants::JOIN_RIGHT);
        }
        $faqCatId = Faq::getAttributesById($recordId, 'faq_faqcat_id');
        $langData['faq_id'] = $recordId;
        $langData['lang_id'] = $langId;
        $langData['faqcat_id'] = $faqCatId;
        $faqLangFrm = $this->getLangForm($langId, $faqCatId);

        if ($langData) {
            $faqLangFrm->fill($langData);
        }

        $this->set('faqCatId', $faqCatId);
        $this->set('recordId', $recordId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $faqLangFrm);
        $this->set('formTitle', Labels::getLabel('LBL_FAQ_SETUP', $this->siteLangId));
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    /**
     * Getting the Language Form
     *
     * @param integer $langId
     * @return void
     */
    private function getLangForm(int $langId = 0)
    {        
        $langId = 1 > $langId ? $this->siteLangId : $langId;
        $frm = new Form('frmFaqLang');
        $frm->addHiddenField('', 'faq_id');     
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_TITLE', $this->siteLangId), 'faq_title');
        $frm->addTextArea(Labels::getLabel('FRM_CONTENT', $this->siteLangId), 'faq_content');

        return $frm;
    }

    public function langSetup()
    {
        $this->checkEditPrivilege();
        $post = FatApp::getPostedData();
        $recordId = $post['faq_id'];
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $langId = $post['lang_id'];
        } else {
            $langId = array_key_first($languages);
        }

        if ($recordId == 0 || $langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $frm = $this->getLangForm($langId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['faq_id']);
        unset($post['lang_id']);
        $data = array(
            'faqlang_lang_id' => $langId,
            'faqlang_faq_id' => $recordId,
            'faq_title' => $post['faq_title'],
            'faq_content' => $post['faq_content'],
        );
        $faqObj = new Faq($recordId);
        if (!$faqObj->updateLangData($langId, $data)) {
            LibHelper::exitWithError($faqObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(Faq::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId, CommonHelper::getDefaultFormLangId())) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = (array)Language::getDropDownList(CommonHelper::getDefaultFormLangId());
        foreach ($languages as $langId => $langName) {
            if (!Faq::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateOrder()
    {
        $this->checkEditPrivilege();
        $post = FatApp::getPostedData();
        if (!empty($post)) {
            $faqObj = new Faq();
            if (!$faqObj->updateOrder($post['faqs'])) {
                LibHelper::exitWithError($faqObj->getError(), true);
            }
            FatUtility::dieJsonSuccess(Labels::getLabel('MSG_ORDER_UPDATED_SUCCESSFULLY', $this->siteLangId));
        }
    }

    public function deleteSelected()
    {
        $this->checkEditPrivilege();
        $faqcatIdsArr = FatUtility::int(FatApp::getPostedData('faq_ids'));

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

    public function autoComplete()
    {
        $pagesize = FatApp::getConfig('CONF_PAGE_SIZE');
        $post = FatApp::getPostedData();

        $srch = Faq::getSearchObject($this->siteLangId, true);
        $srch->addMultipleFields(array('faq_id, IFNULL(faq_title, faq_identifier) as faq_title'));

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cond = $srch->addCondition('faq_title', 'LIKE', '%' . $post['keyword'] . '%');
            $cond->attachCondition('faq_identifier', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
        }

        $excludeRecords = FatApp::getPostedData('excludeRecords', FatUtility::VAR_INT, []);
        $collectionId = FatApp::getPostedData('collection_id', FatUtility::VAR_INT, 0);

        $alreadyAdded = !empty($excludeRecords) ? array_flip($excludeRecords) : Collections::getRecords($collectionId);
        if (!empty($alreadyAdded) && 0 < count($alreadyAdded)) {
            $srch->addCondition('faq_id', 'NOT IN', array_keys($alreadyAdded));
        }

        $srch->joinTable(FaqCategory::DB_TBL, 'LEFT OUTER JOIN', 'fc.faqcat_id = f.faq_faqcat_id', 'fc');
        $srch->addCondition('fc.faqcat_deleted', '=', applicationConstants::NO);
        $srch->addCondition('fc.faqcat_active', '=', applicationConstants::ACTIVE);

        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $posts = FatApp::getDb()->fetchAll($rs, 'faq_id');
        
        $json = array(
            'pageCount' => $srch->pages(),
            'results' => []
        );
        foreach ($posts as $key => $post) {
            $json['results'][] = array(
                'id' => $key,
                'text' => strip_tags(html_entity_decode($post['faq_title'], ENT_QUOTES, 'UTF-8'))
            );
        }
        die(json_encode($json));
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'list':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
                $this->nodes = [
                    ['title' => Labels::getLabel('NAV_FAQ_CATEGORIES', $this->siteLangId), 'href' => UrlHelper::generateUrl('FaqCategories')],
                    ['title' => $pageTitle]
                ];
                break;
            default:
                parent::getBreadcrumbNodes($action);
                break;
        }
        return $this->nodes;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getFormColumns(): array
    {
        $faqTblHeadingCols = CacheHelper::get('faqTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($faqTblHeadingCols) {
            return json_decode($faqTblHeadingCols, true);
        }

        $arr = [
            'dragdrop' => '',
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'faq_display_order' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'faqcat_id' => Labels::getLabel('LBL_ID', $this->siteLangId),
            'faq_title' => Labels::getLabel('LBL_FAQ_TITLE', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('faqTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
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
            'faq_display_order',
            'faq_title',
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
        return array_diff($fields, ['dragdrop', 'faq_display_order', 'faq_title'], Common::excludeKeysForSort());
    }
}
