<?php

class BlogPost extends MyAppModel
{
    public const DB_TBL = 'tbl_blog_post';
    public const DB_TBL_PREFIX = 'post_';
    public const DB_TBL_LANG = 'tbl_blog_post_lang';
    public const DB_TBL_LANG_PREFIX = 'postlang_';
    public const DB_POST_TO_CAT_TBL = 'tbl_blog_post_to_category';
    public const DB_POST_TO_CAT_TBL_PREFIX = 'ptc_';
    public const REWRITE_URL_PREFIX = 'blog/post-detail/';

    private $db;
    public $total_records;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }

    public static function getSearchObject($langId = 0, $joinCategory = true, $post_published = false, $categoryActive = false, $addOrder = true)
    {
        $langId = FatUtility::int($langId);
        $srch = new SearchBase(static::DB_TBL, 'bp');
        if (true === $addOrder) {
            $srch->addOrder('bp.post_published', 'DESC');
        }

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'bp_l.' . static::DB_TBL_LANG_PREFIX . 'post_id = bp.' . static::tblFld('id') . ' and
			bp_l.' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'bp_l'
            );
        }

        if ($joinCategory) {
            $srch->joinTable(
                static::DB_POST_TO_CAT_TBL,
                'LEFT OUTER JOIN',
                'bptc.' . static::DB_POST_TO_CAT_TBL_PREFIX . 'post_id = bp.' . static::tblFld('id'),
                'bptc'
            );

            $srch->joinTable(
                BlogPostCategory::DB_TBL,
                'LEFT OUTER JOIN',
                'bptc.' . static::DB_POST_TO_CAT_TBL_PREFIX . 'bpcategory_id = bpc.' . BlogPostCategory::tblFld('id') . ' and bpc.bpcategory_deleted =0',
                'bpc'
            );
            if ($langId > 0) {
                $srch->joinTable(
                    BlogPostCategory::DB_TBL_LANG,
                    'LEFT OUTER JOIN',
                    'bpc_l.' . BlogPostCategory::DB_TBL_LANG_PREFIX . 'bpcategory_id = bpc.' . BlogPostCategory::tblFld('id') . ' and bpc_l.' . BlogPostCategory::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                    'bpc_l'
                );
            }
        }

        if ($categoryActive) {
            $srch->addCondition('bpc.bpcategory_active', '=', applicationConstants::ACTIVE);
        }
        if ($post_published) {
            $srch->addCondition('bp.post_published', '=', applicationConstants::ACTIVE);
        }
        $srch->addCondition('bp.post_deleted', '=', applicationConstants::NO);
        return $srch;
    }

    public static function getBlogPostsUnderCategory(int $langId, int $bpcategory_id): array
    {
        $langId = FatUtility::int($langId);
        $bpcategory_id = FatUtility::int($bpcategory_id);
        $srch = BlogPost::getSearchObject($langId);
        $srch->addCondition('postlang_post_id', 'is not', 'mysql_func_null', 'and', true);
        $srch->addCondition('ptc_bpcategory_id', '=', $bpcategory_id);
        $srch->addGroupby('post_id');
        $srch->doNotCalculateRecords();
        return FatApp::getDb()->fetchAll($srch->getResultSet());
    }

    public function updateImagesOrder(int $postId, array $order): bool
    {
        $postId = FatUtility::int($postId);
        if (is_array($order) && sizeof($order) > 0) {
            foreach ($order as $i => $id) {
                if (FatUtility::int($id) < 1) {
                    continue;
                }
                FatApp::getDb()->updateFromArray('tbl_attached_files', array('afile_display_order' => $i), array('smt' => 'afile_type = ? AND afile_record_id = ? AND afile_id = ?', 'vals' => array(AttachedFile::FILETYPE_BLOG_POST_IMAGE, $postId, $id)));
            }
            return true;
        }
        return false;
    }

    public function getPostCategories(int $postId, int $langId = 0): array
    {
        $srch = new SearchBase(static::DB_POST_TO_CAT_TBL, 'ptc');
        $srch->addMultipleFields(['bpcategory_id']);
        $srch->addCondition(static::DB_POST_TO_CAT_TBL_PREFIX . 'post_id', '=', $postId);

        $srch->joinTable(BlogPostCategory::DB_TBL, 'INNER JOIN', BlogPostCategory::DB_TBL_PREFIX . 'id = ptc.' . static::DB_POST_TO_CAT_TBL_PREFIX . 'bpcategory_id', 'cat');
        if (0 < $langId) {
            $srch->joinTable(BlogPostCategory::DB_TBL_LANG, 'LEFT JOIN', BlogPostCategory::DB_TBL_PREFIX . 'id = bpc_l.' . BlogPostCategory::DB_TBL_LANG_PREFIX . BlogPostCategory::DB_TBL_PREFIX . 'id AND ' . BlogPostCategory::DB_TBL_LANG_PREFIX .'lang_id = ' . $langId, 'bpc_l');
            $srch->addFld('COALESCE(bpcategory_name, bpcategory_identifier) as bpcategory_name');
        }
        $srch->doNotCalculateRecords();
        return FatApp::getDb()->fetchAll($srch->getResultSet());
    }

    public function addUpdateCategories(int $postId, array $categories = array()): bool
    {
        if (!$postId) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST!', $this->commonLangId);
            return false;
        }

        FatApp::getDb()->deleteRecords(static::DB_POST_TO_CAT_TBL, array('smt' => static::DB_POST_TO_CAT_TBL_PREFIX . 'post_id = ?', 'vals' => array($postId)));
        if (empty($categories)) {
            return true;
        }

        $record = new TableRecord(static::DB_POST_TO_CAT_TBL);
        foreach ($categories as $category_id) {
            $to_save_arr = array();
            $to_save_arr['ptc_post_id'] = $postId;
            $to_save_arr['ptc_bpcategory_id'] = $category_id;
            $record->assignValues($to_save_arr);
            if (!$record->addNew(array(), $to_save_arr)) {
                $this->error = $record->getError();
                return false;
            }
        }
        return true;
    }

    public function rewriteUrl(string $keyword, bool $suffixWithId = true): bool
    {
        if ($this->mainTableRecordId < 1) {
            return false;
        }

        $originalUrl = BlogPost::REWRITE_URL_PREFIX . $this->mainTableRecordId;

        $keyword = preg_replace('/-' . $this->mainTableRecordId . '$/', '', $keyword);
        $seoUrl = CommonHelper::seoUrl($keyword);

        if ($suffixWithId) {
            $seoUrl = $seoUrl . '-' . $this->mainTableRecordId;
        }

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

    public function canMarkRecordDelete()
    {
        $postId = FatUtility::int($this->mainTableRecordId);
        if ($postId > 0) {
            $srch = static::getSearchObject();
            $srch->addCondition('post_deleted', '=', applicationConstants::NO);
            $srch->addCondition('post_id', '=', $postId);
            $srch->addFld('post_id');
            $srch->doNotCalculateRecords();
            $srch->setPageSize(1);
            $rs = $srch->getResultSet();
            $row = FatApp::getDb()->fetch($rs);
            if (!empty($row) && $row['post_id'] == $postId) {
                return true;
            }
        }
        return false;
    }

    public function deleteBlogPostImage(int $postId, int $image_id): bool
    {
        $postId = FatUtility::int($postId);
        $image_id = FatUtility::int($image_id);
        if ($postId < 1 || $image_id < 1) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST!', $this->commonLangId);
            return false;
        }

        $fileHandlerObj = new AttachedFile();
        if (!$fileHandlerObj->deleteFile(AttachedFile::FILETYPE_BLOG_POST_IMAGE, $postId, $image_id)) {
            $this->error = $fileHandlerObj->getError();
            return false;
        }
        return true;
    }

    public static function convertArrToSrchFiltersAssocArr($arr)
    {
        return SearchItem::convertArrToSrchFiltersAssocArr($arr);
    }

    public function setPostViewsCount(int $postId = 0): bool
    {
        $postId = FatUtility::int($postId);
        if ($postId < 1) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST!', $this->commonLangId);
            return false;
        }

        $srch = new SearchBase(static::DB_TBL, 'bp');
        $srch->addCondition('post_id', '=', $postId);
        $srch->addFld('post_view_count');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $this->total_records = $srch->recordCount();
        $result_data = $this->db->fetch($rs);
        $record = new TableRecord(static::DB_TBL);
        $assign_field['post_view_count'] = $result_data['post_view_count'] + 1;
        $record->assignValues($assign_field);
        if ($record->update(array('smt' => '`post_id`=?', 'vals' => array($postId)))) {
            return true;
        }
        $this->error = $this->db->getError();
        return false;
    }

    public static function getBlogPostStatusArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
            applicationConstants::DRAFT => Labels::getLabel('LBL_DRAFT', $langId),
            applicationConstants::PUBLISHED => Labels::getLabel('LBL_PUBLISHED', $langId),
        );
    }

    public static function getStatusHtml(int $langId, int $status): string
    {
        $arr = self::getBlogPostStatusArr($langId);
        $msg = $arr[$status] ?? Labels::getLabel('LBL_N/A', $langId);
        switch ($status) {
            case applicationConstants::DRAFT:
                $status = HtmlHelper::INFO;
                break;
            case applicationConstants::PUBLISHED:
                $status = HtmlHelper::SUCCESS;
                break;

            default:
                $status = HtmlHelper::PRIMARY;
                break;
        }
        return HtmlHelper::getStatusHtml($status, $msg);
    }
}
