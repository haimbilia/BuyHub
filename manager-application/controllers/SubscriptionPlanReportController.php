<?php

class SubscriptionPlanReportController extends AdminBaseController
{

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSubscriptionReport();
    }

    public function index($orderDate = '')
    {
        $formColumns = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($formColumns);
        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('formColumns', $formColumns);
        $this->set('pageTitle', Labels::getLabel('LBL_Subscription_plan_Report', $this->siteLangId));
        $this->getListingData(false);
        $this->_template->render();
    }

    public function search($type = false)
    {
        $this->getListingData($type);
        $jsonData = [
            'headSection' => $this->_template->render(false, false, '_partial/listing/head-section.php', true),
            'listingHtml' => $this->_template->render(false, false, 'subscription-plan-report/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function getListingData($type = false)
    {
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('listingColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current(array_keys($fields)));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current(array_keys($fields));
        }

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_DESC;
        }
        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $pageSize = FatApp::getPostedData('pageSize', FatUtility::VAR_STRING, FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10));
        if (!in_array($pageSize, applicationConstants::getPageSizeValues())) {
            $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }
        $keyword = FatApp::getPostedData('keyword', null, '');


        $srch = new SellerPackagePlansSearch();
        $srch->joinPackage($this->siteLangId);
        $srch->includeCount();
        $srch->addMultipleFields(['ifnull(spackage_name,spackage_identifier) as spackage_name', 'spplan_price', 'spplan_frequency', 'spackage_type', 'spplan_interval', 'activeSubscribers', 'spackageCancelled', 'spackageSold', 'spRenewalPendings', 'spRenewals']);
        $srch->addCondition('spplan_active', '=', applicationConstants::ACTIVE);
        $srch->addGroupBy('spplan_id');
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('spackage_identifier', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('spackage_name', 'like', '%' . $keyword . '%');
        }

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        switch ($sortBy) {
            default:
                $srch->addOrder($sortBy, $sortOrder);
                break;
        }

        if ($type == 'export') {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();

            array_push($sheetData, array_values($fields));
            $subcriptionPeriodArr = SellerPackagePlans::getSubscriptionPeriods($this->siteLangId);
            $count = 1;
            while ($row = FatApp::getDb()->fetch($rs)) {
                $arr = [];
                foreach ($fields as $key => $val) {
                    switch ($key) {
                        case 'listserial':
                            $arr[] = $count;
                            break;
                        case 'spplan_price':
                            $arr[] = CommonHelper::displayMoneyFormat($row[$key], true, true, false);
                            break;
                        case 'spackage_name':
                            $name = $row['spackage_name'] . ' ';
                            $name .= ($row['spackage_type'] == SellerPackages::PAID_TYPE) ? " /" . " " . Labels::getLabel("LBL_Per", $this->siteLangId) : Labels::getLabel("LBL_For", $this->siteLangId);

                            $name .= " " . (($row['spplan_interval'] > 0) ? $row['spplan_interval'] : '')
                                . "  " . $subcriptionPeriodArr[$row['spplan_frequency']];
                            $arr[] = $name;
                            break;
                        default:
                            $arr[] = $row[$key];
                            break;
                    }
                }

                array_push($sheetData, $arr);
                $count++;
            }

            CommonHelper::convertToCsv($sheetData, Labels::getLabel("LBL_Subscription_Plan_Report", $this->siteLangId) . '.csv', ',');
            exit;
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);
        $rs = $srch->getResultSet();
        $arrListing = FatApp::getDb()->fetchAll($rs);

        $this->set("arrListing", $arrListing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pageSize);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->set('allowedKeysForSorting', array_keys($fields));
    }

    public function export()
    {
        $this->search('export');
    }

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'spackage_name', applicationConstants::SORT_ASC);
        }
        $fld = $frm->addTextBox(Labels::getLabel("LBL_Keyword", $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);

        return $frm;
    }

    private function getFormColumns()
    {
        $spackageReportsCacheVar = FatCache::get('spackageReportsCacheVar' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$spackageReportsCacheVar) {
            $arr = [
                'spackage_name' => Labels::getLabel('LBL_Package_Name', $this->siteLangId),
                'spackageSold' => Labels::getLabel('LBL_Sold', $this->siteLangId),
                'activeSubscribers' => Labels::getLabel('LBL_Active_Subscribers', $this->siteLangId),
                'spRenewalPendings' => Labels::getLabel('LBL_Pending_To_Renew', $this->siteLangId),
                'spRenewals' => Labels::getLabel('LBL_Renewed', $this->siteLangId),
                'spackageCancelled' => Labels::getLabel('LBL_Cancellation', $this->siteLangId),
                'spplan_price' => Labels::getLabel('LBL_Package_Cost', $this->siteLangId)
            ];
            FatCache::set('spackageReportsCacheVar' . $this->siteLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($spackageReportsCacheVar);
        }

        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return ['spackage_name', 'spackageSold', 'activeSubscribers', 'spRenewalPendings', 'spRenewals', 'spackageCancelled', 'spplan_price'];
    }
}
