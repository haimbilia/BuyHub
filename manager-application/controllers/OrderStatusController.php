<?php

class OrderStatusController extends ListingBaseController
{
    protected string $modelClass = 'OrderStatus';
    protected $pageKey = 'MANAGE_ORDER_STATUS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewOrderStatus();
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->objPrivilege->canEditOrderStatus();
        $this->setModel($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->set('formTitle', Labels::getLabel('LBL_ORDER_STATUS_SETUP', $this->siteLangId));
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['newRecordBtnAttrs'] = [
            'attr' => [
                'onclick' => 'editRecord(0)'
            ],
        ];
        $actionItemsData['performBulkAction'] = true;
        $actionItemsData['statusButtons'] = true;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_NAME', $this->siteLangId));
        $this->getListingData();

        $this->_template->addJs(['js/jquery.tablednd.js', 'order-status/page-js/index.js']);

        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'orderstatus_name');
        }
        $fld = $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        $orderStatusTypeArr = OrderStatus::getOrderStatusTypeArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('FRM_ORDER_STATUS_TYPE', $this->siteLangId), 'orderstatus_type', $orderStatusTypeArr, '', array(), '');

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'order-status/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();

        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $allowedKeysForSorting = $this->excludeKeysForSort(array_keys($fields));
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'orderstatus_priority');
        if (!array_key_exists($sortBy, $fields) && 'orderstatus_priority' != $sortBy) {
            $sortBy = 'orderstatus_priority';
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $searchForm = $this->getSearchForm($fields);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $postedData = FatApp::getPostedData();
        $post = $searchForm->getFormDataFromArray($postedData);

        $srch = OrderStatus::getSearchObject(false, $this->siteLangId);

        $srch->addFld(array('ostatus.*', 'IFNULL(ostatus_l.orderstatus_name,ostatus.orderstatus_identifier) as orderstatus_name'));

        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('ostatus.orderstatus_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('ostatus_l.orderstatus_name', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $orderstatus_type = FatApp::getPostedData('orderstatus_type', FatUtility::VAR_INT, -1);
        if ($orderstatus_type > 0) {
            $srch->addCondition('ostatus.orderstatus_type', '=', $orderstatus_type);
        } else {
            $srch->addCondition('ostatus.orderstatus_type', '=', Orders::ORDER_PRODUCT);
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        //CommonHelper::printArray($records,1);

        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->siteLangId));
        $this->set("arrListing", $records);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);

        $paginationArr = empty($postedData) ? $post : $postedData;
        $this->set('postedData', $paginationArr);

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditOrderStatus($this->admin_id, true));
    }

    public function form()
    {
        $this->objPrivilege->canEditOrderStatus();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $frm = $this->getForm($recordId);

        if (0 < $recordId) {
            $data = OrderStatus::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $recordId, array('orderstatus_id', 'IFNULL(orderstatus_name,orderstatus_identifier) as orderstatus_name', 'orderstatus_is_active', 'orderstatus_is_digital', 'orderstatus_color_class', 'orderstatus_type'), true);

            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }


        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_ORDER_STATUS_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditOrderStatus();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = FatUtility::int($post['orderstatus_id']);

        $recordObj = new OrderStatus($recordId);
        $post['orderstatus_identifier'] = $post['orderstatus_name'];
        $recordObj->assignValues($post);

        if (!$recordObj->save()) {
            $msg = $recordObj->getError();
            if (false !== strpos(strtolower($msg), 'duplicate')) {
                $msg = Labels::getLabel('ERR_DUPLICATE_RECORD_NAME', $this->siteLangId);
            }
            LibHelper::exitWithError($msg, true);
        }

        $this->setLangData($recordObj, [$recordObj::tblFld('name') => $post[$recordObj::tblFld('name')]]);

        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmorderstatus');
        $frm->addHiddenField('', 'orderstatus_id', $recordId);
        /*$frm->addRequiredField(Labels::getLabel('LBL_Order_Status_Identifier', $this->siteLangId), 'orderstatus_identifier');*/
        $frm->addRequiredField(Labels::getLabel('FRM_ORDER_STATUS_NAME', $this->siteLangId), 'orderstatus_name');
        /* $frm->addRequiredField(Labels::getLabel('FRM_ORDER_STATUS_COLOR_CLASS', $this->siteLangId), 'orderstatus_color_class'); */

        /* Please retain actual css class as option text. As that class used in JS to fill color of that option. */
        $classArr = applicationConstants::getClassArr();
        $frm->addSelectBox(Labels::getLabel('FRM_ORDER_STATUS_TEXT_COLOR', $this->siteLangId), 'orderstatus_color_class', $classArr, '', array(), '');

        $orderStatusTypeArr = OrderStatus::getOrderStatusTypeArr($this->siteLangId);

        $frm->addSelectBox(Labels::getLabel('FRM_ORDER_STATUS_TYPE', $this->siteLangId), 'orderstatus_type', $orderStatusTypeArr, '', array(), '');

        $frm->addCheckBox(Labels::getLabel('FRM_FOR_DIGITAL_ORDERS', $this->siteLangId), 'orderstatus_is_digital', applicationConstants::YES, [], false, applicationConstants::NO);

        $frm->addCheckBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'orderstatus_is_active', applicationConstants::ACTIVE, [], true, applicationConstants::INACTIVE);

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
        $frm = new Form('frmorderstatuslang');
        $frm->addHiddenField('', 'orderstatus_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_ORDER_STATUS_NAME', $langId), 'orderstatus_name');
        return $frm;
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditOrderStatus();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 >= $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (!in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $this->changeStatus($recordId, $status);

        FatUtility::dieJsonSuccess($this->str_update_record);
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditOrderStatus();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('orderstatus_ids'));
        if (empty($recordIdsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }

            $this->changeStatus($recordId, $status);
        }
        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function changeStatus($recordId, $status)
    {
        $status = FatUtility::int($status);
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $orderstatusObj = new OrderStatus($recordId);
        $data['orderstatus_is_active'] = $status;
        $orderstatusObj->assignValues($data);
        if (!$orderstatusObj->save()) {
            LibHelper::exitWithError($orderstatusObj->getError(), true);
        }
    }

    public function setOrderStatusesOrder()
    {
        $this->objPrivilege->canEditOrderStatus();
        $post = FatApp::getPostedData();
        if (!empty($post)) {
            $obj = new OrderStatus();
            if (!$obj->updateOrder($post['orderStatuses'])) {
                LibHelper::exitWithError($obj->getError(), true);
            }

            $this->set('msg', Labels::getLabel('LBL_Order_Updated_Successfully', $this->siteLangId));
            $this->_template->render(false, false, 'json-success.php');
        }
    }

    protected function getFormColumns(): array
    {
        $orderStatusTblHeadingCols = CacheHelper::get('orderStatusTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($orderStatusTblHeadingCols) {
            return json_decode($orderStatusTblHeadingCols, true);
        }

        $arr = [
            'dragdrop' => '',
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'orderstatus_name' => Labels::getLabel('LBL_ORDER_STATUS_NAME', $this->siteLangId),
            'orderstatus_priority' => Labels::getLabel('LBL_ORDER_STATUS_PRIORITY', $this->siteLangId),
            'orderstatus_is_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('orderStatusTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'dragdrop',
            'select_all',
            'listSerial',
            'orderstatus_name',
            'orderstatus_priority',
            'orderstatus_is_active',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['dragdrop'], Common::excludeKeysForSort());
    }
}
