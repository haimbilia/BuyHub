<?php

class YocoPayController extends PaymentController
{

    public const KEY_NAME = 'Yoco';

    public function __construct($action)
    {
        parent::__construct($action);
        $this->init();
    }

    protected function allowedCurrenciesArr()
    {
        return ['ZAR'];
    }

    private function init(): void
    {
        if (false === $this->plugin->init()) {
            $this->setErrorAndRedirect($this->plugin->getError(), FatUtility::isAjaxCall());
        }
    }

    /**
     * charge
     *
     * @param  string $orderId
     * @return void
     */
    public function charge($orderId)
    {
        if ($orderId == '') {
            $msg = Labels::getLabel('MSG_Invalid_Access', $this->siteLangId);
            $this->setErrorAndRedirect($msg, FatUtility::isAjaxCall());
        }

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $paymentAmount = $this->convertToCents($orderPaymentObj->getOrderPaymentGatewayAmount());
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();

        if (!empty($orderInfo) && $orderInfo["order_payment_status"] != Orders::ORDER_PAYMENT_PENDING) {
            $this->setErrorAndRedirect(Labels::getLabel('MSG_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId), FatUtility::isAjaxCall());
        }

        $this->set('orderInfo', $orderInfo);
        $this->set('paymentAmount', $paymentAmount);
        $this->set('exculdeMainHeaderDiv', true);
        $this->set('publicKey', $this->plugin->getPublicKey());
        $this->set('frm', $this->getPaymentForm());
        $this->set('externalLibraries', $this->externalLibraries());
        if (FatUtility::isAjaxCall()) {
            $json['html'] = $this->_template->render(false, false, 'yoco-pay/charge-ajax.php', true, false);
            FatUtility::dieJsonSuccess($json);
        }
        $this->_template->render(true, false);
    }

    /**
     * 
     * @param type $orderId
     */
    public function chargeCard($orderId)
    {
        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();

        if (!empty($orderInfo) && $orderInfo["order_payment_status"] != Orders::ORDER_PAYMENT_PENDING) {
            $msg = Labels::getLabel('MSG_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId);
            $this->setErrorAndRedirect($msg, FatUtility::isAjaxCall(), false);
        }
        $token = FatApp::getPostedData('token', FatUtility::VAR_STRING);

        if (false === $this->plugin->chargeCard($token, $this->convertToCents($paymentAmount), $orderInfo["order_currency_code"])) {
            $this->setErrorAndRedirect($this->plugin->getError(), FatUtility::isAjaxCall(), false);
        }

        $response = $this->plugin->getResponse();
        if (isset($response['status']) && strtolower($response['status']) == 'successful') {
            $orderPaymentObj->addOrderPayment(self::KEY_NAME, $response['id'], ($paymentAmount), Labels::getLabel("MSG_Received_Payment", $this->siteLangId), json_encode($response));
            die(json_encode(['status' => 1, 'redirectUrl' => UrlHelper::generateUrl('custom', 'paymentSuccess', array($orderId))]));
        }
        $msg = $response['displayMessage'] ?? Labels::getLabel("MSG_PAYMENT_FAILED", $this->siteLangId);
        TransactionFailureLog::set(TransactionFailureLog::LOG_TYPE_CHECKOUT, $orderId, json_encode($response));
        $orderPaymentObj->addOrderPaymentComments($msg);
        die(json_encode(['status' => 0, 'redirectUrl' => UrlHelper::generateUrl('custom', 'paymentFailed'), 'msg' => $msg]));
    }

    /**
     * getExternalLibraries
     *
     * @return void
     */
    public function getExternalLibraries()
    {
        $json['libraries'] = $this->externalLibraries();
        FatUtility::dieJsonSuccess($json);
    }

    private function externalLibraries()
    {
        return ['https://js.yoco.com/sdk/v1/yoco-sdk-web.js'];
    }

    private function getPaymentForm(): object
    {
        $frm = new Form('frmPaymentForm');
        $frm->addHtml('', 'card_frame', '');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_CONFIRM', $this->siteLangId));
        return $frm;
    }

    private function convertToCents($amount)
    {
        return number_format($amount, 2, '.', '') * 100;
    }

}
