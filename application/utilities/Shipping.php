<?php

class Shipping
{
    public const BY_ADMIN = 1;
    public const BY_SHOP = 2;

    public const LEVEL_ORDER = 1;
    public const LEVEL_SHOP = 2;
    public const LEVEL_PRODUCT = 3;

    public const TYPE_MANUAL = -1;
    public const RATE_CACHE_KEY_NAME = "shipRateCache_";
    public const CARRIER_CACHE_KEY_NAME = "shipCarrierCache_";

    private $langId;   
    private $successMsg = '';
    private $shippedByArr = [];
    private $selProdShipRates = [];
    private $selectedShippingService = [];
    private $systemRatesToFetchSelprodIds = [];
    private $shippingServicesArr = [];

    public const FULFILMENT_ALL = -1;
    public const FULFILMENT_PICKUP = 1;
    public const FULFILMENT_SHIP = 2;

    /**
     * __construct
     *
     * @param  int $langId
     * @return void
     */
    public function __construct(int $langId)
    {
        $this->langId = $langId;
    }

    /**
     * getShippedByArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getShippedByArr(int $langId): array
    {
        return [
            self::BY_ADMIN => Labels::getLabel('LBL_ADMIN_SHIPPING', $langId),
            self::BY_SHOP => Labels::getLabel('LBL_SHOP_SHIPPING', $langId)
        ];
    }

    /**
     * getFulFillmentArr
     *
     * @param  int $langId
     * @param  int $fulFillmentType
     * @return array
     */
    public static function getFulFillmentArr(int $langId, int $fulFillmentType = -1): array
    {
        switch ($fulFillmentType) {
            case self::FULFILMENT_SHIP:
                return [
                    self::FULFILMENT_SHIP => Labels::getLabel('LBL_SHIPPED_ONLY', $langId)
                ];
                break;
            case self::FULFILMENT_PICKUP:
                return [
                    self::FULFILMENT_PICKUP => Labels::getLabel('LBL_PICKUP_ONLY', $langId)
                ];
                break;
            default:
                return [
                    self::FULFILMENT_ALL => Labels::getLabel('LBL_SHIPPED_AND_PICKUP', $langId),
                    self::FULFILMENT_PICKUP => Labels::getLabel('LBL_PICKUP_ONLY', $langId),
                    self::FULFILMENT_SHIP => Labels::getLabel('LBL_SHIPPED_ONLY', $langId)
                ];
                break;
        }
    }

    /**
     * getLevels
     *
     * @param  int $langId
     * @return array
     */
    public static function getLevels(int $langId): array
    {
        return [
            self::LEVEL_ORDER => Labels::getLabel('LBL_ADMIN_LEVEL_SHIPPING', $langId),
            self::LEVEL_SHOP => Labels::getLabel('LBL_SHOP_LEVEL_SHIPPING', $langId),
            self::LEVEL_PRODUCT => Labels::getLabel('LBL_PRODUCT_LEVEL_SHIPPING', $langId),
        ];
    }

    /**
     * getShippingMethods
     *
     * @param  int $langId
     * @return array
     */
    public static function getShippingMethods(int $langId): array
    {
        $thirdPartyApis = Plugin::getDataByType(Plugin::TYPE_SHIPPING_SERVICES, 1, true);
        if (!empty($thirdPartyApis)) {
            return $thirdPartyApis;
        }

        return [
            self::TYPE_MANUAL => Labels::getLabel('LBL_SYSTEM_LEVEL_SHIPPING', $langId)
        ];
    }

    /**
     * formatOutput
     *
     * @param  int $status
     * @param  array $data - Output Data
     * @return array
     */
    private function formatOutput(int $status, array $data = []): array
    {
        $status = (null != $status ? $status : applicationConstants::FAILURE);
        if (empty($this->error) && applicationConstants::FAILURE == $status) {
            $this->error = Labels::getLabel('MSG_FAILURE', $this->langId);
        }

        if (empty($this->successMsg) && applicationConstants::SUCCESS == $status) {
            $this->successMsg = Labels::getLabel('MSG_SUCCESS', $this->langId);
        }

        $msg = (applicationConstants::FAILURE == $status ? $this->error : $this->successMsg);

        return  [
            'status' => $status,
            'msg' => $msg,
            'data' => $data
        ];
    }

