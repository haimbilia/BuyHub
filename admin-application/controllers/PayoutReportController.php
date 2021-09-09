<?php

class PayoutReportController extends AdminBaseController
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
        if (!array_key_exists($sortOrder, applicationConstants::sortOrder($this->adminLangId))) {
            $sortOrder = applicationConstants::SORT_DESC;
        }
        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
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
            $statusArr = Transactions::getStatusArr($this->adminLangId);
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

            CommonHelper::convertToCsv($sheetData, Labels::getLabel("LBL_Transaction_Report", $this->adminLangId) . '.csv', ',');
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
        $frm->addDateField(Labels::getLabel('LBL_Date_From', $this->adminLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('LBL_Date_To', $this->adminLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));

        if (!empty($fields)) {
            $frm->addHiddenField('', 'sortBy', 'product_name');
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
        $payoutReportsCacheVar = CacheHelper::get('payoutReportsCacheVar' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$payoutReportsCacheVar) {
            $arr = [
                'orderDate' => Labels::getLabel('LBL_Date', $this->adminLangId),
                'rewardDiscount' => Labels::getLabel('LBL_Reward_Discount', $this->adminLangId),
                'affiliateCommissionCharged' => Labels::getLabel('LBL_Affiliate_Commision', $this->adminLangId),
                'discountTotal' => Labels::getLabel('LBL_Coupon_Discount', $this->adminLangId),
                'totalAmount' => Labels::getLabel('LBL_Total_Amount', $this->adminLangId),
            ];
            CacheHelper::create('payoutReportsCacheVar' . $this->adminLangId, serialize($arr), CacheHelper::TYPE_LABELS);
        } else {
            $arr =  unserialize($payoutReportsCacheVar);
        }

        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return ['orderDate', 'rewardDiscount', 'affiliateCommissionCharged', 'discountTotal', 'totalAmount'];
    }
}
