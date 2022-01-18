<?php

class HelpCenterSearch extends SearchBase
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
        $this->langId = $langId;
        
        parent::__construct(HelpCenter::DB_TBL, 'hc');

        if ($this->langId > 0) {
            $this->joinTable(
                HelpCenter::DB_TBL_LANG,
                'LEFT JOIN',
                'hc_l.hclang_hc_id = hc.hc_id AND hc_l.hclang_lang_id = ' . $this->langId,
                'hc_l'
            );
        }
    }
}
