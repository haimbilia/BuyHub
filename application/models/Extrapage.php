<?php

class Extrapage extends MyAppModel
{
    public const DB_TBL = 'tbl_extra_pages';
    public const DB_TBL_PREFIX = 'epage_';

    public const DB_TBL_LANG = 'tbl_extra_pages_lang';
    public const DB_TBL_LANG_PREFIX = 'epagelang_';

    public const CONTACT_US_CONTENT_BLOCK = 1;
    public const LOGIN_PAGE_RIGHT_BLOCK = 13;
    public const REGISTRATION_PAGE_RIGHT_BLOCK = 14;
    // public const FORGOT_PAGE_RIGHT_BLOCK = 15;
    public const SELLER_PAGE_BLOCK1 = 16;
    public const SELLER_PAGE_BLOCK2 = 17;
    public const SELLER_PAGE_BLOCK3 = 25;
    public const SELLER_BANNER_SLOGAN = 18;
    //public const RESET_PAGE_RIGHT_BLOCK = 19;
    public const SUBSCRIPTION_PAGE_BLOCK = 20;
    public const ADVERTISER_BANNER_SLOGAN = 21;
    public const AFFILIATE_BANNER_SLOGAN = 22;
    public const CHECKOUT_PAGE_RIGHT_BLOCK = 23;
    public const SELLER_PAGE_FORM_TEXT = 24;
    public const FOOTER_TRUST_BANNERS = 26;
    public const CHECKOUT_PAGE_HEADER_BLOCK = 27;

    public const ADMIN_PRODUCTS_CATEGORIES_INSTRUCTIONS = 28;
    // public const GENERAL_SETTINGS_INSTRUCTIONS = 29; /* Not Required this data moved to help center. */
    public const ADMIN_BRANDS_INSTRUCTIONS = 30;
    public const ADMIN_OPTIONS_INSTRUCTIONS = 31;
    public const ADMIN_TAGS_INSTRUCTIONS = 32;
    public const ADMIN_COUNTRIES_MANAGEMENT_INSTRUCTIONS = 33;
    public const ADMIN_STATE_MANAGEMENT_INSTRUCTIONS = 34;
    public const ADMIN_CATALOG_MANAGEMENT_INSTRUCTIONS = 35;
    public const SELLER_CATALOG_MANAGEMENT_INSTRUCTIONS = 36;
    public const SELLER_GENERAL_SETTINGS_INSTRUCTIONS = 37;
    public const ADMIN_PRODUCT_INVENTORY_INSTRUCTIONS = 38;
    public const SELLER_PRODUCT_INVENTORY_INSTRUCTIONS = 39;
    public const PRODUCT_INVENTORY_UPDATE_INSTRUCTIONS = 40;
    public const MARKETPLACE_PRODUCT_INSTRUCTIONS = 41;
    public const SELLER_INVENTORY_INSTRUCTIONS = 42;
    public const PRODUCT_REQUEST_INSTRUCTIONS = 43;
    public const ADMIN_TYPE_POLICY_POINTS = 44;
    public const ADMIN_ZONE_MANAGEMENT_INSTRUCTIONS = 45;
    public const FOOTER_META_CONTENT = 46;
    public const SELLER_BADGES_INSTRUCTIONS = 47;
    public const SELLER_RIBBONS_INSTRUCTIONS = 48;

    public const CONTENT_PAGES = 0;
    public const CONTENT_IMPORT_INSTRUCTION = 1;
    public const CONTENT_HOMEPAGE_COLLECTION = 2;

    public const REWRITE_URL_PREFIX = 'custom/view/';

    /* [ EXTRA INFO Column types*/
    public const TYPE_BKGROUND_IMAGE_REPEAT = 1;
    public const TYPE_BKGROUND_IMAGE_SIZE = 2;

    /* EXTRA INFO Column types ]*/

