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
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('fields', $fields);
        $this->_template->addJs('js/report.js');
        $this->_template->render();
    }

    public function search($type = false)
    {
        $fields = $this->getFormColumns();
        $selectedFlds = FatApp::getPostedData('reportColumns', FatUtility::VAR_STRING, '');
        $selectedFlds = !empty($selectedFlds) ? json_decode($selectedFlds) +  $this->getDefaultColumns() : $this->getDefaultColumns();
        $fields =  FilterHelper::parseArrayByKeys($fields, $selectedFlds, true);
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, current(array_keys($fields)));
        if (!array_key_exists($sortBy, $fields)) {
            $sortBy = current(array_keys($fields));
        }

        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, applicationConstants::SORT_DESC);
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_DESC;
        }
        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $keyword = FatApp::getPostedData('keyword', null, '');


        $srch = new SellerPackagePlansSearch();
        $srch->joinPackage($this->adminLangId);
        $srch->includeCount();
        $srch->addMultipleFields(['ifnull(spackage_name,spackage_identifier) as spackage_name', 'spplan_price', 'spplan_frequency', 'spackage_type', 'spplan_interval', 'activeSubscribers', 'spackageCancelled', 'spackageSold', 'spRenewalPendings', 'spRenewals']);
        $srch->addCondition('spplan_active', '=', applicationConstants::ACTIVE);
        $srch->addGroupBy('spplan_id');
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('spackage_identifier', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('spackage_name', 'like', '%' . $keyword . '%');
        }

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
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
            $subcriptionPeriodArr = SellerPackagePlans::getSubscriptionPeriods($this->adminLangId);
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
                            $name .= ($row['spackage_type'] == SellerPackages::PAID_TYPE) ? " /" . " " . Labels::getLabel("LBL_Per", $this->adminLangId) : Labels::getLabel("LBL_For", $this->adminLangId);

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

            CommonHelper::convertToCsv($sheetData, Labels::getLabel("LBL_Subscription_Plan_Report", $this->adminLangId) . '.csv', ',');
            exit;
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        $arrListing = FatApp::getDb()->fetchAll($rs);

        $this->set("arrListing", $arrListing);
        $this->set('pageCount', $srch->pages());
        $this->set('recordCount', $srch->recordCount());
        $this->set('page', $page);
        $this->set('pageSize', $pagesize);
        $this->set('postedData', $post);
        $this->set('sortBy', $sortBy);
        $this->set('sortOrder', $sortOrder);
        $this->set('fields', $fields);
        $this->_template->render(false, false);
    }

    public function export()
    {
        $this->search('export');
    }

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmReportSearch');
        $frm->addHiddenField('', 'page', 1);
        $frm->addTextBox(Labels::getLabel("LBL_Keyword", $this->adminLangId), 'keyword');
        if (!empty($fields)) {
            $frm->addHiddenField('', 'sortBy', 'spackage_name');
            $frm->addHiddenField('', 'sortOrder', applicationConstants::SORT_ASC);
            $frm->addHiddenField('', 'reportColumns', '');
        }

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);

        return $frm;
    }

    private function getFormColumns()
    {
        $spackageReportsCacheVar = FatCache::get('spackageReportsCacheVar' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$spackageReportsCacheVar) {
            $arr = [
                'spackage_name' => Labels::getLabel('LBL_Package_Name', $this->adminLangId),
                'spackageSold' => Labels::getLabel('LBL_Sold', $this->adminLangId),
                'activeSubscribers' => Labels::getLabel('LBL_Active_Subscribers', $this->adminLangId),
                'spRenewalPendings' => Labels::getLabel('LBL_Pending_To_Renew', $this->adminLangId),
                'spRenewals' => Labels::getLabel('LBL_Renewed', $this->adminLangId),
                'spackageCancelled' => Labels::getLabel('LBL_Cancellation', $this->adminLangId),
                'spplan_price' => Labels::getLabel('LBL_Package_Cost', $this->adminLangId)
            ];
            FatCache::set('spackageReportsCacheVar' . $this->adminLangId, serialize($arr), '.txt');
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