    /**
     * getSellerProductShippingProfileIds
     *
     * @param  array $selProdIdArr
     * @return array
     */
    public function getSellerProductShippingProfileIds(array $selProdIdArr): array
    {
        $selProdIdArr = FatUtility::int($selProdIdArr);

        $selProdShipProfileArr = [];
        if (empty($selProdIdArr)) {
            return $selProdShipProfileArr;
        }

        $srch = new ProductSearch($this->langId);
        $srch->setDefinedCriteria(0, 0, array(), false);
        $srch->joinProductShippedBySeller();
        $srch->joinShippingProfileProducts();
        $srch->addCondition('selprod_id', 'IN', $selProdIdArr);
        $srch->addMultipleFields(array('selprod_id', 'shippro_shipprofile_id'));
        $srch->addGroupBy('selprod_id');
        $prodSrchRs = $srch->getResultSet();
        return FatApp::getDb()->fetchAllAssoc($prodSrchRs);
    }

    /**
     * getSellerProductShippingRates
     *
     * @param  array $selProdIdArr
     * @param  int $countryId
     * @param  int $stateId
     * @return array
     */

    public function getSellerProductShippingRates(array $selProdIdArr, int $countryId, int $stateId): array
    {
        if (empty($selProdIdArr)) {
            return [];
        }

        $countryId = FatUtility::int($countryId);
        $stateId = FatUtility::int($stateId);

        $shippedByAdminOnly = FatApp::getConfig('CONF_SHIPPED_BY_ADMIN_ONLY', FatUtility::VAR_INT, 0);

        $srch = new ProductSearch();
        $srch->setDefinedCriteria(0, 0, array(), false);
        $srch->joinProductShippedBy();
        $srch->joinShippingProfileProducts();
        $srch->joinShippingProfile($this->langId);
        $srch->joinShippingProfileZones();
        $srch->joinShippingZones();
        $srch->joinShippingRates($this->langId);
        $srch->joinShippingLocations($countryId, $stateId, 0);
        $srch->addCondition('selprod_id', 'IN', $selProdIdArr);
        $srch->addMultipleFields(array('selprod_id', 'selprod_user_id', 'shippro_shipprofile_id', 'shipprozone_id', 'shiprate_id', 'coalesce(shipr_l.shiprate_name, shipr.shiprate_identifier) as shiprate_name', 'shiprate_cost', 'shiprate_condition_type', 'shiprate_min_val', 'shiprate_max_val', 'psbs.psbs_user_id', 'product_id', 'shiploc_shipzone_id', 'shipprofile_default', 'shop_id', 'coalesce(spprof_l.shipprofile_name, spprof.shipprofile_identifier) as shipprofile_name', 'shop_postalcode', 'shiploc_country_id'));
        if (0 < $shippedByAdminOnly) {
            $srch->addFld('0 as shiippingBySeller');
        } else {
            $srch->addFld('if(psbs_user_id > 0 or product_seller_id > 0, 1, 0) as shiippingBySeller');
        }
        $srch->addCondition('shiprate_id', '!=', 'null');
        $srch->addGroupBy('selprod_id');
        $srch->addGroupBy('shiprate_id');
        $srch->addOrder('shiprate_cost');
        //$srch->addOrder('shiprate_condition_type', 'desc');       
        $prodSrchRs = $srch->getResultSet();
        //$res = FatApp::getDb()->fetchAll($prodSrchRs);
        /*ToDo : Updated logic and fetch from query and also handle for states*/
        $res = [];
        $temp = [];
        while ($row = FatApp::getDb()->fetch($prodSrchRs)) {
            if ($row['shiploc_country_id'] > 0) {
                $temp[] = $row['selprod_id'];
            }

            if (0 < $row['shiippingBySeller']) {
                $fields = array('shop_postalcode as postalCode', 'shop_address_line_1 as line1', 'shop_address_line_2 as line2', 'shop_city as city', 'state_name as state', 'state_code as stateCode', 'country_code as countryCode', 'shop_phone as phone', 'shop_name', 'shop_id');
                $row['shopAddress'] = Shop::getShopAddress($row['shop_id'], true, $this->langId, $fields);
            } else {
                $adminAddress = Admin::getAddress($this->langId);
                $adminAddress['phone'] = FatApp::getConfig('CONF_SITE_PHONE', FatUtility::VAR_INT, 0);
                $adminAddress['shop_name'] = FatApp::getConfig('CONF_SITE_OWNER_' . $this->langId, FatUtility::VAR_STRING, '');
                $adminAddress['shop_id'] = 0;
                $row['shopAddress'] = $adminAddress;
            }

            $res[] = $row;
        }

        foreach ($res as $key => $val) {
            if (in_array($val['selprod_id'], $temp) && $val['shiploc_country_id'] == -1) {
                unset($res[$key]);
            }
        }
        return $res = array_merge($res, []);
    }

