<?php

class AbusiveWordsController extends ListingBaseController
{
    protected $pageKey = 'MANAGE_ABUSIVE_KEYWORDS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewAbusiveWords();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['formAction'] = 'deleteSelected';
        $actionItemsData['performBulkAction'] = true;
        $btnTitle = Labels::getLabel('BTN_NEW', $this->siteLangId);
        $actionItemsData['newRecordBtnAttrs'] = [
            'attr' => [
                'href' => "javascript:void(0)",
                'onclick' => "addNew(true)",
                'title' => $btnTitle,
            ],
            'label' => $btnTitle,
        ];

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_ABUSIVE_KEYWORD', $this->siteLangId));
        $this->getListingData();

        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'abusive-words/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
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

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = Abusive::getSearchObject();
        $srch->addMultipleFields(['aw.*', 'tl.*']);
        $srch->joinTable('tbl_languages', 'inner join', 'abusive_lang_id = language_id and language_active = ' . applicationConstants::ACTIVE, 'tl');

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        if (!empty($post['keyword'])) {
            $srch->addCondition('aw.abusive_keyword', 'like', '%' . $post['keyword'] . '%');
        }

        if (isset($post['lang_id']) && $post['lang_id'] > 0) {
            $srch->addCondition('aw.abusive_lang_id', '=', $post['lang_id']);
        }

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
        $this->set('canEdit', $this->objPrivilege->canEditAbusiveWords($this->admin_id, true));
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $frm = $this->getForm($recordId);

        $data = array('abusive_id' => $recordId);
        if ($recordId > 0) {
            $data = Abusive::getAttributesById($recordId);
            if ($data == false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
        }

        $frm->fill($data);

        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('languages', Language::getAllNames());
        $this->set('formLayout', Language::getLayoutDirection($this->siteLangId));
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditAbusiveWords();
        $data = FatApp::getPostedData();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray($data);

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = $post['abusive_lang_id'];
        } else {
            $lang_id = array_key_first($languages);
            $post['abusive_lang_id'] = $lang_id;
        }

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = FatUtility::int($post['abusive_id']);
        unset($post['abusive_id']);

        $record = new Abusive($recordId);
        $record->assignValues($post);
        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditAbusiveWords();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $data = Abusive::getAttributesById($recordId);
        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditAbusiveWords();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('abusive_ids'));

        if (empty($recordIdsArr)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId), true);
        }

        foreach ($recordIdsArr as $recordId) {
            $data = Abusive::getAttributesById($recordId);
            if (1 > $recordId || false === $data) {
                continue;
            }

            $this->markAsDeleted($recordId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError(Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId), true);
        }
        $obj = new Abusive($recordId);
        if (!$obj->deleteRecord(false)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'abusive_keyword');
        }

        $fld = $frm->addTextBox(Labels::getLabel('FRM_Keyword', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $languages = Language::getAllNames();
        if (1 < count($languages)) {
            $frm->addSelectBox(Labels::getLabel('FRM_Language', $this->siteLangId), 'lang_id', $languages, '', [], Labels::getLabel('LBL_SELECT_LANGUAGE', $this->siteLangId));
        }
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    private function getForm($recordId = 0)
    {
        $frm = new Form('frmAbusiveWord');
        $frm->addHiddenField('', 'abusive_id', $recordId);

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $fld = $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'abusive_lang_id', $languages, '', [], Labels::getLabel('LBL_SELECT_LANGUAGE', $this->siteLangId));
            $fld->requirements()->setRequired(true);
        } else {
            $lang_id = array_key_first($languages);
            $frm->addHiddenField('', 'abusive_lang_id', $lang_id);
        }

        $frm->addRequiredField(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'abusive_keyword');

        return $frm;
    }

    protected function getFormColumns(): array
    {
        $tblHeadingCols = CacheHelper::get('abusiveWordsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'abusive_keyword' => Labels::getLabel('LBL_Keyword', $this->siteLangId),
            'language_name' => Labels::getLabel('LBL_Language', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];

        if (count(Language::getAllNames()) < 2) {
            unset($arr['language_name']);
        }

        CacheHelper::create('abusiveWordsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'abusive_keyword',
            'language_name',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'index':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_CONFIGURATION_&_MANAGEMENT', $this->siteLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => $pageTitle]
                ];
        }
        return $this->nodes;
    }
}
