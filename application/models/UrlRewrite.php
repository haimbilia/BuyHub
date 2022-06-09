<?php

class UrlRewrite extends MyAppModel
{
    public const DB_TBL = 'tbl_url_rewrite';
    public const DB_TBL_PREFIX = 'urlrewrite_';
    private $db;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }

    public static function getSearchObject()
    {
        return new SearchBase(static::DB_TBL, 'ur');
    }

    public static function remove($originalUrl)
    {
        if (FatApp::getDb()->deleteRecords(static::DB_TBL, array('smt' => 'urlrewrite_original = ?', 'vals' => array($originalUrl)))) {
            return true;
        }
        return false;
    }

    public static function update($originalUrl, $customUrl)
    {
        $seoUrlKeyword = array(
            'urlrewrite_original' => $originalUrl,
            'urlrewrite_custom' => $customUrl
        );
        if (FatApp::getDb()->insertFromArray(static::DB_TBL, $seoUrlKeyword, false, array(), array('urlrewrite_custom' => $customUrl))) {
            return true;
        }
        return false;
    }

    public static function getDataByCustomUrl($customUrl, $originalUrl = false)
    {
        $urlSrch = static::getSearchObject();
        $urlSrch->doNotCalculateRecords();
        $urlSrch->setPageSize(1);
        $urlSrch->addMultipleFields(array('urlrewrite_id', 'urlrewrite_original', 'urlrewrite_custom'));
        $urlSrch->addCondition('urlrewrite_custom', '=', $customUrl);
        if ($originalUrl) {
            $urlSrch->addCondition('urlrewrite_original', '!=', $originalUrl);
        }
        $rs = $urlSrch->getResultSet();
        $urlRow = FatApp::getDb()->fetch($rs);
        if ($urlRow == false) {
            return array();
        }

        return $urlRow;
    }
    public static function getDataByOriginalUrl($originalUrl, $excludeThisCustomUrl = false)
    {
        $urlSrch = static::getSearchObject();
        $urlSrch->doNotCalculateRecords();
        $urlSrch->setPageSize(1);
        $urlSrch->addMultipleFields(array('urlrewrite_id', 'urlrewrite_original', 'urlrewrite_custom'));
        $urlSrch->addCondition('urlrewrite_original', '=', $originalUrl);
        if ($excludeThisCustomUrl) {
            $urlSrch->addCondition('urlrewrite_custom', '!=', $excludeThisCustomUrl);
        }
        $rs = $urlSrch->getResultSet();
        $urlRow = FatApp::getDb()->fetch($rs);
        if ($urlRow == false) {
            return array();
        }

        return $urlRow;
    }

    public static function getValidSeoUrl($urlKeyword, $originalUrl, $recordId = 0)
    {
        $customUrl = CommonHelper::seoUrl($urlKeyword);

        $res = static::getDataByCustomUrl($customUrl, $originalUrl);
        if (empty($res)) {
            return $customUrl;
        }

        $i = 1;
        if ($recordId > 0) {
            $customUrl = preg_replace('/-' . $recordId . '$/', '', $customUrl) . '-' . $recordId;
        }

        $slug = $customUrl;

        while (static::getDataByCustomUrl($slug, $originalUrl)) {
            $slug = $customUrl . "-" . $i++;
        }

        return $slug;
    }

    public static function isCustomUrlUnique($customUrl)
    {
        return 1 > count(static::getDataByCustomUrl($customUrl));
    }

    public static function getTypeArray($langId)
    {
        $urlRewriteOrgAssoc = CacheHelper::get('urlRewriteOrgAssoc' .  $langId, CONF_DEF_CACHE_TIME, '.txt');
        if ($urlRewriteOrgAssoc) {
            return json_decode($urlRewriteOrgAssoc, true);
        }

        $arr = [
            Shop::SHOP_VIEW_ORGINAL_URL => Labels::getLabel('FRM_SHOP_URLS', $langId),
            Shop::SHOP_REVIEWS_ORGINAL_URL => Labels::getLabel('FRM_SHOP_REVIEW_URLS', $langId),
            Shop::SHOP_POLICY_ORGINAL_URL => Labels::getLabel('FRM_SHOP_POLICY_URLS', $langId),
            Shop::SHOP_SEND_MESSAGE_ORGINAL_URL => Labels::getLabel('FRM_SHOP_MESSAGE_URLS', $langId),
            Shop::SHOP_TOP_PRODUCTS_ORGINAL_URL => Labels::getLabel('FRM_SHOP_TOP_PRODUCTS_URLS', $langId),
            Shop::SHOP_COLLECTION_ORGINAL_URL => Labels::getLabel('FRM_SHOP_COLLECTION_URLS', $langId),
            Brand::REWRITE_URL_PREFIX => Labels::getLabel('FRM_BRANDS_URLS', $langId),
            BlogPost::REWRITE_URL_PREFIX => Labels::getLabel('FRM_BLOG_POST_URLS', $langId),
            BlogPostCategory::REWRITE_URL_PREFIX => Labels::getLabel('FRM_BLOG_CATEGORY_URLS', $langId),
            ContentPage::REWRITE_URL_PREFIX => Labels::getLabel('FRM_CMS_PAGES_URLS', $langId),
            Extrapage::REWRITE_URL_PREFIX => Labels::getLabel('FRM_EXTRA_PAGES_URLS', $langId),
            ProductCategory::REWRITE_URL_PREFIX => Labels::getLabel('FRM_CATEGORIES_URLS', $langId),
            Product::PRODUCT_VIEW_ORGINAL_URL => Labels::getLabel('FRM_PRODUCT_URLS', $langId),
            Product::PRODUCT_REVIEWS_ORGINAL_URL => Labels::getLabel('FRM_PRODUCT_REVIEWS_URLS', $langId),
            Product::PRODUCT_MORE_SELLERS_ORGINAL_URL => Labels::getLabel('FRM_MORE_SELLERS_URLS', $langId),
        ];

        CacheHelper::create('urlRewriteOrgAssoc' . $langId, FatUtility::convertToJson($arr), CacheHelper::TYPE_LABELS);
        return $arr;
    }
}
