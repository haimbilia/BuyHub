<?php

use Google\Client as GoogleClient;

class FcmPushNotification extends PushNotificationBase
{
    public const KEY_NAME = __CLASS__;
    private const PRODUCTION_URL = 'https://fcm.googleapis.com/fcm/send';
    public const LIMIT = 1000;

    private $deviceTokens;

    public $requiredKeys = ['firebase_service_account_json_key'];

    /**
     * __construct
     *
     * @param int $langId
     * @return void
     */
    public function __construct(int $langId)
    {
        $this->langId = $langId;
    }

    /**
     * setDeviceTokens
     *
     * @param  array $deviceTokens
     * @return void
     */
    public function setDeviceTokens(array $deviceTokens): void
    {
        $this->deviceTokens = $deviceTokens;
    }

    /**
     * notify
     *
     * @param  string $title
     * @param  string $message
     * @param  int $os
     * @param  array $data
     * @return array
     */
    public function notify(string $title, string $message, int $os, array $data = []): array
    {
        if (false === $this->validateSettings($this->langId)) {
            return $this->formatOutput(Plugin::RETURN_FALSE, $this->error);
        }

        if (empty($this->deviceTokens) || 1000 < count($this->deviceTokens)) {
            $this->error = Labels::getLabel('ERR_ARRAY_MUST_CONTAIN_AT_LEAST_1_AND_AT_MOST_1000_REGISTRATION_TOKENS', $this->langId);
            return $this->formatOutput(Plugin::RETURN_FALSE, $this->error);
        }

        if (empty($title) || empty($message)) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->langId);
            return $this->formatOutput(Plugin::RETURN_FALSE, $this->error);
        }

        $config = json_decode($this->settings['firebase_service_account_json_key'], true);
        if (json_last_error() !== JSON_ERROR_NONE &&  $config['project_id'] == '') {
            $this->error = Labels::getLabel('ERR_INVALID_JSON_KEY_FORMAT', $this->langId);
            return $this->formatOutput(Plugin::RETURN_FALSE, $this->error);
        }
        
        foreach ($this->deviceTokens as $deviceToken) {
            if (empty($deviceToken)) {
                continue;
            }
            $Notificationdata = [
                'title' => $title,
                'text' => $message,
                'image' => ($data['image'] ?? ''),
                'type' => ''
            ];
            Notifications::sendPushNotification($config, $deviceToken, $os, $Notificationdata);
        }
        return $this->formatOutput(Plugin::RETURN_TRUE, Labels::getLabel('MSG_SUCCESS', $this->langId));
    }

    /**
     * validateKeys
     *
     * @param  array $keys
     * @return bool
     */
    public function validateKeys(array $keys): bool
    {
        $keys['plugin_active'] = Plugin::ACTIVE;
        $this->settings = $keys;
        $this->setDeviceTokens(['ABC']);

        return ($this->notify('test', 'test', User::DEVICE_OS_ANDROID))['status'] === 1;
    }
}
