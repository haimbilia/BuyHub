<?php require_once dirname(__FILE__) . '/ShipStationFunctions.php';

class ShipStationShipping extends ShippingServicesBase
{
    use ShipStationFunctions;

    public const KEY_NAME = __CLASS__;
    public const HOST = 'ssapi.shipstation.com';
    public const PRODUCTION_URL = 'https://' . self::HOST . '/';

    private const REQUEST_CARRIER_LIST = 1;
    private const REQUEST_SHIPPING_RATES = 2;
    private const REQUEST_CREATE_ORDER = 3;
    private const REQUEST_CREATE_LABEL = 4;
    private const REQUEST_FULFILLMENTS = 5;
    private const REQUEST_GET_ORDER = 6;
    private const REQUEST_MARK_AS_SHIPPED = 7;
    private const REQUEST_WAREHOUSES_LIST = 8;
    private const REQUEST_CREATE_WAREHOUSE = 9;
    private const REQUEST_UPDATE_WAREHOUSE = 10;

    private $resp;
    private $endpoint = '';
    private $ssOrder = [];
    private $orderDetail = [];
    private $shopSellerId = 0;
    private $warehouseId = 0;
    private bool $updateWarehouse = false;

    public $requiredKeys = [
        'api_key',
        'api_secret_key'
    ];

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(int $langId)
    {
        $this->langId = FatUtility::int($langId);
        if (1 > $this->langId) {
            $this->langId = CommonHelper::getLangId();
        }
    }

    /**
     * init
     *
     * @return bool
     */
    public function init(): bool
    {
        return $this->validateSettings($this->langId);
    }

    /**
     * canGenerateLabelSeparately
     *
     * @return bool
     */
    public function canGenerateLabelFromShipment(): bool
    {
        return true;
    }

    /**
     * getCarriers
     *
     * @return array
     */
    public function getCarriers(): array
    {
        if (false === $this->doRequest(self::REQUEST_CARRIER_LIST)) {
            return [];
        }
        return (array) $this->getResponse();
    }

    /**
     * addWarehouseToDb
     *
     * @return bool
     */
    private function addWarehouseIdToDb(int $recordId = 0): bool
    {
        $updateData = [
            'pluginsetting_plugin_id' => Plugin::getAttributesByCode(self::KEY_NAME, 'plugin_id'),
            'pluginsetting_record_id' => $recordId,
            'pluginsetting_key' => 'SHIPSTATION_WAREHOUSE_ID',
            'pluginsetting_value' => $this->warehouseId,
        ];

        if (!FatApp::getDb()->insertFromArray(PluginSetting::DB_TBL, $updateData, false, [], $updateData)) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }

    /**
     * syncDefaultAddressId
     *
     * @param  int $recordId
     * @return bool
     */
    public function syncDefaultAddressId(int $recordId = 0): bool
    {
        if (false === $this->doRequest(self::REQUEST_WAREHOUSES_LIST)) {
            return false;
        }
        $warehousesArr =  (array) $this->getResponse();
        $warehouse = [];
        if (!empty($warehousesArr)) {
            $warehouse = array_filter($warehousesArr, function ($wareHouse) {
                return ($wareHouse['isDefault'] == applicationConstants::YES);
            });
        }

        if (empty($warehouse)) {
            $this->error = Labels::getLabel('LBL_SYNC_SHIPSTATION_DEFAULT_ADDRESS_DESCRIPTION');
            return false;
        }

        $this->warehouseId = current($warehouse)['warehouseId'];
        return $this->addWarehouseIdToDb($recordId);
    }

