<?php
require_once dirname(__FILE__) . '/autoload.php';

class EasyEcom extends MarketplaceChannelsBase
{
    public const KEY_NAME = __CLASS__;
    public const API = [
        'getProducts',
        'getOrders',
        'updateStockQty',
        'getShippedOrderCarrierDetail',
        'getOrderStatus',
        'markOrderAsShipped',
    ];

    public $requiredKeys = ['easyecom_token'];

    use ApiProducts;
    use ApiOrders;

    private $authToken;
    private $reqAuthToken;
    private $db;

    public function __construct(int $langId, string $action, int $userId)
    {
        $this->langId = FatUtility::int($langId);
        if (1 > $this->langId) {
            $this->langId = CommonHelper::getLangId();
        }
        $this->userId = $userId;

        if (in_array($action, self::API)) {
            $autoSyncStatus = User::getUserMeta($this->userId, 'easyEcomSyncingStatus');
            $autoSyncStatus = empty($autoSyncStatus) ? Plugin::INACTIVE : Plugin::ACTIVE;
            if (Plugin::INACTIVE == $autoSyncStatus) {
                $msg = '<p>'. Labels::getLabel('MSG_AUTO_SYNC_IS_NOT_ENABLED', $this->langId) . '</p>';
                $resp = $this->formatOutput($autoSyncStatus, $msg, [], Plugin::RC_UNAUTHORIZED);
                $this->dieWithJsonResponse($resp);
            }
        }
    }
}
