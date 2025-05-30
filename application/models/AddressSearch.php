<?php
class AddressSearch extends SearchBase
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
        parent::__construct(Address::DB_TBL, 'addr');
    }
    
    /**
     * getLangId
     *
     * @param  int $langId
     * @return int
     */
    private function getLangId(int $langId): int
    {
        if (0 < $langId) {
            return $langId;
        }
        return $this->langId;
    }
    
    /**
     * joinCountry
     *
     * @param  int $langId
     * @return void
     */
    public function joinCountry(int $langId = 0)
    {
        $langId = $this->getLangId($langId);

        $this->joinTable(Countries::DB_TBL, 'LEFT JOIN', 'c.country_id = addr.addr_country_id', 'c');

        if (0 < $langId) {
            $this->joinTable(Countries::DB_TBL_LANG, 'LEFT JOIN', 'c.country_id = c_l.countrylang_country_id AND countrylang_lang_id = ' . $langId, 'c_l');
        }
    }
    
    /**
     * joinState
     *
     * @param  int $langId
     * @return void
     */
    public function joinState(int $langId = 0)
    {
        $langId = $this->getLangId($langId);

        $this->joinTable(States::DB_TBL, 'LEFT JOIN', 's.state_id = addr.addr_state_id', 's');

        if (0 < $langId) {
            $this->joinTable(States::DB_TBL_LANG, 'LEFT JOIN', 's.state_id = s_l.statelang_state_id AND s_l.statelang_lang_id = ' . $langId, 's_l');
        }
    }

    public function joinUser()
    {
        $this->joinTable(User::DB_TBL, 'LEFT JOIN', 'addr.addr_record_id = u.user_id AND addr_type = ' . Address::TYPE_USER, 'u');
        $this->joinTable(User::DB_TBL_CRED, 'LEFT JOIN', 'u.user_id = uc.credential_user_id', 'uc');
    }
    
}
