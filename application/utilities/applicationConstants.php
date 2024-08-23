<?php

class applicationConstants
{

    public const YES = 1;
    public const NO = 0;
    public const DAILY = 0;
    public const WEEKLY = 1;
    public const MONTHLY = 2;
    public const ON = 1;
    public const OFF = 0;
    public const SORT_ASC = 'ASC';
    public const SORT_DESC = 'DESC';
    public const SUCCESS = 1;
    public const FAILURE = 0;
    public const ACTIVE = 1;
    public const INACTIVE = 0;
    public const WEIGHT_GRAM = 1;
    public const WEIGHT_KILOGRAM = 2;
    public const WEIGHT_POUND = 3;
    public const LENGTH_CENTIMETER = 1;
    public const LENGTH_METER = 2;
    public const LENGTH_INCH = 3;
    public const NEWS_LETTER_SYSTEM_MAILCHIMP = 1;
    public const NEWS_LETTER_SYSTEM_AWEBER = 2;
    public const LINK_TARGET_CURRENT_WINDOW = "_self";
    public const LINK_TARGET_BLANK_WINDOW = "_blank";
    public const PERCENTAGE = 1;
    public const FLAT = 2;
    public const PUBLISHED = 1;
    public const DRAFT = 0;
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const GENDER_OTHER = 3;
    public const DISCOUNT_COUPON = 1;
    public const DISCOUNT_REWARD_POINTS = 2;
    public const SCREEN_DESKTOP = 1;
    public const SCREEN_IPAD = 2;
    public const SCREEN_MOBILE = 3;
    public const CHECKOUT_PRODUCT = 1;
    public const CHECKOUT_SUBSCRIPTION = 2;
    public const CHECKOUT_PPC = 3;
    public const CHECKOUT_ADD_MONEY_TO_WALLET = 4;
    public const CHECKOUT_GIFT_CARD = 5;
    public const SMTP_TLS = 'tls';
    public const SMTP_SSL = 'ssl';
    public const LAYOUT_LTR = 'ltr';
    public const LAYOUT_RTL = 'rtl';
    public const SYSTEM_CATALOG = 0;
    public const CUSTOM_CATALOG = 1;
    public const DIGITAL_DOWNLOAD_FILE = 0;
    public const DIGITAL_DOWNLOAD_LINK = 1;
    public const DASHBOARD_PAGE_SIZE = 3;
    public const PAGE_SIZE = 20;
    public const ALLOWED_HTML_TAGS_FOR_APP = '<b><strong><i><u><small><br><p><h1><h2><h3><h4><h5><h6><div><a>';
    public const MOBILE_SCREEN_WIDTH = 768;
    public const URL_TYPE_EXTERNAL = 1;
    public const URL_TYPE_SHOP = 2;
    public const URL_TYPE_PRODUCT = 3;
    public const URL_TYPE_CATEGORY = 4;
    public const URL_TYPE_BRAND = 5;
    public const URL_TYPE_COLLECTION = 6;
    public const URL_TYPE_CONTACT_US = 7;
    public const URL_TYPE_SIGN_IN = 8;
    public const URL_TYPE_REGISTER = 9;
    public const URL_TYPE_CMS = 10;
    public const URL_TYPE_BLOG = 11;
    public const SMS_CHARACTER_LENGTH = 160;
    public const DEFAULT_STRING_LENGTH = 70;
    public const BLOG_TITLE_CHARACTER_LENGTH = 70; /* Used for home page collection. */
    public const BASED_ON_DELIVERY_LOCATION = 1;
    public const BASED_ON_RADIUS = 2;
    public const BASED_ON_CURRENT_LOCATION = 3;
    public const LOCATION_COUNTRY = 0;
    public const LOCATION_STATE = 1;
    public const LOCATION_ZIP = 2;
    public const CLASS_INFO = 'badge-info';
    public const CLASS_SUCCESS = 'badge-success';
    public const CLASS_DANGER = 'badge-danger';
    public const CLASS_WARNING = 'badge-warning';
    public const CURRENCY_SEPARATOR_DECIMAL = '.';
    public const CURRENCY_SEPARATOR_COMMA = ',';
    /*[ join type */
    public const JOIN_LEFT = 1;
    public const JOIN_RIGHT = 2;
    public const JOIN_INNER = 3;
    /* join type ]*/

    public static function getWeightUnitsArr($langId, $unitOnly = false)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        if (true == $unitOnly) {
            return array(
                static::WEIGHT_GRAM => 'GM',
                static::WEIGHT_KILOGRAM => 'KG',
                static::WEIGHT_POUND => 'PN',
            );
        }

