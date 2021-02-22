<?php

class DataMigration
{

    public const TYPE_CATEGORY = 1;
    public const TYPE_PRODUCT = 2;
    public const TYPE_USER = 3;
    public const TYPE_SELLER = 4;
    public const TYPE_PRODUCT_TAG = 5;
    public const TYPE_ORDER = 6;

    public $activedServiceId = 0;
    private $langId;
    private $pluginObj;
    protected $error;
    
    protected $countryIdArrByCode;
    protected $countryIdArrByName;
    protected $stateIdArrByCode;
    protected $stateIdArrByName;
    protected $productCatArr;
    protected $optionArr;
    protected $optionValArr;
    protected $userIdByUserMetaArr;

    public function __construct(int $langId = 0)
    {
        $this->langId = (0 < $langId ? $langId : CommonHelper::getLangId());
    }

    public function sync()
    {
        $activatedTaxServiceId = $this->getActivatedServiceId();
        if (1 < $activatedTaxServiceId) {
            $pluginKey = Plugin::getAttributesById($activatedTaxServiceId, 'plugin_code');
            $this->pluginObj = PluginHelper::callPlugin($pluginKey, [$this->langId,], $error, $this->langId);
            if (false === $this->pluginObj) {
                $this->error = $error;
                return false;
            }
            if (false === $this->pluginObj->init()) {
                $this->error = $this->pluginObj->getError();
                return false;
            }

//            if ($this->syncUsers()) {
//                echo 'Users Synced';
//                return 'Users Synced'; 
//            }
//
//            /* mark some users as seller and create shop */
//            if ($this->syncSellers()) {
//                echo 'Sellers Synced';
//                return 'Sellers Synced';                
//            }

//            if ($this->syncProducts()) {
//                echo 'Products Synced';
//                return 'Products Synced';
//            }
            
            if ($this->syncOrders()) {
                echo 'Orders Synced';
                return 'Orders Synced';
            }

        }
    }

    private function syncSellers()
    {
        $sellers = $this->pluginObj->getSellers();
        if (0 < count($sellers)) {
            if (!$this->saveSellerData($sellers)) {
                return true;
            }            
        }
        $this->pluginObj->savePaginationData(DataMigration::TYPE_SELLER);

        return (0 < count($sellers));
    }

    private function syncProducts()
    {
        $products = $this->pluginObj->getProducts();
        if (0 < count($products)) {
            if (!$this->saveProductsData($products)) { 
                return true;
            }            
        }
        $this->pluginObj->savePaginationData(DataMigration::TYPE_PRODUCT);

        return (0 < count($products));
    }
    
    private function syncOrders()
    {
        $orders = $this->pluginObj->getOrders();
        if (0 < count($orders)) {
            
            print_r($orders);
            
            
            if (!$this->saveOrdersData($orders)) { 
                return true;
            }            
        }
//        $this->pluginObj->savePaginationData(DataMigration::TYPE_ORDER);
//
//        return (0 < count($orders));
    }
    
    private function saveOrdersData($orders){
        $db = FatApp::getDb();
        $db->startTransaction();
        foreach ($orders as $order) { 
            $isNewOrder = 1;            
            $orderId = Orders::getOrderIdByPlugin($this->pluginObj->settings['plugin_id'], $order['id']);
            if (0 < $orderId) {
                $isNewOrder = 0;
            }
            $orderData['order_id'] = $order_id;
            $orderData['order_user_id'] = $this->getUserIdFromUserMeta($this->pluginObj->settings['plugin_id'],$order['buyer_id']); 
            $orderData['order_payment_status'] = Orders::ORDER_PAYMENT_PENDING;
            $orderData['order_date_added'] = $order['created_at'];
            
            $currencyRow = Currency::getAttributesById($this->siteCurrencyId);
            $orderData['order_currency_id'] = $currencyRow['currency_id'];
            $orderData['order_currency_code'] = $currencyRow['currency_code'];
            $orderData['order_currency_value'] = $currencyRow['currency_value'];
            
            
            $userAddresses = [];
            
            if(0 < count($order['billingAddress'])){
                $userAddresses[] = array(
                    'oua_order_id' => $orderId,
                    'oua_type' => Orders::BILLING_ADDRESS_TYPE,
                    'oua_name' => $order['billingAddress']['name'],
                    'oua_address1' => $order['billingAddress']['address1'],
                    'oua_address2' => $order['billingAddress']['address2'],
                    'oua_city' => $order['billingAddress']['city'],
                    'oua_state' => $order['billingAddress']['state'],
                    'oua_country' => $order['billingAddress']['country'],
                    'oua_country_code' => $order['billingAddress']['country_code'],
                    'oua_country_code_alpha3' => "",
                    'oua_state_code' => $order['billingAddress']['state_code'],
                    'oua_phone' => $order['billingAddress']['phone'],
                    'oua_zip' => $order['billingAddress']['zip'],
                );
            }
            
            if (0 < count($order['shippingAddress'])) {
                $userAddresses[] = array(
                    'oua_order_id' => $orderId,
                    'oua_type' => Orders::SHIPPING_ADDRESS_TYPE,
                    'oua_name' => $order['shippingAddress']['name'],
                    'oua_address1' => $order['shippingAddress']['address1'],
                    'oua_address2' => $order['shippingAddress']['address2'],
                    'oua_city' => $order['shippingAddress']['city'],
                    'oua_state' => $order['shippingAddress']['state'],
                    'oua_country' => $order['shippingAddress']['country'],
                    'oua_country_code' => $order['shippingAddress']['country_code'],
                    'oua_country_code_alpha3' => "",
                    'oua_state_code' => $order['shippingAddress']['state_code'],
                    'oua_phone' => $order['shippingAddress']['phone'],
                    'oua_zip' => $order['shippingAddress']['zip'],
                );
            }
            
            $orderData['userAddresses'] = $userAddresses;
            
            
        }
        
        //$db->commitTransaction();
        return true;
    }

