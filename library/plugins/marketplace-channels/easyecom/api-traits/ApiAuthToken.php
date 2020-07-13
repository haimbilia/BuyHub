<?php

trait ApiAuthToken
{    
    /**
     * createAuthToken
     *
     * @param  int $userId
     * @return bool
     */
    public function createAuthToken(int $userId): bool
    {
        $authTokenAge = $this->settings['auth_token_age'];

        $userData = User::getUserMeta($userId);
        if (!empty($userData['seller_auth_token']) && isset($userData[$userData['seller_auth_token']]) && time() < $userData[$userData['seller_auth_token']]) {
            return true;
        }

        $this->reqAuthToken = bin2hex(openssl_random_pseudo_bytes(20));
        $userObj = new User($userId);
        if (false !== $userObj->updateUserMeta('seller_auth_token', $this->reqAuthToken)) {
            $userObj->updateUserMeta($this->reqAuthToken, strtotime("+" . $authTokenAge . " day"));
            return true;
        }
        $this->error = $userObj->getError();
        return false;
    }

    /**
     * getAuthTokenDetail
     * 
     * @return array
     */
    private function getAuthTokenDetail(): array
    {
        $data = current(User::getUserMetaDetail($this->reqAuthToken));
        if (empty($data)) {
            return [];
        }
        return $data;
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
            
            if (false === $this->createAuthToken($this->userId)) {
                return $this->formatOutput(false, $this->error);
            }
        }
        $msg = Labels::getLabel("MSG_SUCCESS", $this->langId);
        return $this->formatOutput(true, $msg, ['authToken' => $this->reqAuthToken]);
    }
}