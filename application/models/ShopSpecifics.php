<?php

class ShopSpecifics extends MyAppModel
{
    public const DB_TBL = 'tbl_shop_specifics';
    public const DB_TBL_PREFIX = 'ss_';
    public const DB_TBL_FOREIGN_PREFIX = 'shop_';

    public function __construct($shopId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'shop_id', $shopId);
        $this->objMainTableRecord->setSensitiveFields(array());
    }

    public static function getSearchObject()
    {
        return new SearchBase(static::DB_TBL, 'ss');
    }
}