    private function saveProductsData($products)
    {
        $db = FatApp::getDb();
        $db->startTransaction();
        foreach ($products as $product) {
            
            $catalog = $product['catalog'];
            $isNewProduct = 1;
            $productId = Product::getProdIdByPlugin($this->pluginObj->settings['plugin_id'], $catalog['id']);
            if (0 < $productId) {
                $isNewProduct = 0;
            }

            if ($isNewProduct) {
                $catalog['product_identifier'] = $this->getUniqueProductIdentifier($catalog['product_identifier']);
            } else {
                unset($catalog['product_identifier']);
            }

            $catalog['product_added_by_admin_id'] = 1;
            if (!empty($catalog['user_id'])) {
                $userId = $this->getUserIdFromUserMeta($this->pluginObj->settings['plugin_code'], $catalog['user_id']);
                if (0 < $userId) {
                    $catalog['product_seller_id'] = $userId;
                    $catalog['product_added_by_admin_id'] = 0;
                }
            }            
            $productObj = new Product($productId);
            if (!$productObj->saveProductData($catalog)) {
                $this->error = $productObj->getError();
                $db->rollbackTransaction();
                return false;
            }
            $productId = $productObj->getMainTableRecordId();

            if ($isNewProduct) {
                $record = new TableRecord(Product::DB_PRODUCT_TO_PLUGIN_PRODUCT);
                $pluginToProductArr = array(
                    'ptpp_product_id' => $productId,
                    'ptpp_plugin_id' => $this->pluginObj->settings['plugin_id'],
                    'ptpp_plugin_product_id' => $catalog['id']
                );
                $record->assignValues($pluginToProductArr);
                if (!$record->addNew(array(), $pluginToProductArr)) {
                    $this->error = $record->getError();
                    return false;
                }
            }

            $productLangData = array(
                'product_name' => $catalog['product_name'],
                'product_description' => $catalog['product_description'],
                'product_youtube_video' => $catalog['product_youtube_video'],
            );

            if (!$productObj->updateLangData($this->langId, $productLangData)) {
                $this->error = $productObj->getError();
                $db->rollbackTransaction();
                return false;
            }

            $catId = $this->getCategoryIdByName($catalog['category_name'], $this->langId);

            Product::updateMinPrices($productId);

            if (0 < $catId) {
                if (!$productObj->saveProductCategory($catId)) {
                    $this->error = $productObj->getError();
                    $db->rollbackTransaction();
                    return false;
                }
            }

            foreach ($product['options'] as &$option) {
                $option['option_identifier'] = $option['option_name'] . "_" . $catId;
                $optionId = $this->getOptionId($option['option_identifier'], $option['option_name'], $option['option_is_color'], $option['option_is_color'], $option['option_is_separate_images'], $this->langId);
                if (0 > $optionId) {
                    $this->error = Labels::getLabel('MSG_UNABLE_TO_CREATE_OR_GET_OPTION', $this->langId);
                    $db->rollbackTransaction();
                    return false;
                }

                if (!$productObj->addUpdateProductOption($optionId)) {
                    $this->error = $productObj->getError();
                    $db->rollbackTransaction();
                    return false;
                }

                foreach ($option['values'] as $opValName) {
                    $optionValId = $this->getOptionValId($optionId, $opValName, $this->langId);
                }
            }
            /* [ delete old product images */
            if (0 < count($product['images'])) {
                $db->deleteRecords(
                        AttachedFile::DB_TBL,
                        array(
                            'smt' => 'afile_type = ? AND afile_record_id = ?',
                            'vals' => array(AttachedFile::FILETYPE_PRODUCT_IMAGE, $productId)
                        )
                );
            }
            /*  delete old product images ] */

            foreach ($product['images'] as $prodImage) {
                $optionId = 0;
                $optionValId = 0;
                if (!empty($prodImage['option']) && !empty($prodImage['optionValue'])) {
                    $optionId = $this->optionArr[$prodImage['option'] . "_" . $catId] ?? 0;
                    if (0 < $optionId) {
                        $optionValId = $this->optionValArr[$optionId . "_" . $prodImage['optionValue']] ?? 0;
                    }
                }
                $this->saveProductImage($productId, $optionValId, $prodImage['url']);
            }
            
            foreach ($product['tags'] as $tag) {
                $tagId = $this->getTagIdByName($tag, $this->langId);
                $productObj->addUpdateProductTag($tagId);
            }

            foreach ($product['sellerProducts'] as &$sellerProduct) {

                $isNewSelProd = 1;
                $selprodId = SellerProduct::getProdIdByPlugin($this->pluginObj->settings['plugin_id'], $sellerProduct['id']);

                if (0 < $selprodId) {
                    $isNewSelProd = 0;
                }
                $sellerProduct['selprod_product_id'] = $productId;

                if (!empty($sellerProduct['user_id'])) {
                    $userId = $this->getUserIdFromUserMeta($this->pluginObj->settings['plugin_code'], $sellerProduct['user_id']);
                    if (0 < $userId) {
                        $sellerProduct['selprod_user_id'] = $userId;
                    }
                }

                $selProdOptions = [];
                foreach ($sellerProduct['combination'] as $option => $optionVal) {
                    $optionId = 0;
                    $optionValId = 0;
                    if (!empty($option) && !empty($optionVal)) {
                        $optionId = $this->optionArr[$option . "_" . $catId] ?? 0;
                        if (0 < $optionId) {
                            $optionValId = $this->optionValArr[$optionId . "_" . $optionVal] ?? 0;
                        }
                    }
                    $selProdOptions[$optionId] = $optionValId;
                }
                $selProdCode = $sellerProduct['selprod_product_id'] . '_' . implode('_', $selProdOptions);
                $sellerProduct['selprod_code'] = $selProdCode;

                $selProdObj = new SellerProduct($selprodId);
                $selProdObj->assignValues($sellerProduct);
                if (!$selProdObj->save()) {
                    $this->error = $selProdObj->getError();
                    $db->rollbackTransaction();
                    return false;
                }
                $selprodId = $selProdObj->getMainTableRecordId();

                if ($isNewSelProd) {
                    $record = new TableRecord(SellerProduct::DB_SELLER_PROD_TO_PLUGIN_SELLER_PROD);
                    $pluginToSelProdArr = array(
                        'spps_selprod_id' => $selprodId,
                        'spps_plugin_id' => $this->pluginObj->settings['plugin_id'],
                        'spps_plugin_selprod_id' => $sellerProduct['id']
                    );
                    $record->assignValues($pluginToSelProdArr);
                    if (!$record->addNew(array(), $pluginToSelProdArr)) {
                        $this->error = $record->getError();
                        $db->rollbackTransaction();
                        return false;
                    }
                }

                if (!$selProdObj->addUpdateSellerProductOptions($selprodId, $selProdOptions)) {
                    $this->error = $selProdObj->getError();
                    $db->rollbackTransaction();
                    return false;
                }

                /* Add Url rewriting  [  ---- */
                $selProdObj->rewriteUrlProduct($sellerProduct['selprod_url_keyword']);
                $selProdObj->rewriteUrlReviews($sellerProduct['selprod_url_keyword']);
                $selProdObj->rewriteUrlMoreSellers($sellerProduct['selprod_url_keyword']);
                /* --------  ] */

                $selProdLangData = array(
                    'selprod_title' => $sellerProduct['selprod_title'],
                    'selprod_comments' => $sellerProduct['selprod_comments'],
                );
                if (!$selProdObj->updateLangData($this->langId, $selProdLangData)) {
                    $this->error = $selProdObj->getError();
                    $db->rollbackTransaction();
                    return false;
                }
            }
        }
        $db->commitTransaction();
        return true;
    }