    /**
     * addWarehouse
     *
     * @return bool
     */
    private function addWarehouse(): bool
    {
        $sellerId = $this->orderDetail['opshipping_by_seller_user_id'] ?? $this->shopSellerId;
        if (1 > $sellerId) {
            return $this->syncDefaultAddressId($sellerId);
        }

        $address = $this->getShopAddress($sellerId);
        $this->setAddress($address['shop_name'], $address['line1'], $address['line2'], $address['city'], $address['state'], $address['postalCode'], $address['countryCode'], $address['phone']);
        $requestData = [
            'warehouseName' => $address['shop_name'],
            'originAddress' => $this->getAddress()
        ];

        $userObj = new User($sellerId);
        $returnAddress = $userObj->getUserReturnAddress(CommonHelper::getLangId());
        if (!empty($returnAddress)) {
            $this->setAddress($address['shop_name'], $returnAddress['ura_address_line_1'], $returnAddress['ura_address_line_2'], $returnAddress['ura_city'], $returnAddress['state_name'], $returnAddress['ura_zip'], $returnAddress['country_code'], $returnAddress['ura_phone']);
            $requestData['returnAddress'] = $this->getAddress();
        }

        if (false === $this->doRequest(self::REQUEST_CREATE_WAREHOUSE, $requestData)) {
            return false;
        }
        $warehouse =  (array) $this->getResponse();
        $this->warehouseId = $warehouse['warehouseId'];

        return $this->addWarehouseIdToDb($sellerId);
    }

    public function updateWarehouse(): bool
    {
        $sellerId = $this->shopSellerId ?? 0;
        if (1 > $sellerId) {
            $this->error = Labels::getLabel('LBL_INVALID_SELLER_ID');
            return false;
        }

        $warehouseId = $this->getWarehouseId();
        if (true == $this->updateWarehouse && (0 < $warehouseId || !empty($warehouseId))) {
            $address = $this->getShopAddress($sellerId);
            $this->setAddress($address['shop_name'], $address['line1'], $address['line2'], $address['city'], $address['stateCode'], $address['postalCode'], $address['countryCode'], $address['phone']);

            $requestData = [
                'warehouseId' => $warehouseId,
                'warehouseName' => $address['shop_name'],
                'originAddress' => $this->getAddress()
            ];

            $userObj = new User($sellerId);
            $returnAddress = $userObj->getUserReturnAddress(CommonHelper::getLangId());
            if (!empty($returnAddress)) {
                $this->setAddress($address['shop_name'], $returnAddress['ura_address_line_1'], $returnAddress['ura_address_line_2'], $returnAddress['ura_city'], $returnAddress['state_code'], $returnAddress['ura_zip'], $returnAddress['country_code'], $returnAddress['ura_phone']);
                $requestData['returnAddress'] = $this->getAddress();
            }
            
            if (false === $this->doRequest(self::REQUEST_UPDATE_WAREHOUSE, $requestData)) {
                return false;
            }
            $resp = (array) $this->getResponse();
            if (!isset($resp['success']) || 1 != $resp['success']) {
                $this->error = $resp['message'];
                return false;
            }
        }

        return true;
    }

    /**
     * getWarehouseId
     *
     * @return mixed
     */
    private function getWarehouseId()
    {
        $sellerId = $this->orderDetail['opshipping_by_seller_user_id'] ?? $this->shopSellerId;
        $pluginSettings = new PluginSetting(0, self::KEY_NAME, $sellerId);
        $this->warehouseId = $pluginSettings->get(0, 'SHIPSTATION_WAREHOUSE_ID');
        $this->updateWarehouse = true;
        if (1 > $this->warehouseId || empty($this->warehouseId)) {
            $this->updateWarehouse = false;
            if (false === $this->addWarehouse()) {
                return -1;
            }
        }
        return $this->warehouseId;
    }

    /**
     * 
     * @return array
     */
    public function getWareHouses(): array
    {
        if (false === $this->doRequest(self::REQUEST_WAREHOUSES_LIST)) {
            return [];
        }
        $wareHouses = $this->getResponse();
        $output = [];
        if (!empty($response)) {
            foreach ($wareHouses as $wareHouse) {
                $output[] = [
                    'warehouseId' => $wareHouse['warehouseId'],
                    'warehouseName' => $wareHouse['warehouseName']
                ];
            }
        }
        return $output;
    }

    /**
     * Sets the shop seller ID.
     *
     * @param int $shopSellerId The shop seller ID to set.
     */
    public function setShopSellerId(int $shopSellerId): void
    {
        $this->shopSellerId = $shopSellerId;
    }

