<?php

class DataMigration
{
    public const TYPE_CATEGORY = 1;
    public const TYPE_PRODUCT = 2;
    public const TYPE_USER = 3;
    
    public $activedServiceId = 0;
    
    public function sync()
    {
        $langId = FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1);
        
        $activatedTaxServiceId = static::getActivatedServiceId();
        if (1 < $activatedTaxServiceId) {
            $pluginKey = Plugin::getAttributesById($activatedTaxServiceId, 'plugin_code');
            if (false === PluginHelper::includePlugin($pluginKey, Plugin::getDirectory(Plugin::TYPE_DATA_MIGRATION), $error, $langId)) {
                SystemLog::set($error);
                die($error);
                // need to update
                return;
            }
            $migrationApi = new $pluginKey();
            if (false === $migrationApi->init()) {
                SystemLog::set($migrationApi->getError());
                die($migrationApi->getError());
                // need to update
                return;
            }            
            $users = $migrationApi->getUsers();
                    
            if (0 < count($users)) {
                $this->saveUsersData($users, $migrationApi::KEY_NAME);
                return;
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
    
    private function syncUsers()
    {
    }
    
    private function saveUsersData($users, $pluginName)
    {
        
        print_r($users);
        $langId = FatApp::getConfig('CONF_DEFAULT_SITE_LANG', FatUtility::VAR_INT, 1);

        $db = FatApp::getDb();
        $db->startTransaction();
        $pluginName = strtolower($pluginName);

        $countryIdArrByCode = [];
        $countryIdArrByName = [];

        $stateIdArrByCode = [];
        $stateIdArrByName = [];       

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

                if (!$userObj->updateUserMeta($pluginName . "_id", $user['id'])) {
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
                        $countryId = $this->createCountry($countryCode, $countryName, $langId);
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
                        $stateId = $this->createState($countryId, $stateCode, $stateName, $langId);
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
                    $addrDataToSave['addr_lang_id'] = $langId;
                    
                    $addressObj->assignValues($addrDataToSave, true);
                    if (!$addressObj->save()) {
                        $db->rollbackTransaction();
                        return false;
                    }
                }                
                $db->commitTransaction();
                
            } else {
                $userId = $userArr['user_id'];
            }
        }
    }

    public function createCountry($countryCode, $countryName, $langId)
    {
        $countryObj = new Countries();
        $countryDatatoSave = array(
            'country_code' => $countryCode
        );
        
        echo 1111;
        $countryObj->assignValues($countryDatatoSave);
        if (!$countryObj->save()) {
            print_r($countryObj->getError());
            return false;
        }

        $countryId = $countryObj->getMainTableRecordId();

        $countryLangDatatoSave = array(
            'countrylang_lang_id' => $langId,
            'countrylang_country_id' => $countryId,
            'country_name' => $countryName
        );
       

        if (!$countryObj->updateLangData($langId, $countryLangDatatoSave)) {
            print_r($countryObj->getError());
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
            return false;
        }

        $stateId = $statesObj->getMainTableRecordId();
        
        $stateLangDatatoSave = array(
            'statelang_lang_id' => $lang_id,
            'statelang_state_id' => $stateId,
            'state_name' => $stateName
        );

        if (!$statesObj->updateLangData($langId, $stateLangDatatoSave)) {
            return false;
        }
        
        return $stateId;
    }

    /**
     * getActivatedServiceId
     *
     * @return int
     */
    public static function getActivatedServiceId(): int
    {   
        /*
        if (1 > $this->activedServiceId) {
            $pluginObj = new Plugin();
            $this->activedServiceId = (int) $pluginObj->getDefaultPluginData(Plugin::TYPE_DATA_MIGRATION, 'plugin_id');
        }
        return $this->activedServiceId;
        
         * 
         */
        
        $pluginObj = new Plugin();
        return (int) $pluginObj->getDefaultPluginData(Plugin::TYPE_DATA_MIGRATION, 'plugin_id');
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
}
