<?php

class ShopReport extends MyAppModel
{
    public const DB_TBL = 'tbl_shop_reports';
    public const DB_TBL_PREFIX = 'sreport_';

    public function __construct($sreport_id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $sreport_id);
        $this->objMainTableRecord->setSensitiveFields(array());
    }

    public static function getSearchObject($langId = 0)
    {
        $langId = FatUtility::int($langId);
        $srch = new SearchBase(static::DB_TBL, 'sreport');
        return $srch;
    }

    public static function getReportDetail($shopId, $userId = 0, $attr = '')
    {
        $shopId = FatUtility::int($shopId);
        $userId = FatUtility::int($userId);
        if (empty($attr)) {
            $attr = ['sreport_id'];
        } elseif (is_string($attr)) {
            $attr = [$attr];
        }

        $srch = static::getSearchObject();
        $srch->addMultipleFields($attr);
        $srch->addCondition('sreport_shop_id', '=', 'mysql_func_' . $shopId, 'AND', true);
        if (0 < $userId) {
            $srch->addCondition('sreport_user_id', '=', 'mysql_func_' . $userId, 'AND', true);
        }
        $srch->doNotCalculateRecords();
        return FatApp::getDb()->fetch($srch->getResultSet());
    }
}
