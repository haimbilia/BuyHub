<?php

class MolliePayController extends PaymentController
{
    public const KEY_NAME = "Mollie";
    
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
    }

    /**
     * charge
     *
     * @param  int $orderId
     * @return void
     */
    public function charge($orderId)
    {
        if (empty($orderId)) {
            $msg = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            $this->setErrorAndRedirect($msg, FatUtility::isAjaxCall());
        }

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();
        if (!empty($orderInfo) && $orderInfo["order_payment_status"] != Orders::ORDER_PAYMENT_PENDING) {
            $msg = Labels::getLabel('ERR_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId);
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
        $this->set('exculdeMainHeaderDiv', true);
        $this->set('paymentAmount', $paymentAmount);
        $this->set('orderInfo', $orderInfo);

        $cancelBtnUrl = CommonHelper::getPaymentCancelPageUrl();
        if ($orderInfo['order_type'] == Orders::ORDER_WALLET_RECHARGE) {
            $cancelBtnUrl = CommonHelper::getPaymentFailurePageUrl();
        }

        $this->set('cancelBtnUrl', $cancelBtnUrl);
        if (FatUtility::isAjaxCall()) {
            $json['html'] = $this->_template->render(false, false, 'mollie-pay/charge-ajax.php', true, false);
            FatUtility::dieJsonSuccess($json);
        }
        $this->_template->render(true, false);
    }
    
    /**
     * callback - Used for webhook
     *
     * @param  int $orderId
     * @return void
     */
    public function callback($orderId)
    {
		$post = FatApp::getPostedData();
        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();
        if (!empty($orderInfo) && $orderInfo["order_payment_status"] != Orders::ORDER_PAYMENT_PENDING) {
            $msg = Labels::getLabel('ERR_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId);
            $this->logFailure($orderId, $msg);
            return false;
        }

		if(strlen(trim($post['id'])) <= 0 ){
			$msg = Labels::getLabel('ERR_INVALID_CALLBACK_RESPONSE', $this->siteLangId);
            $this->logFailure($orderId, $msg);
            return false;
		}
		
        if ($this->plugin->validatePaymentResponse($post) === false) {
            $msg = Labels::getLabel('ERR_INVALID_PAYMENT_RESPONSE', $this->siteLangId);
            $this->logFailure($orderId, $msg);
            return false;
        }
		
        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        if (false === $orderPaymentObj->addOrderPayment(self::KEY_NAME, $post['id'], $paymentAmount, Labels::getLabel("MSG_RECEIVED_PAYMENT", $this->siteLangId), json_encode($post))) {
            $msg = $orderPaymentObj->getError();
            $this->logFailure($orderId, $msg);
            return false;
        }
		return true;
	}

    /**
     * getPaymentForm
     *
     * @param  int $orderId
     * @param  bool $processRequest
     * @return object
     */
    private function getPaymentForm($orderId, bool $processRequest = false): object
    {
        if(false === $processRequest){
            $actionUrl = UrlHelper::generateUrl(self::KEY_NAME . 'Pay', 'charge', [$orderId]);
        }else{ 
            $this->plugin->createPaymentAndActionUrl($orderId);
            $actionUrl  = $this->plugin->getActionUrl();
        }
       
        $frm = new Form('frmPaymentForm', array('action' => $actionUrl, 'class' => "form form--normal"));
        if (false === $processRequest) {	
            $frm->addHiddenField('', 'orderId');
            $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_CONFIRM', $this->siteLangId));
        }
        return $frm;
    }
    
    /**
     * logFailure
     *
     * @param  int $orderId
     * @return void
     */
    private function logFailure($orderId, string $msg = '', array $response = [])
    {
        $response = !empty($response) ? $response : $_REQUEST;   
        SystemLog::transaction(json_encode($response), self::KEY_NAME . "-" . $orderId);
        if (empty($msg)) {
            $msg = Labels::getLabel("ERR_PAYMENT_FAILED._{MSG}", $this->siteLangId);
            $msg = CommonHelper::replaceStringData($msg, ['{MSG}' => $this->plugin->getError()]);
        }
        
        $orderPaymentObj = new OrderPayment($orderId);
        $orderPaymentObj->addOrderPaymentComments($msg);
        exit;
    }
    
  


}