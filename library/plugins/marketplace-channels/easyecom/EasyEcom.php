<?php
require_once dirname(__FILE__) . '/autoload.php';

class EasyEcom extends MarketplaceChannelsBase
{
    public const KEY_NAME = __CLASS__;
    
    public $requiredKeys = ['easyecom_token'];
    private $authToken;
    private $reqAuthToken;
    private $easyEcomToken;
    private $db;

    use ApiAuthToken;
    use ApiProducts;
    use ApiOrders;

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
        $this->reqAuthToken = $reqAuthToken;
        if (false === $this->validateRequest($action)) {
            return false;
        }
        return true;
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
        if (empty($this->reqAuthToken) || $this->reqAuthToken != $this->settings['auth_token']) {
            $this->error = Labels::getLabel("MSG_UNAUTHORIZED_ACCESS", $this->langId);
            return false;
        }
        return true;
    }
}
