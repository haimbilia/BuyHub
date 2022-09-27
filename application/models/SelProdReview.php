<?php

class SelProdReview extends MyAppModel
{
    public const DB_TBL = 'tbl_seller_product_reviews';
    public const DB_TBL_PREFIX = 'spreview_';

    public const DB_TBL_ABUSE = 'tbl_seller_product_reviews_abuse';
    public const DB_TBL_ABUSE_PREFIX = 'spra_';

    public const STATUS_PENDING = 0;
    public const STATUS_APPROVED = 1;
    public const STATUS_CANCELLED = 2;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public function addSelProdReviewAbuse($data = array(), $onDuplicateUpdateData = array())
    {
        if (!FatApp::getDb()->insertFromArray(static::DB_TBL_ABUSE, $data, false, array(), $onDuplicateUpdateData)) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }

    public static function getReviewStatusArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId == 0) {
            trigger_error(Labels::getLabel('MSG_Language_Id_not_specified.', $langId), E_USER_ERROR);
        }
        $arr = array(
            static::STATUS_PENDING => Labels::getLabel('LBL_PENDING', $langId),
            static::STATUS_APPROVED => Labels::getLabel('LBL_APPROVED', $langId),
            static::STATUS_CANCELLED => Labels::getLabel('LBL_CANCELLED', $langId),
        );
        return $arr;
    }

    public static function getBuyerAllowedOrderReviewStatuses()
    {
        return unserialize(FatApp::getConfig("CONF_REVIEW_READY_ORDER_STATUS"));
    }

    public static function getSellerTotalReviews(int $userId)
    {
        global  $sellerRating;
        if (isset($sellerRating[$userId]['numOfReviews'])) {
            return $sellerRating[$userId]['numOfReviews'];
        }

        $srch = SelProdRating::getAvgShopReviewsRatingObj($userId);
        $srch->joinUser();
        $srch->joinSeller(0, $userId);
        $srch->joinSellerProducts();
        $srch->joinProducts();
        $srch->addMultipleFields(array('count(distinct(spreview_id)) as numOfReviews'));
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupby('spreview_seller_user_id');
        $record = FatApp::getDb()->fetch($srch->getResultSet());
        return $sellerRating[$userId]['numOfReviews'] = $record['numOfReviews'] ?? 0;
    }

    public static function getProductOrderId($product_id, $loggedUserId)
    {
        $product_id = FatUtility::int($product_id);
        $selProdSrch = SellerProduct::getSearchObject(0);
        $selProdSrch->addCondition('selprod_product_id', '= ', 'mysql_func_' . $product_id, 'AND', true);
        $selProdSrch->addCondition('selprod_active', '= ', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
        $selProdSrch->addCondition('selprod_deleted', '= ', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $selProdSrch->addMultipleFields(array('selprod_id'));
        $selProdSrch->doNotCalculateRecords();
        $rs = $selProdSrch->getResultSet();
        $selprodListing = FatApp::getDb()->fetchAll($rs);
        $selProdList = array();
        foreach ($selprodListing as $key => $val) {
            $selProdList[$key] = $val['selprod_id'];
        }
        $srch = new OrderProductSearch(0, true);
        $allowedReviewStatus = implode(",", SelProdReview::getBuyerAllowedOrderReviewStatuses());
        $allowedSelProdId = implode(",", $selProdList);
        $srch->addDirectCondition('order_user_id =' . $loggedUserId . ' and ( FIND_IN_SET(op_selprod_id,(\'' . $allowedSelProdId . '\')) and op_is_batch = 0) and  FIND_IN_SET(op_status_id,(\'' . $allowedReviewStatus . '\')) ');
        $srch->doNotCalculateRecords();
        /* $srch->addOrder('order_date_added'); */
        return (array) FatApp::getDb()->fetch($srch->getResultSet());
    }


    public static function getStatusClassArr()
    {
        return array(
            static::STATUS_PENDING => applicationConstants::CLASS_INFO,
            static::STATUS_APPROVED => applicationConstants::CLASS_SUCCESS,
            static::STATUS_CANCELLED => applicationConstants::CLASS_DANGER,
        );
    }


    public static function getStatusHtml(int $langId, int $status): string
    {
        $arr = self::getReviewStatusArr($langId);
        $msg = $arr[$status] ?? Labels::getLabel('LBL_N/A', $langId);
        switch ($status) {
            case static::STATUS_PENDING:
                $status = HtmlHelper::INFO;
                break;
            case static::STATUS_APPROVED:
                $status = HtmlHelper::SUCCESS;
                break;
            case static::STATUS_CANCELLED:
                $status = HtmlHelper::DANGER;
                break;
            default:
                $status = HtmlHelper::PRIMARY;
                break;
        }
        return HtmlHelper::getStatusHtml($status, rtrim($msg));
    }
}
