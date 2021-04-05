<?php

class RatingTypeSearch extends SearchBase
{
    private $langId;
    
    /**
     * __construct
     *
     * @param  int $langId
     * @return void
     */
    public function __construct(int $langId = 0)
    {
        $this->langId = FatUtility::int($langId);
        parent::__construct(RatingType::DB_TBL, 'rt');

        if ($langId > 0) {
            $this->joinTable(
                RatingType::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'rt_l.rtlang_rt_id = rt.rt_id AND rt_l.rtlang_lang_id = ' . $langId,
                'rt_l'
            );
        }
    }
}