    /**
     * getRates
     *
     * @param  string $carrierCode
     * @param  string $shipFromPostalCode
     * @param  int $langId
     * @return array
     */
    public function getRates(string $carrierCode, string $shipFromPostalCode): array
    {
        if (empty($this->address)) {
            return [];
        }

        $pkgDetail = [
            'carrierCode' => $carrierCode,
            'serviceCode' => null,
            'packageCode' => null,
            'fromPostalCode' => $shipFromPostalCode,
            'toState' => !empty($this->address['state_code']) ? $this->address['state_code'] : $this->address['state'],
            'toCountry' => $this->address['country'],
            'toPostalCode' => $this->address['postalCode'],
            'toCity' => $this->address['city'],
            'weight' => $this->getWeight(),
            'dimensions' => $this->getDimensions()
        ];

        $warehouseId = $this->getWarehouseId();
        if (0 < $warehouseId || !empty($warehouseId)) {
            $pkgDetail['fromWarehouseId'] = $warehouseId;
        }

        if (false === $this->doRequest(self::REQUEST_SHIPPING_RATES, $pkgDetail)) {
            return [];
        }
        return (array) $this->getResponse();
    }

    /**
     * addOrder
     *
     * @param  int $opId
     * @return bool
     */
    public function addOrder(int $opId): bool
    {
        $this->orderDetail = $this->getSystemOrder($opId);
        if (empty($this->orderDetail)) {
            return false;
        }

        $orderTimestamp = strtotime($this->orderDetail['order_date_added']);
        $orderDate = date('Y-m-d', $orderTimestamp) . 'T' . date('H:i:s', $orderTimestamp) . '.0000000';

        $orderInvoiceNumber = 0;

        $shippingTotal = CommonHelper::orderProductAmount($this->orderDetail, 'SHIPPING');
        $taxCharged = CommonHelper::orderProductAmount($this->orderDetail, 'TAX');

        $orderInvoiceNumber = $this->orderDetail['op_invoice_number'];

        $orderObj = new Orders($this->orderDetail['order_id']);
        $addresses = $orderObj->getOrderAddresses($this->orderDetail['order_id']);
        $billingAddress = $addresses[Orders::BILLING_ADDRESS_TYPE];
        $shippingAddress = (!empty($addresses[Orders::SHIPPING_ADDRESS_TYPE])) ? $addresses[Orders::SHIPPING_ADDRESS_TYPE] : array();

        $warehouseId = $this->getWarehouseId();
        if (0 > $warehouseId) {
            if (empty($this->error)) {
                $this->error = Labels::getLabel('ERR_UNABLE_TO_GET_WAREHOUSE_ID', $this->langId);
            }
            return false;
        }

        $this->order = [];
        $this->order['orderNumber'] = $orderInvoiceNumber;
        $this->order['orderKey'] = $orderInvoiceNumber; // if specified, the method becomes idempotent and the existing Order with that key will be updated
        $this->order['orderDate'] = $orderDate;
        $this->order['paymentDate'] = $orderDate;
        $this->order['orderStatus'] = "awaiting_shipment"; // {awaiting_shipment, on_hold, shipped, cancelled}
        $this->order['customerUsername'] = $this->orderDetail['buyer_user_name'];
        $this->order['customerEmail'] = $this->orderDetail['buyer_email'];
        $this->order['amountPaid'] = $this->orderDetail['order_net_amount'];
        $this->order['taxAmount'] = $taxCharged;
        $this->order['shippingAmount'] = $shippingTotal;
        /* $this->order['customerNotes'] = null;
        $this->order['internalNotes'] = "Express Shipping Please"; */
        $this->order['paymentMethod'] = $this->orderDetail['plugin_name'];
        $this->order['carrierCode'] = $this->orderDetail['opshipping_carrier_code'];
        $this->order['serviceCode'] = $this->orderDetail['opshipping_service_code'];
        $this->order['packageCode'] = "package";
        $this->order['advancedOptions'] = ['warehouseId' => $warehouseId];
        /* $this->order['confirmation'] = null;
        $this->order['shipDate'] = null; */


        $this->setAddress($billingAddress['oua_name'], $billingAddress['oua_address1'], $billingAddress['oua_address2'], $billingAddress['oua_city'], $billingAddress['oua_state'], $billingAddress['oua_zip'], $billingAddress['oua_country_code'], $billingAddress['oua_phone']);
        $this->order['billTo'] = $this->getAddress();

        $this->setAddress($shippingAddress['oua_name'], $shippingAddress['oua_address1'], $shippingAddress['oua_address2'], $shippingAddress['oua_city'], $shippingAddress['oua_state'], $shippingAddress['oua_zip'], $shippingAddress['oua_country_code'], $shippingAddress['oua_phone']);
        $this->order['shipTo'] = $this->getAddress();

        $weightUnitsArr = applicationConstants::getWeightUnitsArr($this->langId, true);
        $weightUnitName = ($this->orderDetail['op_product_weight_unit']) ? $weightUnitsArr[$this->orderDetail['op_product_weight_unit']] : '';
        $productWeightInOunce = Shipping::convertWeightInOunce($this->orderDetail['op_product_weight'], $weightUnitName);

        $this->setWeight($productWeightInOunce);
        $this->order['weight'] = $this->getWeight();

        $lengthUnitsArr = applicationConstants::getLengthUnitsArr($this->langId, true);
        $dimUnitName = ($this->orderDetail['op_product_dimension_unit']) ? $lengthUnitsArr[$this->orderDetail['op_product_dimension_unit']] : '';

        $lengthInCenti = Shipping::convertLengthInCenti($this->orderDetail['op_product_length'], $dimUnitName);
        $widthInCenti = Shipping::convertLengthInCenti($this->orderDetail['op_product_width'], $dimUnitName);
        $heightInCenti = Shipping::convertLengthInCenti($this->orderDetail['op_product_height'], $dimUnitName);

        $this->setDimensions($lengthInCenti, $widthInCenti, $heightInCenti);
        $this->order['dimensions'] = $this->getDimensions();

        $this->setItem($this->orderDetail);
        $this->order['items'] = [$this->getItem()];
        if (false == $this->doRequest(self::REQUEST_CREATE_ORDER, $this->order)) {
            return false;
        }
        return $this->setSsOrder();
    }

