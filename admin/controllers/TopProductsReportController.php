<?php

class TopProductsReportController extends ListingBaseController
{
    private $canView;
    private $canEdit;

    public const REPORT_TYPE_TODAY = 1;
    public const REPORT_TYPE_WEEKLY = 2;
    public const REPORT_TYPE_MONTHLY = 3;
    public const REPORT_TYPE_YEARLY = 4;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewPerformanceReport($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditPerformanceReport($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    private function getReportTypeArr()
    {
        return array(self::REPORT_TYPE_TODAY => 'Today',  self::REPORT_TYPE_WEEKLY => 'Weekly', self::REPORT_TYPE_MONTHLY => 'Monthly', self::REPORT_TYPE_YEARLY => 'Yearly');
    }

    public function index()
    {
        $this->objPrivilege->canViewPerformanceReport();
        $frmSearch = $this->getSearchForm();
        $this->set('frmSearch', $frmSearch);
        $this->_template->render();
    }

    public function search($export = false)
    {
        $this->objPrivilege->canViewPerformanceReport();
        $db = FatApp::getDb();

        $srchFrm = $this->getSearchForm();
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $pageSize = FatApp::getPostedData('pagesize', FatUtility::VAR_INT, 10);
        $topPerformed = FatApp::getPostedData('top_perfomed', FatUtility::VAR_INT, 0);
        $keyword = FatApp::getPostedData('keyword', null, '');


        /* Sub Query to get, how many users added current product in his/her wishlist[ */
        $uWsrch = new UserWishListProductSearch($this->siteLangId);
        $uWsrch->doNotCalculateRecords();
        $uWsrch->doNotLimitRecords();
        $uWsrch->joinWishLists();
        $uWsrch->addGroupBy('uwlp_selprod_id');
        $uWsrch->addMultipleFields(array('uwlp_selprod_id', 'uwlist_user_id', 'count(uwlist_user_id) as wishlist_user_counts'));
        /* ] */

        $srch = new OrderProductSearch($this->siteLangId, true);
        $srch->joinPaymentMethod();
        $srch->joinTable('(' . $uWsrch->getQuery() . ')', 'LEFT OUTER JOIN', 'tquwl.uwlp_selprod_id = op.op_selprod_id', 'tquwl');
        $srch->doNotCalculateRecords();
        $srch->addStatusCondition(unserialize(FatApp::getConfig("CONF_COMPLETED_ORDER_STATUS")));
        $cnd = $srch->addCondition('order_payment_status', '=', Orders::ORDER_PAYMENT_PAID);
        $cnd->attachCondition('plugin_code', '=', 'CashOnDelivery');
        if (!empty($keyword)) {
            $cnd = $srch->addCondition('op_selprod_title', 'like', '%' . $keyword . '%');
            $cnd->attachCondition('op_selprod_options', 'like', '%' . $keyword . '%', 'OR');
            $cnd->attachCondition('op_brand_name', 'like', '%' . $keyword . '%', 'OR');
            $cnd->attachCondition('op_shop_name', 'like', '%' . $keyword . '%', 'OR');
        }
        $srch->addMultipleFields(array('op_selprod_title', 'op_product_name', 'op_shop_name', 'op_selprod_options', 'op_brand_name', 'SUM(op_refund_qty) as totRefundQty', 'SUM(op_qty - op_refund_qty) as totSoldQty', 'op.op_selprod_id', 'count(distinct tquwl.uwlist_user_id) as followers', 'IFNULL(tquwl.wishlist_user_counts, 0) as wishlistUserCounts'));
        $srch->addGroupBy('op.op_selprod_id');
        $srch->addGroupBy('op.op_is_batch');
        if ($topPerformed) {
            $srch->addOrder('totSoldQty', 'desc');
            $srch->addHaving('totSoldQty', '>', 0);
        } else {
            $srch->addOrder('totRefundQty', 'desc');
            $srch->addHaving('totRefundQty', '>', 0);
        }
        /* echo $srch->getQuery(); die; */
        $reportType = FatApp::getPostedData('report_type', FatUtility::VAR_INT, 0);
        if ($reportType) {
            switch ($reportType) {
                case self::REPORT_TYPE_TODAY:
                    $srch->addDirectCondition('DATE(o.order_date_added)=DATE(NOW())');
                    break;

                case self::REPORT_TYPE_WEEKLY:
                    $srch->addDirectCondition('YEARWEEK(o.order_date_added)=YEARWEEK(NOW())');
                    break;

                case self::REPORT_TYPE_MONTHLY:
                    $srch->addDirectCondition('MONTH(o.order_date_added)=MONTH(NOW())');
                    break;

                case self::REPORT_TYPE_YEARLY:
                    $srch->addDirectCondition('YEAR(o.order_date_added)=YEAR(NOW())');
                    break;
            }
        }

        $srch->setPageNumber($page);
        $srch->setPageSize($pageSize);

        if ($export == 'export') {
            $rs = $srch->getResultSet();
            $sheetData = array();
            $arr = array(Labels::getLabel('LBL_Product', $this->siteLangId), Labels::getLabel('LBL_Custom_Title', $this->siteLangId), Labels::getLabel('LBL_Options', $this->siteLangId), Labels::getLabel('LBL_Brand', $this->siteLangId), Labels::getLabel('LBL_Shop', $this->siteLangId), Labels::getLabel('LBL_WishList_User_Counts', $this->siteLangId));
            if ($topPerformed) {
                array_push($arr, Labels::getLabel('LBL_Sold_Quantity', $this->siteLangId));
            } else {
                array_push($arr, Labels::getLabel('LBL_Refund_Quantity', $this->siteLangId));
            }
            array_push($sheetData, $arr);

            while ($row = $db->fetch($rs)) {
                $arr = array($row['op_product_name'], $row['op_selprod_title'], $row['op_selprod_options'], $row['op_brand_name'], $row['op_shop_name'], $row['followers']);
                if ($topPerformed) {
                    array_push($arr, $row['totSoldQty']);
                } else {
                    array_push($arr, $row['totRefundQty']);
                }
                array_push($sheetData, $arr);
            }
            if ($topPerformed) {
                CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Top_Products_Report', $this->siteLangId) . ' ' . date("d-M-Y") . '.csv', ',');
                exit;
            } else {
                CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Most_Refunded_Products_Report', $this->siteLangId) . ' ' . date("d-M-Y") . '.csv', ',');
                exit;
            }
        } else {
            $rs = $srch->getResultSet();
            $arrListing = $db->fetchAll($rs);
            $this->set("arrListing", $arrListing);
            $this->set('pageCount', $srch->pages());
            $this->set('recordCount', $srch->recordCount());
            $this->set('page', $page);
            $this->set('pageSize', $pageSize);
            $this->set('topPerformed', $topPerformed);
            $this->set('postedData', $post);
            $this->set('html', $this->_template->render(false, false, NULL, true));
            $this->_template->render(false, false, 'json-success.php', true, false);
        }
    }

    public function export()
    {
        $this->search('export');
    }

    public function getSearchForm(array $fields = [])
    {
        $frm = new Form('frmTopProductsReportSearch');
        $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $this->siteLangId), 'keyword', '', array('id' => 'keyword', 'autocomplete' => 'off'));
        $frm->addSelectBox(Labels::getLabel('FRM_TYPE', $this->siteLangId), 'report_type', $this->getReportTypeArr(), '', array(), Labels::getLabel('FRM_OVERALL', $this->siteLangId));
        $frm->addHiddenField('', 'page', 1);
        $frm->addSelectBox(Labels::getLabel('FRM_RECORD_PER_PAGE', $this->siteLangId), 'pagesize', array(10 => '10', 20 => '20', 30 => '30', 50 => '50'), '', array(), '');
        $frm->addHiddenField('', 'top_perfomed', 1);
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SEARCH', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('BTN_CLEAR', $this->siteLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }
}
