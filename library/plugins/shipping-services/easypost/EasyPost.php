<?php

/**
 * EasyPost - https://www.easypost.com/docs/api
 */
class EasyPost extends ShippingServicesBase
{
    public const KEY_NAME = __CLASS__;

    private const SETUP_API_KEY = 1;
    private const REQUEST_CARRIER_LIST = 2;
    private const REQUEST_CREATE_ADDRESS = 3;
    private const REQUEST_CREATE_SHIPPING = 4;
    private const REQUEST_RETRIEVE_SHIPMENT = 5;
    private const REQUEST_CREATE_ORDER = 6;
    private const REQUEST_RETRIEVE_ORDER = 7;
    private const REQUEST_REFUND_SHIPMENT = 8;

    private $resp;
    private $toAddress;
    private $fromAddress;
    private $parcel;
    private $dimensions;
    private $weight;
    private $selectedShippingService;
    private $shipment;
    private $shipmentOrderId;
    private $orderQty = 1;
    private $refundStatus = [];
    private $env = Plugin::ENV_SANDBOX;

    public $requiredKeys = [
        'api_key'
    ];

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(int $langId)
    {
        $this->langId = 0 < $langId ? $langId : CommonHelper::getLangId();
        $this->requiredKeys();
    }

    /**
     * requiredKeys
     *
     * @return void
     */
    public function requiredKeys()
    {
        $this->env = FatUtility::int($this->getKey('env'));
        if (0 < $this->env) {
            $this->requiredKeys = [
                'live_api_key'
            ];
        }
    }

    /**
     * init
     *
     * @return bool
     */
    public function init(): bool
    {
        if (false == $this->validateSettings($this->langId)) {
            return false;
        }

        $this->apiKey = Plugin::ENV_PRODUCTION == $this->settings['env'] ? $this->settings['live_api_key'] : $this->settings['api_key'];
        if (false === $this->doRequest(self::SETUP_API_KEY, $this->apiKey)) {
            return false;
        }
        return true;
    }

    /**
     * getResponse
     *
     * @return mixed
     */
    public function getResponse()
    {
        return $this->resp;
    }
    
    /**
     * canGenerateLabelFromShipment
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
     * @param  int $limit
     * @return array
     */
    public function getCarriers(int $limit = 0): array
    {
        if (Plugin::INACTIVE == $this->settings['plugin_active']) {
            return [];
        }

        if (!array_key_exists('live_api_key', $this->settings) || empty($this->settings['live_api_key'])) {
            $this->error = Labels::getLabel('MSG_PRODUCTION_API_KEY_REQUIRED_FOR_CARRIER_LISTING', $this->langId);
            return [];
        }

        if (false === $this->doRequest(self::REQUEST_CARRIER_LIST)) {
            return [];
        }

        $records = (array) $this->getResponse();

        if (0 < $limit && $limit  < count($records)) {
            $records = array_slice($records, ($limit - 1));
        }

        return array_map(function ($records) {
            return $records + ['code' => $records['readable']];
        }, $records);
    }

    /**
     * createAddress
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
    private function createAddress(string $name, string $stt1, string $stt2, string $city, string $state, string $zip, string $countryCode, string $phone): bool
    {
        $address = [
            'name' => $name,
            'street1' => $stt1,
            'street2' => $stt2,
            'city' => $city,
            'state' => $state,
            'zip' => $zip,
            'country' => $countryCode,
            'phone' => $phone
        ];

        if (false === $this->doRequest(self::REQUEST_CREATE_ADDRESS, $address, false)) {
            return false;
        }
        $this->resp = $address;
        return true;
    }

    /**
     * setAddress - Set To Address
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
    public function setAddress(string $name, string $stt1, string $stt2, string $city, string $state, string $zip, string $countryCode, string $phone): bool
    {
        if (false === $this->createAddress($name, $stt1, $stt2, $city, $state, $zip, $countryCode, $phone)) {
            return false;
        }
        $this->toAddress = $this->getResponse();
        return true;
    }

    /**
     * setFromAddress
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
    public function setFromAddress(string $name, string $stt1, string $stt2, string $city, string $state, string $zip, string $countryCode, string $phone): bool
    {
        if (false === $this->createAddress($name, $stt1, $stt2, $city, $state, $zip, $countryCode, $phone)) {
            return false;
        }
        $this->fromAddress = $this->getResponse();
        return true;
    }

    /**
     * convertToInch
     *
     * @param  float $value
     * @param  int $unit
     * @return float
     */
    private function convertToInch($value, $unit)
    {
        switch ($unit) {
            case ShippingPackage::UNIT_TYPE_CM:
                return $value * 0.39370;
                break;
            case ShippingPackage::UNIT_TYPE_METER:
                return $value * 39.3701;
                break;

            default:
                return $value;
                break;
        }
        return $value;
    }

