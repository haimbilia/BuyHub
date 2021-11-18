<?php

class AdminUsers extends MyAppModel
{
    public const DB_TBL = 'tbl_admin';
    public const DB_TBL_PREFIX = 'admin_';

    public const DB_TBL_PERMISSIONS = 'tbl_admin_permissions';

    public function __construct($adminId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $adminId);
        $this->objMainTableRecord->setSensitiveFields(array());
    }

    public static function getSearchObject($isActive = true)
    {
        $srch = new SearchBase(static::DB_TBL, 'adu');
        if ($isActive == true) {
            $srch->addCondition(static::DB_TBL_PREFIX . 'active', '=', 1);
        }
        return $srch;
    }

    public static function getUserPermissions($admperm_admin_id = 0)
    {
        $srch = new SearchBase(self::DB_TBL_PERMISSIONS);
        $srch->addCondition('admperm_admin_id', '=', $admperm_admin_id);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetchAll($rs, 'admperm_section_id');
        if (!empty($row)) {
            return $row;
        }
        return false;
    }

    public function updatePermissions($assignValues = array(), $updateAll = false)
    {
        if ($updateAll) {
            $permissionModules = AdminPrivilege::getPermissionModulesArr();
            foreach ($permissionModules as $key => $val) {
                $assignValues['admperm_section_id'] = $key;
                if (!FatApp::getDb()->insertFromArray(
                    self::DB_TBL_PERMISSIONS,
                    $assignValues,
                    false,
                    array(),
                    $assignValues
                )) {
                    return false;
                }
            }
        } else {
            if (!FatApp::getDb()->insertFromArray(
                self::DB_TBL_PERMISSIONS,
                $assignValues,
                false,
                array(),
                $assignValues
            )) {
                return false;
            }
        }
        return true;
    }
}
