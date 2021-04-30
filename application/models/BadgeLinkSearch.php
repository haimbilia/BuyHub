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
     * addRecordTypesCondition
     *
     * @param  array $typesArr
     * @return void
     */
    public function addRecordTypesCondition(array $typesArr)
    {
        $this->addCondition(BadgeLink::DB_TBL_PREFIX . 'record_type', 'IN',  $typesArr);
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
            $this->joinTable(Badge::DB_TBL_LANG, 'INNER JOIN', 'badge_id = badgelang_badge_id AND badgelang_lang_id = ' . $langId, 'bdg_l');
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
        $this->joinTable(Product::DB_TBL, 'INNER JOIN', 'badgelink_record_id = product_id', 'p');
        if (0 < $langId) {
            $this->joinTable(Product::DB_TBL_LANG, 'INNER JOIN', 'product_id = badgelang_product_id AND badgelang_lang_id = ' . $langId, 'p_l');
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
        $this->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', 'badgelink_record_id = selprod_id', 'sp');
        if (0 < $langId) {
            $this->joinTable(SellerProduct::DB_TBL_LANG, 'INNER JOIN', 'selprod_id = badgelang_selprod_id AND badgelang_lang_id = ' . $langId, 'sp_l');
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
        $this->joinTable(Shop::DB_TBL, 'INNER JOIN', 'badgelink_record_id = shop_id', 'shp');
        if (0 < $langId) {
            $this->joinTable(Shop::DB_TBL_LANG, 'INNER JOIN', 'shop_id = badgelang_shop_id AND badgelang_lang_id = ' . $langId, 'shp_l');
        }
    }
}
