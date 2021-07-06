<?php

class ShopsReportController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewShopsReport();
    }

    public function index()
    {
        $fields = $this->getFormColumns();
        $frmSearch = $this->getSearchForm($fields);
        $this->set('frmSearch', $frmSearch);
        $this->set('defaultColumns', $this->getDefaultColumns());
        $this->set('fields', $fields);
        $this->_template->render();
    }

    public function search($type = false)
    {
        $this->objPrivilege->canViewShopsReport();
        $db = FatApp::getDb();

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
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        if ($page < 2) {
            $page = 1;
        }
        $pageSize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        /* $fields = ['totOrders', 'totQtys', 'totRefundedQtys', 'netSoldQty', 'grossSales', 'transactionAmount', 'inventoryValue', 'taxTotal', 'sellerTaxTotal', 'adminTaxTotal', 'shippingTotal', 'sellerShippingTotal', 'adminShippingTotal', 'couponDiscount', 'volumeDiscount', 'rewardDiscount', 'adminSalesEarnings', 'refundedAmount', 'refundedShipping', 'refundedTax', 'commissionCharged', 'refundedCommission', 'refundedAffiliateCommission', 'orderNetAmount', 'refundedTaxToSeller', 'refundedShippingToSeller']; */
        $opSrch = new Report(0, array_keys($fields), true);
        $opSrch->joinOrders();
        $opSrch->joinPaymentMethod();
        $opSrch->joinOtherCharges(true);
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
        $opSrch->removeFld(['shop_name', 'shop_owner', 'owner_name', 'totProducts', 'totalFavorites', 'totReviews', 'totRating']);

        $srch = new ShopSearch($this->adminLangId, false, false);
        $srch->joinShopOwner(false);
        $srch->addProductsCount();
        $srch->addReviewsCount();
        $srch->addRatingsCount();
        $srch->addFavoritesCount();
        $srch->joinTable('(' . $opSrch->getQuery() . ')', 'LEFT OUTER JOIN', 's.shop_id = opq.op_shop_id', 'opq');
        $srch->addMultipleFields(array('shop_id', 'shop_user_id', 's.shop_created_on', 'IFNULL(shop_name, shop_identifier) as shop_name', 'u.user_id', 'u.user_name as owner_name', 'u_cred.credential_email as owner_email', 'opq.*'));

        if (!array_key_exists($sortOrder, applicationConstants::sortOrder(CommonHelper::getLangId()))) {
            $sortOrder = applicationConstants::SORT_ASC;
        }

        switch ($sortBy) {
            default:
                $srch->addOrder($sortBy, $sortOrder);
                break;
        }

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
            array_push($sheetData, array_values($fields));
            while ($row = $db->fetch($rs)) {
                $arr = [];
                foreach ($fields as $key => $val) {
                    switch ($key) {
                        case 'shop_name':
                            $name = $row['shop_name'];
                            $name .= "\nCreated On: " . FatDate::format($row['shop_created_on'], false, true, FatApp::getConfig('CONF_TIMEZONE', FatUtility::VAR_STRING, date_default_timezone_get()));
                            $arr[] = $name;
                            break;
                        case 'owner_name':
                            $name = $row['owner_name'] . '(' . $row['owner_email'] . ')';
                            $arr[] = $name;
                            break;
                        case 'grossSales':
                        case 'transactionAmount':
                        case 'inventoryValue':
                        case 'taxTotal':
                        case 'adminTaxTotal':
                        case 'sellerTaxTotal':
                        case 'shippingTotal':
                        case 'sellerShippingTotal':
                        case 'adminShippingTotal':
                        case 'discountTotal':
                        case 'couponDiscount':
                        case 'volumeDiscount':
                        case 'rewardDiscount':
                        case 'refundedAmount':
                        case 'refundedShipping':
                        case 'refundedTax':
                        case 'orderNetAmount':
                        case 'commissionCharged':
                        case 'refundedCommission':
                        case 'adminSalesEarnings':
                            $arr[] = CommonHelper::displayMoneyFormat($row[$key], true, true, false);
                            break;
                        default:
                            $arr[] = $row[$key];
                            break;
                    }
                }

                array_push($sheetData, $arr);
            }
            
            CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Shops_Report', $this->adminLangId) . ' ' . date("d-M-Y") . '.csv', ',');
            exit;
        } else {
            $srch->setPageNumber($page);
            $srch->setPageSize($pageSize);
            $rs = $srch->getResultSet();
            $arrListing = $db->fetchAll($rs);

            $this->set("arrListing", $arrListing);
            $this->set('pageCount', $srch->pages());
            $this->set('recordCount', $srch->recordCount());
            $this->set('page', $page);
            $this->set('pageSize', $pageSize);
            $this->set('postedData', $post);
            $this->set('sortBy', $sortBy);
            $this->set('sortOrder', $sortOrder);
            $this->set('fields', $fields);
            $this->_template->render(false, false);
        }
    }

    public function export()
    {
        $this->search('export');
    }

    private function getSearchForm($fields = [])
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
        if (!empty($fields)) {
            $frm->addHiddenField('', 'sortBy', 'shop_name');
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
        $shopsReportCacheVar = FatCache::get('shopsReportCacheVar' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$shopsReportCacheVar) {
            $arr = [
                'shop_name'        =>    Labels::getLabel('LBL_Name', $this->adminLangId),
                'owner_name'    =>    Labels::getLabel('LBL_Owner', $this->adminLangId),
                'totProducts'    => Labels::getLabel('LBL_Items', $this->adminLangId),
                'totOrders' => Labels::getLabel('LBL_Order_Placed', $this->adminLangId),
                'totQtys' => Labels::getLabel('LBL_Ordered_Qty', $this->adminLangId),
                'totRefundedQtys' => Labels::getLabel('LBL_Refunded_Qty', $this->adminLangId),
                'netSoldQty' => Labels::getLabel('LBL_Sold_Qty', $this->adminLangId),
                'grossSales' => Labels::getLabel('LBL_Gross_Sale', $this->adminLangId),
                'transactionAmount' => Labels::getLabel('LBL_Transaction_Amount', $this->adminLangId),
                'inventoryValue' => Labels::getLabel('LBL_Inventory_Value', $this->adminLangId),

                // 'taxTotal' => Labels::getLabel('LBL_Tax_Charged', $this->adminLangId),
                'sellerTaxTotal' => Labels::getLabel('LBL_Tax_Charged', $this->adminLangId),
                // 'adminTaxTotal' => Labels::getLabel('LBL_Tax_Charged_by_Admin', $this->adminLangId),

                // 'shippingTotal' => Labels::getLabel('LBL_Shipping_Charged', $this->adminLangId),
                'sellerShippingTotal' => Labels::getLabel('LBL_Shipping_Charged', $this->adminLangId),
                // 'adminShippingTotal' => Labels::getLabel('LBL_Shipping_Charged_by_Admin', $this->adminLangId),

                // 'couponDiscount' => Labels::getLabel('LBL_Coupon_Discount', $this->adminLangId),
                'volumeDiscount' => Labels::getLabel('LBL_Volume_Discount', $this->adminLangId),
                // 'rewardDiscount' => Labels::getLabel('LBL_Reward_Discount', $this->adminLangId),

                'refundedAmount' => Labels::getLabel('LBL_Refunded_Amount', $this->adminLangId),
                // 'refundedShipping' => Labels::getLabel('LBL_Refunded_Shipping', $this->adminLangId),
                'refundedShippingFromSeller' => Labels::getLabel('LBL_Refunded_Shipping', $this->adminLangId),
                // 'refundedTax' => Labels::getLabel('LBL_Refunded_Tax', $this->adminLangId),
                'refundedTaxFromSeller' => Labels::getLabel('LBL_Refunded_Tax', $this->adminLangId),

                'commissionCharged' => Labels::getLabel('LBL_Commision_Charged', $this->adminLangId),
                'refundedCommission' => Labels::getLabel('LBL_Refunded_Commision', $this->adminLangId),
                'adminSalesEarnings' => Labels::getLabel('LBL_Admin_Earnings', $this->adminLangId),
                'totalFavorites' =>    Labels::getLabel('LBL_Favorites', $this->adminLangId),
                'totReviews'    =>    Labels::getLabel('LBL_Reviews', $this->adminLangId),
                'totRating'        =>    Labels::getLabel('LBL_Rating', $this->adminLangId),
            ];
            FatCache::set('shopsReportCacheVar' . $this->adminLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($shopsReportCacheVar);
        }

        return $arr;
    }

    private function getDefaultColumns(): array
    {
        return ['shop_name', 'owner_name', 'netSoldQty', 'grossSales', 'refundedAmount', 'sellerTaxTotal', 'sellerShippingTotal', 'volumeDiscount', 'adminSalesEarnings'];
    }
}