    /**
     * fetchShippingRatesFromApi
     *
     * @param  array $shippingAddressDetail
     * @param  array $productInfo
     * @param  array $physicalSelProdIdArr
     * @return bool
     */
    private function fetchShippingRatesFromApi(array $shippingAddressDetail, array $productInfo, array &$physicalSelProdIdArr): bool
    {
               
        $weightUnitsArr = applicationConstants::getWeightUnitsArr($this->langId, true);
        $dimensionUnits = ShippingPackage::getUnitTypes($this->langId);

        foreach ($this->selProdShipRates as $rateId => $rates) {
            
            $product = $productInfo[$rates['selprod_id']];
            
            $useManualShipping = FatApp::getConfig('CONF_MANUAL_SHIPPING_RATES_ADMIN', FatUtility::VAR_INT, 0);
            if (0 < $rates['shiippingBySeller']) {
                $useManualShipping = ShopSpecifics::getAttributesById($product['shop_id'], 'shop_use_manual_shipping_rates');
            }

            if (0 < $useManualShipping) {
                $this->systemRatesToFetchSelprodIds[] = $rates['selprod_id'];
                continue;
            }
            
            $shippingApiObj = $this->getShippingApiObj(0 < $rates['shiippingBySeller'] ? $rates['selprod_user_id'] : 0 );
            if(false === $shippingApiObj){
                /* if api not enabled or any error in loading them fetch manual rates*/
                $this->systemRatesToFetchSelprodIds[] = $rates['selprod_id'];
                continue;
            }
            
            $cacheKey = self::CARRIER_CACHE_KEY_NAME . $this->langId . get_class($shippingApiObj) . ($rates['shiippingBySeller'] ? $rates['selprod_user_id'] : 0);
            $carriers = FatCache::get($cacheKey, CONF_API_REQ_CACHE_TIME, '.txt');
            if ($carriers) {
                $carriers = unserialize($carriers);
            } else {
                $limit = ('ShipStationShipping' == get_class($shippingApiObj)::KEY_NAME ? 0 : 1);
                $carriers = $shippingApiObj->getCarriers($limit);
                if (!empty($carriers)) {
                    FatCache::set($cacheKey, serialize($carriers), '.txt');
                }
            }
           
            if (empty($carriers)) {
                continue;
            } 
            $shippingApiObj->setAddress($shippingAddressDetail['addr_name'], $shippingAddressDetail['addr_address1'], $shippingAddressDetail['addr_address2'], $shippingAddressDetail['addr_city'], $shippingAddressDetail['state_name'], $shippingAddressDetail['addr_zip'], $shippingAddressDetail['country_code'], $shippingAddressDetail['addr_phone']);
            
            if (empty($product['shippack_length']) || empty($product['shippack_width']) || empty($product['shippack_height']) || empty($product['shippack_units'])) {
                $msg = Labels::getLabel('MSG_MISSING_LENGTH_/_WIDTH_/_HEIGHT_OR_UNIT_PARAMS_FOR_"{PRODUCT}"._PLEASE_BIND_CORRECT_PACKAGE.', $this->langId);
                $msg = CommonHelper::replaceStringData($msg, ['{PRODUCT}' => $product['selprod_title']]);
                SystemLog::set($msg);
                continue;
            }

            $shopAddress = $rates['shopAddress'];
            
            if (method_exists($shippingApiObj, 'setAddressReference')) {
                $referenceId = str_pad($shopAddress['shop_id'], 6, "0", STR_PAD_LEFT);
                $shippingApiObj->setAddressReference($referenceId);
            }
            
            if (method_exists($shippingApiObj, 'setFromAddress')) {
                $shippingApiObj->setFromAddress($shopAddress['shop_name'], $shopAddress['line1'], $shopAddress['line2'], $shopAddress['city'], $shopAddress['state'], $shopAddress['postalCode'], $shopAddress['countryCode'], $shopAddress['phone']);
            }

            if (method_exists($shippingApiObj, 'setReference')) {
                $shippingApiObj->setReference('selProd-' . $rates['selprod_id'] . $product['quantity']);
            }

            if (method_exists($shippingApiObj, 'setQuantity')) {
                $shippingApiObj->setQuantity($product['quantity']);
            }

            /* Retrieve Selected Shipping Service Detail. */
            if (method_exists($shippingApiObj, 'setSelectedShipping') && is_array($this->selectedShippingService) && 0 < count($this->selectedShippingService)) {
                $shippingApiObj->setSelectedShipping($this->selectedShippingService[$rates['selprod_id']]);
            }
            /* Retrieve Selected Shipping Service Detail. */

            $shippingLevel = self::LEVEL_PRODUCT;

            $shippedBy = -1; /* admin shipping */
            $fromZipCode = FatApp::getConfig('CONF_ZIP_CODE', FatUtility::VAR_STRING, '');
            if (0 < $rates['shiippingBySeller']) {
                $shippedBy = $product['shop_id'];
                $fromZipCode = $rates['shop_postalcode'];
            }

            
            $prodWeight = $product['product_weight'] * $product['quantity'];
            $productWeightClass = isset($weightUnitsArr[$product['product_weight_unit']]) ? $weightUnitsArr[$product['product_weight_unit']] : '';
            $productWeightInOunce = static::convertWeightInOunce($prodWeight, $productWeightClass);

            $shippingApiObj->setWeight($productWeightInOunce);

            if (method_exists($shippingApiObj, 'setDimensions')) {
                $shippingApiObj->setDimensions($product['shippack_length'], $product['shippack_width'], $product['shippack_height'], $dimensionUnits[$product['shippack_units']]);
            }

            $cacheKeyArr = [
                $productWeightInOunce,
                $product['shippack_length'],
                $product['shippack_width'],
                $product['shippack_height'],
                $dimensionUnits[$product['shippack_units']],
                $shopAddress,
                $shippingAddressDetail                
            ];
            
            foreach ($carriers as $carrier) {
                $carrierCode = !empty($carrier) && array_key_exists('code', $carrier) ? $carrier['code'] : '';
                $cacheKeyArr = array_merge($cacheKeyArr, [$carrierCode, $fromZipCode, $this->langId]);
                $cacheKey = self::RATE_CACHE_KEY_NAME . md5(json_encode($cacheKeyArr));
                $shippingRates = FatCache::get($cacheKey, CONF_API_REQ_CACHE_TIME, '.txt');
                if ($shippingRates) {
                    $shippingRates = unserialize($shippingRates);
                } else {
                    $shippingRates = $shippingApiObj->getRates($carrierCode, $fromZipCode);
                    if (!empty($shippingRates)) {
                        FatCache::set($cacheKey, serialize($shippingRates), '.txt');
                    }
                }
                              
                if ((false == $shippingRates || empty($shippingRates))) {
                    SystemLog::set($shippingApiObj->getError());     
                    continue;
                }
                unset($physicalSelProdIdArr[$rates['selprod_id']]);
                foreach ($shippingRates as $key => $value) {
                    $shippingCost = [
                        'id' => $value['serviceCode'],
                        'code' => $rates['selprod_id'],
                        'title' => $value['serviceName'],
                        'cost' => $value['shipmentCost'] + $value['otherCost'],
                        'shiprate_condition_type' => 0,
                        'shiprate_min_val' => 0,
                        'shiprate_max_val' => 0,
                        'shipping_level' => $shippingLevel,
                        'shipping_type' => $shippingApiObj->getKey('plugin_id'),
                        'is_seller_plugin' => $shippingApiObj->getRecordId(),
                        'carrier_code' => $carrierCode,
                    ];

                    $shipmentId = array_key_exists('shipmentId', $value) ? $value['shipmentId'] : $carrierCode . '|' . $value['serviceName'];
                    $this->shippedByArr[$shippedBy][$shippingLevel]['rates'][$rates['selprod_id']][$shipmentId] = $shippingCost;
                }
                /* If rates fetched from one shipment carriers then ignore for others */
                if (!empty($this->shippedByArr[$shippedBy][$shippingLevel]['rates'][$rates['selprod_id']])) {
                    break;
                }
            }
            
            /* add product info if rates fetched*/
            if (!in_array($rates['selprod_id'], $physicalSelProdIdArr)) {
                $this->shippedByArr[$shippedBy][$shippingLevel]['products'][$rates['selprod_id']] = $product;
            }
        }        
        
        return true;
    }

