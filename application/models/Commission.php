<?php

class Commission extends MyAppModel
{
    public const DB_TBL = 'tbl_commission_settings';
    public const DB_TBL_PREFIX = 'commsetting_';
    public const DB_TBL_HISTORY = 'tbl_commission_setting_history';
    private $db;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
        $this->objMainTableRecord->setSensitiveFields(
            array(
                'commsetting_is_mandatory'
            )
        );
    }

    public static function getSearchObject()
    {
        $srch = new SearchBase(static::DB_TBL, 'tcs');

        $srch->addOrder('tcs.' . static::DB_TBL_PREFIX . 'is_mandatory', 'DESC');
        return $srch;
    }

    public static function getHistorySearchObject()
    {
        $srch = new SearchBase(static::DB_TBL_HISTORY, 'tcsh');

        $srch->addOrder('tcsh.csh_added_on', 'DESC');
        return $srch;
    }

    public function addUpdateData($data)
    {
        $assignValues = array(
            'commsetting_product_id' => $data['commsetting_product_id'],
            'commsetting_user_id' => $data['commsetting_user_id'],
            'commsetting_prodcat_id' => $data['commsetting_prodcat_id'],
            'commsetting_fees' => $data['commsetting_fees'],
            'commsetting_by_package' => isset($data['commsetting_by_package']) ? $data['commsetting_by_package'] : 0,           
        );

        if ($this->mainTableRecordId > 0) {
            $assignValues['commsetting_id'] = $this->mainTableRecordId;
        }

        if (!$this->db->insertFromArray(static::DB_TBL, $assignValues, false, array(), $assignValues)) {
            $this->error = $this->db->getError();
            return false;
        }
        return true;
    }

    public function addCommissionHistory($commissionId)
    {
        $data = Commission::getAttributesById($commissionId);
        $assignValues = array(
            'csh_commsetting_id' => $data['commsetting_id'],
            'csh_commsetting_product_id' => $data['commsetting_product_id'],
            'csh_commsetting_user_id' => $data['commsetting_user_id'],
            'csh_commsetting_prodcat_id' => $data['commsetting_prodcat_id'],
            'csh_commsetting_fees' => $data['commsetting_fees'],
            'csh_commsetting_is_mandatory' => $data['commsetting_is_mandatory'],          
            'csh_added_on' => date('Y-m-d H:i:s'),
        );
        if ($this->db->insertFromArray(static::DB_TBL_HISTORY, $assignValues)) {
            return true;
        }

        $this->error = $this->db->getError();
        return false;
    }

    public static function getCommissionSettingsObj($langId, $trashed = 0, $attr = [])
    {
        $langId = FatUtility::int($langId);

        $srch = self::getSearchObject();

        $srch->joinTable('tbl_products', 'LEFT OUTER JOIN', 'tcs.commsetting_product_id = tp.product_id', 'tp');
        $srch->joinTable('tbl_products_lang', 'LEFT OUTER JOIN', 'tp_l.productlang_product_id = tp.product_id and tp_l.productlang_lang_id =' . $langId, 'tp_l');

        $srch->joinTable('tbl_product_categories', 'LEFT OUTER JOIN', 'tpc.prodcat_id = tcs.commsetting_prodcat_id', 'tpc');
        $srch->joinTable('tbl_product_categories_lang', 'LEFT OUTER JOIN', 'tpc_l.prodcatlang_prodcat_id = tpc.prodcat_id and tpc_l.prodcatlang_lang_id =' . $langId, 'tpc_l');

        $srch->joinTable('tbl_users', 'LEFT OUTER JOIN', 'tcs.commsetting_user_id = tu.user_id', 'tu');
        $srch->joinTable('tbl_user_credentials', 'LEFT OUTER JOIN', 'tuc.credential_user_id = tu.user_id', 'tuc');

        if (empty($attr)) {
            $attr = array(
                'tcs.*',
                'IFNULL(tp_l.product_name,tp.product_identifier)as product_name',
                'IFNULL(tpc_l.prodcat_name,tpc.prodcat_identifier)as prodcat_name',
                'CONCAT(tu.user_name," [",tuc.credential_username,"]") as vendor'
            );
        }
        $srch->addMultipleFields($attr);

        return $srch;
    }

    public static function getCommissionHistorySettingsObj($langId)
    {
        $langId = FatUtility::int($langId);

        $srch = self::getHistorySearchObject();

        $srch->joinTable('tbl_products', 'LEFT OUTER JOIN', 'tcsh.csh_commsetting_product_id = tp.product_id', 'tp');
        $srch->joinTable('tbl_products_lang', 'LEFT OUTER JOIN', 'tp_l.productlang_product_id = tp.product_id and tp_l.productlang_lang_id =' . $langId, 'tp_l');

        $srch->joinTable('tbl_product_categories', 'LEFT OUTER JOIN', 'tpc.prodcat_id = tcsh.csh_commsetting_prodcat_id', 'tpc');
        $srch->joinTable('tbl_product_categories_lang', 'LEFT OUTER JOIN', 'tpc_l.prodcatlang_prodcat_id = tpc.prodcat_id and tpc_l.prodcatlang_lang_id =' . $langId, 'tpc_l');

        $srch->joinTable('tbl_users', 'LEFT OUTER JOIN', 'tcsh.csh_commsetting_user_id = tu.user_id', 'tu');
        $srch->joinTable('tbl_user_credentials', 'LEFT OUTER JOIN', 'tuc.credential_user_id = tu.user_id', 'tuc');

        $srch->addMultipleFields(
            array(
                'tcsh.*',
                'IFNULL(tp_l.product_name, tp.product_identifier)as product_name',
                'IFNULL(tpc_l.prodcat_name, tpc.prodcat_identifier)as prodcat_name',
                'CONCAT(tu.user_name," (", tuc.credential_username, ")") as vendor',
                'user_id as vendor_id',
                'user_updated_on as vendor_updated_on',
            )
        );

        return $srch;
    }

    public static function getComissionSettingIdByUser($userId = 0)
    {
        $srch = self::getSearchObject();
        $srch->addCondition('commsetting_user_id', '=', $userId);
        $srch->addCondition('commsetting_product_id', '=', 0);
        $srch->addCondition('commsetting_prodcat_id', '=', 0);
        $srch->addFld('commsetting_id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        if (!$row = FatApp::getDb()->fetch($rs)) {
            return false;
        }

        return $row['commsetting_id'];
    }
}
