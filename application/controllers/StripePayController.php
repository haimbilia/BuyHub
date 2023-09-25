<?php

require_once CONF_INSTALLATION_PATH . 'library/payment-plugins/stripe/init.php';
class StripePayController extends PaymentController
{
    public const KEY_NAME = 'Stripe';

    private $error = false;
    private $paymentUrl = '';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->init();
    }

    protected function allowedCurrenciesArr()
    {
        return [
            'USD', 'AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN', 'BIF',
            'BMD', 'BND', 'BOB', 'BRL', 'BSD', 'BWP', 'BZD', 'CAD', 'CDF', 'CHF', 'CLP', 'CNY', 'COP', 'CRC', 'CVE', 'CZK',
            'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ETB', 'EUR', 'FJD', 'FKP', 'GBP', 'GEL', 'GIP', 'GMD', 'GNF', 'GTQ', 'GYD',
            'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS', 'INR', 'ISK', 'JMD', 'JPY', 'KES', 'KGS', 'KHR', 'KMF', 'KRW',
            'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'MAD', 'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MRO', 'MUR',
            'MVR', 'MWK', 'MXN', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR',
            'PLN', 'PYG', 'QAR', 'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SEK', 'SGD', 'SHP', 'SLL', 'SOS', 'SRD',
            'STD', 'SZL', 'THB', 'TJS', 'TOP', 'TRY', 'TTD', 'TWD', 'TZS', 'UAH', 'UGX', 'UYU', 'UZS', 'VND', 'VUV', 'WST',
            'XAF', 'XCD', 'XOF', 'XPF', 'YER', 'ZAR', 'ZMW'
        ];
    }

    protected function minChargeAmountCurrencies()
    {
        return [
            'USD' => 0.50, 'AED' => 2.00, 'AUD' => 0.50, 'BGN' => 1.00, 'BRL' => 0.50, 'CAD' => 0.50, 'CHF' => 0.50, 'CZK' => 15.00,
            'DKK' => 2.50, 'EUR' => 0.50, 'GBP' => 0.30, 'HKD' => 4.00, 'HUF' => 175.00, 'INR' => 0.50, 'JPY' => 50, 'MXN' => 10,
            'MYR' => 2, 'NOK' => 3.00, 'NZD' => 0.50, 'PLN' => 2.00, 'RON' => 2.00, 'SEK' => 3.00, 'SGD' => 0.50
        ];
    }

    protected function zeroDecimalCurrencies()
    {
        return [
            'BIF', 'CLP', 'DJF', 'GNF', 'JPY', 'KMF', 'KRW', 'MGA', 'PYG', 'RWF', 'UGX', 'VND', 'VUV', 'XAF', 'XOF', 'XPF'
        ];
    }

    private function init(): void
    {
        if (false === $this->plugin->validateSettings($this->siteLangId)) {
            $this->setErrorAndRedirect($this->plugin->getError(), FatUtility::isAjaxCall());
        }

        $this->settings = $this->plugin->getSettings();
    }

    public function charge($orderId)
    {
        if (empty(trim($orderId))) {
            $message = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            $this->setErrorAndRedirect($message, FatUtility::isAjaxCall());
        }

        $stripe = array(
            'secret_key' => $this->settings['privateKey'],
            'publishable_key' => $this->settings['publishableKey']
        );
        $this->set('stripe', $stripe);

        if (!isset($this->settings['privateKey']) && !isset($this->settings['publishableKey'])) {
            $message = Labels::getLabel('STRIPE_INVALID_PAYMENT_GATEWAY_SETUP_ERROR', $this->siteLangId);
            $this->setErrorAndRedirect($message, FatUtility::isAjaxCall());
        }

        if (strlen(trim($this->settings['privateKey'])) > 0 && strlen(trim($this->settings['publishableKey'])) > 0) {
            if (strpos($this->settings['privateKey'], 'test') !== false || strpos($this->settings['publishableKey'], 'test') !== false) {
            }
            \Stripe\Stripe::setApiKey($stripe['secret_key']);
        } else {
            $this->error = Labels::getLabel('STRIPE_INVALID_PAYMENT_GATEWAY_SETUP_ERROR', $this->siteLangId);
        }

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();

        if (array_key_exists($this->systemCurrencyCode, $this->minChargeAmountCurrencies())) {
            $stripeMinAmount = $this->minChargeAmountCurrencies()[$this->systemCurrencyCode];
            if ($stripeMinAmount > $paymentAmount) {
                $this->error = CommonHelper::replaceStringData(Labels::getLabel('ERR_MINIMUM_STRIPE_CHARGE_AMOUNT_IS_{MIN-AMOUNT}', $this->siteLangId), ['{MIN-AMOUNT}' => $stripeMinAmount]);
            }
        }
        $processRequest = false;
        if (!$orderInfo['id']) {
            $message = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            $this->setErrorAndRedirect($message, FatUtility::isAjaxCall());
        } elseif ($orderInfo && $orderInfo["order_payment_status"] == Orders::ORDER_PAYMENT_PENDING) {
            $frm = $this->getPaymentForm($orderId);

            $postOrderId = FatApp::getPostedData('orderId', FatUtility::VAR_STRING, '');

            if (!empty($postOrderId) && $orderId = $postOrderId) {
                $charge = $this->stripeCreateSession($orderId);
                if (isset($charge['id']) && !empty($charge['id'])) {
                    $json['redirectUrl'] = $charge['url'];
                    FatUtility::dieJsonSuccess($json);
                } else {
                    $msg = Labels::getLabel("MSG_UNABLE_TO_INITIALIZE_PAYMENT_REQUEST._PAYMENT_CANNOT_BE_COMPLETED.", $this->siteLangId);
                    $this->setErrorAndRedirect($msg, FatUtility::isAjaxCall());
                }
            } else if (strtolower($_SERVER['REQUEST_METHOD']) == 'post' && !FatUtility::isAjaxCall()) {
                $charge = $this->stripeCreateSession($orderId);
                if (isset($charge['id']) && !empty($charge['id'])) {
                    FatApp::redirectUser($charge['url']);
                } else {
                    $this->error = Labels::getLabel('MSG_UNABLE_TO_INITIALIZE_PAYMENT_REQUEST._PAYMENT_CANNOT_BE_COMPLETED.', $this->siteLangId);
                }
            }
        } else {
            $message = Labels::getLabel('ERR_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($message);
            }
            $this->error = $message;
        }
        $this->set('paymentAmount', $paymentAmount);
        $this->set('orderInfo', $orderInfo);
        if ($this->error) {
            $this->set('error', $this->error);
        }

        $cancelBtnUrl = CommonHelper::getPaymentCancelPageUrl();
        if ($orderInfo['order_type'] == Orders::ORDER_WALLET_RECHARGE) {
            $cancelBtnUrl = CommonHelper::getPaymentFailurePageUrl();
        }
        $frm->fill(['orderId' => $orderId]);

        $this->set('frm', $frm);
        $this->set('cancelBtnUrl', $cancelBtnUrl);
        $this->set('exculdeMainHeaderDiv', true);
        $this->set('processRequest', $processRequest);
        if (FatUtility::isAjaxCall() && !isset($_POST['chargeAjax'])) {
            $json['html'] = $this->_template->render(false, false, 'stripe-pay/charge-ajax.php', true, false);
            FatUtility::dieJsonSuccess($json);
        }
        $this->_template->render(true, false);
    }

    private function formatPayableAmount($amount = null)
    {
        if ($amount == null) {
            return false;
        }

        if (in_array($this->systemCurrencyCode, $this->zeroDecimalCurrencies())) {
            return round($amount);
        }

        $amount = number_format($amount, 2, '.', '');
        return $amount * 100;
    }

    private function getPaymentForm(string $orderId, bool $processRequest = false): object
    {
        $actionUrl = false === $processRequest ? UrlHelper::generateUrl('StripePay', 'charge', array($orderId)) : $this->paymentUrl;
        $frm = new Form('frmPaymentForm', array('id' => 'frmPaymentForm', 'action' => $actionUrl, 'class' => "form form--normal"));
        $frm->addHiddenField('', 'orderId');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_Pay_Now', $this->siteLangId));

        return $frm;
    }

    private function stripeCreateSession($orderId)
    {
        if (!$this->settings) {
            $this->error = Labels::getLabel('STRIPE_INVALID_PAYMENT_GATEWAY_SETUP_ERROR', $this->siteLangId);
        }

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $paymentAmount = $this->formatPayableAmount($paymentAmount);

        $stripe = array(
            'secret_key' => $this->settings['privateKey'],
            'publishable_key' => $this->settings['publishableKey']
        );

        $this->set('stripe', $stripe);

        if (!empty(trim($this->settings['privateKey'])) && !empty(trim($this->settings['publishableKey']))) {
            \Stripe\Stripe::setApiKey($stripe['secret_key']);
        }

        try {
            if (!empty(trim($this->settings['privateKey'])) && !empty(trim($this->settings['publishableKey']))) {

                $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();
                $orderDetails = [
                    'order_id' => $orderId,
                    'customer_name' => $orderInfo['customer_name'],
                    'email' => $orderInfo['customer_email'],
                    'description' => 'Order ' . $orderId,
                ];

                // Create a new checkout session
                $charge = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [
                        [
                            'price_data' => [
                                'currency' => $this->systemCurrencyCode,
                                'unit_amount' => $paymentAmount,
                                'product_data' => [
                                    'name' => $orderDetails['description'],
                                ],
                            ],
                            'quantity' => 1,
                        ],
                    ],
                    'customer_email' => $orderInfo['customer_email'],
                    'metadata' => $orderDetails,
                    'expires_at' => time() + 3600,
                    'payment_intent_data' => [
                        'receipt_email' => FatApp::getConfig('CONF_SITE_OWNER_EMAIL'),
                        "description" => $orderId
                    ],
                    'mode' => 'payment',
                    'currency' => strtolower($this->systemCurrencyCode),
                    'success_url' => CommonHelper::generateFullUrl('StripePay', 'callback') . '?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => CommonHelper::generateFullUrl('StripePay', 'callback') . '?session_id={CHECKOUT_SESSION_ID}',
                ]);

                return $charge->toArray();
            }
        } catch (Exception $e) {
            $this->error = $e->getMessage();
        }

        if ($this->error) {
            $this->setErrorAndRedirect($this->error, FatUtility::isAjaxCall());
        }
    }

    public function callback()
    {
        $stripe = [
            'secret_key' => $this->settings['privateKey'],
            'publishable_key' => $this->settings['publishableKey']
        ];

        try {
            \Stripe\Stripe::setApiKey($stripe['secret_key']);
            $charge = \Stripe\Checkout\Session::retrieve($_GET['session_id']);
            $charge = $charge->toArray();
        } catch (Error $e) {
        }

        $orderPaymentObj = new OrderPayment($charge['metadata']['order_id'], $this->siteLangId);
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();
        $message = '';

        if (!empty($charge)) {

            $payment_amount = $charge['amount_total'];
            if (!in_array($this->systemCurrencyCode, $this->zeroDecimalCurrencies())) {
                $payment_amount = $payment_amount / 100;
            }

            $message .= 'Transaction Id: ' . (string) $charge['payment_intent'] . "&";
            $message .= 'Object: ' . (string) $charge['object'] . "&";
            $message .= 'Amount: ' . (string) $payment_amount . "&";
            $message .= 'Currency: ' . (string) $charge['currency'] . "&";
            $message .= 'Email: ' . (string) $charge['customer_email'] . "&";
            $message .= 'Payment Status: ' . (string) $charge['payment_status'] . "&";
            $message .= 'Status: ' . (string) $charge['status'] . "&";
            $message .= 'Livemode: ' . (string) $charge['livemode'] . "&";
            $message .= 'Locale: ' . (string) $charge['locale'] . "&";
            $message .= 'Session Id: ' . (string) $charge['id'] . "&";
            $message .= 'Created: ' . (string) date("Y-m-d H:i:s", strtotime($charge['created']));

            if (strtolower($charge['payment_status']) == 'paid') {

                $orderPaymentCharge = $this->formatPayableAmount($orderPaymentObj->getOrderPaymentGatewayAmount());
                $total_paid_match = (string) $charge['amount_total'] == (string) $orderPaymentCharge;

                if ($total_paid_match === false) {
                    $message = "\n\n StripePay_NOTE :: TOTAL PAID MISMATCH! " . strtolower($payment_amount) . "\n\n";
                    $orderPaymentObj->addOrderPaymentComments($message);
                    if (false === MOBILE_APP_API_CALL) {
                        FatApp::redirectUser(CommonHelper::generateUrl('custom', 'paymentFailed'));
                    }
                } else if ($orderInfo['order_is_paid'] == 0) {
                    /* Recording Payment in DB */
                    $orderPaymentObj->addOrderPayment($this->settings["plugin_code"], $charge['payment_intent'], $payment_amount, Labels::getLabel("MSG_Received_Payment", $this->siteLangId), $message);
                }

                if (false === MOBILE_APP_API_CALL) {
                    FatApp::redirectUser(CommonHelper::generateUrl('custom', 'paymentSuccess', array($orderInfo['order_number'])));
                }
            } else {
                $orderPaymentObj->addOrderPaymentComments($message);
                if (false === MOBILE_APP_API_CALL) {
                    FatApp::redirectUser(CommonHelper::generateUrl('custom', 'paymentFailed'));
                }
            }
        }
    }
}
