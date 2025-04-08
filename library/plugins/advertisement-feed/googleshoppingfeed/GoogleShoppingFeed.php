<?php
/* 
* Google Shopping Content Class library where you can find used classes and their methods.
* https://developers.google.com/resources/api-libraries/documentation/content/v2.1/php/latest/class-Google_Service_ShoppingContent_Product.html 
*/
class GoogleShoppingFeed extends AdvertisementFeedBase
{
    public const KEY_NAME = __CLASS__;
    public const PAGE_SIZE = 10;

    private $merchantId;

    public $requiredKeys = [
        'client_id',
        'client_secret',
        'developer_key',
    ];

    /**
     * __construct
     *
     * @param  int $langId
     * @param  int $userId
     * @return void
     */
    public function __construct(int $langId, int $userId = 0)
    {
        $this->langId = $langId;
        $this->userId = $userId;
        $this->merchantId = $this->getUserMeta(self::KEY_NAME . '_merchantId');
    }

    /**
     * ageGroup
     *
     * @param  mixed $langId
     * @return array
     */
    public static function ageGroup(int $langId): array
    {
        return [
            'newborn' => Labels::getLabel('LBL_UP_TO_3_MONTHS_OLD', $langId) . ' - ' . Labels::getLabel('LBL_NEWBORN', $langId),
            'infant' => Labels::getLabel('LBL_BETWEEN_3-12_MONTHS_OLD', $langId) . ' - ' . Labels::getLabel('LBL_INFANT', $langId),
            'toddler' => Labels::getLabel('LBL_BETWEEN_1-5_YEARS_OLD', $langId) . ' - ' . Labels::getLabel('LBL_TODDLER', $langId),
            'kids' => Labels::getLabel('LBL_BETWEEN_5-13_YEARS_OLD', $langId) . ' - ' . Labels::getLabel('LBL_KIDS', $langId),
            'adult' => Labels::getLabel('LBL_TYPICALLY_TEENS_OR_OLDER', $langId) . ' - ' . Labels::getLabel('LBL_ADULT', $langId),
        ];
    }

    /**
     * doRequest
     *
     * @param  array $data
     * @return void
     */
    private function doRequest(array $data, bool $isXml = false)
    {
        if ((false === $this->merchantId || 1 > $this->merchantId) && false == $isXml) {
            $this->error = Labels::getLabel('ERR_INVALID_MERCHANT', $this->langId);
            return false;
        }

        if (empty($data) || !array_key_exists('data', $data)) {
            $this->error = Labels::getLabel('ERR_PLEASE_PASS_REQUIRED_PRODUCT_DATA', $this->langId);
            return false;
        }

        if (!array_key_exists('currency_code', $data)) {
            $this->error = Labels::getLabel('ERR_INVALID_CURRENCY', $this->langId);
            return false;
        }

        if ($isXml) {
            $xmlFileName = str_replace(' ', '_', strtolower($data['batchTitle'])) . '.xml';
            $xml = new DOMDocument();
            $xml->xmlVersion = '1.0';
            $rss = $xml->createElement("rss");
            $rssNode = $xml->appendChild($rss);
            $rssNode->setAttribute("version", "2.0");
            $rssNode->setAttribute("xmlns:g", "http://base.google.com/ns/1.0");

            $channelNode = $xml->createElement("channel");
            $rss->appendChild($channelNode);

            $childTitleNode = $xml->createElement('title');
            $childTitleNode->appendChild($xml->createTextNode($data['batchTitle']));
            $channelNode->appendChild($childTitleNode);

            $shopId = Shop::getAttributesByUserId(UserAuthentication::getLoggedUserId(), 'shop_id');
            $childTitleNode = $xml->createElement('link');
            $childTitleNode->appendChild($xml->createTextNode(UrlHelper::generateFullUrl('Shops', 'View', array($shopId))));
            $channelNode->appendChild($childTitleNode);

            $childTitleNode = $xml->createElement('description', );
            $childTitleNode->appendChild($xml->createTextNode($data['batchTitle']));
            $channelNode->appendChild($childTitleNode);
        } else {
            $serviceAccountDetail = $this->getUserMeta('service_account');
            if (empty($serviceAccountDetail)) {
                $this->error = Labels::getLabel('ERR_SERVICE_ACCOUNT_DETAIL_NOT_FOUND', $this->langId);
                return false;
            }

            $serviceAccountDetail = json_decode($serviceAccountDetail, true);

            $client = new Google_Client();
            $client->setAuthConfig($serviceAccountDetail);
            $client->setScopes(Google_Service_ShoppingContent::CONTENT);
            $client->useApplicationDefaultCredentials();
            $client->setUseBatch(true);

            $service = new Google_Service_ShoppingContent($client);
            $batch = $service->createBatch();
        }

        /* $channel = $this->getSettings('channel');
        if (false === $channel) {
            return false;
        } */

        $request = [];
        foreach ($data['data'] as $prodDetail) {
            if ($isXml) {
                $childItemNode = $this->formatAsXml($xml, $prodDetail);
                $channelNode->appendChild($childItemNode);
            } else {
                $product = $this->formatAsGoogleFeed($data, $prodDetail);
                $request = $service->products->insert($this->merchantId, $product);
                $batch->add($request, $product->getOfferId());
            }
        }

        if ($isXml) {
            $rss->appendChild($channelNode);
            $filePath = CONF_UPLOADS_PATH . $data['batchId'] . $xmlFileName;
            return $xml->save($filePath);
        } else {
            if (empty($request)) {
                $this->error = Labels::getLabel('ERR_INVALID_PRODUCT_REQUEST', $this->langId);
                return false;
            }
            return $batch->execute();
        }
    }

