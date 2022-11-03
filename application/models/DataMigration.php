<?php

class DataMigration
{

    public const TYPE_CATEGORY = 1;
    public const TYPE_PRODUCT = 2;
    public const TYPE_USER = 3;
    public const TYPE_SELLER = 4;
    public const TYPE_PRODUCT_TAG = 5;
    public const TYPE_ORDER = 6;
    public const SINGLE_VENDOR = 1;
    public const MULTIVENDOR_VENDOR = 2;

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

    public static function sync()
    {
        if ($response = (new self)->adminSideSync() !== false) {
            return $response;
        }
        if ($response = (new self)->sellerSideSync() !== false) {
            return $response;
        }
    }

    protected function adminSideSync()
    {
        $pluginObj = new Plugin();
        $pluginData = $pluginObj->getDefaultPluginData(Plugin::TYPE_DATA_MIGRATION, ['plugin_code', 'plugin_id', 'plugin_type']);

        if (empty($pluginData)) {
            return false;
        }

        $this->pluginObj = LibHelper::callPlugin($pluginData['plugin_code'], [$this->langId], $error, $this->langId);
        $this->pluginObj->setVendorType(self::MULTIVENDOR_VENDOR);
        if (false === $this->pluginObj) {
            $this->error = $error;
            return false;
        }

        if (false === $this->pluginObj->init()) {
            $this->error = $this->pluginObj->getError();
            return false;
        }

        try {

            if ($this->syncUsers()) {
                echo $str = 'Admin Side Users Synced';
                return $str;
            }

            /* mark some users as seller and create shop*/
            if ($this->syncSellers()) {
                echo $str = 'Admin Side Sellers Synced';
                return $str;
            }

            if ($this->syncProducts()) {
                echo $str = 'Admin Side Products Synced';
                return $str;
            }

            if ($this->syncOrders()) {
                echo $str = 'Admin Side Orders Synced';
                return $str;
            }
        } catch (Exception $e) {
            /* deactive  plugin is exception comes so that it doesnt hamper other users */
            Plugin::updateStatus($pluginData['plugin_type'], Plugin::INACTIVE, $pluginData['plugin_id']);
            echo 'Message: ' . $e->getMessage();
            return false;
        }
        /* deactive  plugin after sync completed  */
        Plugin::updateStatus($pluginData['plugin_type'], Plugin::INACTIVE, $pluginData['plugin_id']);
    }

