<?php

require_once CONF_INSTALLATION_PATH . 'vendor/autoload.php';

/**
 * Parameter reference 
 * https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters
 * 
 * 
 * https://developers.google.com/analytics/devguides/collection/protocol/v1/devguide
 * https://www.optimizesmart.com/implementing-enhanced-ecommerce-tracking-universal-analytics/#a8
 * 
 */
class EcommerceTracking
{

    private $impressions = [];
    private $trackingId;
    private $userId;
    private $event = [];
    private $pageTitle;
    private $transactionDetails;
    private $productAction;
    private $productActionList;
    private $products = [];

    const PROD_ACTION_TYPE_CLICK = 1;
    const PROD_ACTION_TYPE_DETAIL = 2;
    const PROD_ACTION_TYPE_ADD_TO_CART = 3;
    const PROD_ACTION_TYPE_REMOVE_FROM_CART = 4;
    const PROD_ACTION_TYPE_CHECKOUT = 5;
    const PROD_ACTION_TYPE_PURCHASE = 6;
    const PROD_ACTION_TYPE_REFUND = 7;

    const DEBUG = true;

    public function __construct($pageTitle = NULL, $userId = NULL)
    {
        if (1 == FatApp::getConfig('CONF_GOOGLE_ANALYTICS_4', FatUtility::VAR_INT, 0)) {
            $analyticsId = FatApp::getConfig("CONF_PROPERTY_ID");
        } else {
            $analyticsId = FatApp::getConfig("CONF_ANALYTICS_ID");
        }

        $this->trackingId = $analyticsId;
        $this->userId = $userId ?? $this->uuidV4();
        $this->pageTitle = $pageTitle;
    }

    public function addImpression($listName)
    {
        $this->impressions[]['title'] = $listName;
    }

    public function addImpressionProduct($productId, $productName, $category, $brand, $position)
    {
        $impressionKey = count($this->impressions) - 1;
        $this->impressions[$impressionKey]['products'][] = [
            'productId' => $productId,
            'productName' => $productName,
            'category' => $category,
            'brand' => $brand,
            'position' => $position,
            //'variant' => $variant,
        ];
    }

    public function addTransaction($id = NULL, $amount = NULL, $shipping = NULL, $tax = NULL, $currencyCode = NULL)
    {
        $this->transactionDetails = [
            'id' => $id,
            'amount' => $amount,
            'shipping' => $shipping,
            'tax' => $tax,
            'currencyCode' => $currencyCode,
        ];
    }

    public function addEvent($action, $category)
    {
        $this->event = [
            'action' => $action,
            'category' => $category,
        ];
    }

    public function addProductAction($action)
    {
        $this->productAction = $action;
    }

    public function addProductActionList($name)
    {
        $this->productActionList = $name;
    }

    public function addProduct($productId, $productName = NULL, $category = NULL, $brand = NULL, $quantity = NULL, $price = NULL)
    {
        $this->products[] = [
            'productId' => $productId,
            'productName' => $productName,
            'category' => $category,
            'brand' => $brand,
            // 'variant' => $variant,
            'quantity' => $quantity,
            'price' => $price
        ];
    }

    public function sendRequest()
    {
        if (empty($this->trackingId)) {
            return;
        }

        $gaParams = $this->buildParams();

        $url = 'https://www.google-analytics.com/collect';
        if (true == self::DEBUG) {
            $url = 'https://www.google-analytics.com/debug/collect';
            CommonHelper::logData("GOOGLE ECOMMERCE TRACKING PARAMS==>" . $gaParams);
        }
        $curl = new Curl\Curl();
        $curl->setUserAgent($_SERVER['HTTP_USER_AGENT']);
        $curl->setHeader('Content-type', 'application/x-www-form-urlencoded');
        $curl->setOpt(CURLOPT_RETURNTRANSFER, true);
        $curl->post($url, $gaParams);
        if (true == self::DEBUG) {
            if ($curl->error) {
                echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
            } else {
                // CommonHelper::printArray(json_decode($curl->response,true));
                CommonHelper::logData("GOOGLE ECOMMERCE TRACKING RESPONSE==>" . $curl->response);
            }
        }
    }

