<?php

class ImportInstructionsController extends ListingBaseController
{
    protected $pageKey = 'MANAGE_IMPORT_INSTRUCTIONS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewImportInstructions();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('canEdit', $this->objPrivilege->canEditImportInstructions($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->getListingData();
        $this->set('includeEditor', true);
        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'import-instructions/search.php', true),
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

        $srch = Extrapage::getSearchObject($this->siteLangId, false);
        $srch->addCondition('epage_content_for', '=', Extrapage::CONTENT_IMPORT_INSTRUCTION);
        $srch->addMultipleFields([
            'ep.*',
            'ep_l.*'
        ]);

        if (isset($post['keyword']) && '' != $post['keyword']) {
            $condition = $srch->addCondition('ep.epage_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('ep_l.epage_label', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
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
        $this->set('canEdit', $this->objPrivilege->canEditImportInstructions($this->admin_id, true));
    }

    public function langForm($autoFillLangData = 0)
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, CommonHelper::getDefaultFormLangId());

        if (1 > $recordId || 1 > $langId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $epageData = Extrapage::getAttributesById($recordId);
        $langFrm = $this->getLangForm($recordId, $langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(Extrapage::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId, CommonHelper::getDefaultFormLangId());
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = Extrapage::getAttributesByLangId($langId, $recordId, ['*','IFNULL(epage_label,epage_identifier) as epage_label'], applicationConstants::JOIN_RIGHT);           
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('epageData', $epageData);
        $this->set('recordId', $recordId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function langSetup()
    {
        $post = FatApp::getPostedData();
        $recordId = FatUtility::int($post['epage_id']);

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = FatUtility::int($post['lang_id']);
        } else {
            $lang_id = array_key_first($languages);
        }


        if ($recordId == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }
        $frm = $this->getLangForm($recordId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        unset($post['epage_id']);
        unset($post['lang_id']);
        $data = array(
            'epagelang_lang_id' => $lang_id,
            'epagelang_epage_id' => $recordId,
            'epage_label' => $post['epage_label'],
            'epage_content' => $post['epage_content'],
        );

        $epageObj = new Extrapage($recordId);
        if (!$epageObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($epageObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(Extrapage::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId, CommonHelper::getDefaultFormLangId())) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = Extrapage::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getLangForm($recordId = 0, $langId = 0)
    {
        $langId = 1 > $langId ? $this->siteLangId : $langId;
        $frm = new Form('frmBlockLang');
        $frm->addHiddenField('', 'epage_id', $recordId);
        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', $languages, $langId, array(), '');
        } else {
            $langId = array_key_first($languages);
            $frm->addHiddenField('', 'lang_id', $langId);
        }

        $frm->addRequiredField(Labels::getLabel('FRM_SECTION_TITLE', $langId), 'epage_label');
        $frm->addHtmlEditor(Labels::getLabel('FRM_SECTION_CONTENT', $langId), 'epage_content');
        $languages = Language::getAllNames();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languages) && $langId == CommonHelper::getDefaultFormLangId()) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $langId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    protected function getFormColumns(): array
    {
        $importInstructionsTblHeadingCols = CacheHelper::get('importInstructionsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($importInstructionsTblHeadingCols) {
            return json_decode($importInstructionsTblHeadingCols, true);
        }

        $arr = [
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'epage_identifier' => Labels::getLabel('LBL_TITLE', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('importInstructionsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'listSerial',
            'epage_identifier',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
