<?php

class FaqCategory extends MyAppModel
{
    public const DB_TBL = 'tbl_faq_categories';
    public const DB_TBL_LANG = 'tbl_faq_categories_lang';
    public const DB_TBL_PREFIX = 'faqcat_';
    public const DB_TBL_LANG_PREFIX = 'faqcatlang_';

    public const FAQ_PAGE = 0;
    public const SELLER_PAGE = 1;

    private $db;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->objMainTableRecord->setSensitiveFields([static::DB_TBL_PREFIX . 'id']);
        $this->db = FatApp::getDb();
    }

    public static function getSearchObject($langId = 0, $isDeleted = true)
    {
        $srch = new SearchBase(static::DB_TBL, 'fc');

        if ($isDeleted == true) {
            $srch->addCondition('fc.' . static::DB_TBL_PREFIX . 'deleted', '=', applicationConstants::NO);
        }

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'fc_l.' . static::DB_TBL_LANG_PREFIX . 'faqcat_id = fc.' . static::tblFld('id') . ' and
			fc_l.' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'fc_l'
            );
        }

        $srch->addOrder('fc.' . static::DB_TBL_PREFIX . 'active', 'DESC');
        return $srch;
    }

    public static function getFaqCatTypeArr($langId)
    {
        $langId = FatUtility::int($langId);
        if ($langId < 1) {
            $langId = FatApp::getConfig('CONF_ADMIN_DEFAULT_LANG');
        }
        return array(
        static::FAQ_PAGE => Labels::getLabel('LBL_FAQ_PAGE', $langId),
        static::SELLER_PAGE => Labels::getLabel('LBL_SELLER_PAGE', $langId)
        );
    }

    public function getCategoryStructure(): array
    {
        $srch = static::getSearchObject();
        $srch->addCondition('fc.faqcat_deleted', '=', applicationConstants::NO);
        $srch->addCondition('fc.faqcat_active', '=', applicationConstants::ACTIVE);
        $srch->addOrder('fc.faqcat_display_order', 'asc');
        $srch->addOrder('fc.faqcat_identifier', 'asc');
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $categories = FatApp::getDb()->fetchAll($rs, 'faqcat_id');
        sort($categories);
        return $categories;
    }

    public static function getFaqPageCategories()
    {
        $srch = static::getSearchObject();
        $srch->addCondition('fc.faqcat_deleted', '=', applicationConstants::NO);
        $srch->addCondition('fc.faqcat_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition('faqcat_type', '=', static::FAQ_PAGE);
        $srch->addOrder('fc.faqcat_display_order', 'ASC');
        $srch->addOrder('fc.faqcat_identifier', 'ASC');
        $srch->addMultipleFields(array('fc.faqcat_id', 'fc.faqcat_identifier'));
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $categories = FatApp::getDb()->fetchAllAssoc($rs, 'faqcat_id');
        return $categories;
    }
    public static function getSellerPageCategories()
    {
        $srch = static::getSearchObject();
        $srch->addCondition('fc.faqcat_deleted', '=', applicationConstants::NO);
        $srch->addCondition('fc.faqcat_active', '=', applicationConstants::ACTIVE);
        $srch->addCondition('faqcat_type', '=', static::SELLER_PAGE);
        $srch->addOrder('fc.faqcat_display_order', 'ASC');
        $srch->addOrder('fc.faqcat_identifier', 'ASC');
        $srch->addMultipleFields(array('fc.faqcat_id', 'fc.faqcat_identifier'));
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $categories = FatApp::getDb()->fetchAllAssoc($rs, 'faqcat_id');

        return $categories;
    }
    public function getMaxOrder()
    {
        $srch = new SearchBase(static::DB_TBL);
        $srch->addFld("MAX(" . static::DB_TBL_PREFIX . "display_order) as max_order");
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $rs = $srch->getResultSet();
        $record = FatApp::getDb()->fetch($rs);
        if (!empty($record)) {
            return $record['max_order'] + 1;
        }
        return 1;
    }
}