    /**
     * setDimensions - Dimensions are in INCHES (IN) and go to one decimal point.
     *
     * @param  float $length
     * @param  float $width
     * @param  float $height
     * @param  string $unit
     * @return void
     */
    public function setDimensions($length, $width, $height, $unit = 'inches')
    {
        if (empty($length) || empty($width) || empty($height)) {
            return;
        }

        $this->dimensions = [
            'length' => $this->convertToInch($length, $unit),
            'width' => $this->convertToInch($width, $unit),
            'height' => $this->convertToInch($height, $unit),
        ];
    }

    /**
     * setWeight - In oz
     *
     * @param  float $weight
     * @return void
     */
    public function setWeight($weight)
    {
        if (empty($weight)) {
            return;
        }
        $this->weight = $weight;
    }

    /**
     * createParcel
     *
     * @return bool
     */
    public function createParcel(): bool
    {
        if (is_null($this->weight) || empty($this->weight)) {
            $this->error = Labels::getLabel('MSG_WEIGHT_IS_REQUIRED', $this->langId);
            return false;
        }

        if (is_null($this->dimensions) || empty($this->dimensions)) {
            $this->error = Labels::getLabel('MSG_DIMENSIONS_ARE_REQUIRED', $this->langId);
            return false;
        }

        $requestParam = $this->dimensions;
        $requestParam['weight'] = $this->weight;
        $this->parcel = ['parcel' => $requestParam];
        return true;
    }

    /**
     * setQuantity
     *
     * @param  mixed $qty
     * @return void
     */
    public function setQuantity(int $qty)
    {
        $this->orderQty = $qty;
    }

    /**
     * getRates
     *
     * @return array
     */
    public function getRates(): array
    {
        $shipment = $rates = [];
        if (!is_null($this->selectedShippingService) && !empty($this->selectedShippingService)) {
            $rate = $this->retrieveRate($this->selectedShippingService, true);
            $shipment = $this->shipment;
            /* No need to fetch all if result not found. Because if shipment id passed and result not found then might be shipment id is invalid. */
            if (is_array($rate) && 1 > count($rate)) {
                return [];
            }
            $rates = [$rate];
        }

        if (is_array($rates) && 1 > count($rates)) {
            if (
                Plugin::INACTIVE == $this->settings['plugin_active']
                || is_null($this->toAddress) || empty($this->toAddress)
                || is_null($this->fromAddress) || empty($this->fromAddress)
            ) {
                $msg = Labels::getLabel('MSG_VALIDATION_ERROR!!', $this->langId);
                $this->error = !empty($this->error) ? $msg . ' ' . $this->error : $msg;
                return [];
            }

            if (false === $this->createParcel()) {
                return [];
            }

            $orderDetail = [
                "from_address" => $this->fromAddress,
                "to_address" => $this->toAddress,
                "shipments" => [],
            ];

            for ($i = 0; $i < $this->orderQty; $i++) {
                $orderDetail['shipments'][] = $this->parcel;
            }

            if (false === $this->doRequest(self::REQUEST_CREATE_ORDER, $orderDetail)) {
                return [];
            }

            $shipment = $this->getResponse();
            if (empty($shipment) || 0 == count($shipment['rates'])) {
                $this->error = Labels::getLabel('MSG_UNABLE_TO_CALCULATE_RATES_FOR_GIVEN_ADDRESSES', $this->langId);
                return [];
            }
            $rates = $shipment['rates'];
        }

        return array_map(function ($rates) use ($shipment) {
            $serviceName = Labels::getLabel("LBL_{CARRIER}_-_{SERVICE}", $this->langId);
            $serviceName = CommonHelper::replaceStringData($serviceName, ['{CARRIER}' => $rates['carrier'], '{SERVICE}' => $rates['service']]);

            if (array_key_exists('delivery_days', $rates) && 0 < $rates['delivery_days']) {
                $deliveryDays = Labels::getLabel("LBL_ESTIMATED_DELIVERY_IN_{DELIVERY-DAYS}_DAY_'S", $this->langId);
                $serviceName .= '. ' . CommonHelper::replaceStringData($deliveryDays, ['{DELIVERY-DAYS}' => $rates['delivery_days']]);
            }

            $service = $shipment['id'] . '|' . $rates['id'];

            return $rates + [
                'serviceName' => $serviceName,
                'serviceCode' => $service,
                'shipmentId' => $service,
                'shipmentCost' => $rates['rate'],
                'otherCost' => '0',
            ];
        }, $rates);
    }

