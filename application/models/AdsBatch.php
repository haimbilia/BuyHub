<?php

class AdsBatch extends MyAppModel
{
    public const DB_TBL = 'tbl_ads_batches';
    public const DB_TBL_PREFIX = 'adsbatch_';

    public const DB_TBL_BATCH_PRODS = 'tbl_ads_batch_products';
    public const DB_TBL_BATCH_PRODS_PREFIX = 'abprod_';
    
    public const STATUS_PENDING = 0;
    public const STATUS_PUBLISHED = 1;
    public const STATUS_DELETED = 2;
    public const STATUS_PARTIALLY_PENDING = 3;
    
    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function statusArr(int $langId = 0)
    {
        $langId = 1 > $langId ? CommonHelper::getLangId() : $langId;
        return [
            self::STATUS_PENDING => Labels::getLabel('LBL_PENDING', $langId),
            self::STATUS_PUBLISHED => Labels::getLabel('LBL_PUBLISHED', $langId),
            self::STATUS_PARTIALLY_PENDING => Labels::getLabel('LBL_PARTIALLY_PENDING', $langId)
        ];
    }

    public static function getSearchObject($joinAdsProds = false, $langId = 0)
    {
        $langId = 1 > $langId ? CommonHelper::getLangId() : $langId;
        $srch = new SearchBase(static::DB_TBL, 'adb');

        $srch->addOrder('adb.' . static::DB_TBL_PREFIX . 'id', 'DESC');
        $srch->joinTable(Language::DB_TBL, 'LEFT JOIN', self::DB_TBL_PREFIX . 'lang_id = ' . Language::DB_TBL_PREFIX . 'id', 'lang');
        $srch->joinTable(Countries::DB_TBL, 'LEFT JOIN', self::DB_TBL_PREFIX . 'target_country_id = ' . Countries::DB_TBL_PREFIX . 'id', 'c');
        if (true === $joinAdsProds) {
            $now = FatDate::nowInTimezone(FatApp::getConfig('CONF_TIMEZONE'), 'Y-m-d');
            $srch->joinTable(self::DB_TBL_BATCH_PRODS, 'LEFT JOIN', self::DB_TBL_PREFIX . 'id = ' . self::DB_TBL_BATCH_PRODS_PREFIX . self::DB_TBL_PREFIX . 'id', 'abp');
            $srch->joinTable(SellerProduct::DB_TBL, 'INNER JOIN', 'selprod_id = abprod_selprod_id', 'sp');
            $srch->joinTable(SellerProduct::DB_TBL_LANG, 'INNER JOIN', 'selprod_id = selprodlang_selprod_id AND selprodlang_lang_id = ' . $langId, 'sp_l');
            $srch->joinTable(Product::DB_TBL, 'INNER JOIN', 'p.product_id = sp.selprod_product_id', 'p');
            $srch->joinTable(Product::DB_TBL_LANG, 'LEFT OUTER JOIN', 'p.product_id = p_l.productlang_product_id AND p_l.productlang_lang_id = ' . $langId, 'p_l');
            $srch->joinTable(Brand::DB_TBL, 'LEFT JOIN', 'b.brand_id = p.product_brand_id', 'b');
            $srch->joinTable(Brand::DB_TBL_LANG, 'LEFT JOIN', 'b_l.brandlang_brand_id = b.brand_id AND b_l.brandlang_lang_id = ' . $langId, 'b_l');

            $srch->joinTable(
                SellerProduct::DB_TBL_SELLER_PROD_SPCL_PRICE,
                'LEFT OUTER JOIN',
                'm.splprice_selprod_id = selprod_id AND \'' . $now . '\' BETWEEN m.splprice_start_date AND m.splprice_end_date',
                'm'
            );

            $srch->joinTable(
                SellerProduct::DB_TBL_SELLER_PROD_SPCL_PRICE,
                'LEFT OUTER JOIN',
                's.splprice_selprod_id = selprod_id AND s.splprice_price < m.splprice_price
                 AND \'' . $now . '\' BETWEEN s.splprice_start_date AND s.splprice_end_date',
                's'
            );
        }

        return $srch;
    }

    public static function getBatchesByUserId($userId, $adsBatchId = 0)
    {
        $userId = FatUtility::int($userId);
        $adsBatchId = FatUtility::int($adsBatchId);
        if (1 > $userId) {
            return false;
        }
        $db = FatApp::getDb();
        $srch = static::getSearchObject();
        $srch->addCondition(self::DB_TBL_PREFIX . 'user_id', '=', $userId);
        if (0 < $adsBatchId) {
            $srch->addCondition(self::DB_TBL_PREFIX . 'id', '=', $adsBatchId);
        }
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        if (!$rs) {
            return false;
        }

        return $db->fetchAll($rs);
    }