    /**
     * fetchShippingRatesFromSystem
     *
     * @param  array $productInfo
     * @param  array $physicalSelProdIdArr
     * @return bool
     */
    private function fetchShippingRatesFromSystem(array $productInfo, array &$physicalSelProdIdArr): bool
    {        
              
        foreach ($this->selProdShipRates as $rateId => $rates) {            
            if (!empty($this->systemRatesToFetchSelprodIds) && !in_array($rates['selprod_id'], $this->systemRatesToFetchSelprodIds)) {
                continue;
            } 
            
            $product = $productInfo[$rates['selprod_id']];
            $shippedBy = -1; /*Shipped by admin */
            $shippingLevel = self::LEVEL_PRODUCT;

            if ($rates['shiippingBySeller']) {
                $shippedBy = $product['shop_id'];
            }

            if ($rates['shipprofile_default']) {
                $shippingLevel = self::LEVEL_ORDER;
                if ($rates['shiippingBySeller']) {
                    $shippingLevel = self::LEVEL_SHOP;
                }
            }

            $shippingCost = [
                'id' => $rates['shiprate_id'],
                'code' => $rates['selprod_id'],
                'title' => $rates['shiprate_name'],
                'cost' => $rates['shiprate_cost'],
                'shiprate_condition_type' => $rates['shiprate_condition_type'],
                'shiprate_min_val' => $rates['shiprate_min_val'],
                'shiprate_max_val' => $rates['shiprate_max_val'],
                'shipping_level' => $shippingLevel,
                'shipping_type' => self::TYPE_MANUAL,
                'is_seller_plugin' => 0,
                /* 'shipprofile_key' => $rates['shipprofile_id'], */
                'carrier_code' => $rates['shipprofile_name'],
            ];
            unset($physicalSelProdIdArr[$rates['selprod_id']]);

            switch ($shippingLevel) {
                case self::LEVEL_PRODUCT:
                    $this->shippedByArr[$shippedBy][$shippingLevel]['products'][$rates['selprod_id']] = $product;
                    $this->shippedByArr[$shippedBy][$shippingLevel]['shipping_options'][$rates['selprod_id']][] = $rates;

                    if (isset($this->shippedByArr[$shippedBy][$shippingLevel]['rates'][$rates['selprod_id']][$rates['shiprate_id']]) && $this->shippedByArr[$shippedBy][$shippingLevel]['rates'][$rates['selprod_id']][$rates['shiprate_id']] != null) {
                        $this->setCost($this->shippedByArr[$shippedBy][$shippingLevel]['rates'][$rates['selprod_id']][$rates['shiprate_id']], $shippingCost);
                    }
                    $this->shippedByArr[$shippedBy][$shippingLevel]['rates'][$rates['selprod_id']][$rates['shiprate_id']] = $shippingCost;
                    break;
                case self::LEVEL_ORDER:
                case self::LEVEL_SHOP:
                    $this->shippedByArr[$shippedBy][$shippingLevel]['products'][$rates['selprod_id']] = $product;
                    $this->shippedByArr[$shippedBy][$shippingLevel]['shipping_options'][$rates['shiprate_id']] = $rates;
                    if (isset($this->shippedByArr[$shippedBy][$shippingLevel]['rates'][$rates['shiprate_id']]) && $this->shippedByArr[$shippedBy][$shippingLevel]['rates'][$rates['shiprate_id']] != null) {
                        $this->setCost($this->shippedByArr[$shippedBy][$shippingLevel]['rates'][$rates['shiprate_id']], $shippingCost);
                    }
                    $this->shippedByArr[$shippedBy][$shippingLevel]['rates'][$rates['shiprate_id']] = $shippingCost;
                    break;
            }
            $this->shippedByArr[$shippedBy][$shippingLevel]['pickup_options'] = [];
        }
        $this->setCombinedCharges();
        return true;
    }

