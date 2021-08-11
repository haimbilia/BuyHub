<?php

trait ApiOrders
{
    /**
     * getOrders
     * 
     * @param array $post 
     * @return array
     */
    public function getOrders(array $post): array
    {
        $page = (empty($post['page']) || $post['page'] <= 0) ? 1 : FatUtility::int($post['page']);
        $pagesize = array_key_exists('pagesize', $post) ? FatUtility::int($post['pagesize']) : 0;
        $pagesize = 1 > $pagesize ? FatApp::getConfig('conf_page_size', FatUtility::VAR_INT, 10) : $pagesize;
        $fulfillmentType = array_key_exists('fulfillment_type', $post) ? FatUtility::int($post['fulfillment_type']) : 0;

        $ocSrch = new SearchBase(OrderProduct::DB_TBL_CHARGES, 'opc');
        $ocSrch->doNotCalculateRecords();
        $ocSrch->doNotLimitRecords();
        $ocSrch->addMultipleFields(array('opcharge_op_id', 'sum(opcharge_amount) as op_other_charges'));
        $ocSrch->addGroupBy('opc.opcharge_op_id');
        $qryOtherCharges = $ocSrch->getQuery();

        $srch = new OrderProductSearch($this->langId, true, true);
        $srch->joinTable(User::DB_TBL, 'LEFT OUTER JOIN', 'o.order_user_id = buyer.user_id', 'buyer');
        $srch->joinTable(user::DB_TBL_CRED, 'LEFT OUTER JOIN', 'buyer.user_id = buyer_cred.credential_user_id', 'buyer_cred');
        $srch->joinSellerProducts();
        $srch->joinPaymentMethod();
        $srch->joinShippingUsers();
        $srch->joinShippingCharges();
        $srch->addCountsOfOrderedProducts();
        $srch->joinOrderProductShipment();
        $srch->joinTable('(' . $qryOtherCharges . ')', 'LEFT OUTER JOIN', 'op.op_id = opcc.opcharge_op_id', 'opcc');
        $srch->addCondition('op_selprod_user_id', '=', $this->userId);
        $srch->addOrder("op_id", "DESC");
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $srch->addCondition('opshipping_by_seller_user_id', '=', $this->userId);
        $srch->addMultipleFields(
            array('order_id', 'order_payment_status', 'order_user_id', 'op_selprod_id', 'op_is_batch', 'selprod_product_id', 'order_date_added', 'order_net_amount', 'op_invoice_number', 'totCombinedOrders as totOrders', 'op_selprod_title', 'op_product_name', 'op_id', 'op_qty', 'op_selprod_options', 'op_brand_name', 'op_shop_name', 'op_other_charges', 'op_unit_price', 'op_tax_collected_by_seller', 'op_selprod_user_id', 'opshipping_by_seller_user_id', 'op_status_id', 'orderstatus_id', 'IFNULL(orderstatus_name, orderstatus_identifier) as orderstatus_name', 'orderstatus_color_class', 'plugin_code', 'IFNULL(plugin_name, IFNULL(plugin_identifier, "Wallet")) as plugin_name', 'opship.*', 'opshipping_fulfillment_type', 'op_rounding_off', 'op_product_type', 'opshipping_carrier_code', 'opshipping_service_code', 'order_tax_charged', 'order_date_added as created_date', 'order_date_updated as updated_date', 'buyer.user_name as buyer_user_name', 'order_language_id', 'opshipping_label', 'op_selprod_sku')
        );

        $op_status_id = FatApp::getPostedData('status', null, '0');

        if (0 < $op_status_id && in_array($op_status_id, unserialize(FatApp::getConfig("CONF_VENDOR_ORDER_STATUS")))) {
            $srch->addCondition('op_status_id', '=', $op_status_id);
        } else {
            $cond = $srch->addCondition('op_status_id', '=', FatApp::getConfig("CONF_DEFAULT_PAID_ORDER_STATUS"));
            $cond->attachCondition('op_status_id', '=', FatApp::getConfig("CONF_COD_ORDER_STATUS"));
        }

        if (0 < $fulfillmentType) {
            $srch->addCondition('opshipping_fulfillment_type', '=', $fulfillmentType);
        }

        $rs = $srch->getResultSet();
        $orders = FatApp::getDb()->fetchAll($rs);
        
        $oObj = new Orders();
        foreach ($orders as &$order) {
            $charges = $oObj->getOrderProductChargesArr($order['op_id']);
            $order['charges'] = $charges;
            $order['shipping_charges'] = CommonHelper::displayMoneyFormat(CommonHelper::orderProductAmount($order, 'SHIPPING'));

            switch (strtolower($order['plugin_code'])) {
                case 'cashondelivery':
                    $paymentMode = 'COD';
                    break;
                
                case 'PayAtStore':
                    $paymentMode = 'PAYATSTORE';
                    break;
                
                default:
                    $paymentMode = 'PREPAID';
                    if (Orders::ORDER_PAYMENT_PENDING == $order['order_payment_status']) {
                        $paymentMode = 'PENDING';
                    } else if (Orders::ORDER_PAYMENT_CANCELLED == $order['order_payment_status']) {
                        $paymentMode = 'CANCELLED';
                    }
                    break;
            }

            $order['paymentMode'] = $paymentMode;
            
            $addresses = $oObj->getOrderAddresses($order['order_id']);
	        $billingAddress = $addresses[Orders::BILLING_ADDRESS_TYPE];
	        $shippingAddress = (!empty($addresses[Orders::SHIPPING_ADDRESS_TYPE])) ? $addresses[Orders::SHIPPING_ADDRESS_TYPE] : [];
            foreach ($billingAddress as $index => $value) {
               $adKey = str_replace('oua_', '', $index);
               $billingAddress[$adKey] = $value;
               unset($billingAddress[$index]);
            }

            foreach ($shippingAddress as $index => $value) {
               $adKey = str_replace('oua_', '', $index);
               $shippingAddress[$adKey] = $value;
               unset($shippingAddress[$index]);
            }

	        $customerName = explode(' ', $order['buyer_user_name']);
	        $customerName = [
	        	'first_name' => $customerName[0],
	        	'last_name' => isset($customerName[1]) ? $customerName[1] : '',
	        ];

	        $billingAddress = array_merge($customerName, $billingAddress);
	        $shippingAddress = array_merge($customerName, $shippingAddress);

            $order['billing_address'] = $billingAddress;
            $order['shipping_address'] = $shippingAddress;
        }

        $status = (0 < count($orders)) ?  1 : 0;

        $data = [
            'status' => $status,
            'pagination' => [
                'total_pages' => $srch->pages(),
                'page_size' => $pagesize,
                'current_page' => $page,
                'record_count' => $srch->recordCount(),
            ],
            'orders' => $orders
        ];

        $msg = Labels::getLabel("MSG_SUCCESS", $this->langId);
        return $this->formatOutput(true, $msg, $data);
    }

