<?php

class BuyersReportController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewBuyersReport($this->admin_id);
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
        $post = FatApp::getPostedData();

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
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

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

            CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Buyers_Sales_Report', $this->adminLangId) . '_' . date("d-M-Y") . '.csv', ',');
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

    private function getSearchForm($fields = [])
    {
        $frm = new Form('frmReportSearch');
        $frm->addHiddenField('', 'page');

        $frm->addTextBox(Labels::getLabel('LBL_Buyer_Name', $this->adminLangId), 'keyword');

        if (!empty($fields)) {
            $frm->addHiddenField('', 'sortBy', 'buyerName');
            $frm->addHiddenField('', 'sortOrder', applicationConstants::SORT_ASC);
            $frm->addHiddenField('', 'reportColumns', '');

            /* $frm->addSelectBox(Labels::getLabel("LBL_Sort_By", $this->adminLangId), 'sortBy', $fields, '', array(), '');
            $frm->addSelectBox(Labels::getLabel("LBL_Sort_Order", $this->adminLangId), 'sortOrder', applicationConstants::sortOrder($this->adminLangId), 0, array(),  ''); */
        }

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }

    private function getFormColumns()
    {
        $buyerReportsCacheVar = FatCache::get('buyerReportsCacheVar' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$buyerReportsCacheVar) {
            $arr = [
                'buyerName' => Labels::getLabel('LBL_Name', $this->adminLangId),
                'totOrders' => Labels::getLabel('LBL_No._of_Orders', $this->adminLangId),
                'orderItems' => Labels::getLabel('LBL_Ordered_Items', $this->adminLangId),
                'totQtys' => Labels::getLabel('LBL_Ordered_Qty', $this->adminLangId),
                'totRefundedQtys' => Labels::getLabel('LBL_Refunded_Qty', $this->adminLangId),
                'grossSales' => Labels::getLabel('LBL_Gross_Sale', $this->adminLangId),
                // 'transactionAmount' => Labels::getLabel('LBL_Transaction_Amount', $this->adminLangId),
                'inventoryValue' => Labels::getLabel('LBL_Inventory_Value', $this->adminLangId),

                'taxTotal' => Labels::getLabel('LBL_Tax_Charged', $this->adminLangId),

                'shippingTotal' => Labels::getLabel('LBL_Shipping_Charged', $this->adminLangId),

                'discountTotal' => Labels::getLabel('LBL_Total_Discount', $this->adminLangId),
                'couponDiscount' => Labels::getLabel('LBL_Coupon_Discount', $this->adminLangId),
                'volumeDiscount' => Labels::getLabel('LBL_Volume_Discount', $this->adminLangId),
                'rewardDiscount' => Labels::getLabel('LBL_Reward_Discount', $this->adminLangId),

                'refundedAmount' => Labels::getLabel('LBL_Refunded_Amount', $this->adminLangId),
                'refundedShipping' => Labels::getLabel('LBL_Refunded_Shipping', $this->adminLangId),
                'refundedTax' => Labels::getLabel('LBL_Refunded_Tax', $this->adminLangId),

                'orderNetAmount' => Labels::getLabel('LBL_Net_Amount', $this->adminLangId),
            ];
            FatCache::set('buyerReportsCacheVar' . $this->adminLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($buyerReportsCacheVar);
        }

        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return ['buyerName', 'totOrders', 'totQtys', 'totRefundedQtys', 'grossSales',  'taxTotal', 'shippingTotal', 'discountTotal', 'refundedAmount', 'orderNetAmount'];
    }
}
