<?php

class OrderPayment extends Orders
{
    protected $attributes;

    public function __construct($orderId = 0, $langId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $orderId);

        $this->paymentOrderId = $orderId;
        $this->orderLangId = $langId;
        $this->loadData();
    }

    protected function loadData()
    {
        $this->attributes = $this->getOrderById($this->paymentOrderId);
    }

    public function getOrderPaymentGatewayAmount()
    {
        $orderInfo = $this->attributes;
        $orderPaymentGatewayCharge = $orderInfo["order_net_amount"] - $orderInfo['order_wallet_amount_charge'];
        return round($orderPaymentGatewayCharge, 2);
    }

    public function getOrderNo()
    {
        return $this->attributes['order_number'];
    }

    public function getPaymentGatewayCode()
    {
        return $this->attributes['plugin_code'];
    }

    public function getOrderPrimaryinfo()
    {
        $arrOrder = array();
        $orderInfo = $this->attributes;
        $userObj = new User($orderInfo["order_user_id"]);
        $userInfo = $userObj->getUserInfo(array('user_name', 'credential_email', 'user_phone_dcode', 'user_phone'));
        $addresses = $this->getOrderAddresses($orderInfo["order_id"]);
        $currencyArr = Currency::getCurrencyAssoc($this->orderLangId);
        $orderCurrencyCode = !empty($currencyArr[FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)]) ? $currencyArr[FatApp::getConfig('CONF_CURRENCY', FatUtility::VAR_INT, 1)] : '';

        $billingArr = array(
            "customer_billing_name" => '',
            "customer_billing_address_1" => '',
            "customer_billing_address_2" => '',
            "customer_billing_city" => '',
            "customer_billing_postcode" => '',
            "customer_billing_state" => '',
            "customer_billing_country" => '',
            "customer_billing_country_code" => '',
            "customer_billing_phone" => '',
        );

        $shippingArr = array(
            "customer_shipping_name" => '',
            "customer_shipping_address_1" => '',
            "customer_shipping_address_2" => '',
            "customer_shipping_city" => '',
            "customer_shipping_state" => '',
            "customer_shipping_postcode" => '',
            "customer_shipping_country" => '',
            "customer_shipping_country_code" => '',
            "customer_shipping_phone" => '',
        );

        $arrOrder = array(
            "id" => $orderInfo["order_id"],
            "order_number" => $orderInfo["order_number"],
            "invoice" => $orderInfo["order_id"],
            "customer_id" => $orderInfo["order_user_id"],
            "customer_name" => isset($userInfo["user_name"]) ? $userInfo["user_name"] : '',
            "customer_email" => isset($userInfo["credential_email"]) ? $userInfo["credential_email"] : '',
            "customer_phone_dcode" => isset($userInfo["user_phone_dcode"]) ? $userInfo["user_phone_dcode"] : '',
            "customer_phone" => isset($userInfo["user_phone"]) ? $userInfo["user_phone"] : '',
            "order_currency_code" => $orderCurrencyCode,
            "order_currency_id" => $orderInfo["order_currency_id"],
            "order_type" => $orderInfo['order_type'],
            "order_tax_charged" => $orderInfo["order_tax_charged"],
            "order_payment_status" => $orderInfo["order_payment_status"],
            "plugin_code" => $orderInfo["plugin_code"],
            "order_language" => $orderInfo["order_language_code"],
            "order_language_id" => $orderInfo["order_language_id"],
            "order_site_commission" => $orderInfo["order_site_commission"],
            "site_system_name" => FatApp::getConfig("CONF_WEBSITE_NAME_" . $orderInfo["order_language_id"]),
            "site_system_admin_email" => FatApp::getConfig("CONF_SITE_OWNER_EMAIL", FatUtility::VAR_STRING, ''),
            "order_wallet_amount_charge" => $orderInfo['order_wallet_amount_charge'],
            "paypal_bn" => "FATbit_SP",
            "order_pmethod_id" => $orderInfo['order_pmethod_id'],
        );

        /* if (empty($orderInfo) || empty($userInfo) || empty($addresses)){
        return $arrOrder;
        } */
        /* CommonHelper::printArray($addresses);die; */
        if (!empty($addresses[Orders::BILLING_ADDRESS_TYPE])) {
            $billingArr = array(
                "customer_billing_name" => $addresses[Orders::BILLING_ADDRESS_TYPE]["oua_name"],
                "customer_billing_address_1" => $addresses[Orders::BILLING_ADDRESS_TYPE]["oua_address1"],
                "customer_billing_address_2" => $addresses[Orders::BILLING_ADDRESS_TYPE]["oua_address2"],
                "customer_billing_city" => $addresses[Orders::BILLING_ADDRESS_TYPE]["oua_city"],
                "customer_billing_postcode" => $addresses[Orders::BILLING_ADDRESS_TYPE]["oua_zip"],
                "customer_billing_state" => $addresses[Orders::BILLING_ADDRESS_TYPE]["oua_state"],
                "customer_billing_state_code" => $addresses[Orders::BILLING_ADDRESS_TYPE]["oua_state_code"],
                "customer_billing_country" => $addresses[Orders::BILLING_ADDRESS_TYPE]["oua_country"],
                "customer_billing_country_code" => $addresses[Orders::BILLING_ADDRESS_TYPE]["oua_country_code"],
                "customer_billing_phone" => $addresses[Orders::BILLING_ADDRESS_TYPE]["oua_phone_dcode"] . $addresses[Orders::BILLING_ADDRESS_TYPE]["oua_phone"],
            );
        }

        if (!empty($addresses[Orders::SHIPPING_ADDRESS_TYPE])) {
            $shippingArr = array(
                "customer_shipping_name" => $addresses[Orders::SHIPPING_ADDRESS_TYPE]["oua_name"],
                "customer_shipping_address_1" => $addresses[Orders::SHIPPING_ADDRESS_TYPE]["oua_address1"],
                "customer_shipping_address_2" => $addresses[Orders::SHIPPING_ADDRESS_TYPE]["oua_address2"],
                "customer_shipping_city" => $addresses[Orders::SHIPPING_ADDRESS_TYPE]["oua_city"],
                "customer_shipping_state" => $addresses[Orders::SHIPPING_ADDRESS_TYPE]["oua_state"],
                "customer_shipping_state_code" => $addresses[Orders::SHIPPING_ADDRESS_TYPE]["oua_state_code"],
                "customer_shipping_postcode" => $addresses[Orders::SHIPPING_ADDRESS_TYPE]["oua_zip"],
                "customer_shipping_country" => $addresses[Orders::SHIPPING_ADDRESS_TYPE]["oua_country"],
                "customer_shipping_country_code" => $addresses[Orders::SHIPPING_ADDRESS_TYPE]["oua_country_code"],
                "customer_shipping_phone" => $addresses[Orders::SHIPPING_ADDRESS_TYPE]["oua_phone_dcode"] . $addresses[Orders::SHIPPING_ADDRESS_TYPE]["oua_phone"],
            );
        } else {
            //$shippingArr = $billingArr;
        }

        $arrOrder = array_merge($arrOrder, $billingArr, $shippingArr);
        return $arrOrder;
    }

    public function addOrderPayment($paymentMethodName, $txnId, $amount, $comments = '', $response = '', $isWallet = false, $opId = 0, $orderPaymentStatus = Orders::ORDER_PAYMENT_PAID)
    {
        $paymentOrderId = $this->paymentOrderId;
        $defaultSiteLangId = FatApp::getConfig('conf_default_site_lang');
        $orderInfo = $this->attributes;
        if (!empty($orderInfo)) {
            $orderPaymentFinancials = $this->getOrderPaymentFinancials($paymentOrderId, $this->orderLangId);
            $orderCredits = $orderPaymentFinancials["order_credits_charge"];

            if ($orderCredits > 0 && !$isWallet) {
                $this->chargeUserWallet($orderCredits);
            }

            $orderDetails = $this->getOrderById($paymentOrderId);

            if (!FatApp::getDb()->insertFromArray(
                static::DB_TBL_ORDER_PAYMENTS,
                array(
                    'opayment_order_id' => $paymentOrderId,
                    'opayment_method' => $paymentMethodName,
                    'opayment_gateway_txn_id' => $txnId,
                    'opayment_amount' => $amount,
                    'opayment_txn_status' => $orderPaymentStatus,
                    'opayment_comments' => $comments,
                    'opayment_gateway_response' => $response,
                    'opayment_date' => date('Y-m-d H:i:s')
                )
            )) {
                $msg = FatApp::getDb()->getError();
                if (false !== strpos(strtolower($msg), 'duplicate')) {
                    $msg = Labels::getLabel('ERR_DUPLICATE_TRANSACTION');
                }
                $this->error = $msg;
                return false;
            }

            if (isset($orderDetails['plugin_code']) && 'TransferBank' == $orderDetails['plugin_code'] && Orders::ORDER_PAYMENT_PENDING == $orderPaymentStatus) {
                $userName = User::getAttributesById($orderDetails['order_user_id'], 'user_name');
                $emailNotificationData = [
                    'user_name' => $userName,
                    'order_user_id' => $orderInfo['order_user_id'],
                    'order_number' => $orderInfo['order_number'],
                    'order_id' => $paymentOrderId,
                    'payment_method' => $paymentMethodName,
                    'transaction_id' => $txnId,
                    'amount' => CommonHelper::displayMoneyFormat($amount, true, true),
                    'comments' => $comments,
                ];
                $emailObj = new EmailHandler();
                $emailObj->sendTransferBankNotification($defaultSiteLangId, $emailNotificationData);

                $admNotificationData = array(
                    'notification_record_type' => Notification::TYPE_ORDER,
                    'notification_record_id' => $paymentOrderId,
                    'notification_user_id' => $orderDetails['order_user_id'],
                    'notification_label_key' => Notification::ORDER_PAYMENT_TRANSFERRED_TO_BANK,
                    'notification_added_on' => date('Y-m-d H:i:s'),
                );

                Notification::saveNotifications($admNotificationData);
            }

            $totalPaymentPaid = $this->getOrderPaymentPaid($paymentOrderId);
            $orderBalance = (($orderDetails['order_net_amount'] - 1) - $totalPaymentPaid);

            if ($orderBalance <= 0) {
                $this->addOrderPaymentHistory($paymentOrderId, $orderPaymentStatus, Labels::getLabel('MSG_RECEIVED_PAYMENT', $defaultSiteLangId), 1);

                $notificationData = array(
                    'notification_record_type' => Notification::TYPE_ORDER,
                    'notification_record_id' => $paymentOrderId,
                    'notification_user_id' => $orderInfo['order_user_id'],
                    'notification_label_key' => Notification::NEW_ORDER_STATUS_NOTIFICATION,
                    'notification_added_on' => date('Y-m-d H:i:s'),
                );

                Notification::saveNotifications($notificationData);

                if (!empty($orderDetails['order_discount_coupon_code'])) {
                    $srch = DiscountCoupons::getSearchObject();
                    $srch->addCondition('coupon_code', '=', $orderDetails['order_discount_coupon_code']);
                    $srch->doNotCalculateRecords();
                    $srch->setPageSize(1);
                    $rs = $srch->getResultSet();
                    $row = FatApp::getDb()->fetch($rs);
                    if (!empty($row)) {
                        $data = array(
                            'couponhistory_coupon_id' => $row['coupon_id'],
                            'couponhistory_order_id' => $orderDetails['order_id'],
                            'couponhistory_user_id' => $orderDetails['order_user_id'],
                            'couponhistory_amount' => $orderDetails['order_discount_total'],
                            'couponhistory_added_on' => date('Y-m-d H:i:s')
                        );
                        if (!FatApp::getDb()->insertFromArray(CouponHistory::DB_TBL, $data)) {
                            $this->error = FatApp::getDb()->getError();
                            return false;
                        }
                        FatApp::getDb()->deleteRecords(DiscountCoupons::DB_TBL_COUPON_HOLD, array('smt' => 'couponhold_coupon_id = ? and couponhold_user_id = ?', 'vals' => array($row['coupon_id'], $orderDetails['order_user_id'])));
                        FatApp::getDb()->deleteRecords(DiscountCoupons::DB_TBL_COUPON_HOLD_PENDING_ORDER, array('smt' => 'ochold_order_id = ?', 'vals' => array($orderDetails['order_id'])));
                    }
                }
            }

            /* Credit money to user's wallet, if order_type = Orders::ORDER_WALLET_RECHARGE, i.e loading money to wallet[ */
            if ($orderDetails['order_type'] == Orders::ORDER_WALLET_RECHARGE) {
                $formattedOrderValue = "#" . $orderDetails["order_id"];
                $transObj = new Transactions();

                $txnDataArr = array(
                    'utxn_user_id' => $orderDetails["order_user_id"],
                    'utxn_credit' => $amount,
                    'utxn_gateway_txn_id' => $txnId,
                    'utxn_status' => Transactions::STATUS_COMPLETED,
                    'utxn_order_id' => $orderDetails["order_id"],
                    'utxn_comments' => sprintf(Labels::getLabel('LBL_LOADED_MONEY_TO_WALLET', $defaultSiteLangId), $formattedOrderValue),
                    'utxn_type' => Transactions::TYPE_LOADED_MONEY_TO_WALLET
                );
                if (!$txnId = $transObj->addTransaction($txnDataArr)) {
                    $this->error = $transObj->getError();
                    return false;
                }
                /* Send email to User[ */
                $emailNotificationObj = new EmailHandler();
                $emailNotificationObj->sendTxnNotification($txnId, $defaultSiteLangId);
                /* ] */
            }
            /* ] */
            return true;
        } else {
            $this->error = Labels::getLabel('ERR_INVALID_ORDER', $this->commonLangId);
            return false;
        }
    }

    public function confirmPayPickup($orderId, $langId)
    {
        $langId = FatUtility::int($langId);

        $db = FatApp::getDb();
        if (!$db->updateFromArray('tbl_order_products', array('op_status_id' => FatApp::getConfig('CONF_PAY_AT_STORE_ORDER_STATUS', FatUtility::VAR_INT, 0)), array('smt' => 'op_order_id = ? ', 'vals' => array($orderId)))) {
            $this->error = $db->getError();
            return false;
        }

        $orderPaymentObj = new OrderPayment($orderId, $langId);
        $request = $orderPaymentObj->getPaymentGatewayCode();
        $orderPaymentObj->addOrderPaymentComments($request);

        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $orderPaymentObj->addOrderPayment($request, 'S-' . time(), $paymentAmount, Labels::getLabel("LBL_RECEIVED_PAYMENT", $langId), Labels::getLabel('LBL_PAYMENT_FROM_USER_PAY_AT_STORE_ORDER', $langId), false, 0, Orders::ORDER_PAYMENT_PENDING);
        return true;
    }

    public function confirmCodOrder($orderId, $langId)
    {
        $langId = FatUtility::int($langId);

        $db = FatApp::getDb();
        if (!$db->updateFromArray('tbl_order_products', array('op_status_id' => FatApp::getConfig('CONF_COD_ORDER_STATUS', FatUtility::VAR_INT, 0)), array('smt' => 'op_order_id = ? ', 'vals' => array($orderId)))) {
            $this->error = $db->getError();
            return false;
        }


        $orderPaymentObj = new OrderPayment($orderId, $langId);
        $request = $orderPaymentObj->getPaymentGatewayCode();
        $orderPaymentObj->addOrderPaymentComments($request);

        $paymentAmount = $orderPaymentObj->getOrderPaymentGatewayAmount();
        $orderPaymentObj->addOrderPayment($request, 'C-' . time(), $paymentAmount, Labels::getLabel("LBL_RECEIVED_PAYMENT", $langId), Labels::getLabel('LBL_PAYMENT_FROM_USER_COD_ORDER', $langId), false, 0, Orders::ORDER_PAYMENT_PENDING);
        return true;
    }

    public function addOrderPaymentComments($comments, $notify = false)
    {
        $paymentOrderId = $this->paymentOrderId;
        $orderInfo = $this->attributes;
        if (!empty($orderInfo)) {
            $this->addOrderPaymentHistory($paymentOrderId, Orders::ORDER_PAYMENT_PENDING, $comments, $notify);
        } else {
            $this->error = Labels::getLabel('ERR_INVALID_ORDER', $this->commonLangId);
            return false;
        }
        return true;
    }

    public function chargeUserWallet($amountToBeCharge)
    {
        $defaultSiteLangId = FatApp::getConfig('conf_default_site_lang');
        $orderInfo = $this->attributes;
        $userWalletBalance = User::getUserBalance($orderInfo["order_user_id"]);

        if ($userWalletBalance < $amountToBeCharge) {
            $this->error = Message::addErrorMessage(Labels::getLabel('ERR_WALLET_BALANCE_IS_LESS_THAN_AMOUNT_TO_BE_CHARGE', $defaultSiteLangId));
            return false;
        }

        $transObj = new Transactions();
        $transaction_comment = Orders::getOrderCommentById($orderInfo["order_id"], $defaultSiteLangId);
        $txnDataArr = array(
            'utxn_user_id' => $orderInfo["order_user_id"],
            'utxn_debit' => $amountToBeCharge,
            'utxn_status' => Transactions::STATUS_COMPLETED,
            'utxn_order_id' => $orderInfo["order_id"],
            'utxn_comments' => $transaction_comment,
            'utxn_type' => Transactions::TYPE_ORDER_PAYMENT
        );
        if (!$transObj->addTransaction($txnDataArr)) {
            $this->error = $transObj->getError();
            return false;
        }

        // Update Order table user wallet charge amount
        $orderWalletAmountCharge = $orderInfo['order_wallet_amount_charge'] - $amountToBeCharge;
        if (!FatApp::getDb()->updateFromArray(Orders::DB_TBL, array('order_wallet_amount_charge' => $orderWalletAmountCharge), array('smt' => 'order_id = ?', 'vals' => array($orderInfo["order_id"])))) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }

        $this->addOrderPayment(Labels::getLabel('LBL_USER_WALLET', $defaultSiteLangId), 'W-' . time(), $amountToBeCharge, Labels::getLabel("LBL_RECEIVED_PAYMENT", $defaultSiteLangId), Labels::getLabel('LBL_PAYMENT_FROM_USER_WALLET', $defaultSiteLangId), true);
        return true;
    }

    public function chargeFreeOrder($amountToBeCharge = 0)
    {
        $defaultSiteLangId = FatApp::getConfig('conf_default_site_lang');
        $orderInfo = $this->attributes;

        if ($amountToBeCharge > 0) {
            $this->error = Labels::getLabel('ERR_INVALID_ORDER', $defaultSiteLangId);
            return false;
        }

        $transObj = new Transactions();
        $formattedOrderValue = "#" . $orderInfo["order_number"];

        if ($orderInfo['order_type'] == Orders::ORDER_PRODUCT) {
            $txnComment = sprintf(Labels::getLabel('MSG_PRODUCT_PURCHASED_%s', $defaultSiteLangId), $formattedOrderValue);
        } else {
            $txnComment = sprintf(Labels::getLabel('MSG_SUBSCRIPTION_PURCHASED_%s', $defaultSiteLangId), $formattedOrderValue);
        }
        $txnDataArr = array(
            'utxn_user_id' => $orderInfo["order_user_id"],
            'utxn_debit' => $amountToBeCharge,
            'utxn_status' => Transactions::STATUS_COMPLETED,
            'utxn_order_id' => $orderInfo["order_id"],
            'utxn_comments' => $txnComment,
            'utxn_type' => Transactions::TYPE_ORDER_PAYMENT
        );
        if (!$txnId = $transObj->addTransaction($txnDataArr)) {
            $this->error = $transObj->getError();
            return false;
        }
        /* Send email to User[ */
        /* $emailNotificationObj = new EmailHandler();
        $emailNotificationObj->sendTxnNotification( $txnId, $defaultSiteLangId ); */
        /* ] */

        $this->addOrderPayment(Labels::getLabel('LBL_USER_WALLET', $defaultSiteLangId), 'W-' . time(), $amountToBeCharge, Labels::getLabel("LBL_RECEIVED_PAYMENT", $defaultSiteLangId), Labels::getLabel('LBL_PAYMENT_FROM_USER_WALLET', $defaultSiteLangId), true);
        return true;
    }

    public function getPaymentGatewayResponse(): array
    {
        $orderPaymentInfo = $this->getOrderPayments(['order_id' => $this->paymentOrderId]);
        if (empty($orderPaymentInfo)) {
            return [];
        }
        $data = current($orderPaymentInfo);

        if (empty($data['opayment_gateway_response'])) {
            return [];
        }

        if (true == LibHelper::isJson($data['opayment_gateway_response'])) {
            return json_decode($data['opayment_gateway_response'], true);
        }

        return [$data['opayment_gateway_response']];
    }
}
