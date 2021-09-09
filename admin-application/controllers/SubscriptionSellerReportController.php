<?php

class SubscriptionSellerReportController extends AdminBaseController
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

        $srch = new OrderSubscriptionSearch($this->adminLangId, true, true);
        $srch->joinWithCurrentSubscription();
        $srch->joinSubscription();
        $srch->joinOrderUser();
        $srch->joinOtherCharges();
        $srch->addGroupBy('o.order_user_id');
        $srch->addCondition('o.order_type', '=', Orders::ORDER_SUBSCRIPTION);
        $srch->includeCount();
        $srch->addMultipleFields(['user_autorenew_subscription', 'oss_l.ossubs_subscription_name', 'oss.ossubs_interval', 'oss.ossubs_frequency', 'oss.ossubs_type', 'ou.user_name as user_name', 'oss.ossubs_from_date', 'oss.ossubs_till_date', 'subscount.*']);
        $srch->addCompletedOrderCondition();
        if (!empty($keyword)) {
            $srch->addHaving('user_name', 'like', '%' . $keyword . '%', 'AND');
            $srch->addHaving('oss_l.ossubs_subscription_name', 'like', '%' . $keyword . '%', 'OR');
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
                        case 'subscriptionCharges':
                            $arr[] = CommonHelper::displayMoneyFormat($row[$key], true, true, false);
                            break;
                        case 'ossubs_from_date':
                        case 'ossubs_till_date':
                            $arr[] = FatDate::format($row[$key]);
                            break;
                        case 'ossubs_subscription_name':
                            $name = $row['ossubs_subscription_name'] . ' ';
                            $name .= ($row['ossubs_type'] == SellerPackages::PAID_TYPE) ? " /" . " " . Labels::getLabel("LBL_Per", $this->adminLangId) : Labels::getLabel("LBL_For", $this->adminLangId);

                            $name .= " " . (($row['ossubs_interval'] > 0) ? $row['ossubs_interval'] : '')
                                . "  " . $subcriptionPeriodArr[$row['ossubs_frequency']];
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

            CommonHelper::convertToCsv($sheetData, Labels::getLabel("LBL_Subscription_Seller_Report", $this->adminLangId) . '.csv', ',');
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
            $frm->addHiddenField('', 'sortBy', 'user_name');
            $frm->addHiddenField('', 'sortOrder', applicationConstants::SORT_ASC);
            $frm->addHiddenField('', 'reportColumns', '');
        }

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->adminLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);

        return $frm;
    }

    private function getFormColumns()
    {
        $spackageSReportsCacheVar = CacheHelper::get('spackageSReportsCacheVar' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$spackageSReportsCacheVar) {
            $arr = [
                'user_name' => Labels::getLabel('LBL_Name', $this->adminLangId),
                'ossubs_subscription_name' => Labels::getLabel('LBL_Package_Name', $this->adminLangId),
                'ossubs_from_date' => Labels::getLabel('LBL_Activation_Date', $this->adminLangId),
                'ossubs_till_date' => Labels::getLabel('LBL_Expiry_Date', $this->adminLangId),
                'spRenewals' => Labels::getLabel('LBL_Renewed', $this->adminLangId),
                'spackageCancelled' => Labels::getLabel('LBL_Cancellation', $this->adminLangId),
                'subscriptionCharges' => Labels::getLabel('LBL_Amount_paid', $this->adminLangId)
            ];
            CacheHelper::create('spackageSReportsCacheVar' . $this->adminLangId, serialize($arr), CacheHelper::TYPE_LABELS);
        } else {
            $arr =  unserialize($spackageSReportsCacheVar);
        }

        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return ['user_name', 'ossubs_subscription_name', 'ossubs_from_date', 'ossubs_till_date', 'spRenewals', 'spackageCancelled', 'subscriptionCharges'];
    }
}
