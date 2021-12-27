<?php

class MetaTag extends MyAppModel
{
    public const DB_TBL = 'tbl_meta_tags';
    public const DB_TBL_PREFIX = 'meta_';

    public const DB_TBL_LANG = 'tbl_meta_tags_lang';
    public const DB_TBL_LANG_PREFIX = 'metalang_';

    public const META_GROUP_ALL_PRODUCTS = 'all_product';
    public const META_GROUP_PRODUCT_DETAIL = 'product_view';
    public const META_GROUP_ALL_SHOPS = 'all_shop';
    public const META_GROUP_SHOP_DETAIL = 'shop_view';
    public const META_GROUP_CMS_PAGE = 'cms_page_view';
    public const META_GROUP_DEFAULT = 'default';
    public const META_GROUP_ADVANCED = 'advanced_setting';
    public const META_GROUP_ALL_BRANDS = 'all_brand';
    public const META_GROUP_BRAND_DETAIL = 'brand_view';
    public const META_GROUP_CATEGORY_DETAIL = 'category_view';
    public const META_GROUP_BLOG_PAGE = 'BLOG_PAGE';
    public const META_GROUP_BLOG_CATEGORY = 'Blog_Category';
    public const META_GROUP_BLOG_POST = 'Blog_Post';

    private static $result = [];

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->objMainTableRecord->setSensitiveFields([static::DB_TBL_PREFIX . 'id']);
    }

    public static function getTabsArr(int $langId = 0)
    {
        $langId = 0 < $langId ? $langId : CommonHelper::getLangId();

        $metaTagsTabsArr = CacheHelper::get('metaTagsTabsArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if ($metaTagsTabsArr) {
            return json_decode($metaTagsTabsArr);
        }

        $metaGroups = array(
            static::META_GROUP_ALL_PRODUCTS => array(
                'serial' => 2,
                'name' => Labels::getLabel('NAV_ALL_PRODUCTS', $langId),
                'msg' => Labels::getLabel('MSG_MANAGE_META_TAGS_FOR_PRODUCTS\'_CATALOG_LISTING_PAGE', $langId),
                'controller' => 'Products',
                'action' => 'index',
                'isEntity' => false
            ),
            static::META_GROUP_PRODUCT_DETAIL => array(
                'serial' => 3,
                'name' => Labels::getLabel('NAV_PRODUCT_DETAIL', $langId),
                'msg' => Labels::getLabel('MSG_MANAGE_META_TAGS_FOR_EACH_PRODUCT\'S_DETAIL_PAGE', $langId),
                'controller' => 'Products',
                'action' => 'view',
                'Entity Caption' => Labels::getLabel('LBL_PRODUCT', $langId),
                'isEntity' => true
            ),
            static::META_GROUP_ALL_SHOPS => array(
                'serial' => 4,
                'name' => Labels::getLabel('NAV_ALL_SHOPS', $langId),
                'msg' => Labels::getLabel('MSG_MANAGE_META_TAGS_FOR_\'ALL_SHOPS\'_LISTING_PAGE', $langId),
                'controller' => 'Shops',
                'action' => 'index',
                'isEntity' => false
            ),
            static::META_GROUP_SHOP_DETAIL => array(
                'serial' => 5,
                'name' => Labels::getLabel('NAV_SHOP_DETAIL', $langId),
                'msg' => Labels::getLabel('MSG_MANAGE_METATAGS_FOR_EACH_SHOP_DETAIL_PAGE', $langId),
                'controller' => 'Shops',
                'action' => 'view',
                'Entity Caption' => Labels::getLabel('LBL_SHOP', $langId),
                'isEntity' => true
            ),
            static::META_GROUP_CMS_PAGE => array(
                'serial' => 6,
                'name' => Labels::getLabel('NAV_CMS_PAGE', $langId),
                'msg' => Labels::getLabel('MSG_MANAGE_META_TAGS_FOR_ALL_THE_CMS_CONTENT_PAGES', $langId),
                'controller' => 'Cms',
                'action' => 'view',
                'isEntity' => false
            ),
            static::META_GROUP_DEFAULT => array(
                'serial' => 0,
                'name' => Labels::getLabel('NAV_DEFAULT', $langId),
                'msg' => Labels::getLabel('MSG_MANAGE_META_TAGS_FOR_DEFAULT_PAGE', $langId),
                'controller' => '',
                'action' => '',
                'isEntity' => false
            ),
            static::META_GROUP_ADVANCED => array(
                'serial' => 99,
                'name' => Labels::getLabel('NAV_ADVANCED_SETTING', $langId),
                'msg' => Labels::getLabel('MSG_MANAGE_METATAGS_FOR_EXTERNAL_PAGES_CREATED_IF_ANY', $langId),
                'controller' => '',
                'action' => '',
                'isEntity' => false
            ),
            static::META_GROUP_ALL_BRANDS => array(
                'serial' => 7,
                'name' => Labels::getLabel('NAV_ALL_BRANDS', $langId),
                'msg' => Labels::getLabel('LBL_MANAGE_META_TAGS_FOR_BRANDS_LISTING_PAGE', $langId),
                'controller' => 'Brands',
                'action' => 'index',
                'isEntity' => false
            ),
            static::META_GROUP_BRAND_DETAIL => array(
                'serial' => 8,
                'name' => Labels::getLabel('NAV_BRAND_DETAIL', $langId),
                'msg' => Labels::getLabel('MSG_MANAGE_METATAGS_FOR_EACH_BRAND_DETAIL_PAGE', $langId),
                'controller' => 'Brands',
                'action' => 'view',
                'Entity Caption' => Labels::getLabel('LBL_BRAND', $langId),
                'isEntity' => true
            ),
            static::META_GROUP_CATEGORY_DETAIL => array(
                'serial' => 9,
                'name' => Labels::getLabel('NAV_CATEGORY_DETAIL', $langId),
                'msg' => Labels::getLabel('MSG_MANAGE_METATAGS_FOR_PRODUCT_CATEGORY_DETAIL_PAGE', $langId),
                'controller' => 'Category',
                'action' => 'view',
                'Entity Caption' => Labels::getLabel('LBL_CATEGORY', $langId),
                'isEntity' => true
            ),
            static::META_GROUP_BLOG_PAGE => array(
                'serial' => 10,
                'name' => Labels::getLabel('NAV_BLOG_PAGE', $langId),
                'msg' => Labels::getLabel('MSG_MANAGE_METATAGS_FOR_BLOGS\'_DETAIL_PAGE', $langId),
                'controller' => 'Blog',
                'action' => 'index',
                'Entity Caption' => Labels::getLabel('LBL_BLOG', $langId),
                'isEntity' => true
            ),
            static::META_GROUP_BLOG_CATEGORY => array(
                'serial' => 11,
                'name' => Labels::getLabel('NAV_BLOG_CATEGORY', $langId),
                'msg' => Labels::getLabel('MSG_MANAGE_METATAGS_FOR_BLOG_CATEGORIES\'_DETAIL_PAGE', $langId),
                'controller' => 'Blog',
                'action' => 'category',
                'Entity Caption' => Labels::getLabel('LBL_BLOG_CATEGORY', $langId),
                'isEntity' => true
            ),
            static::META_GROUP_BLOG_POST => array(
                'serial' => 12,
                'name' => Labels::getLabel('NAV_BLOG_POST', $langId),
                'msg' => Labels::getLabel('MSG_MANAGE_METATAGS_FOR_EACH_BLOG_POSTS', $langId),
                'controller' => 'Blog',
                'action' => 'postDetail',
                'Entity Caption' => Labels::getLabel('LBL_BLOG_POST', $langId),
                'isEntity' => true
            )
        );

        uasort(
            $metaGroups,
            function ($group1, $group2) {
                if ($group1['serial'] == $group2['serial']) {
                    return 0;
                }
                return ($group1['serial'] < $group2['serial']) ? -1 : 1;
            }
        );
        CacheHelper::create('metaTagsTabsArr' . $langId, json_encode($metaGroups), CacheHelper::TYPE_META_TAGS);
        return $metaGroups;
    }

    public static function getSearchObject()
    {
        return new SearchBase(static::DB_TBL, 'mt');
    }

    public static function isExists(string $controller, string $action, int $recordId, int $subRecordId): bool
    {
        $srch = self::getSearchObject();
        $srch->addCondition('meta_controller', '=', $controller);
        $srch->addCondition('meta_action', '=', $action);
        $srch->addCondition('meta_record_id', '=', $recordId);
        $srch->addCondition('meta_subrecord_id', '=', $subRecordId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        self::$result = (array) FatApp::getDb()->fetch($rs);
        return !empty(self::$result);
    }

    public static function getResult(): array
    {
        return self::$result;
    }
}