    protected function sellerSideSync()
    {

        $srch = Plugin::getSearchObject(0, false, false);
        $srch->joinTable(
                Plugin::DB_TBL_PLUGIN_TO_USER,
                'INNER JOIN',
                'plgu.' . Plugin::DB_TBL_PLUGIN_TO_USER_PREFIX . Plugin::tblFld('id') . ' = plg.' . Plugin::tblFld('id') . ' and plg.' . Plugin::tblFld('type') . '=' . Plugin::TYPE_DATA_MIGRATION,
                'plgu'
        );
        $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'seller_user.user_id = plgu.pu_user_id AND seller_user.user_deleted = ' . applicationConstants::NO, 'seller_user');
        $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'credential_user_id = seller_user.user_id and credential_active = ' . applicationConstants::ACTIVE . ' and credential_verified = ' . applicationConstants::YES, 'seller_user_cred');
        $srch->addOrder(Plugin::DB_TBL_PLUGIN_TO_USER_PREFIX . 'created_at', 'ASC');
        $srch->addFld('pu_user_id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $result = FatApp::getDb()->fetch($rs);
        if (empty($result)) {
            return false;
        }

        $userId = $result['pu_user_id'];
        $sellerPluginObj = new SellerPlugin(0, $userId);
        $pluginData = $sellerPluginObj->getDefaultPluginData(Plugin::TYPE_DATA_MIGRATION, ['plugin_code', 'plugin_id', 'plugin_type']);
        if (empty($pluginData)) {
            return;
        }
        $this->pluginObj = LibHelper::callPlugin($pluginData['plugin_code'], [$this->langId, self::SINGLE_VENDOR], $error, $this->langId, false);
        $this->pluginObj->setVendorType(self::SINGLE_VENDOR);
        $this->pluginObj->setUserId($userId);
        $this->pluginObj->setRecordId($userId); /* to fetch setting by record id */
        if (false === $this->pluginObj) {
            $this->error = $error;
            return false;
        }

        if (false === $this->pluginObj->init()) {
            $this->error = $this->pluginObj->getError();
            return false;
        }

        try {
            if ($this->syncProducts()) {
                echo 'Products Synced';
                return 'Products Synced';
            }
        } catch (Exception $e) {
            /* deactive  plugin is exception comes so that it doesnt hamper other users */
            $sellerPluginObj = new SellerPlugin($pluginData['plugin_id'], $userId);
            $sellerPluginObj->updateStatus(Plugin::INACTIVE);
            echo 'Message: ' . $e->getMessage();
            return false;
        }

        /* deactive user plugin after sync completed  */
        $sellerPluginObj = new SellerPlugin($pluginData['plugin_id'], $userId);
        $sellerPluginObj->updateStatus(Plugin::INACTIVE);
    }

    public function getError()
    {
        return $this->error;
    }

    private function syncUsers()
    {
        $users = $this->pluginObj->getUsers();
        if (0 < count($users)) {
            if (!$this->saveUsersData($users)) {
                $this->logError();
                return true;
            }
        }

        $this->pluginObj->savePaginationData(DataMigration::TYPE_USER);

        return (0 < count($users));
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
                } elseif (!empty($user['user_phone'])) {
                    $user['credential_username'] = $user['user_phone'];
                } else {
                    $user['credential_username'] = preg_replace('/[^A-Za-z0-9-\/]+/', '_', ltrim($user['user_name'], '/')) . "_" . $user['id'];
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

                    $countryId = $this->getCountryIdByNameOrCode($countryCode, $countryName, $this->langId);
                    $stateId = $this->getStateIdByNameOrCode($countryId, $stateCode, $stateName, $this->langId);

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

    private function syncSellers()
    {
        $sellers = $this->pluginObj->getSellers();

        if (0 < count($sellers)) {
            if (!$this->saveSellerData($sellers)) {
                $this->logError();
                return true;
            }
        }
        $this->pluginObj->savePaginationData(DataMigration::TYPE_SELLER);

        return (0 < count($sellers));
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
                } elseif (!empty($user['user_phone'])) {
                    $user['credential_username'] = $user['user_phone'];
                } else {
                    $user['credential_username'] = preg_replace('/[^A-Za-z0-9-\/]+/', '_', ltrim($user['user_name'], '/')) . "_" . $user['id'];
                }
            }

            if (1 > $this->getUserIdFromUserMeta($this->pluginObj->settings['plugin_code'], $user['id'], User::USER_TYPE_SELLER)) {
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
                if (!$userObj->updateUserMeta($pluginCode . "_seller_id", $user['id'])) {                   
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

            $countryId = $this->getCountryIdByNameOrCode($countryCode, $countryName, $this->langId);
            $stateId = $this->getStateIdByNameOrCode($countryId, $stateCode, $stateName, $this->langId);

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

    private function syncProducts()
    {
        $products = $this->pluginObj->getProducts();
        if (0 < count($products)) {
            if (!$this->saveProductsData($products)) {
                $this->logError();
                return true;
            }
        }
        $this->pluginObj->savePaginationData(DataMigration::TYPE_PRODUCT);

        return (0 < count($products));
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
                if ($this->pluginObj->getVendorType() == self::SINGLE_VENDOR) {
                    $userId = $catalog['user_id'];
                } else {
                    $userId = $this->getUserIdFromUserMeta($this->pluginObj->settings['plugin_code'], $catalog['user_id'], User::USER_TYPE_SELLER);
                }
            }

            if (0 < $userId) {
                $catalog['product_seller_id'] = $userId;
                $catalog['product_added_by_admin_id'] = 0;
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
                    $this->error = Labels::getLabel('ERR_UNABLE_TO_CREATE_OR_GET_OPTION', $this->langId);
                    $db->rollbackTransaction();
                    return false;
                }

                if (!$productObj->addUpdateProductOption($optionId,'')) {
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
                    if ($this->pluginObj->getVendorType() == self::SINGLE_VENDOR) {
                        $userId = $sellerProduct['user_id'];
                    } else {
                        $userId = $this->getUserIdFromUserMeta($this->pluginObj->settings['plugin_code'], $sellerProduct['user_id'], User::USER_TYPE_SELLER);
                    }
                }

                if (0 < $userId) {
                    $sellerProduct['selprod_user_id'] = $userId;
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

    private function syncOrders()
    {
        $orders = $this->pluginObj->getOrders();
        if (0 < count($orders)) {
            if (!$this->saveOrdersData($orders)) {
                $this->logError();
                return true;
            }
        }
        $this->pluginObj->savePaginationData(DataMigration::TYPE_ORDER);

        return (0 < count($orders));
    }

    private function saveOrdersData($orders)
    {
        $currencyRow = Currency::getAttributesById($this->langId);
        $weightUnitsArr = applicationConstants::getWeightUnitsArr($this->langId);
        $lengthUnitsArr = applicationConstants::getLengthUnitsArr($this->langId);

        foreach ($orders as $order) {            
            $orderData = [];
            $isNewOrder = 1;
            $orderId = Orders::getOrderIdByPlugin($this->pluginObj->settings['plugin_id'], $order['id']);
            if (0 < $orderId) {
                $isNewOrder = 0;
            }
            $orderData['order_id'] = $orderId;
            $orderData['order_user_id'] = $this->getUserIdFromUserMeta($this->pluginObj->settings['plugin_code'], $order['buyer_id']);
            $orderData['order_payment_status'] = $order['payment_status'];
            $orderData['order_date_added'] = $order['created_at'];
            $orderData['order_currency_id'] = $currencyRow['currency_id'];
            $orderData['order_currency_code'] = $currencyRow['currency_code'];
            $orderData['order_currency_value'] = $currencyRow['currency_value'];          
            $languageRow = Language::getAttributesById(CommonHelper::getLangId());
            $orderData['order_language_id'] = $languageRow['language_id'];
            $orderData['order_language_code'] = $languageRow['language_code'];

            $userAddresses = [];

            if (0 < count($order['billingAddress'])) {
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

            $orderData['order_discount_coupon_code'] = $order['discount_coupon_code'];
            $orderData['order_discount_type'] = DiscountCoupons::TYPE_SELLER_PACKAGE;
            $orderData['order_discount_value'] = $order['discount_value'];
            $orderData['order_discount_total'] = $order['discount_total'];
            //$orderData['order_discount_info'] = "";
            // need to check again
            $orderData['order_reward_point_used'] = 0;
            $orderData['order_reward_point_value'] = 0;

            $orderData['order_tax_charged'] = $order['total_tax'];
            $orderData['order_site_commission'] = 0;
            $orderData['order_volume_discount_total'] = 0;
            $orderData['order_net_amount'] = $order['total_price'];
            $orderData['order_is_wallet_selected'] = 0;
            $orderData['order_wallet_amount_charge'] = 0;
            $orderData['order_type'] = Orders::ORDER_PRODUCT;

            $orderData['orderLangData'] = []; /* no use only using in  newOrderBuyerAdmin email */

            $productCount = 0;
            foreach ($order['products'] as $product) {
                $selprodId = SellerProduct::getProdIdByPlugin($this->pluginObj->settings['plugin_id'], $product['id']);
                $productInfo = $this->getSelProdDataById($selprodId, $this->langId);
                if (empty($productInfo)) {
                    continue;
                    /*
                      $this->error = Labels::getLabel('ERR_SELLER_PRODUCT_NOT_FOUND', $this->langId);
                      return false;
                     *
                     */
                }

                $productCount += 1;
                $productShippingData = array();
                $productTaxChargesData = array();

                $shippingDurationTitle = '';
                $shippingDurationRow = array();

                $productPickUpData = array();
                $productPickupAddress = array();

                $productTaxOption = array();
                $op_product_tax_options = array();

                foreach ($product['tax_lines'] as $taxLineId => $taxLine) {
                    $productTaxChargesData[$taxLineId] = array(
                        'opchargelog_type' => OrderProduct::CHARGE_TYPE_TAX,
                        'opchargelog_identifier' => $taxLine['title'],
                        'opchargelog_value' => $taxLine['price'],
                        'opchargelog_is_percent' => 1,
                        'opchargelog_percentvalue' => $taxLine['rate']
                    );
                    $productTaxChargesData[$taxLineId]['langData'][$this->langId] = array(
                        'opchargeloglang_lang_id' => $this->langId,
                        'opchargelog_name' => $taxLine['title']
                    );
                    $op_product_tax_options[$taxLine['title']]['name'] = $taxLine['title'];
                    $op_product_tax_options[$taxLine['title']]['value'] = $taxLine['price'];
                    $op_product_tax_options[$taxLine['title']]['percentageValue'] = $taxLine['rate'];
                    $op_product_tax_options[$taxLine['title']]['inPercentage'] = 1;
                }

                $productsLangData = array();
                $productShippingLangData = array();

                /* stamping/locking of product options language based [ */
                $op_selprod_options = '';
                $productOptionsRows = SellerProduct::getSellerProductOptions($selprodId, true, $this->langId);
                if (!empty($productOptionsRows)) {
                    $optionCounter = 1;
                    foreach ($productOptionsRows as $poLang) {
                        $op_selprod_options .= $poLang['option_name'] . ': ' . $poLang['optionvalue_name'];
                        if ($optionCounter != count($productOptionsRows)) {
                            $op_selprod_options .= ' | ';
                        }
                        $optionCounter++;
                    }
                }
                /* ] */

                $op_products_dimension_unit_name = ($productInfo['product_dimension_unit']) ? $lengthUnitsArr[$productInfo['product_dimension_unit']] : '';
                $op_product_weight_unit_name = ($productInfo['product_weight_unit']) ? $weightUnitsArr[$productInfo['product_weight_unit']] : '';


                $productsLangData[$this->langId] = array(
                    'oplang_lang_id' => $this->langId,
                    'op_product_name' => $productInfo['product_name'],
                    'op_selprod_title' => $productInfo['selprod_title'],
                    'op_selprod_options' => $op_selprod_options,
                    'op_brand_name' => !empty($productInfo['brand_name']) ? $productInfo['brand_name'] : '',
                    'op_shop_name' => $productInfo['shop_name'],
                    'op_shipping_duration_name' => "",
                    'op_shipping_durations' => $shippingDurationTitle,
                    'op_products_dimension_unit_name' => $op_products_dimension_unit_name,
                    'op_product_weight_unit_name' => $op_product_weight_unit_name,
                    'op_product_tax_options' => json_encode($op_product_tax_options),
                );


                $orderData['products'][$selprodId] = array(
                    'op_selprod_id' => $selprodId,
                    'op_is_batch' => 0,
                    'op_selprod_user_id' => $productInfo['selprod_user_id'],
                    'op_selprod_code' => $productInfo['selprod_code'],
                    'op_qty' => $product['quantity'],
                    'op_unit_price' => $product['price'],
                    'op_unit_cost' => $productInfo['selprod_cost'],
                    'op_selprod_sku' => $productInfo['selprod_sku'],
                    'op_selprod_condition' => $productInfo['selprod_condition'],
                    'op_product_model' => $productInfo['product_model'],
                    'op_product_type' => $productInfo['product_type'],
                    'op_product_length' => $productInfo['product_length'],
                    'op_product_width' => $productInfo['product_width'],
                    'op_product_height' => $productInfo['product_height'],
                    'op_product_dimension_unit' => $productInfo['product_dimension_unit'],
                    'op_product_weight' => $productInfo['product_weight'],
                    'op_product_weight_unit' => $productInfo['product_weight_unit'],
                    'op_shop_id' => $productInfo['shop_id'],
                    'op_shop_owner_username' => $productInfo['shop_owner_username'],
                    'op_shop_owner_name' => $productInfo['shop_onwer_name'],
                    'op_shop_owner_email' => $productInfo['shop_owner_email'],
                    'op_shop_owner_phone' => isset($productInfo['shop_owner_phone']) && !empty($productInfo['shop_owner_phone']) ? $productInfo['shop_owner_phone'] : '',
                    'op_selprod_max_download_times' => ($productInfo['selprod_max_download_times'] != '-1') ? $product['quantity'] * $productInfo['selprod_max_download_times'] : $productInfo['selprod_max_download_times'],
                    'op_selprod_download_validity_in_days' => $productInfo['selprod_download_validity_in_days'],
                    'opshipping_rate_id' => 0, //need to check
                    'op_commission_charged' => 0,
                    'op_commission_percentage' => 0,
                    'op_affiliate_commission_percentage' => 0,
                    'op_affiliate_commission_charged' => 0,
                    'op_status_id' => $product['status'],
                    'productsLangData' => $productsLangData,
                    'productShippingData' => $productShippingData,
                    'productPickUpData' => $productPickUpData,
                    'productPickupAddress' => $productPickupAddress,
                    'productShippingLangData' => $productShippingLangData,
                    'productChargesLogData' => $productTaxChargesData,
                    'op_actual_shipping_charges' => $product['shipping_cost'],
                    'op_refund_qty' => $product['refund_quantity'],
                    'op_refund_amount' => $product['refund_amount'],
                    'op_refund_shipping' => $product['refund_shipping'],
                    'op_tax_code' => "",
                    'productSpecifics' => [
                        'op_selprod_return_age' => $productInfo['return_age'],
                        'op_selprod_cancellation_age' => $productInfo['cancellation_age'],
                        'op_product_warranty' => $productInfo['product_warranty'],
                        'op_prodcat_id' => $productInfo['prodcat_id']
                    ],
                    'op_rounding_off' => 0,
                );


                $discount = $product['total_discount'];
                $rewardPoints = 0;
                $usedRewardPoint = 0;
                $volumeDiscount = $product['volume_discount'];

                $orderData['prodCharges'][$selprodId] = array(
                    OrderProduct::CHARGE_TYPE_SHIPPING => array(
                        'amount' => $product['shipping_cost']
                    ),
                    OrderProduct::CHARGE_TYPE_TAX => array(
                        'amount' => 0 < count($product['tax_lines']) ? array_sum(array_column($product['tax_lines'], 'price')) : 0,
                    ),
                    OrderProduct::CHARGE_TYPE_DISCOUNT => array(
                        'amount' => -$discount /* [Should be negative value] */
                    ),
                    OrderProduct::CHARGE_TYPE_REWARD_POINT_DISCOUNT => array(
                        'amount' => -$usedRewardPoint
                    ),
                    OrderProduct::CHARGE_TYPE_VOLUME_DISCOUNT => array(
                        'amount' => -$volumeDiscount
                    ),
                );
            }

            if (1 > $productCount) {
                /* in shopify some product are not present in multivendor=> do not create order */
                continue;
            }
            $orderData['order_affiliate_user_id'] = 0;
            $orderData['order_affiliate_total_commission'] = 0;

            $orderObj = new Orders();
            if (!$orderObj->addUpdateOrder($orderData, $this->langId)) {
                $this->error = $orderObj->getError();
                return false;
            }

            $orderId = $orderObj->getOrderId();

            if ($isNewOrder) {
                $record = new TableRecord(Orders::DB_ORDER_TO_PLUGIN_ORDER);
                $pluginToOrderArr = array(
                    'opo_order_id' => $orderId,
                    'opo_plugin_id' => $this->pluginObj->settings['plugin_id'],
                    'opo_plugin_order_id' => $order['id']
                );
                $record->assignValues($pluginToOrderArr);
                if (!$record->addNew(array(), $pluginToOrderArr)) {
                    $this->error = $orderObj->getError();
                    return false;
                }
            }
        }

        return true;
    }

    private function getCountryIdByNameOrCode($countryCode, $countryName, $langId)
    {
        $countryId = 0;
        if (!empty($countryCode) || !empty($countryName)) {
            if (!empty($countryCode)) {
                if (!isset($thiscountryIdArrByCode[$countryCode])) {
                    $countryId = Countries::getCountryByCode($countryCode, 'country_id');
                    $this->countryIdArrByCode[$countryCode] = $countryId;
                } else {
                    $countryId = $this->countryIdArrByCode[$countryCode];
                }
            }

            if (empty($countryId) && !empty($countryName)) {
                if (!isset($this->countryIdArrByName[$countryName])) {
                    $countryId = Countries::getCountryAttributeByName($countryName, $langId, 'country_id');
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

    private function getStateIdByNameOrCode($countryId, $stateCode, $stateName, $landId)
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
                    $stateId = States::getStateAttrByCountryIdAndName($countryId, $stateName, $landId, 'state_id');
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

    private function createCountry($countryCode, $countryName, $langId)
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

    private function createState($countryId, $stateCode, $stateName, $langId)
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

    private function getUniqueProductIdentifier(string $identifier): string
    {
        $srchObj = Product::getSearchObject(0, false, false);
        $srchObj->addCondition('product_identifier', "LIKE", $identifier . '%');
        $srchObj->doNotCalculateRecords();
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

    private function getOptionId(string $identifier, string $name, int $isColor, int $hasSeparateImages, int $displayInFilter, int $langId)
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
        $cnd = $srch->addCondition('tag_name', "=", $name);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (empty($row)) {
            $tagObj = new Tag();
            $tagSaveData = array(
                'tag_name' => $name,              
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

    protected function getUserIdFromUserMeta($pluginCode, $pluginUserId, $type = User::USER_TYPE_BUYER): int
    {
        $key = $pluginCode . "_" . $type . "_" . $pluginUserId;
        if (isset($this->userIdByUserMetaArr[$key])) {
            return $this->userIdByUserMetaArr[$key];
        }

        $srch = new SearchBase(User::DB_TBL_META);
        $srch->addFld('usermeta_user_id');
        $metaKey = $pluginCode . "_id";
        if ($type == User::USER_TYPE_SELLER) {
            $metaKey = $pluginCode . "_seller_id";
        }
        $srch->addCondition(User::DB_TBL_META_PREFIX . 'key', '=', $metaKey);
        $srch->addCondition(User::DB_TBL_META_PREFIX . 'value', '=', $pluginUserId);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (empty($row)) {
            return 0;
        }
        return $this->userIdByUserMetaArr[$key] = $row['usermeta_user_id'];
    }

    private function getSelProdDataById($selProdId, $langId)
    {
        $srch = new ProductSearch($langId, null, null, false, false, false);
        $srch->joinSellerProducts(0, '', ['doNotJoinSpecialPrice' => true], false);
        $srch->joinSellers();
        $srch->joinShops($langId, false, false);
        $srch->joinBrands($langId, false, false, false);
        $srch->joinShopSpecifics();
        $srch->joinSellerProductSpecifics();
        $srch->joinProductSpecifics();

        $srch->joinProductToCategory();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('selprod_id', '=', $selProdId);
        $fields = array('IFNULL(product_name, product_identifier) as product_name',
            'IFNULL(selprod_title  ,IFNULL(product_name, product_identifier)) as selprod_title',
            'IFNULL(brand_name, brand_identifier) as brand_name', 'IFNULL(shop_name, shop_identifier) as shop_name',
            'product_dimension_unit', 'product_id', 'product_type', 'product_length', 'product_width',
            'product_height', 'product_dimension_unit', 'product_weight', 'product_weight_unit', 'product_model',
            'selprod_user_id', 'selprod_code', 'selprod_sku', 'selprod_cost', 'selprod_condition', 'shop_id',
            'selprod_max_download_times', 'selprod_download_validity_in_days', 'seller_user_cred.credential_email as shop_owner_email',
            'seller_user_cred.credential_username as shop_owner_username', 'seller_user.user_name as shop_onwer_name',
            'ps.product_warranty', 'COALESCE(sps.selprod_return_age, ss.shop_return_age) as return_age', 'COALESCE(sps.selprod_cancellation_age, ss.shop_cancellation_age) as cancellation_age', 'prodcat_id'
        );

        $srch->addMultipleFields($fields);
        $rs = $srch->getResultSet();
        return FatApp::getDb()->fetch($rs);
    }

    private function logError()
    {
        CommonHelper::logData("Error_" . $this->pluginObj->settings['plugin_code'] . ":" . $this->getError());
        if (CONF_DEVELOPMENT_MODE) {
            print_r($this->getError());
        }
    }

}
