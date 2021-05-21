<?php

class SellerPackagePlansSearch extends SearchBase
{
    private $langId;

    public function __construct()
    {
        parent::__construct(SellerPackagePlans::DB_TBL, 'spp');
    }

    public function joinPackage($langId = 0)
    {
        $this->joinTable(SellerPackages::DB_TBL, 'LEFT OUTER JOIN', 'spp.' . SellerPackagePlans::DB_TBL_PREFIX . 'spackage_id=sp.' . SellerPackages::DB_TBL_PREFIX . 'id', 'sp');
        if ($langId) {
            $this->joinTable(
                SellerPackages::DB_TBL . '_lang',
                'LEFT OUTER JOIN',
                'spl.spackagelang_spackage_id = sp.spackage_id AND spl.spackagelang_lang_id = ' . $langId,
                'spl'
            );
        }
    }

    public function includeCount(int $langId = 0)
    {
        $srch = new OrderSubscriptionSearch($langId, true, true);
        $srch->joinSubscription();
        $srch->addGroupBy('ossubs_plan_id');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(['ossubs_plan_id', 'count(DISTINCT(if(ossubs_status_id = ' . OrderSubscription::ACTIVE_SUBSCRIPTION . ' and ossubs_till_date >= "' . date('Y-m-d') . '", order_user_id, null))) as activeSubscribers', 'count(DISTINCT(if(ossubs_status_id = ' . OrderSubscription::CANCELLED_SUBSCRIPTION . ', order_user_id, null))) as spackageCancelled', 'count(DISTINCT(if(order_payment_status = ' . Orders::ORDER_PAYMENT_PAID . ',order_id,null))) as spackageSold', 'count(DISTINCT(if(order_renew = 0 and order_payment_status = ' . Orders::ORDER_PAYMENT_PAID . ' and ossubs_till_date <= "' . date('Y-m-d') . '", order_id, null))) as spRenewalPendings', 'count(DISTINCT(if(order_renew = 1 and order_payment_status = ' . Orders::ORDER_PAYMENT_PAID . ', order_id, null))) as spRenewals']);
        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'spp.spplan_id = spas.ossubs_plan_id', 'spas');
    }

    public function joinUser()
    {
        $this->joinTable(User::DB_TBL, 'INNER JOIN', 'order_user_id = seller_user.user_id and seller_user.user_is_supplier = ' . applicationConstants::YES . ' AND seller_user.user_deleted = ' . applicationConstants::NO, 'seller_user');
        $this->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'credential_user_id = seller_user.user_id and credential_active = ' . applicationConstants::ACTIVE . ' and credential_verified = ' . applicationConstants::YES, 'seller_user_cred');
    }
}
