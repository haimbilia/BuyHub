<?php

class OrderProduct extends MyAppModel
{
    public const DB_TBL = 'tbl_order_products';
    public const DB_TBL_PREFIX = 'op_';

    public const DB_TBL_LANG = 'tbl_order_products_lang';
    public const DB_TBL_CHARGES = 'tbl_order_product_charges';
    public const DB_TBL_CHARGES_PREFIX = 'opcharge_';
    public const DB_TBL_OP_TO_SHIPPING_USERS = 'tbl_order_product_to_shipping_users';

    public const DB_TBL_SETTINGS = 'tbl_order_product_settings';
    public const DB_TBL_SETTINGS_PREFIX = 'opsetting_';

    public const DB_TBL_RESPONSE = 'tbl_order_product_responses';
    public const DB_TBL_RESPONSE_PREFIX = 'opr_';    

    public const DB_TBL_SHIPMENT_PICKUP = 'tbl_order_product_shipment_pickup';
    public const DB_TBL_SHIPMENT_PICKUP_PREFIX = 'opsp_';    

    public const DB_TBL_PLUGIN_SPECIFICS = 'tbl_order_product_plugin_specifics';
    public const DB_TBL_PLUGIN_SPECIFICS_PREFIX = 'opps_';

    public const CHARGE_TYPE_TAX = 1;
    public const CHARGE_TYPE_DISCOUNT = 2;
    public const CHARGE_TYPE_SHIPPING = 3;
    /* public const CHARGE_TYPE_BATCH_DISCOUNT = 4; */
    public const CHARGE_TYPE_REWARD_POINT_DISCOUNT = 5;
    public const CHARGE_TYPE_VOLUME_DISCOUNT = 6;
    public const CHARGE_TYPE_ADJUST_SUBSCRIPTION_PRICE = 7;

