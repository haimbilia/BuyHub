<?php

class SentEmail extends MyAppModel
{
    public const DB_TBL = 'tbl_email_archives';
    public const DB_TBL_PREFIX = 'earch_';
    
    public function __construct($adminId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $adminId);
        $this->objMainTableRecord->setSensitiveFields(array(''));
    }
    
    public function getSearchObject()
    {
        $srch = new SearchBase(static::DB_TBL, 'm');
        $srch->addOrder('m.earch_sent_on', 'DESC');
        return $srch;
    }
}
