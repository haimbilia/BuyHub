<?php

use Curl\Curl;

class Shopify extends DataMigrationBase
{
    public const KEY_NAME = __CLASS__;

    public $requiredKeys = ['shop_url', 'password'];

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
        $paginationParam = $paginationParam === null ? ['page' => 1, 'limit' => 40] : $paginationParam;
        $products = $this->fetchProducts($paginationParam);

        $collectionsCache = FatCache::get('ShopifyCollectionsCache', CONF_IMG_CACHE_TIME, '.txt');     
        if ($collectionsCache) {
            $collectionArr = json_decode($collectionsCache,true);
        } else {            
            $collectionArr = [];
            $collections = $this->fetchCollections();
            foreach ($collections as $collection) {
                $collectionArr[$collection->main_id_category] = $collection->category_name;
            }
            FatCache::set('ShopifyCollectionsCache', json_encode($collectionArr), '.txt');
        }

        $mappedProducts = [];

        foreach ($products as $product) {
        
            $catalog = [
                'id' => $product->shopify_product_id,
                'product_identifier' => $product->handle,
                'product_type' => $product->variants[0]->requires_shipping ?? 0,
                'brand_name' => '',
                'category_name' => $product->product_type ?? '',
                'product_min_selling_price' => 0,
                'product_approved' => 1,
                'product_active' => $product->active,
                'product_fulfillment_type' => '',
                'product_name' => $product->product_name ?? '',
                'product_description' => $product->product_description ?? '',     
                'product_category' => $product->product_type,
                'user_id' => $product->seller_id, /* shopify user id */
                'product_weight_unit' => 0,
                'product_weight' => 0, /* shopify has different weight for each variants */
                'product_youtube_video' =>''
            ];

            $tags = json_decode($product->product_tag,true);
            if(empty($tags)){
                $tags = []; 
            }
              
            foreach($product->collections as $collection){            
                $tags[]= (string)$collectionArr[$collection->shopify_category_id];
            }

            $mappedOptions = [];

            /* To get option except default one which is created by multivendor on every product, named Title  */
            if (!(count($product->variants) == 1 && 1 == count($product->options) && isset($product->options[0]->name) && $product->options[0]->name == 'Title')) {
                foreach ($product->options as $option) {
                    $values = [];
                    foreach ($option->values as $value) {
                        $values[] = $value->value;
                    }
                    $mappedOptions[$option->name] = array('option_name' => $option->name, 'option_is_color' => 0, 'option_is_separate_images' => 0, 'option_display_in_filter' => 1, 'values' => $values);
                }
            }
            $sellerProducts = [];
            $productImages = [];
            foreach ($product->images as $image) {
                $productImages[$image->id] = ['url' => $image->img_url, 'option' => '', 'optionValue' => ''];
            }


            foreach ($product->variants as $variant) {
                $inventory = [
                    'id' => $variant->shopify_variant_id,
                    'selprod_title' => $product->product_name ?? '',
                    'selprod_url_keyword'=> $product->handle ?? '',
                    'selprod_subtract_stock' => $variant->track_inventory,
                    'selprod_active' => $product->active,
                    'selprod_available_from' => date('Y-m-d'),
                    'selprod_condition' => Product::CONDITION_NEW,
                    'selprod_fulfillment_type' => 0,
                    'selprod_cost' => $variant->price,
                    'selprod_price' => $variant->price,
                    'selprod_stock' => $variant->quantity ?? 0,
                    'selprod_sku' => $variant->sku ?? '',
                    'selprod_min_order_qty'=> 1,
                    'selprod_comments'=>'',
                    'user_id' => $product->seller_id,  /* shopify user id */
                ];
                $combination = [];
                if (0 < count($mappedOptions)) {
                    foreach ($product->options as $key => $option) {
                        $optionValue = $variant->combinations[$key]->option_value;
                        $combination[$option->name] = $optionValue;

                        /* issue in mutivendor api some option values are not present in $product->options */
                        if (isset($mappedOptions[$option->name]['values'])) {
                            if (!in_array($optionValue, $mappedOptions[$option->name]['values'])) {
                                $mappedOptions[$option->name]['values'][] = $optionValue;
                            }
                        }
                    }
                }

                if (isset($productImages[$variant->image_id])) {
                    $optionName = '';
                    $optionValue = '';
                    if (count($combination) == 1) {
                        $optionName = array_key_first($combination);
                        $optionValue = current($combination);
                    } elseif (isset($combination['Color'])) {
                        $optionName = 'Color';
                        $optionValue = $combination['Color'];
                        $mappedOptions[$optionName]['option_is_color'] = 1;
                    } elseif (count($combination) > 1) {
                        foreach ($combination as $key => $val) {
                            if ($key !== 'Size') {
                                $optionName = $key;
                                $optionValue = $val;
                                break;
                            }
                        }
                    }
                    $mappedOptions[$optionName]['option_is_separate_images'] = 1;
                    $productImages[$variant->image_id]['option'] = $optionName;
                    $productImages[$variant->image_id]['optionValue'] = $optionValue;
                }
                $sellerProducts[] = $inventory + ['combination' => $combination];
            }
            $mappedProducts[] = ['catalog' => $catalog, 'options' => $mappedOptions, 'images' => $productImages, 'sellerProducts' => $sellerProducts, 'tags' => $tags];
        }

