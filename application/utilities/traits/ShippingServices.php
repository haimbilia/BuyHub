<?php
trait ShippingServices
{
    private $filename = '';
    private $labelData = '';
    private $trackingNumber = '';
    private $shipmentResponse = '';
    private $error = '';
    private $tpResponse = []; /* Third Party API Response */
    private $shippingService;

    /**
     * generateLabel - Used for shipstation only.
     *
     * @param  int $opId
     * @return void
     */
    public function generateLabel(int $opId)
    {
        $orderData = $this->getOrderProductDetail($opId, ['opshipping_by_seller_user_id', 'op_selprod_user_id', 'opshipping_plugin_id', 'plugin_code', 'op.op_order_id', 'optsu_user_id', 'op_status_id']);
        if (empty($orderData) || 1 > $orderData['opshipping_plugin_id']) {
            LibHelper::dieJsonError(Labels::getLabel("ERR_INVALID_ORDER", $this->langId));
        }

        if ((in_array(strtolower($orderData['plugin_code']), ['cashondelivery', 'payatstore']) ||  in_array($orderData['op_status_id'], (new Orders())->getAdminAllowedUpdateShippingUser())) && !CommonHelper::canAvailShippingChargesBySeller($orderData['op_selprod_user_id'], $orderData['opshipping_by_seller_user_id']) && !$orderData['optsu_user_id']) {
            LibHelper::dieJsonError([
                'msg' =>  Labels::getLabel('ERR_PLEASE_ASSIGN_SHIPPING_USER', $this->langId),
                'status' => 0,
                'openShipUser' => 1,
                'opId' => $opId,
                'orderId' => $orderData['op_order_id']
            ], true);
        }
        $this->validateShippingService($orderData);

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

        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_SUCCESS', $this->langId));
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
            $this->error = Labels::getLabel("ERR_NO_LABEL_DATA_FOUND", $this->langId);
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
            $this->error = Labels::getLabel("ERR_NO_LABEL_DATA_FOUND", $this->langId);
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
        $data = $this->getOrderProductDetail($opId, ['opshipping_by_seller_user_id', 'op_selprod_user_id']);
        $this->validateShippingService($data);
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
            LibHelper::dieWithError($this->error);
        }
        $data = $this->getOrderProductDetail($opId, ['opshipping_by_seller_user_id', 'op_selprod_user_id', 'opshipping_plugin_id']);
        if (empty($data)) {
            $msg = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            LibHelper::dieWithError($msg);
        }
        $this->validateShippingService($data);
        if ($this->shippingService->getKey('plugin_id') != $data['opshipping_plugin_id']) {
            $msg = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            LibHelper::dieWithError($msg);
        }
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
        $data = $this->getOrderProductDetail($opId, ['opshipping_by_seller_user_id', 'op_selprod_user_id']);
        if (empty($data) || 1 > $data['opshipping_plugin_id']) {
            $msg = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }
        $this->validateShippingService($data);

