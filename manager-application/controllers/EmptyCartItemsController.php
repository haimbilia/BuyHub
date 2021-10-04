<?php

class EmptyCartItemsController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewEmptyCartItems();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('canEdit', $this->objPrivilege->canEditZones($this->admin_id, true));
        $this->set("frmSearch", $frmSearch);
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_EMPTY_CART_ITEMS', $this->adminLangId));
        $this->getListingData();

        $this->_template->render();
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

        $srch = EmptyCartItems::getSearchObject($this->adminLangId, false, false);
        $srch->addMultipleFields([
            'eci.*',
            'eci_l.*',
            'eci.emptycartitem_id as listSerial'
        ]);

        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition('emptycartitem_identifier', 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition('eci_l.emptycartitem_title', 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        $page = (empty($page) || $page <= 0) ? 1 : $page;
        $page = FatUtility::int($page);
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
            'listingHtml' => $this->_template->render(false, false, 'empty-cart-items/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);

        if (0 < $recordId) {
            $data = EmptyCartItems::getAttributesById($recordId);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_EMPTY_CART_ITEMS_SETUP', $this->adminLangId));
        $this->_template->render(false, false, '_partial/listing/form.php');
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

        $record = new EmptyCartItems($recordId);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $newTabLangId = 0;
        if ($recordId > 0) {
            $languages = Language::getAllNames();
            foreach ($languages as $langId => $langName) {
                if (!$row = EmptyCartItems::getAttributesByLangId($langId, $recordId)) {
                    $newTabLangId = $langId;
                    break;
                }
            }
        } else {
            $recordId = $record->getMainTableRecordId();
            $newTabLangId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG', FatUtility::VAR_INT, 1);
        }

        $this->set('msg', $this->str_setup_successful);
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

        $langFrm = $this->getLangForm($langId);
        if (0 < $autoFillLangData) {
            $updateLangDataobj = new TranslateLangData(EmptyCartItems::DB_TBL_LANG);
            $translatedData = $updateLangDataobj->getTranslatedData($recordId, $langId);
            if (false === $translatedData) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
            $langData = current($translatedData);
        } else {
            $langData = EmptyCartItems::getAttributesByLangId($langId, $recordId);
        }

        $langData['emptycartitem_id'] = $recordId;
        $langFrm->fill($langData);

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('lang_id', $langId);
        $this->set('langFrm', $langFrm);
        $this->set('formLayout', Language::getLayoutDirection($langId));
        $this->set('formTitle', Labels::getLabel('LBL_STATE_SETUP', $this->adminLangId));
        $this->_template->render(false, false, '_partial/listing/lang-form.php');
    }

    public function langSetup()
    {
        $this->objPrivilege->canEditEmptyCartItems();
        $post = FatApp::getPostedData();

        $recordId = $post['emptycartitem_id'];

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $lang_id = $post['lang_id'];
        } else {
            $lang_id = array_key_first($languages);
            $post['lang_id'] = $lang_id;
        }


        if ($recordId == 0 || $lang_id == 0) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $frm = $this->getLangForm($lang_id);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['emptycartitem_id']);
        unset($post['lang_id']);
        $data = array(
            'emptycartitemlang_emptycartitem_id' => $recordId,
            'emptycartitemlang_lang_id' => $lang_id,
            'emptycartitem_title' => $post['emptycartitem_title']
        );

        $emptyCartItemObj = new EmptyCartItems($recordId);
        if (!$emptyCartItemObj->updateLangData($lang_id, $data)) {
            LibHelper::exitWithError($emptyCartItemObj->getError(), true);
        }

        $autoUpdateOtherLangsData = FatApp::getPostedData('auto_update_other_langs_data', FatUtility::VAR_INT, 0);
        if (0 < $autoUpdateOtherLangsData) {
            $updateLangDataobj = new TranslateLangData(EmptyCartItems::DB_TBL_LANG);
            if (false === $updateLangDataobj->updateTranslatedData($recordId)) {
                LibHelper::exitWithError($updateLangDataobj->getError(), true);
            }
        }

        $newTabLangId = 0;
        $languages = Language::getAllNames();
        foreach ($languages as $langId => $langName) {
            if (!$row = EmptyCartItems::getAttributesByLangId($langId, $recordId)) {
                $newTabLangId = $langId;
                break;
            }
        }

        $this->set('msg', $this->str_setup_successful);
        $this->set('recordId', $recordId);
        $this->set('langId', $newTabLangId);
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
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId), true);
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
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->adminLangId), true);
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

        FatUtility::dieJsonSuccess($this->str_update_record);
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditEmptyCartItems();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('emptycartitem_ids'));
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

        $emptyCartItemObj = new EmptyCartItems($recordId);
        if (!$emptyCartItemObj->changeStatus($status)) {
            LibHelper::exitWithError($emptyCartItemObj->getError(), true);
        }
    }

    private function getForm()
    {
        $frm = new Form('frmEmptyCartItem');
        $frm->addHiddenField('', 'emptycartitem_id');
        $frm->addRequiredField(Labels::getLabel('LBL_Empty_Cart_Item_Identifier', $this->adminLangId), 'emptycartitem_identifier');
        $fld = $frm->addRequiredField(Labels::getLabel('LBL_Empty_Cart_Item_URL', $this->adminLangId), 'emptycartitem_url');
        $fld->htmlAfterField = '<small>' . Labels::getLabel('LBL_Prefix_with_{SITEROOT},_if_needs_to_generate_system\'s_url.', $this->adminLangId) . '</small>';
        $frm->addSelectBox(Labels::getLabel('LBL_Open_Link_in_New_Tab', $this->adminLangId), 'emptycartitem_url_is_newtab', applicationConstants::getYesNoArr($this->adminLangId), applicationConstants::NO, array(), '');
        $frm->addIntegerField(Labels::getLabel('LBL_Display_Order', $this->adminLangId), 'emptycartitem_display_order');
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->adminLangId), 'emptycartitem_active', applicationConstants::getActiveInactiveArr($this->adminLangId), applicationConstants::ACTIVE, array(), '');
        return $frm;
    }

    private function getLangForm($lang_id = 0)
    {
        $frm = new Form('frmEmptyCartItemLang');
        $frm->addHiddenField('', 'emptycartitem_id');

        $languages = Language::getAllNames();
        if (count($languages) > 1) {
            $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->adminLangId), 'lang_id', $languages, $lang_id, array(), '');
        } else {
            $lang_id = array_key_first($languages);
            $frm->addHiddenField('', 'lang_id', $lang_id);
        }

        $frm->addRequiredField(Labels::getLabel('LBL_Empty_Cart_Item_Title', $this->adminLangId), 'emptycartitem_title');

        $siteLangId = FatApp::getConfig('conf_default_site_lang', FatUtility::VAR_INT, 1);
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');

        if (!empty($translatorSubscriptionKey) && $lang_id == $siteLangId) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->adminLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }

        return $frm;
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm);
        }
        $fld = $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->adminLangId), 'keyword');
        $fld->overrideFldType('search');
        
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $frm->addHtml('', 'btn_clear', '<button name="btn_clear" class="btn btn-outline-brand" onclick="clearSearch();">' . Labels::getLabel('LBL_CLEAR', $this->adminLangId) . '</button>');
        return $frm;
    }

    private function getFormColumns(): array
    {
        $emptyCartItemsTblHeadingCols = CacheHelper::get('emptyCartItemsTblHeadingCols' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($emptyCartItemsTblHeadingCols) {
            return json_decode($emptyCartItemsTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->adminLangId),
            'listSerial' => Labels::getLabel('LBL_#', $this->adminLangId),
            'emptycartitem_identifier' => Labels::getLabel('LBL_TITLE', $this->adminLangId),
            'emptycartitem_url' => Labels::getLabel('LBL_URL', $this->adminLangId),
            'emptycartitem_active' => Labels::getLabel('LBL_STATUS', $this->adminLangId),
            'action' => Labels::getLabel('LBL_ACTION', $this->adminLangId),
        ];
        CacheHelper::create('emptyCartItemsTblHeadingCols' . $this->adminLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'emptycartitem_identifier',
            'emptycartitem_url',
            'emptycartitem_active',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['state_active'], Common::excludeKeysForSort());
    }
}
