<?php

class Configurations extends FatModel
{
    private $db;
    public const DB_TBL = 'tbl_configurations';
    public const DB_TBL_PREFIX = 'conf_';

    public const FORM_GENERAL = 1;
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

    public function __construct()
    {
        parent::__construct();
    }

    public static function getLangTypeFormArr()
    {
        return  array(
            Configurations::FORM_GENERAL,
            Configurations::FORM_LOCAL,
            Configurations::FORM_EMAIL,
            Configurations::FORM_SHARING,
            Configurations::FORM_MEDIA,
            Configurations::FORM_SERVER,
        );
    }

    public static function getTabsArr()
    {
        $siteLangId = CommonHelper::getLangId();

        return array(
            Configurations::FORM_GENERAL => Labels::getLabel('NAV_GENERAL', $siteLangId),
            Configurations::FORM_LOCAL => Labels::getLabel('NAV_LOCAL', $siteLangId),
            Configurations::FORM_SEO => Labels::getLabel('NAV_SEO', $siteLangId),
            Configurations::FORM_USER_ACCOUNT => Labels::getLabel('NAV_ACCOUNT', $siteLangId),
            Configurations::FORM_PRODUCT => Labels::getLabel('NAV_PRODUCT', $siteLangId),
            Configurations::FORM_CART_WISHLIST => Labels::getLabel('NAV_CART/Wishlist', $siteLangId),
            Configurations::FORM_CHECKOUT_PROCESS => Labels::getLabel('NAV_CHECKOUT', $siteLangId),
            Configurations::FORM_COMMISSION => Labels::getLabel('NAV_COMMISSION', $siteLangId),
            Configurations::FORM_DISCOUNT => Labels::getLabel('NAV_DISCOUNT', $siteLangId),
            Configurations::FORM_REWARD_POINTS => Labels::getLabel('NAV_REWARD_POINTS', $siteLangId),
            Configurations::FORM_AFFILIATE => Labels::getLabel('NAV_AFFILIATE', $siteLangId),
            Configurations::FORM_REVIEWS => Labels::getLabel('NAV_REVIEWS', $siteLangId),
            Configurations::FORM_THIRD_PARTY_API => Labels::getLabel('NAV_THIRD_PARTY_API', $siteLangId),
            Configurations::FORM_EMAIL => Labels::getLabel('NAV_EMAIL', $siteLangId),
            Configurations::FORM_MEDIA => Labels::getLabel('NAV_MEDIA', $siteLangId),
            Configurations::FORM_SUBSCRIPTION => Labels::getLabel('NAV_SUBSCRIPTION', $siteLangId),
            Configurations::FORM_REFERAL => Labels::getLabel('NAV_REFERAL', $siteLangId),
            Configurations::FORM_SHARING => Labels::getLabel('NAV_SHARING', $siteLangId),
            Configurations::FORM_SYSTEM => Labels::getLabel('NAV_SYSTEM', $siteLangId),
            Configurations::FORM_LIVE_CHAT => Labels::getLabel('NAV_LIVE_CHAT', $siteLangId),
            Configurations::FORM_PPC => Labels::getLabel('NAV_PPC_MANAGEMENT', $siteLangId),
            Configurations::FORM_SERVER => Labels::getLabel('NAV_SERVER', $siteLangId),
        );
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
            self::FORM_GENERAL => 'general',
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
            self::FORM_SERVER => 'server',
        ];
    }
}
