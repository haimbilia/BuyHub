<?php

use Curl\Curl;

class Shopify extends DataMigrationBase
{
    public const KEY_NAME = __CLASS__;
    
    public $requiredKeys = ['shop_url','password'];
    
    private const API_VERSION = '2021-01';

    private $nextLink;
    private $prevLink;
    
    public $langId;
    
    public const MULTIVENDOR_API_URL = 'https://mvmapi.webkul.com';
    public const MULTIVENDOR_API_VERSION = 'v2';
    

    /**
     * init
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
    
    public function init()
    {        
        return $this->validateSettings();
    }

    public function getProducts()
    {
        $products = $this->fetchProducts(['limit' => 1]);
    }

    private function fetchProducts($params = [])
    {
        $url = $this->generateUrl(DataMigration::TYPE_PRODUCT, $params);
        $response = $this->sendGetRequest($url);
        return $response->products;
    }

    public function getUsers()
    { 
        $paginationSavedString = $this->getPaginationStringName(DataMigration::TYPE_USER);
        
        $paginationParam = $this->getData($paginationSavedString);
        if ($this->isSyncCompleted($paginationParam)) {
            return [];
        } 
        
        $paginationParam = $paginationParam === null ? ['limit' => 50] : $paginationParam;
        
        $users = $this->fetchCustomers($paginationParam);
        $mappedUsers = [];
        
        foreach ($users as $key => $user) {
            $mappedUser = array(
                'user_name' => $user->first_name . " " . $user->last_name,
                'user_phone' => $user->phone,
                'credential_email' => $user->email,
                'user_is_buyer' => User::USER_TYPE_BUYER,
                'user_preferred_dashboard' => User::USER_BUYER_DASHBOARD, 
                'user_registered_initially_for' => User::USER_TYPE_BUYER, 
                'user_verify' => 1,
                'user_active' => 1,
                'user_is_supplier' => 0,
                'user_is_advertiser' => 0,
                'credential_username' => '',
                'id'=> $user->id
            );
            $mappedAddress = [];

            foreach ($user->addresses as $address) {
                $mappedAddress[] = array(
                    'addr_title' => $address->name,
                    'addr_name' => $address->name,
                    'addr_address1' => $address->address1,
                    'addr_address2' => $address->address2,
                    'addr_city' => $address->city,
                    'addr_zip' => $address->zip,
                    'addr_phone' => $address->phone,
                    'addr_is_default' => $user->default_address->id == $address->id ? 1 : 0,
                    'country_code' => $address->country_code,
                    'country_name' => $address->country_name,
                    'state_code' => $address->province_code,
                    'state_name' => $address->province,
                );
            }
            $mappedUsers[] = $mappedUser + array('addresses' => $mappedAddress);
        }
        
        return $mappedUsers;
    }
    
    
    public function getSellers()
    { 
        $paginationSavedString = $this->getPaginationStringName(DataMigration::TYPE_SELLER);
        $paginationParam = $this->getData($paginationSavedString);
   
        if ($this->isSyncCompleted($paginationParam)) {
            return [];
        }        
        $paginationParam = $paginationParam === null ? ['page'=> 1,'limit' => 50] : $paginationParam;
        
        $users = $this->fetchSellers($paginationParam);
        
        print_r($sellers);

        $mappedSellers = [];
        
        foreach ($users as $key => $user) {
            $mappedUser = array(
                'user_name' => $user->full_name,
                'user_phone' => $user->phone,
                'credential_email' => $user->email,
                'user_is_buyer' => 1,
                'user_preferred_dashboard' => User::USER_SELLER_DASHBOARD, 
                'user_registered_initially_for' => User::USER_TYPE_SELLER, 
                'user_verify' => 1,
                'user_active' => 1,
                'user_is_supplier' => 1,
                'user_is_advertiser' => 1,
                'credential_username' => '',
                'id'=> $user->id                    
            );
            
            $shop = array(
                'shop_identifier' => $user->sp_store_name,
                'urlrewrite_custom' => $user->sp_store_name,
                'shop_phone' => $user->sp_store_name,
                'shop_country_code' => $user->sp_store_name,
                'shop_state' => $user->sp_store_name,
                'shop_postalcode' => $user->sp_store_name,
                'shop_active' => 1,
                'shop_cod_min_wallet_balance' => 1,
                'shop_fulfillment_type'=> 0,
                'shop_return_age' => 0,
                'shop_cancellation_age' => 0,
                'shop_logo'=> $user->shop_logo,
                'shop_seller_info'=> $user->description,
                ''
            );
            
            $mappedUsers[] = $mappedUser + array('shop' => $shop);
        }
        
        return $mappedUsers;
    }
    
    public function savePaginationData($type){
        
        $paginationSavedString = $this->getPaginationStringName($type);
        $this->saveData([$paginationSavedString => $this->getNextPageParams()]);
        
    }    
    
    public function isSyncCompleted($paginationParam)
    {
        if (is_array($paginationParam) && 1 > count($paginationParam)) {
            return true;
        }
        return false;
    }

    private function fetchSellers($params = [])
    {       
        $url = $this->generateUrl(DataMigration::TYPE_SELLER, $params);
        $response = $this->sendMultiVendorGetRequest($url);         
        $sellers = $response->sellers;
        $this->nextLink = '';
        if(0 < count($sellers)){
            $params['page']++;
            $this->nextLink = $this->generateUrl(DataMigration::TYPE_SELLER, $params);
        }
        
        return $sellers;
    }
    
    
    private function fetchCustomers($params = [])
    {
        $url = $this->generateUrl(DataMigration::TYPE_USER, $params);
        $response = $this->sendGetRequest($url);
        return $response->customers;
    }

    private function sendGetRequest($url)
    {
        $curl = new Curl();
        $curl->setHeader('X-Shopify-Access-Token', $this->settings['password']);
        $curl->get($url);
        if ($curl->error) {
            if (isset($curl->response->errors)) {
                $message = $this->castString($curl->response->errors);
                throw new Exception($message, $curl->errorCode);
            }
            throw new Exception($curl->errorMessage, $curl->errorCode);
        } else {
            $responseHeaders = $curl->getResponseHeaders();
            $this->getLinks($responseHeaders);
            return $curl->response;
        }
    }
    
    private function sendMultiVendorGetRequest($url)
    {
        $curl = new Curl();
        $curl->setHeader('Authorization', 'Bearer'. ' ' .$this->settings['multivendor_access_token']);
        $curl->get($url);
        if ($curl->error) {
            if (isset($curl->response->error)) {
                $message = $this->castString($curl->response->error_description);
                throw new Exception($message, $curl->errorCode);
            }
            throw new Exception($curl->errorMessage, $curl->errorCode);
        } else {
            $this->currentLink = $url;
            return $curl->response;
        }
    }

    private function castString($array)
    {
        if (!is_object($array)) {
            return (string) $array;
        }
        /*
          $string = '';
          $i = 0;
          foreach ($array as $key => $val) {
          //Add values separated by comma
          //prepend the key string, if it's an associative key
          //Check if the value itself is another array to be converted to string
          $string .= ($i === $key ? '' : "$key - ") . $this->castString($val) . ', ';
          $i++;
          }

          //Remove trailing comma and space
          $string = rtrim($string, ', ');

          return $string;
         *
         */
    }

    private function generateUrl($type, $urlParams = array())
    {
        switch ($type) {
            case DataMigration::TYPE_PRODUCT:
                $urlType = 'products';
                break;
            case DataMigration::TYPE_USER:
                $urlType = 'customers';
                break;
            case DataMigration::TYPE_SELLER:
                $urlType = 'sellers';
                break;            
        }

        if (in_array($type, [DataMigration::TYPE_SELLER])) {
            return self::MULTIVENDOR_API_URL . DIRECTORY_SEPARATOR . 'api/' . self::MULTIVENDOR_API_VERSION . DIRECTORY_SEPARATOR . $urlType . '.json' . (!empty($urlParams) ? '?' . http_build_query($urlParams) : '');
        }

        return $this->settings['shop_url'] . DIRECTORY_SEPARATOR . 'admin/api/' . self::API_VERSION . DIRECTORY_SEPARATOR . $urlType . '.json' . (!empty($urlParams) ? '?' . http_build_query($urlParams) : '');
    }

    private function getLinks($responseHeaders)
    {
        $this->nextLink = $this->getLink($responseHeaders, 'next');
        $this->prevLink = $this->getLink($responseHeaders, 'previous');
    }

    private function getLink($responseHeaders, $type = 'next')
    {
        if (!empty($responseHeaders['link'])) {
            if (stristr($responseHeaders['link'], '; rel="' . $type . '"') !== false) {
                $headerLinks = explode(',', $responseHeaders['link']);
                foreach ($headerLinks as $headerLink) {
                    if (stristr($headerLink, '; rel="' . $type . '"') === false) {
                        continue;
                    }
                    $pattern = '#<(.*?)>; rel="' . $type . '"#m';
                    preg_match($pattern, $headerLink, $linkResponseHeaders);
                    if ($linkResponseHeaders) {
                        return $linkResponseHeaders[1];
                    }
                }
            }
        }
        return null;
    }

    protected function getUrlParams($url)
    {
        if ($url) {
            $parts = parse_url($url);
            return $parts['query'];
        }
        return '';
    }

    private function getNextPageParams()
    {
        $nextPageParams = [];
        parse_str($this->getUrlParams($this->getNextLink()), $nextPageParams);
        return $nextPageParams;
    }

    private function getPrevPageParams()
    {
        $nextPageParams = [];
        parse_str($this->getUrlParams($this->getPrevLink()), $nextPageParams);
        return $nextPageParams;
    }

    private function getPrevLink()
    {
        return $this->prevLink;
    }

    private function getNextLink()
    {
        return $this->nextLink;
    }
    
    protected function getPaginationStringName($type)
    {
        $stringName = 'PaginationParam';        
        switch ($type) {
            case DataMigration::TYPE_PRODUCT:
                $stringName = 'product' . $stringName;
                break;
            case DataMigration::TYPE_USER:
                $stringName = 'user' . $stringName;
                break;
            case DataMigration::TYPE_SELLER:
                $stringName = 'seller' . $stringName;
                break;
        }
        
        return $stringName;
    }   
    
    
}
