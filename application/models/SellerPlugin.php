<?php

class SellerPlugin
{
    
    protected $error;
    protected $userId;
    
    public function __construct($userId = 0)
    {        
        $this->userId = FatUtility::convertToType($userId, FatUtility::VAR_INT);
    }
    
    public static function getSearchObject(int $langId = 0, bool $innerJoinPluginUser = false, bool $joinSettings = false)
    {
        $srch = Plugin::getSearchObject($langId, false, $joinSettings);

        $joinCondition = (true == $innerJoinPluginUser) ? 'INNER JOIN' : 'LEFT OUTER JOIN';
        $srch->joinTable(
                Plugin::DB_TBL_PLUGIN_TO_USER,
                $joinCondition,
                'plgu.' . Plugin::DB_TBL_PLUGIN_TO_USER_PREFIX . Plugin::DB_TBL_PREFIX . 'id = plg.' . Plugin::DB_TBL_PREFIX . 'id',
                'plgu'
        );
        return $srch;
    }
    
    
    public function getAttributesById(int $pluginId, int $langId = 0) : array
    {
        if(1 > $this->userId){
            trigger_error('User id not specified', E_USER_ERROR);
        }
        
        $srch = static:: getSearchObject($langId, true);
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('ps_user_id', '=', $this->userId);
        $srch->addCondition('ps_plugin_id', '=', $pluginId);
        $rs = $srch->getResultSet();
        return (array) $db->fetch($rs);  
    }

    /**
     * 
     * @param int $typeId
     * @return int
     */
    public static function getDefaultPluginId(int $type ,int $userId): int
    {
        if (!in_array($type, Plugin::HAVING_KINGPIN) || 1 > $userId) {
            return 0;
        }
        
        $srch = static:: getSearchObject(0, true);    
        $srch->addFld('ps_plugin_id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('plugin_type', '=', $type);
        $srch->addCondition('ps_user_id', '=', $userId);
        $srch->addCondition('ps_active', '=', applicationConstants::ACTIVE);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (empty($row)) {
            return 0;
        }
        return $row['ps_plugin_id'];
    }
    
    public function getDefaultPluginData(int $typeId, $attr = null, int $langId = 0)
    {
        if (!in_array($typeId, self::HAVING_KINGPIN)) {
            $this->error = Labels::getLabel('MSG_INVALID_PLUGIN_TYPE', CommonHelper::getLangId());
            return false;
        }
        $kingPin = FatApp::getConfig('CONF_DEFAULT_PLUGIN_' . $typeId, FatUtility::VAR_INT, 0);
        if (1 > $kingPin) {
            $this->error = Labels::getLabel('MSG_PLUGIN_NOT_FOUND', CommonHelper::getLangId());
            return false;
        }

        if (0 < $langId) {
            $customCols = !empty($attr) ? true : false;
            $srch = static::pluginTypeSrchObj($typeId, $langId, $customCols, true);

            if (!empty($attr)) {
                switch ($attr) {
                    case is_string($attr):
                        if ('plugin_name' == $attr) {
                            $attr = 'COALESCE(plg_l.' . static::DB_TBL_PREFIX . 'name, plg.' . static::DB_TBL_PREFIX . 'identifier) as plugin_name';
                        }
                        $srch->addFld($attr);
                        break;

                    default:
                        $srch->addMultipleFields($attr);
                        break;
                }
            }

            $rs = $srch->getResultSet();
            $result = FatApp::getDb()->fetch($rs);
            if (is_string($attr)) {
                return $result[$attr];
            }
            return $result;
        }
        return Plugin::getAttributesById($kingPin, $attr);
    }
    
    
    public function updateStatus(int $typeId, int $status, int $id = null, &$error = ''): bool
    {
        $db = FatApp::getDb();
        $langId = CommonHelper::getLangId();
        $pluginKey = $this->getAttributesById($id, 'plugin_code');
        $pluginTypesArr = Plugin::getTypeArr($langId);
        $plugins = static::getDataByType($typeId, $langId);
        $activationLimit = Plugin::getActivatationLimit($typeId);
        $msg = '';
        if (0 < $activationLimit && $activationLimit <= count($plugins) && self::ACTIVE == $status) {
            $msg = Labels::getLabel("MSG_MAXIMUM_OF_{LIMIT}_{PLUGIN-TYPE}_CAN_BE_ACTIVATED_SIMULTANEOUSLY.", $langId) . $msg;
            $error = CommonHelper::replaceStringData($msg, ['{LIMIT}' => $activationLimit, '{PLUGIN-TYPE}' => $pluginTypesArr[$typeId]]);
            return false;
        }

        $max = in_array($typeId, self::HAVING_KINGPIN) && applicationConstants::ACTIVE == $status ? 2 : 1;

        for ($i = 0; $i < $max; $i++) {
            $condition = ['smt' => self::DB_TBL_PREFIX . 'type = ?', 'vals' => [$typeId]];
            if (null != $id) {
                $operator = (0 < $i ? '!=' : '=');
                $condition = ['smt' => self::DB_TBL_PREFIX . 'type = ? AND ' . self::DB_TBL_PREFIX . 'id ' . $operator . ' ?', 'vals' => [$typeId, $id]];
            }
            if (!$db->updateFromArray(self::DB_TBL, [self::DB_TBL_PREFIX . 'active' => (0 < $i ? self::INACTIVE : $status)], $condition)) {
                $error = $db->getError();
                return false;
            }
        }

        if (in_array($typeId, self::HAVING_KINGPIN)) {
            $kingPin = (self::INACTIVE == $status) ? self::INACTIVE : $id;
            
            $assignValues = [
                'conf_name' => 'CONF_DEFAULT_PLUGIN_' . $typeId,
                'conf_val' => $kingPin
            ];
            if (false === $db->insertFromArray(
                'tbl_configurations',
                $assignValues,
                false,
                array(),
                $assignValues
            )) {
                $error = $db->getError();
                return false;
            }
        }
        return true;
    }
    
    
    public function getDataByType(int $typeId, int $langId = 0, bool $assoc = false, bool $active = true)
    {
        $typeId = FatUtility::int($typeId);
        if (1 > $typeId) {
            return false;
        }

        if (in_array($typeId, self::HAVING_KINGPIN) && empty((new self())->getDefaultPluginKeyName($typeId))) {
            return [];
        }

        $srch = static::pluginTypeSrchObj($typeId, $langId, $assoc, $active);

        if (true == $assoc) {
            $srch->addMultipleFields(
                [
                    'plg.' . static::DB_TBL_PREFIX . 'id',
                    'COALESCE(plg_l.' . static::DB_TBL_PREFIX . 'name, plg.' . static::DB_TBL_PREFIX . 'identifier) as plugin_name'
                ]
            );
        }
        $srch->addOrder('plugin_display_order', 'ASC');
        $rs = $srch->getResultSet();

        $db = FatApp::getDb();
        if (true == $assoc) {
            return $db->fetchAllAssoc($rs);
        }

        return $db->fetchAll($rs, static::DB_TBL_PREFIX . 'id');
    }
    
    
    
    public function getError()
    {
        return $this->error;
    }

}
