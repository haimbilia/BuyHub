<?php

class OrderSearch extends SearchBase
{
    private $langId;
    private $isOrderBuyerUserJoined;
    public function __construct($langId = 0)
    {
        parent::__construct(Orders::DB_TBL, 'o');
        $this->langId = FatUtility::int($langId);
        $this->isOrderBuyerUserJoined = false;

        if ($this->langId > 0) {
            $this->joinTable(
                Orders::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'orderlang_order_id = o.order_id AND orderlang_lang_id = ' . $this->langId,
                'o_l'
            );
        }
    }

    public function joinOrderBuyerUser()
    {
        $this->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'o.order_user_id = buyer.user_id', 'buyer');
        $this->joinTable(user::DB_TBL_CRED, 'LEFT OUTER JOIN', 'buyer.user_id = buyer_cred.credential_user_id', 'buyer_cred');
        $this->isOrderBuyerUserJoined = true;
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

    public function addKeywordSearch($keyword, $orderType = -1)
    {
        $cnd = $this->addCondition('order_number', 'like', '%' . $keyword . '%');
        if ($this->isOrderBuyerUserJoined) {
            $cnd->attachCondition('buyer.user_name', 'like', '%' . $keyword . '%', 'OR');
            $cnd->attachCondition('buyer_cred.credential_username', 'like', '%' . $keyword . '%', 'OR');
            $cnd->attachCondition('buyer_cred.credential_email', 'like', '%' . $keyword . '%', 'OR');
        }
        if ($orderType >= 0 && $orderType == Orders::ORDER_GIFT_CARD) {
            $cnd->attachCondition('ogcards.ogcards_receiver_name', 'like', '%' . $keyword . '%', 'OR');
            $cnd->attachCondition('ogcards.ogcards_receiver_email', 'like', '%' . $keyword . '%', 'OR');
        }
    }

    public function addDateFromCondition($dateFrom)
    {
        $dateFrom = FatDate::convertDatetimeToTimestamp($dateFrom);
        $dateFrom = date('Y-m-d', strtotime($dateFrom));

        if ($dateFrom != '') {
            $this->addCondition('o.order_date_added', '>=', $dateFrom . ' 00:00:00');
        }
    }

    public function addDateToCondition($dateTo)
    {
        $dateTo = FatDate::convertDatetimeToTimestamp($dateTo);
        $dateTo = date('Y-m-d', strtotime($dateTo));

        if ($dateTo != '') {
            $this->addCondition('o.order_date_added', '<=', $dateTo . ' 23:59:59');
        }
    }

    public function addMinPriceCondition($priceFrom)
    {
        $this->addCondition('o.order_net_amount', '>=', $priceFrom);
    }

    public function addMaxPriceCondition($priceTo)
    {
        $this->addCondition('o.order_net_amount', '<=', $priceTo);
    }
    /* For Subscription Module */
    public function addSubscriptionValidCondition($date = '')
    {
        if ($date == '') {
            $date = date("Y-m-d");
        }
        $this->addCondition('oss.ossubs_till_date', '>=', $date);
    }

    public function joinTableOrderSellerSubscription($langId = 0)
    {
        $this->joinTable(OrderSubscription::DB_TBL, 'LEFT OUTER JOIN', 'oss.ossubs_order_id = o.order_id', 'oss');
        if ($langId > 0) {
            $this->joinTable(OrderSubscription::DB_TBL_LANG, 'LEFT OUTER JOIN', 'oss.ossubs_id = ossl.' . OrderSubscription::DB_TBL_LANG_PREFIX . 'ossubs_id', 'ossl');
        }
    }
    public function joinTableSubscriptionPlan()
    {
        $this->joinTable(SellerPackagePlans::DB_TBL, 'LEFT OUTER JOIN', 'oss.ossubs_plan_id = spp.spplan_id', 'spp');
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

    public function joinOrderProduct($langId = 0)
    {
        $langId = 0 < $langId ? $langId : $this->langId;

        $this->joinTable(Orders::DB_TBL_ORDER_PRODUCTS, 'LEFT OUTER JOIN', 'op.op_order_id = o.order_id', 'op');
        if ($langId > 0) {
            $this->joinTable(Orders::DB_TBL_ORDER_PRODUCTS_LANG, 'LEFT OUTER JOIN', 'torp_l.oplang_op_id = op.op_id and torp_l.oplang_lang_id = ' . $langId, 'torp_l');
        }
    }

    public function joinOrderProductShipping()
    {
        $this->joinTable(Orders::DB_TBL_ORDER_PRODUCTS_SHIPPING, 'LEFT OUTER JOIN', 'ops.opshipping_op_id = op.op_id', 'ops');
    }

    public function joinSellerProduct()
    {
        $this->joinTable(SellerProduct::DB_TBL, 'LEFT OUTER JOIN', 'sp.selprod_id = op.op_selprod_id and op.op_is_batch = 0', 'sp');
    }
}
