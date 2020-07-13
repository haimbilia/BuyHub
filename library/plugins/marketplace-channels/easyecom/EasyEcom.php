<?php
require_once dirname(__FILE__) . '/autoload.php';

class EasyEcom extends MarketplaceChannelsBase
{
    public const KEY_NAME = __CLASS__;
    
    public $requiredKeys = [
        'easyecom_token',
        'auth_token_age'
    ];

    use ApiAuthToken;
    use ApiProducts;
    use ApiOrders;

    private $authToken;
    private $reqAuthToken;
    private $easyEcomToken;
    private $db;
    private $userId;

    public function __construct(int $langId)
    {
        $this->langId = FatUtility::int($langId);
        if (1 > $this->langId) {
            $this->langId = CommonHelper::getLangId();
        }
    }

    /**
     * init
     * 
     * @param string $action 
     * @param string $reqAuthToken 
     * @return void
     */
    public function init(string $action, string $reqAuthToken): bool
    {
        if (false === $this->validateSettings($this->langId)) {
            return false;
        }

        if (true === MOBILE_APP_API_CALL) {
            $this->reqAuthToken = $reqAuthToken;
            if (false === $this->validateRequest($action)) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * getKeys
     *
     * @return mixed
     */
    public function getKeys(string $column)
    {
        return isset($this->settings[$column]) ? $this->settings[$column] : $this->settings;
    }

    /**
     * validateRequest - To validate token request.
     * 
     * @param string $action 
     * @return void
     */
    private function validateRequest(string $action)
    {
        switch ($action) {
            case 'getAuthToken':
                return $this->validateEecRequest();
                break;
            
            default:
                return $this->validateAuthRequest();
                break;
        }
    }


    /**
     * validateEecRequest - To validate getAuthToken request comming from EasyEcom.
     * 
     * @return bool
     */
    private function validateEecRequest(): bool
    {
        if (empty($this->reqAuthToken) || $this->reqAuthToken != $this->settings['easyecom_token']) {
            $this->error = Labels::getLabel("MSG_UNAUTHORIZED_ACCESS", $this->langId);
            return false;
        }
        $this->easyEcomToken = $_SERVER['HTTP_EEC_TOKEN'];
        return true;
    }

    /**
     * validateAuthRequest - To validate GET request comming from EasyEcom.
     * 
     * @return bool
     */
    private function validateAuthRequest(): bool
    {
        $data = $this->getAuthTokenDetail();
        if (empty($data)) {
            $this->error = Labels::getLabel('MSG_INVALID_USER', $this->langId);
            return false;
        }

        $this->userId = $data['usermeta_user_id'];
        $expirationTime = $data['usermeta_value'];
        if (time() >= $expirationTime) {
            $this->error = Labels::getLabel("MSG_AUTH_TOKEN_EXPIRED", $this->langId);
            return false;
        }
        return true;
    }
}
