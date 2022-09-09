<?php

class OrderReturnRequest extends MyAppModel
{
    public const DB_TBL = 'tbl_order_return_requests';
    public const DB_TBL_PREFIX = 'orrequest_';

    public const DB_TBL_RETURN_REQUEST_MESSAGE = 'tbl_order_return_request_messages';

    public const RETURN_REQUEST_TYPE_REPLACE = 1;
    public const RETURN_REQUEST_TYPE_REFUND = 2;

    public const RETURN_REQUEST_STATUS_PENDING = 0;
    public const RETURN_REQUEST_STATUS_ESCALATED = 1;
    public const RETURN_REQUEST_STATUS_REFUNDED = 2;
    public const RETURN_REQUEST_STATUS_WITHDRAWN = 3;
    public const RETURN_REQUEST_STATUS_CANCELLED = 4;

    public const CLASS_REQUEST_STATUS_PENDING = 'warning';
    public const CLASS_REQUEST_STATUS_ESCALATED = 'info';
    public const CLASS_REQUEST_STATUS_REFUNDED = 'green';
    public const CLASS_REQUEST_STATUS_WITHDRAWN = 'purple';
    public const CLASS_REQUEST_STATUS_CANCELLED = 'danger';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getSearchObject($langId = 0)
    {
        return new SearchBase(static::DB_TBL, 'orr');
    }