        return $mappedProducts;
    }

    private function fetchProducts($params = [])
    {
        $url = $this->generateUrl(DataMigration::TYPE_PRODUCT, $params);  
        $response = $this->sendMultiVendorGetRequest($url);        
        $products = $response->products;
        $this->nextLink = '';
        if (0 < count($products)) {
            $params['page']++;
            $this->nextLink = $this->generateUrl(DataMigration::TYPE_PRODUCT, $params);
        }

        return $products;        
    }
    
    public function getOrders()
    {
        $paginationSavedString = $this->getPaginationStringName(DataMigration::TYPE_ORDER);
        $paginationParam = $this->getData($paginationSavedString);

        if ($this->isSyncCompleted($paginationParam)) {
            return [];
        }
        $paginationParam = $paginationParam === null ? ['page' => 1, 'limit' => 2] : $paginationParam;
        $orders = $this->fetchOrders($paginationParam);
        $mappedOrders = [];

        foreach ($orders as $order) {            
            $mappedOrder = [
                'id' => $order->id,
                'created_at' => $order->created_at,
                'buyer_id' => $order->customer->id,
                'currency_code'=>$order->currency,
                'total_price' => $order->total_price,
                'subtotal_price' => $order->subtotal_price,
                'total_weight' => $order->total_weight,
                'total_tax' => $order->total_tax,
                'currency' => $order->currency, // total_price_usd  need to check
                'total_tax' => $order->total_tax,
                'payment_status' => in_array($order->financial_status, ['paid','partially_refunded','refunded'])  ? 1 : 0, /// need to update  or confirmed
                'total_discount' => $order->total_discounts,
                    //shiping charges needd to check
            ];

            $billingAddress = [];
            if (!empty($order->billing_address)) {
                $billingAddress = array(
                    "name" => $order->billing_address->name,                 
                    "address1" => $order->billing_address->address1,
                    "address2" => $order->billing_address->address2,
                    "phone" => $order->billing_address->phone,
                    "city" => $order->billing_address->city,
                    "zip" => $order->billing_address->zip,
                    "state" => $order->billing_address->province,
                    "country" => $order->billing_address->country,
                    "country_code" => $order->billing_address->country_code,
                    "state_code" => $order->billing_address->province_code,
                    "latitude" => $order->billing_address->latitude,
                    "longitude" => $order->billing_address->longitude,
                );
            }

            $shippingAddress = [];
            if (!empty($order->shipping_address)) {
                $shippingAddress = array(
                    "name" => $order->shipping_address->name,
                    "address1" => $order->shipping_address->address1,
                    "address2" => $order->shipping_address->address2 ?? '',
                    "phone" => $order->shipping_address->phone ?? '',
                    "city" => $order->shipping_address->city ?? '',
                    "zip" => $order->shipping_address->zip,
                    "state" => $order->shipping_address->province,
                    "country" => $order->shipping_address->country,
                    "country_code" => $order->shipping_address->country_code,
                    "state_code" => $order->shipping_address->province_code,
                    "latitude" => $order->shipping_address->latitude,
                    "longitude" => $order->shipping_address->longitude,
                );
            }

            /*
              $mappedtax = [];

              foreach($order->tax_lines  as $tax){
              $mappedtax[]= array(
              'title' =>$tax->title,
              'price'=> $tax->price,
              'rate'=> $tax->rate,
              );
              }
             * 
             */

            $products = [];
            foreach ($order->line_items as $lineItem) {
                $taxLines = [];
                foreach ($lineItem->tax_lines as $ptax) {
                    $taxLines[] = array(
                        'title' => $ptax->title,
                        'price' => $ptax->price,
                        'rate' =>  $ptax->rate,
                    );
                }
                $products[$lineItem->variant_id] = array(
                    'id' => $lineItem->variant_id,
                    'title' => $lineItem->title,
                    'quantity' => $lineItem->quantity,
                    'price' => $lineItem->price,
                    'total_discount' => $lineItem->total_discount,
                    'tax_lines' => $taxLines,
                );
            }
            
            $mappedRefund = [];            
            foreach ($order->refunds as $refund) {
                $refundLines = [];
                $refundAmount = 0;
                foreach ($refund->refund_line_items as $refundItem) {
                    $type = DataMigration::FULLY_REFUNDED;                    
                    if($products[$refundItem->line_item->variant_id]["quantity"] == $refundItem->line_item->quantity){
                        $type = DataMigration::FULLY_REFUNDED;
                    }elseif($order->financial_status == "partially_refunded"){
                        $type = DataMigration::PARTIALLY_REFUNDED;
                    }                    
                    $refundLines[] = array(
                        'id' => $refundItem->line_item->variant_id,
                        'title' => $refundItem->quantity,
                        'type' =>  $type,
                    );                                       
                }                
                foreach($refund->transactions as $refTrans){
                    $refundAmount +=$refTrans->amount;
                }                
                $mappedRefund[] = [
                  "amount" =>   $refundAmount,
                  "products" => $refundLines,  
                ];                
            }

            $mappedOrders[] = $mappedOrder + ["products" => $products, "billingAddress" => $billingAddress, "shippingAddress" => $shippingAddress ,'refund'=> $mappedRefund];
        }

        return $mappedOrders;
    }

    private function fetchOrders($params = [])
    {
        $url = $this->generateUrl(DataMigration::TYPE_ORDER, $params);
        $url = 'https://thelocalswpg.myshopify.com/admin/api/2021-01/orders.json?ids=3007848415276';
        $response = $this->sendGetRequest($url);
        return $response->orders;       
    }

    private function fetchCollections($params = [])
    {
        $url = $this->generateUrl(DataMigration::TYPE_PRODUCT_TAG, $params);
        $response = $this->sendMultiVendorGetRequest($url);
        return $response->collections;
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
                'id' => $user->id /* shopify customer id */
            );
            $mappedAddress = [];

            foreach ($user->addresses as $address) {
                $mappedAddress[] = array(
                    'addr_title' => $address->name,
                    'addr_name' => $address->name,
                    'addr_address1' => $address->address1 ?? '',
                    'addr_address2' => $address->address2 ?? '',
                    'addr_city' => $address->city ?? '',
                    'addr_zip' => $address->zip ?? '',
                    'addr_phone' => $address->phone ?? '',
                    'addr_is_default' => $user->default_address->id == $address->id ? 1 : 0,
                    'country_code' => $address->country_code ?? '',
                    'country_name' => $address->country_name ?? '',
                    'state_code' => $address->province_code ?? '',
                    'state_name' => $address->province ?? '',
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
        
        $paginationParam = $paginationParam === null ? ['page' => 1, 'limit' => 25 ,'sort_by'=>'date_add','sort_order'=>'asc'] : $paginationParam;
        
        $sellers = $this->fetchSellers($paginationParam);
        if(1 > count($sellers)){
            $this->nextLink = NULL;
        }
        
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
                'profile_photo' => $seller->store_logo,
                'id' => $seller->id, /* shopify multivendor customer id */
            );

            $shop = array(
                'shop_identifier' => $seller->sp_store_name,
                'shop_name' => $seller->sp_store_name,
                'urlrewrite_custom' => $seller->store_name_handle,
                'shop_contact_person' => $seller->contact ?? '',
                'shop_phone' => '',
                'shop_city' => $seller->city ?? '',
                'shop_country_code' => '',
                'shop_country_name' => '',
                'shop_state_code' => '',
                'shop_state_name' => '',
                'shop_postalcode' => $seller->zipcode ?? '',
                'shop_active' => 1,
                'shop_cod_min_wallet_balance' => 0,
                'shop_fulfillment_type' => Shipping::FULFILMENT_ALL,
                'shop_return_age' => 0,
                'shop_cancellation_age' => 0,
                'shop_seller_info' => $seller->description ?? '',
                'shop_description' => $seller->short_desc ?? '',
                'shop_payment_policy' => $seller->policy ?? '',
                'shop_banner' => $seller->store_banner,
                'shop_logo' => $seller->shop_logo,
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
        $curl->setHeader('Authorization', 'Bearer' . ' ' . $this->settings['multivendor_access_token']);
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
            case DataMigration::TYPE_PRODUCT_TAG:
                $urlType = 'collections';
                break;
            case DataMigration::TYPE_ORDER:
                $urlType = 'orders';
                break;
        }

        if (in_array($type, [DataMigration::TYPE_SELLER, DataMigration::TYPE_PRODUCT, DataMigration::TYPE_PRODUCT_TAG])) {
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
