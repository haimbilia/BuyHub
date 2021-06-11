<?php

class BadgeRequest extends MyAppModel
{
    public const DB_TBL = 'tbl_badge_requests';
    public const DB_TBL_PREFIX = 'breq_';

    /**
     * __construct
     *
     * @param  int $ratingTypeId
     * @return void
     */
    public function __construct(int $ratingTypeId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $ratingTypeId);
        $this->objMainTableRecord->setSensitiveFields([self::DB_TBL_PREFIX . 'id']);
    }
}