    /**
     * retrieveOrder
     *
     * @param  string $orderId
     * @param  bool $formatResp
     * @return bool
     */
    public function retrieveOrder(string $orderId, bool $formatResp = true): bool
    {
        if (!is_null($this->shipment) && !empty($this->shipment) && $this->shipmentOrderId == trim($orderId)) {
            $this->shipment['orderStatus'] = current($this->shipment['shipments'])['status'];
            $this->resp = $this->shipment;
            return true;
        }

        $this->shipmentOrderId = trim($orderId);
        if (false === $this->doRequest(self::REQUEST_RETRIEVE_ORDER, $this->shipmentOrderId, $formatResp)) {
            return false;
        }
        $this->shipment = $this->getResponse();

        $this->shipment['orderStatus'] = current($this->shipment['shipments'])['status'];
        $this->resp = $this->shipment;
        return true;
    }

    /**
     * retrieveShipment
     *
     * @param  string $shipmentId
     * @param  bool $formatResp
     * @return bool
     */
    public function retrieveShipment(string $shipmentId, bool $formatResp = true): bool
    {
        if (!is_null($this->shipment) && !empty($this->shipment)) {
            $this->shipment['orderStatus'] = $this->shipment['status'];
            $this->resp = $this->shipment;
            return true;
        }

        $shipmentId = trim($shipmentId);
        if (false === $this->doRequest(self::REQUEST_RETRIEVE_SHIPMENT, $shipmentId, $formatResp)) {
            return false;
        }
        $this->shipment = $this->getResponse();
        $this->shipment['orderStatus'] = $this->shipment['status'];
        $this->resp = $this->shipment;
        return true;
    }

    /**
     * getShipment : Currently used in test cases
     *
     * @return array|object
     */
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * setShipment : Currently used in test cases
     *
     * @param  array|object $shipment
     * @return void
     */
    public function setShipment($shipment)
    {
        $this->shipment = $shipment;
    }

    /**
     * retrieveRate
     *
     * @param  string $rateId
     * @return object|array
     */
    public function retrieveRate(string $rateId, bool $formatResp = false)
    {
        $shipmentRate = explode('|', $rateId);
        if (empty($shipmentRate)) {
            $this->error = Labels::getLabel('MSG_INVALID_SHIPMENT_ID', $this->langId);
            return (true === $formatResp ? [] : (object)[]);
        }

        if (false === $this->retrieveOrder($shipmentRate[0])) {
            return (true === $formatResp ? [] : (object)[]);
        }

        $shipment = $this->getResponse();
        if (empty($shipment) || 0 == count($shipment['rates'])) {
            $this->error = Labels::getLabel('MSG_UNABLE_TO_FIND_SHIPPING_RATE', $this->langId);
            return (true === $formatResp ? [] : (object)[]);
        }
        $rates = $shipment['rates'];

        $key = array_search($shipmentRate[1], array_column($rates, 'id'));
        if (false === $key) {
            $this->error = Labels::getLabel('MSG_UNABLE_TO_FIND_SHIPMENT', $this->langId);
            return (true === $formatResp ? [] : (object)[]);
        }

        return (false === $formatResp ? \EasyPost\Util::convertToEasyPostObject($rates[$key], $this->apiKey) : $rates[$key]);
    }

