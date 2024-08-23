<?php

trait PluginHelper
{
    public $error;
    public $settings = [];
    public $langId = 0;
    public $keyName;
    protected $recordId = 0;

    /**
     * getError
     *
     * @param  bool $showOrignal
     * @return string
     */
    public function getError(bool $showOrignal = true)
    {
        $msg = Labels::getLabel('MSG_SOMETHING_WENT_WRONG!', $this->langId);
        $error = $showOrignal ? $this->error : $msg;
        return $error;
    }

    /**
     * getPluginSettingsObj
     *
     * @return void
     */
    private function loadPluginSettingsObj(): void
    {
        $this->keyName = !empty($this->keyName) ? $this->keyName : static::KEY_NAME;
        $this->langId = 0 < $this->langId ? $this->langId : CommonHelper::getLangId();
        $this->pluginSetting = new PluginSetting(0, $this->keyName, $this->recordId);
    }

    private function setFormObj()
    {
        $this->frmObj = $this->getForm();
        if (false === $this->frmObj) {
            LibHelper::dieJsonError(Labels::getLabel('ERR_REQUIREMENT_SETTINGS_ARE_NOT_DEFINED', $this->siteLangId));
        }
    }

    /**
     * getSettings
     *
     * @return array
     */
    public function getSettings(): array
    {
        if (!empty($this->settings)) {
            return $this->settings;
        }

        $this->loadPluginSettingsObj();
        if (false === $this->settings = $this->pluginSetting->get($this->langId)) {
            $this->error = $this->pluginSetting->getError();
            return [];
        }
        return $this->settings;
    }

    /**
     * getKey - Get Single Plugin Setting Value
     *
     * @param  string $column
     * @return string
     */
    public function getKey(string $column): string
    {
        if (!empty($this->settings)) {
            return (string) ($this->settings[$column] ?? '');
        }

        $this->loadPluginSettingsObj();
        if (false === $value = $this->pluginSetting->get($this->langId, $column)) {
            $this->error = $this->pluginSetting->getError();
            return '';
        }
        return (string) $value;
    }

    /**
     * validateSettings - To validate plugin required keys are updated in db or not.
     *
     * @param  int $langId
     * @return bool
     */
    public function validateSettings(int $langId = 0): bool
    {
        $this->langId = 0 < $langId ? $langId : CommonHelper::getLangId();
        $this->settings = $this->getSettings();
        if (0 < $this->recordId) {
            if (Plugin::INACTIVE == $this->settings['pu_active']) {
                $this->error = static::KEY_NAME . ' : ' . Labels::getLabel('MSG_PLUGIN_NOT_ACTIVE', $langId);
                return false;
            }
        } else {
            if (Plugin::INACTIVE == $this->settings['plugin_active']) {
                $this->error = static::KEY_NAME . ' : ' . Labels::getLabel('MSG_PLUGIN_NOT_ACTIVE', $langId);
                return false;
            }
        }

        if (isset($this->requiredKeys) && !empty($this->requiredKeys) && is_array($this->requiredKeys)) {
            foreach ($this->requiredKeys as $key) {
                if (!array_key_exists($key, $this->settings) || '' == $this->settings[$key]) {
                    $this->error = static::KEY_NAME . ' : ' . ' "' . $key . '" ' . Labels::getLabel('MSG_SETTINGS_NOT_CONFIGURED', $langId);
                    return false;
                }
            }
        }

        return true;
    }
    

    /** updateSettings
     *
     * @param  int $pluginId
     * @param  array $data
     * @param  string $error - Reference Variable
     * @return bool
     */
    public function updateSettings(int $pluginId, array $data, &$error = ""): bool
    {
        $pluginSetting = new PluginSetting($pluginId);
        if (!$pluginSetting->updateSetting($data)) {
            $error = $pluginSetting->getError();
            return false;
        }
        return true;
    }

    /**
     * 
     * @param int $recordId
     */
    public function setRecordId(int $recordId)
    {
        $this->recordId = $recordId;
    }

    /**
     * getRecordId
     *
     * @return int
     */
    public function getRecordId()
    {
        return $this->recordId;
    }

    /**
     * formatOutput
     *
     * @param  int $status
     * @param  string $msg
     * @param  array $data
     * @return array
     */
    public function formatOutput(int $status, string $msg, array $data = [], $responseCode = LibHelper::RC_BAD_REQUEST): array
    {
        return LibHelper::formatResponse($status, $msg, $data, $responseCode);
    }
}
