<?php

class GiftCards extends MyAppModel
{
    public const DB_TBL = 'tbl_order_gift_cards';
    public const DB_TBL_PREFIX = 'ogcards_';
    private $db;
    const STATUS_UNUSED = 0;
    const STATUS_USED = 1;
    const STATUS_CANCELLED = 2;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }


    public static function getSearchObject()
    {
        $srch = new SearchBase(static::DB_TBL, 'ogc');
        return $srch;
    }

    public static function getGiftCards(int $userId)
    {
        $srch = self::getSearchObject();
        $srch->addCondition('ogcards_sender_id', '=', $userId);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        return FatApp::getDb()->fetchAll($srch->getResultSet(), 'ogcards_id');
    }

    public static function getGiftCardRecords(int $userId, int $pagesize, int $page, string $dateOrder = '')
    {
    }
}
