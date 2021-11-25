<?php

class FaqController extends ListingBaseController
{
    protected $modelClass = 'Faq';

    public function __construct($action) {
        parent::__construct($action);
        $this->objPrivilege->canViewFaq();
    }

    public function list(int $faqCatId)
    {
        $this->checkEditPrivilege(true);
        if (1 > $faqCatId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields, $faqCatId);
        $frmSearch->fill(['faqCatId' => $faqCatId]);
        $pageData = PageLanguageData::getAttributesByKey('MANAGE_FAQ', $this->siteLangId);   
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
       
        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $this->set('pageData', $pageData);
        $this->set('faqCatId', $faqCatId);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_FAQ_TITLE', $this->siteLangId));
        $this->getListingData($faqCatId);
        $this->_template->render();
    }

    public function getSearchForm($fields = [])
    {
        $fields = $this->getFormColumns();

        $frm = new Form('frmRecordSearch');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'faqCatId');
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        if (!empty($fields)) {
            $this->addSortingElements($frm, 'spplan_price');
        }

        HtmlHelper::addSearchButton($frm);
        return $frm;
    }

    public function getListingData(int $faqCatId)
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

        $srch = Faq::getSearchObject($this->siteLangId);

        if($faqCatId && $faqCatId > 0){
            $srch->addCondition('faq_faqcat_id', '=', $faqCatId);
        }
        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('f.faq_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('f_l.faq_title', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
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

    public function search()
    {
        $faqCatId = FatApp::getPostedData('faqCatId', FatUtility::VAR_INT, 0);
        $this->getListingData($faqCatId);
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'faq/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function form() {
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
            $frm->fill($data);
        }
        $this->set('languages', Language::getAllNames());
        $this->set('faqCatId', $faqCatId);
        $this->set('faq_id', $recordId);
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_FAQ_SETUP', $this->siteLangId));
        $this->_template->render(false, false);

    }

    private function getForm(int $faqCatId = 0)
    {
        $frm = new Form('frmFaq');
        $frm->addHiddenField('', 'faqCatId', $faqCatId);
        $frm->addHiddenField('', 'faq_id', 0);
        $frm->addHiddenField('', 'lang_id', $this->siteLangId);
        $frm->addRequiredField(Labels::getLabel('FRM_FAQ_TITLE', $this->siteLangId), 'faq_title');
        $frm->addTextArea(Labels::getLabel('FRM_Content', $this->siteLangId), 'faq_content');
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_Status', $this->siteLangId), 'faq_active', $activeInactiveArr, '', array(), '');

        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) ) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        /* $frm->addCheckBox(Labels::getLabel('LBL_Featured',$this->siteLangId), 'faq_featured', 1, array(),false,0); */

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
        $post['faq_identifier'] = $post['faq_title'] ;
        unset($post['faqcat_id'], $post['faq_id'], $post['lang_id']);
        
        $langData = [
            'faqlang_faq_id' => $recordId,
            'faqlang_lang_id' => $langId,
            'faq_title' => $post['faq_title'],
            'faq_content' => $post['faq_content'],
        ];
        
        $record->assignValues($post);
        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }
      
        if (!$record->updateLangData($langId, $langData)) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;
        if ($recordId > 0) {
            $faqId = $recordId;
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = Faq::getAttributesByLangId($langId, $faqId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $faqId = $record->getMainTableRecordId();
            $newTabLangId = $this->siteLangId;
        }

        $this->set('msg', Labels::getLabel('MSG_CATEGORY_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('recordId', $faqId);
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
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = Faq::getAttributesByLangId($langId, $recordId, null,true);
        }
        $faqCatId = isset($langData['faq_faqcat_id']) ? $langData['faq_faqcat_id'] : 0;
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
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->_template->render(false, false);
    }

    /**
     * Getting the Language Form
     *
     * @param integer $langId
     * @return void
     */
    private function getLangForm(int $langId = 0)
    {
        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $langId = 1 > $langId ? $siteLangId : $langId;
        $frm = new Form('frmFaqLang');
        $frm->addHiddenField('', 'faq_id');
        $siteLangId = $this->siteLangId;
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_Title', $this->siteLangId), 'faq_title');
        $frm->addTextArea(Labels::getLabel('FRM_Content', $this->siteLangId), 'faq_content');

        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $langId == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }


    public function langSetup() {
        $this->checkEditPrivilege();
        $post = FatApp::getPostedData();
        $recordId = $post['faq_id'];
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $langId = $post['lang_id'];
        } else {
            $langId = array_key_first($languages);
        }

        if ( $recordId == 0 || $langId == 0) {
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
            if (false === $updateLangDataobj->updateTranslatedData($recordId)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
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
    
    public function updateOrder() {
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

    public function deleteRecord() {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        
        $res = Faq::getAttributesById($recordId, array('faq_id'));
        if ($res == false) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $faqObj = new Faq($recordId);
        $faqObj->assignValues(array(Faq::tblFld('deleted') => 1));
        if (!$faqObj->save()) {
            LibHelper::exitWithError($faqObj->getError(), true);
        }

        FatUtility::dieJsonSuccess($this->str_delete_record);
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
            return json_decode($faqTblHeadingCols);
        }

        $arr = [
            'dragdrop' => '',
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
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
            'listSerial',
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
        return [];
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
}
