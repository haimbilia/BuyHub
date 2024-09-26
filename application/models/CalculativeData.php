<?php
class CalculativeData extends MyAppModel
{
    public const DB_TBL = 'tbl_calculative_data';
    public const DB_TBL_PREFIX = 'cd_';

    public const KEY_SELLER_APPROVAL = 1;
    public const KEY_CUSTOM_CATALOG = 2;
    public const KEY_CUSTOM_BRAND = 3;
    public const KEY_PRODUCT_CATEGORY = 4;
    public const KEY_WITHDRAWAL = 5;
    public const KEY_ORDER_CANCELLATION = 6;
    public const KEY_ORDER_RETURN = 7;
    public const KEY_BLOG_CONTRIBUTIONS = 8;
    public const KEY_BLOG_COMMENTS = 9;
    public const KEY_THRESHOLD_LEVEL_PRODUCTS = 10;
    public const KEY_USER_GDPR = 11;
    public const KEY_BADGE = 12;
    public const KEY_SELLER_PRODUCT = 13;

    public const KEY_ADMIN_SALES_STATS = 15;
    public const KEY_ADMIN_EARNINGS_STATS = 16;
    public const KEY_USER_SIGNUPS_STATS = 17;
    public const KEY_AFFILIATE_SIGNUPS_STATS = 18;
    public const KEY_ADVERTISER_SIGNUPS_STATS = 19;
    public const KEY_ADMIN_PRODUCTS_STATS = 20;

    public const TYPE_REQUESTS = 1;
    public const TYPE_ADMIN_SALES_STATS = 2;

    public const COLUMNS = [
        'cd_key',
        'cd_type',
        'cd_value'
    ];

    public static string $errorMsg = '';

