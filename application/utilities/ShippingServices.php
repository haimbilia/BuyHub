<?php

trait ShippingServices
{
    private $keyName;
    private $filename = '';
    private $labelData = '';
    private $trackingNumber = '';
    private $shipmentResponse = '';
    private $error = '';
    private $tpResponse = []; /* Third Party API Response */
        
    /**
     * init - This function is already called where this trait included.
     *
     * @param  bool $return
     * @return void
     */
    private function init(bool $return = false)
    {
        $plugin = new Plugin();
        $this->keyName = $plugin->getDefaultPluginKeyName(Plugin::TYPE_SHIPPING_SERVICES);
        if (false === $this->keyName) {
            $this->error = $plugin->getError();
            if (true === $return) {
                return false;
            }
            FatUtility::dieJsonError($this->error);
        }
        
        $this->shippingService = PluginHelper::callPlugin($this->keyName, [$this->langId], $error, $this->langId);
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
    
    /**
     * generateLabel - Used for shipstation only.
     *
     * @param  int $opId
     * @return void
     */
    public function generateLabel(int $opId)
    {
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
            'shipDate' => date('Y-m-d'),// date('Y-m-d', strtotime('+7 day')),
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
        if ('ShipStationShipping' == $this->keyName) {
            $msg = Labels::getLabel("MSG_RETURN_CASE_NOT_ALLOWED_BY_SERVICE_PROVIDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }

        if (false === $this->loadReturnLabelData($opId)) {
            LibHelper::dieJsonError($this->error);
        }
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
        $opSrch->addCountsOfOrderedProducts();
        $opSrch->addOrderProductCharges();
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();
        $opSrch->addCondition('op.op_id', '=', $opId);

        $opSrch->addMultipleFields(
            array('op_status_id', 'op.op_order_id', 'op.op_invoice_number', 'opship_orderid', 'opship_tracking_number', 'opshipping_carrier_code', 'opshipping_service_code')
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
        if (empty($data)) {
            $msg = Labels::getLabel("MSG_INVALID_ORDER", $this->langId);
            LibHelper::dieJsonError($msg);
        }
        
        if (empty($data["opship_orderid"]) && 'ShipStationShipping' == $this->keyName) {
            $msg = Labels::getLabel("MSG_MUST_GENERATE_LABEL_BEFORE_SHIPMENT", $this->langId);
            LibHelper::dieJsonError($msg);
        }

        if ('ShipStationShipping' == $this->keyName) {
            $opshipmentId = $data["opship_orderid"];
        } else {
            $opshipmentId = $data["opshipping_service_code"];
        }

        if (method_exists($this->shippingService, 'loadOrder')) {
            if (false === $this->shippingService->loadOrder($opshipmentId)) {
                LibHelper::dieJsonError($this->shippingService->getError());
            }
            $shipmentData = $this->shippingService->getResponse();
            if (array_key_exists('orderStatus', $shipmentData) && ('shipped' == strtolower($shipmentData['orderStatus']) || 'unknown' != strtolower($shipmentData['orderStatus']))) {
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
        
        $trackingNumber = ('ShipStationShipping' == $this->keyName) ? $data['opship_tracking_number'] : $orderInfo['tracking_code'];
        $updateData = [
            'opship_op_id' => $opId,
            'opship_order_number' => $orderInfo['orderNumber'],
            "opship_tracking_number" => $trackingNumber,
        ];


        if (in_array($this->keyName, ['EasyPost'])) {
            $updateData["opship_tracking_url"] = $orderInfo['tracking_url'];
        }
        
        if (!$db->insertFromArray(OrderProductShipment::DB_TBL, $updateData, false, array(), $updateData)) {
            LibHelper::dieJsonError($db->getError());
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

        if (1 > $qty) {
            $msg = Labels::getLabel("MSG_INVALID_RETURN_QTY", $this->langId);
            LibHelper::dieJsonError($msg);
        }
                
        if ('ShipStationShipping' == $this->keyName || !method_exists($this->shippingService, 'returnShipment')) {
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
                
        if ('ShipStationShipping' == $this->keyName || !method_exists($this->shippingService, 'refundShipment')) {
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
        $this->_template->render(false,false);
    }

    /**
     * getPickupForm
     *
     * @return object
     */
    private function getPickupForm(): object
    {
        if (false === $this->shippingService->canCreatePickup()) {
            $msg = Labels::getLabel('LBL_THIS_SERVICE_IS_NOT_AVAILABLE', $this->siteLangId);
            LibHelper::dieJsonError($msg);
        }

        $frm = new Form('frm' . $this->keyName);
        $frm->addHiddenField('', 'op_id');
        $formElements = $this->shippingService->getPickupFormElementsArr();
        foreach ($formElements as $colName => $colLabel) {
            $htmlAfterField = $fieldFn = "";
            $required = true;
            $attributes = [];
            if (is_array($colLabel)) {
                $htmlAfterField = array_key_exists('htmlAfterField', $colLabel) ? $colLabel['htmlAfterField'] : '';
                $fieldFn = array_key_exists('fieldType', $colLabel) ? $colLabel['fieldType'] : '' ;
                $required = array_key_exists('required', $colLabel) ? $colLabel['required'] : true ;
                $attributes = array_key_exists('attributes', $colLabel) ? $colLabel['attributes'] : [];
                $colLabel = array_key_exists('label', $colLabel) ? $colLabel['label'] : '';
            }
            $fieldFn = !empty($fieldFn) ? $fieldFn : (('password'== strtolower($colName)) ? 'addPasswordField' : 'addTextBox');

            $fld = $frm->$fieldFn($colLabel, $colName, '', $attributes);
            $fld->requirement->setRequired($required);
            $fld->htmlAfterField = $htmlAfterField;
        }

        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_SAVE', $this->siteLangId));
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
        $this->_template->render(false,false);
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
        $data += $post;
        if (false === $this->shippingService->canCreatePickup() || false === $this->shippingService->createPickup($data)) {
            $msg = $this->shippingService->getError();
            if (empty($msg)) {
                $msg = Labels::getLabel('LBL_THIS_SERVICE_IS_NOT_AVAILABLE', $this->siteLangId);
            }
            LibHelper::dieJsonError($msg);
        }

        $resp = $this->shippingService->getResponse();
        echo 'lkl';
    }
}