    private function setSsOrder()
    {
        $this->ssOrder = $this->getResponse();
        return true;
    }

    /**
     * bindLabel - This function should be called after addOrder
     *
     * @return bool
     */
    public function bindLabel(array $requestParam): bool
    {
        if (!isset($requestParam['advancedOptions'])) {
            $requestParam['advancedOptions'] = ['warehouseId' => $this->getWarehouseId()];
        }
        if (false == $this->doRequest(self::REQUEST_CREATE_LABEL, $requestParam)) {
            return false;
        }

        $resp = $this->getResponse(false);
        if (!empty($this->ssOrder)) {
            if ($this->loadOrder($this->ssOrder['orderId'])) {
                $ssOrderInfo = $this->getResponse();
                if ('awaiting_shipment' != $ssOrderInfo['orderStatus']) {
                    $updateData = [
                        'orderId' => $ssOrderInfo['orderId'],
                        'orderKey' => $ssOrderInfo['orderKey'],
                        'orderNumber' => $ssOrderInfo['orderNumber'],
                        'orderStatus' => 'awaiting_shipment',
                        'advancedOptions' => ['warehouseId' => $this->getWarehouseId()]
                    ];
                    $this->doRequest(self::REQUEST_CREATE_ORDER, $updateData);
                }
            }
        }

        $this->resp = $resp;
        return true;
    }

    /**
     * downloadLabel
     *
     * @param  string $labelData
     * @param  string $filename
     * @return void
     */
    public function downloadLabel(string $labelData, string $filename = "label.pdf", bool $preview = false)
    {
        $disposition = (true === $preview ? 'inline' : 'attachment');
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = empty($ext) ? trim($filename) . '.pdf' : $filename;

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: application/pdf");
        header("Content-Disposition: " . $disposition . "; filename=" . $filename);
        header("Content-Transfer-Encoding: binary");

        echo base64_decode($labelData);
        die;
    }

