<?php

class BlogPostCategory extends MyAppModel
{
    public const DB_TBL = 'tbl_blog_post_categories';
    public const DB_TBL_PREFIX = 'bpcategory_';
    public const DB_TBL_LANG = 'tbl_blog_post_categories_lang';
    public const DB_TBL_LANG_PREFIX = 'bpcategorylang_';
    public const REWRITE_URL_PREFIX = 'blog/category/';
    private $db;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
        $this->objMainTableRecord->setSensitiveFields([self::DB_TBL_PREFIX . 'id']);
    }

    public static function getSearchObject($includeChildCount = false, $langId = 0, $bpcategory_active = true)
    {
        $langId = FatUtility::int($langId);
        $srch = new SearchBase(static::DB_TBL, 'bpc');
        $srch->addOrder('bpc.bpcategory_active', 'DESC');

        if ($includeChildCount) {
            $childSrchbase = new SearchBase(static::DB_TBL);
            $childSrchbase->addCondition('bpcategory_deleted', '=', 0);
            $childSrchbase->doNotCalculateRecords();
            $childSrchbase->doNotLimitRecords();

            $srch->joinTable('(' . $childSrchbase->getQuery() . ')', 'LEFT OUTER JOIN', 's.bpcategory_parent = bpc.bpcategory_id', 's');
            $srch->addGroupBy('bpc.bpcategory_id');
            $srch->addFld('COUNT(s.bpcategory_id) AS child_count');
        }

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'bpc_l.' . static::DB_TBL_LANG_PREFIX . 'bpcategory_id = bpc.' . static::tblFld('id') . ' and
			bpc_l.' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'bpc_l'
            );
        }

        if ($bpcategory_active) {
            $srch->addCondition('bpc.bpcategory_active', '=', applicationConstants::ACTIVE);
        }
        $srch->addCondition('bpc.bpcategory_deleted', '=', applicationConstants::NO);
        return $srch;
    }

    /**
     * getMaxOrder
     *
     * @param  int $parent
     * @return int
     */
    public function getMaxOrder(int $parent = 0): int
    {
        $srch = new SearchBase(static::DB_TBL);
        $srch->addFld("MAX(" . static::DB_TBL_PREFIX . "display_order) as max_order");
        if (0 < $parent) {
            $srch->addCondition(static::DB_TBL_PREFIX . 'parent', '=', $parent);
        }
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        $record = FatApp::getDb()->fetch($rs);
        if (!empty($record)) {
            return $record['max_order'] + 1;
        }
        return 0;
    }

    /**
     * getCategoryStructure
     *
     * @param  int $bpcategoryId
     * @param  array $categoryTreeArray
     * @return array
     */
    public function getCategoryStructure(int $bpcategoryId, array $categoryTreeArray = array()): array
    {
        if (!is_array($categoryTreeArray)) {
            $categoryTreeArray = array();
        }

        $srch = static::getSearchObject();
        $srch->addCondition('bpc.bpcategory_deleted', '=', applicationConstants::NO);
        $srch->addCondition('bpc.bpcategory_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition('bpc.bpcategory_id', '=', $bpcategoryId);
        $srch->addOrder('bpc.bpcategory_display_order', 'asc');
        $srch->addOrder('bpc.bpcategory_identifier', 'asc');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        while ($categories = FatApp::getDb()->fetch($rs)) {
            $categoryTreeArray[] = $categories;
            $categoryTreeArray = $this->getCategoryStructure($categories['bpcategory_parent'], $categoryTreeArray);
        }
        sort($categoryTreeArray);
        return $categoryTreeArray;
    }

    /**
     * getParentTreeStructure
     *
     * @param  mixed $bpCategoryId
     * @param  mixed $level
     * @param  mixed $nameSuffix
     * @return string
     */
    public function getParentTreeStructure(int $bpCategoryId = 0, int $level = 0, string $nameSuffix = ''): string
    {
        $srch = static::getSearchObject();
        $srch->addFld('bpc.bpcategory_id,bpc.bpcategory_identifier,bpc.bpcategory_parent');
        $srch->addCondition('bpc.bpcategory_deleted', '=', applicationConstants::NO);
        $srch->addCondition('bpc.bpcategory_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition('bpc.bpCategory_id', '=', FatUtility::int($bpCategoryId));
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetch($rs);
        $name = '';
        $seprator = '';
        if ($level > 0) {
            $seprator = ' &nbsp;&nbsp;&raquo;&raquo;&nbsp;&nbsp;';
        }

        if ($records) {
            $name = $records['bpcategory_identifier'] . $seprator . $nameSuffix;
            if ($records['bpcategory_parent'] > 0) {
                $name = $this->getParentTreeStructure($records['bpcategory_parent'], $level + 1, $name);
            }
        }
        return $name;
    }

    public static function isCategoryActive(int $categoryId): int
    {
        $categoryId = FatUtility::int($categoryId);

        $srch = self::getSearchObject(false, 0, true);
        $srch->addCondition('bpcategory_id', '=', $categoryId);
        $srch->getResultSet();
        return (int) $srch->recordCount();
    }

    public static function getActiveCategoriesFromCodes($catCodes = array())
    {
        $out = array();

        foreach ($catCodes as $key => $catCode) {
            $hierarchyArr = str_split($catCode, 6);

            $this_active = 1;
            foreach ($hierarchyArr as $node) {
                $node = FatUtility::int($node);
                if (!static::isCategoryActive($node)) {
                    $this_active = 0;
                    break;
                }
            }
            if ($this_active == applicationConstants::ACTIVE) {
                $out[] = $key;
            }
        }
        return $out;
    }

    public function makeAssociativeArray($arr, $prefix = ' » ')
    {
        $out = array();
        $tempArr = array();
        foreach ($arr as $key => $value) {
            $tempArr[] = $key;
            $name = $value['bpcategory_name'];
            $code = str_replace('_', '', $value['bpcategory_code']);
            $hierarchyArr = str_split($code, 6);
            $this_deleted = 0;
            foreach ($hierarchyArr as $node) {
                $node = FatUtility::int($node);
                if (!in_array($node, $tempArr)) {
                    $this_deleted = 1;
                    break;
                }
            }
            if ($this_deleted == 0) {
                $level = strlen($code) / 6;
                for ($i = 1; $i < $level; $i++) {
                    $name = $prefix . $name;
                }
                $out[$key] = $name;
            }
        }
        return $out;
    }

    public function getCategoriesForSelectBox(int $langId, int $ignoreCategoryId = 0, bool $checkActive = true)
    {
        $srch = static::getSearchObject(false, 0, $checkActive);
        $srch->joinTable(
            static::DB_TBL_LANG,
            'LEFT OUTER JOIN',
            'bpcategorylang_bpcategory_id = bpcategory_id
			AND bpcategorylang_lang_id = ' . $langId
        );
        $srch->addCondition(static::DB_TBL_PREFIX . 'deleted', '=', 0);
        $srch->addMultipleFields(
            array(
                'bpcategory_id',
                'IFNULL(bpcategory_name, bpcategory_identifier) AS bpcategory_name',
                'GETBLOGCATCODE(bpcategory_id) AS bpcategory_code'
            )
        );

        $srch->addOrder('GETBLOGCATORDERCODE(bpcategory_id)');

        if ($ignoreCategoryId > 0) {
            $srch->addHaving('bpcategory_code', 'NOT LIKE', '%' . str_pad($ignoreCategoryId, 6, '0', STR_PAD_LEFT) . '%');
        }
        $rs = $srch->getResultSet();
        return FatApp::getDb()->fetchAll($rs, 'bpcategory_id');
    }

    public function getFeaturedCategories(int $langId): array
    {
        $srch = static::getSearchObject();
        $srch->joinTable(
            static::DB_TBL_LANG,
            'LEFT OUTER JOIN',
            'bpcategorylang_bpcategory_id = bpcategory_id
			AND bpcategorylang_lang_id = ' . $langId
        );
        $srch->addCondition(static::DB_TBL_PREFIX . 'featured', '=', 1);
        $srch->addMultipleFields(
            array(
                'bpcategory_id',
                'IFNULL(bpcategory_name, bpcategory_identifier) AS bpcategory_name',
                'GETBLOGCATCODE(bpcategory_id) AS bpcategory_code'
            )
        );

        $srch->addOrder('GETBLOGCATORDERCODE(bpcategory_id)');
        return FatApp::getDb()->fetchAll($srch->getResultSet(), 'bpcategory_id');
    }

    public function getBlogPostCatTreeStructure($parent_id = 0, $keywords = '', $level = 0, $name_prefix = '')
    {
        $srch = static::getSearchObject();
        $srch->addFld('bpc.bpcategory_id,bpc.bpcategory_identifier');
        $srch->addCondition('bpc.bpcategory_deleted', '=', applicationConstants::NO);
        $srch->addCondition('bpc.bpcategory_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition('bpc.bpcategory_parent', '=', FatUtility::int($parent_id));

        if (!empty($keywords)) {
            $srch->addCondition('bpc.bpcategory_identifier', 'like', '%' . $keywords . '%');
        }
        $srch->addOrder('bpc.bpcategory_display_order', 'asc');
        $srch->addOrder('bpc.bpcategory_identifier', 'asc');
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAllAssoc($rs);

        $return = array();
        $seprator = '';
        if ($level > 0) {
            $seprator = '&raquo;&raquo;&nbsp;&nbsp;';
            $seprator = CommonHelper::renderHtml($seprator);
        }
        foreach ($records as $bpcategory_id => $bpcategory_identifier) {
            $name = $name_prefix . $seprator . $bpcategory_identifier;
            $return[$bpcategory_id] = $name;
            $return += $this->getBlogPostCatTreeStructure($bpcategory_id, $keywords, $level + 1, $name);
        }
        return $return;
    }

    public static function getBlogPostCatParentChildWiseArr(int $langId = 0, int $parentId = 0, bool $includeChildCat = true, bool $forSelectBox = false, bool $isActive = true, bool $excludeDeleted = false): array
    {
        $parentId = FatUtility::int($parentId);
        $langId = FatUtility::int($langId);
        if (!$langId) {
            trigger_error(Labels::getLabel('MSG_Language_not_specified', $langId), E_USER_ERROR);
        }
        $bpCatSrch = new BlogPostCategorySearch($langId, $isActive);
        $bpCatSrch->doNotCalculateRecords();
        $bpCatSrch->doNotLimitRecords();        
        $bpCatSrch->setParent($parentId);
        $bpCatSrch->addOrder('bpcategory_display_order', 'asc');

        if (true === $excludeDeleted) {
            $bpCatSrch->addCondition('bpc.bpcategory_deleted', '=', applicationConstants::NO);
        }

        $rs = $bpCatSrch->getResultSet();
        if ($forSelectBox) {
            $bpCatSrch->addMultipleFields(array('bpcategory_id', 'IFNULL(bpcategory_name,bpcategory_identifier) as bpcategory_name'));
            $categoriesArr = FatApp::getDb()->fetchAllAssoc($rs);
        } else {            
            $categoriesArr = FatApp::getDb()->fetchAll($rs);
        }

        if (!$includeChildCat) {
            return $categoriesArr;
        }
        if (!empty($categoriesArr) && $forSelectBox == false) {
            foreach ($categoriesArr as &$cat) {
                $cat['children'] = self::getBlogPostCatParentChildWiseArr($langId, $cat['bpcategory_id'], $includeChildCat, $forSelectBox, $isActive, $excludeDeleted);
                $childPosts = BlogPost::getBlogPostsUnderCategory($langId, $cat['bpcategory_id']);
                $cat['countChildBlogPosts'] = count($childPosts);
            }
        }

        return $categoriesArr;
    }

    public static function getRootBlogPostCatArr(int $langId): array
    {
        $langId = FatUtility::int($langId);
        if (!$langId) {
            trigger_error(Labels::getLabel('MSG_Language_not_specified', $langId), E_USER_ERROR);
        }
        return static::getBlogPostCatParentChildWiseArr($langId, 0, false, true);
    }

    public function rewriteUrl($keyword, $suffixWithId = true, $parentId = 0)
    {
        if ($this->mainTableRecordId < 1) {
            return false;
        }

        $parentId = FatUtility::int($parentId);
        $parentUrl = '';
        if (0 < $parentId) {
            $parentUrlRewriteData = UrlRewrite::getDataByOriginalUrl(BlogPostCategory::REWRITE_URL_PREFIX . $parentId);
            if (!empty($parentUrlRewriteData)) {
                $parentUrl = preg_replace('/-' . $parentId . '$/', '', $parentUrlRewriteData['urlrewrite_custom']);
            }
        }

        $originalUrl = BlogPostCategory::REWRITE_URL_PREFIX . $this->mainTableRecordId;

        $keyword = preg_replace('/-' . $this->mainTableRecordId . '$/', '', $keyword);
        $seoUrl = CommonHelper::seoUrl($keyword);
        if ($suffixWithId) {
            $seoUrl = $seoUrl . '-' . $this->mainTableRecordId;
        }

        $seoUrl = str_replace($parentUrl, '', $seoUrl);
        $seoUrl = $parentUrl . '-' . $seoUrl;

        $customUrl = UrlRewrite::getValidSeoUrl($seoUrl, $originalUrl);

        $seoUrlKeyword = array(
            'urlrewrite_original' => $originalUrl,
            'urlrewrite_custom' => $customUrl
        );
        if (FatApp::getDb()->insertFromArray(UrlRewrite::DB_TBL, $seoUrlKeyword, false, array(), array('urlrewrite_custom' => $customUrl))) {
            return true;
        }
        return false;
    }

    public function canMarkRecordDelete($bpcategory_id)
    {
        $srch = static::getSearchObject();
        $srch->addCondition('bpc.bpcategory_deleted', '=', applicationConstants::NO);
        $srch->addCondition('bpc.bpcategory_id', '=', $bpcategory_id);
        $srch->addFld('bpc.bpcategory_id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!empty($row) && $row['bpcategory_id'] == $bpcategory_id) {
            return true;
        }
        return false;
    }

    public function canUpdateRecordStatus($bpcategory_id)
    {
        $srch = static::getSearchObject();
        $srch->addCondition('bpc.bpcategory_deleted', '=', applicationConstants::NO);
        $srch->addCondition('bpc.bpcategory_id', '=', $bpcategory_id);
        $srch->addFld('bpc.bpcategory_id,bpc.bpcategory_active');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!empty($row) && $row['bpcategory_id'] == $bpcategory_id) {
            return $row;
        }
        return false;
    }

    public function updateCatParent($parentCatId)
    {
        if ($this->mainTableRecordId < 1) {
            return false;
        }
        $parentCatId = FatUtility::int($parentCatId);         
        FatApp::getDb()->updateFromArray(static::DB_TBL, array(static::DB_TBL_PREFIX . 'parent' => $parentCatId), array('smt' => static::DB_TBL_PREFIX . 'id = ?', 'vals' => array($this->mainTableRecordId)));     
        return true;
    }

    public static function getData(int $langId = 0, int $bpCatId = 0, bool $includeChildCat = true, bool $isActive = true): array
    {
        $bpCatId = FatUtility::int($bpCatId);
        $langId = FatUtility::int($langId);
        if (!$langId) {
            trigger_error(Labels::getLabel('MSG_Language_not_specified', $langId), E_USER_ERROR);
        }
        $bpCatSrch = new BlogPostCategorySearch($langId, $isActive);
        $bpCatSrch->addCondition('bpc.' . static::DB_TBL_PREFIX . 'id', '=', $bpCatId);
        $bpCatSrch->doNotCalculateRecords();
        $bpCatSrch->doNotLimitRecords();
        $bpCatSrch->addOrder('bpcategory_display_order', 'asc');

        $rs = $bpCatSrch->getResultSet();
        $cat = FatApp::getDb()->fetch($rs);
        if (!$includeChildCat) {
            return $cat;
        }

        if (!empty($cat)) {
            $cat['children'] = self::getBlogPostCatParentChildWiseArr($langId, $cat['bpcategory_id'], $includeChildCat, false, $isActive);
            $childPosts = BlogPost::getBlogPostsUnderCategory($langId, $cat['bpcategory_id']);
            $cat['countChildBlogPosts'] = count($childPosts);
        }

        return $cat;
    }

    public static function getParentIds(int $bpCategoryId, array $parentIds = []): array
    {
        $parentId = BlogPostCategory::getAttributesById($bpCategoryId, 'bpcategory_parent');
        array_unshift($parentIds, $bpCategoryId);

        if (0 < $parentId) {
            return self::getParentIds($parentId, $parentIds);
        }
        return $parentIds;
    }
    
    public static function getChildIds($bpCategoryId, array $childIds = []): array
    {
        $bpCatSrch = new BlogPostCategorySearch(0, false);
        $bpCatSrch->addFld('bpcategory_id');
        $bpCatSrch->doNotCalculateRecords();
        $bpCatSrch->doNotLimitRecords();        
        if (is_array($bpCategoryId)) {
            $bpCatSrch->addCondition('bpcategory_parent', 'in', $bpCategoryId);
        } else {
            $childIds[] = $bpCategoryId;
            $bpCatSrch->setParent($bpCategoryId);
        }
        $bpCatSrch->addOrder('bpcategory_display_order', 'asc');
        $bpCatSrch->addCondition('bpc.bpcategory_deleted', '=', applicationConstants::NO);

        $rs = $bpCatSrch->getResultSet();
        $db = FatApp::getDb();
        $ids = [];
        while ($data = $db->fetch($rs)) {
            $ids[] = $data['bpcategory_id'];
            $childIds[] = $data['bpcategory_id'];
        }

        if (!empty($ids)) {
            return self::getChildIds($ids, $childIds);
        }

        return $childIds;
    }

    /**
     * enableParentCategories
     *
     * @return bool
     */
    public function enableParentCategories(): bool
    {
        $catId = $this->getMainTableRecordId();
        if (1 > $catId) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', CommonHelper::getLangId());
            return false;
        }

        $parentIds = self::getParentIds($catId);
        foreach ($parentIds as $recordId) {
            $obj = new self($recordId);
            $obj->changeStatus(applicationConstants::ACTIVE);
        }
        return true;
    }

    /**
     * disableChildCategories
     *
     * @return bool
     */
    public function disableChildCategories(): bool
    {
        $catId = $this->getMainTableRecordId();
        if (1 > $catId) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', CommonHelper::getLangId());
            return false;
        }

        $childIds = self::getChildIds($catId);
        foreach ($childIds as $recordId) {
            $obj = new self($recordId);
            $obj->changeStatus(applicationConstants::INACTIVE);
        }
        return true;
    }
}
