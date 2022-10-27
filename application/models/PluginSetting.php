<?php

class PluginSetting
{
    private $error;
    private $pluginId;
    private $pluginKey;
    private $langId;
    protected $recordId;

    public const DB_TBL = 'tbl_plugin_settings';
    public const DB_TBL_PREFIX = 'pluginsetting_';

    public const TYPE_STRING = 1;
    public const TYPE_INT = 2;
    public const TYPE_FLOAT = 3;
    public const TYPE_BOOL = 4;
    public const TYPE_SELECT = 5;
    public const TYPE_HTML = 6;
    public const TYPE_ENVIRONMENT = 7;

    public function __construct($id, $pluginKey = '', $recordId = 0)
    {
        $this->pluginId = empty($pluginKey) ? $id : Plugin::getAttributesByCode($pluginKey, 'plugin_id');
        $this->pluginKey = $pluginKey;
        $this->langId = CommonHelper::getLangId();
        $this->recordId = $recordId;
    }

    public function getError()
    {
        return $this->error;
    }

    public function getPluginId()
    {
        return (int) $this->pluginId;
    }

    private function delete(): bool
    {
        if (1 > $this->pluginId) {
            $this->error = Labels::getLabel('ERR_INVALID_REQUEST', $this->langId);
            return false;
        }
        $statement = [
            'smt' => static::DB_TBL_PREFIX . 'plugin_id = ? and ' . static::DB_TBL_PREFIX . 'record_id = ?',
            'vals' => [
                $this->pluginId,
                $this->recordId
            ]
        ];
        if (!FatApp::getDb()->deleteRecords(static::DB_TBL, $statement)) {
            $this->error = FatApp::getDb()->getError();
            return false;
        }
        return true;
    }

    public function get(int $langId = 0, string $column = '')
    {
        if (empty($this->pluginKey)) {
            $this->error = Labels::getLabel('ERR_PLUGIN_KEY_NOT_FOUND', $this->langId);
            return false;
        }

        $srch = new SearchBase(static::DB_TBL, 'tps');
        $srch->addCondition('tps.' . static::DB_TBL_PREFIX . 'plugin_id', '=', $this->pluginId);
        $srch->addCondition('tps.' . static::DB_TBL_PREFIX . 'record_id', '=', $this->recordId);
        $srch->addMultipleFields(array('tps.' . static::DB_TBL_PREFIX . 'key', 'tps.' . static::DB_TBL_PREFIX . 'value'));
        $srch->doNotCalculateRecords();
        $rs = $srch->getResultSet();
        if (!$rs) {
            $this->error = $srch->getError();
            return false;
        }
        $row =  FatApp::getDb()->fetchAllAssoc($rs);

        if (0 < $this->recordId) {
            $settingsData = SellerPlugin::getAttributesByCode($this->recordId, $this->pluginKey, '', $langId, false);
        } else {
            $settingsData = Plugin::getAttributesByCode($this->pluginKey, '', $langId);
        }

        if (0 < $langId) {
            $settingsData['plugin_name'] = !empty($settingsData['plugin_name']) ? $settingsData['plugin_name'] : $settingsData['plugin_identifier'];
        }
        $settings = array_merge($row, $settingsData);


        if (!empty($column) && is_string($column)) {
            return array_key_exists($column, $settings) ? $settings[$column] : '';
        }

        return $settings;
    }

    public function cleanData(&$data): bool
    {
        if (empty($data) || !is_array($data)) {
            $this->error = Labels::getLabel('ERR_PLEASE_PROVIDE_DATA_TO_SAVE_SETTINGS', $this->langId);
            return false;
        }
        unset($data['keyName'], $data['btn_submit'], $data["plugin_id"]);

        if (1 > count($data)) {
            $this->error = Labels::getLabel('ERR_NOTHING_TO_UPDATE', $this->langId);
            return false;
        }
        return true;
    }

    public function save(array $data, array $statement = []): bool
    {
        if (false === $this->cleanData($data)) {
            return false;
        }

        if (!$this->delete($statement)) {
            return false;
        }
        foreach ($data as $key => $val) {
            $updateData = [
                'pluginsetting_plugin_id' => $this->pluginId,
                'pluginsetting_record_id' => $this->recordId,
                'pluginsetting_key' => $key,
                'pluginsetting_value' => is_array($val) ? serialize($val) : $val,
            ];

            if (!FatApp::getDb()->insertFromArray(static::DB_TBL, $updateData, false, [], $updateData)) {
                $this->error = FatApp::getDb()->getError();
                return false;
            }
        }
        return true;
    }

    public function updateSetting(array $data): bool
    {
        if (false === $this->cleanData($data)) {
            return false;
        }

        $smt = self::DB_TBL_PREFIX . 'plugin_id = ?';
        $vals = [$this->pluginId];
        foreach ($data as $key => $val) {
            $smt .= " AND pluginsetting_key = ?";
            $vals[] = $key;
        }

        $statement = [
            'smt' => $smt,
            'vals' => $vals
        ];
        return $this->save($data, $statement);
    }

    public static function getForm($requirements, $langId)
    {
        $frm = new Form('frmPlugins');
        $frm->addHiddenField('', 'keyName');
        $frm->addHiddenField('', 'plugin_id');

        foreach ($requirements as $fieldName => $attributes) {
            $label = '';
            if (isset($attributes['label'])) {
                $label = 'FRM_' . str_replace(' ', '_', strtoupper($attributes['label']));
                $label = Labels::getLabel($label, $langId);
            }

            switch ($attributes['type']) {
                case static::TYPE_INT:
                    $fld = $frm->addIntegerField($label, $fieldName);
                    break;
                case static::TYPE_FLOAT:
                    $fld = $frm->addFloatField($label, $fieldName);
                    break;
                case static::TYPE_BOOL:
                    $yesNo = array_reverse(applicationConstants::getYesNoArr($langId));
                    $fld = $frm->addSelectBox($label, $fieldName, $yesNo, '', array(), '');
                    break;
                case static::TYPE_ENVIRONMENT:
                    $envoirment = Plugin::getEnvArr($langId);
                    $fld = $frm->addSelectBox($label, $fieldName, $envoirment, '', ['class' => 'fieldsVisibilityJs'], '');
                    break;
                case static::TYPE_SELECT:
                    $options = $attributes['options'] ?? [];
                    $selectedValue = $attributes['selectedValue'] ?? '';
                    $selectCaption = $attributes['selectCaption'] ?? Labels::getLabel('LBL_SELECT', $langId);
                    $fld = $frm->addSelectBox($label, $fieldName, $options, $selectedValue, array(), $selectCaption);
                    break;
                case static::TYPE_HTML:
                    $html = $attributes['html'] ?? '';
                    if (!empty($html)) {
                        $frm->addHtml('', $fieldName, $html);
                    }
                    break;
                default:
                    $fld = $frm->addTextBox($label, $fieldName);
                    break;
            }

            if (isset($attributes['required']) && true == $attributes['required']) {
                $fld->requirements()->setRequired(true);
            }

            if (isset($attributes['htmlAfterField']) && !empty($attributes['htmlAfterField'])) {
                $fld->htmlAfterField = $attributes['htmlAfterField'];
            }
        }
        return $frm;
    }

    public static function addKeyFields($frm)
    {
        $frm->addHiddenField('', 'keyName');
        $frm->addHiddenField('', 'plugin_id');
        return $frm;
    }
}
