<?php

class BuyersReportController extends ListingBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBuyersReport($this->admin_id);
    }

    public function index()
    {
        $formColumns = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($formColumns);
        $pageData = PageLanguageData::getAttributesByKey('BUYERS_REPORT', $this->siteLangId);
        $pageTitle = $pageData['plang_title'] ?? LibHelper::getControllerName(true);

        $this->set('pageData', $pageData);
        $this->set('pageTitle', $pageTitle);
        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('formColumns', $formColumns);
        $this->getListingData(false);
        $this->_template->render();
    }

    public function search($type = false)
    {
        $this->getListingData($type);
        $jsonData = [
            'headSection' => $this->_template->render(false, false, '_partial/listing/head-section.php', true),
            'listingHtml' => $this->_template->render(false, false, 'buyers-report/search.php', true),
            'paginationHtml' => $this->_template->render(false, false, '_partial/listing/listing-foot.php', true)
        ];
        LibHelper::exitWithSuccess($jsonData, true);
    }

    public function getListingData($type = false)
    {
        $post = FatApp::getPostedData();

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
        $pageSize = applicationConstants::getPageSize(FatApp::getPostedData('pageSize', FatUtility::VAR_INT));

        $rSrch = new Report(0, array_keys($fields));
        $rSrch->joinOrders();
        $rSrch->joinPaymentMethod();
        $rSrch->joinOtherCharges(true);
        $rSrch->joinOrderProductTaxCharges();
        $rSrch->joinOrderProductShipCharges();
        $rSrch->joinOrderProductDicountCharges();
        $rSrch->joinOrderProductVolumeCharges();
        $rSrch->joinOrderProductRewardCharges();
        $rSrch->setPaymentStatusCondition();
        $rSrch->setCompletedOrdersCondition();
        $rSrch->excludeDeletedOrdersCondition();
        $rSrch->doNotCalculateRecords();
        $rSrch->doNotLimitRecords();
        $rSrch->addTotalOrdersCount('order_user_id');
        $rSrch->setGroupBy('order_user_id');
        $rSrch->removeFld('buyerName');
        // echo $rSrch->getQuery(); exit;
        $fromDate = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        $toDate = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');

        $srch = new UserSearch();
        $srch->joinTable('(' . $rSrch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = opq.order_user_id', 'opq');
        $srch->addMultipleFields(['u.user_name as buyerName', 'uc.credential_email as buyerEmail', 'opq.*']);
        $srch->addCondition('totOrders', '>', '0');

        if (!empty($post['keyword'])) {
            $cnd = $srch->addCondition('u.user_name', 'like', '%' . $post['keyword'] . '%', 'AND');
            $cnd->attachCondition('uc.credential_email', 'like', '%' . $post['keyword'] . '%');
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
                        case 'buyerName':
                            $name = $row['buyerName'] . "\n" . $row['buyerEmail'];
                            $arr[] = $name;
                            break;
                        case 'grossSales':
                        case 'transactionAmount':
                        case 'inventoryValue':
                        case 'taxTotal':
                        case 'shippingTotal':
                        case 'discountTotal':
                        case 'couponDiscount':
                        case 'volumeDiscount':
                        case 'rewardDiscount':
                        case 'refundedAmount':
                        case 'refundedShipping':
                        case 'refundedTax':
                        case 'orderNetAmount':

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

            CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Buyers_Sales_Report', $this->siteLangId) . '_' . date("d-M-Y") . '.csv', ',');
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

    public function getSearchForm($fields = [])
    {
        $frm = new Form('frmRecordSearch');
        if (!empty($fields)) {
            $this->addSortingElements($frm, 'buyerName', applicationConstants::SORT_ASC);
        }

        $fld = $frm->addTextBox(Labels::getLabel('LBL_Keyword', $this->siteLangId), 'keyword');
        $fld->overrideFldType('search');

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm);
        return $frm;
    }

    protected function getFormColumns()
    {
        $buyerReportsCacheVar = FatCache::get('buyerReportsCacheVar' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$buyerReportsCacheVar) {
            $arr = [
                'buyerName' => Labels::getLabel('LBL_Name', $this->siteLangId),
                'totOrders' => Labels::getLabel('LBL_No._of_Orders', $this->siteLangId),
                'orderItems' => Labels::getLabel('LBL_Ordered_Items', $this->siteLangId),
                'totQtys' => Labels::getLabel('LBL_Ordered_Qty', $this->siteLangId),
                'totRefundedQtys' => Labels::getLabel('LBL_Refunded_Qty', $this->siteLangId),
                'grossSales' => Labels::getLabel('LBL_Gross_Sale', $this->siteLangId),
                // 'transactionAmount' => Labels::getLabel('LBL_Transaction_Amount', $this->siteLangId),
                'inventoryValue' => Labels::getLabel('LBL_Inventory_Value', $this->siteLangId),

                'taxTotal' => Labels::getLabel('LBL_Tax_Charged', $this->siteLangId),

                'shippingTotal' => Labels::getLabel('LBL_Shipping_Charged', $this->siteLangId),

                'discountTotal' => Labels::getLabel('LBL_Total_Discount', $this->siteLangId),
                'couponDiscount' => Labels::getLabel('LBL_Coupon_Discount', $this->siteLangId),
                'volumeDiscount' => Labels::getLabel('LBL_Volume_Discount', $this->siteLangId),
                'rewardDiscount' => Labels::getLabel('LBL_Reward_Discount', $this->siteLangId),

                'refundedAmount' => Labels::getLabel('LBL_Refunded_Amount', $this->siteLangId),
                'refundedShipping' => Labels::getLabel('LBL_Refunded_Shipping', $this->siteLangId),
                'refundedTax' => Labels::getLabel('LBL_Refunded_Tax', $this->siteLangId),

                'orderNetAmount' => Labels::getLabel('LBL_Net_Amount', $this->siteLangId),
            ];
            FatCache::set('buyerReportsCacheVar' . $this->siteLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($buyerReportsCacheVar);
        }

        return $arr;
    }

    protected function getDefaultColumns(): array
    {
        return ['buyerName', 'totOrders', 'totQtys', 'totRefundedQtys', 'grossSales',  'taxTotal', 'shippingTotal', 'discountTotal', 'refundedAmount', 'orderNetAmount'];
    }
}
