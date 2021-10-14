<?php

class EarningsReportController extends AdminBaseController
{

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewFinancialReport();
    }

    public function index()
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
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->siteLangId))) {
            $sortOrder = applicationConstants::SORT_DESC;
        }
        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        $fromDate = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        $toDate = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');

        /* Promotion Charges */
        $pSrch = new SearchBase(Promotion::DB_TBL_CHARGES, 'pc');
        $pSrch->doNotCalculateRecords();
        $pSrch->doNotLimitRecords();
        $pSrch->addGroupBy('Date(pc.pcharge_date)');
        $pSrch->addMultipleFields(['Date(pc.pcharge_date) as date']);

        /* Admin Sales Earnings */
        $opSrch = new Report();
        $opSrch->addMultipleFields(['DATE(o.order_date_added) as date']);
        $opSrch->joinOrders();
        $opSrch->joinPaymentMethod();
        $opSrch->joinOtherCharges(true);
        $opSrch->setPaymentStatusCondition();
        $opSrch->setCompletedOrdersCondition();
        $opSrch->excludeDeletedOrdersCondition();
        $opSrch->setGroupBy('DATE(o.order_date_added)');
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();
        $opSrch->setDateCondition($fromDate, $toDate);

        /* Subscription earning */
        $sSrch = new OrderSubscriptionSearch($this->siteLangId, true, true);
        $sSrch->joinSubscription();
        $sSrch->joinOrderUser();
        $sSrch->joinOtherCharges();
        $sSrch->addCondition('order_type', '=', Orders::ORDER_SUBSCRIPTION);
        $sSrch->addGroupBy('DATE(o.order_date_added)');
        $sSrch->addMultipleFields(['DATE(o.order_date_added) as date']);
        $sSrch->doNotCalculateRecords();
        $sSrch->doNotLimitRecords();
        $sSrch->addCompletedOrderCondition();

        $query = $pSrch->getQuery() . ' UNION ALL ' . $opSrch->getQuery() . ' UNION ALL ' . $sSrch->getQuery();
        $srch = new SearchBase("(" . $query . ") as tmp");
        $srch->addMultipleFields(['tmp.date', 'psrch.promotionCharged', 'opSrch.adminSalesEarnings', 'sSrch.subscriptionCharges', 'ifnull(psrch.promotionCharged,0) + ifnull(opSrch.adminSalesEarnings,0) + ifnull(sSrch.subscriptionCharges,0) as totalEarning']);
        $pSrch->addMultipleFields(['SUM(pc.pcharge_charged_amount) as promotionCharged']);
        $opSrch->addMultipleFields(['sum((IFNULL(op_commission_charged,0) - IFNULL(op_refund_commission,0))) as adminSalesEarnings']);
        $sSrch->addMultipleFields(['sum(ossubs_price + ifnull(op_other_charges,0)) as subscriptionCharges']);
        $srch->joinTable('(' . $pSrch->getQuery() . ')', 'LEFT OUTER JOIN', 'tmp.date = psrch.date', 'psrch');
        $srch->joinTable('(' . $opSrch->getQuery() . ')', 'LEFT OUTER JOIN', 'tmp.date = opSrch.date', 'opSrch');
        $srch->joinTable('(' . $sSrch->getQuery() . ')', 'LEFT OUTER JOIN', 'tmp.date = sSrch.date', 'sSrch');
        $srch->addGroupBy('date');

        if (!empty($fromDate)) {
            $srch->addCondition('tmp.date', '>=', $fromDate . ' 00:00:00');
        }

        if (!empty($toDate)) {
            $srch->addCondition('tmp.date', '<=', $toDate . ' 23:59:59');
        }

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder(CommonHelper::getLangId()))) {
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

            $count = 1;
            while ($row = FatApp::getDb()->fetch($rs)) {
                $arr = [];
                foreach ($fields as $key => $val) {
                    switch ($key) {
                        case 'listserial':
                            $arr[] = $count;
                            break;
                        case 'subscriptionCharges':
                        case 'promotionCharged':
                        case 'adminSalesEarnings':
                            $arr[] = CommonHelper::displayMoneyFormat($row[$key], true, true);
                            break;
                        default:
                            $arr[] = $row[$key];
                            break;
                    }
                }

                array_push($sheetData, $arr);
                $count++;
            }

            CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Earnings_Report', $this->siteLangId) . date("d-M-Y") . '.csv', ',');
            exit;
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);
        $rs = $srch->getResultSet();
        echo $srch->getError();
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

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmReportSearch');
        $frm->addHiddenField('', 'page', 1);
        $frm->addDateField(Labels::getLabel('LBL_Date_From', $this->siteLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('LBL_Date_To', $this->siteLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        if (!empty($fields)) {
            $frm->addHiddenField('', 'sortBy', 'date');
            $frm->addHiddenField('', 'sortOrder', applicationConstants::SORT_DESC);
            $frm->addHiddenField('', 'reportColumns', '');

            /* $frm->addSelectBox(Labels::getLabel("LBL_Sort_By", $this->siteLangId), 'sortBy', $fields, '', array(), '');
            $frm->addSelectBox(Labels::getLabel("LBL_Sort_Order", $this->siteLangId), 'sortOrder', applicationConstants::sortOrder($this->siteLangId), 0, array(),  ''); */
        }

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->siteLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);

        return $frm;
    }

    private function getFormColumns()
    {
        $earningsReportsCacheVar = FatCache::get('earningsReportsCacheVar' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$earningsReportsCacheVar) {
            $arr = [
                'date' => Labels::getLabel('LBL_Date', $this->siteLangId),
                'subscriptionCharges' => Labels::getLabel('LBL_Subscription_Charges', $this->siteLangId),
                'promotionCharged' => Labels::getLabel('LBL_Advertisement_Charges', $this->siteLangId),
                'adminSalesEarnings' => Labels::getLabel('LBL_Sales_Earnings', $this->siteLangId),
                'totalEarning' => Labels::getLabel('LBL_Total_Earnings', $this->siteLangId),
            ];
            FatCache::set('earningsReportsCacheVar' . $this->siteLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($earningsReportsCacheVar);
        }

        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return ['date', 'subscriptionCharges', 'promotionCharged', 'adminSalesEarnings', 'totalEarning'];
    }
}