    /**
     * __construct
     *
     * @param  mixed $key
     * @return void
     */
    public function __construct(int $key = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'key', $key);
    }

    /**
     * getErrorMsg
     *
     * @return string
     */
    public static function getErrorMsg(): string
    {
        return (string)self::$errorMsg;
    }

    /**
     * getSearchObject
     *
     * @return SearchBase
     */
    public static function getSearchObject(): SearchBase
    {
        return new SearchBase(static::DB_TBL, 'cd');
    }

    /**
     * getKeyArray
     *
     * @param  int $langId
     * @return array
     */
    public static function getKeyArray(int $langId = 0): array
    {
        $langId = (1 > $langId ? CommonHelper::getLangId() : $langId);
        $keyArr = CacheHelper::get('CalculativeDataKeys' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!empty($keyArr)) {
            return unserialize($keyArr);
        }

        $keyArr = [
            self::KEY_SELLER_APPROVAL => Labels::getLabel('LBL_SELLER_APPROVAL', $langId),
            self::KEY_CUSTOM_CATALOG => Labels::getLabel('LBL_CUSTOM_CATALOG', $langId),
            self::KEY_CUSTOM_BRAND => Labels::getLabel('LBL_CUSTOM_BRAND', $langId),
            self::KEY_PRODUCT_CATEGORY => Labels::getLabel('LBL_PRODUCT_CATEGORY', $langId),
            self::KEY_WITHDRAWAL => Labels::getLabel('LBL_WITHDRAWAL', $langId),
            self::KEY_ORDER_CANCELLATION => Labels::getLabel('LBL_ORDER_CANCELLATION', $langId),
            self::KEY_ORDER_RETURN => Labels::getLabel('LBL_ORDER_RETURN', $langId),
            self::KEY_BLOG_CONTRIBUTIONS => Labels::getLabel('LBL_BLOG_CONTRIBUTIONS', $langId),
            self::KEY_BLOG_COMMENTS => Labels::getLabel('LBL_BLOG_COMMENTS', $langId),
            self::KEY_THRESHOLD_LEVEL_PRODUCTS => Labels::getLabel('LBL_THRESHOLD_LEVEL_PRODUCTS', $langId),
            self::KEY_USER_GDPR => Labels::getLabel('LBL_USER_GDPR', $langId),
            self::KEY_BADGE => Labels::getLabel('LBL_BADGE', $langId),
            self::KEY_SELLER_PRODUCT => Labels::getLabel('LBL_SELLER_PRODUCT', $langId)
        ];

        CacheHelper::create('CalculativeDataKeys' . $langId, serialize($keyArr), CacheHelper::TYPE_LABELS);
        return $keyArr;
    }

    /**
     * getTypesKeys
     *
     * @return array
     */
    public static function getTypesKeys(): array
    {
        return [
            self::TYPE_REQUESTS => [
                self::KEY_SELLER_APPROVAL,
                self::KEY_CUSTOM_CATALOG,
                self::KEY_CUSTOM_BRAND,
                self::KEY_PRODUCT_CATEGORY,
                self::KEY_WITHDRAWAL,
                self::KEY_ORDER_CANCELLATION,
                self::KEY_ORDER_RETURN,
                self::KEY_BLOG_CONTRIBUTIONS,
                self::KEY_BLOG_COMMENTS,
                self::KEY_THRESHOLD_LEVEL_PRODUCTS,
                self::KEY_USER_GDPR,
                self::KEY_BADGE,
                self::KEY_SELLER_PRODUCT
            ],
            self::TYPE_ADMIN_SALES_STATS => [
                self::KEY_ADMIN_SALES_STATS,
                self::KEY_ADMIN_EARNINGS_STATS,
                self::KEY_USER_SIGNUPS_STATS,
                self::KEY_AFFILIATE_SIGNUPS_STATS,
                self::KEY_ADVERTISER_SIGNUPS_STATS,
                self::KEY_ADMIN_PRODUCTS_STATS
            ]
        ];
    }

    /**
     * getKeyName
     *
     * @param  int $key
     * @param  int $langId
     * @return string
     */
    public static function getKeyName(int $key, int $langId = 0): string
    {
        return self::getKeyArray($langId)[$key] ?? '';
    }

    /**
     * getTypeByKey
     *
     * @param  int $key
     * @return int
     */
    public static function getTypeByKey(int $key): int
    {
        if (!isset(self::getKeyArray()[$key])) {
            return 0;
        }
        $res = array_filter(self::getTypesKeys(), function ($keysArr) use ($key) {
            return in_array($key, $keysArr);
        });
        return (int) key($res);
    }

    /**
     * getValue
     *
     * @param  int $key
     * @return mixed
     */
    public static function getValue(int $key): mixed
    {
        if (!isset(self::getKeyArray()[$key])) {
            return null;
        }

        $srch = self::getSearchObject();
        $srch->doNotCalculateRecords();
        $srch->addFld('cd_value');
        $srch->addCondition('cd_key', '=', $key);
        $record = FatApp::getDb()->fetch($srch->getResultSet());
        return (is_array($record) && isset($record['cd_value']) ? $record['cd_value'] : NULL);
    }

    /**
     * getValuesByType
     *
     * @param  int $type
     * @return array
     */
    public static function getValuesByType(int $type): array
    {
        $valuesArr = CacheHelper::get('ValuesByType' . $type, CONF_DEF_CACHE_TIME, '.txt');
        if (!empty($valuesArr)) {
            return unserialize($valuesArr);
        }

        $srch = self::getSearchObject();
        $srch->doNotCalculateRecords();
        $srch->addMultipleFields(['cd_key', 'cd_value']);
        $srch->addCondition('cd_type', '=', $type);
        $valuesArr = FatApp::getDb()->fetchAllAssoc($srch->getResultSet());

        CacheHelper::create('ValuesByType' . $type, serialize($valuesArr), CacheHelper::TYPE_CALCULATIVE_DATA);
        return $valuesArr;
    }

    /**
     * getJsonToArrayValue
     *
     * @param  int $type
     * @return array
     */
    public static function getJsonToArrayValue(int $key): mixed
    {
        $srch = self::getSearchObject();
        $srch->doNotCalculateRecords();
        $srch->addFld('cd_value');
        $srch->addCondition('cd_key', '=', $key);
        $record = FatApp::getDb()->fetch($srch->getResultSet());
        return (isset($record['cd_value']) ? json_decode($record['cd_value'], true) : []);
    }

    /**
     * updateValue
     *
     * @param  int $key
     * @param  mixed $value
     * @param  int $type
     * @return bool
     */
    public static function updateValue(int $key, mixed $value, int $type = 0): bool
    {
        $type = (1 > $type) ? self::getTypeByKey($key) : $type;
        if (0 == $type) {
            self::$errorMsg = Labels::getLabel('ERR_INVALID_KEY');
            return false;
        }
        $dataToSave = [
            'cd_key' => $key,
            'cd_type' => $type,
            'cd_value' => $value
        ];

        $db = FatApp::getDb();
        if (!$db->insertFromArray(self::DB_TBL, $dataToSave, false, array(), $dataToSave)) {
            self::$errorMsg = $db->getError();
            return false;
        }
        return true;
    }
}
