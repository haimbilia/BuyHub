<?php
class ConfirmPayController extends MyAppController
{
    public function charge($orderId = '')
    {
        $isAjaxCall = FatUtility::isAjaxCall();

        if (!$orderId || ((isset($_SESSION['shopping_cart']["order_id"]) && $orderId != $_SESSION['shopping_cart']["order_id"]) && (isset($_SESSION['subscription_shopping_cart']["order_id"]))  && $orderId != $_SESSION['subscription_shopping_cart']["order_id"])) {
            $msg = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($msg);
            }
            Message::addErrorMessage($msg);
            if ($isAjaxCall) {
                FatUtility::dieWithError(Message::getHtml());
            }
            CommonHelper::redirectUserReferer();
        }

        if (!UserAuthentication::isUserLogged() && !UserAuthentication::isGuestUserLogged()) {
            $msg = Labels::getLabel('ERR_YOUR_SESSION_SEEMS_TO_BE_EXPIRED', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($msg);
            }
            Message::addErrorMessage($msg);
            if ($isAjaxCall) {
                FatUtility::dieWithError(Message::getHtml());
            }
            CommonHelper::redirectUserReferer();
        }

        $user_id = User::getUserParentId(UserAuthentication::getLoggedUserId(true));

        $orderObj = new Orders();
        $srch = Orders::getSearchObject();
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('order_id', '=', $orderId);
        $srch->addCondition('order_user_id', '=', $user_id);
        $srch->addCondition('order_payment_status', '=', Orders::ORDER_PAYMENT_PENDING);
        if (false === MOBILE_APP_API_CALL && $orderId == $_SESSION['subscription_shopping_cart']["order_id"]) {
            $srch->addCondition('order_type', '=', Orders::ORDER_SUBSCRIPTION);
        } else {
            $srch->addCondition('order_type', '=', Orders::ORDER_PRODUCT);
        }
        $rs = $srch->getResultSet();
        $orderInfo = FatApp::getDb()->fetch($rs);
        if (!$orderInfo) {
            $msg = Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($msg);
            }
            Message::addErrorMessage($msg);
            if ($isAjaxCall) {
                FatUtility::dieWithError(Message::getHtml());
            }
            CommonHelper::redirectUserReferer();
        }
        
        $orderPaymentFinancials = $orderObj->getOrderPaymentFinancials($orderId);
        if ($orderPaymentFinancials['order_payment_gateway_charge'] > 0) {
            $msg = Labels::getLabel('ERR_PAYMENT_CAN_BE_CHARGED_BY_PAYMENT_GATEWAY', $this->siteLangId);
            if (true === MOBILE_APP_API_CALL) {
                FatUtility::dieJsonError($msg);
            }
            FatApp::redirectUser(UrlHelper::generateUrl('Custom', 'paymentFailure', array($orderId)));
        } else {
            $orderPaymentObj = new OrderPayment($orderId);
            if (!$orderPaymentObj->chargeFreeOrder()) {
                if (true === MOBILE_APP_API_CALL) {
                    FatUtility::dieJsonError($orderPaymentObj->getError());
                }
                Message::addErrorMessage($orderPaymentObj->getError());
                if ($isAjaxCall) {
                    FatUtility::dieWithError(Message::getHtml());
                }
                CommonHelper::redirectUserReferer();
            }
        }
        
        if (false === MOBILE_APP_API_CALL && $orderId == $_SESSION['subscription_shopping_cart']["order_id"]) {
            $scartObj = new SubscriptionCart();
            $scartObj->clear();
            $scartObj->updateUserSubscriptionCart();
        } else {
            $cartObj = new Cart();
            $cartObj->clear();
            $cartObj->updateUserCart();
        }

        if (true === MOBILE_APP_API_CALL) {
            $this->_template->render();
        }

        if ($isAjaxCall) {
            $this->set('redirectUrl', UrlHelper::generateUrl('Custom', 'paymentSuccess', array($orderPaymentObj->getOrderNo())));
            $this->set('msg', Labels::getLabel("MSG_PAYMENT_FROM_WALLET_MADE_SUCCESSFULLY", $this->siteLangId));
            $this->_template->render(false, false, 'json-success.php');
        }
        FatApp::redirectUser(UrlHelper::generateUrl('Custom', 'paymentSuccess', array($orderPaymentObj->getOrderNo())));
    }
}