    /**
     * setSelectedShipping
     *
     * @param  string $selectedShippingService
     * @return void
     */
    public function setSelectedShipping(string $selectedShippingService)
    {
        $this->selectedShippingService = $selectedShippingService;
    }

    /**
     * downloadLabel
     *
     * @param  array $labelData
     * @param  string $filename
     * @return void
     */
    public function downloadLabel(array $labelData, string $filename = 'label.zip')
    {
        if (!array_key_exists('shipments', $labelData)) {
            return false;
        }
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = empty($ext) ? trim($filename) . '.zip' : $filename;
        $this->createZipAndDownload($labelData['shipments'], $filename);
    }

    /**
     * downloadReturnLabel
     *
     * @param  array $labelData
     * @param  string $filename
     * @return void
     */
    public function downloadReturnLabel(array $labelData, string $filename = 'label.zip')
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $filename = empty($ext) ? trim($filename) . '.zip' : $filename;
        $this->createZipAndDownload($labelData, $filename);
    }

    /**
     * createZipAndDownload
     *
     * @param  array $shipment
     * @return void
     */
    private function createZipAndDownload(array $shipment, string $filename = 'label.zip')
    {
        # create new zip opbject
        $zip = new ZipArchive();

        # create a temp file & open it
        $tmp_file = tempnam('.', '');
        $zip->open($tmp_file, ZipArchive::CREATE);

        foreach ($shipment as $value) {
            $file = $value['postage_label']['label_url'];
            # download file
            $download_file = file_get_contents($file);

            #add it to the zip
            $zip->addFromString(basename($file), $download_file);
        }
        # close zip
        $zip->close();

        # send the file to the browser as a download
        header('Content-disposition: attachment; filename=' . $filename);
        header('Content-type: application/zip');
        readfile($tmp_file);

        /* Remove Temp File. */
        unlink($tmp_file);
        /* Remove Temp File. */

        exit;
    }

    /**
     * loadOrder
     *
     * @param  string $rateId
     * @return bool
     */
    public function loadOrder(string $rateId): bool
    {
        $shipmentRate = explode('|', $rateId);
        if (empty($shipmentRate)) {
            $this->error = Labels::getLabel('MSG_INVALID_SHIPMENT_ID', $this->langId);
            return false;
        }

        if (false === $this->retrieveOrder($shipmentRate[0])) {
            return false;
        }
        return true;
    }

    /**
     * proceedToShipment
     *
     * @param  array $requestParam
     * @return bool
     */
    public function proceedToShipment(array $requestParam): bool
    {
        if (is_null($this->shipment) || empty($this->shipment)) {
            $this->error = Labels::getLabel('MSG_LOAD_ORDER_BEFORE_SHIPMENT', $this->langId);
            return false;
        }

        $shipment = \EasyPost\Util::convertToEasyPostObject($this->shipment, $this->apiKey);
        $rate = $this->retrieveRate($requestParam['opshipmentId']);
        $shipment->buy($rate);
        $resp = \EasyPost\Util::convertEasyPostObjectToArray($shipment);
        if (0 < count($resp)) {
            $trackingUrl = [];
            $trackingNumber = [];
            foreach ($resp['shipments'] as $value) {
                $trackingUrl[] = $value['tracker']['public_url'];
                $trackingNumber[] = $value['tracker']['tracking_code'];
            }
            $resp['orderNumber'] = $resp['id'];
            $resp['tracking_url'] = implode(', ', $trackingUrl);
            $resp['tracking_code'] = implode(', ', $trackingNumber);
        }
        $this->resp = $resp;
        return true;
    }

    /**
     * returnShipment
     *
     * @param  string $rateId
     * @param  int $qty
     * @return bool
     */
    public function returnShipment(string $rateId, int $qty): bool
    {
        if (false === $this->loadOrder($rateId)) {
            return false;
        }

        if (is_null($this->shipment) || empty($this->shipment)) {
            $this->error = Labels::getLabel('MSG_LOAD_ORDER_BEFORE_PROCEED_TO_RETURN_SHIPMENT', $this->langId);
            return false;
        }

        $shipments = array_slice($this->shipment['shipments'], 0, $qty);

        $resp = [];
        foreach ($shipments as $shipment) {
            $requestParam = [
                'to_address' => [
                    'id' => $shipment['to_address']['id']
                ],
                'from_address' => [
                    'id' => $shipment['from_address']['id']
                ],
                'parcel' => [
                    'id' => $shipment['parcel']['id']
                ],
                'is_return' => true
            ];

            if (false === $this->doRequest(self::REQUEST_CREATE_SHIPPING, $requestParam, false)) {
                return false;
            }
            $shipmentReturn = $this->getResponse();
            $shipmentReturn->buy($shipmentReturn->lowest_rate());
            $resp[] = \EasyPost\Util::convertEasyPostObjectToArray($shipmentReturn);
        }

        $this->resp = $resp;
        return true;
    }

    /**
     * refundShipment
     *
     * @param  string $rateId
     * @return bool
     */
    public function refundShipment(string $rateId): bool
    {
        if (false === $this->loadOrder($rateId)) {
            return false;
        }

        if (is_null($this->shipment) || empty($this->shipment)) {
            $this->error = Labels::getLabel('MSG_LOAD_ORDER_BEFORE_PROCEED_TO_RETURN_SHIPMENT', $this->langId);
            return false;
        }

        $shipments = $this->shipment['shipments'];

        $trackingCodes = [];
        foreach ($shipments as $shipment) {
            /* Request to refund for shipment on which cancel request generated. */
            $trackingCodes[] = $shipment['tracking_code'];
            /* ---------------------------------------------- */
        }

        $requestRefundParam = [
            "carrier" => $shipments[0]['tracker']['carrier'], /* Because of all shipments( More than 1 qty of individual purchased product ) belongs to same shipping carrier. */
            "tracking_codes" => implode(',', $trackingCodes)
        ];

        if (false === $this->doRequest(self::REQUEST_REFUND_SHIPMENT, $requestRefundParam)) {
            return false;
        }
        return true;
    }

    /**
     * getRefundResponse
     *
     * @return array
     */
    public function getRefundResponse(): array
    {
        return (array) $this->refundStatus;
    }

    /**
     * doRequest
     *
     * @param  int $requestType
     * @param  mixed $requestParam
     * @return bool
     */
    private function doRequest(int $requestType, $requestParam = [], bool $formatResp = true): bool
    {
        try {
            switch ($requestType) {
                case self::SETUP_API_KEY:
                    \EasyPost\EasyPost::setApiKey($requestParam);
                    break;
                case self::REQUEST_CARRIER_LIST:
                    $this->resp = \EasyPost\CarrierAccount::all(null, $this->settings['live_api_key']);
                    break;
                case self::REQUEST_CREATE_ADDRESS:
                    $this->resp = \EasyPost\Address::create_and_verify($requestParam, $this->apiKey);
                    break;
                case self::REQUEST_CREATE_SHIPPING:
                    $this->resp = \EasyPost\Shipment::create($requestParam, $this->apiKey);
                    break;
                case self::REQUEST_RETRIEVE_SHIPMENT:
                    $this->resp = \EasyPost\Shipment::retrieve(['id' => $requestParam], $this->apiKey);
                    break;
                case self::REQUEST_CREATE_ORDER:
                    $this->resp = \EasyPost\Order::create($requestParam, $this->apiKey);
                    break;
                case self::REQUEST_RETRIEVE_ORDER:
                    $this->resp = \EasyPost\Order::retrieve(['id' => $requestParam], $this->apiKey);
                    break;
                case self::REQUEST_REFUND_SHIPMENT:
                    $this->resp = \EasyPost\Refund::create($requestParam, $this->apiKey);
                    break;
            }
            if (true === $formatResp && !empty($this->resp)) {
                $this->resp = \EasyPost\Util::convertEasyPostObjectToArray($this->resp);
            }
            return true;
        } catch (Exception $e) {
            $msg = $e->getMessage();
            if (!empty($e->param)) {
                $error = Labels::getLabel('MSG_INVALID_PARAM:_{PARAM}', $this->langId);
                $msg .= "\n" . CommonHelper::replaceStringData($error, ['{PARAM}' => $e->param]);
            }
            $this->error = $msg;
        } catch (Error $e) {
            $this->error = $e->getMessage();
        }
        return false;
    }
}
