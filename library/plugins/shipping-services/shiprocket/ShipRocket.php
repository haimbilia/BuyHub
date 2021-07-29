<?php

/**
 * ShipRocket - https://apidocs.shiprocket.in
 */

require_once dirname(__FILE__) . '/ShipRocketApi.php';

class ShipRocket extends ShippingServicesBase
{
    public const KEY_NAME = __CLASS__;

    private const REQUEST_GET_RATES = 1;
    private const REQUEST_CHANNELS = 2;
    private const REQUEST_ADD_ORDER = 3;
    private const REQUEST_GET_PICKUP_LOCATIONS = 4;
    private const REQUEST_ADD_PICKUP_LOCATION = 5;

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

    public $requiredKeys = [
        'email',
        'password'
    ];

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(int $langId)
    {
        $this->langId = 0 < $langId ? $langId : CommonHelper::getLangId();
        $this->clientInfoCols = $this->requiredKeys;
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

        $this->client = new ShipRocketApi([
            'email' => $this->settings['email'],
            'password' => $this->settings['password'],
            'use_sandbox' => 0,  /* Use 0 As this API won`t support sanbox mode. */
        ]);
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
     * getCarriers - No API found to fetch carrier list.
     *
     * @return array
     */
    public function getCarriers(): array
    {
        return [
            ['code' => self::KEY_NAME]
        ];
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
     * convertToKg - From Ounces
     *
     * @param  float $value
     * @return float
     */
    private function convertToKg($value)
    {
        return (float) $value * 0.02834952;
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
        $requestParam = [
            'pickup_postcode' => $this->fromAddress['PostCode'],
            'delivery_postcode' => $this->toAddress['PostCode'],
            'weight' => $this->convertToKg($this->weight),
        ];

        if (false === $this->doRequest(self::REQUEST_GET_RATES, $requestParam)) {
            return [];
        }

        $resp = $this->getResponse();
        $courierCompanies = isset($resp['data']['available_courier_companies']) ? $resp['data']['available_courier_companies'] : [];
        if (empty($courierCompanies)) {
            return [];
        }

        $rates = [];
        foreach ($courierCompanies as $detail) {
            $rates[] = [
                'serviceName' => $detail['courier_name'],
                'serviceCode' => $detail['courier_company_id'],
                'shipmentId' => $detail['courier_company_id'],
                'shipmentCost' => $detail['rate'],
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
        $pickupLocationId = str_pad($shopId . date('ym', strtotime($updatedOn)), 8, 0, STR_PAD_LEFT);
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
     * getAllPickupLocations
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
            'shipping_country' => $shippingAddress['oua_state'],
            'shipping_state' => $shippingAddress['oua_country'],
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
            'payment_method' => $this->orderDetail['opayment_method'],
            'shipping_charges' => $shippingTotal,
            'total_discount' => $totalDiscount,
            'sub_total' => CommonHelper::orderProductAmount($this->orderDetail, 'CART_TOTAL', false , User::USER_TYPE_SELLER) + $taxCharged,
            'length' => $this->convertToCm($this->orderDetail['op_product_length'], $this->orderDetail['op_product_dimension_unit']),
            'breadth' => $this->convertToCm($this->orderDetail['op_product_width'], $this->orderDetail['op_product_dimension_unit']),
            'height' => $this->convertToCm($this->orderDetail['op_product_height'], $this->orderDetail['op_product_dimension_unit']),
            'weight' => $this->convertToKg($this->orderDetail['op_product_weight'])
        ];
        
        return $this->doRequest(self::REQUEST_ADD_ORDER, $requestParam);
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
            switch ($requestType) {
                case self::REQUEST_GET_RATES:
                    $this->resp = $this->client->checkServiceability($requestParam['pickup_postcode'], $requestParam['delivery_postcode'], 0, $requestParam['weight']);
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
            }
            return true;
        } catch (Exception $e) {
            CommonHelper::printArray($e);
            $this->error = $e->getMessage();
        } catch (Error $e) {
            $this->error = $e->getMessage();
        }
        return false;
    }
}