    private function syncUsers()
    {
        $users = $this->pluginObj->getUsers();   
        if (0 < count($users)) {
            if (!$this->saveUsersData($users)) {                
                print_r($this->getError());
                return true;
            }
            $this->pluginObj->savePaginationData(DataMigration::TYPE_USER);
        }

        return (0 < count($users));
    }

    private function saveSellerData($sellers)
    {
        $pluginCode = strtolower($this->pluginObj->settings['plugin_code']);

        $db = FatApp::getDb();
        $db->startTransaction();
        foreach ($sellers as &$user) {
            $isNewUser = 1;
            $userObj = new User();
            if (!empty($user['credential_email'])) {
                $userArr = $userObj->checkUserByEmailOrUserName($user['credential_username'], $user['credential_email']);
            } else {
                $userArr = $userObj->checkUserByPhoneOrUserName($user['credential_username'], $user['user_phone']);
            }

            if (!empty($userArr)) {
                $userObj = new User($userArr['user_id']);
                $isNewUser = 0;
            }
            /* not adding/updating data with empty values */
            $userObj->assignValues(array_filter($user));
            if (!$userObj->save()) {
                $this->error = $userObj->getError();
                $db->rollbackTransaction();
                return false;
            }

            $userId = $userObj->getMainTableRecordId();
                        
            if (empty($user['credential_username'])) {
                if (!empty($user['credential_email'])) {
                    $user['credential_username'] = $user['credential_email'];
                }elseif(!empty($user['user_phone'])){
                    $user['credential_username'] = $user['user_phone'];
                } else {
                    $user['credential_username'] = preg_replace('/[^A-Za-z0-9-\/]+/', '_', ltrim($user['user_name'], '/'))."_".$user['id'];
                }
            }

            if ($isNewUser) {
                if (!isset($user['user_password']) || empty($user['user_password'])) {
                    $user['user_password'] = CommonHelper::getRandomPassword(8);
                }

                if (!$userObj->setLoginCredentials($user['credential_username'], $user['credential_email'], $user['user_password'], $user['user_active'], $user['user_verify'])) {
                    $db->rollbackTransaction();
                    return false;
                }

                if (!$this->createSellerApprovalRequest($userId)) {
                    $db->rollbackTransaction();
                    return false;
                }

                /* [----------------profile photo------------- */
                if (!empty($user['profile_photo'])) {
                    $fileAttr = array(
                        'afile_type' => AttachedFile::FILETYPE_USER_PROFILE_CROPED_IMAGE,
                        'afile_record_id' => $userId,
                        'afile_record_subid' => 0,
                        'afile_lang_id' => 0,
                        'afile_screen' => 0,
                        'afile_display_order' => -1,
                        'afile_unique' => 1
                    );
                    AttachedFile::getImageName($user['profile_photo'], $fileAttr);
                }
                /* ----------------profile photo-]------------] */
            }


            if (!empty($user['id'])) {
                if (!$userObj->updateUserMeta($pluginCode . "_id", $user['id'])) {
                    $this->error = $userObj->getError();
                    $db->rollbackTransaction();
                    return false;
                }
            }

            $shop = $user['shop'];

            $countryCode = $shop['shop_country_code'];
            $countryName = $shop['shop_country_name'];

            $stateCode = $shop['shop_state_code'];
            $stateName = $shop['shop_state_name'];

            $countryId = $this->getCountryIdByNameOrCode($countryCode, $countryName,$this->langId);
            $stateId = $this->getStateIdByNameOrCode($countryId, $stateCode, $stateName ,$this->langId);

            $shop['shop_country_id'] = $countryId;
            $shop['shop_state_id'] = $stateId;
            $shop['shop_user_id'] = $userId;

            $isNewShop = 1;

            $shopObj = new Shop(0, $userId);
            if (0 < $shopObj->getMainTableRecordId()) {
                $isNewShop = 0;
            }

            $shopObj->assignValues($shop);
            if (!$shopObj->save()) {
                $this->error = $shopObj->getError();
                $db->rollbackTransaction();
                return false;
            }

            $shopId = $shopObj->getMainTableRecordId();

            $shopLangData = array(
                'shop_name' => $shop['shop_name'],
                'shop_contact_person' => $shop['shop_contact_person'],
                'shop_city' => $shop['shop_city'],
                'shop_seller_info' => $shop['shop_seller_info'],
                'shop_description' => $shop['shop_description'],
                'shop_payment_policy' => $shop['shop_payment_policy']
            );

            if (!$shopObj->updateLangData($this->langId, $shopLangData)) {
                $this->error = $shopObj->getError();
                $db->rollbackTransaction();
                return false;
            }

            if ($shop['urlrewrite_custom'] == '') {
                $shopOriginalUrl = Shop::SHOP_TOP_PRODUCTS_ORGINAL_URL . $shopId;
                FatApp::getDb()->deleteRecords(UrlRewrite::DB_TBL, array('smt' => 'urlrewrite_original = ?', 'vals' => array($shopOriginalUrl)));
            } else {
                $shopObj->rewriteUrlShop($shop['urlrewrite_custom']);
                $shopObj->rewriteUrlReviews($shop['urlrewrite_custom']);
                $shopObj->rewriteUrlTopProducts($shop['urlrewrite_custom']);
                $shopObj->rewriteUrlContact($shop['urlrewrite_custom']);
                $shopObj->rewriteUrlpolicy($shop['urlrewrite_custom']);
            }

            $shopSpecificsObj = new ShopSpecifics($shopId);
            $shopSpecificsObj->assignValues($shop);
            $data = $shopSpecificsObj->getFlds();
            if (!$shopSpecificsObj->addNew(array(), $data)) {
                $this->error = $userObj->getError();
                $db->rollbackTransaction();
            }

            if ($isNewShop) {
                if (!empty($shop['shop_logo'])) {
                    $fileAttr = array(
                        'afile_type' => AttachedFile::FILETYPE_SHOP_LOGO,
                        'afile_record_id' => $shopId,
                        'afile_record_subid' => 0,
                        'afile_lang_id' => $this->langId,
                        'afile_screen' => 0,
                        'afile_display_order' => -1,
                        'afile_unique' => 1
                    );
                    AttachedFile::getImageName($shop['shop_logo'], $fileAttr);
                }

                if (!empty($shop['shop_banner'])) {
                    $fileAttr = array(
                        'afile_type' => AttachedFile::FILETYPE_SHOP_BANNER,
                        'afile_record_id' => $shopId,
                        'afile_record_subid' => 0,
                        'afile_lang_id' => $this->langId,
                        'afile_screen' => applicationConstants::SCREEN_DESKTOP,
                        'afile_display_order' => -1,
                        'afile_unique' => 1
                    );
                    AttachedFile::getImageName($shop['shop_banner'], $fileAttr);
                }
            }
        }

        $db->commitTransaction();

        return true;
    }

