<?php

class FcmPushNotificationSettingsController extends PushNotificationSettingsController
{
    public static function getConfigurationKeys()
    {
        $htmlAfterField = '<div class="m-4">' . Extrapage::getFirebaseServiceAccountSteps(CommonHelper::getLangId()) . '</div>';
        return [
            'firebase_service_account_json_key' => [
                'type' => PluginSetting::TYPE_TEXTAREA,
                'label' => Labels::getLabel('FRM_FIREBASE_SERVICE_ACCOUNT_PRIVATE_KEY_JSON'),
                'required' => true,
                'htmlAfterField' => $htmlAfterField
            ]
        ];
    }
}
