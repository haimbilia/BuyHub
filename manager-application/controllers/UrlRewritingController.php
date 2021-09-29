<?php

class UrlRewritingController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewUrlRewrite();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_URL_REWRITING', $this->adminLangId));
        $this->getListingData();

        $this->_template->render();
    }

    private function getListingData()
    {
        $db = FatApp::getDb();

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);

        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_ASC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);

        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_STRING, FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        if (!in_array($pageSize, applicationConstants::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = $post['lang_id'];
        } else {
            $lang_id = array_key_first($languages);
            $post['lang_id'] = $lang_id;
        }

        $srch = UrlRewrite::getSearchObject($this->adminLangId);
        $srch->addMultipleFields(['ur.*', 'lng.*', 'ur.urlrewrite_id as listSerial']);
        $srch->joinTable(Language::DB_TBL, 'LEFT OUTER JOIN', 'lng.language_id = ur.urlrewrite_lang_id', 'lng');
        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('ur.urlrewrite_original', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('ur.urlrewrite_custom', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        if ($post['lang_id'] > 0) {
            $srch->addCondition('ur.urlrewrite_lang_id', '=', $post['lang_id']);
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->getResultSet();
        // echo $srch->getError();
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
        $this->set('canEdit', $this->objPrivilege->canEditCountries($this->admin_id, true));
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

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $frm = $this->getForm();
        $frm->fill(array('urlrewrite_id' => $recordId));

        if (0 < $recordId) {
            $srch = UrlRewrite::getSearchObject();
            $srch->joinTable(UrlRewrite::DB_TBL, 'LEFT OUTER JOIN', 'temp.urlrewrite_original = ur.urlrewrite_original', 'temp');
            $srch->addCondition('ur.urlrewrite_id', '=', $recordId);
            $rs = $srch->getResultSet();
            $data = [];
            while ($row = FatApp::getDb()->fetch($rs)) {
                $data['urlrewrite_original'] = $row['urlrewrite_original'];
                $data['urlrewrite_custom'][$row['urlrewrite_lang_id']] = $row['urlrewrite_custom'];
            }

            if (empty($data)) {
                FatUtility::dieWithError($this->str_invalid_request);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formLayout', Language::getLayoutDirection($this->adminLangId));
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditUrlRewrite();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            Message::addErrorMessage(current($frm->getValidationErrors()));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $recordId = FatUtility::int($post['urlrewrite_id']);
        unset($post['urlrewrite_id']);

        $row = [];
        if (0 < $recordId) {
            $srch = UrlRewrite::getSearchObject();
            $srch->joinTable(UrlRewrite::DB_TBL, 'LEFT OUTER JOIN', 'temp.urlrewrite_original = ur.urlrewrite_original', 'temp');
            $srch->addCondition('ur.urlrewrite_id', '=', $recordId);
            $srch->addMultipleFields(array('temp.*'));
            $rs = $srch->getResultSet();
            $row = FatApp::getDb()->fetchAll($rs, 'urlrewrite_lang_id');
            $originalUrl = $row ? current($row)['urlrewrite_original'] : '';
        } else {
            $originalUrl = FatApp::getPostedData('urlrewrite_original', FatUtility::VAR_STRING, '');
        }

        if (empty($originalUrl)) {
            Message::addErrorMessage(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId));
            FatUtility::dieJsonError(Message::getHtml());
        }

        $langArr = Language::getAllNames();
        foreach ($langArr as $langId => $langName) {
            if (!FatApp::getConfig('CONF_LANG_SPECIFIC_URL', FatUtility::VAR_INT, 0) && $langId != FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1)) {
                continue;
            }

            $recordId = 0;
            if (array_key_exists($langId, $row)) {
                $recordId = $row[$langId]['urlrewrite_id'];
            }
            $url = $post['urlrewrite_custom'][$langId];
            $data = [
                'urlrewrite_original' => $originalUrl,
                'urlrewrite_lang_id' => $langId,
                'urlrewrite_custom' => CommonHelper::seoUrl($url)
            ];
            $record = new UrlRewrite($recordId);
            $record->assignValues($data);

            if (!$record->save()) {
                Message::addErrorMessage($record->getError());
                FatUtility::dieJsonError(Message::getHtml());
            }
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
            FatUtility::dieJsonError($this->str_invalid_request_id);
        }

        $res = UrlRewrite::getAttributesById($recordId, array('urlrewrite_id'));
        if ($res == false) {
            Message::addErrorMessage($this->str_invalid_request_id);
            FatUtility::dieJsonError(Message::getHtml());
        }

        $this->markAsDeleted($recordId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditUrlRewrite();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('urlrewrite_ids'));

        if (empty($recordIdsArr)) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId)
            );
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }
            $this->markAsDeleted($recordId);
        }
        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            FatUtility::dieWithError(
                Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId)
            );
        }
        $obj = new UrlRewrite($recordId);
        if (!$obj->deleteRecord(false)) {
            Message::addErrorMessage($obj->getError());
            FatUtility::dieJsonError(Message::getHtml());
        }
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }

        $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword');
        $langArr = Language::getAllNames();
        $defaultLangId = FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1);
        if (!FatApp::getConfig('CONF_LANG_SPECIFIC_URL', FatUtility::VAR_INT, 0)) {
            $langArr = [$defaultLangId => $langArr[$defaultLangId]];
        }

        if (count($langArr) > 1) {
            $frm->addSelectBox(Labels::getLabel('LBL_Language', $this->adminLangId), 'lang_id', $langArr, FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1), [], Labels::getLabel('LBL_Select', $this->adminLangId));
        } else {
            $lang_id = array_key_first($langArr);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        return $frm;
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmUrlRewrite');
        $frm->addHiddenField('', 'urlrewrite_id');
        $frm->addRequiredField(Labels::getLabel('LBL_Original_URL', $this->adminLangId), 'urlrewrite_original');

        $langArr = Language::getAllNames();
        foreach ($langArr as $langId => $langName) {
            if (!FatApp::getConfig('CONF_LANG_SPECIFIC_URL', FatUtility::VAR_INT, 0) && $langId != FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1)) {
                continue;
            }

            $fieldName = Labels::getLabel('LBL_Custom_URL', $this->adminLangId);
            if (FatApp::getConfig('CONF_LANG_SPECIFIC_URL', FatUtility::VAR_INT, 0)) {
                $fieldName .=  '(' . $langName . ')';
            }
            $frm->addRequiredField($fieldName, 'urlrewrite_custom[' . $langId . ']');
        }
        $fld =  $frm->addHTML('', '', '');
        $fld->htmlAfterField = '<small>' . Labels::getLabel('LBL_Example:_Custom_URL_Example', $this->adminLangId) . '</small>';
        // $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }
    
    private function getFormColumns(): array
    {
        $urlRewritingTblHeadingCols = CacheHelper::get('urlRewritingTblHeadingCols' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($urlRewritingTblHeadingCols) {
            return json_decode($urlRewritingTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->adminLangId),
            'listSerial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'urlrewrite_original' => Labels::getLabel('LBL_Original', $this->adminLangId),
            'language_code' => Labels::getLabel('LBL_Language', $this->adminLangId),
            'urlrewrite_custom' => Labels::getLabel('LBL_Custom', $this->adminLangId),
            'action' => Labels::getLabel('LBL_Action', $this->adminLangId),
        ];
        CacheHelper::create('urlRewritingTblHeadingCols' . $this->adminLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [    
            'select_all',
            'listSerial',
            'urlrewrite_original',
            'language_code',
            'urlrewrite_custom',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
