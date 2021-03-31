<?php

class Report extends SearchBase
{
    private $langId;
    private $ordersTableJoined;
    private $attr = [];

    public function __construct($langId = 0, $attr = [])
    {
        parent::__construct(Orders::DB_TBL_ORDER_PRODUCTS, 'op');
        $this->langId = FatUtility::int($langId);
        $this->ordersTableJoined = false;
        $this->setFields($attr);
    }

    public function joinOrders()
    {
        if ($this->ordersTableJoined) {
            trigger_error('Orders Table is already joined', E_USER_ERROR);
        }
        $this->joinTable(Orders::DB_TBL, 'INNER JOIN', 'o.order_id = op.op_order_id', 'o');
        $this->ordersTableJoined = true;
    }

    public function joinPaymentMethod(int $langId = 0)
    {
        if (1 > $langId) {
            $langId = $this->langId;
        }

        if (!$this->ordersTableJoined) {
            trigger_error('Please use joinOrders() first, then try to join joinPaymentMethod()', E_USER_ERROR);
        }

        $this->joinTable(Plugin::DB_TBL, 'LEFT OUTER JOIN', 'o.order_pmethod_id = pm.plugin_id', 'pm');
        if ($langId) {
            $this->joinTable(Plugin::DB_TBL_LANG, 'LEFT OUTER JOIN', 'pm.plugin_id = pm_l.pluginlang_plugin_id AND pm_l.pluginlang_lang_id = ' . $langId, 'pm_l');
        }
    }

