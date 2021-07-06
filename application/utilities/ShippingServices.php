<?php

trait ShippingServices
{
    private $filename = '';
    private $labelData = '';
    private $trackingNumber = '';
    private $shipmentResponse = '';
    private $error = '';
    private $tpResponse = []; /* Third Party API Response */

    /**
     * generateLabel - Used for shipstation only.
     *
     * @param  int $opId
     * @return void
     */
    public function generateLabel(int $opId)
    {
        $orderData = $this->getOrderProductDetail($opId);
        if (empty($orderData) || 1 > $orderData['opshipping_plugin_id']) {
            LibHelper::dieJsonError(Labels::getLabel("MSG_INVALID_ORDER", $this->langId));
            return false;
        }

        $this->loadShippingService($orderData);

        if (false === $this->shippingService->addOrder($opId)) {
            LibHelper::dieJsonError($this->shippingService->getError());
        }
        $order = $this->shippingService->getResponse();

        $shipmentApiOrderId = $order['orderId'];
        $requestParam = [
            'orderId' => $order['orderId'],
            'carrierCode' => $order['carrierCode'],
            'serviceCode' => $order['serviceCode'],
            'confirmation' => $order['confirmation'],
            'shipDate' => date('Y-m-d'), // date('Y-m-d', strtotime('+7 day')),
            'weight' => $order['weight'],
            'dimensions' => $order['dimensions'],
        ];

        if (false === $this->shippingService->bindLabel($requestParam)) {
            LibHelper::dieJsonError($this->shippingService->getError());
        }

        $response = $this->shippingService->getResponse(false);
        $responseArr = json_decode($response, true);
        $recordCol = ['opship_op_id' => $opId];

        $dataToSave = [
            'opship_orderid' => $shipmentApiOrderId,
            'opship_shipment_id' => $responseArr['shipmentId'],
            'opship_tracking_number' => $responseArr['trackingNumber'],
        ];

        $db = FatApp::getDb();
        if (!$db->insertFromArray(OrderProductShipment::DB_TBL, array_merge($recordCol, $dataToSave), false, array(), $dataToSave)) {
            LibHelper::dieJsonError($db->getError());
        }

        $opObj = new OrderProduct($opId);
        if (false === $opObj->bindResponse(OrderProduct::RESPONSE_TYPE_SHIPMENT, $response)) {
            LibHelper::dieJsonError($opObj->getError());
        }

        LibHelper::dieJsonSuccess(Labels::getLabel('LBL_SUCCESS', $this->langId));
    }

    /**
     * loadLabelData
     *
     * @param  int $opId
     * @return void
     */
    private function loadLabelData(int $opId): bool
    {
        $orderProductDetail = OrderProductShipment::getAttributesById($opId, ['opr_response', 'op_invoice_number'], true);
        if (empty($orderProductDetail)) {
            $this->error = Labels::getLabel("MSG_NO_LABEL_DATA_FOUND", $this->langId);
            return false;
        }
        $this->shipmentResponse = json_decode($orderProductDetail['opr_response'], true);       
        $this->filename = "label-" . $orderProductDetail['op_invoice_number'];
        $this->labelData = array_key_exists('labelData', $this->shipmentResponse) ? $this->shipmentResponse['labelData'] : $this->shipmentResponse;
        return true;
    }

    /**
     * loadReturnLabelData
     *
     * @param  int $opId
     * @return void
     */
    private function loadReturnLabelData(int $opId): bool
    {
        $orderReturnRequest = OrderReturnRequest::getReturnRequestById($opId, ['opr_response', 'op_invoice_number'], true);
        if (empty($orderReturnRequest)) {
            $this->error = Labels::getLabel("MSG_NO_LABEL_DATA_FOUND", $this->langId);
            return false;
        }
        $this->filename = "return-label-" . $orderReturnRequest['op_invoice_number'];
        $this->labelData = json_decode($orderReturnRequest['opr_response'], true);
        return true;
    }

