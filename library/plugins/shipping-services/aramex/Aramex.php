<?php

/**
 * Aramex - https://www.aramex.com/us/en/solutions-services/developers-solutions-center/apis
 */
class Aramex extends ShippingServicesBase
{
    public const KEY_NAME = __CLASS__;

    private const REQUEST_RATE = 1;
    private const REQUEST_SHIPPING = 2;
    private const REQUEST_VALIDATE_ADDRESS = 3;
    private const REQUEST_TRACKING = 4;
    private const REQUEST_PICKUP = 5;
    private const REQUEST_PICKUP_CANCEL = 6;

    private $resp;
    private $ratesReference = '';
    private $orderQty = 1;
    private $weight;
    private $dimensions;
    private $toAddress = [];
    private $fromAddress = [];
    private $addressReference;
    private $serviceRequest = 0;

    public $requiredKeys = [
        'AccountCountryCode',
        'AccountEntity',
        'AccountNumber',
        'AccountPin',
        'UserName',
        'Password'
    ];

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(int $langId)
    {
        $this->langId = 0 < $langId ? $langId : CommonHelper::getLangId();
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
     * getFormFieldsArr
     *
     * @return array
     */
    public function getFormFieldsArr(): array
    {
        $lblArr = [];
        foreach ($this->requiredKeys as $col) {
            $lbl = Labels::getLabel('LBL_' . strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $col)), $this->langId);
            $lblArr[$col] = $lbl;
        }
        return $lblArr;
    }

    /**
     * setServiceRequest
     *
     * @param  int $request
     * @return void
     */
    private function setServiceRequest(int $request): void
    {
        $this->serviceRequest = $request;
    }

    /**
     * getClientInfo
     *
     * @return array
     */
    private function getClientInfo(): array
    {
        if (false == $this->validateSettings($this->langId)) {
            return [];
        }

        $clientInfoArr = [];
        foreach ($this->requiredKeys as $col) {
            $clientInfoArr[$col] = $this->settings[$col];
        }
        $clientInfoArr['Version'] = 'v1.0';
        return $clientInfoArr;
    }

    /**
     * getSoapClient
     *
     * @return object
     */
    private function getSoapClient(): object
    {
        $service = $this->serviceRequest;
        $options = [
            'trace' => true,
            'cache_wsdl' => WSDL_CACHE_MEMORY,
            'stream_context' => stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]])
        ];
        $wsdl = dirname(__FILE__) . '/wsdls';

        switch ($service) {
            case self::REQUEST_SHIPPING:
            case self::REQUEST_PICKUP:
                $wsdl .= '/shipping.wsdl';
                break;

            case self::REQUEST_PICKUP_CANCEL:
                $wsdl .= '/shipping.wsdl';
                break;

            case self::REQUEST_TRACKING:
                $wsdl .= '/tracking.wsdl';
                break;

            case self::REQUEST_RATE:
                $wsdl .= '/rate.wsdl';
                break;

            case self::REQUEST_VALIDATE_ADDRESS:
                $wsdl .= '/location.wsdl';
                break;
            default:
                CommonHelper::dieWithError(Labels::getLabel('LBL_INVALID_SERVICE_REQUEST', $this->langId));
                break;
        }

        return new SoapClient($wsdl, $options);
    }

    /**
     * getCarriers - Itself a carrier.
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
     * setAddressReference
     *
     * @param  string $referenceId
     * @return void
     */
    public function setAddressReference(string $referenceId)
    {
        $this->addressReference = $referenceId;
    }

    /**
     * validateAddress
     *
     * @param  string $name - 0
     * @param  string $stt1 - 1
     * @param  string $stt2 - 2
     * @param  string $city - 3
     * @param  string $state - 4
     * @param  string $zip - 5
     * @param  string $countryCode - 6
     * @param  string $phone - 7
     * @return array
     */
    private function validateAddress(array $args): bool
    {
        $address = [
            'Line1' => $args[1],
            'Line2' => $args[2],
            'State' => $args[4],
            'PostCode' => $args[5],
            'City' => $args[3],
            'CountryCode' => $args[6]
        ];

        /* Not Required As API Not Working Correctly. */
        /* $this->setServiceRequest(self::REQUEST_VALIDATE_ADDRESS);

            $requestParam = [
                'ClientInfo' => $this->getClientInfo(),
                'Transaction' => [
                    'Reference1' => $this->addressReference
                ],
                'Address' => $address
            ];

            if (false === $this->doRequest($requestParam)) {
                return false;
            } */
        /* ----------------------------- */

        $this->resp = $address;
        return true;
    }

    /**
     * setAddress - Set To Address
     *
     * @return bool
     */
    public function setAddress(): bool
    {
        if (false === $this->validateAddress(func_get_args())) {
            return false;
        }
        $this->toAddress = $this->getResponse();
        return true;
    }

    /**
     * setFromAddress
     *
     * @return bool
     */
    public function setFromAddress(): bool
    {
        if (false === $this->validateAddress(func_get_args())) {
            return false;
        }
        $this->fromAddress = $this->getResponse();
        return true;
    }

    /**
     * convertToCentimeter
     *
     * @param  float $value
     * @param  int $unit
     * @return float
     */
    private function convertToCentimeter($value, $unit)
    {
        switch ($unit) {
            case ShippingPackage::UNIT_TYPE_METER:
                return $value / 100;
                break;
            case ShippingPackage::UNIT_TYPE_INCH:
                return $value / 2.54;
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
    public function setDimensions($length, $width, $height, $unit = 'cm')
    {
        if (empty($length) || empty($width) || empty($height)) {
            return;
        }

        $this->dimensions = [
            'Length' => $this->convertToCentimeter($length, $unit),
            'Width' => $this->convertToCentimeter($width, $unit),
            'Height' => $this->convertToCentimeter($height, $unit),
            'Unit' => "cm"
        ];
    }

    /**
     * setReference - Setter
     *
     * @param  string $referenceId
     * @return void
     */
    public function setReference(string $referenceId)
    {
        $this->ratesReference = $referenceId;
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
     * convertToKgFromOz
     *
     * @param  float $value
     * @return float
     */
    private function convertToKgFromOz($value)
    {
        return CommonHelper::numberFormat(($value * 0.02834952), true, true, 3);
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
        $this->weight = $this->convertToKgFromOz($weight);
    }

    /**
     * convertToSiteCurrency
     *
     * @param  array $val
     * @return void
     */
    private function convertToSiteCurrency(array $val)
    {
        $defaultCurrencyId = FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1);
        $allCurrencies = Currency::getCurrencyAssoc($this->langId);

        $convertCurrency = $val['CurrencyCode'];
        $fromCurrency = array_search(strtolower($convertCurrency), array_map('strtolower', $allCurrencies));
        if (false === $fromCurrency) {
            $msg = Labels::getLabel('LBL_({CURRENCY})_INVALID_CURRENCY._PLEASE_CONTACT_ADMIN_TO_PROCEED_FURTHER,', $this->langId);
            CommonHelper::dieWithError(CommonHelper::replaceStringData($msg, ['{CURRENCY}' => $convertCurrency]));
        }
        return CommonHelper::convertExistingToOtherCurrency($fromCurrency, $val['Value'], $defaultCurrencyId, false);
    }

    /**
     * getRates
     *
     * @return array
     */
    public function getRates(): array
    {
        $this->setServiceRequest(self::REQUEST_RATE);

        $requestParam = [
            'ClientInfo' => $this->getClientInfo(),
            'Transaction' => [
                'Reference1' => $this->ratesReference
            ],
            'OriginAddress' => $this->fromAddress,
            'DestinationAddress' => $this->toAddress,
            'ShipmentDetails' => [
                'PaymentType' => 'P',
                'ProductGroup' => 'EXP',
                'ProductType' => 'PPX', /* When EPX Used Failed to get Rate */
                'ActualWeight' => array('Value' => $this->weight, 'Unit' => 'KG'),
                'ChargeableWeight' => array('Value' => $this->weight, 'Unit' => 'KG'),
                'NumberOfPieces' => $this->orderQty
            ]
        ];

        if (false === $this->doRequest($requestParam)) {
            return [];
        }

        $rates = $this->getResponse();
        return [
            [
                'serviceName' => self::KEY_NAME,
                'serviceCode' => self::KEY_NAME,
                'shipmentId' => $rates['Transaction']['Reference1'],
                'shipmentCost' => $this->convertToSiteCurrency($rates['TotalAmount']),
                'otherCost' => 0,
            ]
        ];
    }

    /**
     * proceedToShipment
     *
     * @param  array $orderData
     * @return bool
     */
    public function proceedToShipment(array $orderData): bool
    {
        $systemOrderDetail = $this->getSystemOrder($orderData['op_id']);

        $orderObj = new Orders();
        $buyerAddresses = $orderObj->getOrderAddresses($orderData['op_order_id']);
        $toAddress = (array_key_exists(Orders::SHIPPING_ADDRESS_TYPE, $buyerAddresses)) ? $buyerAddresses[Orders::SHIPPING_ADDRESS_TYPE] : [];

        if (!empty($toAddress)) {
            if (false === $this->setAddress('', $toAddress['oua_address1'], $toAddress['oua_address2'], $toAddress['oua_city'], $toAddress['oua_state'], $toAddress['oua_zip'], $toAddress['oua_country_code'])) {
                return false;
            }
        }

        $shipperContact = [];
        $sellerInfo = $this->getSellerInfo($systemOrderDetail['op_selprod_user_id']);
        if (!empty($sellerInfo)) {
            $shipperContact = array(
                'PersonName' => $sellerInfo['user_name'],
                'CompanyName' => $sellerInfo['shop_name'],
                'PhoneNumber1' => ValidateElement::formatDialCode($sellerInfo['user_phone_dcode']) . $sellerInfo['user_phone'],
                'CellPhone' => ValidateElement::formatDialCode($sellerInfo['user_phone_dcode']) . $sellerInfo['user_phone'],
                'EmailAddress' => $sellerInfo['credential_email']
            );
        }

        $consigneeContact = [];
        $buyerInfo = $this->getBuyerInfo($systemOrderDetail['order_user_id']);
        if (!empty($buyerInfo)) {
            $consigneeContact = array(
                'PersonName' => $buyerInfo['user_name'],
                'CompanyName' => $buyerInfo['user_name'],
                'PhoneNumber1' => ValidateElement::formatDialCode($buyerInfo['user_phone_dcode']) . $buyerInfo['user_phone'],
                'CellPhone' => ValidateElement::formatDialCode($buyerInfo['user_phone_dcode']) . $buyerInfo['user_phone'],
                'EmailAddress' => $buyerInfo['credential_email']
            );
        }

        $fromAddress = $this->getShopAddress($systemOrderDetail['opshipping_by_seller_user_id']);
        if (!empty($fromAddress)) {
            if (false === $this->setFromAddress('', $fromAddress['line1'], $fromAddress['line2'], $fromAddress['city'], $fromAddress['state'], $fromAddress['postalCode'], $fromAddress['countryCode'])) {
                return false;
            }
        }

        $this->setDimensions($systemOrderDetail['op_product_length'], $systemOrderDetail['op_product_width'], $systemOrderDetail['op_product_height'], $systemOrderDetail['op_product_dimension_unit']);

        $this->setWeight($systemOrderDetail['op_product_weight']);

        $this->setServiceRequest(self::REQUEST_SHIPPING);
        $clientInfo = $this->getClientInfo();

        $requestParam = array(
            'Shipments' => array(
                'Shipment' => array(
                    'Shipper' => array(
                        'AccountNumber' => $this->settings['AccountNumber'],
                        'PartyAddress' => $this->fromAddress,
                        'Contact' => $shipperContact,
                    ),
                    'Consignee' => array(
                        'Reference1' => $orderData['op_invoice_number'],
                        'PartyAddress' => $this->toAddress,
                        'Contact' => $consigneeContact,
                    ),
                    'Reference1' => $orderData['op_invoice_number'],
                    'TransportType' => 0,
                    'ShippingDateTime' => time(),
                    'DueDate' => time(),
                    'Comments' => $orderData['op_order_id'] . ' - ' . $orderData['op_invoice_number'],

                    'Details' => array(
                        'Dimensions' => $this->dimensions,
                        'ActualWeight' => array('Value' => $this->weight, 'Unit' => 'KG'),
                        'ProductGroup' => 'EXP',
                        'ProductType' => 'EPX',
                        'PaymentType' => 'P',
                        'NumberOfPieces' => $systemOrderDetail['op_qty'],
                        'Items' => [
                            [
                                'PackageType' => 'Box',
                                'Quantity' => $systemOrderDetail['op_qty'],
                                'Weight' => array('Value' => $this->weight, 'Unit' => 'KG'),
                                'Comments' => $orderData['op_order_id'] . ' - ' . $orderData['op_invoice_number'],
                                'Reference' => $orderData['op_invoice_number']
                            ]
                        ]
                    ),
                ),
            ),

            'ClientInfo' => $clientInfo,
            'Transaction' => [
                'Reference1' => $orderData['op_order_id'] . '-' . $orderData['op_invoice_number'],
            ],
            'LabelInfo' => array(
                'ReportID' => 9201,
                'ReportType' => 'URL',
            ),
        );

        if (false === $this->doRequest($requestParam)) {
            return false;
        }

        $shipment = $this->getResponse();
        if (0 < count($shipment)) {
            $processedShipment = $shipment['Shipments']['ProcessedShipment'];
            $shipment['orderNumber'] = $shipment['Transaction']['Reference1'];
            $shipment['tracking_url'] = "";
            $shipment['tracking_code'] = $processedShipment['ID'];
        }
        $this->resp = $shipment;
        return true;
    }

    /**
     * downloadLabel
     *
     * @param  array $labelData
     * @return void
     */
    public function downloadLabel(array $labelData)
    {
        if (!array_key_exists('Shipments', $labelData)) {
            return false;
        }
        FatApp::redirectUser($labelData['Shipments']['ProcessedShipment']['ShipmentLabel']['LabelURL']);
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
     * fetchTrackingDetail
     *
     * @param  string $trackingId
     * @param  string $orderInvoiceId
     * @return array
     */
    public function fetchTrackingDetail(string $trackingId, string $orderInvoiceId): array
    {
        $this->setServiceRequest(self::REQUEST_TRACKING);

        $requestParam = [
            'ClientInfo' => $this->getClientInfo(),
            'Transaction' => [
                'Reference1' => $orderInvoiceId
            ],
            'Shipments' => [$trackingId]
        ];

        if (false === $this->doRequest($requestParam)) {
            return [];
        }

        $trackingDetail = $this->getResponse();
        $data = [];

        if (!empty($trackingDetail)) {
            $data = [
                'detail' => [],
                'response' => $trackingDetail,
            ];

            if (isset($trackingDetail['TrackingResults']['KeyValueOfstringArrayOfTrackingResultmFAkxlpY']['Value']['TrackingResult'])) {
                $trackingResult = $trackingDetail['TrackingResults']['KeyValueOfstringArrayOfTrackingResultmFAkxlpY']['Value']['TrackingResult'];
                if (is_array($trackingResult) && array_key_exists(0, $trackingResult)) {
                    foreach ($trackingResult as $trkData) {
                        $data['detail'][] = [
                            'description' => $trkData['UpdateDescription'],
                            'dateTime' => $trkData['UpdateDateTime'],
                            'location' => $trkData['UpdateLocation'],
                            'comments' => $trkData['Comments'],
                            'status' => (strtolower($trkData['UpdateDescription']) == strtolower('Delivered') ? self::TRACKING_STATUS_DELIVERED : self::TRACKING_STATUS_PROCESSING),
                        ];
                    }
                } else {
                    $data['detail'][] = [
                        'description' => $trackingResult['UpdateDescription'],
                        'dateTime' => $trackingResult['UpdateDateTime'],
                        'location' => $trackingResult['UpdateLocation'],
                        'comments' => $trackingResult['Comments'],
                        'status' => (strtolower($trkData['UpdateDescription']) == strtolower('Delivered') ? self::TRACKING_STATUS_DELIVERED : self::TRACKING_STATUS_PROCESSING),
                    ];
                }
            }
        }

        return $data;
    }

    /**
     * canCreatePickup
     *
     * @return bool
     */
    public function canCreatePickup(): bool
    {
        return true;
    }

    /**
     * getPickupFormElementsArr
     *
     * @return array
     */
    public function getPickupFormElementsArr(): array
    {
        return [
            'PickupDate' => [
                'label' => Labels::getLabel('LBL_PICKUP_DATE', $this->langId),
                'required' => true,
                'fieldType' => Plugin::FLD_TYPE_TEXTBOX,
                'attributes' => [
                    'readonly' => 'readonly',
                    'class' => 'date--js'
                ]
            ],
            'ReadyTime' => [
                'label' => Labels::getLabel('LBL_READY_TIME', $this->langId),
                'required' => true,
                'fieldType' => Plugin::FLD_TYPE_TEXTBOX,
                'attributes' => [
                    'readonly' => 'readonly',
                    'class' => 'time--js'
                ]
            ],
            'LastPickupTime' => [
                'label' => Labels::getLabel('LBL_LAST_PICKUP_TIME', $this->langId),
                'required' => true,
                'fieldType' => Plugin::FLD_TYPE_TEXTBOX,
                'attributes' => [
                    'readonly' => 'readonly',
                    'class' => 'time--js'
                ]
            ],
            'ClosingTime' => [
                'label' => Labels::getLabel('LBL_CLOSING_TIME', $this->langId),
                'required' => true,
                'fieldType' => Plugin::FLD_TYPE_TEXTBOX,
                'attributes' => [
                    'readonly' => 'readonly',
                    'class' => 'time--js'
                ]
            ],
        ];
    }

    public function createPickup(array $orderData)
    {

        // if ($orderData['ReadyTime'] > $orderData['LastPickupTime'] || $orderData['ReadyTime'] > $orderData['ClosingTime'] || $orderData['ClosingTime'] < $orderData['LastPickupTime'] || time() > strtotime($orderData['PickupDate'])) {
        //     $this->error = Labels::getLabel('ERR_INVALID_TIME', $this->langId);
        //     return false;
        // }

        $systemOrderDetail = $this->getSystemOrder($orderData['op_id']);
        $fromAddress = $this->getShopAddress($systemOrderDetail['opshipping_by_seller_user_id']);
        if (!empty($fromAddress)) {
            if (false === $this->setFromAddress('', $fromAddress['line1'], $fromAddress['line2'], $fromAddress['city'], $fromAddress['state'], $fromAddress['postalCode'], $fromAddress['countryCode'])) {
                return false;
            }
        }

        $shipperContact = [];
        $sellerInfo = $this->getSellerInfo($systemOrderDetail['op_selprod_user_id']);
        if (!empty($sellerInfo)) {
            $shipperContact = array(
                'PersonName' => $sellerInfo['user_name'],
                'CompanyName' => $sellerInfo['shop_name'],
                'PhoneNumber1' => ValidateElement::formatDialCode($sellerInfo['user_phone_dcode']) . $sellerInfo['user_phone'],
                'CellPhone' => ValidateElement::formatDialCode($sellerInfo['user_phone_dcode']) . $sellerInfo['user_phone'],
                'EmailAddress' => $sellerInfo['credential_email']
            );
        }

        $consigneeContact = [];
        $buyerInfo = $this->getBuyerInfo($systemOrderDetail['order_user_id']);
        if (!empty($buyerInfo)) {
            $consigneeContact = array(
                'PersonName' => $buyerInfo['user_name'],
                'CompanyName' => $buyerInfo['user_name'],
                'PhoneNumber1' => ValidateElement::formatDialCode($buyerInfo['user_phone_dcode']) . $buyerInfo['user_phone'],
                'CellPhone' => ValidateElement::formatDialCode($buyerInfo['user_phone_dcode']) . $buyerInfo['user_phone'],
                'EmailAddress' => $buyerInfo['credential_email']
            );
        }

        $this->setDimensions($systemOrderDetail['op_product_length'], $systemOrderDetail['op_product_width'], $systemOrderDetail['op_product_height'], $systemOrderDetail['op_product_dimension_unit']);

        $this->setWeight($systemOrderDetail['op_product_weight']);

        $comments =  $orderData['op_order_id'] . ' - ' . $orderData['op_invoice_number'];
        $pickupDate = date('Y-m-d\TH:i:s', strtotime($orderData['PickupDate'] . ' ' . $orderData['ReadyTime']));
        $lastPickupTime = date('Y-m-d\TH:i:s', strtotime($orderData['PickupDate'] . ' ' . $orderData['LastPickupTime']));
        $closingTime = date('Y-m-d\TH:i:s', strtotime($orderData['PickupDate'] . ' ' . $orderData['ClosingTime']));

        $requestParam = array(
            'Pickup' => array(
                'PickupAddress' => $this->fromAddress,
                'PickupContact' => $shipperContact,
                'PickupLocation' => 'Reception',
                'PickupDate' => $pickupDate,
                'ReadyTime' => $pickupDate,
                'LastPickupTime' => $lastPickupTime,
                'ClosingTime' => $closingTime,
                'ShippingDateTime' => $pickupDate,
                'Comments' => $comments,
                'Reference1' => $orderData['op_invoice_number'],
                // 'Vehicle' => '',
                'Status' => 'Pending', //'Ready/Pending',
                'PickupItems' => array(
                    'PickupItemDetail' => array(
                        'ProductGroup' => 'EXP',
                        'ProductType' => 'EPX',
                        'Payment' => 'P',
                        'NumberOfShipments' => $systemOrderDetail['op_qty'],
                        // 'PackageType' => 'Box',
                        'NumberOfPieces' => $systemOrderDetail['op_qty'],
                        'Comments' => $comments,
                        'ShipmentWeight' => array('Value' => $this->weight, 'Unit' => 'KG'),
                        'ShipmentVolume' => array('Value' => $this->weight, 'Unit' => 'KG'),
                        'ShipmentDimensions' => $this->dimensions
                    )
                )
            ),
            'ClientInfo' => $this->getClientInfo(),
            'Transaction' => array(
                'Reference1' => $orderData['op_invoice_number']
            ),
            'LabelInfo' => array(
                'ReportID' => 9201,
                'ReportType' => 'URL',
            ),
        );

        $this->setServiceRequest(self::REQUEST_PICKUP);

        if (false === $this->doRequest($requestParam)) {
            return false;
        }
        $pickupResponse = $this->getResponse();
        if ($pickupResponse['HasErrors'] == 1) {
            $this->error = $pickup['Notifications']['Notification']['Message'] ?? Labels::getLabel('ERR_UNABLE_TO_CREATE_PICKUP', $this->langId);
            return false;
        }

        if (0 < count($pickupResponse)) {
            $pickupResponse['orderNumber'] = $pickupResponse['Transaction']['Reference1'];
            $pickupResponse['pickUpId'] = $pickupResponse['ProcessedPickup']['GUID'];
        }
        $this->resp = $pickupResponse;
        return true;
    }


    public function cancelPickup(array $orderData)
    {
        $requestParam = array(
            'ClientInfo' => $this->getClientInfo(),
            'Transaction' => array(
                'Reference1' => $orderData['op_invoice_number']
            ),
            'PickupGUID' => $orderData['opsp_api_req_id']
        );

        $this->setServiceRequest(self::REQUEST_PICKUP_CANCEL);

        if (false === $this->doRequest($requestParam)) {
            return false;
        }
        $cancelResponse = $this->getResponse();
        if ($cancelResponse['HasErrors'] == 1) {
            $this->error = $pickup['Notifications']['Notification']['Message'] ?? Labels::getLabel('ERR_UNABLE_TO_CANCEL_PICKUP', $this->langId);
            return false;
        }
        $this->resp = $cancelResponse;
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
     * doRequest
     *
     * @param  mixed $requestParam
     * @return bool
     */
    private function doRequest($requestParam = []): bool
    {
        $requestType = $this->serviceRequest;

        try {
            $soapClient  = $this->getSoapClient();
            switch ($requestType) {
                case self::REQUEST_RATE:
                    $resp = $soapClient->CalculateRate($requestParam);
                    break;
                case self::REQUEST_VALIDATE_ADDRESS:
                    $resp = $soapClient->ValidateAddress($requestParam);
                    break;
                case self::REQUEST_SHIPPING:
                    $resp = $soapClient->CreateShipments($requestParam);
                    break;
                case self::REQUEST_TRACKING:
                    $resp = $soapClient->TrackShipments($requestParam);
                    break;
                case self::REQUEST_PICKUP:
                    $resp = $soapClient->CreatePickup($requestParam);
                    break;
                case self::REQUEST_PICKUP_CANCEL:
                    $resp = $soapClient->CancelPickup($requestParam);
                    break;

                default:
                    CommonHelper::dieWithError(Labels::getLabel('LBL_INVALID_REQUEST_TYPE', $this->langId));
                    break;
            }

            $this->resp = json_decode(json_encode($resp), true);
            if ($this->resp['HasErrors']) {
                $notifications = [];
                if (isset($this->resp['Notifications'])) {
                    $notifications = $this->resp['Notifications'];
                }

                if (empty($notifications) && isset($this->resp['Shipments']['ProcessedShipment'])) {
                    $notifications = $this->resp['Shipments']['ProcessedShipment']['Notifications'];
                }

                if (array_key_exists(0, $notifications['Notification']) && is_array($notifications['Notification'][0])) {
                    foreach ($notifications['Notification'] as $errorDetail) {
                        $this->error .= $errorDetail['Message'] . '</br>';
                    }
                } else {
                    $this->error = $notifications['Notification']['Message'];
                }
                return false;
            }
            return true;
        } catch (Exception $e) {
            CommonHelper::printArray($e, true);
            $msg = $e->getMessage();
            if (!empty($e->param)) {
                $error = Labels::getLabel('MSG_INVALID_PARAM:_{PARAM}', $this->langId);
                $msg .= "\n" . CommonHelper::replaceStringData($error, ['{PARAM}' => $e->param]);
            }
            $this->error = $msg;
        } catch (Error $e) {
            $this->error = $e->getMessage();
        } catch (SoapFault $e) {
            $this->error = $e->faultstring;
        }
        return false;
    }

    public function canGenerateLabelFromShipment(): bool
    {
        return true;
    }
}
