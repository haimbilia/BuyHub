<?php

/**
 * Payfast - Services in South Africa
 * API's reference https://developers.payfast.co.za/docs
 */
class Payfast extends PaymentMethodBase
{
    public const KEY_NAME = __CLASS__;
    public const PRODUCTION_URL = 'https://payfast.co.za/eng/process';
    public const SANDBOX_URL = 'https://sandbox.payfast.co.za/eng/process';

    public $requiredKeys = [
        'passphrase',
        'merchant_id',
        'merchant_key',
    ];
    private $env = Plugin::ENV_SANDBOX;
    private $response = '';
    private $passphrase = '';
    private $signature = '';
    private $merchantId = '';
    private $merchantKey = '';
    private $actionUrl = '';
    private $requestBody = [];

    /**
     * __construct
     *
     * @param  int $langId
     * @return void
     */
    public function __construct(int $langId)
    {
        $this->langId = 0 < $langId ? $langId : CommonHelper::getLangId();
        $this->requiredKeys();
    }

    /**
     * requiredKeys
     *
     * @return void
     */
    public function requiredKeys()
    {
        $this->env = FatUtility::int($this->getKey('env'));
        if (0 < $this->env) {
            $this->requiredKeys = [
                'passphrase',
                'live_merchant_id',
                'live_merchant_key',
            ];
        }
    }

    /**
     * init
     *
     * @param  int $userId
     * @return bool
     */
    public function init(int $userId): bool
    {
        if (false == $this->validateSettings()) {
            return false;
        }

        if (false === $this->loadBaseCurrencyCode()) {
            return false;
        }

        if (0 < $userId) {
            if (false === $this->loadLoggedUserInfo($userId)) {
                return false;
            }
        }

        if (false === $this->loadSignature()) {
            return false;
        }

        $this->passphrase = $this->settings['passphrase'];
        $this->merchantId = Plugin::ENV_PRODUCTION == $this->settings['env'] ? $this->settings['live_merchant_id'] : $this->settings['merchant_id'];
        $this->merchantKey = Plugin::ENV_PRODUCTION == $this->settings['env'] ? $this->settings['live_merchant_key'] : $this->settings['merchant_key'];
        $this->actionUrl = Plugin::ENV_PRODUCTION == $this->settings['env'] ? self::PRODUCTION_URL : self::SANDBOX_URL;
        return true;
    }

    /**
     * getPassphrase
     *
     * @return string
     */
    public function getPassphrase(): string
    {
        return (string)$this->passphrase;
    }

    /**
     * getmerchantId
     *
     * @return string
     */
    public function getmerchantId(): string
    {
        return (string)$this->merchantId;
    }

    /**
     * getMerchantKey
     *
     * @return string
     */
    public function getMerchantKey(): string
    {
        return (string)$this->merchantKey;
    }

    /**
     * getActionUrl
     *
     * @return string
     */
    public function getActionUrl(): string
    {
        return (string)$this->actionUrl;
    }

    /**
     * getSignature
     *
     * @return string
     */
    public function getSignature(): string
    {
        return (false === $this->loadSignature() ? "" : (string)$this->signature);
    }

    /**
     * loadSignature
     *
     * @return bool
     */
    private function loadSignature(): bool
    {
        if (empty($this->settings['signature'])) {
            $this->signature = $this->settings['signature'];
            return true;
        }

        $signatureData = [
            'merchant-id' => $this->getmerchantId(),
            'passphrase' => $this->getPassphrase(),
            'timestamp' => time(),
            'version' => preg_replace('/[^a-zA-Z0-9]+/', '_', CONF_WEB_APP_VERSION)
        ];
        ksort($signatureData);
        $signature = md5(http_build_query($signatureData));

        if (false === $this->updateSettings($this->settings["plugin_id"], ['signature' => $signature], $this->error)) {
            return false;
        }
        $this->signature = $signature;
        return true;
    }

    /**
     * buildRequestBody
     *
     * @param  string $orderId
     * @return bool
     */
    public function buildRequestBody(string $orderId): bool
    {
        $orderPaymentObj = new OrderPayment($orderId, $this->langId);
        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();
        $customerEmail = !isset($orderInfo['customer_email']) || empty($orderInfo['customer_email']) ? $this->userData['credential_email'] : $orderInfo['customer_email'];

        $this->requestBody = array(
            'merchant_id' => $this->getmerchantId(),
            'merchant_key' => $this->getMerchantKey(),
            'signature' => $this->getSignature(),
            'return_url' => CommonHelper::generateFullUrl(self::KEY_NAME . 'Pay', 'paymentSuccess', [$orderId]),
            'cancel_url' => CommonHelper::generateFullUrl('Custom', 'paymentFailed', [$orderId]),
            'notify_url' => CommonHelper::generateFullUrl(self::KEY_NAME . 'Pay', 'callback', [$orderId]),
            'name_first' => $this->userData['user_name'],
            'email_address' => $customerEmail,
            'm_payment_id' => $orderId,
            'amount' => number_format(sprintf('%.2f', $paymentAmount), 2, '.', ''),
            'item_name' => "Order #" . $orderId
        );
        return true;
    }

    /**
     * getRequestBody
     *
     * @return array
     */
    public function getRequestBody(): array
    {
        return $this->requestBody;
    }
}
