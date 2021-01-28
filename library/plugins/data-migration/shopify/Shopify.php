<?php

use Curl\Curl;

class Shopify extends DataMigrationBase
{

    public const KEY_NAME = __CLASS__;
    private const API_VERSION = '2021-01';
    private const TYPE_PRODUCT = 1;

    /**
     * init
     *
     * @return void
     */
    public function init()
    {
        if (false == $this->validateSettings()) {
            return false;
        }
        return true;
    }

    private function fetchProducts($params = [])
    {
        $url = $this->generateUrl(self::TYPE_PRODUCT, $params);

        $curl = new Curl();
        $curl->setHeader('X-Shopify-Access-Token', $this->settings['password']);        

        $curl->get($url);

        if ($curl->error) {
            echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
        } else {
            
            $a = $curl->getResponseHeaders();
            print_r($a['Status-Line']);
            die();
            
            echo 'Response:' . "\n";
            //print_r($curl->response);
        }
    }

    public function getProducts()
    {

        $products = $this->fetchProducts(['limit' =>1]);
    }

    private function generateUrl($type, $urlParams = array())
    {
        switch ($type) {
            case self::TYPE_PRODUCT:
                $urlType = 'products';
                break;
            default:
                $urlType = '';
            // need to handle error
        }

        return $this->settings['shop_url'] . DIRECTORY_SEPARATOR . 'admin/api/' . self::API_VERSION . DIRECTORY_SEPARATOR . $urlType . '.json' . (!empty($urlParams) ? '?' . http_build_query($urlParams) : '');
    }
    
    
    public function getLinks($responseHeaders){
        $this->nextLink = $this->getLink($responseHeaders,'next');
        $this->prevLink = $this->getLink($responseHeaders,'previous');
    }
    
    public function getLink($responseHeaders, $type='next'){       

        if(!empty($responseHeaders['link'])) {
            if (stristr($responseHeaders['link'], '; rel="'.$type.'"') > -1) {
                $headerLinks = explode(',', $responseHeaders['link']);
                foreach ($headerLinks as $headerLink) {
                    if (stristr($headerLink, '; rel="'.$type.'"') === -1) {
                        continue;
                    }

                    $pattern = '#<(.*?)>; rel="'.$type.'"#m';
                    preg_match($pattern, $headerLink, $linkResponseHeaders);
                    if ($linkResponseHeaders) {
                        return $linkResponseHeaders[1];
                    }
                }
            }
        }

        return null;
    }

}
