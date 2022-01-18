<?php

class Tooltip extends MyAppModel
{
    public const DB_TBL = 'tbl_tool_tips';
    public const DB_TBL_PREFIX = 'abusive_';
    public const DB_TBL_LANG = 'tbl_tool_tips_lang';

    public function __construct($abusiveId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $abusiveId);
    }

    public static function getSearchObject()
    {
        return new SearchBase(static::DB_TBL, 'aw');
    }
}
