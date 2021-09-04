<?php

class CouponHistory extends MyAppModel
{
    public const DB_TBL = 'tbl_coupons_history';
    public const DB_TBL_PREFIX = 'couponhistory_';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getSearchObject()
    {
        return new SearchBase(static::DB_TBL, 'ch');
    }
}
