<?php

require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';
/**
 * Parameter reference 
 * https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters
 */
class EcommerceTracking
{

    private $impressions = [];
    private $trackingId;
    private $userId;
    private $event = [];

    

    public function __construct($trackingId, $userId ,$pageTitle)
    {
        $this->trackingId = $trackingId;
        $this->userId = $userId;
    }
    
    
    
    public function addImpression($listName)
    {        
        $this->impression[$this->impressionCount] = $listName;       
    }

    public function addImpressionProducts($productId, $productName, $category, $brand, $variant, $position)
    {
        $impressionCount = count($this->impression);
        $this->impressions[$impressionCount]['products'][] = [       
            'productId' => $productId,
            'productName' => $productName,
            'category' => $category,
            'brand' => $brand,
            'variant' => $variant,
            'position' => $position,
        ];
    }
    
    
    public function addEvent($action,$category, $label)
    {       
        $this->event = [       
            'action' => $action,
            'category' => $category,
            'label' => $label, 
        ];
    }
    
    
    public function sendRequest(){
        
    $gaParams = [
            'v' => '1', # API Version.
            'tid' => $this->trackingId, # Tracking ID / Property ID.
            # Anonymous Client Identifier. Ideally, this should be a UUID that
            # is associated with particular user, device, or browser instance.
            'cid' => $this->userId,
            'dh'  => $_SERVER['HTTP_HOST'],
            'dp'  => $_SERVER['REQUEST_URI'],
                
        ];

        foreach ($this->impressions as $key => $impression) {
            $impressionKey = "il" . $key;
            $gaParams += ['il' . $key . 'nm' => $impression];
            
            foreach ($impression['products'] as $prodKey => $product) {
                $prodKey++;                
                $prodImpressionKey = $impressionKey . "pi" . $prodKey;

                $gaParams += [
                    $prodImpressionKey . 'id' => $product['productId'], // Product Impression ID. 
                    $prodImpressionKey . 'nm' => $product['productName'], // Product Impression name.
                    $prodImpressionKey . 'ca' => $product['category'], // Product Impression category.
                    $prodImpressionKey . 'br' => $product['brand'], // Product Impression brand.
                    $prodImpressionKey . 'va' => $product['variant'], // Product Impression variant.
                    $prodImpressionKey . 'ps' => $product['position'], // Product Impression position.
                ];
            }
        }
        
        if (0 < count($this->event)) {
            $gaParams +=  [
                't'=>'event',
                'ec'=>$this->event['category'],     // Event Category. Required.
                'ea'=>$this->event['action'],       // Event Action. Required.
                'el'=>$this->event['label'],        // Event label.
            ];
        } else {
            
             $gaParams +=  [
                't'=>'pageview',
                'dh'=>$this->event['category'],     // Document hostname
                'dp'=>$this->event['action'],       // Page.
                'dt'=>$this->event['label'],    
            ];
            
        }

        $url = 'http://www.google-analytics.com/collect';
        $curl = new Curl\Curl();
        $curl->setOpt(CURLOPT_RETURNTRANSFER, true);
        $curl->post($url,$gaParams);

        if ($curl->error) {
            $this->error = $curl->errorCode . ' : ' . $curl->errorMessage;
            $this->error .= !empty($curl->getResponse()->error) ? $curl->getResponse()->error : '';
            return false;
        }
        
    }

}