    private function formatAsXml(DOMDocument $xml, array $prodDetail)
    {
        $colorOption = array_filter($prodDetail['optionsData'], function ($v) {
            return array_key_exists('option_is_color', $v) && 1 == $v['option_is_color'];
        });
        $color = !empty($colorOption) ? array_shift($colorOption)['optionvalue_identifier'] : '';

        $childItemNode = $xml->createElement('item');

        $subChildItemNode = $xml->createElement('g:id', $prodDetail['selprod_id']);
        $childItemNode->appendChild($subChildItemNode);

        $subChildItemNode = $xml->createElement('title', $prodDetail['selprod_title']);
        $childItemNode->appendChild($subChildItemNode);

        $subChildItemNode = $xml->createElement('link');
        $subChildItemNode->appendChild($xml->createTextNode(UrlHelper::generateFullUrl('Products', 'View', array($prodDetail['selprod_id']), CONF_WEBROOT_FRONTEND)));
        $childItemNode->appendChild($subChildItemNode);

        $subChildItemNode = $xml->createElement('description', preg_replace("/\s|&nbsp;/", ' ', strip_tags($prodDetail['product_description'])));
        $childItemNode->appendChild($subChildItemNode);

        $subChildItemNode = $xml->createElement('g:image_link', UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'product', array($prodDetail['product_id'], ImageDimension::VIEW_DESKTOP, $prodDetail['selprod_id'], 0, $this->langId))));
        $childItemNode->appendChild($subChildItemNode);

        $subChildItemNode = $xml->createElement('g:price', CommonHelper::displayMoneyFormat($prodDetail['selprod_price']));
        $childItemNode->appendChild($subChildItemNode);

        $subChildItemNode = $xml->createElement('g:availability', strtolower($prodDetail['selprod_stock']));

        $subChildItemNode = $xml->createElement('g:availability_date', date('Y-m-d', strtotime($prodDetail['selprod_available_from'])));
        $childItemNode->appendChild($subChildItemNode);

        $subChildItemNode = $xml->createElement('g:gtin', $prodDetail['product_upc']);
        $childItemNode->appendChild($subChildItemNode);

        $subChildItemNode = $xml->createElement('g:brand', ucfirst($prodDetail['brand_name']));
        $childItemNode->appendChild($subChildItemNode);

        $subChildItemNode = $xml->createElement('g:update_type', 'merge');
        $childItemNode->appendChild($subChildItemNode);

        $subChildItemNode = $xml->createElement('g:condition', strtolower($prodDetail['selprod_condition']));
        $childItemNode->appendChild($subChildItemNode);

        $subChildItemNode = $xml->createElement('g:age_group', $prodDetail['abprod_age_group']);
        $childItemNode->appendChild($subChildItemNode);

        if (!empty($color)) {
            $subChildItemNode = $xml->createElement('g:color', $color);
            $childItemNode->appendChild($subChildItemNode);
        }

        if (0 < $prodDetail['special_price_found']) {
            $subChildItemNode = $xml->createElement('g:sale_price', CommonHelper::displayMoneyFormat($prodDetail['theprice']));
            $childItemNode->appendChild($subChildItemNode);
        }
        return $childItemNode;
    }

    private function formatAsGoogleFeed(array $data, array $prodDetail): Google_Service_ShoppingContent_Product
    {
        $colorOption = array_filter($prodDetail['optionsData'], function ($v) {
            return array_key_exists('option_is_color', $v) && 1 == $v['option_is_color'];
        });
        $color = !empty($colorOption) ? array_shift($colorOption)['optionvalue_identifier'] : '';

        $product = new Google_Service_ShoppingContent_Product();
        $product->setId($prodDetail['selprod_id']);
        $product->setOfferId($prodDetail['selprod_id']);
        $product->setTitle($prodDetail['selprod_title']);
        $product->setDescription($prodDetail['product_description']);
        $product->setColor($color);
        $product->setItemGroupId($prodDetail['abprod_item_group_identifier']);
        $product->setBrand(ucfirst($prodDetail['brand_name']));
        $product->setLink(UrlHelper::generateFullUrl('Products', 'View', array($prodDetail['selprod_id']), CONF_WEBROOT_FRONTEND));
        $product->setImageLink(UrlHelper::getCachedUrl(UrlHelper::generateFullFileUrl('image', 'product', array($prodDetail['product_id'], ImageDimension::VIEW_DESKTOP, $prodDetail['selprod_id'], 0, $this->langId), CONF_WEBROOT_FRONTEND), CONF_IMG_CACHE_TIME, '.jpg'));
        $product->setContentLanguage(strtolower($prodDetail['language_code']));
        $product->setTargetCountry(strtoupper($prodDetail['country_code']));
        $product->setChannel('online');
        $product->setAvailability($prodDetail['selprod_stock']);
        $product->setAvailabilityDate(date('Y-m-d', strtotime($prodDetail['selprod_available_from'])));
        if (array_key_exists('expire_on', $data)) {
            $product->setExpirationDate($data['expire_on']);
        }
        $product->setCondition(strtolower($prodDetail['selprod_condition']));
        $product->setGoogleProductCategory($prodDetail['abprod_cat_id']);
        $product->setGtin($prodDetail['product_upc']);

        $price = new Google_Service_ShoppingContent_Price();
        $price->setValue($prodDetail['selprod_price']);

        $currencyCode = array_key_exists('currency_code', $data) ? $data['currency_code'] : '';
        if ('' != $currencyCode) {
            $price->setCurrency($data['currency_code']);
        }
        $product->setPrice($price);

        if (0 < $prodDetail['special_price_found']) {
            $price = new Google_Service_ShoppingContent_Price();
            $price->setValue($prodDetail['theprice']);
            if ('' != $currencyCode) {
                $price->setCurrency($data['currency_code']);
            }
            $product->setSalePrice($price);
        }
        return $product;
    }

    /**
     * getProductCategory
     *
     * @param  string $keyword
     * @param  bool $returnFullArray
     * @return array
     */
    public function getProductCategory(string $keyword = '', bool $returnFullArray = false): array
    {
        $arr = [];
        if ($fh = fopen(__DIR__ . '/googleProductCategory.txt', 'r')) {
            $rowIndex = 1;
            while (!feof($fh)) {
                $line = fgets($fh);
                if ($returnFullArray || false !== stripos($line, $keyword)) {
                    $lineContentArr = explode('-', $line, 2);
                    if (!empty($lineContentArr) && 1 < count($lineContentArr)) {
                        $arr[trim($lineContentArr[0])] = trim($lineContentArr[1]);
                    }
                    $rowIndex++;
                }

                if (false === $returnFullArray && $rowIndex == self::PAGE_SIZE) {
                    break;
                }
            }
            fclose($fh);
        }
        ksort($arr);
        return $arr;
    }

    /**
     * getProductCategoryAutocomplete
     *
     * @param  string $keyword
     * @return array
     */
    public function getProductCategoryAutocomplete(string $keyword = ''): array
    {
        $arr = [];
        if ($fh = fopen(__DIR__ . '/googleProductCategory.txt', 'r')) {
            $rowIndex = 1;
            while (!feof($fh)) {
                $line = fgets($fh);
                if ('' == $keyword || false !== stripos($line, $keyword)) {
                    $lineContentArr = explode('-', $line, 2);
                    if (!empty($lineContentArr) && 1 < count($lineContentArr)) {
                        $arr['results'][] = [
                            'id' => trim($lineContentArr[0]),
                            'text' => trim($lineContentArr[1])
                        ];
                    }
                    $rowIndex++;
                }

                if ($rowIndex == self::PAGE_SIZE) {
                    break;
                }
            }
            fclose($fh);
        }
        return $arr;
    }

    /**
     * publishBatch
     *
     * @param  mixed $data
     * @return array
     */
    public function publishBatch(array $data, bool $isXml = false): array
    {
        $status = empty($data) ? Plugin::RETURN_FALSE : Plugin::RETURN_TRUE;
        $msg = Labels::getLabel('MSG_PUBLISHED_SUCESSFULLY', $this->langId);
        if ($isXml) {
            $msg = Labels::getLabel('MSG_GENERATED_SUCESSFULLY', $this->langId);
        }
        $data = ($status == Plugin::RETURN_TRUE ? $this->doRequest($data, $isXml) : '');
        if (false === $data) {
            $status = Plugin::RETURN_FALSE;
        }

        if (is_array($data) && !empty($data) && method_exists((current($data)), 'getErrors')) {
            $errors = (current($data))->getErrors();
            $this->error = '';
            foreach ($errors as $error) {
                $this->error .= $error['message'] . '. ';
            }
            $status = Plugin::RETURN_FALSE;
        }

        $errorMsg = '' == $this->getError() ? Labels::getLabel('MSG_INVALID_REQUEST', $this->langId) : $this->getError();
        $msg = ($status == Plugin::RETURN_FALSE ? $errorMsg : $msg);
        return [
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
        ];
    }


    public function getMaxPublishDays()
    {
        return 30;
    }
}