    private function getCountryIdByNameOrCode($countryCode, $countryName ,$langId)
    {
        $countryId = 0;
        if (!empty($countryCode) || !empty($countryName)) {
            if (!empty($countryCode)) {
                if (!isset($thiscountryIdArrByCode[$countryCode])) {
                    $countryId = Countries::getCountryByCode($countryCode, 'country_id');
                    $this->countryIdArrByCode[$countryCode] = $countryId;
                } else {
                    $countryId = $thiscountryIdArrByCode[$countryCode];
                }
            }

            if (empty($countryId) && !empty($countryName)) {
                if (!isset($this->countryIdArrByName[$countryName])) {
                    $countryId = Countries::getCountryAttributeByName($countryName, 'country_id');
                    $this->countryIdArrByName[$countryName] = $countryId;
                } else {
                    $countryId = $this->countryIdArrByName[$countryName];
                }
            }

            if (empty($countryId)) {
                $countryId = $this->createCountry($countryCode, $countryName, $langId);
                if (empty($countryId)) {
                    return false;
                }
                $this->countryIdArrByCode[$countryCode] = $countryId;
                $this->countryIdArrByName[$countryName] = $countryId;
            }
        }

        return $countryId;
    }

    private function getStateIdByNameOrCode($countryId, $stateCode, $stateName ,$landId)
    {
        $stateId = 0;
        if (!empty($stateCode) || !empty($stateName)) {
            if (!empty($stateCode)) {
                $stateCodekey = $countryId . "_" . $stateCode;
                if (!isset($this->stateIdArrByCode[$stateCodekey])) {
                    $stateArr = States::getStateByCountryAndCode($countryId, $stateCode);
                    if (!empty($stateArr)) {
                        $stateId = $stateArr['state_id'];
                        $this->stateIdArrByCode[$stateCodekey] = $stateId;
                    }
                } else {
                    $stateId = $this->stateIdArrByCode[$stateCodekey];
                }
            }

            if (empty($stateId) && !empty($stateName)) {
                $stateNamekey = $countryId . "_" . $stateName;
                if (!isset($this->stateIdArrByName[$stateNamekey])) {
                    $stateId = States::getStateAttrByCountryIdAndName($countryId,$stateName,$landId,'state_id');
                    $this->stateIdArrByName[$stateNamekey] = $stateId;
                } else {
                    $stateId = $this->stateIdArrByName[$stateNamekey];
                }
            }

            if (empty($stateId)) {
                $stateId = $this->createState($countryId, $stateCode, $stateName, $landId);
                if (empty($stateId)) {
                    return false;
                }

                if (!empty($stateCode)) {
                    $this->stateIdArrByCode[$stateCodekey] = $stateId;
                }

                if (!empty($stateName)) {
                    $this->stateIdArrByName[$stateNamekey] = $stateId;
                }
            }
        }

        return $stateId;
    }