    /**
     * downloadLabel
     *
     * @param  int $opId
     * @return void
     */
    public function downloadLabel(int $opId)
    {
        if (false === $this->loadLabelData($opId)) {
            LibHelper::dieJsonError($this->error);
        }
        $data = $this->getOrderProductDetail($opId);
        $this->loadShippingService($data);       
        $this->shippingService->downloadLabel($this->labelData, $this->filename);
    }

    /**
     * previewLabel
     *
     * @param  int $opId
     * @return void
     */
    public function previewLabel(int $opId)
    {
        if (false === $this->loadLabelData($opId)) {
            LibHelper::dieJsonError($this->error);
        }
        $data = $this->getOrderProductDetail($opId);
        $this->loadShippingService($data);
        $this->shippingService->downloadLabel($this->labelData, $this->filename, true);
    }

    /**
     * previewReturnLabel
     *
     * @param  int $opId
     * @return void
     */
    public function previewReturnLabel(int $opId)
    {
        $data = $this->getOrderProductDetail($opId);
        if (empty($data) || 1 > $data['opshipping_plugin_id']) {
            $msg = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }
        $this->loadShippingService($data);

        if ('ShipStationShipping' == $this->shippingService->keyName) {
            $msg = Labels::getLabel("MSG_RETURN_CASE_NOT_ALLOWED_BY_SERVICE_PROVIDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }

        if (false === $this->loadReturnLabelData($opId)) {
            LibHelper::dieJsonError($this->error);
        }
        $data = $this->getOrderProductDetail($opId);
        $this->loadShippingService($data);
        $this->shippingService->downloadReturnLabel($this->labelData, $this->filename);
    }

    /**
     * getOrderProductDetail
     *
     * @param  int $opId
     * @return array
     */
    private function getOrderProductDetail(int $opId): array
    {
        $db = FatApp::getDb();
        $opSrch = new OrderProductSearch($this->langId, false, true, true);
        $opSrch->joinShippingCharges();
        $opSrch->joinTable(OrderProductShipment::DB_TBL, 'LEFT JOIN', OrderProductShipment::DB_TBL_PREFIX . 'op_id = op.op_id', 'opship');
        $opSrch->joinTable(OrderProduct::DB_TBL_SHIPMENT_PICKUP, 'LEFT JOIN', OrderProduct::DB_TBL_SHIPMENT_PICKUP_PREFIX . 'op_id = op.op_id', 'oppick');
        $opSrch->addCountsOfOrderedProducts();
        $opSrch->addOrderProductCharges();
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();
        $opSrch->addCondition('op.op_id', '=', $opId);

        $opSrch->addMultipleFields(
            array('op_status_id', 'op.op_order_id', 'op.op_invoice_number', 'opship_orderid', 'opship_tracking_number', 'opshipping_carrier_code', 'opshipping_service_code',
                    'opsp_api_req_id', 'opsp_scheduled', 'opshipping_by_seller_user_id', 'op_selprod_user_id', 'op_selprod_id', 'op_qty', 'op_product_length', 'op_product_width', 'op_product_height', 'op_product_dimension_unit',
                    'op_product_weight', 'op_product_weight_unit', 'opshipping_rate_id', 'opshipping_plugin_id'
                )
        );

        $opRs = $opSrch->getResultSet();
        return (array) $db->fetch($opRs);
    }

    /**
     * proceedToShipment
     *
     * @param  int $opId
     * @return void
     */
    public function proceedToShipment(int $opId)
    {
        $db = FatApp::getDb();
        $data = $this->getOrderProductDetail($opId);
        if (empty($data) || 1 > $data['opshipping_plugin_id']) {
            $msg = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }
          
        $this->loadShippingService($data);

        if (empty($data["opship_orderid"]) && 'ShipStationShipping' == $this->shippingService->keyName) {
            $msg = Labels::getLabel("MSG_MUST_GENERATE_LABEL_BEFORE_SHIPMENT", $this->langId);
            LibHelper::dieJsonError($msg);
        }

        if ('ShipStationShipping' == $this->shippingService->keyName) {
            $opshipmentId = $data["opship_orderid"];
        } else {
            $opshipmentId = $data["opshipping_service_code"];
        }
        
        if (method_exists($this->shippingService, 'loadOrder')) {
            if (false === $this->shippingService->loadOrder($opshipmentId)) {
                LibHelper::dieJsonError($this->shippingService->getError());
            }
            $shipmentData = $this->shippingService->getResponse();            
           
            if (array_key_exists('orderStatus', $shipmentData) && 'shipped' == strtolower($shipmentData['orderStatus'])) {
                $status = ucwords($shipmentData['orderStatus']);
                $msg = Labels::getLabel("LBL_ALREADY_{STATUS}", $this->langId);
                $msg = CommonHelper::replaceStringData($msg, ['{STATUS}' => $status]);
                LibHelper::dieJsonError($msg);
            }
        }

        $requestParam = [
            "op_order_id" => $data['op_order_id'],
            "op_invoice_number" => $data['op_invoice_number'],
            "orderId" => $data['opship_orderid'],
            "op_id" => $opId,
            "opshipmentId" => $opshipmentId,
            "carrierCode" => $data['opshipping_carrier_code'],
            "shipDate" => date('Y-m-d'),
            "trackingNumber" => $data['opship_tracking_number'],
            "notifyCustomer" => true,
            "notifySalesChannel" => true,
        ];
        if (false === $this->shippingService->proceedToShipment($requestParam)) {
            LibHelper::dieJsonError($this->shippingService->getError());
        }

        $orderInfo = $this->shippingService->getResponse();

        $trackingNumber = ('ShipStationShipping' == $this->shippingService->keyName) ? $data['opship_tracking_number'] : $orderInfo['tracking_code'];
        $updateData = [
            'opship_op_id' => $opId,
            'opship_order_number' => $orderInfo['orderNumber'],
            "opship_tracking_number" => $trackingNumber,
        ];

        if (in_array($this->shippingService->keyName, ['EasyPost'])) {
            $updateData["opship_tracking_url"] = $orderInfo['tracking_url'];
        }

        if (!$db->insertFromArray(OrderProductShipment::DB_TBL, $updateData, false, array(), $updateData)) {
            LibHelper::dieJsonError($db->getError());
        }
        
        $labelResponse = OrderProductShipment::getAttributesById($opId, 'opr_response');
        if(!empty($labelResponse)){
            $orderInfo = $orderInfo + json_decode($labelResponse, true);
        }        

        $opObj = new OrderProduct($opId);
        if (false === $opObj->bindResponse(OrderProduct::RESPONSE_TYPE_SHIPMENT, json_encode($orderInfo))) {
            LibHelper::dieJsonError($opObj->getError());
        }

        $json = [
            'msg' => Labels::getLabel('LBL_SUCCESS', $this->langId),
            'tracking_number' => $trackingNumber
        ];

        LibHelper::dieJsonSuccess($json);
    }

    /**
     * returnShipment
     *
     * @param  int $opId
     * @param  int $qty
     * @return void
     */
    public function returnShipment(int $opId, int $qty)
    {
        $data = $this->getOrderProductDetail($opId);

        if (empty($data)) {
            $msg = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }
        $this->loadShippingService($data);

        if (1 > $qty) {
            $msg = Labels::getLabel("MSG_INVALID_RETURN_QTY", $this->langId);
            LibHelper::dieJsonError($msg);
        }

        if ('ShipStationShipping' == $this->shippingService->keyName || !method_exists($this->shippingService, 'returnShipment')) {
            $msg = Labels::getLabel("MSG_RETURN_CASE_NOT_ALLOWED_BY_SERVICE_PROVIDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }

        if (false === $this->shippingService->returnShipment($data["opshipping_service_code"], $qty)) {
            LibHelper::dieJsonError($this->shippingService->getError());
        }

        $opObj = new OrderProduct($opId);
        if (false === $opObj->bindResponse(OrderProduct::RESPONSE_TYPE_RETURN, json_encode($this->shippingService->getResponse()))) {
            $this->error = $opObj->getError();
            return false;
        }
    }

    /**
     * refundShipment
     *
     * @param  int $opId
     * @return void
     */
    public function refundShipment(int $opId)
    {
        $data = $this->getOrderProductDetail($opId);

        if (empty($data)) {
            $msg = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }
        $this->loadShippingService($data);

        if ('ShipStationShipping' == $this->shippingService->keyName || !method_exists($this->shippingService, 'refundShipment')) {
            $msg = Labels::getLabel("MSG_RETURN_CASE_NOT_ALLOWED_BY_SERVICE_PROVIDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }

        if (false === $this->shippingService->refundShipment($data["opshipping_service_code"])) {
            LibHelper::dieJsonError($this->shippingService->getError());
        }

        $opObj = new OrderProduct($opId);
        if (false === $opObj->bindResponse(OrderProduct::RESPONSE_TYPE_REFUND, json_encode($this->shippingService->getResponse()))) {
            LibHelper::dieJsonError($opObj->getError());
        }
    }

    /**
     * fetchTrackingDetail
     *
     * @param  string $trackingId
     * @param  string $opInvoiceId
     * @return void
     */
    public function fetchTrackingDetail(string $trackingId, string $opInvoiceId)
    {
        $trackingData = (array) $this->shippingService->fetchTrackingDetail($trackingId, $opInvoiceId);
        $this->set('trackingData', $trackingData);
        $this->_template->render(false, false);
    }

    /**
     * getPickupForm
     *
     * @return object
     */
    private function getPickupForm(): object
    {
        if (false === $this->shippingService->canCreatePickup()) {
            $msg = Labels::getLabel('LBL_THIS_SERVICE_IS_NOT_AVAILABLE', $this->langId);
            LibHelper::dieJsonError($msg);
        }

        $frm = new Form('frm' . $this->shippingService->keyName);
        $frm->addHiddenField('', 'op_id');
        $formElements = $this->shippingService->getPickupFormElementsArr();
        foreach ($formElements as $colName => $colLabel) {
            $htmlAfterField = $fieldFn = "";
            $required = true;
            $attributes = [];
            if (is_array($colLabel)) {
                $htmlAfterField = array_key_exists('htmlAfterField', $colLabel) ? $colLabel['htmlAfterField'] : '';
                $fieldFn = array_key_exists('fieldType', $colLabel) ? $colLabel['fieldType'] : '';
                $required = array_key_exists('required', $colLabel) ? $colLabel['required'] : true;
                $attributes = array_key_exists('attributes', $colLabel) ? $colLabel['attributes'] : [];
                $colLabel = array_key_exists('label', $colLabel) ? $colLabel['label'] : '';
            }
            $fieldFn = !empty($fieldFn) ? $fieldFn : (('password' == strtolower($colName)) ? 'addPasswordField' : 'addTextBox');

            $fld = $frm->$fieldFn($colLabel, $colName, '', $attributes);
            $fld->requirement->setRequired($required);
            $fld->htmlAfterField = $htmlAfterField;
        }

        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_SAVE', $this->langId));
        return $frm;
    }

    /**
     * pickupForm
     *
     * @param  mixed $opId
     * @return void
     */
    public function pickupForm(int $opId)
    {
        $frm = $this->getPickupForm();
        $frm->fill(['op_id' => $opId]);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    /**
     * createPickup
     *
     * @return void
     */
    public function createPickup()
    {
        $frm = $this->getPickupForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['btn_submit']);

        $data = $this->getOrderProductDetail($post['op_id']);
        $this->loadShippingService($data);

        $data += $post;
        if (false === $this->shippingService->canCreatePickup() || false === $this->shippingService->createPickup($data)) {
            $msg = $this->shippingService->getError();
            if (empty($msg)) {
                $msg = Labels::getLabel('LBL_THIS_SERVICE_IS_NOT_AVAILABLE', $this->langId);
            }
            LibHelper::dieJsonError($msg);
        }

        $resp = $this->shippingService->getResponse();
        $apiRequestedData = FilterHelper::parseArrayByKeys($post, array_keys($this->shippingService->getPickupFormElementsArr()));

        $dataToSave = array(
            'opsp_op_id' => $post['op_id'],
            'opsp_api_req_id' => $resp['pickUpId'],
            'opsp_scheduled' => applicationConstants::ACTIVE,
            'opsp_requested_data' => json_encode($apiRequestedData),
            'opsp_response' => json_encode($resp),
        );

        if (!FatApp::getDb()->insertFromArray(OrderProduct::DB_TBL_SHIPMENT_PICKUP, $dataToSave, false, array(), $dataToSave)) {
            LibHelper::dieJsonError(FatApp::getDb()->getError());
        }

        LibHelper::dieJsonSuccess(Labels::getLabel('LBL_SUCCESS', $this->langId));
    }

    public function cancelPickup(int $opId)
    {
        $data = $this->getOrderProductDetail($opId);
        if (empty($data) || empty($data['opsp_scheduled']) || 1 > $data['opsp_scheduled']) {
            LibHelper::dieJsonError(Labels::getLabel("MSG_INVALID_REQUEST", $this->langId));
        }
        $this->loadShippingService($data);

        if (false === $this->shippingService->canCreatePickup() || false === $this->shippingService->cancelPickup($data)) {
            $msg = $this->shippingService->getError();
            if (empty($msg)) {
                $msg = Labels::getLabel('LBL_THIS_SERVICE_IS_NOT_AVAILABLE', $this->langId);
            }
            LibHelper::dieJsonError($msg);
        }

        $resp = $this->shippingService->getResponse();

        if (!FatApp::getDb()->updateFromArray(OrderProduct::DB_TBL_SHIPMENT_PICKUP, ['opsp_scheduled' => applicationConstants::INACTIVE], array('smt' => 'opsp_op_id = ?', 'vals' => array($opId)))) {
            LibHelper::dieJsonError(FatApp::getDb()->getError());
        }
        LibHelper::dieJsonSuccess(Labels::getLabel('LBL_SUCCESS', $this->langId));
    }

    public function shippingRatesForm(int $opId)
    {
        $frm = $this->getShippingRatesForm($opId);
        $frm->fill(['op_id' => $opId]);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }

    private function getShippingRatesForm($opId): object
    {
        $rates = $this->getShippingRatesFromApi($opId);
        $rateOptions = self::formatShippingRates($this->getShippingRatesFromApi($opId), $this->langId);

        $frm = new Form('frmRates');
        $frm->addSelectBox(Labels::getLabel('LBL_RATES', $this->langId), 'shipping_rates', $rateOptions)->requirements()->setRequired();
        $frm->addHiddenField('', 'op_id', $opId)->requirements()->setIntPositive();
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_SAVE', $this->langId));
        return $frm;
    }

    private function formatShippingRates(array $rates, int $langId): array
    {
        $rateOptions = [];
        if (!empty($rates)) {
            foreach ($rates as $key => $rate) {
                $label = $rate['title'] . "( " . CommonHelper::displayMoneyFormat($rate['cost']) . " )";
                $rateOptions[$key] = $label;
            }
        }
        return $rateOptions;
    }

    private function getShippingRatesFromApi($opId)
    {
        $orderData = $this->getOrderProductDetail($opId);
        if (empty($orderData)) {
            $this->error = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            return false;
        }

        $this->loadShippingService($orderData, true);

        $weightUnitsArr = applicationConstants::getWeightUnitsArr($this->langId, true);
        $dimensionUnits = ShippingPackage::getUnitTypes($this->langId);

        $cacheKey = Shipping::CARRIER_CACHE_KEY_NAME . $this->langId . $this->shippingService->keyName;
        $carriers = FatCache::get($cacheKey, CONF_API_REQ_CACHE_TIME, '.txt');
        if ($carriers) {
            $carriers = unserialize($carriers);
        } else {
            $limit = ('ShipStationShipping' == (get_class($this->shippingService))::KEY_NAME ? 0 : 1);
            $carriers = $this->shippingService->getCarriers($limit);
            if (!empty($carriers)) {
                FatCache::set($cacheKey, serialize($carriers), '.txt');
            }
        }
        if (empty($carriers)) {
            $this->error = Labels::getLabel("MSG_UNABLE_TO_FETCH_CARRIERS", $this->langId);
            return false;
        }

        $orderObj = new Orders($orderData['op_order_id']);
        $addresses = $orderObj->getOrderAddresses($orderData['op_order_id'], $orderData['op_order_id']);

        $shippingAddress = (!empty($addresses[Orders::SHIPPING_ADDRESS_TYPE])) ? $addresses[Orders::SHIPPING_ADDRESS_TYPE] : array();

        $this->shippingService->setAddress($shippingAddress['oua_name'], $shippingAddress['oua_address1'], $shippingAddress['oua_address2'], $shippingAddress['oua_city'], $shippingAddress['oua_state'], $shippingAddress['oua_zip'], $shippingAddress['oua_country_code'], $shippingAddress['oua_phone']);

        $shippingHandledBySeller = CommonHelper::canAvailShippingChargesBySeller($orderData['op_selprod_user_id'], $orderData['opshipping_by_seller_user_id']);
        $shopAddress = $this->shippingService->getShopAddress(($shippingHandledBySeller ? $orderData['op_selprod_user_id'] : 0));
        if (method_exists($this->shippingService, 'setAddressReference')) {
            $referenceId = str_pad($shopAddress['shop_id'], 6, "0", STR_PAD_LEFT);
            $this->shippingService->setAddressReference($referenceId);
        }

        if (method_exists($this->shippingService, 'setFromAddress')) {
            $this->shippingService->setFromAddress($shopAddress['shop_name'], $shopAddress['line1'], $shopAddress['line2'], $shopAddress['city'], $shopAddress['state'], $shopAddress['postalCode'], $shopAddress['countryCode'], $shopAddress['phone']);
        }

        if (method_exists($this->shippingService, 'setReference')) {
            $this->shippingService->setReference('selProd-' . $orderData['op_selprod_id'] . $orderData['op_qty']);
        }

        if (method_exists($this->shippingService, 'setQuantity')) {
            $this->shippingService->setQuantity($orderData['op_qty']);
        }

        /* Retrieve Selected Shipping Service Detail. */
        if (method_exists($this->shippingService, 'setSelectedShipping') && is_array($this->selectedShippingService) && 0 < count($this->selectedShippingService)) {
            $this->shippingService->setSelectedShipping($this->selectedShippingService[$orderData['op_selprod_id']]);
        }


        $prodWeight = $orderData['op_product_weight'] * $orderData['op_qty'];
        $productWeightClass = isset($weightUnitsArr[$orderData['op_product_weight_unit']]) ? $weightUnitsArr[$orderData['op_product_weight_unit']] : '';
        $productDimensionClass = isset($dimensionUnits[$orderData['op_product_dimension_unit']]) ? $dimensionUnits[$orderData['op_product_dimension_unit']] : '';
        $productWeightInOunce = Shipping::convertWeightInOunce($prodWeight, $productWeightClass);

        $this->shippingService->setWeight($productWeightInOunce);

        if (method_exists($this->shippingService, 'setDimensions')) {
            $this->shippingService->setDimensions($orderData['op_product_length'], $orderData['op_product_width'], $orderData['op_product_height'], $productDimensionClass);
        }

        $cacheKeyArr = [
            $orderData['op_product_length'],
            $orderData['op_product_width'],
            $orderData['op_product_height'],
            $productWeightInOunce,
            $productDimensionClass,
            $shopAddress,
            $shippingAddress,
        ];

        $shippingCost = [];
        foreach ($carriers as $carrier) {
            $carrierCode = !empty($carrier) && array_key_exists('code', $carrier) ? $carrier['code'] : '';
            $cacheKeyArr = array_merge($cacheKeyArr, [$carrierCode, $this->langId]);
            $cacheKey = Shipping::RATE_CACHE_KEY_NAME . md5(json_encode($cacheKeyArr));
            $shippingRates = FatCache::get($cacheKey, CONF_API_REQ_CACHE_TIME, '.txt');
            if ($shippingRates) {
                $shippingRates = unserialize($shippingRates);
            } else {
                $shippingRates = $this->shippingService->getRates($carrierCode, $shopAddress['postalCode']);
                if (!empty($shippingRates)) {
                    FatCache::set($cacheKey, serialize($shippingRates), '.txt');
                }
            }
            if (empty($shippingRates)) {
                SystemLog::set($this->shippingService->getError());
                continue;
            }

            $keyCounter = 1;
            foreach ($shippingRates as $key => $value) {
                $shippingCost[$keyCounter] = [
                    'title' => $value['serviceName'],
                    'cost' => $value['shipmentCost'] + $value['otherCost'],
                    'service_code' => $value['serviceCode'],
                    'carrier_code' => $carrierCode,
                    'plugin_id' => $this->shippingService->getKey('plugin_id'),
                    'is_seller_plugin' => (0 < $this->shippingService->getRecordId() ? 1 : 0),
                ];
                $keyCounter++;
            }
            /* If rates fetched from one shipment carriers then ignore for others */
            if (0 < count($shippingCost)) {
                break;
            }
        }

        return $shippingCost;
    }

    public function setUpShippingRate()
    {
        $opId = FatApp::getPostedData('op_id', FatUtility::VAR_INT, 0);
        $frm = $this->getShippingRatesForm($opId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        if (!false === $post) {
            LibHelper::dieJsonError(current($frm->getValidationErrors()));
        }

        $opId = $post['op_id'];
        $orderData = $this->getOrderProductDetail($opId);
        if (empty($orderData)) {
            LibHelper::dieJsonError(Labels::getLabel("MSG_INVALID_REQUEST", $this->langId));
        }

        $rates = $this->getShippingRatesFromApi($opId);

        if (1 > count($rates) || !isset($rates[$post['shipping_rates']])) {
            LibHelper::dieJsonError(Labels::getLabel("MSG_INVALID_REQUEST", $this->langId));
        }

        $dataToUpdate = array(
            'opshipping_plugin_charges' => $rates[$post['shipping_rates']]['cost'],
            'opshipping_carrier_code' => $rates[$post['shipping_rates']]['carrier_code'],
            'opshipping_service_code' => $rates[$post['shipping_rates']]['service_code'],
            'opshipping_plugin_id' => $rates[$post['shipping_rates']]['plugin_id'],
            'opshipping_is_seller_plugin' => $rates[$post['shipping_rates']]['is_seller_plugin'],
        );

        if (!FatApp::getDb()->updateFromArray(Orders::DB_TBL_ORDER_PRODUCTS_SHIPPING, $dataToUpdate, array('smt' => 'opshipping_op_id = ?', 'vals' => array($opId)))) {
            LibHelper::dieJsonError(FatApp::getDb()->getError());
        }
        LibHelper::dieJsonSuccess(Labels::getLabel('LBL_SUCCESS', $this->langId));
    }

    private function loadShippingService($orderData, $loadPluginSetting = false)
    {
        $shippingBySeller = CommonHelper::canAvailShippingChargesBySeller($orderData['op_selprod_user_id'], $orderData['opshipping_by_seller_user_id']);
        $this->shippingService = (new Shipping($this->langId))->getShippingApiObj(($shippingBySeller ? $orderData['opshipping_by_seller_user_id'] : 0));
        if (false === $this->shippingService) {
            $this->error = $error;
            if (true === $return) {
                return false;
            }
            FatUtility::dieJsonError($error);
        }

        if (false === $this->shippingService->init()) {
            $this->error = $this->shippingService->getError();
            if (true === $return) {
                return false;
            }
            FatUtility::dieJsonError($this->error);
        }
    }
}
