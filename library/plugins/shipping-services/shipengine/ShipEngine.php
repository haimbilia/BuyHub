<?php

/**
 * ShipEngine - https://www.shipengine.com/docs/, https://github.com/ShipEngine/shipengine-php
 */

use Curl\Curl;

class ShipEngine extends ShippingServicesBase
{
    public const KEY_NAME = __CLASS__;

    private const PRODUCTION_URL = 'https://api.shipengine.com/';
    private const VERSION = 'v1/';

    private const REQUEST_GET_CARRIERS = 1;
    private const REQUEST_GET_RATES = 2;
    private const REQUEST_GENERATE_LABEL = 3;
    private const REQUEST_TRACKING = 4;

    private $apiKey = '';
    private $resp;
    private $formFieldsArr = [];
    private $toAddress = [];
    private $fromAddress = [];
    private $weight = 0;
    private $orderDetail = [];

    public $requiredKeys = ['api_key'];

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(int $langId)
    {
        $this->langId = 0 < $langId ? $langId : CommonHelper::getLangId();
        $this->formFieldsArr = $this->requiredKeys;
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
        return true;
    }

    /**
     * getFormFieldsArr
     *
     * @return array
     */
    public function getFormFieldsArr(): array
    {
        $lblArr = [];
        foreach ($this->formFieldsArr as $col) {
            $lbl = Labels::getLabel('LBL_' . strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $col)), $this->langId);
            $lblArr[$col] = $lbl;
        }
        return $lblArr;
    }

    /**
     * getResponse
     *
     * @return mixed
     */
    public function getResponse()
    {
        $resp = $this->resp;
        $this->resp = '';
        return $resp;
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
     * canFetchTrackingDetail
     *
     * @return bool
     */
    public function canFetchTrackingDetail(): bool
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
        $json = FatCache::get(self::KEY_NAME . '-carriers' . $this->langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!empty($json)) {
            return json_decode($json, true);
        }

        if (false === $this->doRequest(self::REQUEST_GET_CARRIERS)) {
            return [];
        }
        $carriers = ($this->getResponse())['carriers'];

        if (0 < $limit && $limit  < count($carriers)) {
            $carriers = array_slice($carriers, ($limit - 1));
        }

        $carriers = array_map(function ($carriers) {
            return $carriers + ['code' => $carriers['carrier_code']];
        }, $carriers);
        FatCache::set(self::KEY_NAME . '-carriers' . $this->langId, FatUtility::convertToJson($carriers), '.txt');
        return $carriers;
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
    public function setAddress(string $name, string $stt1, string $stt2, string $city, string $state, string $zip, string $countryCode, string $phone)
    {
        $this->toAddress = [
            'Line1' => $name . ' ' . $stt1,
            'Line2' => $stt2,
            'State' => $state,
            'PostCode' => $zip,
            'City' => $city,
            'CountryCode' => $countryCode
        ];
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
    public function setFromAddress(string $name, string $stt1, string $stt2, string $city, string $state, string $zip, string $countryCode, string $phone)
    {
        $this->fromAddress = [
            'Line1' => $name . ' ' . $stt1,
            'Line2' => $stt2,
            'State' => $state,
            'PostCode' => $zip,
            'City' => $city,
            'CountryCode' => $countryCode
        ];
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
     * setDimensions
     *
     * @param  float $length
     * @param  float $width
     * @param  float $height
     * @param  string $unit
     * @return void
     */
    public function setDimensions($length, $width, $height, $unit = 'cm')
    {
        if (empty($length) || empty($width) || empty($height)) {
            return;
        }

        $this->dimensions = [
            'length' => $this->convertToInch($length, $unit),
            'breadth' => $this->convertToInch($width, $unit),
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
     * getRates
     *
     * @return array
     */
    public function getRates(): array
    {
        $carriersResp = $this->getCarriers();
        if (false === $carriersResp) {
            return [];
        }

        $carriers = array_map(function ($carriersResp) {
            return $carriersResp['carrier_id'];
        }, $carriersResp);

        $requestParam = [
            "from_country_code" => $this->fromAddress['CountryCode'],
            'from_postal_code' => $this->fromAddress['PostCode'],
            "to_country_code" => $this->toAddress['CountryCode'],
            'to_postal_code' => $this->toAddress['PostCode'],
            'weight' => [
                'value' => $this->weight,
                'unit' => "ounce",
            ],
            "carrier_ids" => (array) $carriers
        ];

        if (false === $this->doRequest(self::REQUEST_GET_RATES, $requestParam)) {
            return [];
        }

        $rates = [];
        foreach ($this->getResponse() as $detail) {
            if ('invalid' == $detail['validation_status'] && (!empty($detail['warning_messages']) || !empty($detail['error_messages']))) {
                $this->error = current($detail['warning_messages']);
                if (empty($this->error)) {
                    $this->error = current($detail['warning_messages']);
                }
                return [];
                break;
            }

            $serviceName = $detail['service_type'];

            if (array_key_exists('carrier_delivery_days', $detail) && 0 < $detail['carrier_delivery_days']) {
                $deliveryDays = Labels::getLabel("LBL_ESTIMATED_DELIVERY_IN_{DELIVERY-DAYS}_DAY_'S", $this->langId);
                $serviceName .= '. ' . CommonHelper::replaceStringData($deliveryDays, ['{DELIVERY-DAYS}' => $detail['carrier_delivery_days']]);
            }
            $service = $detail['carrier_id'] . '|' . $detail['service_code'];
            $rates[] = [
                'serviceName' => $serviceName,
                'serviceCode' => $service,
                'shipmentId' => $service,
                'shipmentCost' => $detail['shipping_amount']['amount'],
                'otherCost' => '0',
            ];
        }
        return $rates;
    }

    /**
     * proceedToShipment
     *
     * @param  array $requestParam
     * @return bool
     */
    public function proceedToShipment(array $requestParam): bool
    {
        $this->orderDetail = $this->getSystemOrder($requestParam['op_id']);
        if (empty($this->orderDetail)) {
            $this->error = Labels::getLabel('MSG_INVALID_ORDER', $this->langId);
            return false;
        }

        $orderObj = new Orders($this->orderDetail['order_id']);
        $addresses = $orderObj->getOrderAddresses($this->orderDetail['order_id']);
        $shippingAddress = (!empty($addresses[Orders::SHIPPING_ADDRESS_TYPE])) ? $addresses[Orders::SHIPPING_ADDRESS_TYPE] : [];               

        $serviceCode = explode('|', $this->orderDetail['opshipping_service_code']);

        $attr = [
            'shop_address_line_1',
            'shop_address_line_2',
            'shop_city',
            'state_code',
            'COALESCE(state_name, state_identifier) as state_name',
            'country_code',
            'country_name',
            'shop_postalcode',
        ];
        $shopAddress = Shop::getShopAddress($this->orderDetail['op_shop_id'], false, $this->langId, $attr);

        $requestParam = [
            'shipment' => [
                "service_code" => $serviceCode[1],
                "ship_to" => [
                    "name" => $this->orderDetail['buyer_user_name'],
                    "address_line1" => $shippingAddress['oua_address1'] . ' ' . $shippingAddress['oua_address2'],
                    "city_locality" => $shippingAddress['oua_city'],
                    "state_province" => $shippingAddress['oua_state_code'],
                    "postal_code" => $shippingAddress['oua_zip'],
                    "country_code" => $shippingAddress['oua_country_code'],
                    "address_residential_indicator" => "yes"
                ],
                "ship_from" => [
                    "name" => $this->orderDetail['op_shop_owner_name'],
                    "company_name" => $this->orderDetail['op_shop_name'],
                    "phone" => $this->orderDetail['op_shop_owner_phone'],
                    "address_line1" => $shopAddress['shop_address_line_1'] . ' ' . $shopAddress['shop_address_line_2'],
                    "city_locality" => $shopAddress['shop_city'],
                    "state_province" => $shopAddress['state_code'],
                    "postal_code" => $shopAddress['shop_postalcode'],
                    "country_code" => $shopAddress['country_code'],
                    "address_residential_indicator" => "no"
                ],
                "packages" => []
            ]
        ];

        for ($i = 1; $i <= $this->orderDetail['op_qty']; $i++) { 
            $requestParam["shipment"]["packages"][] = [
                "weight" => [
                    "value" => $this->orderDetail['op_product_weight'],
                    "unit" => "ounce"
                ],
                "dimensions" => [
                    "height" => $this->convertToInch($this->orderDetail['op_product_height'], $this->orderDetail['op_product_dimension_unit']),
                    "width" => $this->convertToInch($this->orderDetail['op_product_width'], $this->orderDetail['op_product_dimension_unit']),
                    "length" => $this->convertToInch($this->orderDetail['op_product_length'], $this->orderDetail['op_product_dimension_unit']),
                    "unit" => "inch"
                ]
            ];
        }

        if (false === $this->doRequest(self::REQUEST_GENERATE_LABEL, $requestParam)) {
            return false;
        }

        $labelResp = $this->getResponse();
        $trackingNumber = [];
        foreach ($labelResp['packages'] as $value) {
            $trackingNumber[] = $value['tracking_number'];
        }
        $this->resp = [
            'shipment_response' => $labelResp,
            'orderNumber' => $labelResp['shipment_id'],
            'tracking_code' => implode(', ', $trackingNumber)
        ];
        return true;
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
        if (!array_key_exists('shipment_response', $labelData)) {
            return false;
        }
        $labelUrl = isset($labelData['shipment_response']['label_download']['pdf']) ? $labelData['shipment_response']['label_download']['pdf'] : $labelData['shipment_response']['label_download']['href'];
        FatApp::redirectUser($labelUrl);
        return true;
    }

    /**
     * fetchTrackingDetail
     *
     * @return array
     */
    public function fetchTrackingDetail(): array
    {
        if (empty($this->orderDetail)) {
            $this->error = Labels::getLabel('MSG_UNABLE_TO_LOAD_ORDER', $this->langId);
            return [];
        }

        $labelData = $this->orderDetail['opr_response'];
        if (empty($labelData)) {
            $this->error = Labels::getLabel('MSG_UNABLE_TO_FETCH_TRACKING_DETAILS', $this->langId);
            return [];
        }
        $labelData = json_decode($labelData, true);

        if (false === $this->doRequest(self::REQUEST_TRACKING, $labelData['shipment_response']['label_id'])) {
            return [];
        }

        $trackingDetail = $this->getResponse();
        $data = [];

        if (!empty($trackingDetail)) {
            $data = [
                'detail' => [],
                'response' => $trackingDetail,
                'trackingUrl' => $trackingDetail['tracking_url'],
            ];

            if (isset($trackingDetail['events']) && is_array($trackingDetail['events'])) {
                $events = $trackingDetail['events'];
                foreach ($events as $trkData) {
                    $data['detail'][] = [
                        'description' => $trkData['description'],
                        'dateTime' => $trkData['carrier_occurred_at'],
                        'location' => $trkData['city_locality'] . ', ' . $trkData['state_province'] . ', ' . $trkData['postal_code'] . ', ' . $trkData['country_code'],
                        'comments' => '',
                        'status' => self::TRACKING_STATUS_PROCESSING,
                    ];
                }
            }
        }

        return $data;
    }

    /**
     * loadSystemOrder
     *
     * @param  int $opId
     * @return void
     */
    public function loadSystemOrder(int $opId): void
    {
        $this->orderDetail = (array) $this->getSystemOrder($opId);
    }

    /**
     * getApiUrl
     *
     * @return string
     */
    private function getApiUrl(): string
    {
        return self::PRODUCTION_URL . self::VERSION;
    }

    /**
     * doRequest
     *
     * @param  int $requestType
     * @param  mixed $requestParam
     * @return bool
     */
    private function doRequest(int $requestType, $requestParam = []): bool
    {
        try {
            $curl = new Curl();
            $curl->setHeader('API-Key', $this->apiKey);
            $curl->setHeader('Content-Type', 'application/json');
            switch ($requestType) {
                case self::REQUEST_GET_CARRIERS:
                    $curl->get($this->getApiUrl() . 'carriers');
                    break;
                case self::REQUEST_GET_RATES:
                    $curl->post($this->getApiUrl() . 'rates/estimate', $requestParam);
                    break;
                case self::REQUEST_GENERATE_LABEL:
                    $curl->post($this->getApiUrl() . 'labels', $requestParam);
                    break;
                case self::REQUEST_TRACKING:
                    $curl->get($this->getApiUrl() . 'labels/' . $requestParam . '/track');
                    break;
            }

            if ($curl->error) {
                $resp = json_decode(json_encode($curl->response), true);
                if (array_key_exists('errors', $resp) && is_array($resp['errors'])) {
                    $this->error = ucwords(current($resp['errors'])['message']);
                } else {
                    $this->error = $curl->errorCode . ' : ' . $curl->errorMessage;
                    $this->error .= !empty($curl->getResponse()->error) ? $curl->getResponse()->error : '';
                }
                return false;
            }

            $this->resp = json_decode(json_encode($curl->getResponse()), true);
            return true;
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        } catch (Error $e) {
            $this->error = $e->getMessage();
        }
        return false;
    }
}
