<?php

trait ApiAuthToken
{
	/**
     * createAuthToken
     * 
     * @return bool
     */
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

    /**
     * getAuthToken
     * 
     * @param string $easyEcomToken 
     * @return array
     */
    public function getAuthToken(): array
    {
        if (isset($this->settings['auth_token']) && !empty($this->settings['auth_token'])) {
            $this->authToken = $this->settings['auth_token'];
        } else if (false === $this->createAuthToken()) {
            return $this->formatOutput(false, $this->error);
        }

        $msg = Labels::getLabel("MSG_SUCCESS", $this->langId);
        return $this->formatOutput(true, $msg, ['authToken' => $this->authToken]);
    }
}