<?php

class PluginCommon extends MyAppModel
{
    public const DB_TBL = 'tbl_plugins';
    public const DB_TBL_PREFIX = 'plugin_';

    public const DB_TBL_LANG = 'tbl_plugins_lang';
    public const DB_TBL_LANG_PREFIX = 'pluginlang_';

    public const DB_TBL_PLUGIN_TO_USER = 'tbl_plugin_to_user';
    public const DB_TBL_PLUGIN_TO_USER_PREFIX = 'pu_';

    public const RETURN_FALSE  = 0;
    public const RETURN_TRUE  = 1;

    public const ENV_SANDBOX = 0;
    public const ENV_PRODUCTION = 1;

    public const ACTIVE  = 1;
    public const INACTIVE  = 0;

    public const TYPE_CURRENCY_CONVERTER = 1;
    public const TYPE_SOCIAL_LOGIN = 2;
    public const TYPE_PUSH_NOTIFICATION = 3;
    public const TYPE_PAYOUTS = 4;
    public const TYPE_ADVERTISEMENT_FEED = 5;
    public const TYPE_SMS_NOTIFICATION = 6;
    public const TYPE_FULL_TEXT_SEARCH = 7;
    public const TYPE_SHIPPING_SERVICES = 8;
    public const TYPE_TAX_SERVICES  = 10;
    public const TYPE_SPLIT_PAYMENT_METHOD  = 11;
    public const TYPE_REGULAR_PAYMENT_METHOD  = 13;
    public const TYPE_SHIPMENT_TRACKING = 14;
    public const TYPE_DATA_MIGRATION = 16;

    /* Define here :  if system can activate only one plugin from any group.*/
    public const EITHER_GROUP_TYPE = [
        [
            self::TYPE_SPLIT_PAYMENT_METHOD,
            self::TYPE_REGULAR_PAYMENT_METHOD
        ],
    ];

    /* Payment Gateways Applicable For Pay Later. */
    public const PAY_LATER = [
        'CashOnDelivery',
        'PayAtStore'
    ];

    public const HAVING_DESCRIPTION = [
        self::TYPE_ADVERTISEMENT_FEED
    ];

