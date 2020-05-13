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
        $authTokenAge = $this->settings['auth_token_age'];

        $this->reqAuthToken = bin2hex(openssl_random_pseudo_bytes(20));
        $userObj = new User($this->userId);
        if (false !== $userObj->updateUserMeta('seller_auth_token', $this->reqAuthToken)) {
            $userObj->updateUserMeta($this->reqAuthToken, strtotime("+" . $authTokenAge . " day"));
            return true;
        }
        return false;
    }

    private function getAuthTokenDetail(): array
    {
        return current(User::getUserMetaDetail($this->reqAuthToken));
    }

    /**
     * getAuthToken
     * 
     * @param string $authToken 
     * @return array
     */
    public function getAuthToken(string $authToken): array
    {
        $this->reqAuthToken = $authToken;
        $data = $this->getAuthTokenDetail();
        if (empty($data)) {
            $this->error = Labels::getLabel('MSG_INVALID_USER', $this->langId);
            return $this->formatOutput(false, $this->error);
        }
        $this->userId = $data['usermeta_user_id'];
        $expirationTime = $data['usermeta_value'];

        if (time() >= $expirationTime) {
            if (!User::deleteUserMeta($this->reqAuthToken, $this->error)) {
                return $this->formatOutput(false, $this->error);
            }
            if (false === $this->createAuthToken()) {
                return $this->formatOutput(false, $this->error);
            }
        }
        $msg = Labels::getLabel("MSG_SUCCESS", $this->langId);
        return $this->formatOutput(true, $msg, ['authToken' => $this->reqAuthToken]);
    }
}