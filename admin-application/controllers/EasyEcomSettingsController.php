<?php

class EasyEcomSettingsController extends MarketplaceChannelsSettingsController
{
    public static function getConfigurationKeys()
    {
        return [
            'easyecom_token' => [
                'type' => PluginSetting::TYPE_STRING,
                'required' => true,
                'label' => "EasyEcom Token",
            ],
            'auth_token' => [
                'type' => PluginSetting::TYPE_STRING,
                'required' => false,
                'label' => "Auth Token",
            ]
        ];
    }
}