    /**
     * calculateCharges
     *
     * @param  array $physicalSelProdIdArr
     * @param  array $shippingAddressDetail
     * @param  array $productInfo
     * @return array
     */
    public function calculateCharges(array $physicalSelProdIdArr, array $shippingAddressDetail, array $productInfo): array
    {
        $shipToCountryId = isset($shippingAddressDetail['addr_country_id']) ? $shippingAddressDetail['addr_country_id'] : 0;

        $shipToStateId = isset($shippingAddressDetail['addr_state_id']) ? $shippingAddressDetail['addr_state_id'] : 0;

        $this->selProdShipRates = $this->getSellerProductShippingRates($physicalSelProdIdArr, $shipToCountryId, $shipToStateId);
       
        $this->fetchShippingRatesFromApi($shippingAddressDetail, $productInfo, $physicalSelProdIdArr);
        if (count($this->systemRatesToFetchSelprodIds)) {
            $this->fetchShippingRatesFromSystem($productInfo, $physicalSelProdIdArr);
        }
        /*Include Physical products whose shipping rates not defined */
        foreach ($physicalSelProdIdArr as $selProdId) {
            $this->shippedByArr[$productInfo[$selProdId]['shop_id']][self::LEVEL_PRODUCT]['products'][$selProdId] = $productInfo[$selProdId];
            $this->shippedByArr[$productInfo[$selProdId]['shop_id']][self::LEVEL_PRODUCT]['shipping_options'][$selProdId] = [];
            $this->shippedByArr[$productInfo[$selProdId]['shop_id']][self::LEVEL_PRODUCT]['rates'][$selProdId] = [];
        }
        
        return $this->formatOutput(applicationConstants::SUCCESS, $this->shippedByArr);
    }

