<?php

class EmptyCartItems extends MyAppModel
{
    public const DB_TBL = 'tbl_empty_cart_items';
    public const DB_TBL_LANG = 'tbl_empty_cart_items_lang';
    public const DB_TBL_PREFIX = 'emptycartitem_';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getSearchObject($langId = 0, $isActive = true, $setOrderBy = true)
    {
        $srch = new SearchBase(static::DB_TBL, 'eci');

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'emptycartitemlang_emptycartitem_id = emptycartitem_id
			AND emptycartitemlang_lang_id = ' . $langId,
                'eci_l'
            );
        }

        if ($isActive) {
            $srch->addCondition('emptycartitem_active', '=', 'mysql_func_' . applicationConstants::ACTIVE, 'AND', true);
        }

        if (true === $setOrderBy) {
            $srch->addOrder(static::DB_TBL_PREFIX . 'active', 'DESC');
            $srch->addOrder(static::DB_TBL_PREFIX . 'display_order');
        }
        return $srch;
    }

    public function canRecordMarkDelete($id)
    {
        $id = FatUtility::int($id);
        $srch = static::getSearchObject(0, false);
        $srch->addCondition(static::DB_TBL_PREFIX . 'id', '=', 'mysql_func_' . $id, 'AND', true);
        $srch->addFld(static::DB_TBL_PREFIX . 'id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!empty($row) && $row[static::DB_TBL_PREFIX . 'id'] == $id) {
            return true;
        }
        return false;
    }
}
