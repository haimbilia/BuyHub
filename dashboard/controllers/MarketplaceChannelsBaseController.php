<?php

class MarketplaceChannelsBaseController extends SellerPluginBaseController
{
    public $userId = 0;
    
    /**
     * __construct
     *
     * @param  mixed $action
     * @return void
     */
    public function __construct(string $action)
    {
        parent::__construct($action);

        $class = get_called_class();
        if (!defined($class . '::KEY_NAME')) {
            $msg = Labels::getLabel('MSG_INVALID_PLUGIN', $this->siteLangId);
            return $this->formatOutput(Plugin::RETURN_FALSE, $msg);
        }
        $this->keyName = $class::KEY_NAME;
        if (false === Plugin::isActive($this->keyName)) {
            $msg = Labels::getLabel('MSG_MARKETPLACE_CHANNEL_ACCESS_RESTRICTED', $this->siteLangId);
            return $this->formatOutput(Plugin::RETURN_FALSE, $msg);
        }
    }
    
    /**
     * getLoggedUserInfo
     *
     * @param int $userId
     * @return array
     */
    public function getLoggedUserInfo(): array
    {
        $srch = User::getSearchObject();
        $srch->joinTable(Shop::DB_TBL, 'LEFT OUTER JOIN', 'u.user_id = sh.shop_user_id', 'sh');
        $srch->joinTable(Shop::DB_TBL_LANG, 'LEFT OUTER JOIN', 'sh.shop_id = sh_l.shoplang_shop_id AND shoplang_lang_id = ' . $this->siteLangId, 'sh_l');
        $srch->joinTable(Countries::DB_TBL, 'LEFT OUTER JOIN', 'sh.shop_country_id = c.country_id', 'c');
        $srch->joinTable(Countries::DB_TBL_LANG, 'LEFT OUTER JOIN', 'c.country_id = c_l.countrylang_country_id AND countrylang_lang_id = ' . $this->siteLangId, 'c_l');
        $srch->joinTable(States::DB_TBL, 'LEFT OUTER JOIN', 'sh.shop_state_id = s.state_id', 's');
        $srch->joinTable(States::DB_TBL_LANG, 'LEFT OUTER JOIN', 's.state_id = s_l.statelang_state_id AND statelang_lang_id = ' . $this->siteLangId, 's_l');
        $srch->joinTable(User::DB_TBL_CRED, 'LEFT OUTER JOIN', 'uc.' . User::DB_TBL_CRED_PREFIX . 'user_id = u.user_id', 'uc');
        $srch->joinTable(User::DB_TBL_USR_BANK_INFO, 'LEFT OUTER JOIN', 'ub.ub_user_id = u.user_id', 'ub');
        $srch->addMultipleFields([
            'user_id',
            'user_name',
            'shop_phone',
            'shop_id',
            'credential_email',
            'credential_username',
            'shop_postalcode',
            'IFNULL(country_name, country_code) as country_name',
            'IFNULL(state_name, state_identifier) as state_name',
            'IFNULL(shop_name, shop_identifier) as shop_name',
            'shop_description',
            'user_dob',
            'shop_city',
            'country_code',
            'state_code',
            'ub.*'
        ]);
        $srch->addCondition('user_id', '=', $this->getUserId());
        $rs = $srch->getResultSet();
        return FatApp::getDb()->fetch($rs);
    }

    /**
     * getUserId
     *
     * @return int
     */
    protected function getUserId(): int
    {
        return (0 < $this->userId ? $this->userId : UserAuthentication::getLoggedUserId());
    }
}
