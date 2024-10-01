<?php

use PayPal\Http\PayPalClient;
use PayPal\Http\Environment\SandboxEnvironment;
use PayPal\Http\Environment\ProductionEnvironment;
use PayPal\Checkout\Orders\AmountBreakdown;
use PayPal\Checkout\Orders\Order;
use PayPal\Checkout\Orders\ApplicationContext;
use PayPal\Checkout\Orders\PurchaseUnit;
use PayPal\Checkout\Requests\OrderCreateRequest;
use PayPal\Checkout\Requests\OrderCaptureRequest;
use PayPal\Checkout\Requests\OrderShowRequest;

class Paypal extends PaymentMethodBase
{
    public const KEY_NAME = __CLASS__;
    public const CREATE_ORDER = 1;
    public const CAPTURE_ORDER = 2;
    public const VALIDATE_PAYMENT_REQUEST = 3;

    public $requiredKeys = [
        'client_id',
        'secret_key',
    ];
    private $clientId = '';
    private $secretKey = '';
    private $resp;

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
    private function requiredKeys(): void
    {
        $environment = FatUtility::int($this->getKey('env'));
        if (0 < $environment) {
            $this->requiredKeys = [
                'live_client_id',
                'live_secret_key',
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

        $live = (0 < $this->settings['env']) ? 'live_' : '';
        $this->clientId = $this->settings[$live . 'client_id'];
        $this->secretKey = $this->settings[$live . 'secret_key'];

        return true;
    }


    private function getClientObject(): PayPalClient
    {
        $envoirmentObject = new SandboxEnvironment($this->clientId, $this->secretKey);
        if ($this->settings['env'] > 0) {
            $envoirmentObject = new ProductionEnvironment($this->clientId, $this->secretKey);
        }

        return new PayPalClient($envoirmentObject);
    }

    private function orderCreateRequest(array $data): OrderCreateRequest
    {
        $currency_code = $data['currency_code'];
        $value = $data['value'];

        $applicationContext = ApplicationContext::create();
        $applicationContext->setReturnUrl($data['return_url']);
        $applicationContext->setCancelUrl($data['cancel_url']);

        $purchaseUnit = new PurchaseUnit(AmountBreakdown::of($value, $currency_code));
        $order = (new Order())->addPurchaseUnit($purchaseUnit);
        $order->setApplicationContext($applicationContext);

        return (new OrderCreateRequest($order));
    }

    /**
     * createOrder - Create paypal order
     *
     * @param  int $orderId
     * @return bool
     */
    public function createOrder(int $orderId): bool
    {
        $data = $this->buildRequestBody($orderId);
        return $this->doRequest(self::CREATE_ORDER, $data);
    }

    /**
     * captureOrder
     *
     * @param  mixed $paypalOrderId
     * @return bool
     */
    public function captureOrder($paypalOrderId): bool
    {
        if (empty($paypalOrderId)) {
            return false;
        }

        return $this->doRequest(self::CAPTURE_ORDER, $paypalOrderId);
    }

    /**
     * getResponse
     *
     * @return array
     */
    public function getResponse(bool $decodeJson = true): array
    {
        if ($decodeJson) {
            return json_decode($this->resp->getBody()->getContents(), true);
        }

        return $this->resp;
    }

    /**
     * buildRequestBody
     *
     * @param  int $orderId
     * @return array
     */
    private function buildRequestBody(int $orderId): array
    {
        $orderPaymentObj = new OrderPayment($orderId, $this->langId);
        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();

        $cancelBtnUrl = CommonHelper::getPaymentCancelPageUrl();
        if (Orders::ORDER_WALLET_RECHARGE == $orderInfo['order_type']) {
            $cancelBtnUrl = CommonHelper::getPaymentFailurePageUrl();
        }
        return [
            "currency_code" => $this->systemCurrencyCode,
            "value" =>  number_format((float)$paymentAmount, 2, '.', ''),
            "cancel_url" => $cancelBtnUrl,
            "return_url" => UrlHelper::generateFullUrl('PayPalPay', "callback", [$orderId])
        ];
    }

    /**
     * validatePaymentRequest
     *
     * @param  string $paypalOrderId
     * @param  string $currencyCode
     * @param  float $totalAmount
     * @return bool
     */
    public function validatePaymentRequest(string $paypalOrderId, string $currencyCode, float $totalAmount): bool
    {
        if (!empty(Orders::isExistTransactionId($paypalOrderId))) {
            $this->error = Labels::getLabel('ERR_INVALID_TXN_REQUEST._THIS_TRANSACTION_ALREADY_PROCESSED', $this->langId);
            return false;
        }

        $request = $this->doRequest(self::VALIDATE_PAYMENT_REQUEST, $paypalOrderId);
        if (false === $request) {
            return false;
        }
        $result = $this->getResponse();
        if ('COMPLETED' != $result['status'] || 'CAPTURE' != $result['intent']) {
            $this->error = Labels::getLabel('ERR_THIS_TXN_NOT_YET_CAPTURED/_COMPLETED', $this->langId);
            return false;
        }
        $purchaseUnit = isset($result['purchase_units']) ? current($result['purchase_units']) : [];
        $capturePayment = isset($purchaseUnit['payments']['captures']) ? current($purchaseUnit['payments']['captures']) : [];
        if (empty($capturePayment)) {
            $this->error = Labels::getLabel('ERR_SOMETHING_WENT_WRONG._INVALID_CAPTURE_RESPONSE.', $this->langId);
            return false;
        }

        $amountArr = $capturePayment['amount'] ?? [];

        $paidCurrency = isset($amountArr['currency_code']) ? $amountArr['currency_code'] : '';
        $paidAmount = isset($amountArr['value']) ? $amountArr['value'] : [];
        $payeeEmail = $purchaseUnit['payee']['email_address'];

        if ($currencyCode != $paidCurrency) {
            $this->error = Labels::getLabel('ERR_INVALID_CURRENCY.', $this->langId);
            return false;
        }

        if ($totalAmount != $paidAmount) {
            $this->error = Labels::getLabel('ERR_INVALID_PAID_AMOUNT.', $this->langId);
            return false;
        }

        if ($this->settings['payee_email'] != $payeeEmail) {
            $this->error = Labels::getLabel('ERR_INVALID_MERCHANT.', $this->langId);
            return false;
        }

        return true;
    }

    /**
     * Handle errors and set the error message
     *
     * @param Exception $e
     */
    private function handleError(Exception $e): bool
    {
        $msg = LibHelper::isJson($e->getMessage()) ? json_decode($e->getMessage(), true) : $e->getMessage();
        $this->error = $msg;
        return false;
    }

    /**
     * doRequest
     *
     * @param int $requestType
     * @param mixed $request
     * @return bool
     */
    private function doRequest(int $requestType, $request): bool
    {
        try {
            switch ($requestType) {
                case self::CREATE_ORDER:
                    $requestBody = $this->orderCreateRequest($request);
                    break;
                case self::CAPTURE_ORDER:
                    $requestBody = new OrderCaptureRequest($request);
                    break;
                case self::VALIDATE_PAYMENT_REQUEST:
                    $requestBody = new OrderShowRequest($request);
                    break;
            }

            $client = $this->getClientObject();
            $this->resp = $client->send($requestBody);
            return true;
        } catch (HttpException $e) {
            return $this->handleError($e);
        } catch (InvalidArgumentException $e) {
            return $this->handleError($e);
        } catch (\Exception $e) {
            return $this->handleError($e);
        } catch (\Error $e) {
            return $this->handleError($e);
        }
    }
}
