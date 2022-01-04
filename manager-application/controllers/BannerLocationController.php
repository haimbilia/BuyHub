<?php

class BannerLocationController extends ListingBaseController
{
    protected $modelClass = 'BannerLocation';
    protected $pageKey = 'MANAGE_BANNER_LOCATIONS';
   
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBanners();
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
            $this->set("canEdit", $this->objPrivilege->canEditBanners($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditBanners();
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
        $actionItemsData['performBulkAction'] = true;
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_TITLE', $this->siteLangId));
        $this->getListingData();
        $this->set('includeEditor', true);
        $this->checkEditPrivilege(true);
        $this->_template->addJs('banner-location/page-js/index.js');
        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'banner-location/search.php', true),
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
        $searchForm = $this->getSearchForm($fields);
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 :  FatUtility::int($data['page']);
        $post = $searchForm->getFormDataFromArray($data);
        $srch = BannerLocation::getSearchObject($this->siteLangId, false);
        $srch->addMultipleFields([
            'blocation_banner_count', 'blocation_collection_id', 'blocation_banner_width', 'blocation_banner_height', 
            'blocation_id', 'blocation_promotion_cost', 'blocation_active', 'IFNULL(blocation_name,blocation_identifier) as blocation_name'
        ]);
        $srch->addCondition('blocation_collection_id', '=', '0');
        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('blocation_name', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('blocation_identifier', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
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
        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->siteLangId));
        $this->checkEditPrivilege(true);
    }

    private function getForm($recordId)
    {
        $currency_id = FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1);
        $currencyData = Currency::getAttributesById($currency_id, array('currency_code', 'currency_symbol_left', 'currency_symbol_right'));
        $currencySymbol = ($currencyData['currency_symbol_left'] != '') ? $currencyData['currency_symbol_left'] : $currencyData['currency_symbol_right'];

        $frm = new Form('frmBannerLocation');
        $frm->addHiddenField('', 'blocation_id', $recordId);
        $frm->addRequiredField(Labels::getLabel('FRM_BANNER_LOCATION_TITLE', $this->siteLangId), 'blocation_name');

        $str = Labels::getLabel('FRM_PROMOTION_COST[{CURRENCY-SYMBOL}]', $this->siteLangId);
        $str = CommonHelper::replaceStringData($str, ['{CURRENCY-SYMBOL}' => $currencySymbol]);
        $frm->addTextBox($str, 'blocation_promotion_cost');
        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'blocation_active', $activeInactiveArr, '', array(), '');

        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $frm = $this->getForm($recordId);
        $srch = BannerLocation::getSearchObject($this->siteLangId, false);
        $srch->addMultipleFields([
            'blocation_banner_count', 'blocation_collection_id', 'blocation_banner_width', 'blocation_banner_height', 'blocation_id', 
            'blocation_id', 'blocation_promotion_cost', 'blocation_active', 'IFNULL(blocation_name,blocation_identifier) as blocation_name'
        ]);
        $srch->addCondition('blocation_id', '=', $recordId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $data = FatApp::getDb()->fetch($srch->getResultSet());
        
        if (empty($data)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $frm->fill($data);

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $this->set('frm', $frm);
        $this->set('recordId', $recordId);
        $this->set('lang_id', $this->siteLangId);
        $this->set('activeInactiveArr', $activeInactiveArr);
        $this->set('formTitle', Labels::getLabel('LBL_BANNER_LOCATION_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, '_partial/listing/form.php', true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->checkEditPrivilege();
        $data = FatApp::getPostedData();
        $recordId = $data['blocation_id'];
        $frm = $this->getForm($recordId);
        if (false === $data) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $data = [
            'blocation_identifier' => $post['blocation_name'],
            'blocation_promotion_cost' => $post['blocation_promotion_cost'],
            'blocation_active' => $post['blocation_active'],
            'blocation_id' => $recordId,
        ] ;

        $bannerObj = new Banner();
        if (!$bannerObj->updateLocationData($data)) {
            LibHelper::exitWithError($bannerObj->getError(), true);
        }

        $langId = $this->siteLangId;
        $langData = array(
            'blocationlang_blocation_id' => $recordId,
            'blocationlang_lang_id' => $this->siteLangId,
            'blocation_name' => $post['blocation_name'],
        );

        $bannerObj = new BannerLocation($recordId);
        if (!$bannerObj->updateLangData($this->siteLangId, $langData)) {
            LibHelper::exitWithError($bannerObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(BannerLocation::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = BannerLocation::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', Labels::getLabel('MSG_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($autoFillLangData = 0) 
    {
        $this->checkEditPrivilege();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, 0);

        if (1 > $recordId || $langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $langFrm = $this->getLangForm($recordId, $langId);

        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(BannerLocation::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = BannerLocation::getAttributesByLangId($langId, $recordId);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('formTitle', Labels::getLabel('LBL_BANNER_LOCATION_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, '_partial/listing/lang-form.php', true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getLangForm($recordId, $langId)
    {
        $frm = new Form('frmBannerLocLang');
        $frm->addHiddenField('', 'blocationlang_blocation_id', $recordId);
        $frm->addHiddenField('', 'blocationlang_lang_id', $langId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_BANNER_LOCATION_TITLE', $this->siteLangId), 'blocation_name');
        return $frm;
    }

    public function langSetup()
    {
        $this->checkEditPrivilege();
        $post = FatApp::getPostedData();
        $recordId = $post['blocationlang_blocation_id'];
        $langId = $post['lang_id'];

        if ($langId == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($recordId, $langId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        $data = array(
            'blocationlang_blocation_id' => $recordId,
            'blocationlang_lang_id' => $langId,
            'blocation_name' => $post['blocation_name'],
        );

        $bannerObj = new BannerLocation($recordId);
        if (!$bannerObj->updateLangData($langId, $data)) {
            LibHelper::exitWithError($bannerObj->getError(), true);
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!BannerLocation::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', Labels::getLabel('MSG_SETUP_SUCCESSFUL', $this->siteLangId));
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }


    public function layouts()
    {
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    protected function getFormColumns(): array
    {
        $bannerLocationTblHeadingCols = CacheHelper::get('bannerLocationTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($bannerLocationTblHeadingCols) {
            return json_decode($bannerLocationTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_ID', $this->siteLangId),
            'blocation_name' => Labels::getLabel('LBL_TITLE', $this->siteLangId),
            'blocation_banner_width' => Labels::getLabel('LBL_PREFFERED_WIDTH_(IN_PIXELS)', $this->siteLangId),
            'blocation_banner_height' => Labels::getLabel('LBL_PREFFERED_HEIGHT_(IN_PIXELS)', $this->siteLangId),
            'blocation_promotion_cost' => Labels::getLabel('LBL_PROMOTION_COST', $this->siteLangId),
            'blocation_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId)
        ];
        CacheHelper::create('bannerLocationTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
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
            'select_all',
            'listSerial',
            'blocation_name',
            'blocation_banner_width',
            'blocation_banner_height',
            'blocation_promotion_cost',
            'blocation_active',
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
        return array_diff($fields, ['blocation_active'], Common::excludeKeysForSort());
    }
    
}
