<?php
/**
 * ShipRocket - https://apidocs.shiprocket.in
 */


use Curl\Curl;

class ShipRocket extends ShippingServicesBase
{
    public const KEY_NAME = __CLASS__;

    private const PRODUCTION_URL = 'https://apiv2.shiprocket.in/v1/external';

    private const REQUEST_AUTH_TOKEN = 1;
    private const REQUEST_GET_RATES = 2;

    private $resp;
    private $clientInfoCols = [];
    private $token = '';
    private $toAddress = [];
    private $fromAddress = [];
    private $dimensions = [];
    private $weight = 0;

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
        return $this->validateSettings($this->langId);
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
        return $this->resp;
    }
    
    /**
     * getAuthToken
     *
     * @return string
     */
    public function getAuthToken(): string
    {
        $requestParam = array_combine($this->requiredKeys, [
            $this->settings['email'],
            $this->settings['password'],
        ]);
        if (false === $this->doRequest(self::REQUEST_AUTH_TOKEN, $requestParam)) {
            return '';
        }
        
        return ($this->getResponse())['token'];
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
    public function setDimensions($length, $width, $height, $unit = 'inches')
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
            'cod' => 0,
            'weight' => $this->convertToKg($this->weight),
            'mode' => 'Surface',
            'is_return' => 0,
        ] + $this->dimensions;
        CommonHelper::printArray($requestParam, true);
        if (false === $this->doRequest(self::REQUEST_AUTH_TOKEN, $requestParam)) {
            return [];
        }
        
        $resp = $this->getResponse();
        CommonHelper::printArray($resp, true);
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
            $curl = new Curl();
            switch ($requestType) {
                case self::REQUEST_AUTH_TOKEN:
                    $curl->post(self::PRODUCTION_URL . '/auth/login', $requestParam);
                    break;
                /* case self::REQUEST_CARRIER_LIST:
                    \EasyPost\CarrierAccount::all(null, $this->settings['live_api_key']);
                    break;
                case self::REQUEST_CREATE_ADDRESS:
                    \EasyPost\Address::create_and_verify($requestParam, $this->apiKey);
                    break;
                case self::REQUEST_CREATE_SHIPPING:
                    \EasyPost\Shipment::create($requestParam, $this->apiKey);
                    break;
                case self::REQUEST_RETRIEVE_SHIPMENT:
                    \EasyPost\Shipment::retrieve(['id' => $requestParam], $this->apiKey);
                    break;
                case self::REQUEST_CREATE_ORDER:
                    \EasyPost\Order::create($requestParam, $this->apiKey);
                    break;
                case self::REQUEST_RETRIEVE_ORDER:
                    \EasyPost\Order::retrieve(['id' => $requestParam], $this->apiKey);
                    break;
                case self::REQUEST_REFUND_SHIPMENT:
                    \EasyPost\Refund::create($requestParam, $this->apiKey);
                    break; */
            }
            $curl->setHeader('Content-Type', 'application/json');
            if ($curl->error) {
                $this->error = $curl->errorCode . ': ' . $curl->response->message;
                return false;
            }

            $this->resp = (true === $formatResp) ? (array) $curl->response : $curl->response;
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
