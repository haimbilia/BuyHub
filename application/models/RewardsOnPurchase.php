<?php

class RewardsOnPurchase extends MyAppModel
{
    public const DB_TBL = 'tbl_rewards_on_purchase';
    public const DB_TBL_PREFIX = 'rop_';
    private $db;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }

    public static function getSearchObject()
    {
        return new SearchBase(static::DB_TBL, 'rop');
    }
}
