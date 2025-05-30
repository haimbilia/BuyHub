<?php

class RecommendationActivityBrowsing extends MyAppModel
{
    public const DB_TBL = 'tbl_recommendation_activity_browsing';
    public const DB_TBL_PREFIX = 'rab_';

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'key', $id);
    }

    public static function getSearchObject()
    {
        return new SearchBase(static::DB_TBL, 'rab');
    }
}
