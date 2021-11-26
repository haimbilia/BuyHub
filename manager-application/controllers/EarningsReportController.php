<?php

class EarningsReportController extends ListingBaseController
{
    protected $pageKey = 'REPORT_EARNINGS';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewFinancialReport();
    }

    public function index()
    {
        $formColumns = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($formColumns);
        $pageData = PageLanguageData::getAttributesByKey($this->pageKey, $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $actionItemsData = HtmlHelper::getDefaultActionItems($formColumns);
        $actionItemsData = array_merge($actionItemsData, [
            'newRecordBtn' => false,
            'formColumns' => $formColumns,
            'columnButtons' => true,
            'defaultColumns' => $this->getDefaultColumns()
        ]);

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('frmSearch', $frmSearch);
        $this->set('actionItemsData', $actionItemsData);
        $this->getListingData(false);
        $this->_template->render();
    }

    public function search($type = false)
    {
        $this->getListingData($type);
        $jsonData = [
            'headSection' => $this->_template->render(false, false, '_partial/listing/head-section.php', true),
            'listingHtml' => $this->_template->render(false, false, 'earnings-report/search.php', true),
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

        $sortOrder = applicationConstants::getSortOrder(FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING));
        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

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
                        case 'listSerial':
                            $arr[] = $count;
                            break;
                        case 'subscriptionCharges':
                        case 'promotionCharged':
                        case 'adminSalesEarnings':
                        case 'totalEarning':
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
            $this->addSortingElements($frm, 'date', applicationConstants::SORT_DESC);
        }
        $frm->addDateField(Labels::getLabel('FRM_DATE_FROM', $this->siteLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('FRM_DATE_TO', $this->siteLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);

        return $frm;
    }

    protected function getFormColumns()
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

    protected function getDefaultColumns(): array
    {
        return ['date', 'subscriptionCharges', 'promotionCharged', 'adminSalesEarnings', 'totalEarning'];
    }
}
