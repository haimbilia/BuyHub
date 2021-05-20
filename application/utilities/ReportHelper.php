
<?php
class ReportHelper
{
    private $langId;
    private $srch;
    private $fields = [];
    /**
     * __construct
     *
     * @param  int $langId
     * @return void
     */
    public function __construct(int $langId = 0)
    {
        $this->langId = $langId;
        $this->init($langId);
    }

    public function init($langId)
    {
        $this->srch =  new OrderProductSearch($langId);
        $this->srch->joinOrders();
    }

    public function joinOrderProductCharges()
    {
        $this->srch->addOrderProductCharges();
    }

    public function joinPaymentMethod($langId = 0)
    {
        $this->srch->joinPaymentMethod();
    }

    public function joinSettings()
    {
        $this->srch->joinSettings();
    }

    public function joinOrderProductTaxCharges()
    {
        $this->srch->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_TAX, 'optax');
    }

    public function joinOrderProductShipCharges()
    {
        $this->srch->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_SHIPPING, 'opship');
    }

    public function joinOrderProductDicountCharges()
    {
        $this->srch->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_DISCOUNT, 'opDis');
    }

    public function joinOrderProductVolumeCharges()
    {
        $this->srch->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_VOLUME_DISCOUNT, 'opVolDis');
    }

    public function joinOrderProductRewardCharges()
    {
        $this->srch->joinOrderProductCharges(OrderProduct::CHARGE_TYPE_REWARD_POINT_DISCOUNT, 'opRewardDis');
    }

    public function joinShippingChargedBy()
    {
    }

    public function joinSellerUser()
    {
        $this->srch->joinSellerUser();
    }

    public function setDateCondition($from, $to)
    {
        $this->srch->addCondition('o.order_date_added', '>=', $from . ' 00:00:00');

        $this->srch->addCondition('o.order_date_added', '<=', $to . ' 23:59:59');
    }

    public function setPaidCondition()
    {
        $cnd = $this->srch->addCondition('o.order_is_paid', '=', Orders::ORDER_PAYMENT_PAID);
        $cnd->attachCondition('plugin_code', '=', 'cashondelivery');
        $cnd->attachCondition('plugin_code', '=', 'payatstore');
    }

    public function setCompletedOrdersCondition()
    {
        // $this->srch->addStatusCondition(unserialize(FatApp::getConfig('CONF_COMPLETED_ORDER_STATUS')));
        $completedStatus = unserialize(FatApp::getConfig("CONF_COMPLETED_ORDER_STATUS", FatUtility::VAR_STRING, ''));
        $cancelledStatus = [FatApp::getConfig('CONF_DEFAULT_CANCEL_ORDER_STATUS')];
        $refundCompletedStatus = array_diff($completedStatus, $cancelledStatus);
        $this->srch->addStatusCondition($refundCompletedStatus);
    }

    public function setNonDeletedOrdersCondition($excludeDeleted = true)
    {
        if (!$excludeDeleted) {
            return;
        }
        $this->srch->addCondition('order_deleted', '=', applicationConstants::NO);
    }

    public static function sortBy()
    {
        return [
            1 => 'ASC',
            2 => 'DESC',
        ];
    }

    public function selectFields($fields = [])
    {

        $this->fields[] = array_merge($this->fields, self::getFields($fields));
    }

    public static function getFields($fields = [])
    {
        $arr = [
            'orderDate' => 'DATE(order_date_added) as order_date',
            'totOrders' => 'count(op_id) as totOrders',
            'totQtys' => 'SUM(op_qty) as totQtys',
            'totRefundedQtys' => 'SUM(op_refund_qty) as totRefundedQtys',
            'netSoldQty' => 'SUM(op_qty - op_refund_qty) as netSoldQty',
            'unitPrice' => 'SUM(op_unit_price*op_qty)/sum(op_qty) as unitPrice',
            'cartTotal' => 'SUM(op_unit_price*op_qty) as cartTotal',
            'refundShipping' => '(SUM(op_refund_shipping)) as refundShipping',
            'roundingOff' => 'op_rounding_off'
        ];

        if (empty($fields)) {
            return array_values($arr);
        }

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
}
