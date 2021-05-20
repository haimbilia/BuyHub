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
        $flds = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($flds);
        $this->set('frmSearch', $frmSearch);
        $this->_template->render();
    }

    public function search($type = false)
    {
        $fields = $this->getFormColumns();
        $srchFrm = $this->getSearchForm($fields);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'name');
        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, 'DESC');
        $keyword = FatApp::getPostedData('keyword', null, '');

        $srch = new OrderSubscriptionSearch($this->adminLangId, true, true);
        $srch->joinSubscription();
        $srch->joinOrderUser();
        $srch->joinOtherCharges();
        $srch->addCondition('order_type', '=', Orders::ORDER_SUBSCRIPTION);
        $srch->addGroupBy('order_user_id');
        $srch->addMultipleFields(['user_autorenew_subscription', 'ossubs_subscription_name', 'ossubs_interval', 'ossubs_frequency', 'ossubs_type', 'ou.user_name as user_name', 'sum(ossubs_price + ifnull(op_other_charges,0)) as amountPaid', 'count(DISTINCT(if(order_renew = 1 and order_payment_status = ' . Orders::ORDER_PAYMENT_PAID . ', order_id, null))) as spRenewals', 'count(DISTINCT(if(ossubs_status_id = ' . OrderSubscription::CANCELLED_SUBSCRIPTION . ', order_id, null))) as spackageCancelled', 'ossubs_from_date', 'ossubs_till_date']);
        /*toDo ossubs_from_date and  ossubs_till_date from last order*/

        if (!empty($keyword)) {
            $cnd = $srch->addCondition('user_name', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('ossubs_subscription_name', 'like', '%' . $keyword . '%');
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
                        case 'amountPaid':
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
        $frm->addTextBox(Labels::getLabel("LBL_Name", $this->adminLangId), 'keyword');
        if (!empty($fields)) {
            $frm->addSelectBox(Labels::getLabel("LBL_Sort_By", $this->adminLangId), 'sortBy', $fields, '', array(), '');

            $frm->addSelectBox(Labels::getLabel("LBL_Sort_Order", $this->adminLangId), 'sortOrder', applicationConstants::sortOrder($this->adminLangId), 0, array(),  '');
        }

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);

        return $frm;
    }

    private function getFormColumns()
    {
        $spackageSReportsCacheVar = FatCache::get('spackageSReportsCacheVar' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$spackageSReportsCacheVar) {
            $arr = [
                'user_name' => Labels::getLabel('LBL_Name', $this->adminLangId),
                'ossubs_subscription_name' => Labels::getLabel('LBL_Package_Name', $this->adminLangId),
                'ossubs_from_date' => Labels::getLabel('LBL_Activation_Date', $this->adminLangId),
                'ossubs_till_date' => Labels::getLabel('LBL_Expiry_Date', $this->adminLangId),
                'spRenewals' => Labels::getLabel('LBL_Renewed', $this->adminLangId),
                'spackageCancelled' => Labels::getLabel('LBL_Cancellation', $this->adminLangId),
                'amountPaid' => Labels::getLabel('LBL_Amount_paid', $this->adminLangId)
            ];
            FatCache::set('spackageSReportsCacheVar' . $this->adminLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($spackageSReportsCacheVar);
        }

        return $arr;
    }
}
