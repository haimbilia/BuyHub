<?php

class GiftCardOrdersController extends ListingBaseController
{
    protected string $pageKey = 'MANAGE_GIFT_CARDS_ORDER';
    use OrdersPackage;

    private int $ordersType = Orders::GIFT_CARD_TYPE;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewOrders();
    }

    private function orderData(int $orderId)
    {
        $srch = new OrderSearch($this->siteLangId);
        $srch->joinOrderPaymentMethod();
        $srch->doNotCalculateRecords();
        $srch->joinTable(GiftCards::DB_TBL, 'INNER JOIN', 'ogcards.ogcards_order_id = order_id', 'ogcards');
        $srch->setPageSize(1);
        $srch->joinOrderBuyerUser();
        $srch->addMultipleFields(
            array(
                'order_number', 'order_id', 'order_user_id', 'order_date_added', 'order_payment_status', 'order_tax_charged', 'order_site_commission',
                'order_reward_point_value', 'order_volume_discount_total', 'buyer.user_name as buyer_user_name', 'buyer_cred.credential_email as buyer_email', 'buyer.user_phone_dcode as buyer_phone_dcode', 'buyer.user_phone as buyer_phone', 'order_net_amount', 'order_shippingapi_name', 'order_pmethod_id', 'ifnull(plugin_name,plugin_identifier)as plugin_name', 'order_discount_total', 'plugin_code', 'order_is_wallet_selected', 'order_reward_point_used', 'order_deleted', 'order_rounding_off', 'ogcards.ogcards_receiver_name', 'ogcards.ogcards_receiver_email'
            )
        );
        $srch->addCondition('order_id', '=', $orderId);
        $srch->addCondition('order_type', '=', $this->ordersType);
        $rs = $srch->getResultSet();
        $this->order = (array) FatApp::getDb()->fetch($rs);
        if (empty($this->order)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_ORDER_DATA_NOT_FOUND', $this->siteLangId), false, true);
            CommonHelper::redirectUserReferer();
        }
        $this->order['products'] = [];
        $orderObj = new Orders($this->order['order_id']);
        $this->order['comments'] = $orderObj->getOrderComments($this->siteLangId, array("order_id" => $this->order['order_id']));
        $this->order['payments'] = $orderObj->getOrderPayments(array("order_id" => $this->order['order_id']));
        $this->set('order', $this->order);

        $paymentMethodName = !empty($this->order['plugin_name']) ?  $this->order['plugin_name'] : '';
        if (!empty($paymentMethodName) && $this->order['order_pmethod_id'] > 0 && $this->order['order_is_wallet_selected'] > 0) {
            $paymentMethodName  .= ' + ';
        }
        if ($this->order['order_is_wallet_selected'] > 0) {
            $paymentMethodName .= Labels::getLabel("LBL_Wallet", $this->siteLangId);
        }

        $this->set("paymentMethodName", $paymentMethodName);

        $this->set("canEdit", $this->objPrivilege->canEditOrders($this->admin_id, true));
        $this->set("canEditSellerOrders", $this->objPrivilege->canEditSellerOrders($this->admin_id, true));
    }
}
