<?php

class OrderSubscriptionSearch extends SearchBase
{
    private $langId;
    private $isOrdersTableJoined;
    private $isOrderUserTableJoined;
    private $isOrderSubscriptionStatusJoined;
    private $commonLangId;

    public function __construct($langId = 0, $joinOrders = false, $joinOrderSuscriptionStatus = false)
    {
        parent::__construct(OrderSubscription::DB_TBL, 'oss');
        $this->langId = FatUtility::int($langId);
        $this->isOrdersTableJoined = false;
        $this->isOrderUserTableJoined = false;
        $this->isOrderSubscriptionStatusJoined = false;
        $this->commonLangId = CommonHelper::getLangId();
        if ($this->langId > 0) {
            $this->joinTable(
                OrderSubscription::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'oss_l.' . OrderSubscription::DB_TBL_LANG_PREFIX . 'ossubs_id = oss.' . OrderSubscription::DB_TBL_PREFIX . 'id
			AND oss_l.' . OrderSubscription::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'oss_l'
            );
        }

        if ($joinOrders) {
            $this->joinOrders();
        }

        if ($joinOrderSuscriptionStatus) {
            $this->joinOrderSuscriptionStatus($this->langId);
        }
    }

    public function joinOrderPaymentMethod($langId = 0)
    {
        $langId = FatUtility::int($langId);
        if ($this->langId) {
            $langId = $this->langId;
        }
        $this->joinTable(Plugin::DB_TBL, 'LEFT OUTER JOIN', 'o.order_pmethod_id = pm.plugin_id', 'pm');

        if ($langId) {
            $this->joinTable(Plugin::DB_TBL_LANG, 'LEFT OUTER JOIN', 'pm.plugin_id = pm_l.pluginlang_plugin_id AND pm_l.pluginlang_lang_id = ' . $langId, 'pm_l');
        }
    }
    public function joinOrders()
    {
        if ($this->isOrdersTableJoined) {
            trigger_error(Labels::getLabel('ERR_ORDERS_TABLE_IS_ALREADY_JOINED', $this->commonLangId), E_USER_ERROR);
        }
        $this->isOrdersTableJoined = true;
        $this->joinTable(Orders::DB_TBL, 'INNER JOIN', 'o.order_id = oss.' . OrderSubscription::DB_TBL_PREFIX . 'order_id', 'o');
    }
    public function addOrderProductCharges()
    {
        $srch = new SearchBase(OrderProduct::DB_TBL_CHARGES, 'opc');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(array('opcharge_op_id', 'sum(opcharge_amount) as op_other_charges'));
        $srch->addCondition(Orders::DB_TBL_CHARGES_PREFIX . 'order_type', '=', Orders::ORDER_SUBSCRIPTION);
        $srch->addGroupBy('opc.opcharge_op_id');
        $qryOtherCharges = $srch->getQuery();
        $this->joinTable('(' . $qryOtherCharges . ')', 'LEFT OUTER JOIN', 'oss.ossubs_id = opcc.opcharge_op_id', 'opcc');
    }
    public function joinOrderSuscriptionStatus($langId = 0)
    {
        $langId = FatUtility::int($langId);
        if ($this->langId) {
            $langId = $this->langId;
        }
        if ($this->isOrderSubscriptionStatusJoined) {
            trigger_error(Labels::getLabel('ERR_ORDERPRODUCT_STATUS_IS_ALREADY_JOINED', $this->commonLangId), E_USER_ERROR);
        }
        $this->isOrderSubscriptionStatusJoined = true;
        $this->joinTable(Orders::DB_TBL_ORDERS_STATUS, 'LEFT OUTER JOIN', 'os.orderstatus_id = oss.' . OrderSubscription::DB_TBL_PREFIX . 'status_id', 'os');
        if ($langId) {
            $this->joinTable(Orders::DB_TBL_ORDERS_STATUS_LANG, 'LEFT OUTER JOIN', 'os_l.orderstatuslang_orderstatus_id = os.orderstatus_id AND os_l.orderstatuslang_lang_id = ' . $langId, 'os_l');
        }
    }