    public function joinSellerUser()
    {
        $this->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'seller.user_id = op.op_selprod_user_id', 'seller');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'seller.user_id = credential_user_id', 'seller_cred');
    }

    public function joinOtherCharges($includeNegativeSeperatly = false)
    {
        $ocSrch = new SearchBase(OrderProduct::DB_TBL_CHARGES, 'opc');
        $ocSrch->doNotCalculateRecords();
        $ocSrch->doNotLimitRecords();
        $ocSrch->addGroupBy('opc.opcharge_op_id');
        $ocSrch->addMultipleFields(['opcharge_op_id', 'sum(opc.opcharge_amount) as op_other_charges']);
        if ($includeNegativeSeperatly) {
            $ocSrch->addFld('SUM(CASE WHEN opc.opcharge_amount<0 THEN opc.opcharge_amount ELSE 0 END) as opDiscountCharges');
        }

        $this->joinTable('(' . $ocSrch->getQuery() . ')', 'LEFT OUTER JOIN', 'op.op_id = opcc.opcharge_op_id', 'opcc');
    }

    public function joinOrderProductCharges($type, $alias = 'opc_temp')
    {
        $this->joinTable(OrderProduct::DB_TBL_CHARGES, 'LEFT OUTER JOIN', $alias . '.opcharge_op_id = op.op_id and ' . $alias . '.opcharge_type = ' . $type, $alias);
    }

    public function joinOrderProductTaxCharges()
    {
        $this->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_TAX, 'optax');
        $this->addFld('(SUM(IFNULL(optax.opcharge_amount,0))) as taxTotal');
    }

    public function joinOrderProductShipCharges()
    {
        $this->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_SHIPPING, 'opship');
        $this->addFld('(SUM(IFNULL(opship.opcharge_amount,0))) as shippingTotal');
    }

    public function joinOrderProductDicountCharges()
    {
        $this->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_DISCOUNT, 'opDis');
        $this->addFld('(SUM(IFNULL(opDis.opcharge_amount,0))) as discountTotal');
    }

    public function joinOrderProductVolumeCharges()
    {
        $this->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_VOLUME_DISCOUNT, 'opVolDis');
        $this->addFld('(SUM(IFNULL(opVolDis.opcharge_amount, 0))) as volumeDiscount');
    }

    public function joinOrderProductRewardCharges()
    {
        $this->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_REWARD_POINT_DISCOUNT, 'opRewardDis');
        $this->addFld('(SUM(IFNULL(opRewardDis.opcharge_amount, 0))) as rewardDiscount');
    }

    public function addTotalOrdersCount($key = 'order_id')
    {
        $srch = new self();
        $srch->joinOrders();
        $srch->joinPaymentMethod();
        $srch->setPaymentStatusCondition();
        $srch->setCompletedOrdersCondition();
        $srch->excludeDeletedOrdersCondition();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();

        switch ($key) {
            case 'order_id':
                $srch->addMultipleFields(['o.order_id', 'count(DISTINCT(op.op_id)) as totOrders']);
                $srch->addGroupBy('o.order_id');
                $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'ocount.order_id = o.order_id', 'ocount');
                break;
            case 'op_selprod_id':
                $srch->addMultipleFields(['op.op_selprod_id', 'count(DISTINCT(op.op_id)) as totOrders']);
                $srch->addGroupBy('op.op_selprod_id');
                $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'ocount.op_selprod_id = op.op_selprod_id', 'ocount');
                break;
            case 'order_date_added':
                $srch->addMultipleFields(['DATE(o.order_date_added) as order_date_added', 'count(DISTINCT(o.order_id)) as totOrders']);
                $srch->addGroupBy('DATE(o.order_date_added)');
                $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'ocount.order_date_added = DATE(o.order_date_added)', 'ocount');
                break;
            case 'op_selprod_user_id':
                $srch->joinSellerUser();
                $srch->addMultipleFields(['op_selprod_user_id', 'count(DISTINCT(op.op_id)) as totOrders']);
                $srch->addGroupBy('op_selprod_user_id');
                $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT OUTER JOIN', 'ocount.op_selprod_user_id = op.op_selprod_user_id', 'ocount');
                break;
        }
    }

    public function addStatusCondition($op_status, $orderPaymentCancel = false)
    {
        if (is_array($op_status)) {
            if (!empty($op_status)) {
                $cnd = $this->addCondition('op.op_status_id', 'IN', $op_status);
            } else {
                $cnd = $this->addCondition('op.op_status_id', '=', 0);
            }
        } else {
            $op_status_id = FatUtility::int($op_status);
            $cnd = $this->addCondition('op.op_status_id', '=', $op_status_id);
        }

        if (true === $orderPaymentCancel) {
            $cnd->attachCondition('order_payment_status', '=', Orders::ORDER_PAYMENT_CANCELLED, 'OR');
        }
    }


    public function setDateCondition($from = '', $to = '')
    {
        if (!empty($from)) {
            $this->addCondition('o.order_date_added', '>=', $from . ' 00:00:00');
        }

        if (!empty($to)) {
            $this->addCondition('o.order_date_added', '<=', $to . ' 23:59:59');
        }
    }

    public function setPaymentStatusCondition($paymentStatus = Orders::ORDER_PAYMENT_PAID)
    {
        $cnd = $this->addCondition('o.order_payment_status', '=', $paymentStatus);
        $cnd->attachCondition('pm.plugin_code', '=', 'cashondelivery');
        $cnd->attachCondition('pm.plugin_code', '=', 'payatstore');
    }

    public function setCompletedOrdersCondition()
    {
        // $this->addStatusCondition(unserialize(FatApp::getConfig('CONF_COMPLETED_ORDER_STATUS')));
        $completedStatus = unserialize(FatApp::getConfig("CONF_COMPLETED_ORDER_STATUS", FatUtility::VAR_STRING, ''));
        $cancelledStatus = [FatApp::getConfig('CONF_DEFAULT_CANCEL_ORDER_STATUS')];
        $refundCompletedStatus = array_diff($completedStatus, $cancelledStatus);
        $this->addStatusCondition($refundCompletedStatus);
    }

    public function excludeDeletedOrdersCondition()
    {
        $this->addCondition('order_deleted', '=', applicationConstants::NO);
    }

    public function setGroupBy($key)
    {
        switch ($key) {
            case 'orderDate':
                $this->addGroupBy('DATE(o.order_date_added)');
                break;
            default:
                $this->addGroupBy($key);
                break;
        }
    }

    public static function getFields($fields = [])
    {
        $arr = [
            'orderDate' => 'DATE(o.order_date_added) as order_date',
            'totOrders' => 'ocount.totOrders',
            'totQtys' => 'SUM(op_qty) as totQtys',
            'totRefundedQtys' => 'SUM(op_refund_qty) as totRefundedQtys',
            'netSoldQty' => 'SUM(op_qty - op_refund_qty) as netSoldQty',
            'grossSales' => 'sum(( op_unit_price * op_qty ) + op_other_charges + op_rounding_off - opDiscountCharges) as grossSales',
            'transactionAmount' => 'sum(( op_unit_price * op_qty ) + op_other_charges + op_rounding_off) as transactionAmount',
            'inventoryValue' => 'SUM(op_unit_price*op_qty) as inventoryValue',
            'commissionCharged' => 'sum(op_commission_charged) as commissionCharged',
            'refundedAmount' => 'sum(op_refund_amount) as refundedAmount',
            'refundedCommission' => 'sum(op_refund_commission) as refundedCommission',
            'refundedShipping' => '(SUM(op_refund_shipping)) as refundedShipping',
            'affiliateCommissionCharged' => 'sum(op_affiliate_commission_charged) as affiliateCommissionCharged',
            'refundedAffiliateCommission' => '(SUM(op_refund_shipping)) as refundedAffiliateCommission',
            'adminSalesEarnings' => 'sum((op_commission_charged - op_refund_commission)) as adminSalesEarnings',
            'orderNetAmount' => 'sum(( op_unit_price * op_qty ) + op_other_charges + op_rounding_off - op_refund_amount) as orderNetAmount',
            'unitPrice' => 'SUM(op_unit_price*op_qty)/sum(op_qty) as unitPrice',
            'roundingOff' => 'op_rounding_off',
            'op_other_charges' => 'sum(op_other_charges) as op_other_charges'

        ];

        if (empty($fields)) {
            return array_values($arr);
        }

        $fields = array_diff($fields, ['taxTotal', 'shippingTotal', 'discountTotal', 'volumeDiscount', 'rewardDiscount']);

        $flds = [];
        foreach ($fields as $key) {
            if (!array_key_exists($key, $arr)) {
                $flds[] = $key;
                continue;
            }
            $flds[] = $arr[$key];
        }

        return $flds;
    }

    private function setFields($fields = [])
    {
        if (empty($fields)) {
            return;
        }
        $this->attr[] = array_merge($this->attr, self::getFields($fields));
        $this->addMultipleFields($this->attr);
    }


    public static function salesReportObject($langId = 0, $joinSeller = false, $attr = array())
    {
        $ocSrch = new SearchBase(OrderProduct::DB_TBL_CHARGES, 'opc');
        $ocSrch->doNotCalculateRecords();
        $ocSrch->doNotLimitRecords();
        $ocSrch->addMultipleFields(array('opcharge_op_id', 'sum(opcharge_amount) as op_other_charges'));
        $ocSrch->addGroupBy('opc.opcharge_op_id');
        $qryOtherCharges = $ocSrch->getQuery();

        $srch = new OrderProductSearch($langId, true);
        $srch->joinPaymentMethod();

        if ($joinSeller) {
            $srch->joinSellerUser();
        }

        $srch->joinTable('(' . $qryOtherCharges . ')', 'LEFT OUTER JOIN', 'op.op_id = opcc.opcharge_op_id', 'opcc');
        $srch->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_TAX, 'optax');
        $srch->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_SHIPPING, 'opship');

        $cnd = $srch->addCondition('o.order_payment_status', '=', Orders::ORDER_PAYMENT_PAID);
        $cnd->attachCondition('plugin_code', '=', 'cashondelivery');
        $cnd->attachCondition('plugin_code', '=', 'payatstore');
        $srch->addStatusCondition(unserialize(FatApp::getConfig('CONF_COMPLETED_ORDER_STATUS')));

        if (empty($attr)) {
            $srch->addMultipleFields(array('DATE(order_date_added) as order_date', 'count(op_id) as totOrders', 'SUM(op_qty) as totQtys', 'SUM(op_refund_qty) as totRefundedQtys', 'SUM(op_qty - op_refund_qty) as netSoldQty', 'sum((op_commission_charged - op_refund_commission)) as totalSalesEarnings', 'sum(op_refund_amount) as totalRefundedAmount', 'op.op_qty', 'op.op_unit_price', 'op.op_unit_cost', 'SUM( op.op_unit_cost * op_qty ) as inventoryValue', 'op_other_charges', 'sum(( op_unit_price * op_qty ) + COALESCE(op_other_charges, 0)  + op_rounding_off) as orderNetAmount', '(SUM(optax.opcharge_amount)) as taxTotal', '(SUM(opship.opcharge_amount)) as shippingTotal', 'op_rounding_off'));
        } else {
            $srch->addMultipleFields($attr);
        }
        return $srch;
    }
}
