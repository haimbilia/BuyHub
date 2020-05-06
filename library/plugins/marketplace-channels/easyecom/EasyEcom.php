<?php

class EasyEcom extends MarketplaceChannelsBase
{
    public const KEY_NAME = __CLASS__;
    
    public $requiredKeys = ['easyecom_token'];
    private $authToken;
    private $easyEcomToken;

    public function __construct($langId)
    {
        $this->langId = FatUtility::int($langId);
        if (1 > $this->langId) {
            $this->langId = CommonHelper::getLangId();
        }
        if (false == $this->validateSettings($langId)) {
            return false;
        }
    }

    public function getAuthToken(string $easyEcomToken): array
    {
        $this->easyEcomToken = $easyEcomToken;
        if (!isset($this->settings['easyecom_token']) || empty($this->settings['easyecom_token']) || $this->easyEcomToken != $this->settings['easyecom_token']) {
            $msg = Labels::getLabel("MSG_UNAUTHORIZED_ACCESS", $this->langId);
            return $this->formatOutput(false, $msg);
        }

        if (isset($this->settings['auth_token']) && !empty($this->settings['auth_token'])) {
            $this->authToken = $this->settings['auth_token'];
        } else {
            if (false === $this->createAuthToken()) {
                return $this->formatOutput(false, $this->error);       
            }
        }

        $msg = Labels::getLabel("MSG_SUCCESS", $this->langId);
        return $this->formatOutput(true, $msg, ['authToken' => $this->authToken]);
    }

    private function createAuthToken(): bool
    {
        $this->authToken = bin2hex(openssl_random_pseudo_bytes(20));
        $data = [
            'easyecom_token' => $this->easyEcomToken,
            'auth_token' => $this->authToken
        ];
        $pluginSetting = new PluginSetting(0, self::KEY_NAME);
        if (false === $pluginSetting->save($data)) {
            $this->error = $pluginSetting->getError();
            return false;
        }
        return true;
    } 
}