    public function joinOrderUser()
    {
        if (!$this->isOrdersTableJoined) {
            trigger_error(Labels::getLabel('ERR_JOINORDERUSER_CAN_BE_JOINED_ONLY,_IF_JOINORDERS_IS_JOINED,_SO,_PLEASE_USE_JOINORDERS()_FIRST,_THEN_TRY_TO_JOIN_JOINORDERUSER', $this->commonLangId), E_USER_ERROR);
        }
        $this->joinTable(User::DB_TBL, 'INNER JOIN', 'ou.user_id = o.order_user_id', 'ou');
        $this->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'ou.user_id = ouc.credential_user_id', 'ouc');
        $this->isOrderUserTableJoined = true;
    }

    public function joinSubscription($langId = 0)
    {
        $langId = FatUtility::int($langId);
        if ($this->langId) {
            $langId = $this->langId;
        }
        $this->joinTable(SellerPackagePlans::DB_TBL, 'LEFT OUTER JOIN', 'spp.' . SellerPackagePlans::DB_TBL_PREFIX . 'id = oss.' . OrderSubscription::DB_TBL_PREFIX . 'plan_id ', 'spp');
    }

    public function joinPackage($langId = 0)
    {
        $this->joinTable(SellerPackages::DB_TBL, 'LEFT OUTER JOIN', 'spp.spplan_spackage_id = sp.spackage_id', 'sp');
        if ($langId > 0) {
            $this->joinTable(
                SellerPackages::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'sp_l.' . SellerPackages::DB_TBL_LANG_PREFIX . 'spackage_id = sp.' . SellerPackages::DB_TBL_PREFIX . 'id
			AND sp_l.' . SellerPackages::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'sp_l'
            );
        }
    }

    public function addCompletedOrderCondition()
    {
        $status = array_diff(unserialize(FatApp::getConfig("CONF_SELLER_SUBSCRIPTION_STATUS")), (array)FatApp::getConfig("CONF_SUBSCRIPTION_INACTIVE_ORDER_STATUS"));
        $this->addStatusCondition($status);
    }

    public function addStatusCondition($op_status)
    {
        if (is_array($op_status)) {
            if (!empty($op_status)) {
                $this->addCondition('oss.ossubs_status_id', 'IN', $op_status);
            } else {
                $this->addCondition('oss.ossubs_status_id', '=', 0);
            }
        } else {
            $op_status_id = FatUtility::int($op_status);
            $this->addCondition('oss.ossubs_status_id', '=', $op_status_id);
        }
    }
    public function addKeywordSearch($keyword)
    {
        $cnd = $this->addCondition('o.order_number', 'like', '%' . $keyword . '%');
        $cnd->attachCondition('oss.ossubs_invoice_number', 'like', '%' . $keyword . '%', 'OR');
        if ($this->isOrderUserTableJoined) {
            $cnd->attachCondition('ou.user_name', 'like', '%' . $keyword . '%', 'OR');
            $cnd->attachCondition('ouc.credential_email', 'like', '%' . $keyword . '%', 'OR');
        }
        if ($this->langId) {
            $cnd->attachCondition('ossubs_subscription_name', 'like', '%' . $keyword . '%', 'OR');
        }
    }

    public function addDateFromCondition($dateFrom)
    {
        $dateFrom = FatDate::convertDatetimeToTimestamp($dateFrom);
        $dateFrom = date('Y-m-d', strtotime($dateFrom));

        if (!$this->isOrdersTableJoined) {
            trigger_error(Labels::getLabel('ERR_ORDER_DATE_CONDITION_CANNOT_BE_APPLIED,_AS_ORDERS_TABLE_IS_NOT_JOINED,_SO,_PLEASE_USE_JOINORDERS()_FIRST,_THEN_TRY_TO_ADD_ORDER_DATE_FROM_CONDITION', $this->commonLangId), E_USER_ERROR);
        }
        if ($dateFrom != '') {
            $this->addCondition('o.order_date_added', '>=', $dateFrom . ' 00:00:00');
        }
    }

    public function addDateToCondition($dateTo)
    {
        $dateTo = FatDate::convertDatetimeToTimestamp($dateTo);
        $dateTo = date('Y-m-d', strtotime($dateTo));

        if (!$this->isOrdersTableJoined) {
            trigger_error(Labels::getLabel('ERR_ORDER_DATE_CONDITION_CANNOT_BE_APPLIED,_AS_ORDERS_TABLE_IS_NOT_JOINED,_SO,_PLEASE_USE_JOINORDERS()_FIRST,_THEN_TRY_TO_ADD_ORDER_DATE_TO_CONDITION', $this->commonLangId), E_USER_ERROR);
        }
        if ($dateTo != '') {
            $this->addCondition('o.order_date_added', '<=', $dateTo . ' 23:59:59');
        }
    }
    public function addMinPriceCondition($priceFrom)
    {
        if (!$this->isOrdersTableJoined) {
            trigger_error(Labels::getLabel('ERR_ORDER_PRICE_CONDITION_CANNOT_BE_APPLIED,_AS_ORDERS_TABLE_IS_NOT_JOINED,_SO,_PLEASE_USE_JOINORDERS()_FIRST,_THEN_TRY_TO_ADD_ORDER_PRICE_CONDITION', $this->commonLangId), E_USER_ERROR);
        }
        $this->addCondition('o.order_net_amount', '>=', $priceFrom);
    }

    public function addMaxPriceCondition($priceTo)
    {
        if (!$this->isOrdersTableJoined) {
            trigger_error(Labels::getLabel('ERR_ORDER_PRICE_CONDITION_CANNOT_BE_APPLIED,_AS_ORDERS_TABLE_IS_NOT_JOINED,_SO,_PLEASE_USE_JOINORDERS()_FIRST,_THEN_TRY_TO_ADD_ORDER_PRICE_CONDITION', $this->commonLangId), E_USER_ERROR);
        }
        $this->addCondition('o.order_net_amount', '<=', $priceTo);
    }

    public function joinOtherCharges()
    {
        $srch = new SearchBase(OrderProduct::DB_TBL_CHARGES, 'opc');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('opcharge_order_type', '=', Orders::ORDER_SUBSCRIPTION);
        $srch->addMultipleFields(array('opcharge_op_id', 'sum(opcharge_amount) as op_other_charges'));
        $srch->addGroupBy('opc.opcharge_op_id');

        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'oss.ossubs_id = opcc.opcharge_op_id', 'opcc');
    }

    public function joinWithCurrentSubscription()
    {
        $srch = new SearchBase(Orders::DB_TBL, 'o');
        $srch->addCondition('o.order_type', '=', Orders::ORDER_SUBSCRIPTION);
        $srch->addCondition('o.order_payment_status', '=', Orders::ORDER_PAYMENT_PAID);
        $srch->joinTable(Orders::DB_TBL, 'LEFT OUTER JOIN', 'o_temp.order_date_added > o.order_date_added and o_temp.order_user_id = o.order_user_id and o_temp.order_type = ' . Orders::ORDER_SUBSCRIPTION . ' and o_temp.order_payment_status = ' . Orders::ORDER_PAYMENT_PAID, 'o_temp');
        $srch->addMultipleFields(['COALESCE(o_temp.order_id, o.order_id) as currentOrderId']);
        $srch->addGroupBy('o.order_id');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('o_temp.order_id', 'is', 'mysql_func_NULL', 'AND', true);
        $this->joinTable('(' . $srch->getQuery() . ')', 'INNER JOIN', 'oscurr.currentOrderId = oss.ossubs_order_id', 'oscurr');
    }

    public function includeCount()
    {
        $srch = new OrderSubscriptionSearch(0, true, true);
        $srch->joinSubscription();
        $srch->joinOrderUser();
        $srch->joinOtherCharges();
        $srch->addCondition('o.order_type', '=', Orders::ORDER_SUBSCRIPTION);
        $srch->addGroupBy('o.order_user_id');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCompletedOrderCondition();
        $srch->addMultipleFields(['o.order_user_id', 'sum(if(order_payment_status = ' . Orders::ORDER_PAYMENT_PAID . ', oss.ossubs_price + ifnull(op_other_charges,0), 0)) as subscriptionCharges', 'count(DISTINCT(if(o.order_renew = 1 and order_payment_status = ' . Orders::ORDER_PAYMENT_PAID . ', o.order_id, null))) as spRenewals', 'count(DISTINCT(if(oss.ossubs_status_id = ' . OrderSubscription::CANCELLED_SUBSCRIPTION . ', o.order_id, null))) as spackageCancelled']);
        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT JOIN', 'subscount.order_user_id = o.order_user_id', 'subscount');
    }
}