    private function getCategoryIdByName($categoryName, int $langId): int
    {

        if (empty($categoryName)) {
            return 0;
        }
        if (isset($this->productCatArr[$categoryName])) {
            return $this->productCatArr[$categoryName];
        }
        $srch = ProductCategory::getSearchObject(false, $langId, false, -1);
        $cnd = $srch->addCondition('prodcat_identifier', "=", $categoryName);
        $cnd->attachCondition('prodcat_name', '=', $categoryName);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (empty($row)) {
            $productCatObj = new ProductCategory();
            $prodDataToSave = [
                'prodcat_identifier' => $categoryName,
                'prodcat_active' => 1,
                'prodcat_status' => 1
            ];
            $productCatObj->assignValues($prodDataToSave);
            if (!$productCatObj->save()) {
                $this->error = $productCatObj->getError();
                return false;
            }
            $catLangDatatoSave = [
                'prodcat_name' => $categoryName,
            ];
            if (!$productCatObj->updateLangData($langId, $catLangDatatoSave)) {
                $this->error = $productCatObj->getError();
                return false;
            }
            $catId = $productCatObj->getMainTableRecordId();
        } else {
            $catId = $row['prodcat_id'];
        }
        $this->productCatArr[$categoryName] = $catId;
        return $catId;
    }

