<?php

class DataMigration
{
    public const TYPE_CATEGORY = 1;
    public const TYPE_PRODUCT = 2;
    public const TYPE_USER = 3;
    public const TYPE_SELLER = 4;
    public const TYPE_PRODUCT_TAG = 5;

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
//                return;
//            }

            /* mark some users as seller and create shop */
            if ($this->syncSellers()) {
                return;
            }

            if ($this->syncProducts()){
                return ;
            }




            /*
              $products = $migrationApi->getProducts();
              if(1 > count($products)){

              return;
              }
             *
             *
             */
        }
    }

    private function syncSellers()
    {
        $sellers = $this->pluginObj->getSellers();     
        if (0 < count($sellers)) {
            if (!$this->saveSellerData($sellers)) {           
                return true;
            }
            $this->pluginObj->savePaginationData(DataMigration::TYPE_SELLER);
        }

        return (0 < count($sellers));
    }

    private function syncProducts()
    {
        $products = $this->pluginObj->getProducts();
        if (0 < count($products)) {
            if(!$this->saveProductsData($products)){
                print_r($this->getError());
                return true;
            }
            //$this->pluginObj->saveProductsPaginationData();
        }

        return (0 < count($products));
    }
    
    private function saveProductsData($products)
    {
        $db = FatApp::getDb();
        $db->startTransaction();
        foreach ($products as &$product) {
            
            print_r($product);
            $catalog = $product['catalog'];
            $isNewProduct = 1;
            $productId = Product::getProdIdByPlugin($this->pluginObj->settings['plugin_id'], $catalog['id']);

            if (0 < $productId) {
                $isNewProduct = 0;
            }
            
            if($isNewProduct){
                $catalog['product_identifier'] = $this->getUniqueProductIdentifier($catalog['product_identifier']);
            }else{
                unset($catalog['product_identifier']); 
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
                if(0 > $optionId){
                    $this->error = Labels::getLabel('MSG_UNABLE_TO_CREATE_OR_GET_OPTION', $langId);
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
            /*  delete old product images ]*/
            
            foreach ($product['images'] as $prodImage) {
                $optionId = 0;
                $optionValId = 0;
                if (!empty($prodImage['option']) && !empty($prodImage['optionValue'])) {
                    
                    print_r($this->optionArr);
                    print_r($prodImage['option']);
                    die();
                    $optionId = $this->optionArr[$prodImage['option'] . "_" . $catId] ?? 0;
                    var_dump($optionId);
                    if (0 < $optionId) {
                        $optionValId = $this->optionValArr[$optionId . "_" . $prodImage['optionValue']] ?? 0;
                    }
                }
                $this->saveProductImage($productId, $optionValId, $prodImage['url']);
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
        $pluginName = strtolower($this->pluginObj->settings['plugin_code']);

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

            if (empty($user['user_username'])) {
                if (!empty($user['credential_email'])) {
                    $user['user_username'] = $user['credential_email'];
                } else {
                    $user['user_username'] = $user['user_phone'];
                }
            }

            if ($isNewUser) {
                if (!isset($user['user_password']) || empty($user['user_password'])) {
                    $user['user_password'] = CommonHelper::getRandomPassword(8);
                }

                if (!$userObj->setLoginCredentials($user['user_username'], $user['credential_email'], $user['user_password'], $user['user_active'], $user['user_verify'])) {
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
                if (!$userObj->updateUserMeta($pluginName . "_id", $user['id'])) {
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

            $countryId = $this->getCountryIdByNameOrCode($countryCode, $countryName);
            $stateId = $this->getStateIdByNameOrCode($countryId, $stateCode, $stateName);

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

    private function getCountryIdByNameOrCode($countryCode, $countryName)
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
                $countryId = $this->createCountry($countryCode, $countryName, $this->langId);
                if (empty($countryId)) {
                    return false;
                }
                $this->countryIdArrByCode[$countryCode] = $countryId;
                $this->countryIdArrByName[$countryName] = $countryId;
            }
        }

        return $countryId;
    }

    private function getStateIdByNameOrCode($countryId, $stateCode, $stateName)
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
                    $stateId = States::getStateAttrByCountryIdAndName($stateName, 'state_id');
                    $this->stateIdArrByName[$stateNamekey] = $stateId;
                } else {
                    $stateId = $this->stateIdArrByName[$stateNamekey];
                }
            }

            if (empty($stateId)) {
                $stateId = $this->createState($countryId, $stateCode, $stateName, $this->langId);
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
    
    
    private function getCategoryIdByName($categoryName , int $langId) : int
    {
        
        if(empty($categoryName)){
            return 0;
        }        
        if(isset($this->productCatArr[$categoryName])){
            return $this->productCatArr[$categoryName];
        }
        $srch = ProductCategory::getSearchObject(false, $langId, false, -1);
        $cnd = $srch->addCondition('prodcat_identifier', "=", $categoryName);
        $cnd->attachCondition('prodcat_name', '=', $categoryName);
        $rs = $srch->getResultSet();        
        $row = FatApp::getDb()->fetch($rs);        
        if(empty($row)){            
            $productCatObj = new ProductCategory();
            $prodDataToSave = [
                'prodcat_identifier'=> $categoryName,
                'prodcat_active'=> 1, 
                'prodcat_status' => 1
            ];
            $productCatObj->assignValues($prodDataToSave);            
            if (!$productCatObj->save()) {                
                $this->error = $productCatObj->getError();
                return false;
            } 
            $catLangDatatoSave= [
                'prodcat_name'=> $categoryName,
            ]; 
            if (!$productCatObj->updateLangData($langId, $catLangDatatoSave)) {
                $this->error = $productCatObj->getError();
                return false;
            }
            $catId = $productCatObj->getMainTableRecordId();                     
        }else{
            $catId =  $row['prodcat_id'] ; 
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
        $pluginName = strtolower($this->pluginObj->settings['plugin_code']);

        $db = FatApp::getDb();
        $db->startTransaction();
        foreach ($users as &$user) {
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

                if (empty($user['user_username'])) {
                    if (!empty($user['credential_email'])) {
                        $user['user_username'] = $user['credential_email'];
                    } else {
                        $user['user_username'] = $user['user_phone'];
                    }
                }

                if (!isset($user['user_password']) || empty($user['user_password'])) {
                    $user['user_password'] = CommonHelper::getRandomPassword(8);
                }

                if (!$userObj->setLoginCredentials($user['user_username'], $user['credential_email'], $user['user_password'], $user['user_active'], $user['user_verify'])) {
                    $db->rollbackTransaction();
                    return false;
                }

                foreach ($user['addresses'] as $address) {
                    $countryCode = $address['country_code'];
                    $countryName = $address['country_name'];

                    $stateCode = $address['state_code'];
                    $stateName = $address['state_name'];

                    $countryId = $this->getCountryIdByNameOrCode($countryCode, $countryName);
                    $stateId = $this->getStateIdByNameOrCode($countryId, $stateCode, $stateName);

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

            if (!$userObj->updateUserMeta($pluginName . "_id", $user['id'])) {
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
                $uniqueIdentifer = $identifier . "_". rand(1, 10000);
            } while (in_array($uniqueIdentifer, $identifiers));
            
            return $uniqueIdentifer;
        }

        return $identifier;
    }
    
    public function getOptionId(string $identifier, string $name, int $isColor, int $hasSeparateImages, int $displayInFilter, int $langId)
    {  
        
        if(isset($this->optionArr[$identifier])){
            return $this->optionArr[$identifier];
        }
        
        $srch = Option::getSearchObject();
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
           
            if (!$optionObj->updateLangData($this->langId, ['option_name'=> $name])) {
                $this->error = $optionObj->getError();             
                return false;
            } 
            $this->optionArr[$identifier] = $identifier;
            return $optionObj->getMainTableRecordId();
        }
        
        return $row['option_id'];
    }
    
    private function getOptionValId($optionId, $name, $langId)
    {
        if (isset($this->optionValArr[$optionId . "_" . $name])) {
            return $this->optionValArr[$optionId . "_" . $name];
        }

        $srch = OptionValue::getSearchObject();
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
            $this->optionValArr[$optionId . "_" . $name] = $optionId . "_" . $name;
            return $optionValueObj->getMainTableRecordId();
        }
        return $row['optionvalue_id'];
    }
    
    private function saveProductImage($productId,$optionValId,$url){
        
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

    public function getError()
    {
        return $this->error;
    }
}
