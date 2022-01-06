<?php

class Filter extends MyAppModel
{
    public const DB_TBL = 'tbl_filters';
    public const DB_TBL_PREFIX = 'filter_';    

    public function __construct($id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);       
    }

    public function getSearchObject($isDeleted = true)
    {
        $srch = new SearchBase(static::DB_TBL, 'f');
        if ($isDeleted == true) {
            $srch->addCondition('f.' . static::DB_TBL_PREFIX . 'deleted', '=', 'mysql_func_' . applicationConstants::NO, 'AND', true);
        }
        return $srch;
    }

    public function getAttributesByIdAndGroupId($groupId, $recordId, $attr = null)
    {
        $groupId = FatUtility::convertToType($groupId, FatUtility::VAR_INT);
        $recordId = FatUtility::convertToType($recordId, FatUtility::VAR_INT);

        $srch = $this->getSearchObject();
        $srch->addCondition('f.' . static::tblFld('id'), '=', 'mysql_func_' . $recordId, 'AND', true);
        $srch->addCondition('f.' . static::tblFld('filtergroup_id'), '=', 'mysql_func_' . $groupId, 'AND', true);
        if (null != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }

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

    public function canRecordMarkDelete($id)
    {
        $id = FatUtility::int($id);
        $srch = $this->getSearchObject();
        $srch->addCondition('f.' . static::DB_TBL_PREFIX . 'id', '=', 'mysql_func_' . $id, 'AND', true);
        $srch->addFld('f.' . static::DB_TBL_PREFIX . 'id');
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!empty($row) && $row[static::DB_TBL_PREFIX . 'id'] == $id) {
            return true;
        }
        return false;
    }
}
