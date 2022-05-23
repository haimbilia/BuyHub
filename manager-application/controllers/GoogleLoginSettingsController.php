<?php

class GoogleLoginSettingsController extends SocialLoginSettingsController
{
    public static function getConfigurationKeys()
    {
        return [
            'developer_key' => [
                'type' => PluginSetting::TYPE_STRING,
                'required' => true,
                'label' => "API Key",
            ],
            'client_id' => [
                'type' => PluginSetting::TYPE_STRING,
                'required' => true,
                'label' => "Client ID",
            ],
            'client_secret' => [
                'type' => PluginSetting::TYPE_STRING,
                'required' => true,
                'label' => "Client Secret",
            ],
        ];
    }
}