    /**
     * setCost
     *
     * @param  array $item
     * @param  array $shippingCost
     */
    private function setCost(array &$item, array &$shippingCost): bool
    {
        $code = '';
        if (isset($item['code']) && $item['code'] != '') {
            $code = $item['code'];
        }

        if ($code != '') {
            $shippingCost['code'] = $shippingCost['code'] . '_' . $code;
            $arr = array_filter(explode('_', $shippingCost['code']));
            sort($arr);
            $shippingCost['code'] = implode('_', $arr);
        }
        return true;
    }

    /**
     * setCombinedCharges
     *
     * @return bool
     */
    private function setCombinedCharges(): bool
    {
        $shipppedByArr = array_keys($this->shippedByArr);
        sort($shipppedByArr);
        $weightUnitsArr = applicationConstants::getWeightUnitsArr($this->langId, true);
        foreach ($shipppedByArr as $shipppedBy) {
            $levels = array_keys($this->shippedByArr[$shipppedBy]);
            foreach ($levels as $level) {
                switch ($level) {
                    case self::LEVEL_PRODUCT:
                        foreach ($this->shippedByArr[$shipppedBy][$level]['products'] as $selProdId => $product) {
                            $prodCombinedWeight = 0;
                            $prodCombinedPrice = 0;

                            $prodWeight = $product['product_weight'] * $product['quantity'];
                            $productWeightClass = isset($weightUnitsArr[$product['product_weight_unit']]) ? $weightUnitsArr[$product['product_weight_unit']] : '';
                            $productWeightInOunce = static::convertWeightInOunce($prodWeight, $productWeightClass);
                            $prodCombinedWeight = $prodCombinedWeight + $productWeightInOunce;

                            $prodCombinedPrice = $prodCombinedPrice + ($product['theprice'] * $product['quantity']);
                            $this->filterShippingRates($this->shippedByArr[$shipppedBy][$level]['rates'][$selProdId], $prodCombinedWeight, $prodCombinedPrice);
                        }
                        break;
                    case self::LEVEL_ORDER:
                    case self::LEVEL_SHOP:
                        $prodCombinedWeight = 0;
                        $prodCombinedPrice = 0;
                        foreach ($this->shippedByArr[$shipppedBy][$level]['products'] as $selProdId => $product) {
                            $prodWeight = $product['product_weight'] * $product['quantity'];
                            $productWeightClass = isset($weightUnitsArr[$product['product_weight_unit']]) ? $weightUnitsArr[$product['product_weight_unit']] : '';
                            $productWeightInOunce = static::convertWeightInOunce($prodWeight, $productWeightClass);
                            $prodCombinedWeight = $prodCombinedWeight + $productWeightInOunce;

                            $prodCombinedPrice = $prodCombinedPrice + ($product['theprice'] * $product['quantity']);
                        }
                        $this->filterShippingRates($this->shippedByArr[$shipppedBy][$level]['rates'], $prodCombinedWeight, $prodCombinedPrice);

                        /* foreach ($this->shippedByArr[$shipppedBy][$level]['products'] as $selProdId => $productData) {
                            $prodCombinedWeight = 0;
                            $prodCombinedPrice = 0;
                            foreach ($productData as $product) {
                                $prodWeight = $product['product_weight'] * $product['quantity'];
                                $productWeightClass = isset($weightUnitsArr[$product['product_weight_unit']]) ? $weightUnitsArr[$product['product_weight_unit']] : '';
                                $productWeightInOunce = static::convertWeightInOunce($prodWeight, $productWeightClass);
                                $prodCombinedWeight = $prodCombinedWeight + $productWeightInOunce;

                                $prodCombinedPrice = $prodCombinedPrice + ($product['theprice'] * $product['quantity']);
                            }
                            $this->filterShippingRates($this->shippedByArr[$shipppedBy][$level]['rates'][$selProdId], $prodCombinedWeight, $prodCombinedPrice);
                        } */
                        break;
                }
            }
        }


        /* $levels = array_keys($this->shippedByArr);
        $weightUnitsArr = applicationConstants::getWeightUnitsArr($this->langId);

        foreach ($levels as $level) {
            switch ($level) {
                case self::LEVEL_PRODUCT:
                    foreach ($this->shippedByArr[$level]['products'] as $selProdId => $product) {
                        $prodCombinedWeight = 0;
                        $prodCombinedPrice = 0;

                        $prodWeight = $product['product_weight'] * $product['quantity'];
                        $productWeightClass = isset($weightUnitsArr[$product['product_weight_unit']]) ? $weightUnitsArr[$product['product_weight_unit']] : '';
                        $productWeightInOunce = static::convertWeightInOunce($prodWeight, $productWeightClass);
                        $prodCombinedWeight = $prodCombinedWeight + $productWeightInOunce;

                        $prodCombinedPrice = $prodCombinedPrice + ($product['theprice'] * $product['quantity']);
                        $this->filterShippingRates($this->shippedByArr[$level]['rates'][$selProdId], $prodCombinedWeight, $prodCombinedPrice);
                    }
                    break;
                case self::LEVEL_ORDER:
                case self::LEVEL_SHOP:
                    foreach ($this->shippedByArr[$level]['products'] as $adminOrshopId => $productData) {
                        $prodCombinedWeight = 0;
                        $prodCombinedPrice = 0;
                        foreach ($productData as $product) {
                            $prodWeight = $product['product_weight'] * $product['quantity'];
                            $productWeightClass = isset($weightUnitsArr[$product['product_weight_unit']]) ? $weightUnitsArr[$product['product_weight_unit']] : '';
                            $productWeightInOunce = static::convertWeightInOunce($prodWeight, $productWeightClass);
                            $prodCombinedWeight = $prodCombinedWeight + $productWeightInOunce;

                            $prodCombinedPrice = $prodCombinedPrice + ($product['theprice'] * $product['quantity']);
                        }
                        $this->filterShippingRates($this->shippedByArr[$level]['rates'][$adminOrshopId], $prodCombinedWeight, $prodCombinedPrice);
                    }
                    break;
            }
        } */
        return true;
    }