    public function getStatusArr()
    {
        return [self::STATUS_PENDING, self::STATUS_PUBLISHED, self::STATUS_PARTIALLY_PENDING];
    }

    public static function getBatchProdDetail($adsBatchId, $selProdId)
    {
        $adsBatchId = FatUtility::int($adsBatchId);
        $selProdId = FatUtility::int($selProdId);
        if (1 > $adsBatchId || 1 > $selProdId) {
            return false;
        }

        $db = FatApp::getDb();
        $srch = new SearchBase(static::DB_TBL_BATCH_PRODS, 'abp');
        $srch->doNotCalculateRecords();
        $srch->addCondition(self::DB_TBL_BATCH_PRODS_PREFIX . 'adsbatch_id', '=', $adsBatchId);
        $srch->addCondition(self::DB_TBL_BATCH_PRODS_PREFIX . 'selprod_id', '=', $selProdId);        
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        if (!$rs) {
            return false;
        }

        return $db->fetch($rs);
    }

    public static function updateDetail($recordId, $data)
    {
        $recordId = FatUtility::int($recordId);
        if (1 > $recordId || !is_array($data) || empty($data)) {
            return false;
        }
        $data['adsbatch_id'] = !isset($data['adsbatch_id']) || empty($data['adsbatch_id']) ? $recordId : $data['adsbatch_id'];
        if (!FatApp::getDb()->insertFromArray(static::DB_TBL, $data, false, array(), $data)) {
            return false;
        }
        return true;
    }

    public function getBatchDataForFeed(int $userId ,int $langId): array
    {       
        $srch = AdsBatch::getSearchObject(true);
        $srch->addCondition(AdsBatch::DB_TBL_BATCH_PRODS_PREFIX . 'adsbatch_id', '=', $this->getMainTableRecordId());
        $srch->addCondition(AdsBatch::DB_TBL_PREFIX . 'user_id', '=', $userId);
        $srch->addMultipleFields(
            [
                'selprod_id',
                'selprod_title',
                'selprod_stock',
                'selprod_condition',
                'selprod_price',
                'selprod_available_from',
                'product_id',
                'product_description',
                'product_upc',
                'language_code',
                'country_code',
                'IFNULL(brand_name, brand_identifier) as brand_name',
                'abprod_item_group_identifier',
                'adsbatch_expired_on',
                'abprod_cat_id',
                '(CASE WHEN m.splprice_selprod_id IS NULL THEN 0 ELSE 1 END) AS special_price_found',
                'COALESCE(m.splprice_price, selprod_price) AS theprice'
            ]
        );       
        $productData = FatApp::getDb()->fetchAll($srch->getResultSet());
        if (empty($productData)) {
            return [];            
        }

        foreach ($productData as &$prodDetail) {
            $srch = new SearchBase(SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, 'spo');
            $srch->joinTable(OptionValue::DB_TBL, 'INNER JOIN', 'spo.selprodoption_optionvalue_id = ov.optionvalue_id', 'ov');
            $srch->joinTable(OptionValue::DB_TBL . '_lang', 'LEFT OUTER JOIN', 'ov_lang.optionvaluelang_optionvalue_id = ov.optionvalue_id AND ov_lang.optionvaluelang_lang_id = ' . $langId, 'ov_lang');
            $srch->joinTable(Option::DB_TBL, 'INNER JOIN', 'o.option_id = ov.optionvalue_option_id', 'o');
            $srch->joinTable(Option::DB_TBL . '_lang', 'LEFT OUTER JOIN', 'o.option_id = o_lang.optionlang_option_id AND o_lang.optionlang_lang_id = ' . $langId, 'o_lang');
            $srch->addMultipleFields(['optionvalue_identifier', 'option_is_color', 'option_name']);
            $srch->addCondition('selprodoption_selprod_id', '=', $prodDetail['selprod_id']);          
            $prodDetail['optionsData'] = FatApp::getDb()->fetchAll($srch->getResultSet());
            $prodDetail['selprod_condition'] = (Product::getConditionArr($langId))[$prodDetail['selprod_condition']];
            $prodDetail['selprod_stock'] = (0 < $prodDetail['selprod_stock'] ? "in stock" : 'out of stock');
        }
        return $productData;
    }
}
