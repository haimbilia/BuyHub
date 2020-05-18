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
        $this->db = FatApp::getDb();
        $page = !isset($post['page']) || 1 > $post['page'] ? 1 : $post['page'];
        
        $pagesize = FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 50);
        $pagesize = isset($post['pagesize']) ? $post['pagesize'] : $pagesize;

        $srch = new OrderSearch();
        $srch->joinOrderBuyerUser();
        $srch->joinOrderPaymentMethod($this->langId);
        $srch->joinTable(Orders::DB_TBL_ORDER_PRODUCTS, 'LEFT OUTER JOIN', 'op.op_order_id = order_id', 'op');
        $srch->addOrder('order_date_added', 'DESC');
        $srch->addCondition('order_type', '=', Orders::ORDER_PRODUCT);
        $srch->addCondition('order_is_paid', '=', Orders::ORDER_IS_PAID);
        $srch->addCondition('op_selprod_user_id', '=', $this->userId);
        $srch->setPageNumber($page);
        $srch->setPageSize($pagesize);

        $srch->addMultipleFields([
        	'order_id',
        	'order_status',
        	'order_date_added as created_date',
        	'order_date_updated as updated_date',
        	'order_net_amount',
        	'order_is_paid',
        	'IFNULL(pmethod_name, pmethod_identifier) as pmethod_name',
        	'pmethod_code',
        	'buyer.user_name as buyer_user_name',
            'order_tax_charged',
            'order_discount_total',
            'order_reward_point_value',
            'order_volume_discount_total',
            'order_language_id'
        ]);

        $rs = $srch->getResultSet();
        $ordersList = FatApp::getDb()->fetchAll($rs);
        $payementStatusArr = Orders::getOrderPaymentStatusArr($this->langId);

        $orders = [];
        foreach ($ordersList as $key => $row) {
        	$opSrch = new OrderProductSearch($this->langId, false, true, true);	
			$opSrch->joinShippingUsers();
			$opSrch->joinSellerProducts();
            $opSrch->joinShippingCharges();
            $opSrch->joinTable(Orders::DB_TBL_ORDER_PRODUCTS_SHIPPING_LANG, 'LEFT OUTER JOIN', 'ops_l.opshippinglang_op_id = op.op_id AND ops_l.opshippinglang_lang_id = ' . $this->langId, 'ops_l');
	        $opSrch->addCountsOfOrderedProducts();
	        $opSrch->addOrderProductCharges();
	        $opSrch->doNotCalculateRecords();
	        $opSrch->doNotLimitRecords();
	        $opSrch->addCondition('op.op_order_id', '=', $row['order_id']);

	        $opSrch->addMultipleFields(
	            array('op_id', 'op_invoice_number', 'op_selprod_id', 'selprod_product_id', 'selprod_sku', 'op_selprod_title', 'op_product_name',
	            'op_qty', 'op_brand_name', 'op_selprod_options', 'op_selprod_sku', 'op_product_model',
	            'op_shop_name', 'op_shop_owner_name', 'op_shop_owner_email', 'op_shop_owner_phone', 'op_unit_price',
	            'totCombinedOrders as totOrders', 'op_shipping_duration_name', 'op_shipping_durations',  'IFNULL(orderstatus_name, orderstatus_identifier) as orderstatus_name', 'op_other_charges', 'op_product_tax_options', 'op_status_id', 'optosu.optsu_user_id', 'op_selprod_user_id', 'opshipping_by_seller_user_id', 'op_shipping_duration_name', 'op_shipping_durations','opshipping_carrier')
	        );

	        $opRs = $opSrch->getResultSet();
	        $orderProducts = FatApp::getDb()->fetchAll($opRs);
            $orderObj = new Orders($row['order_id']);
            $charges = $orderObj->getOrderProductChargesByOrderId($row['order_id']);
	        $cartTotal = 0;
	        $shippingTotal = 0;
	        $orderItems = [];
            $taxOptionsTotal = [];
	        foreach ($orderProducts as $index => $opRow) {
                $opRow['charges'] = $charges[$opRow['op_id']];
                
                $taxOptions = json_decode($opRow['op_product_tax_options'], true);
                if (!empty($taxOptions)) {
                    foreach ($taxOptions as $val) {
                        $title = $val['name'];
                        if (!isset($taxOptionsTotal[$key][$title])) {
                            $taxOptionsTotal[$key][$title] = 0;
                        }
                        $taxOptionsTotal[$key][$title] += $val['value'];
                    }
                }

	        	$shippingCost = CommonHelper::orderProductAmount($opRow, 'SHIPPING');
                $volumeDiscount = CommonHelper::orderProductAmount($opRow, 'VOLUME_DISCOUNT');
                $total = CommonHelper::orderProductAmount($opRow, 'cart_total') + $shippingCost+$volumeDiscount;
                $cartTotal = $cartTotal + CommonHelper::orderProductAmount($opRow, 'cart_total');
                $shippingTotal = $shippingTotal + CommonHelper::orderProductAmount($opRow, 'shipping');
                $opshipping_by_seller_user_id = isset($opRow['opshipping_by_seller_user_id']) ? $opRow['opshipping_by_seller_user_id'] : 0;
        
                $orderItems[$key][$index] = [
                	'op_id' => $opRow['op_id'],
                    'op_invoice_number' => $opRow['op_invoice_number'],
                	'selprod_product_id' => $opRow['selprod_product_id'],
                	'selprod_sku' => $opRow['selprod_sku'],
                    'op_selprod_title' => $opRow['op_selprod_title'],
                    'op_selprod_options' => $opRow['op_selprod_options'],
                	'op_selprod_id' => $opRow['op_selprod_id'],
                	'op_selprod_sku' => $opRow['op_selprod_sku'],
                	'op_qty' => $opRow['op_qty'],
                    'op_shop_name' => $opRow['op_shop_name'],
                    'op_shop_owner_name' => $opRow['op_shop_owner_name'],
                    'op_shop_owner_email' => $opRow['op_shop_owner_email'],
                    'op_shop_owner_phone' => $opRow['op_shop_owner_phone'],
                    'orderstatus_name' => $opRow['orderstatus_name'],
                    'op_other_charges' => $opRow['op_other_charges'],
                	'cart_total' => $cartTotal,
                    'op_shipping_duration_name' => $opRow['op_shipping_duration_name'],
                    'op_shipping_durations' => $opRow['op_shipping_durations'],
                    'opshipping_carrier' => $opRow['opshipping_carrier'],
                    'shipping_by' => CommonHelper::canAvailShippingChargesBySeller($opRow['op_selprod_user_id'], $opshipping_by_seller_user_id) ? Labels::getLabel('LBL_YOKART_SELLER', $this->langId) : Labels::getLabel('LBL_YOKART_ADMIN', $this->langId)
                ];
	        }
            
	        $addresses = $orderObj->getOrderAddresses($row['order_id']);
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

	        $customerName = explode(' ', $row['buyer_user_name']);
	        $customerName = [
	        	'first_name' => $customerName[0],
	        	'last_name' => isset($customerName[1]) ? $customerName[1] : '',
	        ];

	        $billingAddress = array_merge($customerName, $billingAddress);
	        $shippingAddress = array_merge($customerName, $shippingAddress);

            $paymentMode = 'PREPAID';
	        if (!empty($row['pmethod_name']) && 'CashOnDelivery' == $row['pmethod_code']) {
	        	$paymentMode = 'COD';	
	        }

	        $orders[$key] = [
	        	'order_id' => $row['order_id'],
                'order_language_id' => $row['order_language_id'],
	        	'order_status' => $payementStatusArr[$row['order_status']],
	        	'created_date' => $row['created_date'],
	        	'updated_date' => $row['updated_date'],
	        	'payment_mode' => $paymentMode,
	        	'cart_total' => $cartTotal,
                'tax' => [
                    'total' => $row['order_tax_charged']
                ],
                'order_discount_total' => $row['order_discount_total'],
                'order_reward_point_value' => $row['order_reward_point_value'],
                'order_volume_discount_total' => $row['order_volume_discount_total'],
                'shipping_fee' => $shippingTotal,
	        	'total' => $row['order_net_amount'],
	        	'billing_address' => $billingAddress,
	        	'shipping_address' => $shippingAddress,
	        	'order_items' => $orderItems[$key]
	        ];

            if (!empty($taxOptionsTotal[$key])) {
                $orders[$key]['tax'] = $taxOptionsTotal[$key];
            }
        }

        $data = [
            'status' => (0 < count($orders)) ?  1 : 0,
            'pagination' => [
                'total_pages' => $srch->pages(),
                'page_size' => $pagesize,
                'current_page' => $page,
                'record_count' => $srch->recordCount()
            ],
            'orders' => $orders
        ];

        $msg = Labels::getLabel("MSG_SUCCESS", $this->langId);
        return $this->formatOutput(true, $msg, $data);
    }

    /**
     * getShippedOrderCarrierDetail
     * 
     * @param string $orderId 
     * @param int $opId 
     * @return array
     */
    public function getShippedOrderCarrierDetail(int $opId): array
    {
        $opSrch = new OrderProductSearch($this->langId, false, true, true);
     
        $opSrch->joinTable(Orders::DB_TBL_ORDER_PRODUCTS_SHIPPING_LANG, 'LEFT OUTER JOIN', 'ops_l.opshippinglang_op_id = op.op_id AND ops_l.opshippinglang_lang_id = ' . $this->langId, 'ops_l');
        $opSrch->joinTable(Orders::DB_TBL_ORDER_STATUS_HISTORY, 'LEFT OUTER JOIN', 'oph.oshistory_op_id = op.op_id', 'oph');
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();
        $opSrch->addCondition('op.op_id', '=', $opId);
        $opSrch->addCondition('op_selprod_user_id', '=', $this->userId);
        $opSrch->addCondition('oshistory_orderstatus_id', '=', OrderStatus::ORDER_SHIPPED);

        $opSrch->addMultipleFields([
            'op_invoice_number',
            'op_shipping_duration_name',
            'op_shipping_durations',
            'opshipping_carrier',
            'oshistory_tracking_number'
        ]);
        $opRs = $opSrch->getResultSet();
        $carrierDetail = FatApp::getDb()->fetch($opRs);
        $msg = Labels::getLabel("MSG_SUCCESS", $this->langId);
        if (empty($carrierDetail)) {
            $carrierDetail = [];
            $msg = Labels::getLabel("MSG_NO_RECORD_FOUND", $this->langId);
        }
        return $this->formatOutput(true, $msg, $carrierDetail);
    }
}