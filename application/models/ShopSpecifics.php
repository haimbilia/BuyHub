<?php

class ShopSpecifics extends MyAppModel
{
    public const DB_TBL = 'tbl_shop_specifics';
    public const DB_TBL_PREFIX = 'ss_';
    public const DB_TBL_FOREIGN_PREFIX = 'shop_';

    public function __construct($shopId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'shop_id', $shopId);
        $this->objMainTableRecord->setSensitiveFields(array());
    }

    public static function getSearchObject()
    {
        return new SearchBase(static::DB_TBL, 'ss');
    }

    /**
     * updateStats : Used for CRON
     *
     * @param  array $shopIdArr
     * @return void
     */
    public static function updateStats(array $shopIdArr = [])
    {
        $srch = new SelProdReviewSearch();
        $srch->joinSelProdRating();
        $srch->joinShops();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('spr.spreview_selprod_id');
        $srch->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
        $srch->addMultipleFields(['shop.shop_id as shop_id', 'ROUND(AVG(sprating_rating),2) as shopRating', '0 as completionRate', '0 as completedOrders', '0 as returnAcceptanceRate', '0 as orderCancelationRate']);
        $srch->addCondition('sprating_ratingtype_id', '=', RatingType::RATING_SHOP);
        if (!empty($shopIdArr)) {
            $srch->addCondition('shop.shop_id', 'in', $shopIdArr);
        }
        $srch->addGroupBy('shop_id');
        $query = '(' . $srch->getQuery() . ')';

        /* Order completion [ */
        $completedOrderStatus = FatApp::getConfig("CONF_DEFAULT_COMPLETED_ORDER_STATUS", FatUtility::VAR_STRING, '');
        if (!empty($completedOrderStatus)) {
            $srch1 = new OrderProductSearch();
            $srch1->joinShop();
            $srch1->doNotCalculateRecords();
            $srch1->doNotLimitRecords();
            if (!empty($shopIdArr)) {
                $srch1->addCondition('sh.shop_id', 'in', $shopIdArr);
            }
            $srch1->addMultipleFields(['sh.shop_id AS shop_id', '0 AS shopRating', '((SUM(CASE WHEN op_status_id = ' . $completedOrderStatus . ' THEN 1 ELSE 0 END)/count(op_id)) * 100) AS completionRate', '0 AS completedOrders', '0 AS returnAcceptanceRate', '0 AS orderCancelationRate']);
            // $srch1->addMultipleFields(['((SUM(CASE WHEN op_status_id = ' . $completedOrderStatus . ' THEN 1 ELSE 0 END)/count(op_id)) * 100) as rate']);
            $srch1->addGroupBy('shop_id');
            $query .= ' UNION (' . $srch1->getQuery() . ')';

            $srch2 = new OrderProductSearch();
            $srch2->joinShop();
            $srch2->doNotCalculateRecords();
            $srch2->doNotLimitRecords();
            if (!empty($shopIdArr)) {
                $srch2->addCondition('sh.shop_id', 'in', $shopIdArr);
            }
            $srch2->addMultipleFields(['sh.shop_id AS shop_id', '0 AS shopRating', '0 AS completionRate', 'count(op_id) AS completedOrders', '0 AS returnAcceptanceRate', '0 AS orderCancelationRate']);
            // $srch2->addMultipleFields(['count(op_id) as completedOrdersCount']);
            $srch2->addCondition('op_status_id', '=', $completedOrderStatus);
            $srch2->addGroupBy('shop_id');
            $query .= ' UNION (' . $srch2->getQuery() . ')';
        }

        $returnReqApprovedStatus = FatApp::getConfig("CONF_RETURN_REQUEST_APPROVED_ORDER_STATUS", FatUtility::VAR_STRING, '');
        if (!empty($returnReqApprovedStatus)) {
            $srch3 = new OrderProductSearch();
            $srch3->joinShop();
            $srch3->doNotCalculateRecords();
            $srch3->doNotLimitRecords();
            if (!empty($shopIdArr)) {
                $srch3->addCondition('sh.shop_id', 'in', $shopIdArr);
            }
            $srch3->addMultipleFields(['sh.shop_id AS shop_id', '0 AS shopRating', '0 AS completionRate', '0 AS completedOrders', '((SUM(CASE WHEN op_status_id = ' . $returnReqApprovedStatus . ' THEN 1 ELSE 0 END)/count(op_id)) * 100) AS returnAcceptanceRate', '0 AS orderCancelationRate']);
            // $srch3->addMultipleFields(['((SUM(CASE WHEN op_status_id = ' . $returnReqApprovedStatus . ' THEN 1 ELSE 0 END)/count(op_id)) * 100) AS rate']);
            $srch3->addGroupBy('shop_id');
            $query .= ' UNION (' . $srch3->getQuery() . ')';
        }

        $cancelOrderStatus = FatApp::getConfig("CONF_DEFAULT_CANCEL_ORDER_STATUS", FatUtility::VAR_STRING, '');
        if (!empty($cancelOrderStatus)) {
            $srch4 = new OrderProductSearch();
            $srch4->joinShop();
            $srch4->doNotCalculateRecords();
            $srch4->doNotLimitRecords();
            if (!empty($shopIdArr)) {
                $srch4->addCondition('sh.shop_id', 'in', $shopIdArr);
            }
            $srch4->addMultipleFields(['sh.shop_id AS shop_id', '0 AS shopRating', '0 AS completionRate', '0 AS completedOrders', '0 AS returnAcceptanceRate', '((SUM(CASE WHEN op_status_id = ' . $cancelOrderStatus . ' THEN 1 ELSE 0 END)/count(op_id)) * 100) AS orderCancelationRate']);
            // $srch4->addMultipleFields(['((SUM(CASE WHEN op_status_id = ' . $cancelOrderStatus . ' THEN 1 ELSE 0 END)/count(op_id)) * 100) AS rate']);
            $srch4->addGroupBy('shop_id');
            $query .= ' UNION (' . $srch4->getQuery() . ')';
        }

        $qry = "SELECT shop_id, SUM(shopRating) AS shopRating, SUM(ifnull(completionRate,0)) AS completionRate,SUM(completedOrders) AS completedOrders,SUM(returnAcceptanceRate) AS returnAcceptanceRate, SUM(orderCancelationRate) AS orderCancelationRate, '" . date('Y-m-d H:i:s') . "' AS sstats_updated_on FROM (" . $query . ") AS tmp group by tmp.shop_id";

        /* $this->joinTable('(' . $qry . ')', 'INNER JOIN', 'blc.badgelink_record_id = shpprod.shop_id AND blnk.blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_SHOP, 'shpprod'); */

        $insertQry = "INSERT IGNORE INTO " . Shop::DB_TBL_STATS . " (sstats_shop_id, sstats_avg_rating, sstats_completion_rate, sstats_completed_orders, sstats_return_acceptance_rate, sstats_cancellation_rate, sstats_updated_on) SELECT * FROM (" . $qry . ") as t 
        ON DUPLICATE KEY UPDATE sstats_avg_rating = t.shopRating,
                                sstats_completion_rate = t.completionRate,
                                sstats_completed_orders = t.completedOrders,
                                sstats_return_acceptance_rate = t.returnAcceptanceRate,
                                sstats_cancellation_rate = t.orderCancelationRate,
                                sstats_updated_on = t.sstats_updated_on";

        $db = FatApp::getDb();
        if (!$db->query($insertQry)) {
            echo $db->getError();
        }
        echo 'Done!';
    }
}
