<?php

class SellerPackagePlansController extends AdminBaseController
{   

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSellerPackages();
    }

    public function index()
    {
        Message::addErrorMessage(Labels::getLabel('MSG_PLEASE_SELECT_SELLER_PACKAGE_FIRST', $this->siteLangId));
        FatApp::redirectUser(UrlHelper::generateUrl('SellerPackages'));
    }

    public function list(int $spackageId)
    {
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_SUBSCRIPTION_PACKAGE_PLANS', $this->siteLangId));
        $packageData =  SellerPackages::getAttributesByLangId($this->siteLangId, $spackageId, ['spackage_name', 'spackage_identifier'], true);
        $this->set('packageName', $packageData['spackage_name']  ??  $packageData['spackage_identifier']);
        $this->getListingData($spackageId);
        $this->_template->render();
    }

    // public function search()
    // {
    //     $this->getListingData();
    //     $jsonData = [
    //         'listingHtml' => $this->_template->render(false, false, 'seller-packages/search.php', true),
    //         'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
    //     ];
    //     LibHelper::exitWithSuccess($jsonData, true);
    // }

    private function getListingData(int $spackageId)
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

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));

        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = SellerPackagePlans::getSearchObject($this->siteLangId);
        $srch->addMultipleFields(array("spp.*", SellerPackagePlans::DB_TBL_PREFIX . 'id as listSerial'));
        $srch->addCondition(SellerPackagePlans::DB_TBL_PREFIX . 'spackage_id','=',$spackageId);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->removeFld(['select_all', 'action']);       
        $arrListing = $db->fetchAll($srch->getResultSet());

        $this->set("arrListing", $arrListing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        $this->set('activeInactiveArr', applicationConstants::getActiveInactiveArr($this->siteLangId));

        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', $allowedKeysForSorting);
        $this->set('spackageId', $spackageId);
        $this->set('canEdit', $this->objPrivilege->canEditSellerPackages($this->admin_id, true));
    }

    public function form( int $spackageId = 0, int $spPlanId = 0)
    {
        $this->objPrivilege->canEditSellerPackages();      
        $spdata = SellerPackages::getAttributesById($spackageId);

        if ($spackageId < 1) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $frm = $this->getForm($spackageId);
        if (0 < $spPlanId) {        
            $data = SellerPackagePlans::getAttributesById($spPlanId);

            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
        } else {
            $data[SellerPackagePlans::DB_TBL_PREFIX . 'spackage_id'] = $spackageId;
        }
        $frm->fill($data);
        $this->set('languages', Language::getAllNames());
        $this->set('spackageId', $spackageId);
        $this->set('spackageType', $spdata['spackage_type']);
        $this->set('spPlanId', $spPlanId);
        $this->set('frm', $frm);
        $this->set('includeTabs', false);        
        $this->_template->render(false, false);
    }

    private function getForm($spackageId)
    {  
        $frm = new Form('frmSellerPackagePlan', array('id' => 'frmSellerPackagePlan'));
        $frm->addHiddenField('', SellerPackagePlans::tblFld('id'));
        $frm->addHiddenField('', SellerPackagePlans::tblFld('spackage_id'));           

        $subsPeriodOption = SellerPackagePlans::getSubscriptionPeriods($this->siteLangId);
        $fldFreq = $frm->addSelectBox(Labels::getLabel('LBL_PERIOD', $this->siteLangId), SellerPackagePlans::DB_TBL_PREFIX . 'frequency', $subsPeriodOption, '', array(), '');
        $fldFreqText = $frm->addHTML('', SellerPackagePlans::tblFld('frequency_text'), '');
        $fldFreq->attachField($fldFreqText);
        $fld = $frm->addIntegerField(Labels::getLabel('LBL_Time_Interval_(FREQUENCY)', $this->siteLangId), SellerPackagePlans::DB_TBL_PREFIX . 'interval');
        $fld->requirements()->setIntPositive();

        if (SellerPackages::getAttributesById($spackageId,SellerPackages::tblFld('type'))  != SellerPackages::FREE_TYPE) {
            $frm->addFloatField(Labels::getLabel('LBL_Price', $this->siteLangId), SellerPackagePlans::DB_TBL_PREFIX . 'price')->requirements()->setRange('0.01', '9999999999');
            $fldPckPrice = $frm->getField(SellerPackagePlans::DB_TBL_PREFIX . 'price');
            $fldPckPrice->setWrapperAttribute('class', 'package_price');
        }

        $fld = $frm->addIntegerField(Labels::getLabel('LBL_Plan_Display_Order', $this->siteLangId), SellerPackagePlans::DB_TBL_PREFIX . 'display_order');
        $fld->requirements()->setIntPositive();

        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), SellerPackagePlans::DB_TBL_PREFIX . 'active', applicationConstants::getActiveInactiveArr($this->siteLangId), '', array(), '');

        return $frm;
    }

    public function setup()
    {
        $this->objPrivilege->canEditSellerPackages();
        $post = FatApp::getPostedData();
        $spackageId = FatApp::getPostedData('spplan_spackage_id', FatUtility::VAR_INT,0);
        $frm = $this->getForm($spackageId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        $spPlanId = $post[SellerPackagePlans::DB_TBL_PREFIX . 'id'];
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $packageRow = SellerPackages::getAttributesById($spackageId);
        $data = $post;

        if ($packageRow[SellerPackages::DB_TBL_PREFIX . 'type'] == SellerPackages::FREE_TYPE) {
            $data[SellerPackagePlans::DB_TBL_PREFIX . 'trial_frequency'] = '';
            $data[SellerPackagePlans::DB_TBL_PREFIX . 'trial_interval'] = 0;
            $data[SellerPackagePlans::DB_TBL_PREFIX . 'price'] = 0;
        }

        $record = new SellerPackagePlans($spPlanId);
        $record->assignValues($data);
        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }
        $this->set('msg', $this->str_setup_successful);
        $this->set('spackageId', $spackageId);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function updateStatus()
    {
        $this->objPrivilege->canEditSellerPackages();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        if (0 >= $recordId) {
            LibHelper::exitWithError($this->str_invalid_request_id, true);
        }

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (!in_array($status, [applicationConstants::ACTIVE, applicationConstants::INACTIVE])) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $this->changeStatus($recordId, $status);

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function toggleBulkStatuses()
    {
        $this->objPrivilege->canEditSellerPackages();

        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, -1);
        $recordIdsArr = FatUtility::int(FatApp::getPostedData('spackage_ids'));
        if (empty($recordIdsArr) || -1 == $status) {
            FatUtility::dieWithError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
        }

        foreach ($recordIdsArr as $recordId) {
            if (1 > $recordId) {
                continue;
            }

            $this->changeStatus($recordId, $status);
        }

        LibHelper::dieJsonSuccess(['msg' => $this->str_update_record]);
    }

    private function changeStatus(int $recordId, int $status)
    {
        if (1 > $recordId || -1 == $status) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }


        $obj = new SellerPackages($recordId);
        if (!$obj->changeStatus($status)) {
            LibHelper::exitWithError($obj->getError(), true);
        }
    }

    private function getFormColumns(): array
    {
        $subsPkgTblHeadingCols = CacheHelper::get('subsPkgPlanTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($subsPkgTblHeadingCols) {
            return json_decode($subsPkgTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_SELECT_ALL', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'spplan_price' => Labels::getLabel('LBL_PLAN_PRICE', $this->siteLangId),
            'spplan_active' => Labels::getLabel('LBL_STATUS', $this->siteLangId),
            'action' => '',
        ];
        CacheHelper::create('subsPkgPlanTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'spplan_price',
            'spplan_active',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['spplan_active'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'list':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_CONFIGURATION_&_MANAGEMENT', $this->siteLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => Labels::getLabel('LBL_SUBSCRIPTION_PACKAGES', $this->siteLangId), 'href' => UrlHelper::generateUrl('SellerPackages')],
                    ['title' => Labels::getLabel('LBL_SUBSCRIPTION_PACKAGE_PLANS', $this->siteLangId)]
                ];
        }
        return $this->nodes;
    }
}
