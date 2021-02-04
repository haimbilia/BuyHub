<?php

class DataMigration
{
    public const TYPE_CATEGORY = 1;
    public const TYPE_PRODUCT = 2;
    public const TYPE_USER = 3;
    public const TYPE_SELLER = 4;
    
    public $activedServiceId = 0;
    private $langId;
    private $pluginObj;
    protected $error;

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

//            if ($this->syncProducts()){
//                return ;
//            }




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
        print_r($sellers);
        die();
        if (0 < count($sellers)) {            
            if(!$this->saveSellerData($sellers)){                
                print_r($this->getError());
                return true;
            } 
            $this->pluginObj->savePaginationData(DataMigration::TYPE_SELLER);
        } 

        return (0 < count($sellers));      
    }
    

    private function syncProducts()
    {        
        $products = $this->pluginObj->getProducts();
        print_r($products);
//        if (0 < count($products)) {            
//            if(!$this->saveProductsData($products)){                
//                print_r($this->getError());
//                return true;
//            } 
//            $this->pluginObj->saveProductsPaginationData();
//        } 
//
//        return (0 < count($users));
    }
    
    
    private function syncUsers()
    {        
        $users = $this->pluginObj->getUsers();
        if (0 < count($users)) {            
            if(!$this->saveUsersData($users)){                
                print_r($this->getError());
                return true;
            } 
            $this->pluginObj->savePaginationData(DataMigration::TYPE_USER);
        } 

        return (0 < count($users));
    }
    
    
    
    private function saveSellerData($sellers){
        
    }
    
    private function saveUsersData($users)
    {    
        $countryIdArrByCode = [];
        $countryIdArrByName = [];

        $stateIdArrByCode = [];
        $stateIdArrByName = [];
        
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

                    if (!empty($countryCode)) {
                        if (!isset($countryIdArrByCode[$countryCode])) {
                            $countryId = Countries::getCountryByCode($countryCode, 'country_id');
                            $countryIdArrByCode[$countryCode] = $countryId;
                        } else {
                            $countryId = $countryIdArrByCode[$countryCode];
                        }
                    }

                    if (empty($countryId) && !empty($countryName)) {
                        if (!isset($countryIdArrByName[$countryName])) {
                            $countryId = Countries::getCountryAttributeByName($countryName, 'country_id');
                            $countryIdArrByName[$countryName] = $countryId;
                        } else {
                            $countryId = $countryIdArrByName[$countryName];
                        }
                    }

                    if (empty($countryId)) {
                        $countryId = $this->createCountry($countryCode, $countryName, $this->langId);
                        if (empty($countryId)) {
                            $db->rollbackTransaction();
                            return false;
                        }
                        $countryIdArrByCode[$countryCode] = $countryId;
                        $countryIdArrByName[$countryName] = $countryId;
                    }

                    if (!empty($stateCode)) {
                        $stateCodekey = $countryId . "_" . $stateCode;
                        if (!isset($stateIdArrByCode[$stateCodekey])) {
                            $stateArr = States::getStateByCountryAndCode($countryId, $stateCode);
                            if (!empty($stateArr)) {
                                $stateId = $stateArr['state_id'];
                                $stateIdArrByCode[$stateCodekey] = $stateId;
                            }
                        } else {
                            $stateId = $stateIdArrByCode[$stateCodekey];
                        }
                    }

                    if (empty($stateId) && !empty($stateName)) {
                        $stateNamekey = $countryId . "_" . $stateName;
                        if (!isset($stateIdArrByName[$stateNamekey])) {
                            $stateId = States::getStateAttrByCountryIdAndName($stateName, 'state_id');
                            $stateIdArrByName[$stateNamekey] = $stateId;
                        } else {
                            $stateId = $stateIdArrByName[$stateNamekey];
                        }
                    }

                    if (empty($stateId)) {
                        $stateId = $this->createState($countryId, $stateCode, $stateName, $this->langId);
                        if (empty($stateId)) {
                            $db->rollbackTransaction();
                            return false;
                        }
                        $stateIdArrByCode[$stateCodekey] = $stateId;
                        $stateIdArrByName[$stateNamekey] = $stateId;
                    }

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
            'country_code' => $countryCode
        );
        $countryObj->assignValues($countryDatatoSave);
        if (!$countryObj->save()) {
            $this->error = $countryObj->getError();
            return false;
        }

        $countryId = $countryObj->getMainTableRecordId();

        $countryLangDatatoSave = array(
            'countrylang_lang_id' => $langId,
            'countrylang_country_id' => $countryId,
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
            'statelang_lang_id' => $lang_id,
            'statelang_state_id' => $stateId,
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

    public function getError()
    {
        return $this->error;
    }
   
    
}
