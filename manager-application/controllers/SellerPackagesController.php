<?php

class SellerPackagesController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSellerPackages();
    }

    /**
     * setLangTemplateData - This function is use to automate load langform and save it. 
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setLangTemplateData(array $constructorArgs = []): void
    {
        $this->objPrivilege->canEditSellerPackages();
        $this->modelObj = (new ReflectionClass('SellerPackages'))->newInstanceArgs($constructorArgs);
        $this->formLangFields = [$this->modelObj::tblFld('name')];
        $this->set('formTitle', Labels::getLabel('LBL_SUBSCRIPTION_PACKAGES_SETUP', $this->siteLangId));
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);

        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_SUBSCRIPTION_PACKAGES', $this->siteLangId));
        $this->getListingData();
        $this->_template->render();
    }

    public function search()
    {
        $this->getListingData();
        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'seller-packages/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
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

        $srch = SellerPackages::getSearchObject($this->siteLangId);
        $srch->addMultipleFields(array("sp.*", "IFNULL( spl." . SellerPackages::DB_TBL_PREFIX . "name, sp." . SellerPackages::DB_TBL_PREFIX . "identifier ) as " . SellerPackages::DB_TBL_PREFIX . "name", 
        SellerPackages::DB_TBL_PREFIX . 'id as listSerial'));

        if (!empty($post['keyword'])) {
            $condition = $srch->addCondition("sp." . SellerPackages::DB_TBL_PREFIX . "identifier", 'like', '%' . $post['keyword'] . '%');
            $condition->attachCondition("spl." . SellerPackages::DB_TBL_PREFIX . "name", 'like', '%' . $post['keyword'] . '%', 'OR');
        }

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->removeFld(['select_all', 'action']);
        $rs = $srch->getResultSet();
        $arrListing = $db->fetchAll($rs);

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
        $this->set('canEdit', $this->objPrivilege->canEditSellerPackages($this->admin_id, true));
    }

    public function form()
    {
        $this->objPrivilege->canEditSellerPackages();

        $recordId = FatApp::getPostedData('recordId', FatUtility::VAR_INT, 0);
        $frm = $this->getForm($recordId);
        if (0 < $recordId) {  
            $data = SellerPackages::getAttributesByLangId($this->getDefaultFormLangId(), $recordId, null, true);  

            if ($data === false) {
                LibHelper::exitWithError($this->str_invalid_request, true);
            }
            $frm->fill($data);
        }
        $this->set('languages', Language::getDropDownList($this->getDefaultFormLangId()));
        $this->set('recordId', $recordId);
        $this->set('frm', $frm);
        $this->set('formTitle', Labels::getLabel('LBL_SUBSCRIPTION_PACKAGES_SETUP', $this->siteLangId));
        $this->_template->render(false, false);
    }

    public function setup()
    {
        $this->objPrivilege->canEditSellerPackages();
     
        $recordId = FatApp::getPostedData('spackage_id', FatUtility::VAR_INT, 0);
        
        $frm = $this->getForm($recordId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }
      
        $recordObj = new SellerPackages($recordId);
        $post['spackage_identifier'] = $post['spackage_name'];
        $recordObj->assignValues($post);
        if (!$recordObj->save()) {
            LibHelper::exitWithError($recordObj->getError(), true);
        }

        $this->setLangData($recordObj, [$recordObj::tblFld('name') => $post[$recordObj::tblFld('name')]]);
      
        $this->_template->render(false, false, 'json-success.php');
    }

    private function getForm($recordId)
    {
        $recordId = FatUtility::int($recordId);
        $arr_package_options = SellerPackages::getPackageTypes();
        $frm = new Form('frmSellerPackage');
        $frm->addHiddenField('', 'spackage_id');
        $frm->addRequiredField(Labels::getLabel('LBL_Package_Name', $this->siteLangId), SellerPackages::DB_TBL_PREFIX . 'name');
        /*$frm->addRequiredField(Labels::getLabel('LBL_Package_Identifier', $this->siteLangId), SellerPackages::DB_TBL_PREFIX . 'identifier');*/
        $disbaleText = array();
        if ($recordId > 0) {
            $disbaleText = array('disabled' => 'disabled');
        }
        $packageTypeFld = $frm->addSelectBox(Labels::getLabel('LBL_Package_Type', $this->siteLangId), SellerPackages::DB_TBL_PREFIX . 'type', $arr_package_options, '', $disbaleText, '');
        if (0 == $recordId) {
            $packageTypeFld->requirements()->setRequired();
        }
        $commissionRate = $frm->addFloatField(Labels::getLabel('LBL_Package_Commision_Rate_in_Percentage', $this->siteLangId), SellerPackages::DB_TBL_PREFIX . 'commission_rate');
        $commissionRate->requirements()->setRange(0, 100);

        $fld = $frm->addIntegerField(Labels::getLabel('LBL_Package_Products_Allowed', $this->siteLangId), SellerPackages::DB_TBL_PREFIX . 'products_allowed');
        $fld->requirements()->setIntPositive();

        $fld = $frm->addIntegerField(Labels::getLabel('LBL_Package_Inventory_Allowed', $this->siteLangId), SellerPackages::DB_TBL_PREFIX . 'inventory_allowed');
        $fld->requirements()->setIntPositive();

        $fld = $frm->addIntegerField(Labels::getLabel('LBL_Package_Images_Per_Catalog', $this->siteLangId), SellerPackages::DB_TBL_PREFIX . 'images_per_product');
        $fld->requirements()->setIntPositive();

        $frm->addSelectBox(Labels::getLabel('LBL_Package_Status', $this->siteLangId), SellerPackages::DB_TBL_PREFIX . 'active', applicationConstants::getActiveInactiveArr($this->siteLangId), applicationConstants::ACTIVE, array(), '');

        $fld = $frm->addRequiredField(Labels::getLabel('LBL_Package_Display_Order', $this->siteLangId), SellerPackages::DB_TBL_PREFIX . 'display_order');
        $fld->requirements()->setIntPositive();    
        
        $languageArr = Language::getDropDownList();
        $translatorSubscriptionKey = FatApp::getConfig('CONF_TRANSLATOR_SUBSCRIPTION_KEY', FatUtility::VAR_STRING, '');
        if (!empty($translatorSubscriptionKey) && 1 < count($languageArr)) {
            $frm->addCheckBox(Labels::getLabel('LBL_UPDATE_OTHER_LANGUAGES_DATA', $this->siteLangId), 'auto_update_other_langs_data', 1, array(), false, 0);
        }
        return $frm;
    }    

    protected function getLangForm($recordId = 0, $lang_id = 0)
    {
        $this->objPrivilege->canEditSellerPackages();
        $frm = new Form('frmSellerPackageLang');
        $frm->addHiddenField('', SellerPackages::DB_TBL_PREFIX . 'id', $recordId);
        $frm->addSelectBox(Labels::getLabel('LBL_LANGUAGE', $this->siteLangId), 'lang_id', Language::getAllNames(), $lang_id, array(), '');
        $frm->addRequiredField(Labels::getLabel('LBL_Package_Name', $this->siteLangId), SellerPackages::DB_TBL_PREFIX . 'name');
        $frm->addTextarea(Labels::getLabel('LBL_Package_Description', $this->siteLangId), SellerPackages::DB_TBL_PREFIX . 'text');
        return $frm;
    }

    public function searchPlans()
    {
        $spackageId = FatApp::getPostedData('spackageId');
        $spackageId = FatUtility::convertToType($spackageId, FatUtility::VAR_INT);
        $sPackageObj = new SellerPackages();
        $data = $sPackageObj->getAttributesById($spackageId);

        if ($data === false) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $records = SellerPackagePlans::getPlanByPackageId($spackageId);

        $this->set('spackageId', $spackageId);
        $this->set("arrListing", $records);
        $this->set("spackageData", $data);
        $this->_template->render(false, false);
    }

    public function planForm($spackageId = 0, $spPlanId = 0)
    {
        $this->objPrivilege->canEditSellerPackages();
        $spackageId = FatUtility::int($spackageId);
        $spPlanId = FatUtility::int($spPlanId);
        $sPackageObj = new SellerPackages();
        $spdata = $sPackageObj->getAttributesById($spackageId);

        if ($spackageId < 1) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $frm = $this->getPlanForm($spackageId);
        if (0 < $spPlanId) {
            $sPackageObj = new SellerPackagePlans();
            $data = $sPackageObj->getAttributesById($spPlanId);

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
        $this->set('spPlanFrm', $frm);

        $this->_template->render(false, false);
    }

    private function getPlanForm($spackageId)
    {
        $sPackageObj = new SellerPackages($this->siteLangId);
        $sPackageData = $sPackageObj->getAttributesById($spackageId);

        $frm = new Form('frmSellerPackagePlan', array('id' => 'frmSellerPackagePlan'));
        $frm->addHiddenField('', SellerPackagePlans::DB_TBL_PREFIX . 'id');
        $frm->addHiddenField('', SellerPackagePlans::DB_TBL_PREFIX . 'spackage_id');
        $arr_options_packages = SellerPackages::getSellerPackages($this->siteLangId);
        $frm->addHTML(Labels::getLabel('LBL_Package', $this->siteLangId), SellerPackagePlans::DB_TBL_PREFIX . 'spackage_name', '<div class="field-set"><div class="caption-wraper"><label class="field_label">' . Labels::getLabel('LBL_Package', $this->siteLangId) . '<span class="spn_must_field">*</span></label></div><div class="field-wraper"><div class="field_cover"><p class="text-ptop10">' . $sPackageData['spackage_identifier'] . '</p></div></div></div>');

        $subsPeriodOption = SellerPackagePlans::getSubscriptionPeriods($this->siteLangId);
        $fldFreq = $frm->addSelectBox(Labels::getLabel('LBL_PERIOD', $this->siteLangId), SellerPackagePlans::DB_TBL_PREFIX . 'frequency', $subsPeriodOption, '', array(), '');
        $fldFreqText = $frm->addHTML('', SellerPackagePlans::DB_TBL_PREFIX . 'frequency_text', '');
        $fldFreq->attachField($fldFreqText);


        $fld = $frm->addIntegerField(Labels::getLabel('LBL_Time_Interval_(FREQUENCY)', $this->siteLangId), SellerPackagePlans::DB_TBL_PREFIX . 'interval');
        $fld->requirements()->setIntPositive();

        if ($sPackageData[SellerPackages::DB_TBL_PREFIX . 'type'] != SellerPackages::FREE_TYPE) {
            $priceFld = $frm->addFloatField(Labels::getLabel('LBL_Price', $this->siteLangId), SellerPackagePlans::DB_TBL_PREFIX . 'price')->requirements()->setRange('0.01', '9999999999');
            $fldPckPrice = $frm->getField(SellerPackagePlans::DB_TBL_PREFIX . 'price');
            $fldPckPrice->setWrapperAttribute('class', 'package_price');
        }

        $fld = $frm->addIntegerField(Labels::getLabel('LBL_Plan_Display_Order', $this->siteLangId), SellerPackagePlans::DB_TBL_PREFIX . 'display_order');
        $fld->requirements()->setIntPositive();
        $arr_options = applicationConstants::getActiveInactiveArr($this->siteLangId);
        $frm->addSelectBox(Labels::getLabel('LBL_Status', $this->siteLangId), SellerPackagePlans::DB_TBL_PREFIX . 'active', $arr_options, '', array(), '');
        // $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE_CHANGES', $this->siteLangId));
        return $frm;
    }

    public function setupPlan()
    {
        $this->objPrivilege->canEditSellerPackages();
        $postData = FatApp::getPostedData();

        $spackageId = $postData[SellerPackagePlans::DB_TBL_PREFIX . 'spackage_id'];
        $frm = $this->getPlanForm($spackageId);
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

            /* $data[SellerPackagePlans::DB_TBL_PREFIX.'frequency'] = SellerPackagePlans::SUBSCRIPTION_PERIOD_UNLIMITED; */
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

    public function autoComplete()
    {
        $pagesize = 10;
        $post = FatApp::getPostedData();
        $srch = SellerPackagePlans::getSearchObject();

        $srch->joinTable(
            SellerPackages::DB_TBL,
            'LEFT OUTER JOIN',
            'sp.spackage_id = spp.spplan_spackage_id ',
            'sp'
        );
        $srch->joinTable(
            SellerPackages::DB_TBL . '_lang',
            'LEFT OUTER JOIN',
            'spl.spackagelang_spackage_id = sp.spackage_id AND spl.spackagelang_lang_id = ' . $this->siteLangId,
            'spl'
        );

        $srch->addOrder('spackage_name');

        $srch->addMultipleFields(array('spplan_id', "IFNULL( spl.spackage_name, sp.spackage_identifier ) as spackage_name", "spplan_interval", "spplan_frequency"));
        $srch->addCondition('spackage_active', '=', applicationConstants::YES);
        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('spackage_name', 'LIKE', '%' . $post['keyword'] . '%');
            $cnd->attachCondition('spackage_identifier', 'LIKE', '%' . $post['keyword'] . '%', 'OR');
        }
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();

        $plans = $db->fetchAll($rs, 'spplan_id');
        $json = array();
        foreach ($plans as $key => $plan) {
            $json[] = array(
                'id' => $plan['spplan_id'],
                'name' => DiscountCoupons::getPlanTitle($plan, $this->siteLangId),
            );
        }
        die(json_encode($json));
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
        $subsPkgTblHeadingCols = CacheHelper::get('subsPkgTblHeadingCols' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if ($subsPkgTblHeadingCols) {
            return json_decode($subsPkgTblHeadingCols);
        }

        $arr = [
            'select_all' => Labels::getLabel('LBL_Select_all', $this->siteLangId),
            'listSerial' => Labels::getLabel('LBL_SR._NO', $this->siteLangId),
            'spackage_identifier' => Labels::getLabel('LBL_Package_Name', $this->siteLangId),
            'spackage_active' => Labels::getLabel('LBL_Status', $this->siteLangId),
            'action' => '',
        ];
        CacheHelper::create('subsPkgTblHeadingCols' . $this->siteLangId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'spackage_identifier',
            'spackage_active',
            'action',
        ];
    }

    private function excludeKeysForSort($fields = []): array
    {
        return array_diff($fields, ['spackage_active'], Common::excludeKeysForSort());
    }

    public function getBreadcrumbNodes($action)
    {
        parent::getBreadcrumbNodes($action);

        switch ($action) {
            case 'index':
                $this->nodes = [
                    ['title' => Labels::getLabel('LBL_SETTINGS', $this->siteLangId), 'href' => UrlHelper::generateUrl('Settings')],
                    ['title' => Labels::getLabel('LBL_SUBSCRIPTION_PACKAGES', $this->siteLangId)]
                ];
        }
        return $this->nodes;
    }
}
