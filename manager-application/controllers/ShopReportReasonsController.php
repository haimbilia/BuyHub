<?php

class ShopReportReasonsController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewShopReportReasons();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_SHOP_REPORT_REASONS', $this->siteLangId));
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
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_STRING, FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        if (!in_array($pageSize, applicationConstants::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }

        $srch = ShopReportReason::getSearchObject($this->siteLangId);
        $srch->addMultipleFields(array('reportreason.*', 'reportreason_l.reportreason_title', 'reportreason_id as listSerial'));

        if (!empty($post['keyword'])) {
            $cond = $srch->addCondition('reportreason_identifier', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cond->attachCondition('reportreason_title', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $arrListing = $db->fetchAll($rs);

        $this->set("arrListing", $arrListing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditShopReportReasons($this->admin_id, true));
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'shop-report-reasons/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);        
        $frm = $this->getForm();

        if (0 < $recordId) {
            $data = ShopReportReason::getAttributesByLangId($this->getDefaultFormLangId(), $recordId, array('reportreason_id', 'reportreason_title'), true);

            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getDropDownList($this->getDefaultFormLangId()));
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_SHOP_REPORT_REASON_SETUP', $this->siteLangId));
        $this->_template->render(false, false, '_partial/listing/form.php');
    }

    public function setup()
    {
        $this->objPrivilege->canEditShopReportReasons();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = FatUtility::int($post['reportreason_id']);       

        $recordObj = new ShopReportReason($recordId);
        $post['reportreason_identifier'] = $post['reportreason_title'];
        $recordObj->assignValues($post);

        if (!$recordObj->save()) {
            LibHelper::exitWithError($recordObj->getError(), true);
        }

        $this->setLangData($recordObj, [$recordObj::tblFld('title') => $post[$recordObj::tblFld('title')]]);

        $this->_template->render(false, false, 'json-success.php');
    }

    public function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->objPrivilege->canEditShopReportReasons();
        $this->modelObj = (new ReflectionClass('ShopReportReason'))->newInstanceArgs($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('title')];
        $this->set('formTitle', Labels::getLabel('LBL_SHOP_REPORT_REASON_SETUP', $this->siteLangId));
    }

    private function getForm()
    {
        $frm = new Form('frmShopReportReason');
        $frm->addHiddenField('', 'reportreason_id');
        /*$frm->addRequiredField(Labels::getLabel('LBL_Reason_Identifier', $this->siteLangId), 'reportreason_identifier');*/
        $frm->addRequiredField(Labels::getLabel('LBL_Reason_Title', $this->siteLangId), 'reportreason_title');
        $languageArr = Language::getDropDownList();

        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    protected function getLangForm($recordId = 0, $lang_id = 0)
    {
        $frm = new Form('frmShopReportReasonLang');
        $frm->addHiddenField('', 'reportreason_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->siteLangId), 'lang_id', Language::getDropDownList($this->getDefaultFormLangId()), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('LBL_Reason_Title', $this->siteLangId), 'reportreason_title');
        return $frm;
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditShopReportReasons();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);

        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditShopReportReasons();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('reportreason_ids'));

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

    private function markAsDeleted($recordId)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $obj = new ShopReportReason($recordId);
        if (!$obj->deleteRecord(true)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    private function getFormColumns(): array
    {
        $shopReportReasonTblHeadingCols = CacheHelper::get('shopReportReasonTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($shopReportReasonTblHeadingCols) {
            return json_decode($shopReportReasonTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), 
            'reportreason_title' => Labels::getLabel('LBL_Reason_Title', $this->siteLangId),
            'action' =>  Labels::getLabel('LBL_ACTION', $this->siteLangId),
        ];
        CacheHelper::create('shopReportReasonTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'reportreason_identifier',
            'reportreason_title',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
