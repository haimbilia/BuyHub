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
        self::DB_TBL_PREFIX . 'user_id',
        self::DB_TBL_PREFIX . 'message',
        self::DB_TBL_PREFIX . 'status',
        self::DB_TBL_PREFIX . 'requested_on',
        self::DB_TBL_PREFIX . 'status_updated_on',
    ];
    /**
     * __construct
     *
     * @param  int $badgeRequestId
     * @return void
     */
    public function __construct(int $badgeRequestId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $badgeRequestId);
        $this->objMainTableRecord->setSensitiveFields([self::DB_TBL_PREFIX . 'id']);
    }

    /**
     * getStatusArr
     *
     * @param  int $langId
     * @return array
     */
    public static function getStatusArr(int $langId): array
    {
        $arr = CacheHelper::get('getBadgeRequestStatusArr' . $langId, CONF_DEF_CACHE_TIME, '.txt');
        if (!$arr) {
            $arr = [
                self::REQUEST_PENDING => Labels::getLabel('LBL_PENDING', $langId),
                self::REQUEST_APPROVED => Labels::getLabel('LBL_APPROVED', $langId),
                self::REQUEST_REJECTED => Labels::getLabel('LBL_REJECTED', $langId)
            ];
            CacheHelper::create('getBadgeRequestStatusArr' . $langId, FatUtility::convertToJson($arr), CacheHelper::TYPE_LABELS);
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

    /**
     * getAttributesByConditionId
     *
     * @param  int $condId
     * @param  mixed $attr
     * @return mixed
     */
    public static function getAttributesByConditionId($condId, $attr = null)
    {
        $condId = FatUtility::int($condId);
        $db = FatApp::getDb();

        $srch = new SearchBase(static::DB_TBL);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition(static::tblFld('blinkcond_id'), '=', $condId);

        if (null != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }

        $rs = $srch->getResultSet();
        $row = $db->fetch($rs);

        if (!is_array($row)) {
            return false;
        }

        if (is_string($attr)) {
            return $row[$attr];
        }

        return $row;
    }

    /**
     * getBadgeData
     *
     * @return array
     */
    public function getBadgeData(int $langId): array
    {
        $srch = new SearchBase(self::DB_TBL, 'breq');
        $srch->joinTable(BadgeLinkCondition::DB_TBL, 'INNER JOIN', 'blc.blinkcond_id = breq.breq_blinkcond_id', 'blc');
        $srch->joinTable(Badge::DB_TBL, 'INNER JOIN', 'blc.blinkcond_badge_id =  bdg.badge_id', 'bdg');
        $srch->joinTable(Badge::DB_TBL_LANG, 'LEFT JOIN', 'bdg.badge_id =  bdg_l.badgelang_badge_id AND bdg_l.badgelang_lang_id = ' . $langId, 'bdg_l');
        $srch->addCondition('breq_id', '=', $this->mainTableRecordId);
        $attrs = self::ATTR + BadgeLinkCondition::ATTR + Badge::ATTR;
        $attrs[] = 'COALESCE(badge_name, badge_identifier) as badge_name';
        $srch->addMultipleFields($attrs);
        $srch->doNotCalculateRecords();
        $row = FatApp::getDb()->fetch($srch->getResultSet());
        return (is_array($row) ? $row : []);
    }
}
