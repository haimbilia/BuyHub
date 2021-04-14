<?php

class ShopsReportController extends AdminBaseController
{
    private $canView;
    private $canEdit;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->canView = $this->objPrivilege->canViewShopsReport($this->admin_id, true);
        $this->canEdit = $this->objPrivilege->canEditShopsReport($this->admin_id, true);
        $this->set("canView", $this->canView);
        $this->set("canEdit", $this->canEdit);
    }

    public function index()
    {
        $this->objPrivilege->canViewShopsReport();
        $frmSearch = $this->getSearchForm();
        $this->set('frmSearch', $frmSearch);
        $this->_template->render();
    }

    public function search($type = false)
    {
        $this->objPrivilege->canViewShopsReport();
        $db = FatApp::getDb();

        $srchFrm = $this->getSearchForm();
        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);


        $fields = ['totOrders', 'totQtys', 'totRefundedQtys', 'netSoldQty', 'grossSales', 'transactionAmount', 'inventoryValue', 'taxTotal', 'sellerTaxTotal', 'adminTaxTotal', 'shippingTotal', 'sellerShippingTotal', 'adminShippingTotal', 'couponDiscount', 'volumeDiscount', 'rewardDiscount', 'adminSalesEarnings', 'refundedAmount', 'refundedShipping', 'refundedTax', 'commissionCharged', 'refundedCommission', 'refundedAffiliateCommission', 'orderNetAmount'];
        $opSrch = new Report(0, $fields, true);
        $opSrch->joinOrders();
        $opSrch->joinPaymentMethod();
        $opSrch->joinOtherCharges(true, [OrderProduct::CHARGE_TYPE_DISCOUNT, OrderProduct::CHARGE_TYPE_REWARD_POINT_DISCOUNT]);
        $opSrch->joinOrderProductTaxCharges();
        $opSrch->joinOrderProductShipCharges();
        $opSrch->joinOrderProductDicountCharges();
        $opSrch->joinOrderProductVolumeCharges();
        $opSrch->joinOrderProductRewardCharges();
        $opSrch->setPaymentStatusCondition();
        $opSrch->setCompletedOrdersCondition();
        $opSrch->excludeDeletedOrdersCondition();
        $opSrch->addTotalOrdersCount('op_selprod_user_id');
        $opSrch->setGroupBy('shop_id');
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();

        $srch = new ShopSearch($this->adminLangId, false, false);
        $srch->joinShopOwner(false);
        $srch->addProductsCount();
        $srch->addReviewsCount();
        $srch->addRatingsCount();
        $srch->addFavoritesCount();
        $srch->joinTable('(' . $opSrch->getQuery() . ')', 'LEFT OUTER JOIN', 's.shop_id = opq.op_shop_id', 'opq');
        $srch->addMultipleFields(array('shop_id', 'shop_user_id', 's.shop_created_on', 'IFNULL(shop_name, shop_identifier) as shop_name', 'u.user_id', 'u.user_name as owner_name', 'u_cred.credential_email as owner_email', 'opq.*'));
        $srch->addOrder('shop_name');

        $shop_id = FatApp::getPostedData('shop_id', null, '');
        $shop_keyword = FatApp::getPostedData('shop_name', null, '');
        if ($shop_id) {
            $shop_id = FatUtility::int($shop_id);
            $srch->addCondition('s.shop_id', '=', $shop_id);
        }

        $shop_user_id = FatApp::getPostedData('shop_user_id', null, '');
        $shop_owner_keyword = FatApp::getPostedData('user_name', null, '');
        if ($shop_user_id) {
            $shop_user_id = FatUtility::int($shop_user_id);
            $srch->addCondition('s.shop_user_id', '=', $shop_user_id);
        }

        if ($shop_id == 0 and $shop_user_id == 0 and $shop_keyword != '') {
            $cond = $srch->addCondition('shop_name', '=', $shop_keyword);
            $cond->attachCondition('shop_name', 'like', '%' . $shop_keyword . '%', 'OR');
            $cond->attachCondition('shop_identifier', 'like', '%' . $shop_keyword . '%');
        }

        if ($shop_id == 0 and $shop_user_id == 0 and $shop_owner_keyword != '') {
            $cond1 = $srch->addCondition('user_name', '=', $shop_owner_keyword);
            $cond1->attachCondition('user_name', 'like', '%' . $shop_owner_keyword . '%', 'OR');
            $cond1->attachCondition('credential_email', 'like', '%' . $shop_owner_keyword . '%');
        }

        $date_from = FatApp::getPostedData('date_from', null, '');
        if ($date_from) {
            $srch->addCondition('s.shop_created_on', '>=', $date_from);
        }

        $date_to = FatApp::getPostedData('date_to', null, '');
        if ($date_to) {
            $srch->addCondition('s.shop_created_on', '<=', $date_to);
        }

        if ($type == 'export') {
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $rs = $srch->getResultSet();
            $sheetData = array();
            $arr = array(Labels::getLabel('LBL_Shop_Name', $this->adminLangId), Labels::getLabel('LBL_Created_Date', $this->adminLangId), Labels::getLabel('LBL_Owner_Name', $this->adminLangId), Labels::getLabel('LBL_Owner_Email', $this->adminLangId), Labels::getLabel('LBL_Items', $this->adminLangId), Labels::getLabel('LBL_Sold_Qty', $this->adminLangId), Labels::getLabel('LBL_Sales', $this->adminLangId), Labels::getLabel('LBL_Favorites', $this->adminLangId), Labels::getLabel('LBL_Site_Commission', $this->adminLangId), Labels::getLabel('LBL_Reviews', $this->adminLangId), Labels::getLabel('LBL_Rating', $this->adminLangId));
            array_push($sheetData, $arr);
            while ($row = $db->fetch($rs)) {
                $ownerName = $row['owner_name'];
                $ownerEmail = $row['owner_email'];
                $shopCreatedDate = FatDate::format($row['shop_created_on'], false, true, FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get()));
                $total = CommonHelper::displayMoneyFormat($row['total'], true, true);
                $commission = CommonHelper::displayMoneyFormat($row['commission'], true, true);
                $arr = array($row['shop_name'],  $shopCreatedDate, $ownerName, $ownerEmail, $row['totProducts'], $row['totSoldQty'], $total, $row['totalFavorites'], $commission, $row['totReviews'], round($row['totRating']));
                array_push($sheetData, $arr);
            }
            CommonHelper::convertToCsv($sheetData, 'Shops_Report_' . date("d-M-Y") . '.csv', ',');
            exit;
        } else {
            $srch->setPageNumber($page);
            $srch->setPageSize($pageSize);
            $rs = $srch->getResultSet();
            $arr_listing = $db->fetchAll($rs);
            $this->set("arr_listing", $arr_listing);
            $this->set('pageCount', $srch->pages());
            $this->set('recordCount', $srch->recordCount());
            $this->set('page', $page);
            $this->set('pageSize', $pageSize);
            $this->set('postedData', $post);
            $this->_template->render(false, false);
        }
    }

    public function export()
    {
        $this->search('export');
    }

    private function getSearchForm()
    {
        $frm = new Form('frmShopsReportSearch');
        $frm->addHiddenField('', 'page', 1);
        $frm->addTextBox(Labels::getLabel('LBL_Shop', $this->adminLangId), 'shop_name');
        $frm->addHiddenField('', 'shop_id', 0);
        $frm->addTextBox(Labels::getLabel('LBL_Shop_Owner', $this->adminLangId), 'user_name');
        $frm->addHiddenField('', 'shop_user_id', 0);
        $fld = $frm->addDateField(Labels::getLabel('LBL_Date_From', $this->adminLangId), 'date_from', '', array('readonly' => 'readonly'));
        $fld->htmlAfterField = Labels::getLabel('LBL_Shop_Created_date_from', $this->adminLangId);
        $fld = $frm->addDateField(Labels::getLabel('LBL_Date_To', $this->adminLangId), 'date_to', '', array('readonly' => 'readonly'));
        $fld->htmlAfterField = Labels::getLabel('LBL_Shop_Created_Date_To', $this->adminLangId);
        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }
}
