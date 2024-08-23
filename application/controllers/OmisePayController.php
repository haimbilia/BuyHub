<?php
class OmisePayController extends PaymentController
{
    public const KEY_NAME = "Omise";

    public function __construct($action)
    {
        parent::__construct($action);
        $this->init();
    }

    protected function allowedCurrenciesArr()
    {
        return ['THB'];
    }

    private function init(): void
    {
        if (false === $this->plugin->validateSettings($this->siteLangId)) {
            $this->setErrorAndRedirect($this->plugin->getError());
        }
        $this->settings = $this->plugin->getSettings();
        if (!defined('OMISE_PUBLIC_KEY')) {
            define('OMISE_PUBLIC_KEY', $this->settings['public_key']);
        }
        if (!defined('OMISE_SECRET_KEY')) {
            define('OMISE_SECRET_KEY', $this->settings['secret_key']);
        }
    }

    private function getPaymentForm($orderId)
    {
        $frm = new Form('frmPaymentForm', array('id' => 'frmPaymentForm', 'action' => UrlHelper::generateUrl('OmisePay', 'send', array($orderId)), 'class' => "form form--normal"));
        $frm->addRequiredField(Labels::getLabel('FRM_ENTER_CREDIT_CARD_NUMBER', $this->siteLangId), 'cc_number');
        $frm->addRequiredField(Labels::getLabel('FRM_CARD_HOLDER_NAME', $this->siteLangId), 'cc_owner');
        $data['months'] = applicationConstants::getMonthsArr($this->siteLangId);       

        $data['year_expire'] = array();
        for ($i = date('Y'); $i < date('Y') + 11; $i++) {
            $data['year_expire'][$i] = $i;
        }
        $frm->addSelectBox(Labels::getLabel('FRM_EXPIRY_MONTH', $this->siteLangId), 'cc_expire_date_month', $data['months'], '', array(), '');
        $frm->addSelectBox(Labels::getLabel('FRM_EXPIRY_YEAR', $this->siteLangId), 'cc_expire_date_year', $data['year_expire'], '', array(), '');
        $frm->addPasswordField(Labels::getLabel('FRM_CVV_SECURITY_CODE', $this->siteLangId), 'cc_cvv')->requirements()->setRequired(true);
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_PAY_NOW', $this->siteLangId), array('id' => 'button-confirm'));
        return $frm;
    }

    public function charge($orderId = '')
    {
        if (empty(trim($orderId))) {
            FatUtility::exitWIthErrorCode(404);
        }

        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();
        if (!$orderInfo['id']) {
            FatUtility::exitWIthErrorCode(404);
        } elseif ($orderInfo && $orderInfo["order_payment_status"] == Orders::ORDER_PAYMENT_PENDING) {
            $frm = $this->getPaymentForm($orderId);
            $this->set('frm', $frm);
        } else {
            $this->set('error', Labels::getLabel('ERR_INVALID_ORDER_PAID_CANCELLED', $this->siteLangId));
        }

        $cancelBtnUrl = CommonHelper::getPaymentCancelPageUrl();
        if ($orderInfo['order_type'] == Orders::ORDER_WALLET_RECHARGE) {
            $cancelBtnUrl = CommonHelper::getPaymentFailurePageUrl();
        }

        $this->set('cancelBtnUrl', $cancelBtnUrl);

        $this->set('paymentAmount', $paymentAmount);
        $this->set('orderInfo', $orderInfo);
        $this->set('exculdeMainHeaderDiv', true);
        if (FatUtility::isAjaxCall()) {
            $json['html'] = $this->_template->render(false, false, 'omise-pay/charge-ajax.php', true, false);
            FatUtility::dieJsonSuccess($json);
        }
        $this->_template->render(true, false);
    }

