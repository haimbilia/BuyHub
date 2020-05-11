<?php

trait ApiOrders
{
	public function getOrders()
    {
        $this->db = FatApp::getDb();
        $page = FatApp::getPostedData('page', FatUtility::VAR_INT, 1);
        $pagesize = FatApp::getConfig('CONF_ITEMS_PER_PAGE_CATALOG', FatUtility::VAR_INT, 50);

        $srch = new OrderSearch();
        $srch->joinOrderBuyerUser();
        $srch->joinOrderPaymentMethod($this->langId);

        $srch->addOrder('order_date_added', 'DESC');
        $srch->addCondition('order_type', '=', Orders::ORDER_PRODUCT);
        $srch->addCondition('order_is_paid', '=', Orders::ORDER_IS_PAID);
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
        	'buyer.user_name as buyer_user_name'
        ]);

        $rs = $srch->getResultSet();
        echo $srch->getError();
        $ordersList = FatApp::getDb()->fetchAll($rs);
        $payementStatusArr = Orders::getOrderPaymentStatusArr($this->langId);

        $orders = [];
        foreach ($ordersList as $key => $row) {
        	$opSrch = new OrderProductSearch($this->langId, false, true, true);	
			$opSrch->joinShippingUsers();
			$opSrch->joinSellerProducts();
	        $opSrch->addCountsOfOrderedProducts();
	        $opSrch->addOrderProductCharges();
	        $opSrch->doNotCalculateRecords();
	        $opSrch->doNotLimitRecords();
	        $opSrch->addCondition('op.op_order_id', '=', $row['order_id']);

	        $opSrch->addMultipleFields(
	            array('op_id', 'op_invoice_number', 'op_selprod_id', 'selprod_product_id', 'selprod_sku', 'op_selprod_title', 'op_product_name',
	            'op_qty', 'op_brand_name', 'op_selprod_options', 'op_selprod_sku', 'op_product_model',
	            'op_shop_name', 'op_shop_owner_name', 'op_shop_owner_email', 'op_shop_owner_phone', 'op_unit_price',
	            'totCombinedOrders as totOrders', 'op_shipping_duration_name', 'op_shipping_durations',  'IFNULL(orderstatus_name, orderstatus_identifier) as orderstatus_name', 'op_other_charges', 'op_product_tax_options', 'op_status_id', 'optosu.optsu_user_id')
	        );

	        $opRs = $opSrch->getResultSet();
	        $orderProducts = FatApp::getDb()->fetchAll($opRs);
	        
	        $cartTotal = 0;
	        $shippingTotal = 0;
	        $orderItems = [];
	        foreach ($orderProducts as $index => $opRow) {
	        	$shippingCost = CommonHelper::orderProductAmount($opRow, 'SHIPPING');
                $volumeDiscount = CommonHelper::orderProductAmount($opRow, 'VOLUME_DISCOUNT');
                $total = CommonHelper::orderProductAmount($opRow, 'cart_total') + $shippingCost+$volumeDiscount;
                $cartTotal = $cartTotal + CommonHelper::orderProductAmount($opRow, 'cart_total');
                $shippingTotal = $shippingTotal + CommonHelper::orderProductAmount($opRow, 'shipping');
                $orderItems[$key][$index] =  [
                	'order_item_id' => $opRow['op_id'],
                	'product_id' => $opRow['selprod_product_id'],
                	'sku' => $opRow['selprod_sku'],
                	'variant_id' => $opRow['op_selprod_id'],
                	'variant_sku' => $opRow['op_selprod_sku'],
                	'quantity' => $opRow['op_qty'],
                	'total' => $cartTotal,
                ];
	        }
            $orderObj = new Orders($row['order_id']);
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
	        	'order_status' => $payementStatusArr[$row['order_status']],
	        	'created_date' => $row['created_date'],
	        	'updated_date' => $row['updated_date'],
	        	'payment_mode' => $paymentMode,
	        	'cart_total' => $cartTotal,
	        	'total' => $row['order_net_amount'],
	        	'billing_address' => $billingAddress,
	        	'shipping_address' => $shippingAddress,
	        	'order_items' => $orderItems[$key]
	        ];
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
}