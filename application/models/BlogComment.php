<?php

class BlogComment extends MyAppModel
{
    public const DB_TBL = 'tbl_blog_post_comments';
    public const DB_TBL_PREFIX = 'bpcomment_';

    public const COMMENT_STATUS_PENDING = 0;
    public const COMMENT_STATUS_APPROVED = 1;
    public const COMMENT_STATUS_REJECT = 2;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getSearchObject($joinBlogPost = true, $langId = 0)
    {
        $langId = FatUtility::int($langId);
        $srch = new SearchBase(static::DB_TBL);

        if ($joinBlogPost) {
            $srch->joinTable(BlogPost::DB_TBL, 'left outer join', static::DB_TBL_PREFIX . 'post_id = ' . BlogPost::DB_TBL_PREFIX . 'id');
            if ($langId) {
                $srch->joinTable(BlogPost::DB_TBL_LANG, 'left outer join', BlogPost::DB_TBL_PREFIX . 'id = ' . BlogPost::DB_TBL_LANG_PREFIX . 'post_id and ' . BlogPost::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId);
            }
        }

        $srch->addCondition('bpcomment_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        return $srch;
    }

    public function canMarkRecordDelete(int $bpcommentId): bool
    {
        $srch = static::getSearchObject();
        $srch->addCondition('bpcomment_deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        $srch->addCondition('bpcomment_id', '=', 'mysql_func_' . $bpcommentId, 'AND', true);
        $srch->addFld('bpcomment_id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!empty($row) && $row['bpcomment_id'] == $bpcommentId) {
            return true;
        }
        return false;
    }

    public static function getBlogCommentStatusArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
            self::COMMENT_STATUS_PENDING => Labels::getLabel('LBL_PENDING', $langId),
            self::COMMENT_STATUS_APPROVED => Labels::getLabel('LBL_APPROVED', $langId),
            self::COMMENT_STATUS_REJECT => Labels::getLabel('LBL_REJECTED', $langId)
        );
    }

    public static function getStatusHtml(int $langId, int $status): string
    {
        $arr = self::getBlogCommentStatusArr($langId);
        $msg = $arr[$status] ?? Labels::getLabel('LBL_N/A', $langId);
        switch ($status) {
            case self::COMMENT_STATUS_PENDING:
                $status = HtmlHelper::INFO;
                break;
            case self::COMMENT_STATUS_APPROVED:
                $status = HtmlHelper::SUCCESS;
                break;
            case self::COMMENT_STATUS_REJECT:
                $status = HtmlHelper::DANGER;
                break;

            default:
                $status = HtmlHelper::PRIMARY;
                break;
        }
        return HtmlHelper::getStatusHtml($status, $msg);
    }
}
