<?php

class BadgeLinkConditionSearch extends SearchBase
{
    private $badgeLinksJoin = false;
    private $selProdIdArr = [];

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(BadgeLinkCondition::DB_TBL, 'blnk');
    }

    /**
     * joinBadge
     *
     * @param  int $langId
     * @return void
     */
    public function joinBadge(int $langId = 0)
    {
        $this->joinTable(Badge::DB_TBL, 'INNER JOIN', 'blinkcond_badge_id = badge_id', 'bdg');
        if (0 < $langId) {
            $this->joinTable(Badge::DB_TBL_LANG, 'LEFT JOIN', 'badge_id = badgelang_badge_id AND badgelang_lang_id = ' . $langId, 'bdg_l');
        }
    }

    /**
     * joinBadgeLinks
     *
     * @return void
     */
    public function joinBadgeLinks()
    {
        $this->badgeLinksJoin = true;
        $this->joinTable(BadgeLinkCondition::DB_TBL_BADGE_LINKS, 'LEFT JOIN', 'badgelink_blinkcond_id = blinkcond_id', 'blc');
    }

    /**
     * joinBadgeRequest
     *
     * @return void
     */
    public function joinBadgeRequest(int $status = 0)
    {
        if (false === $this->badgeLinksJoin) {
            trigger_error(Labels::getLabel('ERR_PLEASE_JOIN_BADGE_LINKS', CommonHelper::getLangId()), E_USER_ERROR);
        }

        $cnd = '';
        if (0 < $status) {
            $cnd .= ' and breq.breq_status = ' . $status;
        }

        $this->joinTable(BadgeRequest::DB_TBL, 'LEFT JOIN', 'breq.breq_id = blc.badgelink_breq_id ' . $cnd, 'breq');
    }

    /**
     * joinProduct
     *
     * @param  int $langId
     * @return void
     */
    public function joinProduct(int $langId = 0)
    {
        if (false === $this->badgeLinksJoin) {
            trigger_error(Labels::getLabel('ERR_PLEASE_JOIN_BADGE_LINKS', $langId), E_USER_ERROR);
        }

        $this->joinTable(Product::DB_TBL, 'LEFT JOIN', 'badgelink_record_id = product_id', 'p');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT JOIN', 'pu.credential_user_id = p.product_seller_id', 'pu');
        if (0 < $langId) {
            $this->joinTable(Product::DB_TBL_LANG, 'LEFT JOIN', 'product_id = productlang_product_id AND productlang_lang_id = ' . $langId, 'p_l');
        }
    }

    /**
     * joinSellerProduct
     *
     * @param  int $langId
     * @return void
     */
    public function joinSellerProduct(int $langId = 0)
    {
        if (false === $this->badgeLinksJoin) {
            trigger_error(Labels::getLabel('ERR_PLEASE_JOIN_BADGE_LINKS', $langId), E_USER_ERROR);
        }

        $this->joinTable(SellerProduct::DB_TBL, 'LEFT JOIN', 'badgelink_record_id = selprod_id', 'sp');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT JOIN', 'spu.credential_user_id = sp.selprod_user_id', 'spu');
        $this->joinTable(SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, 'LEFT JOIN', 'selprod_id = selprodoption_selprod_id', 'spo');
        $this->joinTable(OptionValue::DB_TBL, 'LEFT JOIN', 'selprodoption_optionvalue_id = optionvalue_id', 'optv');
        $this->joinTable(Option::DB_TBL, 'LEFT JOIN', 'optionvalue_option_id = option_id', 'opt');
        if (0 < $langId) {
            $this->joinTable(SellerProduct::DB_TBL_LANG, 'LEFT JOIN', 'selprod_id = selprodlang_selprod_id AND selprodlang_lang_id = ' . $langId, 'sp_l');
            $this->joinTable(Option::DB_TBL_LANG, 'LEFT JOIN', 'option_id = optionlang_option_id AND optionlang_lang_id = ' . $langId, 'opt_l');
            $this->joinTable(OptionValue::DB_TBL_LANG, 'LEFT JOIN', 'optionvaluelang_optionvalue_id = optionvalue_id AND optionvaluelang_lang_id = ' . $langId, 'optv_l');
        }
        $this->addGroupBy('badgelink_record_id');
    }

    /**
     * joinShop
     *
     * @param  int $langId
     * @return void
     */
    public function joinShop(int $langId = 0)
    {
        if (false === $this->badgeLinksJoin) {
            trigger_error(Labels::getLabel('ERR_PLEASE_JOIN_BADGE_LINKS', $langId), E_USER_ERROR);
        }

        $this->joinTable(Shop::DB_TBL, 'LEFT JOIN', 'badgelink_record_id = shop_id', 'shp');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT JOIN', 'shpu.credential_user_id = shp.shop_user_id', 'shpu');
        if (0 < $langId) {
            $this->joinTable(Shop::DB_TBL_LANG, 'LEFT JOIN', 'shop_id = shoplang_shop_id AND shoplang_lang_id = ' . $langId, 'shp_l');
        }
    }

    /**
     * joinUser
     *
     * @return void
     */
    public function joinUser()
    {
        $this->joinTable(User::DB_TBL, 'LEFT JOIN', 'blnku.user_id = blnk.blinkcond_user_id', 'blnku');
    }

    /* TODO : need to replace newely build function */

    /**
     * joinBadges
     *
     * @param  int $langId
     * @return void
     */
    public function joinBadges(int $langId = 0, int $type = 0, bool $active = true)
    {
        $cond = '';
        if (true == $active) {
            $cond .= ' AND bdg.badge_active = ' . applicationConstants::ACTIVE;
        }

        if (0 < $type) {
            $cond .= ' AND bdg.badge_type = ' . $type;
        }

        $this->joinTable(Badge::DB_TBL, 'INNER JOIN', 'blnk.blinkcond_badge_id = bdg.badge_id ' . $cond, 'bdg');
        if (0 < $langId) {
            $this->joinTable(Badge::DB_TBL_LANG, 'LEFT JOIN', 'badge_id = badgelang_badge_id AND badgelang_lang_id = ' . $langId, 'bdg_l');
        }
    }

    /**
     * joinProducts
     *
     * @param  int $langId
     * @return void
     */
    public function joinProducts(int $langId = 0, $includeSelProds = true)
    {
        if (false === $this->badgeLinksJoin) {
            trigger_error(Labels::getLabel('ERR_PLEASE_JOIN_BADGE_LINKS', $langId), E_USER_ERROR);
        }

        $srch = new SearchBase(Product::DB_TBL, 'p');
        if (0 < $langId) {
            $srch->joinTable(Product::DB_TBL_LANG, 'LEFT JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $langId, 'p_l');
        }

        if (true == $includeSelProds) {
            $srch->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', 'psp.selprod_product_id = p.product_id and psp.selprod_deleted = ' . applicationConstants::NO, 'psp');

            if (!empty($this->selProdIdArr)) {
                $srch->addCondition('psp.selprod_id', 'in', $this->selProdIdArr);
            }
        }
        $srch->addMultipleFields(['p.product_id', 'psp.selprod_id as product_selprod_id']);
        $srch->addCondition('p.product_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition('p.product_deleted', '=', applicationConstants::NO);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT JOIN', 'blc.badgelink_record_id = prod.product_id AND blnk.blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_PRODUCT, 'prod');
    }

    /**
     * joinSellerProducts
     *
     * @param  int $langId
     * @return void
     */
    public function joinSellerProducts(int $langId = 0)
    {
        if (false === $this->badgeLinksJoin) {
            trigger_error(Labels::getLabel('ERR_PLEASE_JOIN_BADGE_LINKS', $langId), E_USER_ERROR);
        }

        if (!empty($this->selProdIdArr)) {
            $srch = new SearchBase(SellerProduct::DB_TBL, 'p');
            $srch->doNotCalculateRecords();
            $srch->doNotLimitRecords();
            $srch->addCondition('p.selprod_id', 'in', $this->selProdIdArr);
            $srch->addMultipleFields(['p.selprod_id']);
            $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT JOIN', 'blc.badgelink_record_id = sp.selprod_id AND blnk.blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT, 'sp');
        } else {
            $this->joinTable(SellerProduct::DB_TBL, 'LEFT JOIN', 'blc.badgelink_record_id = sp.selprod_id AND blnk.blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_SELLER_PRODUCT, 'sp');
        }

        if (0 < $langId) {
            $this->joinTable(SellerProduct::DB_TBL_LANG, 'LEFT JOIN', 'sp.selprod_id = selprodlang_selprod_id AND sp_l.selprodlang_lang_id = ' . $langId, 'sp_l');
        }
    }

    /**
     * joinShops
     *
     * @param  int $langId
     * @return void
     */
    public function joinShops(int $langId = 0, $includeSelProds = true)
    {
        if (false === $this->badgeLinksJoin) {
            trigger_error(Labels::getLabel('ERR_PLEASE_JOIN_BADGE_LINKS', $langId), E_USER_ERROR);
        }

        $srch = new SearchBase(Shop::DB_TBL, 's');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();

        // $this->joinTable(Shop::DB_TBL, 'LEFT JOIN', 'blc.badgelink_record_id = shp.shop_id AND blnk.blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_SHOP, 'shp');
        if (0 < $langId) {
            $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT JOIN', 's.shop_id = s_l.shoplang_shop_id AND s_l.shoplang_lang_id = ' . $langId, 's_l');
        }

        if (true == $includeSelProds) {
            $srch->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', 'sp.selprod_user_id = s.shop_user_id and sp.selprod_deleted = ' . applicationConstants::NO, 'sp');
            if (!empty($this->selProdIdArr)) {
                $srch->addCondition('sp.selprod_id', 'in', $this->selProdIdArr);
            }
        }
        $srch->addMultipleFields(['s.shop_id', 'sp.selprod_id as shop_selprod_id']);
        $this->joinTable('(' . $srch->getQuery() . ')', 'LEFT JOIN', 'blc.badgelink_record_id = shpprod.shop_id AND blnk.blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_SHOP, 'shpprod');
    }

    /**
     * joinShopsForBadges
     *    
     * @return void
     */
    public function joinShopsForBadges(array $shopIdArr = [])
    {
        if (false === $this->badgeLinksJoin) {
            trigger_error(Labels::getLabel('ERR_PLEASE_JOIN_BADGE_LINKS', CommonHelper::getLangId()), E_USER_ERROR);
        }

        $srch = new SearchBase(Shop::DB_TBL, 's');
        /*  $srch->joinTable(User::DB_TBL, 'INNER JOIN', 'u.user_id = s.shop_user_id', 'u'); */
        $srch->joinTable(User::DB_TBL_CRED, 'INNER JOIN', 'c.credential_user_id = s.shop_user_id', 'c');
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addMultipleFields(['s.shop_id']);
        if (!empty($shopIdArr)) {
            $srch->addCondition('s.shop_id', 'in', $this->shopIdArr);
        }

        //$srch->addCondition('u.user_deleted', '=', applicationConstants::NO);
        $srch->addCondition('c.credential_verified', '=', applicationConstants::YES);
        $srch->addCondition('c.credential_active', '=', applicationConstants::ACTIVE);
        $this->joinTable('(' . $srch->getQuery() . ')', 'INNER JOIN', 'blc.badgelink_record_id = shpprod.shop_id AND blnk.blinkcond_record_type = ' . BadgeLinkCondition::RECORD_TYPE_SHOP, 'shpprod');
    }

    public function attachAutomaticConditions(array $shopIdArr = [])
    {
        /* Shop Rating */
        $srch = new SelProdReviewSearch();
        $srch->joinSelProdRating();
        $srch->joinShops();
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addGroupBy('spr.spreview_selprod_id');
        $srch->addCondition('spr.spreview_status', '=', SelProdReview::STATUS_APPROVED);
        $srch->addMultipleFields(['shop.shop_id', 'ROUND(AVG(sprating_rating),2) as shopRating']);
        // $srch->addCondition('spreview_seller_user_id', '=', $recordId);
        $srch->addCondition('sprating_ratingtype_id', '=', RatingType::RATING_SHOP);

        if (!empty($shopIdArr)) {
            $srch->addCondition('shop.shop_id', 'in', $this->shopIdArr);
        }
        
        $query = '(' . $srch->getQuery() . ') union (' . $subSrch2->getQuery() . ')';
    }

    /**
     * setSelProdIdArr
     *
     * @param  array $arr
     * @return void
     */
    public function setSelProdIdArr(array $arr)
    {
        $this->selProdIdArr = $arr;
    }
}
