<?php

class BadgeLinkSearch extends SearchBase
{
    /**
     * __construct
     *
     * @param  int $langId   
     * @return void
     */
    public function __construct()
    {
        parent::__construct(BadgeLink::DB_TBL, 'blnk');
    }
    
    /**
     * addBadgeTypeCondition
     *
     * @param  array $typesArr
     * @return void
     */
    public function addBadgeTypeCondition(array $typesArr)
    {
        $this->addHaving(Badge::DB_TBL_PREFIX . 'type', 'IN',  $typesArr);
    }

    /**
     * addRecordTypesCondition
     *
     * @param  array $recordTypesArr
     * @return void
     */
    public function addRecordTypesCondition(array $recordTypesArr)
    {
        $this->addCondition(BadgeLink::DB_TBL_PREFIX . 'record_type', 'IN',  $recordTypesArr);
    }

    /**
     * addConditionTypesCondition
     *
     * @param  array $conditionTypesArr
     * @return void
     */
    public function addConditionTypesCondition(array $conditionTypesArr)
    {
        $this->addCondition(BadgeLink::DB_TBL_PREFIX . 'condition_type', 'IN',  $conditionTypesArr);
    }

    /**
     * addFromCondition
     *
     * @param  string $from
     * @return void
     */
    public function addFromCondition(string $from, string $operator = '<=')
    {
        $this->addCondition(BadgeLink::DB_TBL_PREFIX . 'condition_from', $operator,  $from);
    }

    /**
     * addToCondition
     *
     * @param  string $to
     * @return void
     */
    public function addToCondition(string $to, string $operator = '>=')
    {
        $this->addCondition(BadgeLink::DB_TBL_PREFIX . 'condition_to', $operator,  $to);
    }
    
    /**
     * joinBadge
     *
     * @param  int $langId
     * @return void
     */
    public function joinBadge(int $langId = 0)
    {
        $this->joinTable(Badge::DB_TBL, 'INNER JOIN', 'badgelink_badge_id = badge_id', 'bdg');
        if (0 < $langId) {
            $this->joinTable(Badge::DB_TBL_LANG, 'LEFT JOIN', 'badge_id = badgelang_badge_id AND badgelang_lang_id = ' . $langId, 'bdg_l');
        }
    }
    
    /**
     * joinProduct
     *
     * @param  int $langId
     * @return void
     */
    public function joinProduct(int $langId = 0)
    {
        $this->joinTable(Product::DB_TBL, 'LEFT JOIN', 'JSON_CONTAINS(badgelink_record_ids, CAST(product_id AS INT))', 'p');
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
        $this->joinTable(SellerProduct::DB_TBL, 'LEFT JOIN', 'JSON_CONTAINS(badgelink_record_ids, CAST(product_id AS INT))', 'sp');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'spu.credential_user_id = sp.selprod_user_id', 'spu');
        $this->joinTable(SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, 'LEFT JOIN', 'selprod_id = selprodoption_selprod_id', 'spo');
        $this->joinTable(OptionValue::DB_TBL, 'LEFT JOIN', 'selprodoption_optionvalue_id = optionvalue_id', 'optv');
        $this->joinTable(Option::DB_TBL, 'LEFT JOIN', 'optionvalue_option_id = option_id', 'opt');
        if (0 < $langId) {
            $this->joinTable(SellerProduct::DB_TBL_LANG, 'LEFT JOIN', 'selprod_id = selprodlang_selprod_id AND selprodlang_lang_id = ' . $langId, 'sp_l');
            $this->joinTable(Option::DB_TBL_LANG, 'LEFT JOIN', 'option_id = optionlang_option_id AND optionlang_lang_id = ' . $langId, 'opt_l');
            $this->joinTable(OptionValue::DB_TBL_LANG, 'LEFT JOIN', 'optionvaluelang_optionvalue_id = optionvalue_id AND optionvaluelang_lang_id = ' . $langId, 'optv_l');
        }

    }

    /**
     * joinShop
     *
     * @param  int $langId
     * @return void
     */
    public function joinShop(int $langId = 0)
    {
        $this->joinTable(Shop::DB_TBL, 'LEFT JOIN', 'JSON_CONTAINS(badgelink_record_ids, CAST(product_id AS INT))', 'shp');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'shpu.credential_user_id = shp.shop_user_id', 'shpu');
        if (0 < $langId) {
            $this->joinTable(Shop::DB_TBL_LANG, 'LEFT JOIN', 'shop_id = shoplang_shop_id AND shoplang_lang_id = ' . $langId, 'shp_l');
        }
    }
}