    /**
     * setAddress
     *
     * @param  string $name
     * @param  string $stt1
     * @param  string $stt2
     * @param  string $city
     * @param  string $state
     * @param  string $zip
     * @param  string $countryCode
     * @param  string $phone
     * @return bool
     */
    public function setAddress(string $name, string $stt1, string $stt2, string $city, string $state, string $zip, string $countryCode, string $phone, string $stateCode = ''): bool
    {
        $this->address = [];

        $this->address['name'] = $name; // This has to be a String... If you put NULL the API cries...
        $this->address['company'] = $name;
        $this->address['street1'] = $stt1;
        $this->address['street2'] = $stt2;
        $this->address['city'] = $city;
        $this->address['state'] = $state;
        $this->address['state_code'] = $stateCode;
        $this->address['postalCode'] = $zip;
        $this->address['country'] = $countryCode;
        $this->address['phone'] = $phone;
        return true;
    }

    /**
     * getAddress
     *
     * @return array
     */
    public function getAddress(): array
    {
        return empty($this->address) ? [] : $this->address;
    }

    /**
     * setWeight
     *
     * @param  float $weight
     * @param  string $unit
     * @return bool
     */
    public function setWeight($weight, $unit = 'ounces'): bool
    {
        $this->weight = [];
        $this->weight['value'] = floatval($weight);
        $this->weight['units'] = trim($unit);

        return true;
    }

    /**
     * getWeight
     *
     * @return array
     */
    public function getWeight(): array
    {
        return empty($this->weight) ? [] : $this->weight;
    }

    /**
     * setDimensions
     *
     * @param  int $length
     * @param  int $width
     * @param  int $height
     * @param  string $unit
     * @return bool
     */
    public function setDimensions($length, $width, $height, $unit = 'centimeters'): bool
    {
        $this->dimensions = [];

        $this->dimensions['units'] = $unit;
        $this->dimensions['length'] = $length;
        $this->dimensions['width'] = $width;
        $this->dimensions['height'] = $height;

        return true;
    }

    /**
     * getDimensions
     *
     * @return array
     */
    public function getDimensions(): array
    {
        return empty($this->dimensions) ? [] : $this->dimensions;
    }

    /**
     * setItem
     *
     * @param  array $op
     * @return bool
     */
    public function setItem(array $op): bool
    {
        $this->item = [];

        $this->item['lineItemKey'] = $op['op_product_name'];
        $this->item['sku'] = $op['op_selprod_sku'];
        $this->item['name'] = $op['op_selprod_title'];
        $this->item['imageUrl'] = UrlHelper::generateFullUrl('image', 'product', array($op['selprod_product_id'], ImageDimension::VIEW_THUMB, $op['op_selprod_id'], 0, $this->langId));
        $this->item['weight'] = $this->order['weight'];
        $this->item['quantity'] = $op['op_qty'];
        $this->item['unitPrice'] = $op['op_unit_price'];
        return true;
    }

    /**
     * getItem
     *
     * @return array
     */
    public function getItem(): array
    {
        return empty($this->item) ? [] : $this->item;
    }

    /**
     * getFulfillments - This function return order shipment detail
     *
     * @param  mixed $requestParam
     * @return bool
     */
    public function getFulfillments(array $requestParam): bool
    {
        return $this->doRequest(self::REQUEST_FULFILLMENTS, $requestParam);
    }

    /**
     * loadOrder
     *
     * @param  string $orderId
     * @return bool
     */
    public function loadOrder($orderId): bool
    {
        return $this->doRequest(self::REQUEST_GET_ORDER, [$orderId]);
    }

