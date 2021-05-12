<?php

/**
 * Aramex - https://www.aramex.com/us/en/solutions-services/developers-solutions-center/apis
 */
class Aramex extends ShippingServicesBase
{
    public const KEY_NAME = __CLASS__;

    private const REQUEST_RATE = 1;
    private const REQUEST_SHIPPING = 2;
    private const REQUEST_TRACKING = 3;
    private const REQUEST_LOCATION = 4;
    private const REQUEST_VALIDATE_LOCATION = 5;

    private $resp;
    private $soapClient;
    private $ratesReference = '';
    private $orderQty = 1;
    private $weight;
    private $dimensions;
    private $toAddress = [];
    private $fromAddress = [];
    private $addressReference;

    private $clientInfoCols = [];

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
        $this->clientInfoCols = $this->requiredKeys;
        $this->requiredKeys();
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
     * requiredKeys
     *
     * @return void
     */
    public function requiredKeys()
    {
        $this->env = FatUtility::int($this->getKey('env'));
        if (0 < $this->env) {
            $this->requiredKeys = preg_filter('/^/', 'live_', $this->requiredKeys);
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

        return true;
    }

    /**
     * getClientInfo
     *
     * @return array
     */
    private function getClientInfo(): array
    {
        $clientInfoArr = [];
        $prefix = (Plugin::ENV_PRODUCTION == $this->settings['env']) ? 'live_' : '';
        foreach ($this->clientInfoCols as $col) {
            $clientInfoArr[$col] = $this->settings[$prefix . $col];
        }
        $clientInfoArr['Version'] = 'v1.0';
        return $clientInfoArr;
    }

    /**
     * getSoapClient
     *
     * @param  int service
     * @return void
     */
    private function getSoapClient(int $service)
    {
        $dir = (Plugin::ENV_SANDBOX == $this->settings['env']) ? 'test' : 'live';
        libxml_disable_entity_loader(false);

        switch ($service) {
            case self::REQUEST_SHIPPING:
                return new SoapClient(dirname(__FILE__) . '/wsdls/' . $dir . '/shipping.wsdl', ['trace' => true, 'cache_wsdl' => WSDL_CACHE_MEMORY]);
                break;

            case self::REQUEST_TRACKING:
                return new SoapClient(dirname(__FILE__) . '/wsdls/' . $dir . '/tracking.wsdl', ['trace' => true, 'cache_wsdl' => WSDL_CACHE_MEMORY]);
                break;

            case self::REQUEST_RATE:
                return new SoapClient(dirname(__FILE__) . '/wsdls/' . $dir . '/rate.wsdl', ['trace' => true, 'cache_wsdl' => WSDL_CACHE_MEMORY]);
                break;

            case self::REQUEST_LOCATION:
            case self::REQUEST_VALIDATE_LOCATION:
                return new SoapClient(dirname(__FILE__) . '/wsdls/' . $dir . '/location.wsdl', ['trace' => true, 'cache_wsdl' => WSDL_CACHE_MEMORY]);
                break;
            default:
                trigger_error(Labels::getLabel('LBL_INVALID_SERVICE_REQUEST', $this->langId), E_USER_ERROR);
                break;
        }
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
        
        /* Comment below code if getting error(ClientInfo - Invalid username or password) while validating .. */
        $requestParam = [
            'ClientInfo' => $this->getClientInfo(),
            'Transaction' => [
                'Reference1' => $this->addressReference
            ],
            'Address' => $address
        ];

        if (false === $this->doRequest(self::REQUEST_VALIDATE_LOCATION, $requestParam)) {
            return false;
        }
        /* **************************** */

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
            echo $this->error;die;
            return false;
        }
        $this->fromAddress = $this->getResponse();
        return true;
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
        $defaultCurrencyId = CommonHelper::getCurrencyId();
        $allCurrencies = Currency::getCurrencyAssoc($this->langId);

        $convertCurrency = $val['CurrencyCode'];
        $fromCurrency = array_search(strtolower($convertCurrency), array_map('strtolower', $allCurrencies));
        if (false === $fromCurrency) {
            return $val;
        }
        return CommonHelper::convertExistingToOtherCurrency($fromCurrency, $val['Value'], $defaultCurrencyId);
    }

    /**
     * getRates
     *
     * @return array
     */
    public function getRates(): array
    {
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
                'ProductType' => 'PPX',
                'ActualWeight' => array('Value' => $this->weight, 'Unit' => 'KG'),
                'ChargeableWeight' => array('Value' => $this->weight, 'Unit' => 'KG'),
                'NumberOfPieces' => $this->orderQty
            ]
        ];
        
        if (false === $this->doRequest(self::REQUEST_RATE, $requestParam)) {
            // echo $this->error;die;
            return [];
        }

        $rates = $this->getResponse();
        return [
            [
                'serviceName' => self::KEY_NAME,
                'serviceCode' => self::KEY_NAME,
                'shipmentId' => $rates['Transaction']['Reference1'],
                'shipmentCost' => $this->convertToSiteCurrency($rates['TotalAmount']),
                'otherCost' => '0',
            ]
        ];
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
     * @param  int $requestType
     * @param  mixed $requestParam
     * @return bool
     */
    private function doRequest(int $requestType, $requestParam = []): bool
    {
        try {
            $soapClient  = $this->getSoapClient($requestType);
            switch ($requestType) {
                case self::REQUEST_RATE:
                    $resp = $soapClient->CalculateRate($requestParam);
                    break;
                case self::REQUEST_VALIDATE_LOCATION:
                    $resp = $soapClient->ValidateAddress($requestParam);
                    break;
            }

            $this->resp = json_decode(json_encode($resp), true);
            if ($this->resp['HasErrors']) {
                if (array_key_exists(0, $this->resp['Notifications']['Notification']) && is_array($this->resp['Notifications']['Notification'][0])) {
                    foreach ($this->resp['Notifications']['Notification'] as $errorDetail) {
                        $this->error .= (self::KEY_NAME . ': ' . $errorDetail['Code'] . ' - ' . $errorDetail['Message']) . '</br>';
                    }
                } else {
                    $this->error = (self::KEY_NAME . ': ' . $this->resp['Notifications']['Notification']['Code'] . ' - ' . $this->resp['Notifications']['Notification']['Message']);
                }
                return false;
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
        } catch (SoapFault $fault) {
            $this->error = $fault->faultstring;
        }
        return false;
    }
}
