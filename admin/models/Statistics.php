<?php

class Statistics extends MyAppModel
{
    public const BY_TODAY = 1;
    public const BY_THIS_WEEK = 7;
    public const BY_THIS_MONTH = 30;
    public const BY_LAST_3_MONTHS = 90;
    public const BY_THIS_YEAR = 365;
    public const BY_ALL = -1;
    private $db = '';

    public function __construct()
    {
        $this->db = FatApp::getDb();
    }

    public static function getIntervals($langId)
    {
        return [
            self::BY_TODAY =>  Labels::getLabel('LBL_TODAY', $langId),
            self::BY_THIS_WEEK =>  Labels::getLabel('LBL_THIS_WEEK', $langId),
            self::BY_THIS_MONTH =>  Labels::getLabel('LBL_THIS_MONTH', $langId),
            self::BY_LAST_3_MONTHS =>  Labels::getLabel('LBL_LAST_3_MONTH', $langId),
            self::BY_ALL =>  Labels::getLabel('LBL_ALL', $langId)
        ];
    }

    public static function getIntervalCondition($interval, $fld)
    {
        switch ($interval) {
            case self::BY_TODAY:
                return 'DATE(' . $fld . ') = DATE(NOW())';
                break;
            case self::BY_THIS_WEEK:
                return  $fld . ' > DATE(now() - INTERVAL 7 DAY)';
                break;
            case self::BY_THIS_MONTH:
                return  $fld . ' > DATE(now() - INTERVAL 1 MONTH)';
                break;
            case self::BY_LAST_3_MONTHS:
                return  $fld . ' > DATE(now() - INTERVAL 3 MONTH)';
                break;
            case self::BY_THIS_YEAR:
                return 'YEAR(' . $fld . ') = YEAR(NOW())';
                break;
        }
    }

