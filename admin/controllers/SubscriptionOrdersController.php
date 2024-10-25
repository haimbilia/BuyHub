<?php

class SubscriptionOrdersController extends ListingBaseController
{
    protected string $pageKey = 'MANAGE_SUBSCRIPTION_ORDERS';
    use OrdersPackage;
    
    private int $ordersType = Orders::ORDER_SUBSCRIPTION;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSubscriptionOrders();
    }

    private function orderData(int $orderId)
    {
        $srch = new OrderSubscriptionSearch($this->siteLangId);
        $srch->joinOrders();
        $srch->joinOrderPaymentMethod();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->joinOrderUser();
        $srch->addMultipleFields(
            array(
                'order_number', 'order_id', 'order_user_id', 'order_date_added', 'order_payment_status', 'order_tax_charged', 'order_site_commission',
                'ou.user_name as buyer_user_name', 'ouc.credential_email as buyer_email', 'ou.user_phone_dcode as buyer_phone_dcode', 'ou.user_phone as buyer_phone',
                'order_net_amount',   'order_pmethod_id', 'plugin_name', 'order_discount_total', 'order_deleted', 'plugin_code', 'order_rounding_off', 'order_reward_point_value'
            )
        );
        $srch->addCondition('order_id', '=', $orderId);
        $srch->addCondition('order_type', '=', Orders::ORDER_SUBSCRIPTION);
        $rs = $srch->getResultSet();
        $this->order = FatApp::getDb()->fetch($rs);
        if (!$this->order) {
            Message::addErrorMessage(Labels::getLabel('ERR_ORDER_DATA_NOT_FOUND', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl("SubscriptionOrders"));
        }

        $opSrch = new OrderSubscriptionSearch($this->siteLangId, false, true);
        $opSrch->addOrderProductCharges();
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();
        $opSrch->addCondition('oss.ossubs_order_id', '=', $orderId);

        $ossubsId = FatApp::getPostedData('ossubs_id', FatUtility::VAR_INT, 0);
        if (0 < $ossubsId) {
            $opSrch->addCondition('ossubs_id', '=', $ossubsId);
        }

        $opSrch->addMultipleFields(
            array(
                'ossubs_id', 'ossubs_invoice_number', 'ossubs_price', 'ossubs_type', 'IFNULL(orderstatus_name, orderstatus_identifier) as orderstatus_name', 'orderstatus_color_class',
                'ossubs_frequency', 'ossubs_subscription_name,ossubs_interval', 'ossubs_status_id', 'ossubs_till_date', 'ossubs_from_date', 'ossubs_products_allowed', 'ossubs_inventory_allowed',
                'ossubs_images_allowed', 'ossubs_commission', 'ossubs_rfq_offers_allowed'
            )
        );

        $this->order['items'] = FatApp::getDb()->fetchAll($opSrch->getResultSet(), 'ossubs_id');
        $orderObj = new Orders($this->order['order_id']);
        $this->order['comments'] = $orderObj->getOrderComments($this->siteLangId, array("order_id" => $this->order['order_id']));
        $this->order['payments'] = $orderObj->getOrderPayments(array("order_id" => $this->order['order_id']));


        $paymentMethodName = Labels::getLabel('LBL_WALLET', $this->siteLangId);
        if (0 < (int) $this->order['order_pmethod_id']) {
            $srch = Plugin::getSearchObject($this->siteLangId, false);
            $srch->addMultipleFields(['COALESCE(plugin_name, plugin_identifier) as plugin_name']);
            $srch->addCondition('plugin_id', '=', $this->order['order_pmethod_id']);
            $srch->setPageSize(1);
            $srch->doNotCalculateRecords();
            $paymentMethodName = current((array) FatApp::getDb()->fetch($srch->getResultSet()));
        }

        $frm = $this->getPaymentForm($this->siteLangId, $this->order['order_id']);
        $this->set('frm', $frm);
        $this->set('paymentMethodName', $paymentMethodName);
        $this->set('order', $this->order);
        $this->set("canEdit", $this->objPrivilege->canEditSubscriptionOrders($this->admin_id, true));
        $this->set('orderStatuses', Orders::getOrderSubscriptionStatusArr($this->siteLangId));
    }

    public function updatePayment()
    {
        $this->objPrivilege->canEditSubscriptionOrders();
        $frm = $this->getPaymentForm($this->siteLangId);

        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($frm->getValidationErrors()), true);
        }

        $orderId = $post['opayment_order_id'];
        if ($orderId == '' || $orderId == null) {
            LibHelper::exitWithError($this->str_invalid_request, true);
        }

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        if (!$orderPaymentObj->addOrderPayment($post["opayment_method"], $post['opayment_gateway_txn_id'], $post["opayment_amount"], $post["opayment_comments"])) {
            LibHelper::exitWithError($orderPaymentObj->getError(), true);
        }

        $this->set('msg', Labels::getLabel('MSG_PAYMENT_DETAILS_ADDED_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function cancel($order_id)
    {
        $this->objPrivilege->canEditSubscriptionOrders();

        $orderObj = new Orders();
        $order = $orderObj->getOrderById($order_id);

        if ($order == false) {
            LibHelper::exitWithError(Labels::getLabel('ERR_PLEASE_PERFORM_THIS_ACTION_ON_VALID_RECORD.', $this->siteLangId), true);
        }

        if (!$order["order_payment_status"]) {
            if (!$orderObj->addOrderPaymentHistory($order_id, Orders::ORDER_PAYMENT_CANCELLED, Labels::getLabel('MSG_ORDER_CANCELLED', $order['order_language_id']), 1)) {
                LibHelper::exitWithError($orderObj->getError(), true);
            }

            if (!$orderObj->refundOrderPaidAmount($order_id, $order['order_language_id'])) {
                LibHelper::exitWithError($orderObj->getError(), true);
            }
        }

        $this->set('msg', Labels::getLabel('MSG_ORDER_CANCELLED', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

    public function viewPaymemntGatewayResponse()
    {
        $orderId = FatApp::getPostedData('order_id', FatUtility::VAR_INT, 0);
        $oPayment = new OrderPayment($orderId);
        $response = $oPayment->getPaymentGatewayResponse();
        $this->set('response', $response);
        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }
}
