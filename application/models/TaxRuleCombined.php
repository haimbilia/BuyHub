<?php
class TaxRuleCombined extends MyAppModel
{
    const DB_TBL = 'tbl_tax_rule_details';
    const DB_TBL_PREFIX = 'taxruledet_';

    public function __construct(int $id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }

    /**
    * getSearchObject
    *
    * @param  int $langId
    * @return object
    */
    public static function getSearchObject(): object
    {
        $srch = new SearchBase(static::DB_TBL, 'taxCom');
        return $srch;
    }
    /**
     * 
     * @param int $taxRuleId
     * @return bool
     */
    public function deletecombinedTaxes(int $taxRuleId): bool
    {
        if(!FatApp::getDb()->deleteRecords(
            self::DB_TBL,
            array(
                'smt'=> self::DB_TBL_PREFIX .'taxrule_id=? ',
                'vals'=>array($taxRuleId)
            )
        )) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }
}
