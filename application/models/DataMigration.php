<?php

class DataMigration
{
    public const TYPE_CATEGORY = 1;
    public const TYPE_PRODUCT = 2;
    public const TYPE_USER = 3;
    
    public function sync()
    {
        $langId = 1;
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
            
            print_r($users);
        }
    }
    
    public function syncUsers(){
        
    }

    /**
     * getActivatedServiceId
     *
     * @return int
     */
    public static function getActivatedServiceId(): int
    {
        $pluginObj = new Plugin();
        return (int) $pluginObj->getDefaultPluginData(Plugin::TYPE_DATA_MIGRATION, 'plugin_id');
    }
    
    public static function getSyncType()
    {
        $langId = FatUtility::convertToType($langId, FatUtility::VAR_INT);
        return array(
            self::TYPE_CATEGORIES => Labels::getLabel('LBL_CATEGORIES', $langId),
            self::TYPE_PRODUCTS => Labels::getLabel('LBL_PRODUCTS', $langId),
            self::TYPE_USER => Labels::getLabel('LBL_USERS', $langId),
        );
    }
}