        return array(
            static::WEIGHT_GRAM => Labels::getLabel('LBL_Gram', $langId),
            static::WEIGHT_KILOGRAM => Labels::getLabel('LBL_Kilogram', $langId),
            static::WEIGHT_POUND => Labels::getLabel('LBL_Pound', $langId),
        );
    }

    public static function getAllLanguages()
    {
        $languagesArr = Language::getAllNames();
        if (count($languagesArr) > 1) {
            return [0 => Labels::getLabel('LBL_ALL_LANGUAGES')] + $languagesArr;
        }
        return $languagesArr;
    }

    public static function digitalDownloadTypeArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }
        return array(
            static::DIGITAL_DOWNLOAD_FILE => Labels::getLabel('LBL_Digital_download_file', $langId),
            static::DIGITAL_DOWNLOAD_LINK => Labels::getLabel('LBL_Digital_download_link', $langId),
        );
    }

    public static function sortOrder($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }
        return array(
            static::SORT_ASC => Labels::getLabel('LBL_ASCENDING', $langId),
            static::SORT_DESC => Labels::getLabel('LBL_DESCENDING', $langId),
        );
    }

    public static function getLengthUnitsArr($langId, $unitOnly = false)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        if (true == $unitOnly) {
            return array(
                static::LENGTH_CENTIMETER => 'CM',
                static::LENGTH_METER => 'M',
                static::LENGTH_INCH => 'IN',
            );
        }

        return array(
            static::LENGTH_CENTIMETER => Labels::getLabel('LBL_CentiMeter', $langId),
            static::LENGTH_METER => Labels::getLabel('LBL_Meter', $langId),
            static::LENGTH_INCH => Labels::getLabel('LBL_Inch', $langId),
        );
    }

    public static function getYesNoArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
            static::YES => Labels::getLabel('LBL_YES', $langId),
            static::NO => Labels::getLabel('LBL_NO', $langId)
        );
    }

    public static function getYesNoClassArr()
    {
        return array(
            static::YES => applicationConstants::CLASS_SUCCESS,
            static::NO => applicationConstants::CLASS_DANGER
        );
    }

    public static function getActiveInactiveArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
            static::ACTIVE => Labels::getLabel('LBL_Active', $langId),
            static::INACTIVE => Labels::getLabel('LBL_In-active', $langId)
        );
    }

    public static function getActiveInactiveClassArr()
    {
        return array(
            static::ACTIVE => static::CLASS_SUCCESS,
            static::INACTIVE => static::CLASS_DANGER
        );
    }

    public static function getBooleanArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
            1 => Labels::getLabel('LBL_True', $langId),
            0 => Labels::getLabel('LBL_False', $langId)
        );
    }

    public static function getOnOffArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
            static::ON => Labels::getLabel('LBL_On', $langId),
            static::OFF => Labels::getLabel('LBL_Off', $langId)
        );
    }

    public static function getNewsLetterSystemArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
            static::NEWS_LETTER_SYSTEM_MAILCHIMP => Labels::getLabel('LBL_Mailchimp', $langId),
            static::NEWS_LETTER_SYSTEM_AWEBER => Labels::getLabel('LBL_Aweber', $langId),
        );
    }

    public static function getLinkTargetsArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }
        return array(
            static::LINK_TARGET_CURRENT_WINDOW => Labels::getLabel('LBL_Same_Window', $langId),
            static::LINK_TARGET_BLANK_WINDOW => Labels::getLabel('LBL_New_Window', $langId)
        );
    }

    /* static function getUserTypesArr($langId){
      $langId = FatUtility::int($langId);
      if($langId < 1){
      $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
      }
      return array(
      1=>Labels::getLabel('LBL_Seller', $langId),
      2=>Labels::getLabel('LBL_Buyer', $langId)
      );
      } */

    public static function getPercentageFlatArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }
        return array(
            static::PERCENTAGE => Labels::getLabel('LBL_Percentage', $langId),
            static::FLAT => Labels::getLabel('LBL_Flat', $langId)
        );
    }

    public static function allowedMimeTypes()
    {
        $mimeTypes = array('text/plain', 'image/png', 'image/jpeg', 'image/jpg', 'image/gif', 'image/bmp', 'image/tiff', 'image/svg+xml', 'application/zip', 'application/x-zip', 'application/x-zip-compressed', 'application/rar', 'application/x-rar', 'application/x-rar-compressed', 'application/octet-stream', 'audio/mpeg', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword', 'text/plain', 'image/x-icon', 'application/vnd.openxmlformats-officedocument.wordprocessingml.documentapplication/vnd.openxmlformats-officedocument.wordprocessingml.document');
        return array_merge($mimeTypes, static::allowedVideoMimeTypes());
    }

    public static function allowedFileExtensions()
    {
        $extensions = array('zip', 'txt', 'png', 'jpeg', 'jpg', 'gif', 'bmp', 'ico', 'tiff', 'tif', 'svg', 'svgz', 'rar', 'msi', 'cab', 'mp3', 'pdf', 'psd', 'ai', 'eps', 'ps', 'doc', 'docx', 'csv');

        return array_merge($extensions, static::allowedVideoFileExtensions());
    }

    public static function allowedVideoFileExtensions()
    {
        return array(/* 'qt',  */'mov', 'mp4', 'webm');
    }

    public static function allowedImageFileExtensions()
    {
        return ['png', 'jpeg', 'jpg', 'gif'];
    }

    public static function allowedVideoMimeTypes()
    {
        return array('video/quicktime', 'video/mp4', 'video/x-m4v', 'video/webm');
    }

    public static function getGenderArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }
        return array(
            static::GENDER_MALE => Labels::getLabel('LBL_Male', $langId),
            static::GENDER_FEMALE => Labels::getLabel('LBL_Female', $langId),
            static::GENDER_OTHER => Labels::getLabel('LBL_Other', $langId),
        );
    }

    public static function getDisplaysArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
            static::SCREEN_DESKTOP => Labels::getLabel('LBL_Desktop', $langId),
            static::SCREEN_IPAD => Labels::getLabel('LBL_Ipad', $langId),
            static::SCREEN_MOBILE => Labels::getLabel('LBL_Mobile', $langId)
        );
    }

    public static function getExcludePaymentGatewayArr()
    {
        return array(
            static::CHECKOUT_PRODUCT => array(''),
            static::CHECKOUT_SUBSCRIPTION => array(
                'CashOnDelivery',
                'TransferBank',
                'PayAtStore'
            ),
            static::CHECKOUT_PPC => array(
                'CashOnDelivery',
                'TransferBank',
                'PayAtStore'
            ),
            static::CHECKOUT_ADD_MONEY_TO_WALLET => array(
                'CashOnDelivery',
                'TransferBank',
                'PayAtStore'
            ),
            static::CHECKOUT_GIFT_CARD => array(
                'CashOnDelivery',
                'TransferBank',
                'PayAtStore'
            )
        );
    }

    public static function getCatalogTypeArr($langId)
    {
        return array(
            static::CUSTOM_CATALOG => Labels::getLabel('LBL_SELLER_PRODUCTS', $langId),
            static::SYSTEM_CATALOG => Labels::getLabel('LBL_MY_PRODUCTS', $langId)
        );
    }

    public static function getCatalogTypeArrForFrontEnd($langId)
    {
        return array(
            static::SYSTEM_CATALOG => Labels::getLabel('LBL_Marketplace_Products', $langId),
            static::CUSTOM_CATALOG => Labels::getLabel('LBL_My_Private_Products', $langId)
        );
    }

    public static function getShopBannerSize()
    {
        return array(
            Shop::TEMPLATE_ONE => '2000*500',
            Shop::TEMPLATE_TWO => '1300*600',
            Shop::TEMPLATE_THREE => '1350*410',
            Shop::TEMPLATE_FOUR => '1350*410',
            Shop::TEMPLATE_FIVE => '1350*570'
        );
    }

    public static function getSmtpSecureArr($langId)
    {
        return array(
            static::SMTP_TLS => Labels::getLabel('LBL_tls', $langId),
            static::SMTP_SSL => Labels::getLabel('LBL_ssl', $langId),
        );
    }

    public static function getSmtpSecureSettingsArr()
    {
        return array(
            static::SMTP_TLS => 'tls',
            static::SMTP_SSL => 'ssl',
        );
    }

    public static function getLayoutDirections($langId)
    {
        return array(
            static::LAYOUT_LTR => Labels::getLabel('LBL_Left_To_Right', $langId),
            static::LAYOUT_RTL => Labels::getLabel('LBL_Right_To_Left', $langId),
        );
    }

    public static function getMonthsArr($langId)
    {
        return array(
            '01' => '01 ' . Labels::getLabel('LBL_January', $langId),
            '02' => '02 ' . Labels::getLabel('LBL_Februry', $langId),
            '03' => '03 ' . Labels::getLabel('LBL_March', $langId),
            '04' => '04 ' . Labels::getLabel('LBL_April', $langId),
            '05' => '05 ' . Labels::getLabel('LBL_May', $langId),
            '06' => '06 ' . Labels::getLabel('LBL_June', $langId),
            '07' => '07 ' . Labels::getLabel('LBL_July', $langId),
            '08' => '08 ' . Labels::getLabel('LBL_August', $langId),
            '09' => '09 ' . Labels::getLabel('LBL_September', $langId),
            '10' => '10 ' . Labels::getLabel('LBL_October', $langId),
            '11' => '11 ' . Labels::getLabel('LBL_November', $langId),
            '12' => '12 ' . Labels::getLabel('LBL_December', $langId),
        );
    }

    public static function getProductListingSettings($langId)
    {
        return array(
            static::BASED_ON_DELIVERY_LOCATION => Labels::getLabel('LBL_BASED_ON_DELIVERY_LOCATION', $langId),
            static::BASED_ON_RADIUS => Labels::getLabel('LBL_BASED_ON_RADIUS', $langId),
            static::BASED_ON_CURRENT_LOCATION => Labels::getLabel('LBL_BASED_ON_CURRENT_LOCATION', $langId),
        );
    }

    public static function getLocationLevels($langId)
    {
        return array(
            static::LOCATION_COUNTRY => Labels::getLabel('LBL_COUNTRY_LEVEL', $langId),
            static::LOCATION_STATE => Labels::getLabel('LBL_STATE_LEVEL', $langId),
            static::LOCATION_ZIP => Labels::getLabel('LBL_POSTAL_CODE_LEVEL', $langId),
        );
    }

    public static function getClassArr()
    {
        return array(
            0 => applicationConstants::CLASS_INFO,
            1 => applicationConstants::CLASS_SUCCESS,
            2 => applicationConstants::CLASS_DANGER,
            3 => applicationConstants::CLASS_WARNING
        );
    }

    public static function currencySeparatorArr($langId)
    {
        return array(
            static::CURRENCY_SEPARATOR_DECIMAL => Labels::getLabel('LBL_Decimal_(_._)', $langId),
            static::CURRENCY_SEPARATOR_COMMA => Labels::getLabel('LBL_Comma_(_,_)', $langId)
        );
    }

    public static function getClassColor(int $class): string
    {
        $classArr = self::getClassArr();
        $class = $classArr[$class] ?? '';
        
        switch ($class) {
            case applicationConstants::CLASS_INFO:
                return '#5578eb';
                break;
            case applicationConstants::CLASS_SUCCESS:
                return '#1dc9b7';
                break;
            case applicationConstants::CLASS_DANGER:
                return '#fd397a';
                break;
            case applicationConstants::CLASS_WARNING:
                return '#ffb822';
                break;

            default:
                return '#000000';
                break;
        }
    }

    public static function getPageSizeValues()
    {
        return [10, 20, 25, 50, 100];
    }

    public static function getPageSize(int $pageSize)
    {
        if (!in_array($pageSize, self::getPageSizeValues())) {
            return FatApp::getConfig('CONF_ADMIN_PAGESIZE', FatUtility::VAR_INT, 10);
        }
        return $pageSize;
    }

    public static function getFrontEndPageSize(int $pageSize)
    {
        if (!in_array($pageSize, self::getPageSizeValues())) {
            return FatApp::getConfig('CONF_PAGE_SIZE', FatUtility::VAR_INT, 10);
        }
        return $pageSize;
    }

    public static function getSortOrder(string $sortOrder, string $defaultOrder = self::SORT_ASC)
    {
        if (!in_array($sortOrder, [self::SORT_ASC, self::SORT_DESC])) {
            return $defaultOrder;
        }
        return $sortOrder;
    }

    public static function getJoinTypes(): array
    {
        return [static::JOIN_LEFT => 'LEFT', static::JOIN_RIGHT => 'RIGHT', static::JOIN_INNER => 'INNER'];
    }

    public static function getBkImageRepeatTypes($langId): array
    {
        return array(
            'repeat' => Labels::getLabel('LBL_REPEAT', $langId),
            'repeat-x' => Labels::getLabel('LBL_REPEAT_X', $langId),
            'repeat-y' => Labels::getLabel('LBL_REPEAT_Y', $langId),
            'no-repeat' => Labels::getLabel('LBL_NO_REPEAT', $langId),
            /*  'initial' => Labels::getLabel('LBL_INITIAL', $langId),
            'inherit' => Labels::getLabel('LBL_INHERIT', $langId),
            'space' => Labels::getLabel('LBL_SPACE', $langId),
            'round' => Labels::getLabel('LBL_ROUND', $langId), */
        );
    }

    public static function getBkImageSizeTypes($langId): array
    {
        return array(
            'auto' => Labels::getLabel('LBL_AUTO', $langId),
            /*  'length' => Labels::getLabel('LBL_LENGTH', $langId), */
            'cover' => Labels::getLabel('LBL_COVER', $langId),
            'contain' => Labels::getLabel('LBL_CONTAIN', $langId),
            /* 'initial' => Labels::getLabel('LBL_INITIAL', $langId),
            'inherit' => Labels::getLabel('LBL_INHERIT', $langId), */
        );
    }
}
