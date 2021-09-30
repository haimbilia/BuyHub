<?php

class BlogContribution extends MyAppModel
{
    public const DB_TBL = 'tbl_blog_contributions';
    public const DB_TBL_PREFIX = 'bcontributions_';

    public const BLOG_CONTRIBUTION_PENDING = 0;
    public const BLOG_CONTRIBUTION_APPROVED = 1;
    public const BLOG_CONTRIBUTION_POSTED = 2;
    public const BLOG_CONTRIBUTION_REJECTED = 3;

    private $db;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->objMainTableRecord->setSensitiveFields([self::DB_TBL_PREFIX . 'id']);
        $this->db = FatApp::getDb();
    }

    public static function getSearchObject()
    {
        return new SearchBase(static::DB_TBL);
    }

    public static function getBlogContributionStatusArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }

        return array(
            self::BLOG_CONTRIBUTION_PENDING => Labels::getLabel('LBL_PENDING', $langId),
            self::BLOG_CONTRIBUTION_APPROVED => Labels::getLabel('LBL_APPROVED', $langId),
            self::BLOG_CONTRIBUTION_POSTED => Labels::getLabel('LBL_POSTED', $langId),
            self::BLOG_CONTRIBUTION_REJECTED => Labels::getLabel('LBL_REJECTED', $langId),
        );
    }

    public static function getStatusHtml(int $langId, int $status): string
    {
        $arr = self::getBlogContributionStatusArr($langId);
        $msg = $arr[$status];
        switch ($status) {
            case self::BLOG_CONTRIBUTION_PENDING:
                $status = HtmlHelper::INFO;
                break;
            case self::BLOG_CONTRIBUTION_APPROVED:
                $status = HtmlHelper::SUCCESS;
                break;
            case self::BLOG_CONTRIBUTION_POSTED:
                $status = HtmlHelper::SUCCESS;
                break;
            case self::BLOG_CONTRIBUTION_REJECTED:
                $status = HtmlHelper::DANGER;
                break;
            
            default:
                $status = HtmlHelper::PRIMARY;
                break;
        }
        return HtmlHelper::getStatusHtml($status, $msg);
    }
}
