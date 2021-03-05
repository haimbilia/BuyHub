<?php

class Plugin extends PluginCommon
{    
    public function __construct(int $id = 0)
    {
        parent::__construct(static::DB_TBL, static::DB_TBL_PREFIX . 'id', $id);
        $this->objMainTableRecord->setSensitiveFields(
            array('plugin_code')
        );
    }

    /**
     * getSearchObject
     *
     * @param  int $langId
     * @param  bool $isActive
     * @param  bool $joinSettings
     * @return object
     */
    public static function getSearchObject(int $langId = 0, bool $isActive = true, bool $joinSettings = false): object
    {
        $srch = new SearchBase(static::DB_TBL, 'plg');
        if ($isActive == true) {
            $srch->addCondition('plg.' . static::DB_TBL_PREFIX . 'active', '=', applicationConstants::ACTIVE);
        }
        if ($langId > 0) {
            $srch->joinTable(
                static::DB_TBL_LANG,
                'LEFT OUTER JOIN',
                'plg_l.pluginlang_' . static::DB_TBL_PREFIX . 'id = plg.' . static::DB_TBL_PREFIX . 'id and plg_l.pluginlang_lang_id = ' . $langId,
                'plg_l'
            );
        }

        if (true === $joinSettings) {
            $srch->joinTable(
                PluginSetting::DB_TBL,
                'LEFT OUTER JOIN',
                'plgs.' . PluginSetting::DB_TBL_PREFIX . static::DB_TBL_PREFIX . 'id = plg.' . static::DB_TBL_PREFIX . 'id',
                'plgs'
            );
        }
        return $srch;
    }

    /**
     * isActive
     *
     * @param  string $code - Keyname
     * @return bool
     */
    public static function isActive(string $code): bool
    {
        return (0 < static::getAttributesByCode($code, self::DB_TBL_PREFIX . 'active') ? true : false);
    }

    /**
     * isActive
     *
     * @param  string $code - Keyname
     * @return bool
     */
    public static function isActiveByType(string $type): bool
    {
        $srch = new SearchBase(static::DB_TBL, 'plg');
        $srch->addCondition('plg.' . static::DB_TBL_PREFIX . 'type', '=', $type);
        $srch->addCondition('plg.' . static::DB_TBL_PREFIX . 'active', '=', applicationConstants::YES);
        $rs = $srch->getResultSet();
        $row = FatApp::getDb()->fetch($rs);
        if (!empty($row)) {
            return true;
        }
        return false;
    }

    /**
     * getAttributesByCode
     *
     * @param  string $code
     * @param  mixed $attr
     * @param  int $langId
     * @return mixed
     */
    public static function getAttributesByCode(string $code, $attr = '', int $langId = 0)
    {
        $srch = new SearchBase(static::DB_TBL, 'plg');
        $srch->addCondition('plg.' . static::DB_TBL_PREFIX . 'code', '=', $code);

        if (0 < $langId) {
            $srch->joinTable(self::DB_TBL_LANG, 'LEFT JOIN', self::DB_TBL_LANG_PREFIX . static::DB_TBL_PREFIX . 'id = ' . static::DB_TBL_PREFIX . 'id and ' . self::DB_TBL_LANG_PREFIX . 'lang_id = ' . $langId, 'plg_l');
        }

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

    /**
     * pluginTypeSrchObj
     *
     * @param  int $typeId
     * @param  int $langId
     * @param  bool $customCols
     * @param  bool $active
     * @return object
     */
    private static function pluginTypeSrchObj(int $typeId, int $langId, bool $customCols = true, bool $active = false)
    {
        $srch = static::getSearchObject($langId, $active);
        if (false === $customCols) {
            $srch->addMultipleFields(self::ATTRS);
        }

        $srch->addCondition('plg.' . static::DB_TBL_PREFIX . 'type', '=', $typeId);
        return $srch;
    }

    /**
     * getDataByType
     *
     * @param  int $typeId
     * @param  int $langId
     * @param  bool $assoc
     * @param  bool $active
     * @return mixed
     */
    public static function getDataByType(int $typeId, int $langId = 0, bool $assoc = false, bool $active = true)
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

    /**
     * getNamesByType
     *
     * @param  int $typeId
     * @param  int $langId
     * @return mixed
     */
    public static function getNamesByType(int $typeId, int $langId)
    {
        $typeId = FatUtility::int($typeId);
        $langId = FatUtility::int($langId);
        if (1 > $typeId && 1 > $langId) {
            return false;
        }
        return static::getDataByType($typeId, $langId, true);
    }

    /**
     * getNamesWithCode
     *
     * @param  int $typeId
     * @param  int $langId
     * @return mixed
     */
    public static function getNamesWithCode(int $typeId, int $langId)
    {
        $typeId = FatUtility::int($typeId);
        $langId = FatUtility::int($langId);
        if (1 > $typeId && 1 > $langId) {
            return false;
        }
        $arr = [];
        $pluginsTypeArr = static::getDataByType($typeId, $langId);
        array_walk($pluginsTypeArr, function (&$value, &$key) use (&$arr) {
            $arr[$value['plugin_code']] = $value['plugin_name'];
        });
        return $arr;
    }

    /**
     * getSocialLoginPluginsStatus
     *
     * @param  int $langId
     * @return void
     */
    public static function getSocialLoginPluginsStatus(int $langId)
    {
        $srch = static::pluginTypeSrchObj(static::TYPE_SOCIAL_LOGIN, $langId);
        $srch->addMultipleFields(
            [
                'plg.' . static::DB_TBL_PREFIX . 'code',
                'plg.' . static::DB_TBL_PREFIX . 'active'
            ]
        );
        $rs = $srch->getResultSet();

        return FatApp::getDb()->fetchAllAssoc($rs);
    }

    /**
     * getDefaultPluginKeyName - Used for Kingpin plugins only
     *
     * @param  int $typeId
     * @return mixed
     */
    public function getDefaultPluginKeyName(int $typeId)
    {
        return $this->getDefaultPluginData($typeId, 'plugin_code');
    }

    /**
     * getDefaultPluginData - Used for Kingpin plugins only
     *
     * @param  int $typeId
     * @param  mixed $attr
     * @param  int $langId
     * @return mixed
     */
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

    /**
     * canSendSms
     *
     * @param  string $tpl
     * @return bool
     */
    public static function canSendSms(string $tpl = ''): bool
    {
        $active = (new self())->getDefaultPluginData(Plugin::TYPE_SMS_NOTIFICATION, 'plugin_active');
        $status = empty($tpl) ? 1 : SmsTemplate::getTpl($tpl, 0, 'stpl_status');
        return (false != $active && !empty($active) && 0 < $status);
    }

    /**
     * updateStatus
     *
     * @param  int $typeId
     * @param  int $status
     * @param  int $id
     * @param  mixed $error
     * @return bool
     */
    public static function updateStatus(int $typeId, int $status, int $id = null, &$error = ''): bool
    {
        $db = FatApp::getDb();
        $langId = CommonHelper::getLangId();
        $pluginKey = Plugin::getAttributesById($id, 'plugin_code');
        $pluginTypesArr = static::getTypeArr($langId);
        $plugins = static::getDataByType($typeId, $langId);
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
}