    /**
     * filterShippingRates
     *
     * @param  array $rates
     * @param  float $weight
     * @param  float $price
     * @return bool
     */
    private function filterShippingRates(array &$rates, float $weight = 0, float $price = 0): bool
    {
        $priceOrWeighCondMatched = false;
        $defaultShippingRates = [];
        $priceOrWeightCost = '';
        $priceOrWeightCostId = 0;
        uasort($rates, function ($a, $b) {
            return  $b['shiprate_condition_type'] - $a['shiprate_condition_type'];
        });
        foreach ($rates as $key => $rate) {
            switch ($rate['shiprate_condition_type']) {

                case ShippingRate::CONDITION_TYPE_PRICE:
                    if ($price < $rate['shiprate_min_val'] || $price > $rate['shiprate_max_val']) {
                        unset($rates[$rate['id']]);
                        continue 2;
                    }
                    $priceOrWeighCondMatched = true;
                    break;

                case ShippingRate::CONDITION_TYPE_WEIGHT:
                    $minVal = static::convertWeightInOunce($rate['shiprate_min_val'], 'KG');
                    $maxVal = static::convertWeightInOunce($rate['shiprate_max_val'], 'KG');
                    if ($weight < $minVal || $weight > $maxVal) {
                        unset($rates[$rate['id']]);
                        continue 2;
                    }
                    $priceOrWeighCondMatched = true;
                    break;

                default:
                    if (true == $priceOrWeighCondMatched) {
                        unset($rates[$rate['id']]);
                        continue 2;
                    }
                    $defaultShippingRates[] = $rate['id'];
                    break;
            }

            if (in_array($rate['shiprate_condition_type'], [ShippingRate::CONDITION_TYPE_PRICE, ShippingRate::CONDITION_TYPE_WEIGHT])) {
                if ($priceOrWeightCost == '' && true == $priceOrWeighCondMatched) {
                    $priceOrWeightCost = $rate['cost'];
                    $priceOrWeightCostId = $rate['id'];
                } elseif ($priceOrWeightCost != '' && $priceOrWeightCost < $rate['cost']) {
                    unset($rates[$priceOrWeightCostId]);
                    $priceOrWeightCost = $rate['cost'];
                    $priceOrWeightCostId = $rate['id'];
                    continue;
                } else {
                    unset($rates[$rate['id']]);
                }
            }
        }
        if (true == $priceOrWeighCondMatched && !empty($defaultShippingRates)) {
            foreach ($defaultShippingRates as $rateId) {
                unset($rates[$rateId]);
            }
        }
        return true;
    }

