<?php
require_once dirname(__FILE__) . '/autoload.php';

class EasyEcom extends MarketplaceChannelsBase
{
    public const KEY_NAME = __CLASS__;
    
    public $requiredKeys = [
        'easyecom_token',
        'auth_token_age'
    ];

    use ApiProducts;
    use ApiOrders;

    private $authToken;
    private $reqAuthToken;
    private $db;
    private $userId;

    public function __construct(int $langId)
    {
        $this->langId = FatUtility::int($langId);
        if (1 > $this->langId) {
            $this->langId = CommonHelper::getLangId();
        }
        $this->userId = UserAuthentication::getLoggedUserId(true);
    }
    
    /**
     * getKeys
     *
     * @return mixed
     */
    public function getKeys(string $column = '')
    {
        return isset($this->settings[$column]) ? $this->settings[$column] : $this->settings;
    }
}
