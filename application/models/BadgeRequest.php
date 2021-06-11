<?php

class BadgeRequest extends MyAppModel
{
    public const DB_TBL = 'tbl_badge_requests';
    public const DB_TBL_PREFIX = 'breq_';

    public const REQUEST_PENDING = 0;
    public const REQUEST_APPROVED = 1;
    public const REQUEST_CANCELLED = 2;

    public const ATTR = [
        self::DB_TBL_PREFIX . 'id',
        self::DB_TBL_PREFIX . 'badge_id', 
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
     * getSearchObject
     *
     * @param  int $langId
     * @param  array $attr
     * @return object
     */
    public static function getSearchObject(int $langId, array $attr = []): object
    {
        $srch = new SearchBase(self::DB_TBL, 'breq');
        $srch->joinTable(Badge::DB_TBL, 'INNER JOIN', 'badge_id = breq_badge_id', 'bdg');
        $srch->joinTable(Badge::DB_TBL_LANG, 'LEFT JOIN', 'badgelang_badge_id = badge_id AND badgelang_lang_id = ' . $langId, 'bdg_l');

        if (empty($attr)) {
            $srch->addMultipleFields(array_merge(
                self::ATTR,
                ['COALESCE(badge_name, badge_identifier) as badge_name']
            ));
        }

        return $srch;
    }
    
    /**
     * getStatusArr
     *
     * @param  int $langId
     * @return void
     */
    public static function getStatusArr(int $langId)
    {
        return [
            self::REQUEST_PENDING => Labels::getLabel('LBL_PENDING', $langId),
            self::REQUEST_APPROVED => Labels::getLabel('LBL_APPROVED', $langId),
            self::REQUEST_CANCELLED => Labels::getLabel('LBL_CANCELLED', $langId)
        ];
    }
}