    public function send($orderId)
    {
        $post = FatApp::getPostedData();
        $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
        $orderPaymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $this->paymentInitiated($orderId);
        if ($orderPaymentAmount > 0) {
            $orderInfo = $orderPaymentObj->getOrderPrimaryinfo();
            $orderActualPaid = ceil($orderPaymentAmount) * 100; /* payment accepted in satang. i.e. to charge ฿20.00, you should set amount=2000 (฿20.00). */
            $livemode = true;
            if (FatApp::getConfig('CONF_TRANSACTION_MODE', FatUtility::VAR_BOOLEAN, false) == false) {
                $livemode = false;
            }
            $json = array();
            try {
                unset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['omiseChargeId']);
                $token = OmiseToken::create(
                    array(
                        'card' => array(
                            'name' => $post['cc_owner'],
                            'number' => str_replace(' ', '', $post['cc_number']),
                            'expiration_month' => $post['cc_expire_date_month'],
                            'expiration_year' => $post['cc_expire_date_year'],
                            'city' => FatUtility::decodeHtmlEntities($orderInfo['customer_billing_city'], ENT_QUOTES, 'UTF-8'),
                            'city' => FatUtility::decodeHtmlEntities($orderInfo['customer_billing_city'], ENT_QUOTES, 'UTF-8'),
                            'postal_code' => FatUtility::decodeHtmlEntities($orderInfo['customer_billing_postcode'], ENT_QUOTES, 'UTF-8'),
                            'security_code' => $post['cc_cvv'],
                            'livemode' => $livemode
                        )
                    )
                );
                $token_ref = $token->offsetGet('id');
                $customer = OmiseCustomer::create(
                    array(
                        'email' => $orderInfo['customer_email'],
                        'description' => $orderInfo['customer_name'] . ' (id: ' . $orderInfo['customer_id'] . ')',
                        'card' => $token_ref,
                        'livemode' => $livemode
                    )
                );
                $response = OmiseCharge::create(
                    array(
                        'amount' => $orderActualPaid,
                        'currency' => 'thb', /* $orderInfo["order_currency_code"], */
                        'description' => 'Order-' . $orderId,
                        'ip' => $_SERVER['REMOTE_ADDR'],
                        'customer' => $customer->offsetGet('id'),
                        // 'card'        => $token_ref,
                        'livemode' => $livemode,
                        'return_uri' => UrlHelper::generateFullUrl('OmisePay', 'success', array($orderId))
                    )
                );
                if (!$response) {
                    throw new Exception(Labels::getLabel('ERR_EMPTY_GATEWAY_RESPONSE', $this->siteLangId));
                }

                /*--IN CASE OF 3D SECURE ENABLED IN MERCHANT ACCOUNT--*/
                if (strtolower($response->offsetGet('status')) == 'pending') {
                    $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['omiseChargeId'][$orderId] = $response->offsetGet('id');
                    $json['redirect'] = $response->offsetGet('authorize_uri');
                    echo json_encode($json);
                    die;
                }
                /* ^^^^^^^^^^ */

                if (strtolower($response->offsetGet('status')) != 'successful' || strtolower($response->offsetGet('paid')) != true) {
                    throw new Exception($response->offsetGet('failure_message'));
                }

                $trans = OmiseTransaction::retrieve($response->offsetGet('transaction'));
                $omise_fee = round($orderActualPaid * ('.0365'), 0);
                $vat = round($omise_fee * ('.07'), 0);
                $trans_fee = intval($omise_fee + $vat);
                if ($trans->offsetGet('amount') != ($orderActualPaid - $trans_fee)) {
                    throw new Exception(Labels::getLabel('ERR_INVALID_TRANSACTION_AMOUNT', $this->siteLangId));
                }
                /* Recording Payment in DB */
                if (!$orderPaymentObj->addOrderPayment($this->settings["plugin_code"], $response->offsetGet('transaction'), $orderPaymentAmount, Labels::getLabel("MSG_RECEIVED_PAYMENT", $this->siteLangId), json_encode((array) $response))) {
                    $error = Labels::getLabel('ERR_INVALID_ACTION', $this->siteLangId);
                } else {
                    $json['redirect'] = UrlHelper::generateUrl('custom', 'paymentSuccess', array($orderPaymentObj->getOrderNo()));
                }
                /* End Recording Payment in DB */
            } catch (OmiseNotFoundException $e) {
                $json['error'] = 'ERROR: ' . $e->getMessage();
            } catch (exception $e) {
                $json['error'] = 'ERROR: ' . $e->getMessage();
            }
        } else {
            $json['error'] = Labels::getLabel('ERR_INVALID_REQUEST', $this->siteLangId);
        }
        echo json_encode($json);
    }

    /*--IN CASE OF 3D SECURE ENABLED IN MERCHANT ACCOUNT--*/
    public function success($orderId)
    {
        $error = Labels::getLabel('ERR_PAYMENT_FAILED', $this->siteLangId);
        try {
            $charge = OmiseCharge::retrieve($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['omiseChargeId'][$orderId]);
            if (strtolower($charge->offsetGet('status')) != 'successful' || strtolower($charge->offsetGet('paid')) != true) {
                throw new Exception($charge->offsetGet('failure_message'));
            }

            $orderPaymentObj = new OrderPayment($orderId, $this->siteLangId);
            $orderPaymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();

            $orderActualPaid = ceil($orderPaymentAmount) * 100; /* payment accepted in satang. i.e. to charge ฿20.00, you should set amount=2000 (฿20.00). */
            if ($charge->offsetGet('amount') != $orderActualPaid) {
                throw new Exception(Labels::getLabel('ERR_INVALID_TRANSACTION_AMOUNT', $this->siteLangId));
            }

            /* Recording Payment in DB */
            if (!$orderPaymentObj->addOrderPayment($this->settings["plugin_code"], $charge->offsetGet('transaction'), $orderPaymentAmount, Labels::getLabel("MSG_RECEIVED_PAYMENT", $this->siteLangId), json_encode((array) $charge))) {
                $error = Labels::getLabel('ERR_INVALID_ACTION', $this->siteLangId);
            } else {
                FatApp::redirectUser(UrlHelper::generateUrl('custom', 'paymentSuccess', array($orderPaymentObj->getOrderNo())));
            }
            /* End Recording Payment in DB */
        } catch (OmiseNotFoundException $e) {
            $error = 'ERROR: ' . $e->getMessage();
        } catch (exception $e) {
            $error = 'ERROR: ' . $e->getMessage();
        }

        Message::addErrorMessage($error);
        FatApp::redirectUser(CommonHelper::getPaymentFailurePageUrl());
    }
}