    private function createSellerApprovalRequest(int $userId)
    {
        $record = new TableRecord(User::DB_TBL_USR_SUPP_REQ);
        $assign_fields = array();
        $assign_fields['usuprequest_user_id'] = $userId;
        $assign_fields['usuprequest_date'] = date('Y-m-d H:i:s');
        $assign_fields['usuprequest_attempts'] = 1;
        $assign_fields['usuprequest_status'] = 1;
        $record->assignValues($assign_fields);
        $data = $record->getFlds();
        if (!$record->addNew(array(), $data)) {
            $this->error = $record->getError();
            return false;
        }
        return true;
    }

    private function saveUsersData($users)
    {
        $pluginCode = strtolower($this->pluginObj->settings['plugin_code']);

        $db = FatApp::getDb();
        $db->startTransaction();
        foreach ($users as $userkey => &$user) {
                        
            if (empty($user['credential_username'])) {
                if (!empty($user['credential_email'])) {
                    $user['credential_username'] = $user['credential_email'];
                }elseif(!empty($user['user_phone'])){
                    $user['credential_username'] = $user['user_phone'];
                } else {
                    $user['credential_username'] = preg_replace('/[^A-Za-z0-9-\/]+/', '_', ltrim($user['user_name'], '/'))."_".$user['id'];
                }
            }
            
            $userObj = new User();
            if (!empty($user['credential_email'])) {
                $userArr = $userObj->checkUserByEmailOrUserName($user['credential_username'], $user['credential_email']);
            } else {
                $userArr = $userObj->checkUserByPhoneOrUserName($user['credential_username'], $user['user_phone']);
            }

            if (empty($userArr)) {
                $userObj->assignValues($user);
                if (!$userObj->save()) {
                    $this->error = $userObj->getError();
                    $db->rollbackTransaction();
                    return false;
                }

                $userId = $userObj->getMainTableRecordId();


                if (!isset($user['user_password']) || empty($user['user_password'])) {
                    $user['user_password'] = CommonHelper::getRandomPassword(8);
                }
                
                              
                if (!$userObj->setLoginCredentials($user['credential_username'], $user['credential_email'], $user['user_password'], $user['user_active'], $user['user_verify'])) {
                    $this->error = $userObj->getError();
                    $db->rollbackTransaction();
                    return false;
                }
                foreach ($user['addresses'] as $address) {
                    $countryCode = $address['country_code'];
                    $countryName = $address['country_name'];

                    $stateCode = $address['state_code'];
                    $stateName = $address['state_name'];

                    $countryId = $this->getCountryIdByNameOrCode($countryCode, $countryName,$this->langId);
                    $stateId = $this->getStateIdByNameOrCode($countryId, $stateCode, $stateName ,$this->langId);

                    $addressObj = new Address();
                    $addrDataToSave = $address;
                    $addrDataToSave['addr_country_id'] = $countryId;
                    $addrDataToSave['addr_state_id'] = $stateId;
                    $addrDataToSave['addr_record_id'] = $userId;
                    $addrDataToSave['addr_type'] = Address::TYPE_USER;
                    $addrDataToSave['addr_lang_id'] = $this->langId;
                    $addressObj->assignValues($addrDataToSave, true);
                    if (!$addressObj->save()) {
                        $this->error = $addressObj->getError();
                        $db->rollbackTransaction();
                        return false;
                    }
                }
            } else {
                $userId = $userArr['user_id'];
                $userObj = new User($userId);
            }
            
            if (!$userObj->updateUserMeta($pluginCode . "_id", $user['id'])) {
                $this->error = $userObj->getError();
                $db->rollbackTransaction();
                return false;
            }
        }
        
        $db->commitTransaction();

        return true;
    }

