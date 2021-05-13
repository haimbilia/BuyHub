<?php

class UsersReportController extends AdminBaseController
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
        $this->_template->render();
    }

    public function search($type = false)
    {
        $usertype = FatApp::getPostedData('user_type', FatUtility::VAR_INT, User::USER_TYPE_BUYER);
        $this->validateViewPermission($usertype);

        $post = FatApp::getPostedData();

        $fields = $this->getFormColumns($usertype);
        $srchFrm = $this->getSearchForm($fields, $usertype);

        $post = $srchFrm->getFormDataFromArray(FatApp::getPostedData());
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : intval($post['page']);
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
        $rSrch->removeFld(['name', 'user_regdate', 'referrerName', 'user_referral_code', 'rewardsPoints', 'rewardsPointsEarned', 'rewardsPointsRedeemed', 'credential_verified', 'availableBalance', 'totRating','promotionCharged']);

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
                break;
            default:
                $srch->joinReferrerUser();
                $srch->includeRewardsCount();
                $srch->addFld('uref.user_name as referrerName');
                $srch->addFld('uref_c.credential_email as referrerEmail');
                $srch->addFld('urpbal.*');

                $rSrch->addTotalOrdersCount('order_user_id');
                $rSrch->setGroupBy('order_user_id');
                $srch->joinTable('(' . $rSrch->getQuery() . ')', 'LEFT OUTER JOIN', 'u.user_id = opq.order_user_id', 'opq');
                break;
        }

        $srch->addMultipleFields(['u.user_name as name', 'uc.credential_email as email', 'u.user_city', 'u.user_zip', 'u.user_address1 as user_address', 'u.user_regdate', 'u.user_referral_code', 'uc.credential_verified','pchagres.promotionCharged', 'opq.*']);

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
                        case 'netSoldQty':
                        case 'orderNetAmount':
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
        $this->set('usertype', $usertype);
        $this->_template->render(false, false);
    }

    public function export()
    {
        $this->search('export');
    }

    private function getSearchForm($fields = [], $usertype = User::USER_TYPE_BUYER)
    {
        $frm = new Form('frmReportSearch');
        $frm->addHiddenField('', 'page', 1);
        $frm->addHiddenField('', 'user_type', $usertype);
        $frm->addDateField(Labels::getLabel('LBL_Reg._Date_From', $this->adminLangId), 'date_from', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addDateField(Labels::getLabel('LBL_Reg._Date_To', $this->adminLangId), 'date_to', '', array('readonly' => 'readonly', 'class' => 'small dateTimeFld field--calender'));
        $frm->addTextBox(Labels::getLabel('LBL_Name_Or_Email', $this->adminLangId), 'keyword', '', array('id' => 'keyword', 'autocomplete' => 'off'));

        if (!empty($fields)) {
            $frm->addSelectBox(Labels::getLabel("LBL_Sort_By", $this->adminLangId), 'sortBy', $fields, '', array(), '');

            $frm->addSelectBox(Labels::getLabel("LBL_Sort_Order", $this->adminLangId), 'sortOrder', applicationConstants::sortOrder($this->adminLangId), 0, array(),  '');
        }

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Search', $this->adminLangId));
        $fld_cancel = $frm->addButton("", "btn_clear", Labels::getLabel('LBL_Clear_Search', $this->adminLangId), array('onclick' => 'clearSearch();'));
        $fld_submit->attachField($fld_cancel);

        return $frm;
    }

    private function getFormColumns($userType = User::USER_TYPE_BUYER)
    {
        $buyerUserReportsCacheVar = FatCache::get('buyerUserReportsCacheVar' . $userType . '-' . $this->adminLangId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$buyerUserReportsCacheVar) {
            $arr = [
                'name' => Labels::getLabel('LBL_Name', $this->adminLangId),
                /* 'email' => Labels::getLabel('LBL_Email', $this->adminLangId), */
                /*  'user_address' => Labels::getLabel('LBL_Address', $this->adminLangId), */
                'user_regdate' => Labels::getLabel('LBL_Registration_Date', $this->adminLangId)
            ];

            switch ($userType) {
                case User::USER_TYPE_SELLER:
                    $arr = $arr + [
                        'credential_verified' => Labels::getLabel('LBL_Verified', $this->adminLangId),
                        'totOrders' => Labels::getLabel('LBL_Order_Placed', $this->adminLangId),
                        'totQtys' => Labels::getLabel('LBL_Ordered_Qty', $this->adminLangId),
                        'totRefundedQtys' => Labels::getLabel('LBL_Refunded_Qty', $this->adminLangId),
                        'refundedAmount' => Labels::getLabel('LBL_Refunded_Amount', $this->adminLangId),
                        'orderNetAmount' => Labels::getLabel('LBL_Net_Amount', $this->adminLangId),
                        'availableBalance' => Labels::getLabel('LBL_Wallet_Balance', $this->adminLangId),
                        'promotionCharged'        =>    Labels::getLabel('LBL_Promotion_Charged', $this->adminLangId),
                        'totRating'        =>    Labels::getLabel('LBL_Rating', $this->adminLangId),
                    ];
                    break;
                default:
                    $arr = $arr + [
                        'referrerName' => Labels::getLabel('LBL_Referrer', $this->adminLangId),
                        'user_referral_code' => Labels::getLabel('LBL_Referral_Code', $this->adminLangId),
                        'rewardsPoints' => Labels::getLabel('LBL_Rewards_Balance', $this->adminLangId),
                        'rewardsPointsEarned' => Labels::getLabel('LBL_Rewards_Earned', $this->adminLangId),
                        'rewardsPointsRedeemed' => Labels::getLabel('LBL_Rewards_Redeemed', $this->adminLangId),
                        'netSoldQty' => Labels::getLabel('LBL_Item_Purchased', $this->adminLangId),
                        'orderNetAmount' => Labels::getLabel('LBL_Total_Purchase', $this->adminLangId),
                        'availableBalance' => Labels::getLabel('LBL_Wallet_Balance', $this->adminLangId)
                    ];
                    break;
            }
            FatCache::set('buyerUserReportsCacheVar' . $userType . '-' . $this->adminLangId, serialize($arr), '.txt');
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
