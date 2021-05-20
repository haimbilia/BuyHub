<?php

class QnbPayController extends PaymentController
{

    public const KEY_NAME = "Qnb";
    public const SUPPORTED_CURRENCIES = [392 => 'JPY', 643 => 'RUB', 826 => 'GBP', 840 => 'USD', 949 => 'TRY', 978 => 'EUR'];

    /**
     * __construct
     *
     * @param  string $action
     * @return void
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
        $this->init();
    }

    /**
     * allowedCurrenciesArr
     *
     * @return array
     */
    protected function allowedCurrenciesArr(): array
    {
        return self::SUPPORTED_CURRENCIES;
    }

    /**
     * init
     *
     * @return void
     */
    private function init(): void
    {
        if (false === $this->plugin->init()) {
            $this->setErrorAndRedirect($this->plugin->getError(), FatUtility::isAjaxCall());
        }
        $this->settings = $this->plugin->getSettings();
    }

    /**
     * charge
     *
     * @param  string $orderId
     * @return void
     */
    public function charge($orderId)
    {
        if (empty($orderId)) {
            $msg = Labels::getLabel('MSG_Invalid_Access', $this->siteLangId);
            $this->setErrorAndRedirect($msg, FatUtility::isAjaxCall());
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

        $frm->fill(['orderId' => $orderId]);
        $this->set('frm', $frm);
        $this->set('exculdeMainHeaderDiv', true);
        $this->set('paymentAmount', $paymentAmount);
        $this->set('orderInfo', $orderInfo);

        $cancelBtnUrl = CommonHelper::getPaymentCancelPageUrl();
        if ($orderInfo['order_type'] == Orders::ORDER_WALLET_RECHARGE) {
            $cancelBtnUrl = CommonHelper::getPaymentFailurePageUrl();
        }

        $this->set('cancelBtnUrl', $cancelBtnUrl);
        if (FatUtility::isAjaxCall()) {
            $json['html'] = $this->_template->render(false, false, 'qnb-pay/charge-ajax.php', true, false);
            FatUtility::dieJsonSuccess($json);
        }
        $this->_template->render(true, false);
    }

    public function callback()
    {
        $post = FatApp::getPostedData();
        $orderId = FatApp::getPostedData('OrderId');
        if (empty($orderId)) {
            $this->logFailure($orderId, Labels::getLabel('MSG_Invalid_Callback_Response', $this->siteLangId));
        }

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();

        if (!empty($orderInfo) && $orderInfo["order_payment_status"] != Orders::ORDER_PAYMENT_PENDING) {
            $this->logFailure($orderId, Labels::getLabel('MSG_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId));
        }

        $hashstr = $this->settings['merchant_id'] . $this->settings['merchant_password'] . $post['OrderId'] . $post['AuthCode'] . $post['ProcReturnCode'] . $post['3DStatus'] . $post['ResponseRnd'] . $this->settings['user_code'];
        $hash = base64_encode(pack('H*', sha1($hashstr)));

        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();

        if ($hash !== $post['ResponseHash'] || $paymentAmount != $post['PurchAmount']) {
            $this->logFailure($orderId, Labels::getLabel('MSG_Invalid_Payment_Response', $this->siteLangId));
        }

        if ('00' != $post['ProcReturnCode']) {
            $this->logFailure($orderId, $post['ErrMsg']);
        }

        if (false === $orderPaymentObj->addOrderPayment(self::KEY_NAME, $post['RequestGuid'], $paymentAmount, Labels::getLabel("MSG_RECEIVED_PAYMENT", $this->siteLangId), json_encode($post))) {
            $msg = $orderPaymentObj->getError();
            $this->logFailure($orderId, $msg);
        }
    }

    public function paymentFailed()
    {

        if (isset($_POST['ErrMsg']) && !empty($_POST['ErrMsg'])) {
            Message::addErrorMessage($_POST['ErrMsg']);
        }
        FatApp::redirectUser(CommonHelper::getPaymentFailurePageUrl());
    }

    /**
     * getPaymentForm
     *
     * @param  string $orderId
     * @param  bool $processRequest
     * @return object
     */
    private function getPaymentForm(string $orderId, bool $processRequest = false): object
    {
        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $paymentGatewayCharge = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();
        $actionUrl = $this->settings['env'] == Plugin::ENV_PRODUCTION ? 'https://vpos.qnbfinansbank.com/Gateway/3DHost.aspx' : 'https://vpostest.qnbfinansbank.com/Gateway/3DHost.aspx';

        $frm = new Form('frmPaymentForm', array('action' => $actionUrl, 'method' => 'post', 'class' => "form form--normal"));
        $mbrId = 5;
        $okUrl = UrlHelper::generateFullUrl('QnbPay', 'callback');
        $failUrl = UrlHelper::generateFullUrl('QnbPay', 'paymentFailed');
        $txnType = 'Auth';
        $installmentCount = 0;
        $rnd = microtime();
        $merchantPass = $this->settings['merchant_password'];
        $hashstr = $mbrId . $orderId . $paymentGatewayCharge . $okUrl . $failUrl . $txnType . $installmentCount . $rnd . $merchantPass;
        $hash = base64_encode(pack('H*', sha1($hashstr)));

        $frm->addHiddenField('', 'MbrId', $mbrId);
        $frm->addHiddenField('', 'MerchantID', $this->settings['merchant_id']);
        $frm->addHiddenField('', 'UserCode', $this->settings['user_code']);
        $frm->addHiddenField('', 'UserPass', $this->settings['user_password']);
        $frm->addHiddenField('', 'SecureType', '3DHost');
        $frm->addHiddenField('', 'TxnType', $txnType);
        $frm->addHiddenField('', 'InstallmentCount', $installmentCount);
        $frm->addHiddenField('', 'Currency', array_flip(self::SUPPORTED_CURRENCIES)[strtoupper($orderInfo["order_currency_code"])]);
        $frm->addHiddenField('', 'OkUrl', $okUrl);
        $frm->addHiddenField('', 'FailUrl', $failUrl);
        $frm->addHiddenField('', 'OrderId', $orderId);
        //$frm->addHiddenField('', 'OrgOrderId');
        $frm->addHiddenField('', 'PurchAmount', $paymentGatewayCharge);
        $frm->addHiddenField('', 'Lang', ($orderInfo['order_language'] == 'TR' ? 'TR' : 'EN'));
        $frm->addHiddenField('', 'Rnd', $rnd);
        $frm->addHiddenField('', 'Hash', $hash);
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_CONFIRM', $this->siteLangId));
        return $frm;
    }

    /**
     * logFailure
     *
     * @param  string $orderId
     * @return void
     */
    private function logFailure(string $orderId, string $msg = '', array $response = [])
    {
        $response = !empty($response) ? $response : $_REQUEST;
        TransactionFailureLog::set(TransactionFailureLog::LOG_TYPE_CHECKOUT, $orderId, json_encode($response));
        if (empty($msg)) {
            $msg = Labels::getLabel("MSG_PAYMENT_FAILED._{MSG}", $this->siteLangId);
            $msg = CommonHelper::replaceStringData($msg, ['{MSG}' => $this->plugin->getError()]);
        }

        $orderPaymentObj = new OrderPayment($orderId);
        $orderPaymentObj->addOrderPaymentComments($msg);
        exit;
    }

}
