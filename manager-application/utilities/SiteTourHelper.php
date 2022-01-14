<?php

class SiteTourHelper
{
    public const TOUR_STEP = 'tour-step';

    public const STEP_CONFIGURATION = 1;
    public const STEP_EMAIL_CONF = 2;
    public const STEP_PAYMENT_METHOD = 3;
    public const STEP_TAX_SERVICE = 4;
    public const STEP_SHIPPING_SERVICE = 5;

    public const STEP_ADD_PRODUCT = 6;
    public const STEP_SLIDES = 7;
    public const STEP_NAVIGATION = 8;
    public const STEP_TAX = 9;

    public static function getStepsArr()
    {
        return [
            self::STEP_CONFIGURATION,
            self::STEP_EMAIL_CONF,
            self::STEP_PAYMENT_METHOD,
            self::STEP_TAX_SERVICE,
            self::STEP_SHIPPING_SERVICE,
            /*  self::STEP_ADD_PRODUCT,
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
            case self::STEP_ADD_PRODUCT:
                $url = UrlHelper::generateUrl('Products', 'form');
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
            case self::STEP_SLIDES:
                $url = UrlHelper::generateUrl('Slides');
                break;
            case self::STEP_NAVIGATION:
                $url = UrlHelper::generateUrl('Navigations');
                break;
            case self::STEP_TAX:
                $url = UrlHelper::generateUrl('TaxStructure');
                break;
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
                'title' => 'Configure General Settings',
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
           /*  self::STEP_ADD_PRODUCT => [
                'title' => 'Add Product',
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ], */
            self::STEP_EMAIL_CONF => [
                'title' => 'Configure Email Settings',
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
            self::STEP_PAYMENT_METHOD => [
                'title' => 'Configure Payment Methods',
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
            self::STEP_TAX_SERVICE => [
                'title' => 'Configure Tax Services',
                'icon' => '',
                'msg' => 'Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print'
            ],
            self::STEP_SHIPPING_SERVICE => [
                'title' => 'Configure Shipping Services',
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
                /*  case self::STEP_ADD_PRODUCT:
                $status = $this->validateAddProduct();
                break; */
            case self::STEP_EMAIL_CONF:
                $status = $this->validateEmailConfiguration();
                break;
            case self::STEP_PAYMENT_METHOD:
                $status = $this->validateEmailConfiguration();
                break;
            case self::STEP_SLIDES:
                $status = $this->validateSlides();
                break;
            case self::STEP_NAVIGATION:
                $status = $this->validateNavigation();
                break;
            case self::STEP_TAX:
                $status = $this->validateTax();
                break;
        }

        return $status;
    }

    public function validateGeneralConfiguration()
    {
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
        if (empty(FatApp::getConfig('CONF_REPLY_TO_EMAIL', FatUtility::VAR_STRING, '')) && empty(FatApp::getConfig('CONF_CONTACT_EMAIL', FatUtility::VAR_STRING, '')) && empty(FatApp::getConfig('CONF_FROM_EMAIL', FatUtility::VAR_STRING, ''))) {
            return true;
        }
        return false;
    }
}
