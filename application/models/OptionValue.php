<?php

class OptionValue extends MyAppModel
{
    public const DB_TBL = 'tbl_option_values';
    public const DB_TBL_LANG = 'tbl_option_values_lang';
    public const DB_TBL_PREFIX = 'optionvalue_';
    public const DB_TBL_LANG_PREFIX = 'optionvaluelang_';
    
    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
    }

    public static function getSearchObject($langId = 0, $addOrderBy = true)
    {
        $srch = new SearchBase(static::DB_TBL, 'ov');

        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'ov_l.' . static::DB_TBL_LANG_PREFIX . 'optionvalue_id = ov.' . static::tblFld('id') . ' and
			ov_l.' . static::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId,
                'ov_l'
            );
        }

        if (true === $addOrderBy) {
            $srch->addOrder('ov.' . static::DB_TBL_PREFIX . 'display_order', 'ASC');
        }
        return $srch;
    }

    public function getOptionValue($optionId)
    {
        $optionId = FatUtility::convertToType($optionId, FatUtility::VAR_INT);

        $srch = static::getSearchObject();
        $srch->addCondition('ov.' . static::tblFld('option_id'), '=', $optionId);
        $srch->addCondition('ov.' . static::tblFld('id'), '=', $this->mainTableRecordId);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $record = FatApp::getDb()->fetch($rs);

        if (!empty($record)) {
            $lang_record = CommonHelper::getLangFields(
                $record['optionvalue_id'],
                'optionvaluelang_optionvalue_id',
                'optionvaluelang_lang_id',
                array('optionvalue_name'),
                static::DB_TBL . '_lang'
            );
            return  array_merge($record, $lang_record);
        }

        return $record;
    }

    public function getAttributesByIdAndOptionId($optionId, $recordId, $attr = null)
    {
        $optionId = FatUtility::convertToType($optionId, FatUtility::VAR_INT);
        $recordId = FatUtility::convertToType($recordId, FatUtility::VAR_INT);

        $srch = static::getSearchObject();
        $srch->addCondition('ov.' . static::tblFld('id'), '=', $recordId);
        $srch->addCondition('ov.' . static::tblFld('option_id'), '=', $optionId);
        if (null != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return false;
        }

        if (is_string($attr)) {
            return $row[$attr];
        }
        return $row;
    }

    public function getAttributesByIdentifierAndOptionId($optionId, $recordId, $attr = null)
    {
        $optionId = FatUtility::convertToType($optionId, FatUtility::VAR_INT);

        $srch = static::getSearchObject();
        $srch->addCondition('ov.' . static::tblFld('identifier'), '=', $recordId);
        $srch->addCondition('ov.' . static::tblFld('option_id'), '=', $optionId);
        if (null != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);

        if (!is_array($row)) {
            return false;
        }

        if (is_string($attr)) {
            return $row[$attr];
        }
        return $row;
    }

    public function getAttributesByOptionId($optionId, $attr = null)
    {
        $optionId = FatUtility::convertToType($optionId, FatUtility::VAR_INT);

        $srch = static::getSearchObject();
        $srch->addCondition('ov.' . static::tblFld('option_id'), '=', $optionId);
        if (null != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetchAll($rs);

        if (!is_array($row)) {
            return false;
        }

        return $row;
    }

    public function canEditRecord($optionId)
    {
        $optionId = FatUtility::int($optionId);
        $srch = static::getSearchObject();
        $srch->addCondition('ov.' . static::DB_TBL_PREFIX . 'id', '=', $this->mainTableRecordId);
        $srch->addCondition('ov.' . static::DB_TBL_PREFIX . 'option_id', '=', $optionId);
        $srch->addFld('ov.' . static::DB_TBL_PREFIX . 'id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!empty($row) && $row[static::DB_TBL_PREFIX . 'id'] == $this->mainTableRecordId) {
            return true;
        }
        return false;
    }

    public function isLinkedWithInventory()
    {
        $srch = SellerProduct::getSearchObject();
        $srch->joinTable(SellerProduct::DB_TBL_SELLER_PROD_OPTIONS, 'INNER JOIN', SellerProduct::DB_TBL_PREFIX . 'id = ' . SellerProduct::DB_TBL_SELLER_PROD_OPTIONS_PREFIX . 'selprod_id');
        $srch->joinTable(static::DB_TBL, 'INNER JOIN', static::DB_TBL_PREFIX . 'id = ' . SellerProduct::DB_TBL_SELLER_PROD_OPTIONS_PREFIX . 'optionvalue_id');
        $srch->addCondition(static::DB_TBL_PREFIX . 'id', '=', $this->mainTableRecordId);
        $srch->addFld('selprod_id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        return (bool) FatApp::getDb()->fetch($srch->getResultSet());
    }
}