    public function createCountry($countryCode, $countryName, $langId)
    {
        $countryObj = new Countries();
        $countryDatatoSave = array(
            'country_code' => $countryCode,
            'country_active' => 1
        );
        $countryObj->assignValues($countryDatatoSave);
        if (!$countryObj->save()) {
            return false;
        }

        $countryId = $countryObj->getMainTableRecordId();

        $countryLangDatatoSave = array(
            'country_name' => $countryName
        );
        if (!$countryObj->updateLangData($langId, $countryLangDatatoSave)) {
            $this->error = $countryObj->getError();
            return false;
        }
        return $countryId;
    }

    public function createState($countryId, $stateCode, $stateName, $langId)
    {
        $statesObj = new States();
        $stateDatatoSave = array(
            'state_code' => $stateCode,
            'state_identifier' => $stateName,
            'state_country_id' => $stateName,
        );
        $statesObj->assignValues($stateDatatoSave);
        if (!$statesObj->save()) {
            $this->error = $statesObj->getError();
            return false;
        }

        $stateId = $statesObj->getMainTableRecordId();

        $stateLangDatatoSave = array(
            'state_name' => $stateName
        );

        if (!$statesObj->updateLangData($langId, $stateLangDatatoSave)) {
            $this->error = $statesObj->getError();
            return false;
        }
        return $stateId;
    }

    /**
     * getActivatedServiceId
     *
     * @return int
     */
    public function getActivatedServiceId(): int
    {
        if (1 > $this->activedServiceId) {
            $pluginObj = new Plugin();
            $this->activedServiceId = (int) $pluginObj->getDefaultPluginData(Plugin::TYPE_DATA_MIGRATION, 'plugin_id');
        }
        return $this->activedServiceId;
    }

    public static function getSyncType($langId)
    {
        $langId = FatUtility::convertToType($langId, FatUtility::VAR_INT);
        return array(
            self::TYPE_CATEGORIES => Labels::getLabel('LBL_CATEGORIES', $langId),
            self::TYPE_PRODUCTS => Labels::getLabel('LBL_PRODUCTS', $langId),
            self::TYPE_USER => Labels::getLabel('LBL_USERS', $langId),
        );
    }

    private function getUniqueProductIdentifier(string $identifier): string
    {
        $srchObj = Product::getSearchObject(0, false, false);
        $srchObj->addCondition('product_identifier', "LIKE", $identifier . '%');
        $rs = $srchObj->getResultSet();
        $identifiers = FatApp::getDb()->fetchAllAssoc($rs);

        if (0 < count($identifiers)) {
            do {
                $uniqueIdentifer = $identifier . "_" . rand(1, 10000);
            } while (in_array($uniqueIdentifer, $identifiers));

            return $uniqueIdentifer;
        }

        return $identifier;
    }

