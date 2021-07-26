<?php

class SellerPlugin extends PluginCommon
{
    protected $userId;

    public function __construct(int $id = 0, $userId = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->userId = $userId;

        $this->objMainTableRecord->setSensitiveFields(
            array('plugin_code')
        );
    }
    
    public static function getAllowedTypeArr($langId)
    {
        $pluginsType = [         
            self::TYPE_SHIPPING_SERVICES => Labels::getLabel('LBL_SHIPPING_SERVICES', $langId),
            self::TYPE_DATA_MIGRATION => Labels::getLabel('LBL_DATA_MIGRATION', $langId),
        ];

        if (0 < FatApp::getConfig('CONF_SHIPPED_BY_ADMIN_ONLY', FatUtility::VAR_INT, 0)) {
            unset($pluginsType[self::TYPE_SHIPPING_SERVICES]);
        }
        return $pluginsType;
    }

    public static function getSearchObject(int $userId, int $langId = 0, bool $isActive = true, bool $innerJoinPluginUser = true, bool $joinSettings = false): object
    {
        if (1 > $userId) {
            trigger_error('User id not specified', E_USER_ERROR);
        }

        $srch = Plugin::getSearchObject($langId, false, false);

        $joinCondition = (true == $innerJoinPluginUser) ? 'INNER JOIN' : 'LEFT OUTER JOIN';
        $srch->joinTable(
            Plugin::DB_TBL_PLUGIN_TO_USER,
            $joinCondition,
            'plgu.' . Plugin::DB_TBL_PLUGIN_TO_USER_PREFIX . Plugin::DB_TBL_PREFIX . 'id = plg.' . Plugin::DB_TBL_PREFIX . 'id and plgu.' . Plugin::DB_TBL_PLUGIN_TO_USER_PREFIX . 'user_id = ' . $userId,
            'plgu'
        );

        if ($isActive == true) {
            $srch->addCondition('plgu.' . Plugin::DB_TBL_PLUGIN_TO_USER_PREFIX . 'active', '=', applicationConstants::ACTIVE);
        }

        if (true === $joinSettings) {
            $srch->joinTable(
                PluginSetting::DB_TBL,
                'LEFT OUTER JOIN',
                'plgs.' . PluginSetting::DB_TBL_PREFIX . static::DB_TBL_PREFIX . 'id = plg.' . static::DB_TBL_PREFIX . 'id and ' . PluginSetting::DB_TBL_PREFIX . 'record_id =' . $userId,
                'plgs'
            );
        }

        return $srch;
    }

    private static function pluginTypeSrchObj(int $userId, int $typeId, int $langId, bool $customCols = true, bool $active = false): object
    {
        $srch = static::getSearchObject($userId, $langId, $active);
        if (false === $customCols && 0 < $langId) {
            $srch->addMultipleFields(self::ATTRS);
        }

        $srch->addCondition('plg.' . static::DB_TBL_PREFIX . 'type', '=', $typeId);
        return $srch;
    }

