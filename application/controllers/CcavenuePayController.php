<?php

require_once CONF_INSTALLATION_PATH . 'library/payment-plugins/ccavenue/Crypto.php';
class CcavenuePayController extends PaymentController
{
    public const KEY_NAME = "Ccavenue";

    public function __construct($action)
    {
        parent::__construct($action);
        $this->init();
    }

    protected function allowedCurrenciesArr()
    {
        return ['INR'];
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
        if (empty($orderId)) {
            FatUtility::exitWIthErrorCode(404);
        }

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();

        if (!empty($orderInfo) && $orderInfo["order_payment_status"] != Orders::ORDER_PAYMENT_PENDING) {
            $msg = Labels::getLabel('MSG_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId);
            $this->setErrorAndRedirect($msg, FatUtility::isAjaxCall());
        }

        $frm = $this->getPaymentForm($orderId);
        $postOrderId = FatApp::getPostedData('orderId', FatUtility::VAR_STRING, '');
        $processRequest = false;
        if (!empty($postOrderId) && $orderId = $postOrderId) {
            $frm = $this->getPaymentForm($orderId, true);
            $processRequest = true;
        }

        $frm->fill(['orderId' => $orderId]);
        $this->set('frm', $frm);
        $this->set('processRequest', $processRequest);

        $this->set('paymentAmount', $paymentAmount);
        $this->set('orderInfo', $orderInfo);
        $this->set('exculdeMainHeaderDiv', true);
        if (FatUtility::isAjaxCall()) {
            if (!function_exists('mcrypt_encrypt')) {
                Message::addErrorMessage(Labels::getLabel('LBL_MCRYPT_EXTENSION_NOT_LOADED', $this->siteLangId));
                $json['html'] = Message::getHtml();
            } else {
                $json['html'] = $this->_template->render(false, false, 'ccavenue-pay/charge-ajax.php', true, false);
            }
            FatUtility::dieJsonSuccess($json);
        }
        $this->_template->render(true, false);
    }

    public function iframe($orderId)
    {
        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();

        if (!$orderInfo['id']) {
            $this->setErrorAndRedirect(Labels::getLabel("ERR_INVALID_REQUEST", $this->siteLangId), FatUtility::isAjaxCall());
        }
        $working_key = $this->settings['working_key'];
        $access_code = $this->settings['access_code'];
        $merchant_data = '';
        $post = FatApp::getPostedData();
        $post['currency'] = $this->systemCurrencyCode;
        $merchant_data = http_build_query($post);

        $encrypted_data = encrypt($merchant_data, $working_key); // Method for encrypting the data.
        if (FatApp::getConfig('CONF_TRANSACTION_MODE', FatUtility::VAR_BOOLEAN, false) == true) {
            $iframe_url = 'https://secure.ccavenue.com';
        } else {
            $iframe_url = 'https://test.ccavenue.com';
        }
        $this->paymentInitiated($orderId);
        $iframe_url .= '/transaction/transaction.do?command=initiateTransaction&encRequest=' . $encrypted_data . '&access_code=' . $access_code;
        FatApp::redirectUser($iframe_url);
    }

    public function callback()
    {
        $post = FatApp::getPostedData();
        $workingKey = $this->settings['working_key'];
        $encResponse = $post["encResp"];            //This is the response sent by the CCAvenue Server
        $rcvdString = decrypt($encResponse, $workingKey);        //Crypto Decryption used as per the specified working key.
        parse_str($rcvdString, $response);
        $order_status = $response['order_status'];
        $orderId = $response['merchant_param1'];
        $paid_amount = $response['amount'];
        $tracking_id = $response['order_id'];

        $orderPaymentObj = new OrderPayment($orderId);
        $paymentGatewayCharge = $orderPaymentObj->getOrderPaymentGatewayAmount();
        if ($paymentGatewayCharge > 0) {
            $total_paid_match = ((float) $paid_amount == $paymentGatewayCharge);
            if (!$total_paid_match) {
                $rcvdString .= "\n\n CCAvenue :: TOTAL PAID MISMATCH! " . strtolower($paid_amount) . "\n\n";
            }
            if ($order_status == "Success" && $total_paid_match) {
                $orderPaymentObj->addOrderPayment($this->settings["plugin_code"], $tracking_id, $paymentGatewayCharge, Labels::getLabel("MSG_Received_Payment", $this->siteLangId), json_encode($post));
                FatApp::redirectUser(UrlHelper::generateUrl('custom', 'paymentSuccess', array($orderPaymentObj->getOrderNo())));
            } else {
                if (isset($response['status_message']) || isset($response['failure_message'])) {
                    $message = isset($response['failure_message']) && !empty($response['failure_message']) ? $response['failure_message'] : $response['status_message'];
                    Message::addErrorMessage($message);
                }
                SystemLog::transaction(json_encode($post), self::KEY_NAME . "-" . $orderId);
                $orderPaymentObj->addOrderPaymentComments($rcvdString);
                FatApp::redirectUser(CommonHelper::getPaymentFailurePageUrl());
            }
        }
    }

    private function getPaymentForm($orderId, bool $processRequest = false)
    {
        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $paymentGatewayCharge = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();
        if (empty($orderInfo['customer_email'])) {
            Message::addErrorMessage(Labels::getLabel('LBL_PLEASE_UPDATE_YOUR_EMAIL_ADDRESS', $this->siteLangId));
            FatApp::redirectUser(CommonHelper::getPaymentFailurePageUrl());
        }
        $actionUrl = false === $processRequest ? UrlHelper::generateUrl(self::KEY_NAME . 'Pay', 'charge', array($orderId), CONF_WEBROOT_FRONTEND) : UrlHelper::generateFullUrl(self::KEY_NAME . 'Pay', 'iframe', array($orderId));

        $frm = new Form('frm-ccavenue', array('id' => 'frm-ccavenue', 'action' => $actionUrl, 'class' => "form form--normal"));
        $frm->addHiddenField('', 'orderId');

        if (false === $processRequest) {
            $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_CONFIRM', $this->siteLangId));
        } else {
            if ($orderInfo['order_type'] == Orders::ORDER_WALLET_RECHARGE) {
                $addr = new Address();
                $addrData = $addr->getData(Address::TYPE_USER, UserAuthentication::getLoggedUserId(true), applicationConstants::YES);
                $addrData = !empty($addrData) ? current($addrData) : [];
                if (empty($addrData)) {
                    Message::addErrorMessage(Labels::getLabel('LBL_PLEASE_ADD_ADDRESS_TO_PROCEED_FURTHER', $this->siteLangId));
                    FatApp::redirectUser(CommonHelper::getPaymentFailurePageUrl());
                }

                $orderInfo["customer_billing_name"] = $addrData['addr_name'];
                $orderInfo["customer_billing_address_1"] = $addrData['addr_address1'];
                $orderInfo["customer_billing_address_2"] = $addrData['addr_address2'];
                $orderInfo["customer_billing_city"] = $addrData['addr_city'];
                $orderInfo["customer_billing_state"] = $addrData['state_name'];
                $orderInfo["customer_billing_postcode"] = $addrData['addr_zip'];
                $orderInfo['customer_billing_country'] = $addrData['country_name'];
                $orderInfo['customer_billing_phone'] = $addrData['addr_phone'];
            }

            $frm->addHiddenField('', 'tid', "", array("id" => "tid"));
            $frm->addHiddenField('', 'merchant_id', $this->settings["merchant_id"]);
            $frm->addHiddenField('', 'order_id', $orderInfo['invoice']);
            $frm->addHiddenField('', 'amount', $paymentGatewayCharge);
            $frm->addHiddenField('', 'merchant_param1', $orderId);
            //$frm->addHiddenField('', 'currency', $orderInfo["order_currency_code"]);
            $frm->addHiddenField('', 'language', "EN");
            $frm->addHiddenField('', 'redirect_url', UrlHelper::generateFullUrl('CcavenuePay', 'callback'));
            $frm->addHiddenField('', 'cancel_url', CommonHelper::getPaymentCancelPageUrl());
            //$frm->addHiddenField('', 'item_name_1', $order_payment_gateway_description);
            $frm->addHiddenField('', 'billing_name', $orderInfo["customer_billing_name"]);
            $frm->addHiddenField('', 'billing_address', $orderInfo["customer_billing_address_1"] . ', ' . $orderInfo["customer_billing_address_2"]);
            $frm->addHiddenField('', 'billing_city', $orderInfo["customer_billing_city"]);
            $frm->addHiddenField('', 'billing_state', $orderInfo["customer_billing_state"]);
            $frm->addHiddenField('', 'billing_zip', $orderInfo["customer_billing_postcode"]);
            $frm->addHiddenField('', 'billing_country', $orderInfo['customer_billing_country']);
            $frm->addHiddenField('', 'billing_tel', $orderInfo['customer_billing_phone']);
            $frm->addHiddenField('', 'billing_email', $orderInfo['customer_email']);
            $frm->addHiddenField('', 'delivery_name', $orderInfo["customer_shipping_name"]);
            $frm->addHiddenField('', 'delivery_address', $orderInfo["customer_shipping_address_1"] . ', ' . $orderInfo["customer_shipping_address_2"]);
            $frm->addHiddenField('', 'delivery_city', $orderInfo["customer_shipping_city"]);
            $frm->addHiddenField('', 'delivery_state', $orderInfo["customer_shipping_state"]);
            $frm->addHiddenField('', 'delivery_zip', $orderInfo["customer_shipping_postcode"]);
            $frm->addHiddenField('', 'delivery_country', $orderInfo['customer_shipping_country']);
            $frm->addHiddenField('', 'delivery_tel', $orderInfo['customer_shipping_phone']);
            $frm->addHiddenField('', 'integration_type', 'iframe_normal');
        }
        return $frm;
    }
}
