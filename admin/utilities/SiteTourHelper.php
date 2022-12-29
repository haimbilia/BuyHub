<?php

class SiteTourHelper
{
    public const TOUR_STEP = 'tour-step';

    public const STEP_CONFIGURATION = 1;
    public const STEP_MEDIA = 2;
    public const STEP_COMMISION = 3;
    public const STEP_EMAIL_CONF = 4;
    public const STEP_PAYMENT_METHOD = 5;
    public const STEP_TAX_SERVICE = 6;
    public const STEP_SHIPPING_SERVICE = 7;
    public const STEP_SOCIAL_LOGIN = 8;
    public const STEP_ADD_PRODUCT = 9;
    /*  
    public const STEP_SLIDES = 7;
    public const STEP_NAVIGATION = 8;
    public const STEP_TAX = 9; */

    public static function getStepsArr()
    {
        return [
            self::STEP_CONFIGURATION,
            self::STEP_MEDIA,
            self::STEP_COMMISION,
            self::STEP_EMAIL_CONF,
            self::STEP_PAYMENT_METHOD,
            self::STEP_TAX_SERVICE,
            self::STEP_SHIPPING_SERVICE,
            self::STEP_SOCIAL_LOGIN,
            self::STEP_ADD_PRODUCT
            /* 
            self::STEP_SLIDES,
            self::STEP_NAVIGATION,
            self::STEP_TAX */
        ];
    }

    public static function getNextLink(int $stepNumber)
    {
        $stepNumber++;
        return self::getUrl($stepNumber);
    }

    public static function getPrevLink(int $stepNumber)
    {
        $stepNumber--;
        return self::getUrl($stepNumber);
    }

    public static function getUrl(int $stepNumber)
    {
        $url = '';
        switch ($stepNumber) {
            case self::STEP_CONFIGURATION:
                $url = UrlHelper::generateUrl('Configurations', 'Index', [Configurations::FORM_LOCAL]);
                break;
            case self::STEP_MEDIA:
                $url = UrlHelper::generateUrl('Configurations', 'Index', [Configurations::FORM_MEDIA]);
                break;
            case self::STEP_COMMISION:
                $url = UrlHelper::generateUrl('Configurations', 'Index', [Configurations::FORM_COMMISSION]);
                break;
            case self::STEP_EMAIL_CONF:
                $url = UrlHelper::generateUrl('Configurations', 'Index', [Configurations::FORM_EMAIL]);
                break;
            case self::STEP_PAYMENT_METHOD:
                $url = UrlHelper::generateUrl('Plugins', 'Index', [PluginCommon::TYPE_REGULAR_PAYMENT_METHOD]);
                break;
            case self::STEP_TAX_SERVICE:
                $url = UrlHelper::generateUrl('Plugins', 'Index', [PluginCommon::TYPE_TAX_SERVICES]);
                break;
            case self::STEP_SHIPPING_SERVICE:
                $url = UrlHelper::generateUrl('Plugins', 'Index', [PluginCommon::TYPE_SHIPPING_SERVICES]);
                break;
            case self::STEP_SOCIAL_LOGIN:
                $url = UrlHelper::generateUrl('Plugins', 'Index', [PluginCommon::TYPE_SOCIAL_LOGIN]);
                break;
            case self::STEP_ADD_PRODUCT:
                return $url = UrlHelper::generateUrl('Products', 'form');
                break;
                /* case self::STEP_ADD_PRODUCT:
                $url = UrlHelper::generateUrl('Products', 'form');
                break;    
            case self::STEP_SLIDES:
                $url = UrlHelper::generateUrl('Slides');
                break;
            case self::STEP_NAVIGATION:
                $url = UrlHelper::generateUrl('Navigations');
                break;
            case self::STEP_TAX:
                $url = UrlHelper::generateUrl('TaxStructure');
                break; */
            default:
                $url = UrlHelper::generateUrl('GettingStarted');
                $stepNumber = 0;
                break;
        }
        return rtrim($url, '/') . '?' . self::TOUR_STEP . '=' . ($stepNumber);
    }

    public static function getStepIndex()
    {
        $index = UrlHelper::getQueryStringArr(self::TOUR_STEP);

        $stepsArr = self::getStepsArr();
        if (in_array($index, $stepsArr)) {
            return $index;
        }
        return 0;
    }

    public static function validate(int $index)
    {
        $stepsArr = self::getStepsArr();
        if (in_array($index, $stepsArr)) {
            return true;
        }
        return false;
    }

