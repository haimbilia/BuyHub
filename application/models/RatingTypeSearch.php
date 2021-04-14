<?php

class RatingTypeSearch extends SearchBase
{
    private $langId;
    
    /**
     * __construct
     *
     * @param  int $langId
     * @param  int $isActive
     * @param  int $isDefault
     * @return void
     */
    public function __construct(int $langId = 0, int $isActive = -1, int $isDefault = -1)
    {
        $this->langId = FatUtility::int($langId);
        parent::__construct(RatingType::DB_TBL, 'rt');

        if ($langId > 0) {
            $this->joinTable(
                RatingType::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'rt_l.ratingtypelang_ratingtype_id = rt.ratingtype_id AND rt_l.ratingtypelang_lang_id = ' . $langId,
                'rt_l'
            );
        }

        if (-1 < $isActive) {
            $this->addCondition(RatingType::DB_TBL_PREFIX . 'active', '=',  $isActive);
        }

        if (-1 < $isDefault) {
            $this->addCondition(RatingType::DB_TBL_PREFIX . 'default', '=',  $isDefault);
        }
    }
}
