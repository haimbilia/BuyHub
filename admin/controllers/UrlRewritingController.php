<?php

class UrlRewritingController extends ListingBaseController
{
    protected $pageKey = 'MANAGE_URL_REWRITING';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewUrlRewrite();
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

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_ORIGINAL_AND_CUSTOM', $this->siteLangId));
        $this->getListingData();

        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    { 
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'url-rewriting/search.php', true),
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
        $lang_id = FatApp::getPostedData('lang_id', FatUtility::VAR_INT, $this->siteLangId);
        $lang_id = 1 > $lang_id ? $this->siteLangId : $lang_id;
        $languages = Language::getAllNames();

        $srch = UrlRewrite::getSearchObject($this->siteLangId);
        $srch->joinTable(Language::DB_TBL, 'LEFT OUTER JOIN', 'lng.language_id = ur.urlrewrite_lang_id', 'lng');
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $condition = $srch->addCondition('ur.urlrewrite_original', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('ur.urlrewrite_custom', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        if (!empty($post['url_type'])) {
            $srch->addCondition('ur.urlrewrite_original', 'like', $post['url_type'] . '%');
        }

        if ($lang_id > 0) {
            $srch->addCondition('ur.urlrewrite_lang_id', '=', 'mysql_func_' . $lang_id, 'AND', true);
        }
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(['ur.*', 'lng.*']);
        $srch->addOrder($sortBy, $sortOrder);
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $this->set("arrListing", FatApp::getDb()->fetchAll($srch->getResultSet()));
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('languages', $languages);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditUrlRewrite($this->admin_id, true));
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $frm = $this->getForm();
        $frm->fill(array('urlrewrite_id' => $recordId));

        if (0 < $recordId) {
            $srch = UrlRewrite::getSearchObject();
            $srch->joinTable(UrlRewrite::DB_TBL, 'LEFT OUTER JOIN', 'temp.urlrewrite_original = ur.urlrewrite_original', 'temp');
            $srch->addCondition('ur.urlrewrite_id', '=', 'mysql_func_' . $recordId, 'AND', true);
            $rs = $srch->getResultSet();
            $data = [];
            while ($row = FatApp::getDb()->fetch($rs)) {
                $data['urlrewrite_original'] = $row['urlrewrite_original'];
                $data['urlrewrite_custom'][$row['urlrewrite_lang_id']] = $row['urlrewrite_custom'];
            }

            if (empty($data)) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formLayout', Language::getLayoutDirection($this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditUrlRewrite();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = FatUtility::int($post['urlrewrite_id']);
        unset($post['urlrewrite_id']);

        $row = [];
        if (0 < $recordId) {
            $srch = UrlRewrite::getSearchObject();
            $srch->joinTable(UrlRewrite::DB_TBL, 'LEFT OUTER JOIN', 'temp.urlrewrite_original = ur.urlrewrite_original', 'temp');
            $srch->addCondition('ur.urlrewrite_id', '=', 'mysql_func_' . $recordId, 'AND', true);
            $srch->addMultipleFields(array('temp.*'));
            $rs = $srch->getResultSet();
            $row = FatApp::getDb()->fetchAll($rs, 'urlrewrite_lang_id');
            $originalUrl = $row ? current($row)['urlrewrite_original'] : '';
        } else {
            $originalUrl = FatApp::getPostedData('urlrewrite_original', FatUtility::VAR_STRING, '');
        }

        if (empty($originalUrl)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $langArr = Language::getAllNames();
        foreach ($langArr as $langId => $langName) {
            if (!FatApp::getConfig('CONF_LANG_SPECIFIC_URL', FatUtility::VAR_INT, 0) && $langId != FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1)) {
                continue;
            }

            $urlrewriteId = 0;
            if (array_key_exists($langId, $row)) {
                $urlrewriteId = $row[$langId]['urlrewrite_id'];
            }

            $url = $post['urlrewrite_custom'][$langId];
            $data = [
                'urlrewrite_original' => $originalUrl,
                'urlrewrite_lang_id' => $langId,
                'urlrewrite_custom' => CommonHelper::seoUrl($url)
            ];

            FatApp::getDb()->insertFromArray(UrlRewrite::DB_TBL, $data, false, [], $data);
            /* $record = new UrlRewrite($urlrewriteId);
            $record->assignValues($data); */

            /* if (!$record->save()) {
                LibHelper::exitWithError($record->getError(), true);
            } */
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditUrlRewrite();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $res = UrlRewrite::getAttributesById($recordId, array('urlrewrite_id'));
        if ($res == false) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditUrlRewrite();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('urlrewrite_ids'));

        if (empty($recordIdsArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            $this->markAsDeleted($recordId);
        }
        $this->set('msg', Labels::getLabel('MSG_RECORDS_DELETED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $obj = new UrlRewrite($recordId);
        if (!$obj->deleteRecord(false)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'urlrewrite_original');
        }

        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $langArr = Language::getAllNames();
        $defaultLangId = FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1);
        if (!FatApp::getConfig('CONF_LANG_SPECIFIC_URL', FatUtility::VAR_INT, 0)) {
            $langArr = [$defaultLangId => $langArr[$defaultLangId]];
        }

        if (count($langArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $this->siteLangId), 'lang_id', $langArr, FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1), [], Labels::getLabel('LBL_SELECT_LANGUAGE', $this->siteLangId));
        } else {
            $lang_id = array_key_first($langArr);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }
        $frm->addSelectBox(Labels::getLabel('FRM_URL_TYPE', $this->siteLangId), 'url_type', UrlRewrite::getTypeArray($this->siteLangId), '', [], Labels::getLabel('LBL_SELECT_URL_TYPE', $this->siteLangId));

        $frm->addHiddenField('', 'total_record_count');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmUrlRewrite');
        $frm->addHiddenField('', 'urlrewrite_id');
        $frm->addRequiredField(Labels::getLabel('FRM_ORIGINAL_URL', $this->siteLangId), 'urlrewrite_original');

        $langArr = Language::getAllNames();
        foreach ($langArr as $langId => $langName) {
            if (!FatApp::getConfig('CONF_LANG_SPECIFIC_URL', FatUtility::VAR_INT, 0) && $langId != FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1)) {
                continue;
            }

            $fieldName = Labels::getLabel('FRM_CUSTOM_URL', $this->siteLangId);
            if (FatApp::getConfig('CONF_LANG_SPECIFIC_URL', FatUtility::VAR_INT, 0)) {
                $fieldName .=  '(' . $langName . ')';
            }
            $frm->addRequiredField($fieldName, 'urlrewrite_custom[' . $langId . ']');
        }
        $fld =  $frm->addHTML('', '', '');
        $fld->htmlAfterField = '<span class="form-text">' . Labels::getLabel('LBL_EXAMPLE:_CUSTOM_URL_EXAMPLE', $this->siteLangId) . '</span>';
        // $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $urlRewritingTblHeadingCols = CacheHelper::get('urlRewritingTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($urlRewritingTblHeadingCols) {
            return json_decode($urlRewritingTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            /*  'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'urlrewrite_original' => Labels::getLabel('LBL_ORIGINAL', $this->siteLangId),
            'url_type' => Labels::getLabel('LBL_TYPE', $this->siteLangId),
            'language_code' => Labels::getLabel('LBL_LANGUAGE', $this->siteLangId),
            'urlrewrite_custom' => Labels::getLabel('LBL_CUSTOM', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('urlRewritingTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /*  'listSerial', */
            'urlrewrite_original',
            'url_type',
            'language_code',
            'urlrewrite_custom',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort(), ['url_type']);
    }

    public function getBreadcrumbNodes($action)
    {
        switch ($action) {
            case 'index':
                $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
                $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);
                $this->nodes = [
                    ['title' => Labels::getLabel('NAV_SEO', $this->siteLangId)],
                    ['title' => $pageTitle]
                ];
                break;
            default:
                parent::getBreadcrumbNodes($action);
                break;
        }
        return $this->nodes;
    }
}
