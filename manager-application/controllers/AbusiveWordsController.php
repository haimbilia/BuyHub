<?php

class AbusiveWordsController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewAbusiveWords();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_ABUSIVE_WORDS', $this->adminLangId));
        $this->getListingData();

        $this->_template->render();
    }

    private function getListingData()
    {
        $db = FatApp::getDb();
        $post = FatApp::getPostedData();

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

        $srch = Abusive::getSearchObject();
        $srch->addMultipleFields(['aw.*', 'tl.*', 'abusive_id as listSerial']);
        $srch->joinTable('tbl_languages', 'inner join', 'abusive_lang_id = language_id and language_active = ' . applicationConstants::ACTIVE, 'tl');
        
        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        if (!empty($post['keyword'])) {
            $srch->addCondition('aw.abusive_keyword', 'like', '%' . $post['keyword'] . '%');
        }

        if ($post['lang_id'] > 0) {
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
        $this->set('canEdit', $this->objPrivilege->canEditCountries($this->admin_id, true));
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
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditAbusiveWords();
        $data = FatApp::getPostedData();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray($data);

        $languages = Language::getAllNames();
		if(count($languages) > 1){
			 $lang_id = $post['abusive_lang_id'];
		} else  {
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

        $this->set('msg', Labels::getLabel('LBL_UPDATED_SUCCESSFULLY', $this->adminLangId));
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
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId), true);
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

    private function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId), true);
        }
        $obj = new Abusive($recordId);
        if (!$obj->deleteRecord(false)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmWordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }
        $frm->addTextBox('Keyword', 'keyword', '');
        $languages = Language::getAllNames();
        $frm->addSelectBox(Labels::getLabel('LBL_Language', $this->adminLangId), 'lang_id', array(0 => Labels::getLabel('LBL_Does_not_Matter', $this->adminLangId)) + $languages, '', array(), Labels::getLabel('LBL_Select', $this->adminLangId));
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SEARCH', $this->adminLangId));
        $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId));
        return $frm;
    }

    private function getForm($recordId = 0)
    {
        $frm = new Form('frmAbusiveWord');
        $frm->addHiddenField('', 'abusive_id', $recordId);
        $languages = Language::getAllNames();
		if(count($languages) > 1){
			 $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->adminLangId), 'abusive_lang_id', $languages, '', array(), Labels::getLabel('LBL_Select', $this->adminLangId));
		} else  {
			$lang_id = array_key_first($languages); 
			$frm->addHiddenField('', 'abusive_lang_id', $lang_id);
		}
        
        $frm->addTextbox('Keyword', 'abusive_keyword');
        // $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $this->adminLangId));
        return $frm;
    }

    private function getFormColumns(): array
    {
        $abusiveWordsTblHeadingCols = CacheHelper::get('abusiveWordsTblHeadingCols' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($abusiveWordsTblHeadingCols) {
            return json_decode($abusiveWordsTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->adminLangId),
            'listSerial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'abusive_keyword' => Labels::getLabel('LBL_Keyword', $this->adminLangId),
            'language_name' => Labels::getLabel('LBL_Language', $this->adminLangId),
            'action' => Labels::getLabel('LBL_Action', $this->adminLangId),
        ];
        CacheHelper::create('abusiveWordsTblHeadingCols' . $this->adminLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [    
            'select_all',
            'listSerial',
            'abusive_keyword',
            'language_name',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
