<?php

use Curl\Curl;

class Shopify extends DataMigrationBase
{

    public const KEY_NAME = __CLASS__;
    private const API_VERSION = '2021-01';

    private $nextLink;
    private $prevLink;

    /**
     * init
     *
     * @return void
     */
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
        $paginationParam = $this->getData('userPaginationParam');
        
        
        
        
        $paginationParam = !empty($paginationParam) ? $paginationParam : ['limit' => 1];

        $users = $this->fetchCustomers($paginationParam);

        print_r($users);

        $mappedUsers = [];

        foreach ($users as $key => $user) {
            $mappedUser = array(
                'user_name' => $user->first_name . " " . $user->last_name,
                'user_phone' => $user->phone,
                'credential_email' => $user->email,
            );
            $mappedAddress = [];

            foreach ($user->addresses as $address) {
                $mappedAddress[] = array(
                    'addr_title' => $address->name,
                    'addr_name' => $address->name,
                    'addr_address1' => $address->address1,
                    'addr_address2' => $address->address2,
                    'addr_country_code' => $address->country_code,
                    'addr_state_code' => $address->province_code,
                    'addr_city' => $address->city,
                    'addr_zip' => $address->zip,
                    'addr_phone' => $address->phone,
                    'addr_is_default' => $user->default_address->id == $address->id ? 1 : 0,
                );
            }
            $mappedUsers[] = $mappedUser + array('addresses' => $mappedAddress);
        }

        $this->saveData(['userPaginationParam' => $this->getNextPageParams()]);
        return $mappedUsers;
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

    private function generateUrl($type, $urlParams = array())
    {
        switch ($type) {
            case DataMigration::TYPE_PRODUCT:
                $urlType = 'products';
                break;
            case DataMigration::TYPE_USER:
                $urlType = 'customers';
                break;
            default:
                $urlType = '';
            // need to handle error
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

    public function getPrevLink()
    {
        return $this->prevLink;
    }

    public function getNextLink()
    {
        return $this->nextLink;
    }

    public function saveData($dataArr)
    {
        $pluginID = $this->settings['plugin_id'];
        $dataArr = $dataArr + $this->getData();
        $data = json_encode($dataArr);
        $confName = 'DATA_MIGRATION_' . $pluginID;

        $dataToSave = array('conf_name' => $confName, 'conf_val' => $data);

        FatApp::getDb()->insertFromArray(
                Configurations::DB_TBL,
                $dataToSave,
                false,
                array(),
                $dataToSave
        );
    }

    public function getData($key = '')
    {
        $pluginID = $this->settings['plugin_id'];
        $confName = 'DATA_MIGRATION_' . $pluginID;
        $val = FatApp::getConfig($confName, FatUtility::VAR_STRING, '');
        $data = !empty($val) ? json_decode($val, true) : [];
        if (!empty($key)) {
            return isset($data[$key]) ? $data[$key] : '';
        }
        return $data;
    }

}