    /**
     * convertWeightInOunce
     *
     * @param  float $productWeight
     * @param  string $productWeightClass
     * @return float
     */
    public static function convertWeightInOunce(float $productWeight, string $productWeightClass): float
    {
        $coversionRate = 1;
        switch (strtoupper($productWeightClass)) {
            case "KG":
                $coversionRate = "35.274";
                break;
            case "GM":
                $coversionRate = "0.035274";
                break;
            case "PN":
                $coversionRate = "16";
                break;
            case "OU":
                $coversionRate = "1";
                break;
            case "Ltr":
                $coversionRate = "33.814";
                break;
            case "Ml":
                $coversionRate = "0.033814";
                break;
        }

        return Fatutility::float($productWeight * $coversionRate);
    }

    /**
     * convertLengthInCenti
     *
     * @param  float $productWeight
     * @param  string $productWeightClass
     * @return float
     */
    public static function convertLengthInCenti(float $productWeight, string $productWeightClass): float
    {
        $coversionRate = 1;
        switch (strtoupper($productWeightClass)) {
            case "IN":
                $coversionRate = "2.54";
                break;
            case "MM":
                $coversionRate = "0.1";
                break;
            case "M":
                $coversionRate = "100";
                break;
            case "CM":
                $coversionRate = "1";
                break;
        }

        return Fatutility::float($productWeight * $coversionRate);
    }
    /**
     * formatShippingRates
     *
     * @return array
     */
    public static function formatShippingRates(array $rates, int $langId): array
    {
        $rateOptions = [];
        if (!empty($rates)) {
            $rateOptions[] = Labels::getLabel('MSG_SELECT_SERVICE', $langId);
            foreach ($rates as $key => $value) {
                $code = $value['serviceCode'];
                $price = $value['shipmentCost'] + $value['otherCost'];
                $name = $value['serviceName'];
                $displayPrice = CommonHelper::displayMoneyFormat($price);

                $label = $name . " (" . $displayPrice . " )";
                $rateOptions[$code . "-" . $price] = $label;
            }
        }

        return $rateOptions;
    }

    /**
     * setSelectedShipping
     *
     * @param  mixed $selectedShippingService
     * @return void
     */
    public function setSelectedShipping(array $selectedShippingService)
    {
        $this->selectedShippingService = $selectedShippingService;
    }
    
    /**
     * 
     * @param type $adminApi
     * @param type $sellerId 
     * 
     * $sellerId = 0 - Admin plugin else seller plugin
     */
    
    public function getShippingApiObj(int $sellerId = 0)
    {
        if (isset($this->shippingServicesArr[$sellerId])) {
            return $this->shippingServicesArr[$sellerId];
        }

        $isSellerPluginObjActive = false;

        if (0 < $sellerId) {
            $sellerPluginObj = new SellerPlugin(0, $sellerId);
            $pluginData = $sellerPluginObj->getDefaultPluginData(Plugin::TYPE_SHIPPING_SERVICES);            
            if (!empty($pluginData)) {
                $isSellerPluginObjActive = true;
                $pluginObj = $sellerPluginObj;
            }
        }
        if (!$isSellerPluginObjActive) {
            $pluginObj = new Plugin();
            $pluginData = $pluginObj->getDefaultPluginData(Plugin::TYPE_SHIPPING_SERVICES);
            if (empty($pluginData)) {
                $this->shippingServicesArr[$sellerId] = false;
                return false;
            }
        }

        $pluginObj = PluginHelper::callPlugin($pluginData['plugin_code'], [$this->langId], $error, $this->langId, false);
        if ($isSellerPluginObjActive) {
            $pluginObj->setRecordId($sellerId);
        }
        if (false === $pluginObj) {
            $this->error = $error;
            return false;
        }

        if (method_exists($pluginObj, 'init') && false === $pluginObj->init()) {
            $this->error = $pluginObj->getError();
            return false;
        }
        return $this->shippingServicesArr[$sellerId] = $pluginObj;
    }

}
