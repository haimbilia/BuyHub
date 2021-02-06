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
        $paginationSavedString = $this->getPaginationStringName(DataMigration::TYPE_PRODUCT);
        $paginationParam = $this->getData($paginationSavedString);
   
        if ($this->isSyncCompleted($paginationParam)) {
            return [];
        }
        $paginationParam = $paginationParam === null ? ['page'=> 1,'limit' => 4] : $paginationParam;
        $products = $this->fetchProducts($paginationParam);
        
        $mappedProducts = [];
        
        
        foreach($products as $product){
            $catalog = [
                'product_identifier'=>'',
                'product_type'=> $product->requires_shipping ,
                'brand_name'=>'',
                'category_name'=>$product->product_type ?? '',              
                'product_min_selling_price'=> 0,
                'product_approved'=> 1,
                'product_active'=>$product->active,           
                'product_fulfillment_type'=>'',
                'product_name'=> $product->product_name ?? '',
                'product_description'=>$product->product_description ?? '',
                'product_tags_string'=>'',
                'product_category'=>$product->product_type,
                'product_user_id'=>$product->seller_id,
                'product_weight_unit' => 0,
                'product_weight' => 0 /* shopify has different weight for each variants */                
            ];
            
        }
        
        
        print_r($products);
        
        die();
    }

    private function fetchProducts($params = [])
    {
        $url = $this->generateUrl(DataMigration::TYPE_PRODUCT, $params);
        $response = $this->sendMultiVendorGetRequest($url);
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
                'user_preferred_dashboard' => User::USER_BUYER_DASHBOARD,
                'user_registered_initially_for' => User::USER_TYPE_BUYER,
                'user_verify' => 1,
                'user_active' => 1,
                'user_is_buyer' => 1,
                'user_is_supplier' => 0,
                'user_is_advertiser' => 0,
                'credential_username' => '',
                'id'=> $user->id   /*shopify customer id */
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
        $paginationParam = $paginationParam === null ? ['page'=> 1,'limit' => 25] : $paginationParam;
        
        $sellers = $this->fetchSellers($paginationParam);
        
        $mappedSellers = [];
        
        foreach ($sellers as $key => $seller) {
            $mappedSeller = array(
                'user_name' => $seller->full_name,
                'user_phone' => '',
                'credential_email' => $seller->email,
                'user_preferred_dashboard' => User::USER_SELLER_DASHBOARD,
                'user_registered_initially_for' => User::USER_TYPE_SELLER,
                'user_verify' => 1,
                'user_active' => 1,
                'user_is_buyer' => 1,
                'user_is_supplier' => 1,
                'user_is_advertiser' => 1,
                'credential_username' => '',
                'profile_photo'=> $seller->store_logo,
                'id'=> $seller->id,  /*shopify multivendor customer id */
            );
            
            $shop = array(
                'shop_identifier' => $seller->sp_store_name,
                'shop_name' => $seller->sp_store_name,
                'urlrewrite_custom' => $seller->store_name_handle,
                'shop_contact_person' => $seller->contact ?? '' ,
                'shop_phone' => '',
                'shop_city' => $seller->city ?? '',
                'shop_country_code' => '',
                'shop_country_name' => '',
                'shop_state_code' => '',
                'shop_state_name' => '',
                'shop_postalcode' => $seller->zipcode ?? '',
                'shop_active' => 1,
                'shop_cod_min_wallet_balance' => 0,
                'shop_fulfillment_type'=> Shipping::FULFILMENT_ALL,
                'shop_return_age' => 0,
                'shop_cancellation_age' => 0,
                'shop_seller_info'=> $seller->description ?? '',
                'shop_description'=> $seller->short_desc ?? '',
                'shop_payment_policy'=> $seller->policy ?? '',
                'shop_banner'=> $seller->store_banner,
                'shop_logo'=> $seller->shop_logo,
            );
            
            if (!empty($seller->id_country)) {
                $shop['shop_country_code'] = $seller->id_country->iso_code;
                $shop['shop_country_name'] = $seller->id_country->name;
            }
            
            if (!empty($seller->id_state)) {
                $shop['shop_state_code'] = $seller->id_state->iso_code;
                $shop['shop_state_name'] = $seller->id_state->name;
            }
            
            $mappedSellers[] = $mappedSeller + array('shop' => $shop);
        }
        
        return $mappedSellers;
    }
    
    public function savePaginationData($type)
    {
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
        if (0 < count($sellers)) {
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

        if (in_array($type, [DataMigration::TYPE_SELLER ,DataMigration::TYPE_PRODUCT])) {
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