    public function getDataByType(int $typeId, int $langId = 0, bool $assoc = false, bool $active = true)
    {
        if (1 > $typeId) {
            $this->error = Labels::getLabel('MSG_INVALID_REQUEST', $langId);
            return false;
        }

        $srch = static::pluginTypeSrchObj($this->userId, $typeId, $langId, $assoc, $active);

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

    public static function getAttributesByCode(int $userId, string $code, $attr = '', int $langId = 0, bool $innerJoinPluginUser = true)
    {
        $srch = self::getSearchObject($userId, $langId, false, $innerJoinPluginUser);
        $srch->addCondition('plg.' . static::DB_TBL_PREFIX . 'code', '=', $code);

        if ('' != $attr) {
            if (is_array($attr)) {
                $srch->addMultipleFields($attr);
            } elseif (is_string($attr)) {
                $srch->addFld($attr);
            }
        }

        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (empty($row) || !is_array($row)) {
            return false;
        }

        if (!empty($attr) && is_string($attr)) {
            return $row[$attr];
        }
        return $row;
    }

    public function getDefaultPluginKeyName(int $typeId)
    {
        return $this->getDefaultPluginData($typeId, 'plugin_code');
    }

    public function getDefaultPluginData(int $typeId, $attr = null, int $langId = 0)
    {
        if (!in_array($typeId, self::getKingpinTypeArr())) {
            $this->error = Labels::getLabel('MSG_INVALID_PLUGIN_TYPE', CommonHelper::getLangId());
            return false;
        }
        
        $customCols = !empty($attr) ? true : false;
        $srch = static::pluginTypeSrchObj($this->userId, $typeId, $langId, $customCols, true);

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
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $rs = $srch->getResultSet();
        $result = FatApp::getDb()->fetch($rs);
        if (empty($result)) {
            return false;
        }
        if (is_string($attr)) {
            return $result[$attr];
        }
        return $result;
    }

    public static function getDefaultPluginId(int $userId, int $type): int
    {
        if (!in_array($type, Plugin::getKingpinTypeArr()) || 1 > $userId) {
            return 0;
        }
        $srch = static::getSearchObject($userId);
        $srch->addFld('pu_plugin_id');
        $srch->doNotCalculateRecords();
        $srch->setPageSize(1);
        $srch->addCondition('plugin_type', '=', $type);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (empty($row)) {
            return 0;
        }
        return $row['pu_plugin_id'];
    }

    public function updateStatus(int $status): bool
    {
        $langId = CommonHelper::getLangId();
        if (1 > $this->userId || 1 > $this->mainTableRecordId) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST_ID', $langId);
            return false;
        }

        $db = FatApp::getDb();
        $pluginData = Plugin::getAttributesById($this->mainTableRecordId);
        if (empty($pluginData)) {
            $this->error = Labels::getLabel('MSG_INVALID_REQUEST', $langId);
            return false;
        }

        $pluginKey = $pluginData['plugin_code'];
        $typeId = $pluginData['plugin_type'];
        $pluginTypesArr = static::getTypeArr($langId);
        $plugins = $this->getDataByType($typeId, $langId);
        $activationLimit = static::getActivatationLimit($typeId);


        $payLater = self::PAY_LATER;

        $msg = '';
        if (self::TYPE_REGULAR_PAYMENT_METHOD == $typeId) {
            $msg = ' ' . Labels::getLabel('MSG_EXCEPT_PAY_LATER_PLUGINS.', $langId);
            $plugins = !$plugins ? [] : $plugins;
            $activatedPayLaterPlugins = 0;
            array_walk($plugins, function ($plugin) use (&$activationLimit, $pluginKey, $payLater, &$activatedPayLaterPlugins) {
                if (in_array($plugin['plugin_code'], $payLater)) {
                    $activatedPayLaterPlugins++;
                }

                if (in_array($pluginKey, $payLater) && in_array($plugin['plugin_code'], $payLater)) {
                    $activationLimit++;
                    return;
                }
            });

            if (!in_array($pluginKey, $payLater) && $activationLimit == count($plugins) && $activatedPayLaterPlugins == count($payLater)) {
                $activationLimit++;
            }
        }


        if (0 < $activationLimit && $activationLimit <= count($plugins) && self::ACTIVE == $status) {
            $msg = Labels::getLabel("MSG_MAXIMUM_OF_{LIMIT}_{PLUGIN-TYPE}_CAN_BE_ACTIVATED_SIMULTANEOUSLY.", $langId) . $msg;
            $this->error = CommonHelper::replaceStringData($msg, ['{LIMIT}' => $activationLimit, '{PLUGIN-TYPE}' => $pluginTypesArr[$typeId]]);
            return false;
        }

        if ($status == applicationConstants::YES) {
            $dataToSave = array(
                'pu_plugin_id' => $this->mainTableRecordId,
                'pu_user_id' => $this->userId,
                'pu_active' => $status,
                'pu_created_at' => date("Y-m-d H:i:s"),
            );
            if (!FatApp::getDb()->insertFromArray(self::DB_TBL_PLUGIN_TO_USER, $dataToSave, false, array(), $dataToSave)) {
                $this->error = $db->getError();
                return false;
            }
        } else {
            if (!$db->deleteRecords(self::DB_TBL_PLUGIN_TO_USER, array('smt' => 'pu_plugin_id = ? AND pu_user_id = ?', 'vals' => array($this->mainTableRecordId, $this->userId)))) {
                $this->error = $db->getError();
                return false;
            }
        }

        if ($status == applicationConstants::YES && in_array($typeId, self::getKingpinTypeArr())) {
            $deleteQuery = "delete pu FROM tbl_plugin_to_user as pu inner join tbl_plugins on pu_plugin_id = plugin_id and pu_user_id =" . $this->userId . " where plugin_type = " . $typeId . " and pu_plugin_id !=" . $this->mainTableRecordId;
            FatApp::getDb()->query($deleteQuery);
        }

        return true;
    }

    public static function updateStatusByType(int $userId, int $typeId, int $status, string &$error = ''): bool
    {
        if (0 < $status && in_array($typeId, static::getKingpinTypeArr())) {
            $error = Labels::getLabel('MSG_KING_PIN_TYPE_PLUGINS_ARE_NOT_ALLOWED_TO_ACTIVATE_BY_TYPE', CommonHelper::getLangId());
            return false;
        }

        $db = FatApp::getDb();
        if (1 > $status) {
            if (!$db->query("DELETE pu 
                            FROM tbl_plugin_to_user as pu 
                            INNER JOIN tbl_plugins p ON p.plugin_id = pu.pu_plugin_id
                            WHERE p.plugin_type = " . $typeId . "
                            AND pu.pu_user_id = " . $userId)) {
                $error = $db->getError();
                return false;
            }
        } else {
            if (!$db->query("INSERT INTO tbl_plugin_to_user (pu_plugin_id, pu_user_id, pu_active)
                            SELECT plugin_id, " . $userId . ", 1
                            FROM tbl_plugins
                            WHERE plugin_type = " . $typeId)) {
                $error = $db->getError();
                return false;
            }
        }
        return true;
    }
}
