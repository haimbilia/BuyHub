<?php

class ShopifySettingsController extends DataMigrationSettingsController
{
    public static function getConfigurationKeys($langId)
    {
        return [
            'shop_url' => [
                'type' => PluginSetting::TYPE_STRING,
                'required' => true,
                'label' => Labels::getLabel('LBL_SHOP_URL', $langId),
            ],           
            'password' => [
                'type' => PluginSetting::TYPE_STRING,
                'required' => true,
                'label' => Labels::getLabel('LBL_PASSWORD', $langId),
            ],
        ];
    }

}
