<?php

class CashOnDeliveryPayController extends MyAppController
{
    private $keyName = "CashOnDelivery";

    public function charge($orderId)
    {
        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();
        if (!$orderInfo || $orderInfo["order_payment_status"] == Orders::ORDER_PAYMENT_PAID) {
            $msg = Labels::getLabel('MSG_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId);
            LibHelper::exitWithError($msg, FatUtility::isAjaxCall(), true);
            FatApp::redirectUser(UrlHelper::generateUrl('Buyer', 'ViewOrder', array($orderInfo['id'])));
        }

        /* Partial Payment is not allowed, Wallet + COD, So, disabling COD in case of Partial Payment Wallet Selected. [ */
        if ($orderInfo['order_wallet_amount_charge'] > 0 && $paymentAmount > 0) {
            $msg = Labels::getLabel('MSG_Wallet_can_not_be_used_along_with_{COD}', $this->siteLangId);
            $msg = str_replace('{cod}', $this->keyName, $msg);
            LibHelper::exitWithError($msg, FatUtility::isAjaxCall(), true);
            FatApp::redirectUser(UrlHelper::generateUrl('Buyer', 'ViewOrder', array($orderInfo['id'])));
        }
        /* ] */

        $token = FatApp::getPostedData('_token', FatUtility::VAR_STRING, '');
        if (!empty($token) && !UserAuthentication::isUserLogged('', $token)) {
            Message::addErrorMessage(Labels::getLabel('ERR_INVALID_TOKEN', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('Buyer', 'ViewOrder', array($orderInfo['id'])));
        }
        /* Avoid payment for digital products [ */

        $userId = UserAuthentication::getLoggedUserId();
        $srch = new OrderProductSearch($this->siteLangId, true);
        $srch->joinOrderUser();
        $srch->addCondition('order_user_id', '=', $userId);
        $srch->addCondition('order_id', '=', $orderId);
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();

        $childOrderDetail = FatApp::getDb()->fetchAll($rs, 'op_id');

        foreach ($childOrderDetail as $opID => $opDetail) {
            if ($opDetail["op_product_type"] == Product::PRODUCT_TYPE_DIGITAL) {
                $str = Labels::getLabel('MSG_Digital_Products_can_not_be_processed_along_with_{COD}', $this->siteLangId);
                $str = str_replace('{cod}', $this->keyName, $str);
                LibHelper::exitWithError($msg, FatUtility::isAjaxCall(), true);
                FatApp::redirectUser(UrlHelper::generateUrl('Buyer', 'ViewOrder', array($orderInfo['id'])));
            }
           /*  if($opDetail['op_status_id'] == FatApp::getConfig('CONF_COD_ORDER_STATUS', FatUtility::VAR_INT, 0)){
                LibHelper::exitWithError(Labels::getLabel('ERR_ORDER_ALREADY_PLACED', $this->siteLangId), FatUtility::isAjaxCall(), true);
            }     */       
        }
        /* ] */
        $this->paymentInitiated($orderId);
        $orderPaymentObj->confirmCodOrder($orderId, $this->siteLangId);
        foreach ($childOrderDetail as $opID => $opDetail) {
            if ($opDetail['op_is_batch']) {
                $opSelprodCodeArr = explode('|', $opDetail['op_selprod_code']);
            } else {
                $opSelprodCodeArr = array($opDetail['op_selprod_code']);
            }

            foreach ($opSelprodCodeArr as $opSelprodCode) {
                if (empty($opSelprodCode)) {
                    continue;
                }
                Product::recordProductWeightage($opSelprodCode, SmartWeightageSettings::PRODUCT_ORDER_PAID);
            }
        }
        $successUrl = UrlHelper::generateFullUrl('custom', 'paymentSuccess', array( $orderPaymentObj->getOrderNo() ));
        if (FatUtility::isAjaxCall()) {
            $json['redirect'] = $successUrl;
            FatUtility::dieJsonSuccess($json);
        }
        FatApp::redirectUser($successUrl);
    }

    /**
     * paymentInitiated : Order Id is not being used for now. 
     *
     * @param  int $orderId
     * @return void
     */
    protected function paymentInitiated($orderId)
    {
        unset($_SESSION['shopping_cart']["order_id"]);
        unset($_SESSION['subscription_shopping_cart']["order_id"]);
    }
}
