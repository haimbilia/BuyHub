<?php
class YkPluginTest extends YkAppTest
{
    private static $class;
    private static $keyName;
    private static $plugin;
    private static $directory;
    private static $pluginStatus;
    private static $settings;
    private static $missingSettings;
    private static $pluginSettingObj;

    /**
     * setupBeforeClass - This will treat as constructor.
     *
     * @return void
     */
    public static function setupBeforeClass(): void
    {
        self::$class = get_called_class();
        self::$keyName = (self::$class)::KEY_NAME;
        self::$plugin = Plugin::getAttributesByCode(self::$keyName, ['plugin_id', 'plugin_type', 'plugin_active']);
        self::$directory = Plugin::getDirectory(self::$plugin['plugin_type']);
        $langId = CommonHelper::getLangId();

        if (false === PluginHelper::includePlugin(self::$keyName, self::$directory, $error, $langId, false)) {
            FatUtility::dieJsonError($error);
        }

        if (!defined('LANG_CODES_ARR')) {
            define('LANG_CODES_ARR', Language::getAllCodesAssoc());
        }

        if (Plugin::INACTIVE == self::$plugin['plugin_active']) {
            if (true === Plugin::updateStatus(self::$plugin['plugin_type'], Plugin::ACTIVE, self::$plugin['plugin_id'])) {
                self::$pluginStatus = Plugin::ACTIVE;
                if (method_exists(self::$class, 'settings')) {
                    self::$settings = (self::$class)::settings();
                    self::updateSettings();
                }
            }
        }
    }

    /**
     * tearDownAfterClass - Called after the last test of the test case, respectively.
     *
     * @return void
     */
    public static function tearDownAfterClass(): void
    {
        if (Plugin::ACTIVE == self::$pluginStatus) {
            Plugin::updateStatus(self::$plugin['plugin_type'], Plugin::INACTIVE, self::$plugin['plugin_id']);
        }

        if (!empty(self::$missingSettings)) {
            $revertSettings = array_fill_keys(self::$missingSettings, '');
            if (!self::$pluginSettingObj->save($revertSettings)) {
                FatUtility::dieJsonError(self::$pluginSettingObj->getError());
            }
        }
    }

    /**
     * updateSettings - Update Plugin's default settings to make it temporarily working.
     *
     * @return void
     */
    private static function updateSettings()
    {
        if (!empty(self::$settings)) {
            self::$pluginSettingObj = new PluginSetting(self::$plugin["plugin_id"], self::$keyName);
            $pluginSettings = self::$pluginSettingObj->get();
            foreach (self::$settings as $settingKey => $value) {
                if (!array_key_exists($settingKey, $pluginSettings) || empty($pluginSettings[$settingKey])) {
                    self::$missingSettings[] = $settingKey;
                }
            }

            if (!self::$pluginSettingObj->save(self::$settings)) {
                FatUtility::dieJsonError(self::$pluginSettingObj->getError());
            }
        }
    }
}
