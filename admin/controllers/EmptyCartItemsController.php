<?php
class EmptyCartItemsController extends ListingBaseController
{
    protected $pageKey = 'EMPTY_CART_ITEMS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewEmptyCartItems();
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->objPrivilege->canEditEmptyCartItems();
        $this->modelObj = (new ReflectionClass('EmptyCartItems'))->newInstanceArgs($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('title')];
        $this->set('formTitle', Labels::getLabel('LBL_EMPTY_CART_ITEMS_SETUP', $this->siteLangId));
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($fields);
        $actionItemsData['statusButtons'] = true;
        $actionItemsData['deleteButton'] = true;
        $actionItemsData['performBulkAction'] = true;

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('actionItemsData', $actionItemsData);
        $this->set("frmSearch", $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('keywordPlaceholder', Labels::getLabel('FRM_SEARCH_BY_TITLE', $this->siteLangId));
        $this->getListingData();

        $this->_template->render(true, true, '_partial/listing/index.php');
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'empty-cart-items/search.php', true),
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
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current($allowedKeysForSorting));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current($allowedKeysForSorting);
        }

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $searchForm = $this->getSearchForm($fields);

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $post = $searchForm->getFormDataFromArray(FatApp::getPostedData());

        $srch = EmptyCartItems::getSearchObject($this->siteLangId, false, false);
       
        if (isset($post['keyword']) && '' != $post['keyword']) {
            $condition = $srch->addCondition('emptycartitem_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('eci_l.emptycartitem_title', 'like', '%' . $post['keyword'] . '%', 'OR');
        }
        $this->setRecordCount(clone $srch, $pageSize, $page, $post);
        $srch->doNotCalculateRecords();  
        $srch->addMultipleFields([
            'eci.*',
            'eci_l.*'
        ]); 
        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->addOrder($sortBy, $sortOrder); 
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);

        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->siteLangId));
        $this->set("arrListing", $records); 
        $this->set('postedData', $post); 
        $this->set('frmSearch', $searchForm);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('canEdit', $this->objPrivilege->canEditEmptyCartItems($this->admin_id, true));
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);
        if (0 < $recordId) {
            $data = EmptyCartItems::getAttributesByLangId(CommonHelper::getDefaultFormLangId(), $recordId, ['*','IFNULL(emptycartitem_title,emptycartitem_identifier) as emptycartitem_title'], applicationConstants::JOIN_RIGHT);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }
        
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_EMPTY_CART_ITEMS_SETUP', $this->siteLangId));
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditEmptyCartItems();

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['emptycartitem_id'];
        unset($post['emptycartitem_id']);

        $post['emptycartitem_identifier'] = $post['emptycartitem_title'];

        $recordObj = new EmptyCartItems($recordId);
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

    public function deleteRecord()
    {
        $this->objPrivilege->canEditEmptyCartItems();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);
        FatUtility::dieJsonSuccess($this->str_delete_record);
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditEmptyCartItems();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('emptycartitem_ids'));

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
        $obj = new EmptyCartItems($recordId);
        if (!$obj->canRecordMarkDelete($recordId)) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        if (!$obj->deleteRecord(true)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditEmptyCartItems();
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 >= $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (!in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $this->changeStatus($recordId, $status);

        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_STATUS_UPDATED', $this->siteLangId));
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditEmptyCartItems();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('emptycartitem_ids'));
        if (empty($recordIdsArr) || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }

            $this->changeStatus($recordId, $status);
        }
        $this->set('msg', Labels::getLabel('MSG_STATUS_UPDATED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    protected function changeStatus($recordId, $status)
    {
        $status = FatUtility::int($status);
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $emptyCartItemObj = new EmptyCartItems($recordId);
        if (!$emptyCartItemObj->changeStatus($status)) {
            LibHelper::exitWithError($emptyCartItemObj->getError(), true);
        }
    }

    private function getForm()
    {
        $frm = new Form('frmEmptyCartItem');
        $frm->addHiddenField('', 'emptycartitem_id');
        //$frm->addRequiredField(Labels::getLabel('LBL_Empty_Cart_Item_Identifier', $this->siteLangId), 'emptycartitem_identifier');
        $frm->addRequiredField(Labels::getLabel('FRM_EMPTY_CART_ITEM_TITLE', $this->siteLangId), 'emptycartitem_title');
        $fld = $frm->addRequiredField(Labels::getLabel('FRM_EMPTY_CART_ITEM_URL', $this->siteLangId), 'emptycartitem_url');
        $fld->htmlAfterField = '<small>' . Labels::getLabel('FRM_PREFIX_WITH_{SITEROOT},_if_needs_to_generate_system\'s_url.', $this->siteLangId) . '</small>';
        $frm->addSelectBox(Labels::getLabel('FRM_OPEN_LINK_IN_NEW_TAB', $this->siteLangId), 'emptycartitem_url_is_newtab', applicationConstants::getYesNoArr($this->siteLangId), applicationConstants::NO, array(), '');
        $frm->addIntegerField(Labels::getLabel('FRM_DISPLAY_ORDER', $this->siteLangId), 'emptycartitem_display_order');
        $fld = $frm->addCheckBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'emptycartitem_active', applicationConstants::ACTIVE, [], true, applicationConstants::INACTIVE);        
        $languageArr = Language::getDropDownList();

        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('FRM_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    protected function getLangForm($recordId, $langId)
    {
        $frm = new Form('frmEmptyCartItemLang');
        $frm->addHiddenField('', 'emptycartitem_id', $recordId);
        $frm->addSelectBox(Labels::getLabel('FRM_LANGUAGE', $langId), 'lang_id', Language::getDropDownList(CommonHelper::getDefaultFormLangId()), $langId, array(), '');
        $frm->addRequiredField(Labels::getLabel('FRM_EMPTY_CART_ITEM_TITLE', $langId), 'emptycartitem_title');
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $emptyCartItemsTblHeadingCols = CacheHelper::get('emptyCartItemsTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($emptyCartItemsTblHeadingCols) {
            return json_decode($emptyCartItemsTblHeadingCols, true);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
           /*  'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId), */
            'emptycartitem_identifier' => Labels::getLabel('LBL_TITLE', $this->siteLangId),
            'emptycartitem_url' => Labels::getLabel('LBL_URL', $this->siteLangId),
            'emptycartitem_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];
        CacheHelper::create('emptyCartItemsTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
           /*  'listSerial', */
            'emptycartitem_identifier',
            'emptycartitem_url',
            'emptycartitem_active',
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
                    ['title' => Labels::getLabel('LBL_SETTINGS', $this->siteLangId), 'href' => UrlHelper::generateUrl('Settings')],
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