    public static function getRequestTypeArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
            /* static::RETURN_REQUEST_TYPE_REPLACE => Labels::getLabel( 'LBL_Order_Request_Type_Replace', $langId ), */
            static::RETURN_REQUEST_TYPE_REFUND => Labels::getLabel('LBL_ORDER_REQUEST_TYPE_REFUND', $langId),
        );
    }

    public static function getRequestStatusClass()
    {
        return array(
            static::RETURN_REQUEST_STATUS_PENDING => static::CLASS_REQUEST_STATUS_PENDING,
            static::RETURN_REQUEST_STATUS_ESCALATED => static::CLASS_REQUEST_STATUS_ESCALATED,
            static::RETURN_REQUEST_STATUS_REFUNDED => static::CLASS_REQUEST_STATUS_REFUNDED,
            static::RETURN_REQUEST_STATUS_WITHDRAWN => static::CLASS_REQUEST_STATUS_WITHDRAWN,
            static::RETURN_REQUEST_STATUS_CANCELLED => static::CLASS_REQUEST_STATUS_CANCELLED,
        );
    }


    public static function getRequestStatusArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }
        return array(
            static::RETURN_REQUEST_STATUS_PENDING => Labels::getLabel('LBL_RETURN_REQUEST_STATUS_PENDING', $langId),
            static::RETURN_REQUEST_STATUS_ESCALATED => Labels::getLabel('LBL_RETURN_REQUEST_STATUS_ESCALATED', $langId),
            static::RETURN_REQUEST_STATUS_REFUNDED => Labels::getLabel('LBL_RETURN_REQUEST_STATUS_REFUNDED', $langId),
            static::RETURN_REQUEST_STATUS_WITHDRAWN => Labels::getLabel('LBL_RETURN_REQUEST_STATUS_WITHDRAWN', $langId),
            static::RETURN_REQUEST_STATUS_CANCELLED => Labels::getLabel('LBL_RETURN_REQUEST_STATUS_CANCELLED', $langId),
        );
    }

    public static function getRequestStatusClassArr()
    {
        return array(
            static::RETURN_REQUEST_STATUS_PENDING => applicationConstants::CLASS_INFO,
            static::RETURN_REQUEST_STATUS_ESCALATED => applicationConstants::CLASS_INFO,
            static::RETURN_REQUEST_STATUS_REFUNDED => applicationConstants::CLASS_SUCCESS,
            static::RETURN_REQUEST_STATUS_WITHDRAWN => applicationConstants::CLASS_WARNING,
            static::RETURN_REQUEST_STATUS_CANCELLED => applicationConstants::CLASS_DANGER,
        );
    }

    public function escalateRequest($orrequest_id, $user_id, $langId)
    {
        $orrequest_id = FatUtility::int($orrequest_id);
        $langId = FatUtility::int($langId);
        $user_id = FatUtility::int($user_id);
        if ($orrequest_id < 1 || $langId < 1 || $user_id < 1) {
            trigger_error(Labels::getLabel('ERR_INVALID_ARGUMENT_PASSED', $this->commonLangId), E_USER_ERROR);
        }
        $db = FatApp::getDb();
        $dataToUpdate = array('orrequest_status' => static::RETURN_REQUEST_STATUS_ESCALATED);
        $whereArr = array('smt' => 'orrequest_id = ?', 'vals' => array($orrequest_id));
        if (!$db->updateFromArray(static::DB_TBL, $dataToUpdate, $whereArr)) {
            $this->error = $db->getError();
            return false;
        }
        $orrmsg_msg = str_replace('{website_name}', FatApp::getConfig('CONF_WEBSITE_NAME_' . $langId), Labels::getLabel('LBL_RETURN_REQUEST_ESCALATED_TO', $langId));
        $dataToSave = array(
            'orrmsg_orrequest_id' => $orrequest_id,
            'orrmsg_from_user_id' => $user_id,
            'orrmsg_msg' => $orrmsg_msg,
            'orrmsg_date' => date('Y-m-d H:i:s'),
            'orrmsg_deleted' => 0,
        );
        if (!$db->insertFromArray(OrderReturnRequestMessage::DB_TBL, $dataToSave)) {
            $this->error = $db->getError();
            return false;
        }
        return true;
    }

    public function withdrawRequest($orrequest_id, $user_id, $langId, $op_id, $orderLangId)
    {
        $orrequest_id = FatUtility::int($orrequest_id);
        $langId = FatUtility::int($langId);
        $user_id = FatUtility::int($user_id);
        $op_id = FatUtility::int($op_id);
        $orderLangId = FatUtility::int($orderLangId);

        if ($orrequest_id < 1 || $langId < 1 || $op_id < 1 || $orderLangId < 1) {
            trigger_error(Labels::getLabel('ERR_INVALID_ARGUMENT_PASSED', $this->commonLangId), E_USER_ERROR);
        }
        $db = FatApp::getDb();

        $dataToUpdate = array('orrequest_status' => static::RETURN_REQUEST_STATUS_WITHDRAWN);
        $whereArr = array('smt' => 'orrequest_id = ?', 'vals' => array($orrequest_id));
        if (!$db->updateFromArray(static::DB_TBL, $dataToUpdate, $whereArr)) {
            $this->error = $db->getError();
            return false;
        }

        $orrmsg_msg = Labels::getLabel('ERR_RETURN_REQUEST_WITHDRAWN', $this->commonLangId);
        $dataToSave = array(
            'orrmsg_orrequest_id' => $orrequest_id,
            'orrmsg_from_user_id' => $user_id,
            'orrmsg_msg' => $orrmsg_msg,
            'orrmsg_date' => date('Y-m-d H:i:s'),
            'orrmsg_deleted' => 0,
        );

        if (!$user_id && AdminAuthentication::isAdminLogged()) {
            $dataToSave['orrmsg_from_admin_id'] = AdminAuthentication::getLoggedAdminId();
        }
        if (!$db->insertFromArray(OrderReturnRequestMessage::DB_TBL, $dataToSave)) {
            $this->error = $db->getError();
            return false;
        }

        $oObj = new Orders();
        $oObj->addChildProductOrderHistory($op_id, $orderLangId, FatApp::getConfig("CONF_RETURN_REQUEST_WITHDRAWN_ORDER_STATUS"), Labels::getLabel('MSG_RETURN_REQUEST_WITHDRAWN', $orderLangId), 1);
        return true;
    }

    public function approveRequest($orrequest_id, $user_id, $langId, $moveRefundInWallet = true, $adminComment = '', $thirdPartyResponse = '')
    {
        $orrequest_id = FatUtility::int($orrequest_id);
        $langId = FatUtility::int($langId);
        $user_id = FatUtility::int($user_id);

        if ($orrequest_id < 1 || $langId < 1) {
            trigger_error(Labels::getLabel('ERR_INVALID_ARGUMENT_PASSED!', $this->commonLangId), E_USER_ERROR);
        }
        $db = FatApp::getDb();

        $srch = new OrderReturnRequestSearch();
        $srch->joinOrderProducts();
        $srch->joinOrderProductSettings();
        $srch->joinShippingCharges();
        $srch->joinOrders();
        $srch->addOrderProductCharges();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('orrequest_id', '=', $orrequest_id);
        $srch->addMultipleFields(array('orrequest_id', 'orrequest_op_id', 'orrequest_qty', 'orrequest_type', 'op_commission_percentage',
         'op_affiliate_commission_percentage', 'op_qty', 'order_language_id', 'op_shop_owner_name', 'op_unit_price', 'op_other_charges', 'op_commission_include_shipping', 'op_tax_collected_by_seller', 'op_commission_include_tax', 'op_free_ship_upto',
         'op_actual_shipping_charges', 'op_rounding_off', 'order_pmethod_id','op_selprod_user_id','opshipping_by_seller_user_id'));
        $rs = $srch->getResultSet();
        $requestRow = $db->fetch($rs);

        if (!$requestRow) {
            $this->error = Labels::getLabel("ERR_INVALID_REQUEST", $this->commonLangId);
            return false;
        }

        $canRefundToCard = (PaymentMethods::MOVE_TO_CUSTOMER_CARD == $moveRefundInWallet);

        $oObj = new Orders();
        $charges = $oObj->getOrderProductChargesArr($requestRow['orrequest_op_id']);
        $requestRow['charges'] = $charges;

        $orderLangId = $requestRow['order_language_id'];

        $db->startTransaction();
        $dataToUpdate = array(
            'orrequest_status' => static::RETURN_REQUEST_STATUS_REFUNDED,
            'orrequest_refund_in_wallet' => $moveRefundInWallet,
            'orrequest_admin_comment' => $adminComment,
        );
        $whereArr = array('smt' => 'orrequest_id = ?', 'vals' => array($requestRow['orrequest_id']));
        if (!$db->updateFromArray(static::DB_TBL, $dataToUpdate, $whereArr)) {
            $this->error = $db->getError();
            $db->rollbackTransaction();
            return false;
        }

        $approved_by_person_name = $requestRow['op_shop_owner_name'];
        if (!$user_id && AdminAuthentication::isAdminLogged()) {
            $approved_by_person_name = FatApp::getConfig('CONF_WEBSITE_NAME_' . $orderLangId);
        }

        $orrmsg_msg = str_replace("{approved_by_person_name}", $approved_by_person_name, Labels::getLabel('LBL_RETURN_REQUEST_APPROVED_BY', $orderLangId));
        $dataToSave = array(
            'orrmsg_orrequest_id' => $orrequest_id,
            'orrmsg_from_user_id' => $user_id,
            'orrmsg_msg' => $orrmsg_msg,
            'orrmsg_date' => date('Y-m-d H:i:s'),
            'orrmsg_deleted' => 0,
        );

        if (!$user_id && AdminAuthentication::isAdminLogged()) {
            $dataToSave['orrmsg_from_admin_id'] = AdminAuthentication::getLoggedAdminId();
        }

        if (!$db->insertFromArray(OrderReturnRequestMessage::DB_TBL, $dataToSave)) {
            $this->error = $db->getError();
            $db->rollbackTransaction();
            return false;
        }

        if ($requestRow['orrequest_type'] == static::RETURN_REQUEST_TYPE_REPLACE) {
            $moveRefundInWallet = false;
        }

        if ($moveRefundInWallet && $requestRow['orrequest_type'] == static::RETURN_REQUEST_TYPE_REFUND) {
            $opDataToUpdate = CommonHelper::getOrderProductRefundAmtArr($requestRow);
            unset($opDataToUpdate['op_cart_amount']);
            unset($opDataToUpdate['op_prod_price']);
            $whereArr = array('smt' => 'op_id = ?', 'vals' => array($requestRow['orrequest_op_id']));
            if (!$db->updateFromArray(OrderProduct::DB_TBL, $opDataToUpdate, $whereArr)) {
                $this->error = $db->getError();
                $db->rollbackTransaction();
                return false;
            }
        }

        $approvedByLabel = sprintf(Labels::getLabel('LBL_APPROVED_RETURN_REQUEST', $orderLangId), $requestRow['op_shop_owner_name']);
        if (!$user_id && AdminAuthentication::isAdminLogged()) {
            $approvedByLabel = sprintf(Labels::getLabel('LBL_APPROVED_RETURN_REQUEST', $orderLangId), FatApp::getConfig('CONF_WEBSITE_NAME_' . $orderLangId));
        }
        if (true == $oObj->addChildProductOrderHistory($requestRow['orrequest_op_id'], $orderLangId, FatApp::getConfig("CONF_RETURN_REQUEST_APPROVED_ORDER_STATUS"), $approvedByLabel, 1, '', 0, $moveRefundInWallet)) {
            if (true === $canRefundToCard) {
                $pluginKey = Plugin::getAttributesById($requestRow['order_pmethod_id'], 'plugin_code');

                $paymentMethodObj = new PaymentMethods();
                if (true === $paymentMethodObj->canRefundToCard($pluginKey, $orderLangId)) {
                    if (false == $paymentMethodObj->initiateRefund($requestRow)) {
                        $this->error = $paymentMethodObj->getError();
                        $db->rollbackTransaction();
                        return false;
                    }
                    $resp = $paymentMethodObj->getResponse();
                    if (empty($resp)) {
                        $this->error = Labels::getLabel('ERR_UNABLE_TO_PLACE_GATEWAY_REFUND_REQUEST', $orderLangId);
                        $db->rollbackTransaction();
                        return false;
                    }

                    // Debit from wallet if plugin/payment method support's direct payment to card.
                    if (!empty($resp->id)) {
                        $childOrderInfo = $oObj->getOrderProductsByOpId($requestRow['orrequest_op_id'], $orderLangId);
                        $txnAmount = $childOrderInfo['op_refund_amount'];
                        $comments = Labels::getLabel('LBL_TRANSFERED_TO_YOUR_CARD._INVOICE_#{invoice-no}', $orderLangId);
                        $comments = CommonHelper::replaceStringData($comments, ['{invoice-no}' => $childOrderInfo['op_invoice_number']]);
                        Transactions::debitWallet($childOrderInfo['order_user_id'], Transactions::TYPE_ORDER_REFUND, $txnAmount, $orderLangId, $comments, $requestRow['orrequest_op_id'], $resp->id);
                    }

                    $dataToUpdate = ['orrequest_payment_gateway_req_id' => $resp->id];
                    $whereArr = array('smt' => 'orrequest_id = ?', 'vals' => [$orrequest_id]);
                    if (!$db->updateFromArray(static::DB_TBL, $dataToUpdate, $whereArr)) {
                        $this->error = $db->getError();
                        $db->rollbackTransaction();
                        return false;
                    }
                }
            }
        }
        $db->commitTransaction();
        return true;
    }

    public static function getReturnRequestById($opId, $attr = null, $joinOrderProduct = false)
    {
        $opId = FatUtility::convertToType($opId, FatUtility::VAR_INT);
        if (1 > $opId) {
            return false;
        }

        $db = FatApp::getDb();

        $srch = new SearchBase(static::DB_TBL);
        $srch->joinTable(OrderProduct::DB_TBL_RESPONSE, 'LEFT JOIN', 'opr_op_id = orrequest_op_id AND opr_type = ' . OrderProduct::RESPONSE_TYPE_RETURN, 'opr');
        if (true === $joinOrderProduct) {
            $srch->joinTable(Orders::DB_TBL_ORDER_PRODUCTS, 'LEFT OUTER JOIN', 'op.op_id = orrequest_op_id', 'op');
        }
        $srch->addCondition('orrequest_op_id', '=', $opId);

        if (null != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }

        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = $db->fetch($rs);

        if (!is_array($row)) {
            return false;
        }

        if (is_string($attr)) {
            return $row[$attr];
        }
        return $row;
    }


    public static function getStatusHtml(int $langId, int $status): string
    {
        $arr = self::getRequestStatusArr($langId);
        $msg = $arr[$status] ?? Labels::getLabel('LBL_N/A', $langId);
        switch ($status) {
            case static::RETURN_REQUEST_STATUS_PENDING:
                $status = HtmlHelper::INFO;
                break;
            case static::RETURN_REQUEST_STATUS_ESCALATED:
                $status = HtmlHelper::PRIMARY;
                break;
            case static::RETURN_REQUEST_STATUS_REFUNDED:
                $status = HtmlHelper::SUCCESS;
                break;
            case static::RETURN_REQUEST_STATUS_WITHDRAWN:
                $status = HtmlHelper::WARNING;
                break;
            case static::RETURN_REQUEST_STATUS_CANCELLED:
                $status = HtmlHelper::DANGER;
                break;
            default:
                $status = HtmlHelper::PRIMARY;
                break;
        }
        return HtmlHelper::getStatusHtml($status, rtrim($msg));
    }
}
