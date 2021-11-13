<?php

class UsersReportController extends ListingBaseController
{

    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function index($usertype = User::USER_TYPE_BUYER)
    {
        $this->validateViewPermission($usertype);
        $flds = $this->getFormColumns($usertype);
        $frmSearch = $this->getSearchForm($flds, $usertype);
        // $frmSearch->fill(array('sortBy' => 'totOrders', 'sortOrder' => 'DESC'));
        $this->set('frmSearch', $frmSearch);
        $this->set('usertype', $usertype);
        $this->_template->addJs('js/report.js');
        $this->_template->render();
    }

    public function search($type = false)
    {
        $usertype = FatApp::getPostedData('user_type', FatUtility::VAR_INT, User::USER_TYPE_BUYER);
        $this->validateViewPermission($usertype);

        $fields = $this->getFormColumns($usertype);
        $srchFrm = $this->getSearchForm($fields, $usertype);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $page = ($page <= 0) ? 1 : $page;
        $pagesize = FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);

        $sortBy = FatApp::getPostedData('sortBy', FatUtility::VAR_STRING, 'name');
        $sortOrder = FatApp::getPostedData('sortOrder', FatUtility::VAR_STRING, 'DESC');

        $shopSpecific = ($usertype == User::USER_TYPE_SELLER) ? true : false;

        $rSrch = new Report(0, array_keys($fields), $shopSpecific);
        $rSrch->joinOrders();
        $rSrch->joinPaymentMethod();
        $rSrch->joinOtherCharges(true);
        $rSrch->setPaymentStatusCondition();
        $rSrch->setCompletedOrdersCondition();
        $rSrch->excludeDeletedOrdersCondition();
        $rSrch->doNotCalculateRecords();
        $rSrch->doNotLimitRecords();
        $rSrch->removeFld(['name', 'user_regdate', 'referrerName', 'user_referral_code', 'rewardsPoints', 'rewardsPointsEarned', 'rewardsPointsRedeemed', 'credential_verified', 'availableBalance', 'totRating', 'promotionCharged']);

