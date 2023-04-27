<?php

class Configurations extends FatModel
{
    public const DB_TBL = 'tbl_configurations';
    public const DB_TBL_PREFIX = 'conf_';

    public const FORM_CMS = 1;
    public const FORM_LOCAL = 2;
    public const FORM_SEO = 3;
    public const FORM_PRODUCT = 4;
    public const FORM_AFFILIATE = 5;
    public const FORM_REWARD_POINTS = 6;
    public const FORM_REVIEWS = 7;
    public const FORM_LIVE_CHAT = 8;
    public const FORM_THIRD_PARTY_API = 9;
    public const FORM_EMAIL = 10;
    public const FORM_SERVER = 11;
    public const FORM_SHARING = 12;
    public const FORM_REFERAL = 13;
    public const FORM_MEDIA = 14;
    public const FORM_DISCOUNT = 15;
    public const FORM_SUBSCRIPTION = 16;
    public const FORM_SYSTEM = 17;
    public const FORM_PPC = 18;
    public const FORM_IMPORT_EXPORT = 19;
    public const FORM_CHECKOUT_PROCESS = 20;
    public const FORM_USER_ACCOUNT = 21;
    public const FORM_CART_WISHLIST = 22;
    public const FORM_COMMISSION = 23;

    public const MESSAGE_AUTOCLOSE_TIME = 3;

    public function __construct()
    {
        parent::__construct();
    }

    public static function getLangTypeFormArr()
    {
        return  array(
            Configurations::FORM_CMS,
            Configurations::FORM_LOCAL,
            Configurations::FORM_EMAIL,
            Configurations::FORM_SHARING,
            Configurations::FORM_MEDIA,
            Configurations::FORM_SYSTEM,
        );
    }

