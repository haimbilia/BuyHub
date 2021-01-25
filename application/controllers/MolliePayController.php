<?php

class MolliePayController extends PaymentController
{
    public const KEY_NAME = "Mollie";
    private $actionUrl = '';

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
        return ['EUR', 'USD'];
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
        //$this->actionUrl = $this->plugin->getActionUrl();
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
		
        $this->set('frm', $frm);
        $this->set('processRequest', $processRequest);
        $this->set('exculdeMainHeaderDiv', true);
        $this->set('paymentAmount', $paymentAmount);
        $this->set('orderInfo', $orderInfo);

        $cancelBtnUrl = CommonHelper::getPaymentCancelPageUrl();
        if ($orderInfo['order_type'] == Orders::ORDER_WALLET_RECHARGE) {
            $cancelBtnUrl = CommonHelper::getPaymentFailurePageUrl();
        }

        $this->set('cancelBtnUrl', $cancelBtnUrl);
        if (FatUtility::isAjaxCall()) {
            $json['html'] = $this->_template->render(false, false, 'payfast-pay/charge-ajax.php', true, false);
            FatUtility::dieJsonSuccess($json);
        }
        $this->_template->render(true, false);
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
        $orderPaymentObj = new OrderPayment($orderId);
        TransactionFailureLog::set(TransactionFailureLog::LOG_TYPE_CHECKOUT, $orderId, json_encode($response));

        if (empty($msg)) {
            $msg = Labels::getLabel("MSG_PAYMENT_FAILED._{MSG}", $this->siteLangId);
            $msg = CommonHelper::replaceStringData($msg, ['{MSG}' => $this->plugin->getError()]);
        }

        $orderPaymentObj->addOrderPaymentComments($msg);
        Message::addErrorMessage($msg);
        FatApp::redirectUser(CommonHelper::getPaymentFailurePageUrl());
        die;
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
        $actionUrl = false === $processRequest ? UrlHelper::generateUrl(self::KEY_NAME . 'Pay', 'charge', [$orderId]) : $this->actionUrl;

        $frm = new Form('frmPaymentForm', array('action' => $actionUrl, 'class' => "form form--normal"));
        if (false === $processRequest) {	
            $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_CONFIRM', $this->siteLangId));
        } else {	
            $this->plugin->buildRequestBody($orderId);
            foreach ($this->plugin->getRequestBody() as $name => $value) {
                $frm->addHiddenField('', $name, $value);
            }
        }
        return $frm;
    }


}