        $srch = new UserSearch();
        $srch->includeTransactionBalance();
        $srch->includePromotionCharges();
        $srch->addRatingsCount();
        switch ($usertype) {
            case  User::USER_TYPE_SELLER:
                $rSrch->joinOrderProductTaxCharges();
                $rSrch->joinOrderProductShipCharges();
                $rSrch->addTotalOrdersCount('op_selprod_user_id');
                $rSrch->setGroupBy('op_selprod_user_id');
                $srch->joinTable('(' . $rSrch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = opq.op_selprod_user_id', 'opq');
                $srch->addFld(['pchagres.promotionCharged']);
                $srch->addCondition('u.user_is_supplier', '=', applicationConstants::YES);
                break;
            default:
                $srch->joinReferrerUser();
                $srch->includeRewardsCount();
                $srch->addFld(['uref.user_name as referrerName', 'uref_c.credential_email as referrerEmail', 'urpbal.*']);
                $srch->addCondition('u.user_is_buyer', '=', applicationConstants::YES);

                $rSrch->addTotalOrdersCount('order_user_id');
                $rSrch->setGroupBy('order_user_id');
                $srch->joinTable('(' . $rSrch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = opq.order_user_id', 'opq');
                break;
        }

        $srch->addMultipleFields(['u.user_name as name', 'uc.credential_email as email', 'u.user_city', 'u.user_zip', 'u.user_address1 as user_address', 'u.user_regdate', 'u.user_referral_code', 'uc.credential_verified',  'opq.*']);

        $date_from = FatApp::getPostedData('date_from', FatUtility::VAR_DATE, '');
        if (!empty($date_from)) {
            $srch->addCondition('u.user_regdate', '>=', $date_from . ' 00:00:00');
        }

        $date_to = FatApp::getPostedData('date_to', FatUtility::VAR_DATE, '');
        if (!empty($date_to)) {
            $srch->addCondition('u.user_regdate', '<=', $date_to . ' 23:59:59');
        }

        $keyword = FatApp::getPostedData('keyword', null, '');
        if (!empty($keyword)) {
            $cond = $srch->addCondition('uc.credential_username', '=', $keyword);
            $cond->attachCondition('uc.credential_email', 'like', '%' . $keyword . '%', 'OR');
            $cond->attachCondition('u.user_name', 'like', '%' . $keyword . '%');
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
                        case 'name':
                            $name = $row['name'] . "\n" . $row['email'];
                            $arr[] = $name;
                            break;
                        case 'orderNetAmount':
                        case 'promotionCharged':
                        case 'availableBalance':
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

            CommonHelper::convertToCsv($sheetData, Labels::getLabel('LBL_Buyers/Seller_Sales_Report', $this->siteLangId) . '_' . date("d-M-Y") . '.csv', ',');
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
        $this->set('usertype', $usertype);
        $this->_template->render(false, false);
    }

    public function export()
    {
        $this->search('export');
    }

    public function getSearchForm($fields = [], $usertype = User::USER_TYPE_BUYER)
    {
        $frm = new Form('frmReportSearch');
        $frm->addHiddenField('', 'page', 1);
        $frm->addHiddenField('', 'user_type', $usertype);
        $frm->addDateField(Labels::getLabel('LBL_Reg._Date_From', $this->siteLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('LBL_Reg._Date_To', $this->siteLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addTextBox(Labels::getLabel('LBL_Name_Or_Email', $this->siteLangId), 'keyword', '', array('id' => 'keyword', 'autocomplete' => 'off'));

        if (!empty($fields)) {
            $frm->addSelectBox(Labels::getLabel("LBL_Sort_By", $this->siteLangId), 'sortBy', $fields, '', array(), '');

            $frm->addSelectBox(Labels::getLabel("LBL_Sort_Order", $this->siteLangId), 'sortOrder', applicationConstants::sortOrder($this->siteLangId), 0, array(),  '');
        }

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->siteLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_CLEAR', $this->siteLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);

        return $frm;
    }

    protected function getFormColumns($userType = User::USER_TYPE_BUYER)
    {
        $buyerUserReportsCacheVar = FatCache::get('buyerUserReportsCacheVar' . $userType . '-' . $this->siteLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$buyerUserReportsCacheVar) {
            $arr = [
                'name' => Labels::getLabel('LBL_Name', $this->siteLangId),
                /* 'email' => Labels::getLabel('LBL_Email', $this->siteLangId), */
                /*  'user_address' => Labels::getLabel('LBL_Address', $this->siteLangId), */
                'user_regdate' => Labels::getLabel('LBL_Registration_Date', $this->siteLangId)
            ];

            switch ($userType) {
                case User::USER_TYPE_SELLER:
                    $arr = $arr + [
                        'credential_verified' => Labels::getLabel('LBL_Verified', $this->siteLangId),
                        'totOrders' => Labels::getLabel('LBL_Order_Placed', $this->siteLangId),
                        'totQtys' => Labels::getLabel('LBL_Ordered_Qty', $this->siteLangId),
                        'totRefundedQtys' => Labels::getLabel('LBL_Refunded_Qty', $this->siteLangId),
                        'refundedAmount' => Labels::getLabel('LBL_Refunded_Amount', $this->siteLangId),
                        'orderNetAmount' => Labels::getLabel('LBL_Net_Amount', $this->siteLangId),
                        'availableBalance' => Labels::getLabel('LBL_Available_Balance', $this->siteLangId),
                        'promotionCharged'        =>    Labels::getLabel('LBL_Promotion_Charged', $this->siteLangId),
                        'totRating'        =>    Labels::getLabel('LBL_Rating', $this->siteLangId),
                    ];
                    break;
                default:
                    $arr = $arr + [
                        'referrerName' => Labels::getLabel('LBL_Referrer', $this->siteLangId),
                        'user_referral_code' => Labels::getLabel('LBL_Referral_Code', $this->siteLangId),
                        'rewardsPoints' => Labels::getLabel('LBL_Rewards_Balance', $this->siteLangId),
                        'rewardsPointsEarned' => Labels::getLabel('LBL_Rewards_Earned', $this->siteLangId),
                        'rewardsPointsRedeemed' => Labels::getLabel('LBL_Rewards_Redeemed', $this->siteLangId),
                        'netSoldQty' => Labels::getLabel('LBL_Item_Purchased', $this->siteLangId),
                        'orderNetAmount' => Labels::getLabel('LBL_Total_Purchase', $this->siteLangId),
                        'availableBalance' => Labels::getLabel('LBL_Available_Balance', $this->siteLangId)
                    ];
                    break;
            }
            FatCache::set('buyerUserReportsCacheVar' . $userType . '-' . $this->siteLangId, serialize($arr), '.txt');
        } else {
            $arr =  unserialize($buyerUserReportsCacheVar);
        }

        return $arr;
    }

    private function validateViewPermission($usertype = User::USER_TYPE_BUYER)
    {
        switch ($usertype) {
            case User::USER_TYPE_SELLER;
                $this->objPrivilege->canViewSellersReport($this->admin_id);
                break;
            default:
                $this->objPrivilege->canViewUsersReport($this->admin_id);
                break;
        }
    }
}
