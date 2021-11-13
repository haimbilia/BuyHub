<?php

class RewardsOnPurchaseController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewRewardsOnPurchase();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $pageData = PageLanguageData::getAttributesByKey('MANAGE_REWARDS_ON_PURCHASE', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('languages', Language::getAllNames());
        $this->getListingData();

        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'rewards-on-purchase/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData()
    {
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

        $srch = RewardsOnPurchase::getSearchObject();
        $srch->addMultipleFields(['rop.*']);
        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        if (!empty($post['keyword'])) {
            $srch->addCondition('rop.rop_purchase_upto', 'like', '%' . $post['keyword'] . '%');
        }
        
        if (!empty($post['rop_reward_point'])) {
            $srch->addCondition('rop.rop_reward_point', 'like', '%' . $post['rop_reward_point'] . '%');
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
        $this->set('canEdit', $this->objPrivilege->canEditRewardsOnPurchase($this->admin_id, true));
        $this->set('languages', Language::getDropDownList($this->getDefaultFormLangId()));
    }

    public function form()
    {
        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm();

        if (0 < $recordId) {
            $data = RewardsOnPurchase::getAttributesById($recordId);
            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }

        $this->set('languages', Language::getAllNames());
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('includeTabs', false);
        $this->set('formTitle', Labels::getLabel('LBL_REWARDS_ON_PURCHASE_SETUP', $this->siteLangId));
        $this->_template->render(false, false, '_partial/listing/form.php');
    }

    public function setup()
    {
        $this->objPrivilege->canEditRewardsOnPurchase();

        $post = FatApp::getPostedData();

        $recordId = 0;
        if (isset($post['rop_id'])) {
            $recordId = FatUtility::int($post['rop_id']);
        }

        $frm = $this->getForm();
        $post = $frm->getFormDataFromArray($post);

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $recordId = $post['rop_id'];
        unset($post['rop_id']);

        $record = new RewardsOnPurchase($recordId);
        $record->assignValues($post);

        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteRecord()
    {
        $this->objPrivilege->canEditRewardsOnPurchase();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if ($recordId < 1) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $this->markAsDeleted($recordId);

        $this->set('msg', $this->str_delete_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function deleteSelected()
    {
        $this->objPrivilege->canEditRewardsOnPurchase();
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('rop_ids'));

        if (empty($recordIdsArr)) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
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

    private function markAsDeleted($ropId)
    {
        $ropId = FatUtility::int($ropId);
        if (1 > $ropId) {
            LibHelper::exitWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId), true);
        }
        $obj = new RewardsOnPurchase($ropId);

        $data = RewardsOnPurchase::getAttributesById($ropId, array('rop_id'));
        if ($data == false) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        if (!$obj->deleteRecord(false)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'rop_purchase_upto');
        }
        
        $fld = $frm->addTextBox(Labels::getLabel('FRM_PURCHASE_AMOUNT', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');
        
        $frm->addTextBox(Labels::getLabel('FRM_REWARD_POINTS', $this->siteLangId), 'rop_reward_point');

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    private function getForm($recordId = 0)
    {
        $frm = new Form('frmRewardsOnPurchase');
        $frm->addHiddenField('', 'rop_id', $recordId);
        $fld = $frm->addFloatField(Labels::getLabel('FRM_PURCHASE_UPTO', $this->siteLangId), 'rop_purchase_upto');
        $fld->requirements()->setFloatPositive();
        $fld = $frm->addFloatField(Labels::getLabel('FRM_REWARD_POINT', $this->siteLangId), 'rop_reward_point');
        $fld->requirements()->setFloatPositive();
        return $frm;
    }

    protected function getFormColumns(): array
    {
        $rewardsOnPurchaseTblHeadingCols = CacheHelper::get('rewardsOnPurchaseTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($rewardsOnPurchaseTblHeadingCols) {
            return json_decode($rewardsOnPurchaseTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'rop_purchase_upto' => Labels::getLabel('LBL_PURCHAHSE', $this->siteLangId),
            'rop_reward_point' => Labels::getLabel('LBL_REWARD_POINT', $this->siteLangId),            
            'action' => Labels::getLabel('LBL_ACTION_BUTTONS', $this->siteLangId),
        ];

        if(count(Language::getAllNames()) < 2 ){
            unset($arr['language_name']);
        }

        CacheHelper::create('rewardsOnPurchaseTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return [    
            'select_all',
            'listSerial',
            'rop_purchase_upto',
            'rop_reward_point',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, Common::excludeKeysForSort());
    }
}
