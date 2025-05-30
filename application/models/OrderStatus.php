<?php

class OrderStatus extends MyAppModel
{
    public const DB_TBL = 'tbl_orders_status';
    public const DB_TBL_PREFIX = 'orderstatus_';

    public const DB_TBL_LANG = 'tbl_orders_status_lang';
    public const DB_TBL_LANG_PREFIX = 'orderstatuslang_';

    public const FOR_DIGITAL_ONLY = 1;
    public const FOR_NON_DIGITAL = 2;

    public const ORDER_REFUNDED = 9;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->objMainTableRecord->setSensitiveFields([self::DB_TBL_PREFIX . 'id']);
        $this->db = FatApp::getDb();
    }

    public static function getSearchObject($isActive = true, $langId = 0)
    {
        $langId = FatUtility::int($langId);
        $srch = new SearchBase(static::DB_TBL, 'ostatus');

        if ($isActive == true) {
            $srch->addCondition('ostatus.' . static::DB_TBL_PREFIX . 'is_active', '=', applicationConstants::ACTIVE);
        }

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'ostatus_l.' . static::DB_TBL_LANG_PREFIX . 'orderstatus_id = ostatus.' . static::tblFld('id') . ' and
			ostatus_l.' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'ostatus_l'
            );
        }

        return $srch;
    }

    public static function nonCancellableStatuses()
    {
        return array(
            FatApp::getConfig("CONF_DEFAULT_SHIPPING_ORDER_STATUS"),
            FatApp::getConfig("CONF_DEFAULT_DEIVERED_ORDER_STATUS"),
            FatApp::getConfig("CONF_DEFAULT_COMPLETED_ORDER_STATUS"),
            FatApp::getConfig("CONF_RETURN_REQUEST_ORDER_STATUS"),
            FatApp::getConfig("CONF_DEFAULT_CANCEL_ORDER_STATUS"),
            static::ORDER_REFUNDED
        );
    }

    public static function getOrderStatusTypeArr($langId)
    {
        return array(
            Orders::ORDER_PRODUCT => Labels::getLabel('LBL_PRODUCt', $langId),
            Orders::ORDER_SUBSCRIPTION => Labels::getLabel('LBL_SUBSCRIPTIONS', $langId),
        );
    }

    public function updateOrder($order)
    {
        if (is_array($order) && sizeof($order) > 0) {
            foreach ($order as $i => $id) {
                if (FatUtility::int($id) < 1) {
                    continue;
                }

                FatApp::getDb()->updateFromArray(
                    static::DB_TBL,
                    array(
                        static::DB_TBL_PREFIX . 'priority' => $i
                    ),
                    array(
                        'smt' => static::DB_TBL_PREFIX . 'id = ?',
                        'vals' => array($id)
                    )
                );
            }
            return true;
        }
        return false;
    }

    /**
     * getOpStatusClass
     *
     * @param  int $status
     * @return string
     */
    public static function getOpStatusClass(int $status): string
    {
        $defaultPaid = FatApp::getConfig("CONF_DEFAULT_PAID_ORDER_STATUS");
        $defaultApproved = FatApp::getConfig("CONF_DEFAULT_APPROVED_ORDER_STATUS");
        $defaultInProcess = FatApp::getConfig("CONF_DEFAULT_INPROCESS_ORDER_STATUS");
        $defaultShipped = FatApp::getConfig("CONF_DEFAULT_SHIPPING_ORDER_STATUS");
        $defaultDelivered = FatApp::getConfig("CONF_DEFAULT_DEIVERED_ORDER_STATUS");
        $defaultCompleted = FatApp::getConfig("CONF_DEFAULT_COMPLETED_ORDER_STATUS");
        switch ($status) {
            case Orders::ORDER_PAYMENT_PENDING:
            case $defaultPaid:
            case $defaultApproved:
                return 'in-process';
                break;
            case $defaultInProcess:
                return 'ready-for-shipping';
                break;
            case $defaultShipped:
                return 'shipped';
                break;
            case $defaultDelivered:
            case $defaultCompleted:
                return 'delivered';
                break;

            default:
                return 'delivered';
                break;
        }
    }

    public static function getOrderStatusColorClassArray(): array
    {

        $tblHeadingCols = CacheHelper::get('getOrderStatusColorClassArray', CONF_DEF_CACHE_TIME, '.txt');
        if ($tblHeadingCols) {
            return json_decode($tblHeadingCols, true);
        }

        $srch =  self::getSearchObject();
        $srch->addMultipleFields(array('orderstatus_id', 'orderstatus_color_class'));
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        if (!$rs) {
            return array();
        }
        $arr = FatApp::getDb()->fetchAllAssoc($rs, 'orderstatus_id');
        $colorClasses  = applicationConstants::getClassArr();
        foreach ($arr as $statusId => $colorcode) {
            if($colorcode !== NULL)
            $arr[$statusId] = $colorClasses[$colorcode];
        }

        CacheHelper::create('getOrderStatusColorClassArray', json_encode($arr), CacheHelper::TYPE_ORDER_STATUS);
        return $arr;
    }
    /**
     * getDefaultOrderStausMsg
     *
     * @param  int $status
     * @param  int $langId
     * @return string
     */
    public static function getDefaultOrderStatusMsg(int $status, int $langId): string
    {
        $defaultPaid = FatApp::getConfig("CONF_DEFAULT_PAID_ORDER_STATUS");
        $defaultApproved = FatApp::getConfig("CONF_DEFAULT_APPROVED_ORDER_STATUS");
        $defaultInProcess = FatApp::getConfig("CONF_DEFAULT_INPROCESS_ORDER_STATUS");
        $defaultShipped = FatApp::getConfig("CONF_DEFAULT_SHIPPING_ORDER_STATUS");
        $defaultDelivered = FatApp::getConfig("CONF_DEFAULT_DEIVERED_ORDER_STATUS");
        $defaultCompleted = FatApp::getConfig("CONF_DEFAULT_COMPLETED_ORDER_STATUS");
        switch ($status) {
            case Orders::ORDER_PAYMENT_PENDING:
                return Labels::getLabel('LBL_TIMELINE_ORDER_STATUS_PENDING', $langId);
                break;
            case $defaultPaid:
                return Labels::getLabel('LBL_TIMELINE_ORDER_STATUS_PAID', $langId);
                break;
            case $defaultApproved:
                return Labels::getLabel('LBL_TIMELINE_ORDER_STATUS_APPROVED', $langId);
                break;
            case $defaultInProcess:
                return Labels::getLabel('LBL_TIMELINE_ORDER_STATUS_IN_PROCESS', $langId);
                break;
            case $defaultShipped:
                return Labels::getLabel('LBL_TIMELINE_ORDER_STATUS_SHIPPED', $langId);
                break;
            case $defaultDelivered:
                return Labels::getLabel('LBL_TIMELINE_ORDER_STATUS_DELIVERED', $langId);
                break;
            case $defaultCompleted:
                return Labels::getLabel('LBL_TIMELINE_ORDER_STATUS_COMPLETED', $langId);
                break;

            default:
                return '';
                break;
        }
    }
}
