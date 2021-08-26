<?php

class BadgeRequest extends MyAppModel
{
    public const DB_TBL = 'tbl_badge_requests';
    public const DB_TBL_PREFIX = 'breq_';

    public const REQUEST_PENDING = 0;
    public const REQUEST_APPROVED = 1;
    public const REQUEST_REJECTED = 2;

    public const ATTR = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'blinkcond_id', 
        self::DB_TBL_PREFIX . 'record_type', 
        self::DB_TBL_PREFIX . 'message',
        self::DB_TBL_PREFIX . 'status',
        self::DB_TBL_PREFIX . 'requested_on',
        self::DB_TBL_PREFIX . 'status_updated_on',
    ];
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
    
    /**
     * getStatusArr
     *
     * @param  int $langId
     * @return void
     */
    public static function getStatusArr(int $langId): array
    {
        $arr = FatCache::get('getBadgeRequestStatusArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::REQUEST_PENDING => Labels::getLabel('LBL_PENDING', $langId),
                self::REQUEST_APPROVED => Labels::getLabel('LBL_APPROVED', $langId),
                self::REQUEST_REJECTED => Labels::getLabel('LBL_REJECTED', $langId)
            ];
            FatCache::set('getBadgeRequestStatusArr' . $langId, FatUtility::convertToJson($arr), '.txt');
            return $arr;
        }
    
        return json_decode($arr, true);
    }

    /**
     * getRequestStatus
     *
     * @param  int $blinkCondId
     * @param  int $sellerId
     * @return int
     */
    public static function getRequestStatus(int $blinkCondId, int $sellerId): int
    {
        $srch = new SearchBase(self::DB_TBL, 'breq');
        $srch->addCondition(self::DB_TBL_PREFIX . 'blinkcond_id', '=', $blinkCondId);
        $srch->addCondition(self::DB_TBL_PREFIX . 'user_id', '=', $sellerId);
        $srch->addCondition(self::DB_TBL_PREFIX . 'status', 'IN', [self::REQUEST_PENDING, self::REQUEST_APPROVED]);
        $srch->addFld(self::DB_TBL_PREFIX . 'status');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $row = (array) FatApp::getDb()->fetch($srch->getResultSet());
        return (int) (empty($row) ? -1 : $row[self::DB_TBL_PREFIX . 'status']);
    }
}