        if ('ShipStationShipping' == $this->shippingService->keyName) {
            $msg = Labels::getLabel("MSG_RETURN_CASE_NOT_ALLOWED_BY_SERVICE_PROVIDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }

        if (false === $this->loadReturnLabelData($opId)) {
            LibHelper::dieJsonError($this->error);
        }
        $this->shippingService->downloadReturnLabel($this->labelData, $this->filename);
    }

    /**
     * 
     * @param int $opId
     * @param array $attr
     * @return array
     */
    private function getOrderProductDetail(int $opId, array $attr = []): array
    {
        $db = FatApp::getDb();
        $opSrch = new OrderProductSearch($this->langId, false, true, true);
        $opSrch->joinOrders();
        $opSrch->joinPaymentMethod();
        $opSrch->joinShippingCharges();
        $opSrch->joinTable(OrderProductShipment::DB_TBL, 'LEFT JOIN', OrderProductShipment::DB_TBL_PREFIX . 'op_id = op.op_id', 'opship');
        $opSrch->joinTable(OrderProduct::DB_TBL_SHIPMENT_PICKUP, 'LEFT JOIN', OrderProduct::DB_TBL_SHIPMENT_PICKUP_PREFIX . 'op_id = op.op_id', 'oppick');
        $opSrch->joinShippingUsers();
        $opSrch->addCountsOfOrderedProducts();
        $opSrch->addOrderProductCharges();
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();
        $opSrch->addCondition('op.op_id', '=', $opId);
        $attr = !empty($attr) ? $attr : [
            'op_id', 'op_status_id', 'op.op_order_id', 'op.op_invoice_number', 'opship_orderid', 'opship_tracking_number', 'opshipping_carrier_code', 'opshipping_service_code',
            'opsp_api_req_id', 'opsp_scheduled', 'opshipping_by_seller_user_id', 'op_selprod_user_id', 'op_selprod_id', 'op_qty', 'op_product_length', 'op_product_width', 'op_product_height', 'op_product_dimension_unit',
            'op_product_weight', 'op_product_weight_unit', 'opshipping_rate_id', 'opshipping_plugin_id', 'plugin_code', 'optsu_user_id'
        ];
        $opSrch->addMultipleFields($attr);
        return (array) $db->fetch($opSrch->getResultSet());
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
        if (empty($data)) {
            $msg = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }

        if (1 > $data['opshipping_plugin_id']) {
            $msg = Labels::getLabel("ERR_PLEASE_FETCH_SHIPPING_RATES", $this->langId);
            LibHelper::dieJsonError($msg);
        }

        if ((in_array(strtolower($data['plugin_code']), ['cashondelivery', 'payatstore']) || in_array($data['op_status_id'], (new Orders())->getAdminAllowedUpdateShippingUser())) && !CommonHelper::canAvailShippingChargesBySeller($data['op_selprod_user_id'], $data['opshipping_by_seller_user_id']) && !$data['optsu_user_id']) {
            LibHelper::dieJsonError([
                'msg' =>  Labels::getLabel('ERR_PLEASE_ASSIGN_SHIPPING_USER', $this->langId),
                'status' => 0,
                'openShipUser' => 1,
                'opId' => $opId,
                'orderId' => $data['op_order_id']
            ], true);
        }

        $this->validateShippingService($data);

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
        if (!empty($labelResponse)) {
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

        FatUtility::dieJsonSuccess($json);
    }

    /**
     * returnShipment
     *
     * @param  int $opId
     * @param  int $qty
     * @return void
     */
    public function returnShipment(int $opId, int $qty, string $href = '')
    {
        $data = $this->getOrderProductDetail($opId, ['opshipping_by_seller_user_id', 'op_selprod_user_id', 'opshipping_service_code']);

        if (empty($data)) {
            $msg = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            if (!empty($href)) {
                Message::addErrorMessage($msg);
                FatApp::redirectUser($href);
            }
            LibHelper::dieJsonError($msg);
        }

        $this->validateShippingService($data, $href);

        if (1 > $qty) {
            $msg = Labels::getLabel("MSG_INVALID_RETURN_QTY", $this->langId);
            if (!empty($href)) {
                Message::addErrorMessage($msg);
                FatApp::redirectUser($href);
            }
            LibHelper::dieJsonError($msg);
        }

        if ('ShipStationShipping' == $this->shippingService->keyName || !method_exists($this->shippingService, 'returnShipment')) {
            $msg = Labels::getLabel("MSG_RETURN_CASE_NOT_ALLOWED_BY_SERVICE_PROVIDER", $this->langId);
            if (!empty($href)) {
                Message::addErrorMessage($msg);
                FatApp::redirectUser($href);
            }
            LibHelper::dieJsonError($msg);
        }

        if (method_exists($this->shippingService, 'loadSystemOrder')) {
            $this->shippingService->loadSystemOrder($opId);
        }

        if (false === $this->shippingService->returnShipment($data["opshipping_service_code"], $qty)) {
            if (!empty($href)) {
                Message::addErrorMessage($this->shippingService->getError());
                FatApp::redirectUser($href);
            }
            LibHelper::dieJsonError($this->shippingService->getError());
        }

        $opObj = new OrderProduct($opId);
        if (false === $opObj->bindResponse(OrderProduct::RESPONSE_TYPE_RETURN, json_encode($this->shippingService->getResponse()))) {
            if (!empty($href)) {
                Message::addErrorMessage($opObj->getError());
                FatApp::redirectUser($href);
            }
            LibHelper::dieJsonError($opObj->getError());
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
        $data = $this->getOrderProductDetail($opId, ['opshipping_by_seller_user_id', 'op_selprod_user_id', 'opshipping_service_code']);

        if (empty($data)) {
            $msg = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }
        $this->validateShippingService($data);

        if ('ShipStationShipping' == $this->shippingService->keyName || !method_exists($this->shippingService, 'refundShipment')) {
            $msg = Labels::getLabel("MSG_RETURN_CASE_NOT_ALLOWED_BY_SERVICE_PROVIDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }

        if (method_exists($this->shippingService, 'loadSystemOrder')) {
            $this->shippingService->loadSystemOrder($opId);
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
    public function fetchTrackingDetail(string $trackingId, int $opId)
    {
        $orderData = $this->getOrderProductDetail($opId, ['opshipping_by_seller_user_id', 'op_selprod_user_id', 'op_invoice_number', 'op.op_order_id']);
        if (empty($orderData)) {
            $this->error = Labels::getLabel("ERR_INVALID_ORDER", $this->langId);
            return false;
        }
        $this->validateShippingService($orderData);

        if (method_exists($this->shippingService, 'loadSystemOrder')) {
            $this->shippingService->loadSystemOrder($opId);
        }

        $trackingData = (array) $this->shippingService->fetchTrackingDetail($trackingId, $orderData['op_invoice_number']);
        $this->set('trackingData', $trackingData);
        $this->set('opId', $opId);
        $this->set('orderId', $orderData['op_order_id']);
        $this->set('orderNumber', $orderData['op_invoice_number']);
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
        $data = $this->getOrderProductDetail($opId, ['opshipping_by_seller_user_id', 'op_selprod_user_id']);
        if (empty($data)) {
            $msg = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }
        $this->validateShippingService($data);
        $frm = $this->getPickupForm();
        if (null == $frm->getField('btn_submit')) {
            $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SAVE', $this->langId));
        }
        $frm->fill(['op_id' => $opId]);
        $this->set('frm', $frm);
        $this->set('op_id', $opId);
        $this->_template->render(false, false);
    }

    /**
     * createPickup
     *
     * @return void
     */
    public function createPickup()
    {
        $data = $this->getOrderProductDetail(FatApp::getPostedData('op_id', FatUtility::VAR_INT, 0));
        if (empty($data)) {
            $msg = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }
        $this->validateShippingService($data);
        $frm = $this->getPickupForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        unset($post['btn_submit']);

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

        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_SUCCESS', $this->langId));
    }

    public function cancelPickup(int $opId)
    {
        $data = $this->getOrderProductDetail($opId);
        if (empty($data) || empty($data['opsp_scheduled']) || 1 > $data['opsp_scheduled']) {
            LibHelper::dieJsonError(Labels::getLabel("ERR_INVALID_REQUEST", $this->langId));
        }
        $this->validateShippingService($data);

        if (false === $this->shippingService->canCreatePickup() || false === $this->shippingService->cancelPickup($data)) {
            $msg = $this->shippingService->getError();
            if (empty($msg)) {
                $msg = Labels::getLabel('LBL_THIS_SERVICE_IS_NOT_AVAILABLE', $this->langId);
            }
            LibHelper::dieJsonError($msg);
        }

        $resp = $this->shippingService->getResponse();
        if (false === $resp) {
            LibHelper::dieJsonError($this->shippingService->getError());
        }

        if (!FatApp::getDb()->updateFromArray(OrderProduct::DB_TBL_SHIPMENT_PICKUP, ['opsp_scheduled' => applicationConstants::INACTIVE], array('smt' => 'opsp_op_id = ?', 'vals' => array($opId)))) {
            LibHelper::dieJsonError(FatApp::getDb()->getError());
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_SUCCESS', $this->langId));
    }

    public function shippingRatesForm(int $opId)
    {
        $frm = $this->getShippingRatesForm($opId);
        $frm->fill(['op_id' => $opId]);
        $this->set('frm', $frm);

        $this->set('html', $this->_template->render(false, false, NULL, true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    private function getShippingRatesForm($opId): object
    {
        $orderData = $this->getOrderProductDetail($opId);
        if (empty($orderData)) {
            LibHelper::exitWithError(Labels::getLabel("ERR_INVALID_ORDER", $this->langId), true);
        }

        $rates = $this->getShippingRatesFromApi($orderData);

        if (false === $rates) {
            LibHelper::exitWithError($this->error, true);
        }
        $rateOptions = $this->formatShippingRates($rates, $this->langId);

        $frm = new Form('frmRates');
        $frm->addSelectBox(Labels::getLabel('FRM_RATES', $this->langId), 'shipping_rates', $rateOptions)->requirements()->setRequired();
        $frm->addHiddenField('', 'op_id', $opId)->requirements()->setIntPositive();
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

    private function getShippingWarehouseList($orderData)
    {
        $this->validateShippingService($orderData);
        $wareHouses = [];
        foreach ($this->shippingService->getWareHouses() as $warehouse) {
            $wareHouses[$warehouse['warehouseId']] = $warehouse['warehouseName'];
        }
    }

    private function getShippingRatesFromApi($orderData)
    {die('hi');
        $this->validateShippingService($orderData);

        $weightUnitsArr = applicationConstants::getWeightUnitsArr($this->langId, true);
        $dimensionUnits = ShippingPackage::getUnitTypes($this->langId);

        $cacheKey = Shipping::CARRIER_CACHE_KEY_NAME . $this->langId . $this->shippingService->keyName;
        $carriers = CacheHelper::get($cacheKey, CONF_API_REQ_CACHE_TIME, '.txt');
        if ($carriers) {
            $carriers = unserialize($carriers);
        } else {
            $limit = ('ShipStationShipping' == (get_class($this->shippingService))::KEY_NAME ? 0 : 1);
            $carriers = $this->shippingService->getCarriers($limit);
            if (!empty($carriers)) {
                CacheHelper::create($cacheKey, serialize($carriers), CacheHelper::TYPE_SHIPING_API);
            }
        }
        if (empty($carriers)) {
            $this->error = Labels::getLabel("ERR_UNABLE_TO_FETCH_CARRIERS", $this->langId);
            return false;
        }

        $orderObj = new Orders($orderData['op_order_id']);
        //$addresses = $orderObj->getOrderAddresses($orderData['op_order_id'], $orderData['op_id']);
        $addresses = $orderObj->getOrderAddresses($orderData['op_order_id']);

        $shippingAddress = [];
        if (!empty($addresses)) {
            $shippingAddress = (!empty($addresses[Orders::SHIPPING_ADDRESS_TYPE])) ? $addresses[Orders::SHIPPING_ADDRESS_TYPE] : array();
            $this->shippingService->setAddress($shippingAddress['oua_name'], $shippingAddress['oua_address1'], $shippingAddress['oua_address2'], $shippingAddress['oua_city'], $shippingAddress['oua_state'], $shippingAddress['oua_zip'], $shippingAddress['oua_country_code'], $shippingAddress['oua_phone']);
        }

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
        if (method_exists($this->shippingService, 'setSelectedShipping') && isset($this->selectedShippingService) && is_array($this->selectedShippingService) && 0 < count($this->selectedShippingService)) {
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
            $shippingRates = CacheHelper::get($cacheKey, CONF_API_REQ_CACHE_TIME, '.txt');
            if ($shippingRates) {
                $shippingRates = unserialize($shippingRates);
            } else {
                $shippingRates = $this->shippingService->getRates($carrierCode, $shopAddress['postalCode']);
                if (!empty($shippingRates)) {
                    CacheHelper::create($cacheKey, serialize($shippingRates), CacheHelper::TYPE_SHIPING_API);
                } else {
                    SystemLog::system($this->shippingService->getError(), $this->shippingService->keyName . ' - ' . Labels::getLabel('ERR_UNABLE_TO_FETCH_SHIPPING_RATES'));
                    continue;
                }
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
            LibHelper::dieJsonError(Labels::getLabel("ERR_INVALID_REQUEST", $this->langId));
        }

        $rates = $this->getShippingRatesFromApi($orderData);

        if (1 > count($rates) || !isset($rates[$post['shipping_rates']])) {
            LibHelper::dieJsonError(Labels::getLabel("ERR_INVALID_REQUEST", $this->langId));
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
        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_SUCCESS', $this->langId));
    }

    private function validateShippingService($orderData, $href = '')
    {
        $this->loadShippingService($orderData, $href = '');
        if (false === $this->shippingService) {
            LibHelper::dieJsonError(Labels::getLabel("ERR_NO_DEFAULT_SHIPPING_SERVICE_PLUGIN_FOUND", $this->langId));
        }
    }

    private function loadShippingService($orderData, $href = '')
    {
        $shippingBySeller = CommonHelper::canAvailShippingChargesBySeller($orderData['op_selprod_user_id'], $orderData['opshipping_by_seller_user_id']);
        $shippingObj = new Shipping($this->langId);
        $this->shippingService = $shippingObj->getShippingApiObj(($shippingBySeller ? $orderData['opshipping_by_seller_user_id'] : 0));
    }

    public function syncCarriers(int $sellerId = 0)
    {
        if (1 > $sellerId && false == AdminAuthentication::isAdminLogged()) {
            LibHelper::dieJsonError(Labels::getLabel("ERR_INVALID_REQUEST", $this->langId));
        }

        $shippingObj = new Shipping($this->langId);
        $shippingApiObj = $shippingObj->getShippingApiObj($sellerId);
        if (false === $shippingApiObj) {
            LibHelper::dieJsonError($shippingObj->getError());
        }

        $pluginData = $shippingObj->getShippingPluginData();
        $pluginId = $pluginData['plugin_id'] ?? 0;
        $shippingApiClass = get_class($shippingApiObj);
        $shippingApiKey = $shippingApiClass::KEY_NAME;
        $limit = ('ShipStationShipping' == $shippingApiKey ? 0 : 1);
        $carriers = $shippingApiObj->getCarriers($limit);
        if (empty($carriers)) {
            LibHelper::dieJsonError(Labels::getLabel("ERR_NO_CARRIER_FOUND", $this->langId));
        }

        if (0 < $pluginId) {
            $updateData = [
                'pluginsetting_plugin_id' => $pluginId,
                'pluginsetting_record_id' => $sellerId,
                'pluginsetting_key' => 'carriers',
                'pluginsetting_value' => serialize($carriers),
            ];

            if (!FatApp::getDb()->insertFromArray(PluginSetting::DB_TBL, $updateData, false, [], $updateData)) {
                $this->error = FatApp::getDb()->getError();
                return false;
            }
        }
        $cacheKey = Shipping::CARRIER_CACHE_KEY_NAME . $this->langId . $shippingApiClass . $sellerId;
        CacheHelper::create($cacheKey, serialize($carriers), CacheHelper::TYPE_SHIPING_API);
        FatUtility::dieJsonSuccess(Labels::getLabel('LBL_SUCCESSFULLY_SYNCED', $this->langId));
    }
}
