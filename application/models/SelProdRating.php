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

    public static function getReviewsAndRatings($recordId, $langId, $isSeller = true)
    {
        $srch = new SelProdReviewSearch();
        $srch->joinSeller();
        $srch->joinSellerProducts();
        $srch->joinSelProdRating($langId);
        $srch->joinOrderProduct();
        $srch->joinOrderProductShipping();
        $srch->addMultipleFields(['sprating_spreview_id', 'ratingtype_id', 'COALESCE(ratingtype_name, ratingtype_identifier) as ratingtype_name', 'sprating_rating']);
        $srch->addDirectCondition("(CASE WHEN 0 < opshipping_by_seller_user_id THEN TRUE ELSE `ratingtype_type` != '" . RatingType::TYPE_DELIVERY . "' END)");
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();

        if (true === $isSeller) {
            $srch->addCondition('spreview_seller_user_id', '=', $recordId);
        } else {
            $srch->addCondition('sprating_spreview_id', '=', $recordId);
        }

        $srch->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
        $srch->addOrder('ratingtype_id');
        $rs = $srch->getResultSet();
        return (array) FatApp::getDb()->fetchAll($rs);
    }

    public static function getSellerRating($userId)
    {
        $userId = FatUtility::int($userId);
        $srch = new SelProdReviewSearch();
        $srch->joinSeller();
        $srch->joinSellerProducts();
        $srch->joinSelProdRating();
        $srch->joinOrderProduct();
        $srch->joinOrderProductShipping();
        $srch->addMultipleFields(array("ROUND(AVG(sprating_rating),2) as avg_rating"));
        $srch->addDirectCondition("(CASE WHEN 0 < opshipping_by_seller_user_id THEN `ratingtype_type` IN('" . RatingType::TYPE_SHOP . "', '" . RatingType::RATING_DELIVERY . "') ELSE `ratingtype_type` = '" . RatingType::TYPE_SHOP . "' END)");
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addCondition('spreview_seller_user_id', '=', $userId);
        $srch->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
        $srch->addGroupby('spreview_seller_user_id');
        $rs = $srch->getResultSet();
        $record = FatApp::getDb()->fetch($rs);
        return ($record == false) ? 0 : $record['avg_rating'];
    }

    public static function getAvgSelProdReviewsRating(int $selProdId, int $langId): array
    {
        $srch = new SelProdReviewSearch();
        $srch->joinSelProdRating($langId);
        $srch->addCondition(RatingType::DB_TBL_PREFIX . 'type', 'IN', [RatingType::TYPE_PRODUCT, RatingType::TYPE_OTHER]);
        $srch->addCondition('spreview_selprod_id', '=', $selProdId);
        $srch->addGroupBy('sprating_ratingtype_id');
        $srch->addMultipleFields([
            'sprating_ratingtype_id', 
            'COALESCE(ratingtype_name, ratingtype_identifier) as ratingtype_name', 
            'IFNULL(ROUND(AVG(sprating_rating),2),0) as prod_rating'
        ]);
        $srch->getResultSet();
        return (array) FatApp::getDb()->fetchAll($srch->getResultSet());
    }

    public static function getAvgShopReviewsRating(int $shopUserId, int $langId): array
    {
        $srch = new SelProdReviewSearch();
        $srch->joinOrderProduct();
        $srch->joinOrderProductShipping();
        $srch->joinSelProdRating($langId);
        $srch->addDirectCondition("(CASE WHEN 0 < opshipping_by_seller_user_id THEN `ratingtype_type` IN ('" . RatingType::TYPE_SHOP . "', '" . RatingType::RATING_DELIVERY . "') ELSE `ratingtype_type` IN ('" . RatingType::TYPE_SHOP . "') END)");

        $srch->addCondition('op_selprod_user_id', '=', $shopUserId);
        $srch->addGroupBy('sprating_ratingtype_id');
        $srch->addMultipleFields([
            'sprating_ratingtype_id', 
            'COALESCE(ratingtype_name, ratingtype_identifier) as ratingtype_name', 
            'IFNULL(ROUND(AVG(sprating_rating),2),0) as prod_rating'
        ]);
        $srch->addOrder('sprating_ratingtype_id');
        $srch->getResultSet();
        return (array) FatApp::getDb()->fetchAll($srch->getResultSet());
    }
}
