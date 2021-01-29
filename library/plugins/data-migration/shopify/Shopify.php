<?php

use Curl\Curl;

class Shopify extends DataMigrationBase
{

    public const KEY_NAME = __CLASS__;
    private const API_VERSION = '2021-01';
    private const TYPE_PRODUCT = 1;

    private $nextLink;
    private $prevLink;

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
        $response = $this->sendGetRequest($url);
        return $response->products;
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

    protected function castString($array)
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

    public function getProducts()
    {
        $products = $this->fetchProducts(['limit' => 1]);
        
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

    public function getLinks($responseHeaders)
    {
        $this->nextLink = $this->getLink($responseHeaders, 'next');
        $this->prevLink = $this->getLink($responseHeaders, 'previous');
    }

    public function getLink($responseHeaders, $type = 'next')
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

    public function getUrlParams($url)
    {
        if ($url) {
            $parts = parse_url($url);
            return $parts['query'];
        }
        return '';
    }

    public function getNextPageParams()
    {
        $nextPageParams = [];
        parse_str($this->getUrlParams($this->getNextLink()), $nextPageParams);
        return $nextPageParams;
    }

    public function getPrevPageParams()
    {
        $nextPageParams = [];
        parse_str($this->getUrlParams($this->getPrevLink()), $nextPageParams);
        return $nextPageParams;
    }

}
