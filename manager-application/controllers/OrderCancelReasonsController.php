<?php

class OrderCancelReasonsController extends ListingBaseController
{
    protected string $modelClass = 'OrderCancelReason';
    protected $pageKey = 'MANAGE_ORDER_CANCEL_REASONS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewOrderCancelReasons();
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->objPrivilege->canEditOrderCancelReasons();
        $this->setModel($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('title')];
        $this->set('formTitle', Labels::getLabel('LBL_ORDER_CANCEL_REASON_SETUP', $this->siteLangId));
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['formAction'] = 'deleteSelected';
        $languages = Language::getAllNames();
        if (1 === count($languages)) {
            $actionItemsData['newRecordBtnAttrs'] = [
                'attr' => [
                    'onclick' => "addNew(true)",
                ]
            ];
        }
        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_REASON_TITLE', $this->siteLangId));
        $this->getListingData();

        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'order-cancel-reasons/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
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

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = OrderCancelReason::getSearchObject($this->siteLangId); 
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $cond = $srch->addCondition('ocreason_identifier', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('ocreason_title', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();
        
        $srch->addMultipleFields(array('ocreason.*', 'ocreason_l.ocreason_title')); 
        $srch->addOrder($sortBy, $sortOrder); 
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize); 
        $this->set("arrListing", $db->fetchAll($srch->getResultSet())); 
        $this->set('postedData', $post); 
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditOrderCancelReasons($this->admin_id, true));
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $frm = $this->getForm();
        $languages = Language::getAllNames();
        if (1 === count($languages)) {
            $frm->setFormTagAttribute('data-onclear', 'editRecord(' . $recordId . ', true)');
        }

        if (0 < $recordId) {
            $data = OrderCancelReason::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $recordId, array('ocreason_id', 'ocreason_identifier', 'IFNULL(ocreason_title,ocreason_identifier) as ocreason_title'), applicationConstants::JOIN_RIGHT);

            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }


        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_ORDER_CANCEL_REASON_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, '_partial/listing/form.php', true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditOrderCancelReasons();
        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['ocreason_id'];
        unset($post['ocreason_id']);

        $post['ocreason_identifier'] = $post['ocreason_title'];
        $recordObj = new OrderCancelReason($recordId);
        $recordObj->assignValues($post);

        if (!$recordObj->save()) {
            $msg = $recordObj->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }

        $this->setLangData($recordObj, [$recordObj::tblFld('title') => $post[$recordObj::tblFld('title')]]);

        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmOrderCancelReason');
        $frm->addHiddenField('', 'ocreason_id', $recordId);
        //$frm->addRequiredField(Labels::getLabel('LBL_Reason_Identifier', $this->siteLangId), 'ocreason_identifier');
        $frm->addRequiredField(Labels::getLabel('FRM_REASON_TITLE', $this->siteLangId), 'ocreason_title');
        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }

    protected function getLangForm($recordId = 0, $langId = 0)
    {
        $langId = 1 > $langId ? $this->siteLangId : $langId;
        $frm = new Form('frmOrderCancelReasonLang');
        $frm->addHiddenField('', 'ocreason_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_REASON_TITLE', $langId), 'ocreason_title');
        // $frm->addTextarea('Reason Description', 'ocreason_description');
        return $frm;
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditOrderCancelReasons();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditOrderCancelReasons();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('ocreason_ids'));

        if (empty($recordIdsArr)) {
            LibHelper::exitWithError($this->str_invalid_request, true);
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

    protected function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $obj = new OrderCancelReason($recordId);
        if (!$obj->deleteRecord(true)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    protected function getFormColumns(): array
    {
        $ordercancelReasonTblHeadingCols = CacheHelper::get('ordercancelReasonTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($ordercancelReasonTblHeadingCols) {
            return json_decode($ordercancelReasonTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
           /*  'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'ocreason_title' => Labels::getLabel('LBL_REASON_TITLE', $this->siteLangId),
            'action' =>  Labels::getLabel('LBL_ACTION', $this->siteLangId),
        ];
        CacheHelper::create('ordercancelReasonTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            /* 'listSerial', */
            'ocreason_identifier',
            'ocreason_title',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
