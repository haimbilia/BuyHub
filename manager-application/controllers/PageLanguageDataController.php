<?php
class PageLanguageDataController extends ListingBaseController
{
    protected $modelClass = 'PageLanguageData';
    protected $pageKey = 'MANAGE_PAGES_LANGUAGE_DATA_BLOCK';
   
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewPagesLanguageData();
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
            $this->set("canEdit", $this->objPrivilege->canEditPagesLanguageData($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditPagesLanguageData();
        }
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->setModel();
        $actionItemsData = HtmlHelper::getDefaultActionItems($fields, $this->modelObj);
        $actionItemsData['newRecordBtn'] = false;
        $actionItemsData['performBulkAction'] = false;
        $actionItemsData['deleteButton'] = false;
       
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_KEY_OR_TITLE', $this->siteLangId));
        $this->getListingData();
        $this->_template->addJs('page-language-data/page-js/index.js');
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function displayAlert()
    {
        $plangId = FatApp::getPostedData('id', FatUtility::VAR_INT, 0);
        if (1 > $plangId) {
            LibHelper::exitWithError($this->str_invalid_request, true, false, true);
        }

        $pageData = PageLanguageData::getAttributesById($plangId);
        if (false == $pageData) {
            LibHelper::exitWithError($this->str_invalid_request, true, false, true);
        }
        $this->set('pageData', $pageData);
        $jsonData = [
            'html' => $this->_template->render(false, false, 'page-language-data/display-alert.php', true, true)
        ];        

        LibHelper::exitWithSuccess($jsonData, true);
    }


    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'page-language-data/search.php', true),
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
        $searchForm = $this->getSearchForm(false, $fields);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);
        $srch = PageLanguageData::getSearchObject();

        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('plang_key', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('plang_title', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        $srch->addGroupBy(PageLanguageData::DB_TBL_PREFIX . 'key');

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
        $srch->setPageNumber($page);
        $srch->addOrder($sortBy, $sortOrder); 
        $srch->setPageSize($pageSize);
        $records = FatApp::getDb()->fetchAll($srch->getResultSet());

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
        $this->checkEditPrivilege(true);
    }

    public function form($pLangKey = '', $langId = 0, $autoFillLangData = 0)
    {
        $this->checkEditPrivilege();
        $langId = FatUtility::int($langId);
        
        if ($pLangKey == '' || $langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request);
        }
        $langFrm = $this->getForm($pLangKey, $langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(PageLanguageData::DB_TBL);
            $translatedData = $updateLangDataobj->getTranslatedData($pLangKey, $langId);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = PageLanguageData::getAttributesByKey($pLangKey, $langId);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        if (is_array($langData) && array_key_exists('plang_replacements', $langData) && $langData['plang_replacements'] == '') {
            $etplData = PageLanguageData::getAttributesByKey($pLangKey, $langId);
            $langFrm->getField('plang_replacements')->value = $etplData['plang_replacements'];
        }

      
        $this->set('languages', Language::getAllNames());
        $this->set('pLangKey', $pLangKey);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('frm', $langFrm);
       
        $this->_template->render(false, false);
    }

    private function getForm($pLangKey = 0, $lang_id = 0)
    {
        $frm = new Form('frmCMSPage');
        $frm->addHiddenField('', 'plang_key', $pLangKey);

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', $languages, $lang_id, array(), '');
        } else {
            $lang_id = array_key_first($languages);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }
        $frm->addRequiredField(Labels::getLabel('FRM_PAGE_TITLE', $this->siteLangId), 'plang_title');
        $frm->addTextArea(Labels::getLabel('FRM_PAGE_SUMMARY', $this->siteLangId), 'plang_summary');
        $frm->addTextArea(Labels::getLabel('FRM_WARNING_MESSAGE', $this->siteLangId), 'plang_warring_msg');
        $frm->addTextArea(Labels::getLabel('FRM_RECOMMENDATIONS', $this->siteLangId), 'plang_recommendations');
        $frm->addTextArea(Labels::getLabel('FRM_REPLACEMENTS', $this->siteLangId), 'plang_replacements');
        return $frm;
    }

    public function setup() 
    {

        $this->checkEditPrivilege();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true, false, true);
        }

        $recordId = $post['plang_id'];
        // unset($post['plang_id']);
        $contentPage = new PageLanguageData($recordId);
        $contentPage->assignValues($post);
        if (!$contentPage->save()) {
            LibHelper::exitWithError($contentPage->getError(), true, false, true);
        }

        $newTabLangId = 0;
        if ($recordId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!ContentPage::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $recordId = $contentPage->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        $this->set('msg', Labels::getLabel('MSG_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }


     /**
     * Undocumented function
     *
     * @return array
     */
    protected function getFormColumns(): array
    {
        $pagesLanguageDataTblHeadingCols = CacheHelper::get('pagesLanguageDataTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($pagesLanguageDataTblHeadingCols) {
            return json_decode($pagesLanguageDataTblHeadingCols);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_ID', $this->siteLangId),
            'plang_key' => Labels::getLabel('LBL_KEY', $this->siteLangId),
            'plang_title' => Labels::getLabel('LBL_TITLE', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId)
        ];
        CacheHelper::create('pagesLanguageDataTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
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
            'listSerial',
            'plang_key',
            'plang_title',
            'action'
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
        return array_diff($fields, [], Common::excludeKeysForSort());
    }
}
