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
    private const REQUEST_CHANNELS = 3;
    private const REQUEST_ADD_ORDER = 4;
    private const REQUEST_GET_PICKUP_LOCATIONS = 5;
    private const REQUEST_ADD_PICKUP_LOCATION = 6;
    private const REQUEST_ASSIGN_AWB = 7;
    private const REQUEST_GENERATE_LABEL = 8;
    private const REQUEST_RETURN_ORDER = 9;
    private const REQUEST_CANCEL_ORDER = 10;

    private $apiKey = '';
    private $resp;
    private $clientInfoCols = [];
    private $client;
    private $toAddress = [];
    private $fromAddress = [];
    private $dimensions = [];
    private $weight = 0;
    private $channel = [];
    private $pickups = [];
    private $orderDetail = [];
    private $buyerReturnAddress = [];

    public $requiredKeys = ['api_key'];

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(int $langId)
    {
        $this->langId = 0 < $langId ? $langId : CommonHelper::getLangId();
        $this->clientInfoCols = $this->requiredKeys;
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
     * getColsLabelArr
     *
     * @return array
     */
    public function getColsLabelArr(): array
    {
        $lblArr = [];
        foreach ($this->clientInfoCols as $col) {
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
     * convertToCm
     *
     * @param  float $value
     * @param  int $unit
     * @return float
     */
    private function convertToCm($value, $unit)
    {
        switch ($unit) {
            case ShippingPackage::UNIT_TYPE_INCH:
                return $value * 2.54;
                break;
            case ShippingPackage::UNIT_TYPE_METER:
                return $value * 100;
                break;

            default:
                return $value;
                break;
        }
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
            'length' => $this->convertToCm($length, $unit),
            'breadth' => $this->convertToCm($width, $unit),
            'height' => $this->convertToCm($height, $unit),
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
            "from_country_code" =>$this->fromAddress['CountryCode'],
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

            $rates[] = [
                'serviceName' => $serviceName,
                'serviceCode' => $detail['service_code'],
                'shipmentId' => $detail['carrier_id'] . '|' . $detail['service_code'],
                'shipmentCost' => $detail['shipping_amount']['amount'],
                'otherCost' => '0',
            ];
        }
        return $rates;
    }

    /**
     * getChannel
     *
     * @return array
     */
    public function getChannel(): array
    {
        if (!empty($this->channel)) {
            return $this->channel;
        }

        if (false === $this->doRequest(self::REQUEST_CHANNELS)) {
            return [];
        }

        $resp = $this->getResponse();
        return $this->channel = current($resp['data']);
    }

    /**
     * getPickupLocation
     *
     * @param  int $shopId
     * @return int
     */
    private function getPickupLocation(int $shopId): int
    {
        $updatedOn = Shop::getAttributesById($shopId, 'shop_updated_on');
        $pickupLocationId = $shopId . date('ym', strtotime($updatedOn));
        $pickups = $this->getAllPickupLocations();

        if (false !== array_search($pickupLocationId, array_column($pickups, 'pickup_location'))) {
            return (int) $pickupLocationId;
        }

        if (false === $this->addPickupLocation($pickupLocationId)) {
            return 0;
        }
        return $pickupLocationId;
    }

    /**
     * getReturnPickupLocation
     *
     * @return string
     */
    private function getReturnPickupLocation(): int
    {
        $pickupLocationId = $this->orderDetail['op_invoice_number'];
        $pickups = $this->getAllPickupLocations();

        $locationIndex = array_search($pickupLocationId, array_column($pickups, 'pickup_location'));
        if (false !== $locationIndex) {
            return (int) $pickups[$locationIndex]['id'];
        }

        if (false === $this->addReturnPickupLocation($pickupLocationId)) {
            return 0;
        }

        $resp = $this->getResponse();
        if (1 > $resp['success']) {
            $this->error = Labels::getLabel('MSG_UNABLE_TO_ADD_LOCATION', $this->langId);
            return 0;
        }
        return (int) $resp['address']['id'];
    }

    /**
     * getAllPickupLocations
     *
     * @return array
     */
    private function getAllPickupLocations(): array
    {
        if (!empty($this->pickups)) {
            return $this->pickups;
        }

        if (false === $this->doRequest(self::REQUEST_GET_PICKUP_LOCATIONS)) {
            return [];
        }

        $resp = $this->getResponse();
        return $this->pickups = current($resp['data']);
    }

    /**
     * addPickupLocation
     *
     * @return array
     */
    private function addPickupLocation(int $pickupLocationId)
    {
        $attr = [
            'shop_address_line_1',
            'shop_address_line_2',
            'shop_city',
            'COALESCE(state_name, state_identifier) as state_name',
            'country_name',
            'shop_postalcode',
        ];
        $address = Shop::getShopAddress($this->orderDetail['op_shop_id'], false, $this->langId, $attr);

        $requestParam = [
            'pickup_location' => FatUtility::convertToType($pickupLocationId, FatUtility::VAR_STRING),
            'name' => $this->orderDetail['op_shop_owner_name'],
            'email' => $this->orderDetail['op_shop_owner_email'],
            'phone' => $this->orderDetail['op_shop_owner_phone'],
            'address' => $address['shop_address_line_1'],
            'address_2' => $address['shop_address_line_2'],
            'city' => $address['shop_city'],
            'state' => $address['state_name'],
            'country' => $address['country_name'],
            'pin_code' => $address['shop_postalcode'],
        ];
        return $this->doRequest(self::REQUEST_ADD_PICKUP_LOCATION, $requestParam);
    }

    /**
     * addReturnPickupLocation
     *
     * @param  string $pickupLocationId
     * @return void
     */
    private function addReturnPickupLocation(string $pickupLocationId)
    {
        $requestParam = [
            'pickup_location' => FatUtility::convertToType($pickupLocationId, FatUtility::VAR_STRING),
            'name' => $this->buyerReturnAddress['oua_name'],
            'email' => $this->orderDetail['buyer_email'],
            'phone' => $this->buyerReturnAddress['oua_phone'],
            'address' => $this->buyerReturnAddress['oua_address1'],
            'address_2' => $this->buyerReturnAddress['oua_address2'],
            'city' => $this->buyerReturnAddress['oua_city'],
            'state' => $this->buyerReturnAddress['oua_state'],
            'country' => $this->buyerReturnAddress['oua_country'],
            'pin_code' => $this->buyerReturnAddress['oua_zip'],
        ];
        return $this->doRequest(self::REQUEST_ADD_PICKUP_LOCATION, $requestParam);
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

        $pickupLocationId = $this->getPickupLocation($this->orderDetail['op_shop_id']);
        if (1 > (int) $pickupLocationId) {
            $this->error = Labels::getLabel('MSG_UNABLE_TO_GET_PICKUP_LOCATION', $this->langId);
            return false;
        }

        $orderTimestamp = strtotime($this->orderDetail['order_date_added']);
        $taxOptions = json_decode($this->orderDetail['op_product_tax_options'], true);

        $shippingTotal = CommonHelper::orderProductAmount($this->orderDetail, 'SHIPPING');

        $discount = CommonHelper::orderProductAmount($this->orderDetail, 'DISCOUNT');
        $volumeDiscount = CommonHelper::orderProductAmount($this->orderDetail, 'VOLUME_DISCOUNT');
        $totalDiscount = abs($discount) + abs($volumeDiscount);
        $discountPerUnit = ($totalDiscount / $this->orderDetail['op_qty']); /* Inclusive Tax */

        $taxCharged = 0;
        if (!empty($taxOptions)) {
            foreach ($taxOptions as $key => $val) {
                $taxCharged += $val['value'];
            }
        }

        $orderObj = new Orders($this->orderDetail['order_id']);
        $addresses = $orderObj->getOrderAddresses($this->orderDetail['order_id']);
        $billingAddress = $addresses[Orders::BILLING_ADDRESS_TYPE];
        $shippingAddress = (!empty($addresses[Orders::SHIPPING_ADDRESS_TYPE])) ? $addresses[Orders::SHIPPING_ADDRESS_TYPE] : [];

        $channel = $this->getChannel();

        $this->setAddress($billingAddress['oua_name'], $billingAddress['oua_address1'], $billingAddress['oua_address2'], $billingAddress['oua_city'], $billingAddress['oua_state'], $billingAddress['oua_zip'], $billingAddress['oua_country_code'], $billingAddress['oua_phone']);

        $this->orderDetail['op_other_charges'] = array_sum(array_column($this->orderDetail['charges'], 'opcharge_amount'));

        $taxOptions = !empty($this->orderDetail['op_product_tax_options']) ? json_decode($this->orderDetail['op_product_tax_options'], true) : [];
        $taxPercentage = !empty($taxOptions) ? $taxOptions['Tax']['percentageValue'] : 0;

        $sellingPrice = $this->orderDetail['op_unit_price'] + ($taxCharged / $this->orderDetail['op_qty']);
        if (0 < FatApp::getConfig("CONF_PRODUCT_INCLUSIVE_TAX", FatUtility::VAR_INT, 0)) {
            $sellingPrice =  $this->orderDetail['op_unit_price'];
        }

        $requestParam = [
            'order_id' => $this->orderDetail['op_invoice_number'],
            'order_date' => date('Y-m-d H:i', $orderTimestamp),
            'pickup_location' => FatUtility::convertToType($pickupLocationId, FatUtility::VAR_STRING),
            'channel_id' => isset($channel['id']) ? $channel['id'] : '',
            'comment' => $this->orderDetail['op_order_id'] . ' - ' . $this->orderDetail['op_invoice_number'],
            'reseller_name' => $this->orderDetail['op_shop_owner_name'],
            'company_name' =>  $this->orderDetail['op_shop_name'],
            'billing_customer_name' => CommonHelper::getFirstName($this->orderDetail['buyer_user_name']),
            "billing_last_name" => CommonHelper::getLastName($this->orderDetail['buyer_user_name']),
            'billing_address' => $billingAddress['oua_address1'],
            'billing_address_2' => $billingAddress['oua_address2'],
            'billing_city' => $billingAddress['oua_city'],
            'billing_pincode' => $billingAddress['oua_zip'],
            'billing_state' => $billingAddress['oua_state'],
            'billing_country' => $billingAddress['oua_country'],
            'billing_email' => $this->orderDetail['buyer_email'],
            'billing_phone' => $this->orderDetail['buyer_phone'],
            'shipping_is_billing' => false,
            'shipping_customer_name' => CommonHelper::getFirstName($this->orderDetail['buyer_user_name']),
            "shipping_last_name" => CommonHelper::getLastName($this->orderDetail['buyer_user_name']),
            'shipping_address' => $shippingAddress['oua_address1'],
            'shipping_address_2' => $shippingAddress['oua_address2'],
            'shipping_city' => $shippingAddress['oua_city'],
            'shipping_pincode' => $shippingAddress['oua_zip'],
            'shipping_country' => $shippingAddress['oua_country'],
            'shipping_state' => $shippingAddress['oua_state'],
            'shipping_email' => $this->orderDetail['buyer_email'],
            'shipping_phone' => $this->orderDetail['buyer_phone'],
            'order_items' => [
                [
                    'name' =>  $this->orderDetail['op_selprod_title'],
                    'sku' =>  $this->orderDetail['op_selprod_sku'],
                    'units' => $this->orderDetail['op_qty'],
                    'selling_price' => $sellingPrice,
                    'discount' => $discountPerUnit,
                    'tax' => $taxPercentage,
                ]
            ],
            'payment_method' => (FatApp::getConfig("CONF_COD_ORDER_STATUS", FatUtility::VAR_INT, OrderStatus::ORDER_COD) == $this->orderDetail['op_status_id']) ? 'COD' : 'Prepaid',
            'shipping_charges' => $shippingTotal,
            'total_discount' => $totalDiscount,
            'sub_total' => CommonHelper::orderProductAmount($this->orderDetail, 'CART_TOTAL', false, User::USER_TYPE_SELLER) + $taxCharged,
            'length' => $this->convertToCm($this->orderDetail['op_product_length'], $this->orderDetail['op_product_dimension_unit']),
            'breadth' => $this->convertToCm($this->orderDetail['op_product_width'], $this->orderDetail['op_product_dimension_unit']),
            'height' => $this->convertToCm($this->orderDetail['op_product_height'], $this->orderDetail['op_product_dimension_unit']),
            'weight' => $this->convertToKg($this->orderDetail['op_product_weight'])
        ];

        if (false === $this->doRequest(self::REQUEST_ADD_ORDER, $requestParam)) {
            return false;
        }
        $orderShipment = $this->getResponse();

        if (!isset($orderShipment['shipment_id']) && isset($orderShipment['message'])) {
            $this->error = $orderShipment['message'];
            return false;
        }

        $requestParam = [
            'shipmentIdsArr' => [$orderShipment['shipment_id']],
            'courierId' => $this->orderDetail['opshipping_service_code'],
            'weight' => $this->convertToKg($this->orderDetail['op_product_weight']),
        ];
        if (false === $this->doRequest(self::REQUEST_ASSIGN_AWB, $requestParam)) {
            return false;
        }

        $awbResp = $this->getResponse();
        if (applicationConstants::SUCCESS != $awbResp['awb_assign_status']) {
            $this->error = Labels::getLabel('MSG_UNABLE_TO_ASSIGN_AWB_FOR_THE_ORDER', $this->langId);
            return false;
        }

        if (false === $this->doRequest(self::REQUEST_GENERATE_LABEL, ['shipment_id' => $orderShipment['shipment_id']])) {
            return false;
        }

        $labelResp = $this->getResponse();
        if (applicationConstants::SUCCESS != $labelResp['label_created']) {
            $this->error = Labels::getLabel('MSG_UNABLE_TO_BIND_LABEL', $this->langId);
            return false;
        }
        $this->resp = [
            'shipment_response' => json_encode($orderShipment),
            'awb_response' => json_encode($awbResp),
            'label_response' => json_encode($labelResp),
            'orderNumber' => $orderShipment['order_id'],
            'tracking_url' => $labelResp['label_url'],
            'tracking_code' => $labelResp['shipment_id'],
        ];
        return true;
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
     * refundShipment
     *
     * @return bool
     */
    public function refundShipment(): bool
    {
        $orderId = OrderProductShipment::getAttributesById($this->orderDetail['op_id'], 'opship_order_number');
        if (false == $orderId || empty($orderId)) {
            $this->error = Labels::getLabel('MSG_UNABLE_TO_LOCATE_ORDER', $this->langId);
            return false;
        }
        return $this->doRequest(self::REQUEST_CANCEL_ORDER, ['ids' => [$orderId]]);
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
                case self::REQUEST_CHANNELS:
                    $this->resp = $this->client->channelsList();
                    break;
                case self::REQUEST_ADD_ORDER:
                    $this->resp = $this->client->createQuickOrder($requestParam);
                    break;
                case self::REQUEST_GET_PICKUP_LOCATIONS:
                    $this->resp = $this->client->getPickups($requestParam);
                    break;
                case self::REQUEST_ADD_PICKUP_LOCATION:
                    $this->resp = $this->client->createPickup($requestParam);
                    break;
                case self::REQUEST_ASSIGN_AWB:
                    $shipmentIdsArr = $requestParam['shipmentIdsArr'];
                    $courierId = $requestParam['courierId'];
                    $weight = $requestParam['weight'];
                    $this->resp = $this->client->assignAWBs($shipmentIdsArr, $courierId, $weight);
                    break;
                case self::REQUEST_GENERATE_LABEL:
                    $this->resp = $this->client->generateLabel($requestParam);
                    break;
                case self::REQUEST_RETURN_ORDER:
                    $this->resp = $this->client->createReturnOrder($requestParam);
                    break;
                case self::REQUEST_CANCEL_ORDER:
                    $this->resp = $this->client->cancelOrder($requestParam);
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