    /**
     * proceedToShipment
     *
     * @param  array $requestParam
     * @return bool
     */
    public function proceedToShipment(array &$requestParam): bool
    {
        if (false === $this->addOrder($requestParam['op_id'])) {
            LibHelper::dieJsonError($this->getError());
        }
        $order = $this->getResponse();

        $shipmentApiOrderId = $order['orderId'];
        $labelRequestParam = [
            'orderId' => $order['orderId'],
            'carrierCode' => $order['carrierCode'],
            'serviceCode' => $order['serviceCode'],
            'confirmation' => $order['confirmation'],
            'shipDate' => date('Y-m-d'), // date('Y-m-d', strtotime('+7 day')),
            'weight' => $order['weight'],
            'dimensions' => $order['dimensions'],
        ];

        if (false === $this->bindLabel($labelRequestParam)) {
            LibHelper::dieJsonError($this->getError());
        }

        $response = $this->getResponse(false);
        $responseArr = json_decode($response, true);
        $recordCol = ['opship_op_id' => $requestParam['op_id']];

        $dataToSave = [
            'opship_orderid' => $shipmentApiOrderId,
            'opship_shipment_id' => $responseArr['shipmentId'],
            'opship_tracking_number' => $responseArr['trackingNumber'],
        ];

        $db = FatApp::getDb();
        if (!$db->insertFromArray(OrderProductShipment::DB_TBL, array_merge($recordCol, $dataToSave), false, array(), $dataToSave)) {
            LibHelper::dieJsonError($db->getError());
        }

        $opObj = new OrderProduct($requestParam['op_id']);
        if (false === $opObj->bindResponse(OrderProduct::RESPONSE_TYPE_SHIPMENT, $response)) {
            LibHelper::dieJsonError($opObj->getError());
        }

        if (!empty($this->ssOrder)) {
            if ($this->loadOrder($this->ssOrder['orderId'])) {
                $ssOrderInfo = $this->getResponse();
                $requestParam['orderId'] = $order['orderId'];
                $requestParam['trackingNumber'] = $responseArr['trackingNumber'];
                if ('awaiting_shipment' == $ssOrderInfo['orderStatus']) {
                    return $this->doRequest(self::REQUEST_MARK_AS_SHIPPED, $requestParam);
                }
            }
        }
        return true;
    }

    /**
     * validateKeys
     *
     * @param  array $keys
     * @return bool
     */
    public function validateKeys(array $keys): bool
    {
        $keys['plugin_active'] = Plugin::ACTIVE;
        $this->settings = $keys;
        if (false == $this->getCarriers() && '401 Unauthorized' == $this->error) {
            return false;
        }
        return true;
    }

    /**
     * doRequest
     *
     * @param  int $requestType
     * @param  mixed $requestParam
     * @param  bool $formatError
     * @return bool
     */
    private function doRequest(int $requestType, $requestParam = [], bool $formatError = true): bool
    {
        try {
            switch ($requestType) {
                case self::REQUEST_CARRIER_LIST:
                    $this->carrierList();
                    break;
                case self::REQUEST_SHIPPING_RATES:
                    $this->shippingRates($requestParam);
                    break;
                case self::REQUEST_CREATE_ORDER:
                    $this->createOrder($requestParam);
                    break;
                case self::REQUEST_CREATE_LABEL:
                    $this->createLabel($requestParam);
                    break;
                case self::REQUEST_FULFILLMENTS:
                    $this->fulfillments($requestParam);
                    break;
                case self::REQUEST_GET_ORDER:
                    $this->getOrder($requestParam);
                    break;
                case self::REQUEST_MARK_AS_SHIPPED:
                    $this->markAsShipped($requestParam);
                    break;
                case self::REQUEST_WAREHOUSES_LIST:
                    $this->wareHousesList();
                    break;
                case self::REQUEST_CREATE_WAREHOUSE:
                    $this->createWarehouse($requestParam);
                    break;
                case self::REQUEST_UPDATE_WAREHOUSE:
                    $this->updateWarehouseRecord($requestParam);
                    break;
            }

            $resp = (array)$this->getResponse(true);
            if (array_key_exists('Message', $resp)) {
                $this->error = (true === $formatError) ? $this->getResponse(true) : $this->resp;
                if (true === $formatError) {
                    $this->error = $this->formatError();
                }
                SystemLog::plugin(json_encode($requestParam), json_encode($resp), self::KEY_NAME);
                return false;
            }

            return true;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        } catch (Error $e) {
            $this->error = $e->getMessage();
        }

        $this->error =  (true === $formatError ? $this->formatError() : $this->error);
        return false;
    }
}