    /**
     * getShippedOrderCarrierDetail
     * 
     * @param int $opId 
     * @return array
     */
    public function getShippedOrderCarrierDetail(int $opId): array
    {
        $opSrch = new OrderProductSearch($this->langId, false, true, true);
     
        $opSrch->joinTable(Orders::DB_TBL_ORDER_STATUS_HISTORY, 'LEFT JOIN', 'oph.oshistory_op_id = op.op_id', 'oph');
        $opSrch->joinTable(Orders::DB_TBL_ORDER_PRODUCTS_SHIPPING, 'LEFT JOIN', 'ops.opshipping_op_id = op.op_id', 'ops');
        $opSrch->joinTable(OrderProduct::DB_TBL_RESPONSE, 'LEFT JOIN', 'op.op_id = opr.opr_op_id', 'opr');
        $opSrch->joinTable(OrderProductShipment::DB_TBL, 'LEFT JOIN', 'opship.opship_op_id = op.op_id', 'opship');
        $opSrch->doNotCalculateRecords();
        $opSrch->setPageSize(1);
        $opSrch->addCondition('op.op_id', '=', $opId);
        $opSrch->addCondition('op_selprod_user_id', '=', $this->userId);
        $opSrch->addCondition('oshistory_orderstatus_id', '=', OrderStatus::ORDER_SHIPPED);
        $opSrch->addCondition('opshipping_by_seller_user_id', '=', $this->userId);

        $opSrch->addMultipleFields([
            'op_invoice_number',
            'opshipping_by_seller_user_id',
            'opship_tracking_number',
            'opship_tracking_url',
            'opshipping_label',
            'opshipping_carrier_code',
            'opshipping_service_code',
            'opr_response',
        ]);
        $opRs = $opSrch->getResultSet();
        $carrierDetail = FatApp::getDb()->fetch($opRs);
        $msg = Labels::getLabel("MSG_SUCCESS", $this->langId);
        if (empty($carrierDetail)) {
            $msg = Labels::getLabel("MSG_NO_RECORD_FOUND", $this->langId);
            return $this->formatOutput(Plugin::RETURN_FALSE, $msg);
        }

        $carrierDetail['label'] = '';
        if (!empty($carrierDetail['opship_tracking_number']) && !empty($carrierDetail['opr_response'])) {
            $excryptedOpId = LibHelper::encrypt($opId);
            $carrierDetail['label'] = UrlHelper::generateFullUrl('Products', 'getOrderProductLabel', [$excryptedOpId], CONF_WEBROOT_FRONT_URL);    
        } else if (!empty($carrierDetail['opship_tracking_url'])) {
            $shipBy = FatApp::getConfig('CONF_SITE_OWNER_' . $this->langId, FatUtility::VAR_INT, 1);
            if (0 < $carrierDetail['opshipping_by_seller_user_id']) {
                $shop = Shop::getAttributesByUserId($carrierDetail['opshipping_by_seller_user_id'], ['shop_identifier', 'shop_name'], true, $this->langId);
                $shipBy = empty($shop['shop_name']) ? $shop['shop_name'] : $shop['shop_identifier'];
            }
            $label = Labels::getLabel('LBL_SHIPPING', $this->langId);
            $carrierDetail['opshipping_label'] = $shipBy . ' - ' . $label;    
            $carrierDetail['opshipping_carrier_code'] = '';    
            $carrierDetail['opshipping_service_code'] = '';    
        }
        unset($carrierDetail['opr_response']);

        return $this->formatOutput(Plugin::RETURN_TRUE, $msg, $carrierDetail);
    }