    public function getOptionId(string $identifier, string $name, int $isColor, int $hasSeparateImages, int $displayInFilter, int $langId)
    {

        if (isset($this->optionArr[$identifier])) {
            return $this->optionArr[$identifier];
        }

        $srch = Option::getSearchObject();
        $srch->addFld('option_id');
        $cnd = $srch->addCondition('option_identifier', "=", $identifier);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (empty($row)) {
            $optionData = array(
                'option_identifier' => $identifier,
                'option_is_color' => $isColor,
                'option_is_separate_images' => $hasSeparateImages,
                'option_display_in_filter' => $displayInFilter,
                'option_seller_id' => $displayInFilter,
                'option_type' => Option::OPTION_TYPE_SELECT,
            );
            $optionObj = new Option();
            $optionObj->assignValues($optionData);
            if (!$optionObj->save()) {
                $this->error = $optionObj->getError();
                return false;
            }

            if (!$optionObj->updateLangData($this->langId, ['option_name' => $name])) {
                $this->error = $optionObj->getError();
                return false;
            }
            return $this->optionArr[$identifier] = $optionObj->getMainTableRecordId();
        }
        return $this->optionArr[$identifier] = $row['option_id'];
    }

    private function getOptionValId($optionId, $name, $langId)
    {
        if (isset($this->optionValArr[$optionId . "_" . $name])) {
            return $this->optionValArr[$optionId . "_" . $name];
        }

        $srch = OptionValue::getSearchObject();
        $srch->addFld('optionvalue_id');
        $srch->addCondition('optionvalue_identifier', "=", $name);
        $srch->addCondition('optionvalue_option_id', "=", $optionId);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (empty($row)) {
            $optionValueObj = new OptionValue();
            $opSaveData = array(
                'optionvalue_option_id' => $optionId,
                'optionvalue_identifier' => $name,
            );
            $optionValueObj->assignValues($opSaveData);
            $data = $optionValueObj->getFlds();
            if (!$optionValueObj->addNew(array(), $data)) {
                $this->error = $userObj->getError();
                return false;
            }
            if (!$optionValueObj->updateLangData($langId, ['optionvalue_name' => $name])) {
                $this->error = $optionValueObj->getError();
                return false;
            }
            return $this->optionValArr[$optionId . "_" . $name] = $optionValueObj->getMainTableRecordId();
        }
        return $this->optionValArr[$optionId . "_" . $name] = $row['optionvalue_id'];
    }

    private function getTagIdByName($name, $langId)
    {

        if (isset($this->tagArr[$name])) {
            return $this->tagArr[$name];
        }

        $srch = Tag::getSearchObject();
        $srch->addFld('tag_id');
        $cnd = $srch->addCondition('tag_identifier', "=", $name);
        //$cnd->attachConditon('tag_name', "=", $name);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (empty($row)) {
            $tagObj = new Tag();
            $tagSaveData = array(
                'tag_identifier' => $name,
                'tag_admin_id' => 1,
            );
            $tagObj->assignValues($tagSaveData);
            $data = $tagObj->getFlds();
            if (!$tagObj->addNew(array(), $data)) {
                $this->error = $tagObj->getError();
                return false;
            }
            if (!$tagObj->updateLangData($langId, ['tag_name' => $name])) {
                $this->error = $tagObj->getError();
                return false;
            }
            return $this->tagArr[$name] = $tagObj->getMainTableRecordId();
        }
        return $this->tagArr[$name] = $row['tag_id'];
    }

    private function saveProductImage($productId, $optionValId, $url)
    {

        $fileAttr = array(
            'afile_type' => AttachedFile::FILETYPE_PRODUCT_IMAGE,
            'afile_record_id' => $productId,
            'afile_record_subid' => $optionValId,
            'afile_lang_id' => $this->langId,
            'afile_screen' => 0,
            'afile_display_order' => -1,
            'afile_unique' => 0
        );
        AttachedFile::getImageName($url, $fileAttr);
    }

    protected function getUserIdFromUserMeta($pluginCode, $pluginUserId): int
    {

        if (isset($this->userIdByUserMetaArr[$pluginCode . "_" . $pluginUserId])) {
            return $this->userIdByUserMetaArr[$pluginCode . "_" . $pluginUserId];
        }

        $srch = new SearchBase(User::DB_TBL_META);
        $srch->addFld('usermeta_user_id');
        $metaKey = $pluginCode . "_id";
        $srch->addCondition(User::DB_TBL_META_PREFIX . 'key', '=', $metaKey);
        $srch->addCondition(User::DB_TBL_META_PREFIX . 'value', '=', $pluginUserId);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (empty($row)) {
            return 0;
        }
        return $this->userIdByUserMetaArr[$pluginCode . "_" . $pluginUserId] = $row['usermeta_user_id'];
    }

    public function getError()
    {
        return $this->error;
    }

}