    private function buildParams()
    {
        $gaParams = [
            'v' => '1', # API Version.
            'tid' => $this->trackingId, # Tracking ID / Property ID.
            # Anonymous Client Identifier. Ideally, this should be a UUID that
            # is associated with particular user, device, or browser instance.
            'cid' => $this->userId,
        ];

        foreach ($this->impressions as $key => $impression) {
            $key++;
            $impressionKey = "il" . $key;
            $gaParams += ['il' . $key . 'nm' => $impression['title']];

            foreach ($impression['products'] as $prodKey => $product) {
                $prodKey++;
                $prodImpressionKey = $impressionKey . "pi" . $prodKey;

                $gaParams += [
                    $prodImpressionKey . 'id' => $product['productId'], // Product Impression ID. 
                    $prodImpressionKey . 'nm' => $product['productName'], // Product Impression name.
                    $prodImpressionKey . 'ca' => $product['category'], // Product Impression category.
                    $prodImpressionKey . 'br' => $product['brand'], // Product Impression brand.
                    //$prodImpressionKey . 'va' => $product['variant'], // Product Impression variant.
                    $prodImpressionKey . 'ps' => $product['position'], // Product Impression position.
                ];
            }
        }

        if (0 < count($this->event)) {
            $gaParams += [
                't' => 'event',
                'ec' => $this->event['category'], // Event Category. Required.
                'ea' => $this->event['action'], // Event Action. Required.
                /* 'el' => $this->event['label'], // Event label. */
            ];
        } else {
            $gaParams += [
                't' => 'pageview',
                'dh' => $_SERVER['HTTP_HOST'], // Document hostname
                'dp' => urldecode($_SERVER['REQUEST_URI']), // Page.
                'dt' => $this->pageTitle,
            ];
        }


        if (!empty($this->productAction)) {
            $pa = '';
            switch ($this->productAction) {
                case self::PROD_ACTION_TYPE_CLICK:
                    $pa = "click";
                    break;
                case self::PROD_ACTION_TYPE_DETAIL:
                    $pa = "detail";
                    break;
                case self::PROD_ACTION_TYPE_ADD_TO_CART:
                    $pa = "add";
                    break;
                case self::PROD_ACTION_TYPE_REMOVE_FROM_CART:
                    $pa = "remove";
                    break;
                case self::PROD_ACTION_TYPE_CHECKOUT:
                    $pa = "checkout";
                    break;
                case self::PROD_ACTION_TYPE_PURCHASE:
                    $pa = "purchase";
                    break;
                case self::PROD_ACTION_TYPE_REFUND:
                    $pa = "refund";
                    break;
            }
            $gaParams['pa'] = $pa;
        }

        if (!empty($this->productActionList)) {
            $gaParams['pal'] = $this->productActionList;
        }

        foreach ($this->products as $prodKey => $product) {
            $prodKey++;
            $gaKey = "pr" . $prodKey;
            $gaParams += [
                $gaKey . 'id' => $product['productId'], // Product ID. 
                $gaKey . 'nm' => $product['productName'], // Product name.
                $gaKey . 'ca' => $product['category'], // Product category.
                $gaKey . 'br' => $product['brand'], // Product  brand.
                // $gaKey . 'va' => $product['variant'], // Product variant.
                $gaKey . 'qt' => $product['quantity'], // Product quantity.
                $gaKey . 'pr' => $product['price'],
            ];
        }

        if (!empty($this->transactionDetails)) {
            $gaParams += [
                'ti' => $this->transactionDetails['id'],
                'tr' => $this->transactionDetails['amount'], // Revenue.
                'ts' => $this->transactionDetails['shipping'], // Shipping.
                'tt' => $this->transactionDetails['tax'], // Tax.
                'cu' => $this->transactionDetails['currencyCode'], // Tax.
            ];
        }

        return http_build_query($gaParams);
    }

    private function uuidV4()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
            // 48 bits for "node"
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
    }
}