    /**
     * getOrderStatus
     * 
     * @param int $opId 
     * @return array
     */
    public function getOrderStatus(int $opId): array
    {
        $opSrch = new OrderProductSearch($this->langId, false, true, true);
        $opSrch->addCondition('op.op_id', '=', $opId);
        $opSrch->addCondition('op_selprod_user_id', '=', $this->userId);

        $opSrch->addMultipleFields([
            'op_status_id'
        ]);
        $opSrch->setPageSize(1);
        $opSrch->doNotCalculateRecords();    
        $opRs = $opSrch->getResultSet();
        $orderStatus = FatApp::getDb()->fetch($opRs);

        $msg = Labels::getLabel("MSG_SUCCESS", $this->langId);
        $status = true;
        if (empty($orderStatus)) {
            $orderStatus = [];
            $status = false;
            $msg = Labels::getLabel("MSG_NO_RECORD_FOUND", $this->langId);
        }
        return $this->formatOutput($status, $msg, $orderStatus);
    }

    /**
     * markOrderAsShipped
     * 
     * @param array $post 
     * @return array
     */
    public function markOrderAsShipped(array $post): array
    {
        $opId = FatUtility::int($post['op_id']);
        $trackingNumber = $post['tracking_number'];
        $trackingUrl = $post['tracking_url'];

        if (1 > $opId || empty($trackingNumber) || empty($trackingUrl)) {
            $msg = Labels::getLabel('MSG_INVALID_REQUEST', $this->langId);
            return $this->formatOutput(false, $msg);
        }

        $resp = $this->getOrderStatus($opId);
        if (false === $resp['status']) {
            return $resp;
        }
        
        $updateData = [
            'opship_op_id' => $opId,
            'opship_tracking_number' => $trackingNumber,
            'opship_tracking_url' => $trackingUrl,
        ];
        if (false == FatApp::getDb()->insertFromArray(OrderProductShipment::DB_TBL, $updateData, false, array(), $updateData)) {
            return $this->formatOutput(false, FatApp::getDb()->getError());
        }

        $comment = Labels::getLabel('MSG_MARKED_AS_SHIPPED_BY_EASY_ECOM', $this->langId);
        $orderObj = new Orders();
        if (false == $orderObj->addChildProductOrderHistory($opId, $this->langId, OrderStatus::ORDER_SHIPPED, $comment, true, $trackingNumber)) {
            return $this->formatOutput(false, $orderObj->getError());
        }
        $msg = Labels::getLabel("MSG_SUCCESS", $this->langId);
        return $this->formatOutput(true, $msg);
    }
}