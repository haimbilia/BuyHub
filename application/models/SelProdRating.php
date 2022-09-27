<?php

class SelProdRating extends MyAppModel
{
    public const DB_TBL = 'tbl_seller_product_rating';
    public const DB_TBL_PREFIX = '	sprating_';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getSearchObj()
    {
        return new SearchBase(static::DB_TBL, 'sprating');
    }

    public static function getRatingAspectsArr($langId, $fulfillmentType = Shipping::FULFILMENT_ALL, $isActive = 1, $ratingType = RatingType::TYPE_PRODUCT)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        $srch = new RatingTypeSearch($langId, $isActive, applicationConstants::YES);
        $srch->addTypesCondition([$ratingType]);
        $attr = ['ratingtype_id', 'COALESCE(ratingtype_name, ratingtype_identifier) as ratingtype_name'];
        $srch->addMultipleFields($attr);
        $srch->doNotCalculateRecords();

        $ratingTypes = (array) FatApp::getDb()->fetchAllAssoc($srch->getResultSet());

        if ($fulfillmentType == Shipping::FULFILMENT_PICKUP && array_key_exists(RatingType::TYPE_DELIVERY, $ratingTypes)) {
            unset($ratingTypes[RatingType::TYPE_DELIVERY]);
        }

        return $ratingTypes;
    }

    public static function getShopRatingTypeArr($langId): array
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return self::getRatingAspectsArr($langId, Shipping::FULFILMENT_ALL, applicationConstants::ACTIVE, RatingType::TYPE_SHOP);
    }

    public static function getDeliveryRatingTypeArr($langId): array
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return self::getRatingAspectsArr($langId, Shipping::FULFILMENT_ALL, applicationConstants::ACTIVE, RatingType::TYPE_DELIVERY);
    }

    public static function getReviewsAndRatings($recordId, $langId, $isSeller = true, $type = [])
    {
        $recordId = FatUtility::int($recordId);
        $srch = new SelProdReviewSearch();
        $srch->joinSeller();
        $srch->joinSellerProducts();
        $srch->joinSelProdRating($langId);
        $srch->joinOrderProduct();
        $srch->joinOrderProductShipping();
        if (!empty($type)) {
            $srch->addCondition('sprating_ratingtype_id', 'in', $type);
        }
        $srch->addMultipleFields(['sprating_spreview_id', 'ratingtype_id', 'COALESCE(ratingtype_name, ratingtype_identifier) as ratingtype_name', 'sprating_rating']);
        $srch->addDirectCondition("(CASE WHEN 0 < opshipping_by_seller_user_id THEN TRUE ELSE `ratingtype_type` != '" . RatingType::TYPE_DELIVERY . "' END)");
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();

        if (true === $isSeller) {
            $srch->addCondition('spreview_seller_user_id', '=', 'mysql_func_' . $recordId, 'AND', true);
        } else {
            $srch->addCondition('sprating_spreview_id', '=', 'mysql_func_' . $recordId, 'AND', true);
        }

        $srch->addCondition('spr.spreview_status', '=', 'mysql_func_' . SelProdReview::STATUS_APPROVED, 'AND', true);
        $srch->addOrder('ratingtype_id');
        $rs = $srch->getResultSet();
        return (array) FatApp::getDb()->fetchAll($rs);
    }

    public static function getSellerRating($userId)
    {
        $userId = FatUtility::int($userId);
        global  $sellerRating;
        if (isset($sellerRating[$userId]['avg_rating'])) {
            return $sellerRating[$userId]['avg_rating'];
        }

        $srch = new SelProdReviewSearch();
        $srch->joinSeller(0, $userId);
        $srch->joinSellerProducts();
        $srch->joinSelProdRating();
        $srch->joinOrderProduct();
        $srch->joinOrderProductShipping();
        $srch->addMultipleFields(array("ROUND(AVG(sprating_rating),2) as avg_rating"));
        $srch->addDirectCondition("(CASE WHEN 0 < opshipping_by_seller_user_id THEN `ratingtype_type` IN('" . RatingType::TYPE_SHOP . "', '" . RatingType::TYPE_DELIVERY . "') ELSE `ratingtype_type` = '" . RatingType::TYPE_SHOP . "' END)");
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('spreview_seller_user_id', '=', 'mysql_func_' . $userId, 'AND', true);
        $srch->addCondition('spr.spreview_status', '=', 'mysql_func_' . SelProdReview::STATUS_APPROVED, 'AND', true);
        $srch->addGroupby('spreview_seller_user_id');
        $rs = $srch->getResultSet();
        $record = FatApp::getDb()->fetch($rs);
        return $sellerRating[$userId]['avg_rating'] = ($record == false) ? 0 : $record['avg_rating'];
    }

    public static function getProdRatingAspects(int $productId, int $langId): array
    {
        $srch = new SelProdReviewSearch();
        $srch->joinSelProdRating($langId);
        $srch->addCondition(RatingType::DB_TBL_PREFIX . 'type', 'IN', [RatingType::TYPE_PRODUCT, RatingType::TYPE_OTHER]);
        $srch->addCondition('spreview_product_id', '=', 'mysql_func_' . $productId, 'AND', true);
        $srch->addGroupBy('sprating_ratingtype_id');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields([
            'sprating_ratingtype_id',
            'COALESCE(ratingtype_name, ratingtype_identifier) as ratingtype_name',
            'IFNULL(ROUND(AVG(sprating_rating),2),0) as prod_rating'
        ]);
        return (array) FatApp::getDb()->fetchAll($srch->getResultSet());
    }

    public static function getAvgShopReviewsRatingObj(int $shopUserId, int $langId = 0): object
    {
        $srch = new SelProdReviewSearch();
        $srch->joinOrderProduct();
        $srch->joinOrderProductShipping();
        $srch->joinSelProdRating($langId);
        $srch->addDirectCondition("(CASE WHEN 0 < opshipping_by_seller_user_id THEN `ratingtype_type` IN ('" . RatingType::TYPE_SHOP . "', '" . RatingType::TYPE_DELIVERY . "') ELSE `ratingtype_type` IN ('" . RatingType::TYPE_SHOP . "') END)");

        $srch->addCondition('op_selprod_user_id', '=', 'mysql_func_' . $shopUserId, 'AND', true);
        $srch->addCondition('spr.spreview_status', '=', 'mysql_func_' . SelProdReview::STATUS_APPROVED, 'AND', true);
        $srch->addCondition('spr.spreview_seller_user_id', '=', $shopUserId);

        // $srch->addOrder('sprating_ratingtype_id', 'DESC');
        return $srch;
    }
}
