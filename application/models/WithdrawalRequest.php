<?php

class WithdrawalRequest extends MyAppModel
{
    public const DB_TBL = 'tbl_user_withdrawal_requests';
    public const DB_TBL_PREFIX = 'withdrawal_';

    public function __construct($withdrawalId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $withdrawalId);
        $this->objMainTableRecord->setSensitiveFields(array());
    }

    public static function getSearchObject()
    {
        $srch = new SearchBase(static::DB_TBL, 'withdrawal');
        return $srch;
    }
}