    public static function getTabsArr(int $langId)
    {
        $confTabsCacheVar = CacheHelper::get('confTabsCacheVar' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if ($confTabsCacheVar) {
            return json_decode($confTabsCacheVar, true);
        }

        $arr =   array(
            Configurations::FORM_LOCAL => Labels::getLabel('NAV_BUSINESS_PROFILE', $langId),
            Configurations::FORM_USER_ACCOUNT => Labels::getLabel('NAV_USER_ACCOUNT', $langId),
            Configurations::FORM_MEDIA => Labels::getLabel('NAV_BUSINESS_LOGO', $langId),
            Configurations::FORM_THIRD_PARTY_API => Labels::getLabel('NAV_THIRD_PARTY_API', $langId),
            Configurations::FORM_PRODUCT => Labels::getLabel('NAV_PRODUCT', $langId),
            Configurations::FORM_CART_WISHLIST => Labels::getLabel('NAV_CART/Wishlist', $langId),
            Configurations::FORM_DISCOUNT => Labels::getLabel('NAV_DISCOUNT', $langId),
            Configurations::FORM_REVIEWS => Labels::getLabel('NAV_REVIEWS', $langId),
            Configurations::FORM_SHARING => Labels::getLabel('NAV_SHARING', $langId),
            Configurations::FORM_REWARD_POINTS => Labels::getLabel('NAV_REWARD_POINTS', $langId),
            Configurations::FORM_REFERAL => Labels::getLabel('NAV_REFERAL_(_APPLICABLE_FOR_WEB_INTERFACE_ONLY_)', $langId),
            Configurations::FORM_COMMISSION => Labels::getLabel('NAV_WEBSITE_COMMISION', $langId),
            Configurations::FORM_AFFILIATE => Labels::getLabel('NAV_AFFILIATE', $langId),
            Configurations::FORM_SUBSCRIPTION => Labels::getLabel('NAV_SUBSCRIPTION', $langId),
            Configurations::FORM_SEO => Labels::getLabel('NAV_SEO', $langId),
            Configurations::FORM_PPC => Labels::getLabel('NAV_PPC_MANAGEMENT', $langId),
            Configurations::FORM_LIVE_CHAT => Labels::getLabel('NAV_LIVE_CHAT', $langId),
            Configurations::FORM_EMAIL => Labels::getLabel('NAV_EMAIL_CONFIGURATION', $langId),
            Configurations::FORM_CMS => Labels::getLabel('NAV_CMS_PAGES', $langId),
            Configurations::FORM_CHECKOUT_PROCESS => Labels::getLabel('NAV_CHECKOUT', $langId),
            Configurations::FORM_SYSTEM => Labels::getLabel('NAV_SYSTEM', $langId),
            /* Configurations::FORM_SERVER => Labels::getLabel('NAV_SERVER', $langId), */
        );
        CacheHelper::create('confTabsCacheVar' . $langId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }

    public static function getTabsMsgArr($langId)
    {
        $confTabMsgCacheVar = CacheHelper::get('confTabMsgCacheVar' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if ($confTabMsgCacheVar) {
            return json_decode($confTabMsgCacheVar, true);
        }

        $arr = array(
            Configurations::FORM_CMS => Labels::getLabel('NAV_SETUP_STORE_NAME,_EMAIL,_CONTACT_NUMBER_AND_MORE', $langId),
            Configurations::FORM_LOCAL => Labels::getLabel('NAV_SETUP_STORE_ADDRESS,_TIME_ZONE,_LANGUAGE_AND_MORE', $langId),
            Configurations::FORM_SEO => Labels::getLabel('NAV_CONFIGURE_SETTINGS_TO_IMPROVE_SEO_PERFORMANCE', $langId),
            Configurations::FORM_USER_ACCOUNT => Labels::getLabel('NAV_SETUP_PERMISSIONS_AND_WITHDRAWAL_AMOUNTS', $langId),
            Configurations::FORM_PRODUCT => Labels::getLabel('NAV_SETUP_PRODUCT_RELATED_SETTINGS_FOR_SELLERS', $langId),
            Configurations::FORM_CART_WISHLIST => Labels::getLabel('NAV_SETUP_CART_CANCELLATIONS,_REMINDERS_AND_MORE', $langId),
            Configurations::FORM_CHECKOUT_PROCESS => Labels::getLabel('NAV_SETUP_COD,_WALLET_BALANCE,_ORDER_STATUS_AND_MORE', $langId),
            Configurations::FORM_COMMISSION => Labels::getLabel('NAV_SETUP_COMMISSION_ON_TAX_AND_SHIPPING', $langId),
            Configurations::FORM_DISCOUNT => Labels::getLabel('NAV_SETUP_DISCOUNT_COUPONS,_MINIMUM_ORDER_VALUE_AND_MORE', $langId),
            Configurations::FORM_REWARD_POINTS => Labels::getLabel('NAV_SETUP_BIRTHDAY_REWARDS,_YEAR-END_REWARDS_AND_MORE', $langId),
            Configurations::FORM_AFFILIATE => Labels::getLabel('NAV_SETUP_AFFILIATE\'S_SIGNUP_COMMISSION,_COMMISSION_VALIDITY_AND_MORE', $langId),
            Configurations::FORM_REVIEWS => Labels::getLabel('NAV_SETUP_REVIEWS_MODULE_VISIBILITY_AND_DEFAULT_STATUS', $langId),
            Configurations::FORM_THIRD_PARTY_API => Labels::getLabel('NAV_SETUP_GOOGLE_MAP,_FB_PIXEL,_MICROSOFT_TRANSLATOR,_ETC', $langId),
            Configurations::FORM_EMAIL => Labels::getLabel('NAV_SETUP_FROM-EMAIL,_REPLY_EMAIL,_CONTACT_EMAIL_AND_MORE', $langId),
            Configurations::FORM_MEDIA => Labels::getLabel('NAV_SETUP_LOGOS,_FAVICONS,_WATERMARKS_AND_MORE', $langId),
            Configurations::FORM_SUBSCRIPTION => Labels::getLabel('NAV_SETUP_SUBSCRIPTION_MODULE_VISIBILITY,_SELLER_SUBSCRIPTIONS_AND_MORE', $langId),
            Configurations::FORM_REFERAL => Labels::getLabel('NAV_SETUP_REFERRAL\'S_REWARD_POINTS,_VALIDITY_AND_MORE', $langId),
            Configurations::FORM_SHARING => Labels::getLabel('NAV_SETUP_SHARING_FOR_FB_AND_TWITTER', $langId),
            Configurations::FORM_SYSTEM => Labels::getLabel('NAV_SETUP_SYSTEM_LEVEL_CONFIGURATIONS', $langId),
            Configurations::FORM_LIVE_CHAT => Labels::getLabel('NAV_SETUP_LIVE-CHAT_MODULE_VISIBILITY', $langId),
            Configurations::FORM_PPC => Labels::getLabel('NAV_SETUP_COST-PER-CLICK,_PPC_SLIDES_COUNT_AND_MORE', $langId),
            /* Configurations::FORM_SERVER => Labels::getLabel('NAV_SETUP_SSL_AND_MAINTENANCE_MODE', $langId), */
        );
        CacheHelper::create('confTabMsgCacheVar' . $langId, json_encode($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }


    public static function dateFormatPhpArr()
    {
        return array('Y-m-d' => 'Y-m-d', 'd/m/Y' => 'd/m/Y', 'm-d-Y' => 'm-d-Y', 'M d, Y' => 'M d, Y', 'd.m.Y' => 'd.m.Y');
    }

    public static function dateFormatMysqlArr()
    {
        return array('%Y-%m-%d', '%d/%m/%Y', '%m-%d-%Y', '%b %d, %Y');
    }

    public static function dateTimeZoneArr()
    {
        $arr = DateTimeZone::listIdentifiers();
        $arr = array_combine($arr, $arr);
        return $arr;
    }

    public static function getConfigurations($attr = [])
    {

        $srch = new SearchBase(static::DB_TBL, 'conf');
        if (!empty($attr)) {
            $srch->addCondition('conf_name', 'in', $attr);
        }
        $rs = $srch->getResultSet();
        $record = array();
        while ($row = FatApp::getDb()->fetch($rs)) {
            $record[strtoupper($row['conf_name'])] = $row['conf_val'];
        }
        return $record;
    }

    public function update($data)
    {
        foreach ($data as $key => $val) {
            $assignValues = array('conf_name' => $key, 'conf_val' => $val);
            FatApp::getDb()->insertFromArray(
                static::DB_TBL,
                $assignValues,
                false,
                array(),
                $assignValues
            );
        }
        return true;
    }

    public static function getSvgIconNames()
    {
        return [
            self::FORM_CMS => 'server',
            self::FORM_LOCAL => 'local',
            self::FORM_SEO => 'seo',
            self::FORM_USER_ACCOUNT => 'user-account',
            self::FORM_PRODUCT => 'product',
            self::FORM_CART_WISHLIST => 'cart-wishlist',
            self::FORM_CHECKOUT_PROCESS => 'checkout-process',
            self::FORM_COMMISSION => 'commission',
            self::FORM_DISCOUNT => 'discount',
            self::FORM_REWARD_POINTS => 'reward-points',
            self::FORM_AFFILIATE => 'affiliate',
            self::FORM_REVIEWS => 'reviews',
            self::FORM_THIRD_PARTY_API => 'third-party-api',
            self::FORM_EMAIL => 'email',
            self::FORM_MEDIA => 'media',
            self::FORM_SUBSCRIPTION => 'subscription',
            self::FORM_REFERAL => 'referal',
            self::FORM_SHARING => 'sharing',
            self::FORM_SYSTEM => 'system',
            self::FORM_LIVE_CHAT => 'live-chat',
            self::FORM_PPC => 'ppc',
            /* self::FORM_SERVER => 'server', */
        ];
    }

    public static function redirectionLink(int $formType): array
    {
        $arr = [
            Configurations::FORM_COMMISSION => [
                'link' => UrlHelper::generateUrl('Commission'),
                'title' => Labels::getLabel('FRM_MANAGE_COMMISSION'),
            ]
        ];
        
        return $arr[$formType] ?? [];
    }
}
