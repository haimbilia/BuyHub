<?php

class DataMigration
{
    
    public const TYPE_CATEGORY = 1;
    public const TYPE_PRODUCT = 2;       
    
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
            $products = $migrationApi->getProducts();
            
            print_r($products);
        }
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
}
