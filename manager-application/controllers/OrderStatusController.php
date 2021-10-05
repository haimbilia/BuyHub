<?php

class OrderStatusController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewOrderStatus();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_ORDER_STATUS', $this->adminLangId));
        $this->getListingData();

        $this->_template->addJs('js/jquery.tablednd.js');
        $this->_template->render();
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword');
        $fld->overrideFldType('search');

        $orderStatusTypeArr = OrderStatus::getOrderStatusTypeArr($this->adminLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Order_Status_type', $this->adminLangId), 'orderstatus_type', $orderStatusTypeArr, '', array(), '');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $frm->addHtml('', 'btn_clear', '<button name="btn_clear" class="btn btn-outline-brand" onclick="clearSearch();">' . Labels::getLabel('LBL_CLEAR', $this->adminLangId) . '</button>');
        return $frm;
    }

    private function getListingData()
    {
        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_STRING, FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        if (!in_array($pageSize, applicationConstants::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }

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

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_ASC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $searchForm = $this->getSearchForm($fields);
        
        $page = (empty($data['page']) || $data['page'] <= 0) ? 1 : $data['page'];
        $post = $searchForm->getFormDataFromArray($data);

        $srch = OrderStatus::getSearchObject(false, $this->adminLangId);

        $srch->addFld(array('ostatus.*', 'IFNULL(ostatus_l.orderstatus_name,ostatus.orderstatus_identifier) as orderstatus_name', 'ostatus.orderstatus_id as listSerial'));

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

        $page = FatUtility::int($page);
        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->adminLangId));
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
        $this->set('canEdit', $this->objPrivilege->canEditStates($this->admin_id, true));
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

    public function form()
    {
        $this->objPrivilege->canEditOrderStatus();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);

        $frm = $this->getForm($recordId);

        if (0 < $recordId) {
            $data = OrderStatus::getAttributesById($recordId, array('orderstatus_id', 'orderstatus_identifier', 'orderstatus_is_active', 'orderstatus_is_digital', 'orderstatus_color_class'));

            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_ORDER_STATUS_SETUP', $this->adminLangId));
        $this->_template->render(false, false, '_partial/listing/form.php');
    }

    public function setup()
    {
        $this->objPrivilege->canEditOrderStatus();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['orderstatus_id'];
        unset($post['orderstatus_id']);

        $record = new OrderStatus($recordId);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;
        if ($recordId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = OrderStatus::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $recordId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }
        $this->set('msg', Labels::getLabel('LBL_Updated_Successfully', $this->adminLangId));
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function langForm($autoFillLangData = 0)
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $langId = FatApp::getPostedData('langId', FatUtility::VAR_INT, FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1));

        if (1 > $recordId || 1 > $langId) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        
        $langFrm = $this->getLangForm($recordId, $langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(OrderStatus::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = OrderStatus::getAttributesByLangId($langId, $recordId);
        }

        if ($langData) {
            $langFrm->fill($langData);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('formTitle', Labels::getLabel('LBL_ORDER_STATUS_SETUP', $this->adminLangId));
        $this->_template->render(false, false, '_partial/listing/lang-form.php');
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditOrderStatus();
        $post = FatApp::getPostedData();

        $recordId = $post['orderstatus_id'];
        $languages = Language::getAllNames();
	
        if(count($languages) > 1){
			 $lang_id = $post['lang_id'];
		} else  {
			$lang_id = array_key_first($languages); 
			$post['lang_id'] = $lang_id;
		}

      
        if ($recordId == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($recordId, $lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['orderstatus_id']);
        unset($post['lang_id']);

        $data = array(
            'orderstatuslang_lang_id' => $lang_id,
            'orderstatuslang_orderstatus_id' => $recordId,
            'orderstatus_name' => $post['orderstatus_name']
        );

        $orderstatusObj = new OrderStatus($recordId);

        if (!$orderstatusObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($orderstatusObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(OrderStatus::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = OrderStatus::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($recordId = 0)
    {
        $recordId = FatUtility::int($recordId);

        $frm = new Form('frmorderstatus');
        $frm->addHiddenField('', 'orderstatus_id', $recordId);
        $frm->addRequiredField(Labels::getLabel('LBL_Order_Status_Identifier', $this->adminLangId), 'orderstatus_identifier');
        /* $frm->addRequiredField(Labels::getLabel('LBL_ORDER_STATUS_COLOR_CLASS', $this->adminLangId), 'orderstatus_color_class'); */

        /* Please retain actual css class as option text. As that class used in JS to fill color of that option. */
        $classArr = applicationConstants::getClassArr();
        $frm->addSelectBox(Labels::getLabel('LBL_ORDER_STATUS_COLOR_CLASS', $this->adminLangId), 'orderstatus_color_class', $classArr, '', array(), '');

        $orderStatusTypeArr = OrderStatus::getOrderStatusTypeArr($this->adminLangId);

        $frm->addSelectBox(Labels::getLabel('LBL_Order_Status_type', $this->adminLangId), 'orderstatus_type', $orderStatusTypeArr, '', array(), '');

        $yesNoArr = applicationConstants::getYesNoArr($this->adminLangId);

        $frm->addSelectBox(Labels::getLabel('LBL_Order_Status_is_Digital', $this->adminLangId), 'orderstatus_is_digital', $yesNoArr, '', array(), '');

        $activeInactiveArr = applicationConstants::getActiveInactiveArr($this->adminLangId);

        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->adminLangId), 'orderstatus_is_active', $activeInactiveArr, '', array(), '');
        return $frm;
    }

    private function getLangForm($recordId = 0, $lang_id = 0)
    {
        $frm = new Form('frmorderstatuslang');
        $frm->addHiddenField('', 'orderstatus_id', $recordId);

        $languages = Language::getAllNames();
		if(count($languages) > 1){
			 $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->adminLangId), 'lang_id', $languages, $lang_id, array(), '');
		} else  {
			$lang_id = array_key_first($languages); 
			$frm->addHiddenField('', 'lang_id', $lang_id);
		}
        
        $frm->addRequiredField(Labels::getLabel('LBL_orderstatus_Name', $this->adminLangId), 'orderstatus_name');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->adminLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
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
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId), true);
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

    private function changeStatus($recordId, $status)
    {
        $status = FatUtility::int($status);
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId || -1 == $status) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId), true);
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

            $this->set('msg', Labels::getLabel('LBL_Order_Updated_Successfully', $this->adminLangId));
            $this->_template->render(false, false, 'json-success.php');
        }
    }

    private function getFormColumns(): array
    {
        $orderStatusTblHeadingCols = CacheHelper::get('orderStatusTblHeadingCols' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($orderStatusTblHeadingCols) {
            return json_decode($orderStatusTblHeadingCols);
        }

        $arr = [
            'dragdrop' => '',
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->adminLangId),
            'listSerial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'orderstatus_name' => Labels::getLabel('LBL_ORDER_STATUS_NAME', $this->adminLangId),
            'orderstatus_is_active' => Labels::getLabel('LBL_STATUS', $this->adminLangId),
            'action' => Labels::getLabel('LBL_ACTION', $this->adminLangId),
        ];
        CacheHelper::create('orderStatusTblHeadingCols' . $this->adminLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'dragdrop',
            'select_all',
            'listSerial',
            'orderstatus_name',
            'orderstatus_is_active',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['dragdrop', 'orderstatus_is_active'], Common::excludeKeysForSort());
    }
}
