<?php

class PayoutReportController extends ListingBaseController
{

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewFinancialReport();
    }

    public function index()
    {
        $formColumns = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($formColumns);
        $pageData = PageLanguageData::getAttributesByKey('PAYOUT_REPORT', $this->siteLangId);
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
        $this->_template->render(true, true, '_partial/listing/reports-index.php');
    }

    public function search($type = false)
    {
        $this->getListingData($type);
        $jsonData = [
            'headSection' => $this->_template->render(false, false, '_partial/listing/head-section.php', true),
            'listingHtml' => $this->_template->render(false, false, 'payout-report/search.php', true),
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

        $srch = new Report(0, []);
        $srch->joinOrders();
        $srch->joinPaymentMethod();
        $srch->joinOtherCharges(true);
        $srch->joinOrderProductDicountCharges();
        $srch->joinOrderProductRewardCharges();
        $srch->setPaymentStatusCondition();
        $srch->setCompletedOrdersCondition();
        $srch->excludeDeletedOrdersCondition();
        $srch->setGroupBy('orderDate');
        $srch->setDateCondition($fromDate, $toDate);
        $srch->setOrderBy($sortBy, $sortOrder);
        $srch->addMultipleFields(['DATE(o.order_date_added) as orderDate', 'SUM(IFNULL(ABS(opDiscountCharges), 0)) as discountTotal', 'sum(IFNULL(ABS(op_affiliate_commission_charged),0)) as affiliateCommissionCharged', 'SUM(IFNULL(ABS(opRewardDis.opcharge_amount), 0)) as rewardDiscount']);
        $srch->addFld('(SUM(IFNULL(ABS(opDiscountCharges), 0)) + sum(IFNULL(op_affiliate_commission_charged,0)) + (SUM(IFNULL(ABS(opRewardDis.opcharge_amount), 0))) ) as totalAmount');

        if ($type == 'export') {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();

            array_push($sheetData, array_values($fields));
            $count = 1;
            $statusArr = Transactions::getStatusArr($this->siteLangId);
            while ($row = FatApp::getDb()->fetch($rs)) {
                $arr = [];
                foreach ($fields as $key => $val) {
                    switch ($key) {
                        case 'listserial':
                            $arr[] = $count;
                            break;
                        case 'orderDate':
                            $arr[] = FatDate::format($row[$key]);
                            break;
                        case 'rewardDiscount':
                        case 'affiliateCommissionCharged':
                        case 'discountTotal':
                        case 'totalAmount':
                            $arr[] = CommonHelper::displayMoneyFormat($row[$key], true, true, false);
                            break;
                        default:
                            $arr[] = $row[$key];
                            break;
                    }
                }

                array_push($sheetData, $arr);
                $count++;
            }

            CommonHelper::convertToCsv($sheetData, Labels::getLabel("LBL_Transaction_Report", $this->siteLangId) . '.csv', ',');
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
            $this->addSortingElements($frm, 'product_name', applicationConstants::SORT_ASC);
        }
        $frm->addDateField(Labels::getLabel('LBL_Date_From', $this->siteLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('LBL_Date_To', $this->siteLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);

        return $frm;
    }

    protected function getFormColumns()
    {
        $payoutReportsCacheVar = FatCache::get('payoutReportsCacheVar' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$payoutReportsCacheVar) {
            $arr = [
                'orderDate' => Labels::getLabel('LBL_Date', $this->siteLangId),
                'rewardDiscount' => Labels::getLabel('LBL_Reward_Discount', $this->siteLangId),
                'affiliateCommissionCharged' => Labels::getLabel('LBL_Affiliate_Commision', $this->siteLangId),
                'discountTotal' => Labels::getLabel('LBL_Coupon_Discount', $this->siteLangId),
                'totalAmount' => Labels::getLabel('LBL_Total_Amount', $this->siteLangId),
            ];
            FatCache::set('payoutReportsCacheVar' . $this->siteLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($payoutReportsCacheVar);
        }

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return ['orderDate', 'rewardDiscount', 'affiliateCommissionCharged', 'discountTotal', 'totalAmount'];
    }
}