    public const RESPONSE_TYPE_SHIPMENT = 1;
    public const RESPONSE_TYPE_RETURN = 2;
    public const RESPONSE_TYPE_REFUND = 3;
    
    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getSearchObject($langId = 0)
    {
        $srch = new SearchBase(static::DB_TBL, 'op');

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'op_l.oplang_op_id = o.op_id
			AND op_l.oplang_lang_id = ' . $langId,
                'op_l'
            );
        }

        return $srch;
    }

    public static function getChargeTypeArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }
        return array(
            static::CHARGE_TYPE_TAX => Labels::getLabel('LBL_Order_Product_Tax_Charges', $langId),
            static::CHARGE_TYPE_DISCOUNT => Labels::getLabel('LBL_Order_Product_Discount_Charges', $langId),
            static::CHARGE_TYPE_SHIPPING => Labels::getLabel('LBL_Order_Product_Shipping_Charges', $langId),
            /* static::CHARGE_TYPE_BATCH_DISCOUNT=>Labels::getLabel('LBL_Order_Product_Batch_Discount', $langId), */
            static::CHARGE_TYPE_REWARD_POINT_DISCOUNT => Labels::getLabel('LBL_Order_Product_Reward_Point', $langId),
            static::CHARGE_TYPE_VOLUME_DISCOUNT => Labels::getLabel('LBL_Order_Product_Volume_Discount', $langId),
        );
    }

    public static function getOpIdArrByOrderId($orderId)
    {
        $opSrch = static::getSearchObject();
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();
        $opSrch->addMultipleFields(array('op_id'));
        $opSrch->addCondition('op_order_id', '=', $orderId);
        $rs = $opSrch->getResultSet();
        return $row = FatApp::getDb()->fetchAll($rs, 'op_id');
    }

    public static function getOpArrByOrderId($orderId, $checkNotCancelled = true)
    {
        $opSrch = OrderProduct::getSearchObject();
        $opSrch->doNotCalculateRecords();
        $opSrch->doNotLimitRecords();
        $opSrch->addMultipleFields(array('op_id', 'op_selprod_id', 'op_selprod_user_id', 'op_unit_price', 'op_qty', 'op_actual_shipping_charges', 'op_refund_qty'));
        $opSrch->addCondition('op_order_id', '=', $orderId);

        if ($checkNotCancelled) {
            $opSrch->joinTable(OrderCancelRequest::DB_TBL, 'LEFT OUTER JOIN', 'ocr.' . OrderCancelRequest::DB_TBL_PREFIX . 'op_id = op.op_id', 'ocr');
            $cnd = $opSrch->addCondition(OrderCancelRequest::DB_TBL_PREFIX . 'status', '!=', OrderCancelRequest::CANCELLATION_REQUEST_STATUS_APPROVED);
            $cnd->attachCondition(OrderCancelRequest::DB_TBL_PREFIX . 'status', 'IS', 'mysql_func_null', 'OR', true);
        }
        $rs = $opSrch->getResultSet();
        return $rows = FatApp::getDb()->fetchAll($rs);
    }

    public function setupSettings()
    {
        if ($this->mainTableRecordId < 1) {
            return false;
        }

        $data = array(
            'opsetting_op_id' => $this->mainTableRecordId,
            'op_tax_collected_by_seller' => FatApp::getConfig('CONF_TAX_COLLECTED_BY_SELLER', FatUtility::VAR_INT, 0),
            'op_commission_include_tax' => FatApp::getConfig('CONF_COMMISSION_INCLUDING_TAX', FatUtility::VAR_INT, 0),
            'op_commission_include_shipping' => FatApp::getConfig('CONF_COMMISSION_INCLUDING_SHIPPING', FatUtility::VAR_INT, 0)
        );

        if (FatApp::getDb()->insertFromArray(static::DB_TBL_SETTINGS, $data, false, array(), $data)) {
            return true;
        }
        return false;
    }

    public static function pendingForReviews($userId, $langId = 0)
    {
        $srch = new OrderProductSearch($langId, true);
        $srch->joinSellerProducts($langId);
        $srch->addStatusCondition(SelProdReview::getBuyerAllowedOrderReviewStatuses());
        $srch->joinTable('tbl_seller_product_reviews', 'left outer join', 'o.order_id = spr.spreview_order_id and ((op.op_selprod_id = spr.spreview_selprod_id and op.op_is_batch = 0) || (op.op_batch_selprod_id = spr.spreview_selprod_id and op.op_is_batch = 1))', 'spr');
        $srch->addCondition('o.order_user_id', '=', $userId);
        $srch->addCondition('spr.spreview_id', 'is', 'mysql_func_null', 'and', true);
        $srch->addMultipleFields(array('op_id', 'op_selprod_id', 'op_order_id', 'selprod_title', 'selprod_product_id', 'order_id', 'order_user_id', 'op_qty', 'op_unit_price', 'op_selprod_options'));
        $rows = FatApp::getDb()->fetchAll($srch->getResultSet());
        return $rows;
    }
    
    /**
     * getResponseTypes
     *
     * @param  int $langId
     * @return array
     */
    public static function getResponseTypes(int $langId): array
    {
        return [
            self::RESPONSE_TYPE_SHIPMENT => Labels::getLabel('LBL_SHIPMENT', $langId),
            self::RESPONSE_TYPE_RETURN => Labels::getLabel('LBL_RETURN', $langId),
            self::RESPONSE_TYPE_REFUND => Labels::getLabel('LBL_REFUND', $langId),
        ];
    }
    
    /**
     * isValidResponseType
     *
     * @param  int $type
     * @return bool
     */
    public static function isValidResponseType(int $type): bool
    {
        return array_key_exists($type, self::getResponseTypes(0));
    }
    
    /**
     * bindResponse
     *
     * @param  int $type
     * @param  string $response
     * @return bool
     */
    public function bindResponse(int $type, string $response): bool
    {
        if (1 > $this->mainTableRecordId) {
            $this->error = Labels::getLabel('MSG_INVALID_ORDER_PRODUCT_ID', 0);
            return false;
        }

        if (false === self::isValidResponseType($type)) {
            $this->error = Labels::getLabel('MSG_INVALID_RESPONSE_TYPE', 0);
            return false;
        }

        $dataToInsert = [
            'opr_op_id' => $this->mainTableRecordId,
            'opr_type' => $type
        ];

        $updateOnDuplicate = [
            'opr_response' => $response,
            'opr_added_on' => date('Y-m-d H:i:s')
        ];
        
        $dataToInsert = array_merge($dataToInsert, $updateOnDuplicate);

        $db = FatApp::getDb();
        if (!$db->insertFromArray(static::DB_TBL_RESPONSE, $dataToInsert, false, [], $updateOnDuplicate)) {
            $this->error = $db->getError();
            return false;
        }
        return true;
    }
    
    /**
     * getResponse : Belongs to third party response
     *
     * @param  int $type
     * @param  int $joinTypeTables
     * @param  int $attr
     * @param  int $langId
     * @return array
     */
    public function getResponse(int $type = 0, bool $joinTypeTables = false, array $attr = [], int $langId = 0): array
    {
        if (1 > $this->mainTableRecordId) {
            $this->error = Labels::getLabel('MSG_INVALID_ORDER_PRODUCT_ID', $langId);
            return [];
        }

        if (0 < $type && false === self::isValidResponseType($type)) {
            $this->error = Labels::getLabel('MSG_INVALID_RESPONSE_TYPE', $langId);
            return [];
        }

        $srch = new SearchBase(static::DB_TBL_RESPONSE, 'opr');

        if (empty($attr)) {
            $attr = ['opr_response'];
        }

        $attr = !in_array('opr_response', $attr) ? array_merge($attr, ['opr_response']) : $attr;
        $attr = (1 > $type) ? array_merge($attr, ['opr_type']) : $attr;

        $srch->addMultipleFields($attr);
        $srch->joinTable(self::DB_TBL, 'INNER JOIN', 'op.op_id = opr.opr_op_id', 'op');
        $srch->addCondition('opr.' . static::DB_TBL_RESPONSE_PREFIX . 'op_id', '=', $this->mainTableRecordId);
        if (0 < $type) {
            $srch->addCondition('opr.' . static::DB_TBL_RESPONSE_PREFIX . 'type', '=', $type);
            if (true === $joinTypeTables) {
                switch ($type) {
                    case self::RESPONSE_TYPE_REFUND:
                    case self::RESPONSE_TYPE_SHIPMENT:
                        $srch->joinTable(OrderProductShipment::DB_TBL, 'INNER JOIN', 'ops.opship_op_id = opr.opr_op_id', 'ops');
                        break;
                    case self::RESPONSE_TYPE_RETURN:
                        $srch->joinTable(OrderReturnRequest::DB_TBL, 'INNER JOIN', 'orr.orrequest_op_id = opr.opr_op_id', 'orr');
                        break;
                }
            }
        }

        $rs = $srch->getResultSet();
        return FatApp::getDb()->fetchAll($rs);
    }

    public function getSpecifics()
    {
        if ($this->mainTableRecordId < 1) {
            return [];
        }
        $srch = new OrderProductSearch(0, true);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(['op_selprod_return_age', 'op_selprod_cancellation_age', 'op_product_warranty', 'op_prodcat_id']
        );
        $srch->joinOrderProductSpecifics();
        $srch->addCondition('op.op_id', '=', $this->mainTableRecordId);

        $rs = $srch->getResultSet();
        return (array) FatApp::getDb()->fetch($rs);
    }

    public static function moreAttachmentsForm($langId)
    {
        $frm = new Form('additional_attachments');
        $frm->addHiddenField('', 'op_id');
        $frm->addFileUpload(Labels::getLabel('LBL_Upload_File', $langId), 'downloadable_file', array('id' => 'downloadable_file'));
        return $frm;
    }
        
    /**
     * getOrderActionRate
     *
     * @param  int $sellerId
     * @param  int $status
     * @return float
     */
    private static function getOrderActionRate(int $sellerId, int $status)
    {
        $srch = new OrderProductSearch();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('op_selprod_user_id', '=', $sellerId);
        $srch->addMultipleFields(['((SUM(CASE WHEN op_status_id = ' . $status . ' THEN 1 ELSE 0 END)/count(op_id)) * 100) as rate']);
        $compltedOrderRate = (array) FatApp::getDb()->fetch($srch->getResultSet());
        if (empty($compltedOrderRate)) {
            return 0;
        }
        return (float) CommonHelper::numberFormat($compltedOrderRate['rate'], true, true, 1);
    }

    /**
     * getCompletionRate
     *
     * @param  int $sellerId
     * @return float
     */
    public static function getCompletionRate(int $sellerId): float
    {
        $status = FatApp::getConfig("CONF_DEFAULT_COMPLETED_ORDER_STATUS", FatUtility::VAR_STRING, '');
        if (empty($status)) {
            return 0;
        }

        return self::getOrderActionRate($sellerId, $status);
    }

    /**
     * getCancellationRate
     *
     * @param  int $sellerId
     * @return float
     */
    public static function getCancellationRate(int $sellerId): float
    {
        $status = FatApp::getConfig("CONF_DEFAULT_CANCEL_ORDER_STATUS", FatUtility::VAR_STRING, '');
        if (empty($status)) {
            return 0;
        }

        return self::getOrderActionRate($sellerId, $status);
    }

    /**
     * getReturnAcceptanceRate
     *
     * @param  int $sellerId
     * @return float
     */
    public static function getReturnAcceptanceRate(int $sellerId): float
    {
        $status = FatApp::getConfig("CONF_RETURN_REQUEST_APPROVED_ORDER_STATUS", FatUtility::VAR_STRING, '');
        if (empty($status)) {
            return 0;
        }

        return self::getOrderActionRate($sellerId, $status);
    }
    
    /**
     * getCompltedOrderCount
     *
     * @param  int $sellerId
     * @return int
     */
    public static function getCompltedOrderCount(int $sellerId): int
    {
        $completedOrderStatus = FatApp::getConfig("CONF_DEFAULT_COMPLETED_ORDER_STATUS", FatUtility::VAR_STRING, '');
        if (empty($completedOrderStatus)) {
            return 0;
        }

        $srch = new OrderProductSearch();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('op_selprod_user_id', '=', $sellerId);
        $srch->addMultipleFields(['count(op_id) as completedOrdersCount']);
        $srch->addCondition('op_status_id', '=', $completedOrderStatus);
        $compltedOrderRate = (array) FatApp::getDb()->fetch($srch->getResultSet());
        if (empty($compltedOrderRate)) {
            return 0;
        }
        return (int) $compltedOrderRate['completedOrdersCount'];
    }    
    
    public static function getPickUpShedule($op_id)
    {
        $srch = new SearchBase(static::DB_TBL_SHIPMENT_PICKUP);
        $srch->addCondition('opsp_op_id', '=', $op_id);
        return FatApp::getDb()->fetch($srch->getResultSet());
    }

}