    public function getDashboardSummary($type)
    {
        $type = strtolower($type);
        switch ($type) {
            case 'signups':
                $userObj = new User();
                $srch = $userObj->getUserSearchObj();
                $srch->doNotCalculateRecords();
                $srch->doNotLimitRecords();
                $srch->addCondition('u.user_is_shipping_company', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
                $srch->addMultipleFields(array('count(user_id) as total_users'));
                $rs = $srch->getResultSet();
                return  $this->db->fetch($rs);
                break;
            case 'shops':
                $srch = new ShopSearch();
                $srch->joinShopOwner();
                $srch->doNotCalculateRecords();
                $srch->doNotLimitRecords();
                $srch->addMultipleFields(array('count(shop_id) as total_shops'));
                $rs = $srch->getResultSet();
                return $this->db->fetch($rs);
                break;
            case 'products':
                $srch = Product::getSearchObject();
                $srch->doNotCalculateRecords();
                $srch->doNotLimitRecords();
                $srch->addMultipleFields(array('count(product_id) as total_products'));
                $rs = $srch->getResultSet();
                return $this->db->fetch($rs);
                break;
            case 'orders':
                $srch = new OrderSearch();
                $srch->joinOrderPaymentMethod();
                $srch->doNotCalculateRecords();
                $srch->doNotLimitRecords();
                $cnd = $srch->addCondition('order_payment_status', '=', 'mysql_func_' . Orders::ORDER_PAYMENT_PAID, 'AND', true);
                $cnd->attachCondition('plugin_code', '=', 'CashOnDelivery');
                $cnd->attachCondition('plugin_code', '=', 'payatstore');
                $srch->addMultipleFields(array('avg(order_net_amount) AS avg_order,count(order_id) as total_orders'));
                $rs = $srch->getResultSet();
                return $this->db->fetch($rs);
                break;
            case 'sales':
                $srch = new OrderProductSearch();
                $srch->joinorders();
                $srch->joinPaymentMethod();
                $srch->addOrderProductCharges();
                $srch->doNotCalculateRecords();
                $srch->doNotLimitRecords();
                $cnd = $srch->addCondition('order_payment_status', '=', 'mysql_func_' . Orders::ORDER_PAYMENT_PAID, 'AND', true);
                $cnd->attachCondition('plugin_code', '=', 'CashOnDelivery');
                $cnd->attachCondition('plugin_code', '=', 'payatstore');
                $completedOrderStatus = unserialize(FatApp::getConfig("CONF_COMPLETED_ORDER_STATUS"));
                $srch->addStatusCondition($completedOrderStatus);
                $srch->addMultipleFields(array('SUM((op_unit_price * op_qty ) + COALESCE(op_other_charges,0) + COALESCE(op_rounding_off,0) - COALESCE(op_refund_amount,0)) AS lifetime_sales,avg((op_unit_price * op_qty ) + COALESCE(op_other_charges,0) + COALESCE(op_rounding_off,0) - COALESCE(op_refund_amount,0)) AS avg_order,count(op_id) as total_orders'));
                $rs = $srch->getResultSet();
                return $this->db->fetch($rs);
                break;
        }
    }

    public function getDashboardLast12MonthsSummary($langId, $type, $userTypeArr = array(), $months = 12)
    {
        $last12Months = Stats::getLast12MonthsDetails($months);
        $type = strtolower($type);
        switch ($type) {
            case 'sales':
                $srch = new OrderProductSearch();
                $srch->joinorders();
                $srch->joinPaymentMethod();
                $srch->addOrderProductCharges();
                $srch->doNotCalculateRecords();
                $srch->doNotLimitRecords();
                $srch->addStatusCondition(unserialize(FatApp::getConfig("CONF_COMPLETED_ORDER_STATUS")));
                foreach ($last12Months as $key => $val) {
                    $srchObj = clone $srch;
                    $srchObj->addDirectCondition("month(`order_date_added` ) = $val[monthCount] and year(`order_date_added` )= $val[year]");
                    $srchObj->addMultipleFields(array('SUM((op_unit_price * op_qty ) + COALESCE(op_other_charges,0) + COALESCE(op_rounding_off,0) - COALESCE(op_refund_amount,0)) AS Sales,avg((op_unit_price * op_qty ) + COALESCE(op_other_charges,0) + COALESCE(op_rounding_off,0) - COALESCE(op_refund_amount,0)) AS avg_order,count(op_id) as total_orders'));
                    $rs = $srchObj->getResultSet();
                    $row = $this->db->fetch($rs);
                    $sales_data[] = array("duration" => Labels::getLabel('LBL_' . $val['monthShort'], $langId) . "-" . $val['year'], "value" => round($row["Sales"] ?? 0, 2));
                }
                return $sales_data;
                break;
            case 'earnings':
                $srch = new OrderProductSearch();
                $srch->joinorders();
                $srch->joinPaymentMethod();
                $srch->addOrderProductCharges();
                $srch->doNotCalculateRecords();
                $srch->doNotLimitRecords();
                $srch->addStatusCondition(unserialize(FatApp::getConfig("CONF_COMPLETED_ORDER_STATUS")));

                foreach ($last12Months as $key => $val) {
                    $srchObj = clone $srch;
                    $srchObj->addMultipleFields(array('sum((IFNULL(op_commission_charged,0) - IFNULL(op_refund_commission,0))) AS Earning'));
                    $srchObj->addDirectCondition("month(`order_date_added` ) = $val[monthCount] and year(`order_date_added` )= $val[year]");
                    $rs = $srchObj->getResultSet();
                    $row = $this->db->fetch($rs);
                    $earnings_data[] = array("duration" => Labels::getLabel('LBL_' . $val['monthShort'], $langId) . "-" . $val['year'], "value" => round($row["Earning"] ?? 0, 2));
                }
                return $earnings_data;
                break;

            case 'signups':
                $userObj = new User();
                $srch = $userObj->getUserSearchObj();
                $srch->doNotCalculateRecords();
                $srch->doNotLimitRecords();
                $srch->addMultipleFields(array('count(user_id) AS Registrations'));
                $srch->addCondition('u.user_is_shipping_company', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);

                foreach ($last12Months as $key => $val) {
                    $srchObj = clone $srch;
                    $srchObj->addDirectCondition("month(`user_regdate` ) = $val[monthCount] and year(`user_regdate` ) = $val[year]");

                    if ((isset($userTypeArr['user_is_buyer']) && FatUtility::int($userTypeArr['user_is_buyer']) > 0) || (isset($userTypeArr['user_is_supplier']) && FatUtility::int($userTypeArr['user_is_supplier']) > 0)) {
                        $cnd = $srchObj->addCondition('u.user_is_buyer', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
                        $cnd->attachCondition('u.user_is_supplier', '=', 'mysql_func_' . applicationConstants::YES, 'OR', true);
                    }

                    if (isset($userTypeArr['user_is_affiliate']) && FatUtility::int($userTypeArr['user_is_affiliate']) > 0) {
                        $srchObj->addCondition('u.user_is_affiliate', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
                    }

                    if (isset($userTypeArr['user_is_advertiser']) && FatUtility::int($userTypeArr['user_is_advertiser']) > 0) {
                        $srchObj->addCondition('u.user_is_advertiser', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
                    }
                    $rs = $srchObj->getResultSet();
                    $row = $this->db->fetch($rs);
                    $signups_data[] = array("duration" => Labels::getLabel('LBL_' . $val['monthShort'], $langId) . "-" . $val['year'], "value" => round($row["Registrations"], 2));
                }
                return $signups_data;
                break;
            case 'products':
                $srch = SellerProduct::getSearchObject();
                $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
                $srch->addCondition('sp.selprod_active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
                $srch->addCondition('sp.selprod_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
                $srch->addCondition('p.product_active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
                $srch->addCondition('p.product_approved', '=', 'mysql_func_' . Product::APPROVED, 'AND', true);
                $srch->doNotCalculateRecords();
                $srch->doNotLimitRecords();
                $srch->addMultipleFields(array('count(selprod_id) AS sellerProducts'));
                foreach ($last12Months as $key => $val) {
                    $srchObj = clone $srch;
                    $srchObj->addDirectCondition("month(`selprod_added_on` ) = $val[monthCount] and year(`selprod_added_on` ) = $val[year]");
                    $rs = $srchObj->getResultSet();
                    $row = $this->db->fetch($rs);
                    $products_data[] = array("duration" => Labels::getLabel('LBL_' . $val['monthShort'], $langId) . "-" . $val['year'], "value" => round($row["sellerProducts"], 2));
                }
                return $products_data;
                break;
        }
    }

    public function getOrderSalesStats($interval = self::BY_THIS_MONTH)
    {
        $srch = new OrderProductSearch();
        $srch->joinorders();
        $srch->joinPaymentMethod();
        $srch->addOrderProductCharges();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $cnd = $srch->addCondition('order_payment_status', '=', 'mysql_func_' . Orders::ORDER_PAYMENT_PAID, 'AND', true);
        $cnd->attachCondition('plugin_code', '=', 'CashOnDelivery');
        $cnd->attachCondition('plugin_code', '=', 'payatstore');
        $srch->addStatusCondition(unserialize(FatApp::getConfig("CONF_COMPLETED_ORDER_STATUS")));
        $srch->addCondition('order_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $srch->addMultipleFields(array('SUM((op_unit_price * op_qty ) + IFNULL(op_other_charges,0) + IFNULL(op_rounding_off,0) - IFNULL(op_refund_amount,0)) AS totalsales,SUM(op_commission_charged - op_refund_commission) totalcommission'));

        switch ($interval) {
            case self::BY_TODAY:
                $srch->addFld(array('1 AS num_days'));
                $srch->addDirectCondition(self::getIntervalCondition($interval, 'order_date_added'));
                break;
            case self::BY_THIS_WEEK:
                $srch->addFld(array('7 AS num_days'));
                $srch->addDirectCondition(self::getIntervalCondition($interval, 'order_date_added'));
                break;
            case self::BY_THIS_MONTH:
                $srch->addFld(array('30 AS num_days'));
                $srch->addDirectCondition(self::getIntervalCondition($interval, 'order_date_added'));
                break;
            case self::BY_LAST_3_MONTHS:
                $srch->addFld(array('90 AS num_days'));
                $srch->addDirectCondition(self::getIntervalCondition($interval, 'order_date_added'));
                break;
            case self::BY_ALL:
                $srchObj1 = clone $srch;
                $srchObj1->addFld(array('1 AS num_days'));
                $srchObj1->addDirectCondition(self::getIntervalCondition(self::BY_TODAY, 'order_date_added'));

                $srchObj7 = clone $srch;
                $srchObj7->addFld(array('7 AS num_days'));
                $srchObj7->addDirectCondition(self::getIntervalCondition(self::BY_THIS_WEEK, 'order_date_added'));

                $srchObj30 = clone $srch;
                $srchObj30->addFld(array('30 AS num_days'));
                $srchObj30->addDirectCondition(self::getIntervalCondition(self::BY_THIS_MONTH, 'order_date_added'));

                $srchObj90 = clone $srch;
                $srchObj90->addFld(array('90 AS num_days'));
                $srchObj90->addDirectCondition(self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'order_date_added'));

                $srchObjAll = clone $srch;
                $srchObjAll->addFld(array('-1 AS num_days'));

                $sql = $srchObj1->getQuery() . " UNION ALL " . $srchObj7->getQuery() . " UNION ALL " . $srchObj30->getQuery() . " UNION ALL " . $srchObj90->getQuery() . " UNION ALL " . $srchObjAll->getQuery();
                break;
            default:
                $srch->addFld(array('30 AS num_days'));
                $srch->addDirectCondition(self::getIntervalCondition(self::BY_THIS_MONTH, 'order_date_added'));
                break;
        }

        if ($interval != self::BY_ALL) {
            $sql = $srch->getQuery();
        }

        $rs = $this->db->query($sql);
        return $this->db->fetchAll($rs, 'num_days');
    }

    public function getShopsSignupStats($interval = self::BY_THIS_MONTH)
    {
        $srch = Shop::getSearchObject(false);
        $srch->joinTable('tbl_users', 'INNER JOIN', 'u.user_id = s.shop_user_id', 'u');
        $srch->joinTable('tbl_user_credentials', 'INNER JOIN', 'u.user_id = c.credential_user_id', 'c');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();

        switch ($interval) {
            case self::BY_TODAY:
                $srch->addFld(array('1 AS num_days', 'count(shop_id) as shopSignups'));
                $srch->addDirectCondition(self::getIntervalCondition($interval, 'shop_created_on'));
                break;
            case self::BY_THIS_WEEK:
                $srch->addFld(array('7 AS num_days', 'count(shop_id) as shopSignups'));
                $srch->addDirectCondition(self::getIntervalCondition($interval, 'shop_created_on'));
                break;
            case self::BY_THIS_MONTH:
                $srch->addFld(array('30 AS num_days', 'count(shop_id) as shopSignups'));
                $srch->addDirectCondition(self::getIntervalCondition($interval, 'shop_created_on'));
                break;
            case self::BY_LAST_3_MONTHS:
                $srch->addFld(array('90 AS num_days', 'count(shop_id) as shopSignups'));
                $srch->addDirectCondition(self::getIntervalCondition($interval, 'shop_created_on'));
                break;
            case self::BY_ALL:
                $srchObj1 = clone $srch;
                $srchObj1->addFld(array('1 AS num_days', 'count(shop_id) as shopSignups'));
                $srchObj1->addDirectCondition(self::getIntervalCondition(self::BY_TODAY, 'shop_created_on'));

                $srchObj7 = clone $srch;
                $srchObj7->addFld(array('7 AS num_days', 'count(shop_id) as shopSignups'));
                $srchObj7->addDirectCondition(self::getIntervalCondition(self::BY_THIS_WEEK, 'shop_created_on'));

                $srchObj30 = clone $srch;
                $srchObj30->addFld(array('30 AS num_days', 'count(shop_id) as shopSignups'));
                $srchObj30->addDirectCondition(self::getIntervalCondition(self::BY_THIS_MONTH, 'shop_created_on'));

                $srchObj90 = clone $srch;
                $srchObj90->addFld(array('90 AS num_days', 'count(shop_id) as shopSignups'));
                $srchObj90->addDirectCondition(self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'shop_created_on'));

                $srchObjAll = clone $srch;
                $srchObjAll->addFld(array('-1 AS num_days', 'count(shop_id) as shopSignups'));

                $sql = $srchObj1->getQuery() . " UNION ALL " . $srchObj7->getQuery() . " UNION ALL " . $srchObj30->getQuery() . " UNION ALL " . $srchObj90->getQuery() . " UNION ALL " . $srchObjAll->getQuery();
                break;
            default:
                $srch->addFld(array('30 AS num_days', 'count(shop_id) as shopSignups'));
                $srch->addDirectCondition(self::getIntervalCondition(self::BY_THIS_MONTH, 'shop_created_on'));
                break;
        }

        if ($interval != self::BY_ALL) {
            $sql = $srch->getQuery();
        }

        $rs = $this->db->query($sql);
        return $this->db->fetchAll($rs, 'num_days');
    }

    public function getUserSignupStats($interval = self::BY_THIS_MONTH)
    {
        switch ($interval) {
            case self::BY_TODAY:
                $sql = 'SELECT 1 AS num_days, count(user_id) as users FROM `tbl_users` WHERE user_deleted = ' . applicationConstants::NO . ' and user_is_shipping_company = ' . applicationConstants::NO . ' and ' . self::getIntervalCondition($interval, 'user_regdate');
                break;
            case self::BY_THIS_WEEK:
                $sql = 'SELECT 7 AS num_days, count(user_id)  as users FROM `tbl_users` WHERE  user_deleted = ' . applicationConstants::NO . ' and user_is_shipping_company = ' . applicationConstants::NO . ' and ' . self::getIntervalCondition($interval, 'user_regdate');
                break;
            case self::BY_THIS_MONTH:
                $sql = 'SELECT 30 AS num_days, count(user_id)  as users FROM `tbl_users` WHERE user_deleted = ' . applicationConstants::NO . ' and user_is_shipping_company = ' . applicationConstants::NO . ' and ' . self::getIntervalCondition($interval, 'user_regdate');
                break;
            case self::BY_LAST_3_MONTHS:
                $sql = 'SELECT 90 AS num_days, count(user_id)  as users FROM `tbl_users` WHERE user_deleted = ' . applicationConstants::NO . ' and user_is_shipping_company = ' . applicationConstants::NO . ' and ' . self::getIntervalCondition($interval, 'user_regdate');
                break;
            case self::BY_ALL:
                $sql = "SELECT 1 AS num_days, count(user_id)  as users FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and user_is_shipping_company = " . applicationConstants::NO . " and " . self::getIntervalCondition(self::BY_TODAY, 'user_regdate') . "
				UNION ALL
				SELECT 7 AS num_days, count(user_id) as users FROM `tbl_users` WHERE  user_deleted = " . applicationConstants::NO . " and user_is_shipping_company = " . applicationConstants::NO . " and  " . self::getIntervalCondition(self::BY_THIS_WEEK, 'user_regdate') . "
				UNION ALL
				SELECT 30 AS num_days, count(user_id) as users FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and user_is_shipping_company = " . applicationConstants::NO . " and " . self::getIntervalCondition(self::BY_THIS_MONTH, 'user_regdate') . "
				UNION ALL
				SELECT 90 AS num_days, count(user_id) as users FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and user_is_shipping_company = " . applicationConstants::NO . " and " . self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'user_regdate') . "
				UNION ALL
				SELECT -1 AS num_days, count(user_id) as users FROM `tbl_users` where user_deleted = " . applicationConstants::NO . " and user_is_shipping_company = " . applicationConstants::NO . " and user_is_shipping_company!=1";
                break;
            default:
                $sql = 'SELECT 30 AS num_days, count(user_id) as users FROM `tbl_users` WHERE user_deleted = ' . applicationConstants::NO . ' and user_is_shipping_company = ' . applicationConstants::NO . ' and ' . self::getIntervalCondition(self::BY_THIS_MONTH, 'user_regdate');
                break;
        }

        $rs = $this->db->query($sql);
        return $this->db->fetchAllAssoc($rs, 'num_days');
    }

    public function getStats($type)
    {
        $type = strtolower($type);
        switch ($type) {
            case 'total_members':
                $sql = "SELECT 1 AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and user_is_shipping_company = " . applicationConstants::NO . " and " . self::getIntervalCondition(self::BY_TODAY, 'user_regdate') . "
				UNION ALL
				SELECT 7 AS num_days, count(user_id) FROM `tbl_users` WHERE  user_deleted = " . applicationConstants::NO . " and user_is_shipping_company = " . applicationConstants::NO . " and  " . self::getIntervalCondition(self::BY_THIS_WEEK, 'user_regdate') . "
				UNION ALL
				SELECT 30 AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and user_is_shipping_company = " . applicationConstants::NO . " and " . self::getIntervalCondition(self::BY_THIS_MONTH, 'user_regdate') . "
				UNION ALL
				SELECT 90 AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and user_is_shipping_company = " . applicationConstants::NO . " and " . self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'user_regdate') . "
				UNION ALL
				SELECT -1 AS num_days, count(user_id) FROM `tbl_users` where user_deleted = " . applicationConstants::NO . " and user_is_shipping_company = " . applicationConstants::NO . " and user_is_shipping_company!=1";

                /* buyer/seller data [ */
                $sql .= " UNION ALL
				SELECT 'buyer_seller_1' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_buyer = 1 OR user_is_supplier = 1) and " . self::getIntervalCondition(self::BY_TODAY, 'user_regdate') . "
				UNION ALL
				SELECT 'buyer_seller_7' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_buyer = 1 OR user_is_supplier = 1) and " . self::getIntervalCondition(self::BY_THIS_WEEK, 'user_regdate') . "
				UNION ALL
				SELECT 'buyer_seller_30' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_buyer = 1 OR user_is_supplier = 1) and " . self::getIntervalCondition(self::BY_THIS_MONTH, 'user_regdate') . "
				UNION ALL
				SELECT 'buyer_seller_90' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_buyer = 1 OR user_is_supplier = 1) and " . self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'user_regdate') . "
				UNION ALL
				SELECT 'buyer_seller_all' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_buyer = 1 OR user_is_supplier = 1)";
                /* ] */

                /* advertiser data [ */
                $sql .= " UNION ALL
				SELECT 'advertiser_1' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_advertiser = 1)  and " . self::getIntervalCondition(self::BY_TODAY, 'user_regdate') . "
				UNION ALL
				SELECT 'advertiser_7' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_advertiser = 1) and " . self::getIntervalCondition(self::BY_THIS_WEEK, 'user_regdate') . "
				UNION ALL
				SELECT 'advertiser_30' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_advertiser = 1)  and " . self::getIntervalCondition(self::BY_THIS_MONTH, 'user_regdate') . "
				UNION ALL
				SELECT 'advertiser_90' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_advertiser = 1) and " . self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'user_regdate') . "
				UNION ALL
				SELECT 'advertiser_all' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_advertiser = 1)";
                /* ] */

                /* Affiliate data [ */
                $sql .= " UNION ALL
				SELECT 'affiliate_1' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_affiliate = 1)  and " . self::getIntervalCondition(self::BY_TODAY, 'user_regdate') . "
				UNION ALL
				SELECT 'affiliate_7' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_affiliate = 1) and " . self::getIntervalCondition(self::BY_THIS_WEEK, 'user_regdate') . "
				UNION ALL
				SELECT 'affiliate_30' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_affiliate = 1)  and " . self::getIntervalCondition(self::BY_THIS_MONTH, 'user_regdate') . "
				UNION ALL
				SELECT 'affiliate_90' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_affiliate = 1) and " . self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'user_regdate') . "
				UNION ALL
				SELECT 'affiliate_all' AS num_days, count(user_id) FROM `tbl_users` WHERE user_deleted = " . applicationConstants::NO . " and (user_is_affiliate = 1)";
                /* ] */

                $rs = $this->db->query($sql);
                return $this->db->fetchAllAssoc($rs);
                break;

            case 'total_shops':
                return $this->getShopsSignupStats(self::BY_ALL);
                break;

            case 'total_orders':
                $srch = new OrderSearch();
                $srch->joinOrderBuyerUser();
                $srch->joinOrderPaymentMethod();
                $srch->doNotCalculateRecords();
                $srch->doNotLimitRecords();
                $srch->addCondition('order_type', '=', 'mysql_func_' . Orders::ORDER_PRODUCT, 'AND', true);
                $srch->addMultipleFields(array('1 AS num_days,count(distinct order_id) as totalorders', 'IFNULL(SUM(order_net_amount), 0) as totalsales', 'IFNULL(AVG(order_net_amount),0) avgorder'));

                $srchObj1 = clone $srch;
                $srchObj1->addFld(array('1 AS num_days'));
                $srchObj1->addDirectCondition(self::getIntervalCondition(self::BY_TODAY, 'order_date_added'));

                $srchObj7 = clone $srch;
                $srchObj7->addFld(array('7 AS num_days'));
                $srchObj7->addDirectCondition(self::getIntervalCondition(self::BY_THIS_WEEK, 'order_date_added'));

                $srchObj30 = clone $srch;
                $srchObj30->addFld(array('30 AS num_days'));
                $srchObj30->addDirectCondition(self::getIntervalCondition(self::BY_THIS_MONTH, 'order_date_added'));

                $srchObj90 = clone $srch;
                $srchObj90->addFld(array('90 AS num_days'));
                $srchObj90->addDirectCondition(self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'order_date_added'));

                $srchObjAll = clone $srch;
                $srchObjAll->addFld(array('-1 AS num_days'));

                $sql = $srchObj1->getQuery() . " UNION ALL " . $srchObj7->getQuery() . " UNION ALL " . $srchObj30->getQuery() . " UNION ALL " . $srchObj90->getQuery() . " UNION ALL " . $srchObjAll->getQuery();

                $rs = $this->db->query($sql);
                return $this->db->fetchAll($rs);
                break;

            case 'total_sales':
                return $this->getOrderSalesStats(self::BY_ALL);
                break;

            case 'total_seller_products':
                $sql = "SELECT 1 as num_days, COUNT(selprod_id) FROM " . SellerProduct::DB_TBL . " sp
				LEFT OUTER JOIN " . Product::DB_TBL . " p ON sp.selprod_product_id = p.product_id
				WHERE " . self::getIntervalCondition(self::BY_TODAY, 'selprod_added_on') . "
				AND product_active = " . applicationConstants::ACTIVE . " AND product_approved = " . applicationConstants::YES . " AND selprod_active = " . applicationConstants::ACTIVE . " AND selprod_deleted = " . applicationConstants::NO . "
				UNION ALL
				SELECT 7 as num_days, COUNT(selprod_id) FROM " . SellerProduct::DB_TBL . " sp
				LEFT OUTER JOIN " . Product::DB_TBL . " p ON sp.selprod_product_id = p.product_id
				WHERE " . self::getIntervalCondition(self::BY_THIS_WEEK, 'selprod_added_on') . "
				AND product_active = " . applicationConstants::ACTIVE . " AND product_approved = " . applicationConstants::YES . " AND selprod_active = " . applicationConstants::ACTIVE . " AND selprod_deleted = " . applicationConstants::NO . "
				UNION ALL
				SELECT 30 as num_days, COUNT(selprod_id) FROM " . SellerProduct::DB_TBL . " sp
				LEFT OUTER JOIN " . Product::DB_TBL . " p ON sp.selprod_product_id = p.product_id
				WHERE " . self::getIntervalCondition(self::BY_THIS_MONTH, 'selprod_added_on') . "
				AND product_active = " . applicationConstants::ACTIVE . " AND product_approved = " . applicationConstants::YES . " AND selprod_active = " . applicationConstants::ACTIVE . " AND selprod_deleted = " . applicationConstants::NO . "
				UNION ALL
				SELECT 90 as num_days, COUNT(selprod_id) FROM " . SellerProduct::DB_TBL . " sp
				LEFT OUTER JOIN " . Product::DB_TBL . " p ON sp.selprod_product_id = p.product_id
				WHERE " . self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'selprod_added_on') . "
				AND product_active = " . applicationConstants::ACTIVE . " AND product_approved = " . applicationConstants::YES . " AND selprod_active = " . applicationConstants::ACTIVE . " AND selprod_deleted = " . applicationConstants::NO . "
				UNION ALL
				SELECT -1 AS num_days, COUNT(selprod_id) FROM " . SellerProduct::DB_TBL . " sp
				LEFT OUTER JOIN " . Product::DB_TBL . " p ON sp.selprod_product_id = p.product_id
				AND product_active = " . applicationConstants::ACTIVE . " AND product_approved = " . applicationConstants::YES . " AND selprod_active = " . applicationConstants::ACTIVE . " AND selprod_deleted = " . applicationConstants::NO;
                $rs = $this->db->query($sql);
                return $this->db->fetchAllAssoc($rs);
                break;

            case 'total_withdrawal_requests':
                $srch = new WithdrawalRequestsSearch();
                $srch->joinUsers(true);
                $srch->doNotCalculateRecords();
                $srch->doNotLimitRecords();

                $srchObj1 = clone $srch;
                $srchObj1->addFld(array('1 AS num_days', 'count(withdrawal_id)'));
                $srchObj1->addDirectCondition(self::getIntervalCondition(self::BY_TODAY, 'withdrawal_request_date'));

                $srchObj7 = clone $srch;
                $srchObj7->addFld(array('7 AS num_days', 'count(withdrawal_id)'));
                $srchObj7->addDirectCondition(self::getIntervalCondition(self::BY_THIS_WEEK, 'withdrawal_request_date'));

                $srchObj30 = clone $srch;
                $srchObj30->addFld(array('30 AS num_days', 'count(withdrawal_id)'));
                $srchObj30->addDirectCondition(self::getIntervalCondition(self::BY_THIS_MONTH, 'withdrawal_request_date'));

                $srchObj90 = clone $srch;
                $srchObj90->addFld(array('90 AS num_days', 'count(withdrawal_id)'));
                $srchObj90->addDirectCondition(self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'withdrawal_request_date'));

                $srchObjAll = clone $srch;
                $srchObjAll->addFld(array('-1 AS num_days', 'count(withdrawal_id)'));

                $sql = $srchObj1->getQuery() . " UNION ALL " . $srchObj7->getQuery() . " UNION ALL " . $srchObj30->getQuery() . " UNION ALL " . $srchObj90->getQuery() . " UNION ALL " . $srchObjAll->getQuery();

                $rs = $this->db->query($sql);
                return $this->db->fetchAllAssoc($rs);
                break;

            case 'total_affiliate_commission':
                $commonAndCondition = "( utxn_type = " . Transactions::TYPE_AFFILIATE_REFERRAL_SIGN_UP . " OR utxn_type = " . Transactions::TYPE_AFFILIATE_REFERRAL_ORDER . " )";
                $sql = "SELECT 1 AS num_days, IFNULL(SUM(utxn_credit), 0) FROM tbl_user_transactions WHERE " . self::getIntervalCondition(self::BY_TODAY, 'utxn_date') . " AND " . $commonAndCondition . "
				UNION ALL
				SELECT 7 AS num_days, IFNULL(SUM( utxn_credit ), 0) FROM tbl_user_transactions WHERE " . self::getIntervalCondition(self::BY_THIS_WEEK, 'utxn_date') . " AND " . $commonAndCondition . "
				UNION ALL
				SELECT 30 AS num_days, IFNULL(SUM( utxn_credit ), 0) FROM tbl_user_transactions WHERE " . self::getIntervalCondition(self::BY_THIS_MONTH, 'utxn_date') . " AND " . $commonAndCondition . "
				UNION ALL
				SELECT 90 AS num_days, IFNULL(SUM( utxn_credit ), 0) FROM tbl_user_transactions WHERE " . self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'utxn_date') . " AND " . $commonAndCondition . "
				UNION ALL
				SELECT -1 AS num_days, IFNULL(SUM( utxn_credit ), 0) FROM tbl_user_transactions WHERE " . $commonAndCondition;
                $rs = $this->db->query($sql);
                return $this->db->fetchAllAssoc($rs);
                break;

            case 'total_ppc_earnings':
                $sql = "SELECT 1 AS num_days,SUM(pcharge_charged_amount) AS totalppcearnings FROM `tbl_promotions_charges` tpc  WHERE  " . self::getIntervalCondition(self::BY_TODAY, 'pcharge_date') . "
				UNION ALL
				SELECT 7 AS num_days,SUM(pcharge_charged_amount) AS totalppcearnings FROM `tbl_promotions_charges` tpc  WHERE   " . self::getIntervalCondition(self::BY_THIS_WEEK, 'pcharge_date') . "
				UNION ALL
				SELECT 30 AS num_days,SUM(pcharge_charged_amount) AS totalppcearnings FROM `tbl_promotions_charges` tpc  WHERE  " . self::getIntervalCondition(self::BY_THIS_MONTH, 'pcharge_date') . "
				UNION ALL
				SELECT 90 AS num_days,SUM(pcharge_charged_amount) AS totalppcearnings FROM `tbl_promotions_charges` tpc  WHERE  " . self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'pcharge_date') . "
				UNION ALL
				SELECT -1 AS num_days,SUM(pcharge_charged_amount) AS totalppcearnings FROM `tbl_promotions_charges` tpc";

                $rs = $this->db->query($sql);
                return  $this->db->fetchAllAssoc($rs);
                break;

            case 'total_subscription_earnings':
                $sql = "SELECT 1 AS num_days,SUM(order_net_amount) AS earnings FROM `tbl_order_seller_subscriptions` osub  INNER JOIN tbl_orders on order_id = ossubs_order_id WHERE " . self::getIntervalCondition(self::BY_TODAY, 'ossubs_from_date') . " and order_payment_status = 1
                                UNION ALL
                                SELECT 7 AS num_days,SUM(order_net_amount) AS earnings FROM `tbl_order_seller_subscriptions` osub INNER JOIN tbl_orders on order_id = ossubs_order_id  WHERE " . self::getIntervalCondition(self::BY_THIS_WEEK, 'ossubs_from_date') . " and order_payment_status = 1
                                UNION ALL
                                SELECT 30 AS num_days,SUM(order_net_amount) AS earnings FROM `tbl_order_seller_subscriptions` osub INNER JOIN tbl_orders on order_id = ossubs_order_id WHERE " . self::getIntervalCondition(self::BY_THIS_MONTH, 'ossubs_from_date') . " and order_payment_status = 1
                                UNION ALL
                                SELECT 90 AS num_days,SUM(order_net_amount) AS earnings FROM `tbl_order_seller_subscriptions` osub INNER JOIN tbl_orders on order_id = ossubs_order_id  WHERE " . self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'ossubs_from_date') . " and order_payment_status = 1
                                UNION ALL
                                SELECT -1 AS num_days,SUM(order_net_amount) AS earnings FROM `tbl_order_seller_subscriptions` osub INNER JOIN tbl_orders on order_id = ossubs_order_id where order_payment_status = 1";
                $rs = $this->db->query($sql);
                return  $this->db->fetchAllAssoc($rs);
                break;

            case 'total_affiliate_withdrawal_requests':
                $srch = new WithdrawalRequestsSearch();
                $srch->joinUsers(true);
                $srch->doNotCalculateRecords();
                $srch->doNotLimitRecords();
                $srch->addCondition('user_is_affiliate', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
                $srchObj1 = clone $srch;
                $srchObj1->addFld(array('1 AS num_days', 'count(withdrawal_id)'));
                $srchObj1->addDirectCondition(self::getIntervalCondition(self::BY_TODAY, 'withdrawal_request_date'));

                $srchObj7 = clone $srch;
                $srchObj7->addFld(array('7 AS num_days', 'count(withdrawal_id)'));
                $srchObj7->addDirectCondition(self::getIntervalCondition(self::BY_THIS_WEEK, 'withdrawal_request_date'));

                $srchObj30 = clone $srch;
                $srchObj30->addFld(array('30 AS num_days', 'count(withdrawal_id)'));
                $srchObj30->addDirectCondition(self::getIntervalCondition(self::BY_THIS_MONTH, 'withdrawal_request_date'));

                $srchObj90 = clone $srch;
                $srchObj90->addFld(array('90 AS num_days', 'count(withdrawal_id)'));
                $srchObj90->addDirectCondition(self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'withdrawal_request_date'));

                $srchObjAll = clone $srch;
                $srchObjAll->addFld(array('-1 AS num_days', 'count(withdrawal_id)'));

                $sql = $srchObj1->getQuery() . " UNION ALL " . $srchObj7->getQuery() . " UNION ALL " . $srchObj30->getQuery() . " UNION ALL " . $srchObj90->getQuery() . " UNION ALL " . $srchObjAll->getQuery();

                $rs = $this->db->query($sql);
                return $this->db->fetchAllAssoc($rs);
                break;

            case 'total_product_reviews':
                $sql = "SELECT 1 AS num_days, count(spreview_id) FROM `tbl_seller_product_reviews` WHERE " . self::getIntervalCondition(self::BY_TODAY, 'spreview_posted_on') . "
				UNION ALL
				SELECT 7 AS num_days, count(spreview_id) FROM `tbl_seller_product_reviews` WHERE " . self::getIntervalCondition(self::BY_THIS_WEEK, 'spreview_posted_on') . "
				UNION ALL
				SELECT 30 AS num_days, count(spreview_id) FROM `tbl_seller_product_reviews` WHERE " . self::getIntervalCondition(self::BY_THIS_MONTH, 'spreview_posted_on') . "
				UNION ALL
				SELECT 90 AS num_days, count(spreview_id) FROM `tbl_seller_product_reviews` WHERE " . self::getIntervalCondition(self::BY_LAST_3_MONTHS, 'spreview_posted_on') . "
				UNION ALL
				SELECT -1 AS num_days, count(spreview_id) FROM `tbl_seller_product_reviews`";

                $rs = $this->db->query($sql);
                return  $this->db->fetchAllAssoc($rs);
                break;
        }
    }

    public function getTopProducts($type, $langId = 0, $pageSize = 0)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }
        $srch = new OrderProductSearch($langId, true);
        // $srch->joinPaymentMethod();
        $srch->joinSellerProducts($langId);
        $srch->doNotCalculateRecords();
        if ($pageSize > 0) {
            $srch->setPageSize($pageSize);
        } else {
            $srch->doNotLimitRecords();
        }

        $plugInIds = [0 => '-1'];
        $plugInIds[] = Plugin::getAttributesByCode('cashondelivery', 'plugin_id');
        $plugInIds[] = Plugin::getAttributesByCode('payatstore', 'plugin_id');

        $cnd = $srch->addCondition('order_payment_status', '=', 'mysql_func_' . Orders::ORDER_PAYMENT_PAID, 'AND', true);
        /*  $cnd->attachCondition('plugin_code', '=', 'CashOnDelivery');
        $cnd->attachCondition('plugin_code', '=', 'payatstore'); */
        $cnd->attachCondition('o.order_pmethod_id', 'in', $plugInIds);
        $srch->addStatusCondition(unserialize(FatApp::getConfig("CONF_COMPLETED_ORDER_STATUS")));
        $srch->addMultipleFields(array('IF(selprod_title is null or op_selprod_title ="",CONCAT(op_product_name,op_selprod_options) , selprod_title) as product_name', 'sum(op_qty - op_refund_qty) as sold'));
        switch (strtoupper($type)) {
            case 'TODAY':
                $srch->addDirectCondition(self::getIntervalCondition(self::BY_TODAY, 'o.order_date_added'));
                break;
            case 'WEEKLY':
                $srch->addDirectCondition(self::getIntervalCondition(self::BY_THIS_WEEK, 'o.order_date_added'));
                break;
            case 'MONTHLY':
                $srch->addDirectCondition(self::getIntervalCondition(self::BY_THIS_MONTH, 'o.order_date_added'));
                break;
            case 'YEARLY':
                $srch->addDirectCondition(self::getIntervalCondition(self::BY_THIS_YEAR, 'o.order_date_added'));
                break;
        }
        /* $srch->addGroupBy('product_name'); */
        $srch->addGroupBy('op_selprod_id');
        $srch->addGroupBy('op_is_batch');
        $srch->addOrder('sold', 'desc');
        $rs = $srch->getResultSet();
        return $this->db->fetchAll($rs);
    }

    public function getTopSearchKeywords($type, $pageSize = 0)
    {
        $srch = new SearchBase('tbl_search_items', 'tsi');
        switch (strtoupper($type)) {
            case 'TODAY':
                $srch->addDirectCondition(self::getIntervalCondition(self::BY_TODAY, 'tsi.searchitem_date'));
                break;
            case 'WEEKLY':
                $srch->addDirectCondition(self::getIntervalCondition(self::BY_THIS_WEEK, 'tsi.searchitem_date'));
                break;
            case 'MONTHLY':
                $srch->addDirectCondition(self::getIntervalCondition(self::BY_THIS_MONTH, 'tsi.searchitem_date'));
                break;
            case 'YEARLY':
                $srch->addDirectCondition(self::getIntervalCondition(self::BY_THIS_YEAR, 'tsi.searchitem_date'));
                break;
        }
        $srch->addMultipleFields(array('tsi.*', 'sum(tsi.searchitem_count) as search_count'));
        /*  $srch->addOrder('searchitem_count', 'desc'); */
        $srch->addOrder('search_count', 'desc');
        $srch->addGroupBy('tsi.searchitem_keyword');
        if ($pageSize > 0) {
            $srch->setPageSize($pageSize);
        }

        $srch->doNotCalculateRecords();
        return $this->db->fetchAll($srch->getResultSet());
    }

    public function getAddedToCartCount()
    {
        $sql = "Select COUNT(DISTINCT user_id) as cart_count from (SELECT usercart_user_id as user_id FROM `tbl_user_cart` group by usercart_user_id
				UNION ALL
				SELECT order_user_id as user_id FROM `tbl_orders` group by order_user_id) tbl ";
        $rs = $this->db->query($sql);
        return $result = $this->db->fetch($rs);
    }

    public function getUserOrderStatsCount($type = '')
    {
        $plugInIds = [0 => '-1'];
        $plugInIds[] = Plugin::getAttributesByCode('cashondelivery', 'plugin_id');
        $plugInIds[] = Plugin::getAttributesByCode('payatstore', 'plugin_id');

        $cancelAndRefundedStatusArr = (array) FatApp::getConfig("CONF_DEFAULT_CANCEL_ORDER_STATUS");
        $srch = new OrderProductSearch(0, true, false, false, false);
        // $srch->joinPaymentMethod();
        /* $srch = new SearchBase('tbl_order_products', 'torp');
        $srch->joinTable('tbl_orders', 'LEFT JOIN', 'tord.order_id = torp.op_order_id', 'tord'); */
        switch (strtoupper($type)) {
            case 'CANCEL_AND_REFUNDED':
                $srch->addStatusCondition($cancelAndRefundedStatusArr);
                break;
            case 'REACHED_CHECKOUT':
                $srch->addCondition('order_payment_status', '=', 'mysql_func_' . Orders::ORDER_PAYMENT_PENDING, 'AND', true);
                break;
            case 'PURCHASED':
                $cnd = $srch->addCondition('order_payment_status', '=', 'mysql_func_' . Orders::ORDER_PAYMENT_PAID, 'AND', true);
                /*  $cnd->attachCondition('plugin_code', '=', 'cashondelivery');
                $cnd->attachCondition('plugin_code', '=', 'payatstore'); */
                $cnd->attachCondition('o.order_pmethod_id', 'in', $plugInIds);
                break;
        }
        $srch->addMultipleFields(array('op_id'));
        $srch->addGroupBy('order_user_id');
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        return $srch->recordCount();
    }

    public function getConversionStats()
    {
        $srch = new SearchBase('tbl_users', 'tu');
        $srch->addMultipleFields(array('count(user_id) as total_users'));
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        $res = $this->db->fetch($rs);
        $totalUser = $res['total_users'];

        $srch = new SearchBase('tbl_user_cart', 'tuc');
        $srch->addMultipleFields(array('count(usercart_user_id) as total_users'));
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addDirectCondition('usercart_user_id not REGEXP "^-?[0-9]+$"');
        $rs = $srch->getResultSet();
        $res = $this->db->fetch($rs);
        $totalUser += $res['total_users'];

        $cartRes = $this->getAddedToCartCount();
        $addedToCartCount = $cartRes["cart_count"];
        $purchasedCount = $this->getUserOrderStatsCount('purchased');
        $reachedToChecoutCount = $purchasedCount + $this->getUserOrderStatsCount('REACHED_CHECKOUT');
        $cancelAndRefundedUserCount = $this->getUserOrderStatsCount('CANCEL_AND_REFUNDED');

        $data['added_to_cart']['count'] = $addedToCartCount;
        $data['added_to_cart']['%age'] = ($totalUser) ? round(($addedToCartCount * 100) / $totalUser, 2) : 0;

        $data['reached_checkout']['count'] = $reachedToChecoutCount;
        $data['reached_checkout']['%age'] = ($totalUser) ? round(($reachedToChecoutCount * 100) / $totalUser, 2) : 0;

        $data['purchased']['count'] = $purchasedCount;
        $data['purchased']['%age'] = ($totalUser) ? round((($purchasedCount * 100) / $totalUser), 2) : 0;

        $data['cancelled']['count'] = $cancelAndRefundedUserCount;
        $data['cancelled']['%age'] = ($totalUser) ? round((($cancelAndRefundedUserCount * 100) / $totalUser), 2) : 0;

        /* $data = array(
        'added_to_cart'=>array('count'=>$addedToCartCount,'%age' => ( $totalUser ) ? round(($addedToCartCount*100)/$totalUser,2)) : 0 ,
        'reached_checkout'=>array('count'=>$reachedToChecoutCount,'%age'=>round(($reachedToChecoutCount*100)/$totalUser),2),
        'purchased'=>array('count'=>$purchasedCount,'%age'=>round(($purchasedCount*100)/$totalUser),2),
        'cancelled'=>array('count'=>$cancelAndRefundedUserCount,'%age'=>round(($cancelAndRefundedUserCount*100)/$totalUser),2),
        ); */
        return $data;
    }
}
