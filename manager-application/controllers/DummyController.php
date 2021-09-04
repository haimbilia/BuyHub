<?php

class DummyController extends AdminBaseController
{
    public function index()
    {
        $shopIdArr = [];
        /* Shop Rating */
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
            $srch1->addMultipleFields(['sh.shop_id as shop_id', '0 as shopRating', '((SUM(CASE WHEN op_status_id = ' . $completedOrderStatus . ' THEN 1 ELSE 0 END)/count(op_id)) * 100) as completionRate', '0 as completedOrders', '0 as returnAcceptanceRate', '0 as orderCancelationRate']);
            // $srch1->addMultipleFields(['((SUM(CASE WHEN op_status_id = ' . $completedOrderStatus . ' THEN 1 ELSE 0 END)/count(op_id)) * 100) as rate']);

            $query .= ' UNION (' . $srch1->getQuery() . ')';

            $srch2 = new OrderProductSearch();
            $srch2->joinShop();
            $srch2->doNotCalculateRecords();
            $srch2->doNotLimitRecords();
            if (!empty($shopIdArr)) {
                $srch2->addCondition('sh.shop_id', 'in', $shopIdArr);
            }
            $srch2->addMultipleFields(['sh.shop_id as shop_id', '0 as shopRating', '0 as completionRate', 'count(op_id) as completedOrders', '0 as returnAcceptanceRate', '0 as orderCancelationRate']);
            // $srch2->addMultipleFields(['count(op_id) as completedOrdersCount']);
            $srch2->addCondition('op_status_id', '=', $completedOrderStatus);
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
            $srch3->addMultipleFields(['sh.shop_id as shop_id', '0 as shopRating', '0 as completionRate', '0 as completedOrders', '((SUM(CASE WHEN op_status_id = ' . $returnReqApprovedStatus . ' THEN 1 ELSE 0 END)/count(op_id)) * 100) as returnAcceptanceRate', '0 as orderCancelationRate']);
            // $srch3->addMultipleFields(['((SUM(CASE WHEN op_status_id = ' . $returnReqApprovedStatus . ' THEN 1 ELSE 0 END)/count(op_id)) * 100) as rate']);
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
            $srch4->addMultipleFields(['sh.shop_id as shop_id', '0 as shopRating', '0 as completionRate', '0 as completedOrders', '0 as returnAcceptanceRate', '((SUM(CASE WHEN op_status_id = ' . $cancelOrderStatus . ' THEN 1 ELSE 0 END)/count(op_id)) * 100) as orderCancelationRate']);
            // $srch4->addMultipleFields(['((SUM(CASE WHEN op_status_id = ' . $cancelOrderStatus . ' THEN 1 ELSE 0 END)/count(op_id)) * 100) as rate']);
            $query .= ' UNION (' . $srch4->getQuery() . ')';
        }

        $qry = "select shop_id, sum(shopRating) as shopRating, sum(completionRate) as completionRate,sum(completedOrders) as completedOrders,sum(returnAcceptanceRate) as returnAcceptanceRate, sum(orderCancelationRate) as orderCancelationRate from (".$query.") as tmp group by tmp.shop_id";

       echo $qry ;exit;
    }
}       