    public static function getStepsData($langId)
    {
        return [
            self::STEP_CONFIGURATION => [
                'title' => Labels::getLabel('NAV_BUSINESS_PROFILE', $langId),
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print',
            ],
            self::STEP_MEDIA => [
                'title' => Labels::getLabel('NAV_BUSINESS_LOGO', $langId),
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
            self::STEP_COMMISION => [
                'title' => Labels::getLabel('NAV_WEBSITE_COMMISION', $langId),
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
            self::STEP_EMAIL_CONF => [
                'title' => Labels::getLabel('NAV_EMAIL_CONFIGURATION', $langId),
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
            self::STEP_PAYMENT_METHOD => [
                'title' => Labels::getLabel('NAV_PAYMENT_METHODS', $langId),
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
            self::STEP_TAX_SERVICE => [
                'title' => Labels::getLabel('NAV_SALES_TAX_PLUGINS', $langId),
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
            self::STEP_SHIPPING_SERVICE => [
                'title' => Labels::getLabel('NAV_SHIPPING_SERVICES_PLUGINS', $langId),
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
            self::STEP_SOCIAL_LOGIN => [
                'title' => Labels::getLabel('NAV_SOCIAL_LOGIN_PLUGINS', $langId),
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
            self::STEP_ADD_PRODUCT => [
                'title' => Labels::getLabel('NAV_ADD_PRODUCT', $langId),
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
            /*  self::STEP_SLIDES => [
                'title' => 'Configure Home page slides',
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
            self::STEP_NAVIGATION => [
                'title' => 'Configure Front End Header Navigation',
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
            self::STEP_TAX => [
                'title' => 'Setup Tax Rates',
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ], */
        ];
    }

    public function validateSteps(int $stepNumber)
    {
        $status = false;
        switch ($stepNumber) {
            case self::STEP_CONFIGURATION:
                $status = $this->validateGeneralConfiguration();
                break;
            case self::STEP_MEDIA:
                $status = $this->validateMedia();
                break;
            case self::STEP_COMMISION:
                $status = $this->validateCommision();
                break;
            case self::STEP_EMAIL_CONF:
                $status = $this->validateEmailConfiguration();
                break;
            case self::STEP_PAYMENT_METHOD:
                $status = $this->validatePlugin(PluginCommon::TYPE_REGULAR_PAYMENT_METHOD);
                break;
            case self::STEP_TAX_SERVICE:
                $status = $this->validatePlugin(PluginCommon::TYPE_TAX_SERVICES);
                break;
            case self::STEP_SOCIAL_LOGIN:
                $status = $this->validatePlugin(PluginCommon::TYPE_SOCIAL_LOGIN);
                break;
            case self::STEP_SHIPPING_SERVICE:
                $status = $this->validatePlugin(PluginCommon::TYPE_SHIPPING_SERVICES);
                break;
        }

        return $status;
    }

    public function validateGeneralConfiguration()
    {
        if (empty(FatApp::getConfig('CONF_SITE_OWNER_EMAIL', FatUtility::VAR_STRING, '')) || empty(FatApp::getConfig('CONF_ZIP_CODE', FatUtility::VAR_STRING, '')) || empty(FatApp::getConfig('CONF_ADDRESS_1', FatUtility::VAR_STRING, ''))) {
            return false;
        }
        return true;
    }

    public function validateSlides()
    {
        return true;
    }

    public function validateNavigation()
    {
        return true;
    }

    public function validateTax()
    {
        return true;
    }

    public function validateAddProduct()
    {
        $srch = Product::getSearchObject();
        // $srch->joinTable(Product::DB_TBL_PRODUCT_TO_CATEGORY, 'LEFT OUTER JOIN', 'product_id = ptc_product_id', 'ptcat');
        $srch->addCondition('product_active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
        $srch->addCondition('product_approved', '=', 'mysql_func_' . applicationConstants::YES, 'AND', true);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addFld('1');
        $records = FatApp::getDb()->fetch($srch->getResultSet());
        if (false == $records) {
            return false;
        }
        return true;
    }

    public function validateEmailConfiguration()
    {
        if (empty(FatApp::getConfig('CONF_REPLY_TO_EMAIL', FatUtility::VAR_STRING, '')) || empty(FatApp::getConfig('CONF_CONTACT_EMAIL', FatUtility::VAR_STRING, '')) || empty(FatApp::getConfig('CONF_FROM_EMAIL', FatUtility::VAR_STRING, ''))) {
            return false;
        }
        return true;
    }

    public function validateMedia()
    {
        $fileData = AttachedFile::getAttachment(AttachedFile::FILETYPE_FRONT_LOGO, 0, 0, CommonHelper::getLangId());
        if (!empty($fileData) && 0 < $fileData['afile_id']) {
            return true;
        }
        return false;
    }

    public function validateCommision()
    {
        if (empty(FatApp::getConfig('CONF_MAX_COMMISSION', FatUtility::VAR_INT, 0))) {
            return false;
        }
        return true;
    }

    public function validatePlugin($type)
    {
        if (Plugin::isActiveByType($type)) {
            return true;
        }
        return false;
    }
}