    public function __construct($epageId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $epageId);
    }

    public static function getSearchObject($langId = 0, $isActive = true)
    {
        $srch = new SearchBase(static::DB_TBL, 'ep');

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'ep_l.' . static::DB_TBL_LANG_PREFIX . 'epage_id = ep.' . static::tblFld('id') . ' and
			ep_l.' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'ep_l'
            );
        }

        if ($isActive) {
            $srch->addCondition('epage_active', '=', applicationConstants::ACTIVE);
        }

        return $srch;
    }

    public static function getContentBlockArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
            static::CONTACT_US_CONTENT_BLOCK => Labels::getLabel('LBL_CONTACT_US_CONTENT_BLOCK', $langId),
            static::LOGIN_PAGE_RIGHT_BLOCK => Labels::getLabel('LBL_LOGIN_PAGE_RIGHT_BLOCK', $langId),
            static::REGISTRATION_PAGE_RIGHT_BLOCK => Labels::getLabel('LBL_REGISTRATION_PAGE_RIGHT_BLOCK', $langId),
            //static::RESET_PAGE_RIGHT_BLOCK => Labels::getLabel('LBL_RESET_PAGE_RIGHT_BLOCK', $langId),
            static::SELLER_PAGE_BLOCK1 => Labels::getLabel('LBL_SELLER_PAGE_BLOCK1', $langId),
            static::SELLER_PAGE_BLOCK2 => Labels::getLabel('LBL_SELLER_PAGE_BLOCK2', $langId),
            static::SELLER_PAGE_BLOCK3 => Labels::getLabel('LBL_SELLER_PAGE_BLOCK3', $langId),
            static::SELLER_BANNER_SLOGAN => Labels::getLabel('LBL_SELLER_BANNER_SLOGAN', $langId),
            static::SUBSCRIPTION_PAGE_BLOCK => Labels::getLabel('LBL_SUBSCRIPTION_PAGE_BLOCK', $langId),
            static::ADVERTISER_BANNER_SLOGAN => Labels::getLabel('LBL_ADVERTISER_BANNER_SLOGAN', $langId),
            static::AFFILIATE_BANNER_SLOGAN => Labels::getLabel('LBL_AFFILIATE_BANNER_SLOGAN', $langId),
        );
    }

    public function updatePageContent($data = array())
    {
        if (!($this->mainTableRecordId > 0)) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->commonLangId);
            return false;
        }

        $epage_id = FatUtility::int($data['epage_id']);
        unset($data['btn_submit']);
        unset($data['epage_id']);

        if (!FatApp::getDb()->updateFromArray(
            static::DB_TBL,
            $data,
            array('smt' => static::DB_TBL_PREFIX . 'id = ? ', 'vals' => array((int)$epage_id))
        )) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }

        return true;
    }

    public function getContentByPageType($pageType = '', $langId = 0)
    {
        if ($pageType == '') {
            return '';
        }
        $flds = ['epage_id', 'epage_identifier', 'epage_type', 'epage_content_for', 'epage_active', 'epage_default', 'epage_default_content', 'epage_extra_info', 'epage_updated_on'];
        $langId = FatUtility::int($langId);
        if (0 < $langId) {
            $flds = array_merge($flds, ['epagelang_epage_id', 'epagelang_lang_id', 'epage_label', 'epage_content']);
        }

        $srch = self::getSearchObject($langId);
        $srch->addCondition('ep.epage_type', '=', $pageType);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addMultipleFields($flds);
        return FatApp::getDb()->fetch($srch->getResultSet());
    }

    public static function isActive($pageType)
    {
        // use to stop multiple query on dashboard
        if (isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['isContentActive'][$pageType])) {
            return $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['isContentActive'][$pageType];
        }
        $srch = self::getSearchObject();
        $srch->addCondition('ep.epage_type', '=', $pageType);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addFld('epage_id');
        $row = FatApp::getDb()->fetch($srch->getResultSet());

        $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['isContentActive'][$pageType] = NULL !== $row;

        return NULL !== $row;
    }

    public static function getContentBlockArrWithBg($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
            static::SELLER_BANNER_SLOGAN => Labels::getLabel('LBL_SELLER_BANNER_SLOGAN', $langId),
            static::ADVERTISER_BANNER_SLOGAN => Labels::getLabel('LBL_ADVERTISER_BANNER_SLOGAN', $langId),
            static::AFFILIATE_BANNER_SLOGAN => Labels::getLabel('LBL_AFFILIATE_BANNER_SLOGAN', $langId),
        );
    }

    public function rewriteUrl($keyword)
    {
        if ($this->mainTableRecordId < 1) {
            return false;
        }

        $originalUrl = static::REWRITE_URL_PREFIX . $this->mainTableRecordId;

        $seoUrl = CommonHelper::seoUrl($keyword);

        $customUrl = UrlRewrite::getValidSeoUrl($seoUrl, $originalUrl, $this->mainTableRecordId);

        return UrlRewrite::update($originalUrl, $customUrl);
    }

    /**
     * saveLangData
     *
     * @param  int $langId
     * @param  string $collectionName
     * @return bool
     */
    public function saveLangData(int $langId, array $data): bool
    {
        $langId = FatUtility::int($langId);
        if ($this->mainTableRecordId < 1 || $langId < 1) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->commonLangId);
            return false;
        }

        $data = array(
            'epagelang_epage_id' => $this->mainTableRecordId,
            'epagelang_lang_id' => $langId,
            'epage_label' => $data['epage_label'],
            'epage_content' => $data['epage_content'],
        );

        if (!$this->updateLangData($langId, $data)) {
            $this->error = $this->getError();
            return false;
        }
        return true;
    }

    /**
     * saveTranslatedLangData
     *
     * @param  int $langId
     * @return bool
     */
    public function saveTranslatedLangData(int $langId): bool
    {
        $langId = FatUtility::int($langId);
        if ($this->mainTableRecordId < 1 || $langId < 1) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->commonLangId);
            return false;
        }

        $translateLangobj = new TranslateLangData(static::DB_TBL_LANG);
        if (false === $translateLangobj->updateTranslatedData($this->mainTableRecordId, 0, $langId)) {
            $this->error = $translateLangobj->getError();
            return false;
        }
        return true;
    }

    /**
     * getTranslatedData
     *
     * @param  array $data
     * @param  int $toLangId
     * @return bool
     */
    public function getTranslatedData(array $data, int $toLangId)
    {
        $toLangId = FatUtility::int($toLangId);
        if (empty($data) || $toLangId < 1) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->commonLangId);
            return false;
        }

        $translateLangobj = new TranslateLangData(static::DB_TBL_LANG);
        $translatedData = $translateLangobj->directTranslate($data, $toLangId);
        if (false === $translatedData) {
            $this->error = $translateLangobj->getError();
            return false;
        }
        return $translatedData;
    }

    /**
     * nonHtmlEditorBlocks
     *
     * @param  mixed $block
     * @return void
     */
    public static function nonHtmlEditorBlocks(int $block): bool
    {
        $arr = [
            static::ADVERTISER_BANNER_SLOGAN,
            static::SELLER_BANNER_SLOGAN,
            static::AFFILIATE_BANNER_SLOGAN,
        ];

        return in_array($block, $arr);
    }
}
