<?php

class ProdSpecification extends MyAppModel
{
    public const DB_TBL = 'tbl_product_specifications';
    public const DB_TBL_PREFIX = 'prodspec_';

    public const DB_TBL_LANG = 'tbl_product_specifications_lang';
    public const DB_TBL_LANG_PREFIX = 'prodspeclang_';

    private $db;

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->db = FatApp::getDb();
    }
    public static function getSearchObject($langId = 0, $bothLanguageData = true)
    {
        $srch = new SearchBase(static::DB_TBL, 'ps');
        $langQuery = '';
        if ($langId || $bothLanguageData) {
            if (!$bothLanguageData) {
                $langQuery = 'AND psl.prodspeclang_lang_id = ' . $langId;
            }
            $srch->joinTable(
                static::DB_TBL . '_lang',
                'LEFT OUTER JOIN',
                'psl.prodspeclang_prodspec_id = ps.prodspec_id ' . $langQuery,
                'psl'
            );
        }

        return $srch;
    }

    public static function requiredFields()
    {
        return array(
            ImportexportCommon::VALIDATE_POSITIVE_INT => array(
                'product_id',
                'prodspeclang_lang_id',
            ),
            ImportexportCommon::VALIDATE_NOT_NULL => array(
                'product_identifier',
                'prodspeclang_lang_code',
                'prodspec_name',
                'prodspec_value',
            ),
        );
    }

    public static function validateFields($columnIndex, $columnTitle, $columnValue, $langId)
    {
        $requiredFields = static::requiredFields();
        return ImportexportCommon::validateFields($requiredFields, $columnIndex, $columnTitle, $columnValue, $langId);
    }

    public static function getProdSpecification($prodSpecId, $productId, $langId = 0, $values = true)
    {
        $srch = static::getSearchObject($langId, $values);
        if ($prodSpecId) {
            $srch->addCondition('ps.prodspec_id', '=', $prodSpecId);
        }
        if ($productId) {
            $srch->addCondition('ps.prodspec_product_id', '=', $productId);
        }
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $db = FatApp::getDb();
        return $db->fetchAll($rs);
    }

    public function deleteRecords(int $langId): bool
    {
        if (1 > $this->getMainTableRecordId()) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST_ID');
            return false;
        }
        $langSrch = new SearchBase(Product::DB_PRODUCT_LANG_SPECIFICATION);
        $langSrch->addCondition('prodspeclang_prodspec_id', '=', $this->getMainTableRecordId());
        $langSrch->addCondition('prodspeclang_lang_id', '!=', $langId);
        $langSrch->doNotCalculateRecords();
        $langSrch->addMultipleFields(['count(1) as record']);
        $langRs = $langSrch->getResultSet();
        $row = FatApp::getDb()->fetch($langRs);
        if (false == $row || $row['record'] == 0) {
            $this->db->deleteRecords(Product::DB_PRODUCT_SPECIFICATION, array('smt' => 'prodspec_id = ? ', 'vals' => [$this->getMainTableRecordId()]));
            $this->db->deleteRecords(Product::DB_PRODUCT_LANG_SPECIFICATION, array('smt' => 'prodspeclang_prodspec_id = ?', 'vals' => [$this->getMainTableRecordId()]));
        } else {
            $this->db->deleteRecords(Product::DB_PRODUCT_LANG_SPECIFICATION, array('smt' => 'prodspeclang_prodspec_id = ? and prodspeclang_lang_id = ?', 'vals' => [$this->getMainTableRecordId(), $langId]));
        }
        return true;
    }
}