    public const ATTRS = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'code',
        self::DB_TBL_PREFIX . 'type',
        self::DB_TBL_PREFIX . 'description',
        'COALESCE(plg_l.' . self::DB_TBL_PREFIX . 'name, plg.' . self::DB_TBL_PREFIX . 'identifier) as plugin_name',
        self::DB_TBL_PREFIX . 'active',
    ];


    /**
     * getTypeArr - Used to get plugin type
     *
     * @param  mixed $langId
     * @return void
     */
    public static function getTypeArr($langId)
    {
        return [
            self::TYPE_CURRENCY_CONVERTER => Labels::getLabel('LBL_CURRENCY_CONVERTER', $langId),
            self::TYPE_SOCIAL_LOGIN => Labels::getLabel('LBL_SOCIAL_LOGIN', $langId),
            self::TYPE_PUSH_NOTIFICATION => Labels::getLabel('LBL_PUSH_NOTIFICATION', $langId),
            self::TYPE_PAYOUTS => Labels::getLabel('LBL_PAYOUT', $langId),
            self::TYPE_ADVERTISEMENT_FEED => Labels::getLabel('LBL_ADVERTISEMENT_FEED', $langId),
            self::TYPE_SMS_NOTIFICATION => Labels::getLabel('LBL_SMS_NOTIFICATION', $langId),
            self::TYPE_TAX_SERVICES => Labels::getLabel('LBL_TAX_SERVICES', $langId),
            // self::TYPE_FULL_TEXT_SEARCH => Labels::getLabel('LBL_FULL_TEXT_SEARCH', $langId), /* NOT IN USE */
            self::TYPE_SPLIT_PAYMENT_METHOD => Labels::getLabel('LBL_SPLIT_PAYMENT_METHODS', $langId),
            self::TYPE_REGULAR_PAYMENT_METHOD => Labels::getLabel('LBL_REGULAR_PAYMENT_METHODS', $langId),
            self::TYPE_SHIPPING_SERVICES => Labels::getLabel('LBL_SHIPPING_SERVICES', $langId),
            self::TYPE_SHIPMENT_TRACKING => Labels::getLabel('LBL_SHIPMENT_TRACKING', $langId),
            self::TYPE_DATA_MIGRATION => Labels::getLabel('LBL_DATA_MIGRATION', $langId),
        ];
    }

    /**
     * getDirectory - Used to get plugin directory
     *
     * @param  mixed $pluginType
     * @return mixed
     */
    public static function getDirectory(int $pluginType)
    {
        $pluginDir = [
            self::TYPE_CURRENCY_CONVERTER => "currency-converter",
            self::TYPE_SOCIAL_LOGIN => "social-login",
            self::TYPE_PUSH_NOTIFICATION => "push-notification",
            self::TYPE_ADVERTISEMENT_FEED => "advertisement-feed",
            self::TYPE_SMS_NOTIFICATION => "sms-notification",
            // self::TYPE_FULL_TEXT_SEARCH => "full-text-search", /* NOT IN USE */
            self::TYPE_TAX_SERVICES => "tax",
            self::TYPE_SPLIT_PAYMENT_METHOD => "payment-methods",
            self::TYPE_REGULAR_PAYMENT_METHOD => "payment-methods",
            self::TYPE_SHIPPING_SERVICES => "shipping-services",
            self::TYPE_SHIPMENT_TRACKING => "shipment-tracking",
            self::TYPE_DATA_MIGRATION => "data-migration",
        ];

        if (array_key_exists($pluginType, $pluginDir)) {
            return $pluginDir[$pluginType];
        }
        return false;
    }

    /**
     * getActivatationLimit
     *
     * @param  int $typeId
     * @return void
     */
    public static function getActivatationLimit(int $typeId): int
    {
        if (false === static::getDirectory($typeId)) {
            return -1;
        }

        $pluginTypeArr = [
            self::TYPE_REGULAR_PAYMENT_METHOD => 4,
        ];
        return array_key_exists($typeId, $pluginTypeArr) ? $pluginTypeArr[$typeId] : 0;
    }

    /**
     * getGroupType
     *
     * @param  mixed $pluginType
     * @return array
     */
    public static function getGroupType(int $pluginType): array
    {
        $groupArr = [];
        try {
            $eitherGroupTypes = Plugin::EITHER_GROUP_TYPE;
            array_walk($eitherGroupTypes, function ($group, $index) use ($pluginType, &$groupArr) {
                if (in_array($pluginType, $group)) {
                    $groupArr = $group;
                    throw new Exception();
                }
            });
        } catch (Exception $e) {
            // Do Nothing. Used Just to break array_walk.
        }
        return $groupArr;
    }

    /**
     * getEnvArr
     *
     * @param  mixed $langId
     * @return array
     */
    public static function getEnvArr(int $langId): array
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = CommonHelper::getLangId();
        }

        return [
            self::ENV_SANDBOX => Labels::getLabel('LBL_SANDBOX', $langId),
            self::ENV_PRODUCTION => Labels::getLabel('LBL_PRODUCTION', $langId),
        ];
    }

    /**
     * getKingpinTypeArr
     *
     * @return void
     */
    public static function getKingpinTypeArr(): array
    {
        /* Define here :  if system can not activate multiple plugins for a same feature.*/
        return [
            self::TYPE_CURRENCY_CONVERTER,
            self::TYPE_PUSH_NOTIFICATION,
            self::TYPE_ADVERTISEMENT_FEED,
            self::TYPE_SMS_NOTIFICATION,
            self::TYPE_TAX_SERVICES,
            // self::TYPE_FULL_TEXT_SEARCH, /* NOT IN USE */
            self::TYPE_SPLIT_PAYMENT_METHOD,
            self::TYPE_SHIPPING_SERVICES,
            self::TYPE_SHIPMENT_TRACKING,
            self::TYPE_DATA_MIGRATION
        ];
    }

    /**
     * getSeparateIconTypeArr
     *
     * @return void
     */
    public static function getSeparateIconTypeArr(): array
    {
        return [
            self::TYPE_SPLIT_PAYMENT_METHOD,
            self::TYPE_REGULAR_PAYMENT_METHOD
        ];
    }
}
