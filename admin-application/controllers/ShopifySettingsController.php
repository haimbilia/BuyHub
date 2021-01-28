<?php

class ShopifySettingsController extends DataMigrationSettingsController
{

    public static function getConfigurationKeys()
    {
        return [
            'shop_url' => [
                'type' => PluginSetting::TYPE_STRING,
                'required' => true,
                'label' => "Shop Url",
            ],
            'api_key' => [
                'type' => PluginSetting::TYPE_STRING,
                'required' => true,
                'label' => "API key",
            ],
            'password' => [
                'type' => PluginSetting::TYPE_STRING,
                'required' => true,
                'label' => "Password",
            ]
        ];
    }

}
