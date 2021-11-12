<?php

class SellerPackagePlansController extends AdminBaseController
{

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSellerPackages();
    }

    /**
     * checkEditPrivilege - This function is used to check, set previlege and can be also used in parent class to validate request.
     *
     * @param  bool $setVariable
     * @return void
     */
    protected function checkEditPrivilege(bool $setVariable = false): void
    {
        if (true === $setVariable) {
            $this->set("canEdit", $this->objPrivilege->canEditSellerPackages($this->admin_id, true));
        } else {
            $this->objPrivilege->canEditSellerPackages();
        }
    }

    /**
     * setModel - This function is used to set related model class and used by its parent class.
     *
     * @param  array $constructorArgs
     * @return void
     */
    protected function setModel(array $constructorArgs = []): void
    {
        $this->modelObj = (new ReflectionClass('SellerPackagePlans'))->newInstanceArgs($constructorArgs);
    }

    public function index()
    {
        Message::addErrorMessage(Labels::getLabel('MSG_PLEASE_SELECT_SELLER_PACKAGE_FIRST', $this->siteLangId));
        FatApp::redirectUser(UrlHelper::generateUrl('SellerPackages'));
    }

    public function list(int $spackageId)
    {
        $packageData =  SellerPackages::getAttributesByLangId($this->siteLangId, $spackageId, ['spackage_name', 'spackage_identifier'], true);

        if ($packageData === false) {
            Message::addErrorMessage($this->str_invalid_request);
            FatApp::redirectUser(UrlHelper::generateUrl('SellerPackages'));
        }

        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('pageTitle', Labels::getLabel('LBL_MANAGE_SUBSCRIPTION_PACKAGE_PLANS', $this->siteLangId));
        $packageData =  SellerPackages::getAttributesByLangId($this->siteLangId, $spackageId, ['spackage_name', 'spackage_identifier'], true);
        $this->set('packageName', $packageData['spackage_name']  ??  $packageData['spackage_identifier']);
        $this->getListingData($spackageId);
        $this->_template->render();
    }

    public function search()
    {
        $spackageId = FatApp::getPostedData('spackageId', FatUtility::VAR_INT, 0);
        $this->getListingData($spackageId);

        $jsonData = [
            'listingHtml' => $this->_template->render(false, false, 'seller-package-plans/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    private function getListingData(int $spackageId)
    {

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
        $post['spackageId'] = $spackageId;

        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;

        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $srch = SellerPackagePlans::getSearchObject($this->siteLangId);
        $srch->addMultipleFields(array("spp.*"));
        $srch->addCondition(SellerPackagePlans::DB_TBL_PREFIX . 'spackage_id', '=', $spackageId);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        $srch->addOrder($sortBy, $sortOrder);

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $srch->removeFld(['select_all', 'action']);
        $arrListing = FatApp::getDb()->fetchAll($srch->getResultSet());

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

    public function form()
    {
        $this->checkEditPrivilege();

        $spackageId = FatApp::getPostedData('spackageId', FatUtility::VAR_INT, 0);
        $spPlanId = FatApp::getPostedData('spPlanId', FatUtility::VAR_INT, 0);

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
        $this->set('spackageId', $spackageId);
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
        $frm->addSelectBox(Labels::getLabel('FRM_PERIOD', $this->siteLangId), 'spplan_frequency', $subsPeriodOption, '', array(), '');

        $fld = $frm->addIntegerField(Labels::getLabel('FRM_TIME_INTERVAL_(FREQUENCY)', $this->siteLangId), 'spplan_interval');
        $fld->requirements()->setIntPositive();

        if (SellerPackages::getAttributesById($spackageId, SellerPackages::tblFld('type'))  != SellerPackages::FREE_TYPE) {
            $frm->addFloatField(Labels::getLabel('FRM_PRICE', $this->siteLangId), 'spplan_price')->requirements()->setRange('0.01', '9999999999');
            $fldPckPrice = $frm->getField('spplan_price');
            $fldPckPrice->setWrapperAttribute('class', 'package_price');
        }

        $fld = $frm->addIntegerField(Labels::getLabel('FRM_PLAN_DISPLAY_ORDER', $this->siteLangId), 'spplan_display_order');
        $fld->requirements()->setIntPositive();

        $frm->addSelectBox(Labels::getLabel('FRM_STATUS', $this->siteLangId), 'spplan_active', applicationConstants::getActiveInactiveArr($this->siteLangId), '', array(), '');

        return $frm;
    }

    public function setup()
    {
        $this->checkEditPrivilege();
        $post = FatApp::getPostedData();
        $spackageId = FatApp::getPostedData('spplan_spackage_id', FatUtility::VAR_INT, 0);

        $frm = $this->getForm($spackageId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $packageRow = SellerPackages::getAttributesById($spackageId, ['spackage_type']);
        if (false === $packageRow) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }
        $data = $post;

        if ($packageRow[SellerPackages::DB_TBL_PREFIX . 'type'] == SellerPackages::FREE_TYPE) {
            $data[SellerPackagePlans::DB_TBL_PREFIX . 'trial_frequency'] = '';
            $data[SellerPackagePlans::DB_TBL_PREFIX . 'trial_interval'] = 0;
            $data[SellerPackagePlans::DB_TBL_PREFIX . 'price'] = 0;
        }

        $record = new SellerPackagePlans($post['spplan_id']);
        $record->assignValues($data);
        if (!$record->save()) {
            LibHelper::exitWithError($record->getError(), true);
        }
        $this->set('msg', $this->str_setup_successful);
        $this->_template->render(false, false, 'json-success.php');
    }
    
    protected function getFormColumns(): array
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

    protected function getDefaultColumns(): array
    {
        return [
            'select_all',
            'listSerial',
            'spplan_price',
            'spplan_active',
            'action',
        ];
    }

    protected function excludeKeysForSort($fields = []): array
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
