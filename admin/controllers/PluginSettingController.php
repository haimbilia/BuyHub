<?php

class PluginSettingController extends ListingBaseController
{
    use PluginHelper;

    protected $frmObj;
    protected $pluginSettingObj;

    public function __construct($action)
    {
        parent::__construct($action);
        $this->admin_id = AdminAuthentication::getLoggedAdminId();
        $this->objPrivilege->canEditPlugins($this->admin_id);

        if (get_called_class() == __CLASS__) {
            LibHelper::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        $this->keyName = FatApp::getPostedData('keyName', FatUtility::VAR_STRING, '');
        if (empty($this->keyName)) {
            try {
                $this->keyName = get_called_class()::KEY_NAME;
            } catch (\Error $e) {
                $message = $e->getMessage();
                LibHelper::dieJsonError($message);
            }
            if (empty($this->keyName)) {
                LibHelper::dieJsonError(Labels::getLabel('ERR_INVALID_KEY_NAME', $this->siteLangId));
            }
        }
    }

    public function index()
    {
        $this->setFormObj();
        $pluginSetting = new PluginSetting(0, $this->keyName);
        $settings = $pluginSetting->get();
        if (false === $settings) {
            $msg = empty($pluginSetting->getError()) ? Labels::getLabel('ERR_SETTINGS_NOT_AVALIABLE_FOR_THIS_PLUGIN', $this->siteLangId) : $pluginSetting->getError();
            LibHelper::exitWithError($msg, true);
        }
        $this->frmObj->fill($settings);
        $identifier = isset($settings['plugin_identifier']) ? $settings['plugin_identifier'] : '';
        $this->set('frm', $this->frmObj);
        $this->set('identifier', $identifier);
        $this->set('keyName', $this->keyName);

        $this->set('html', $this->_template->render(false, false, 'plugins/settings.php', true));
        $this->_template->render(false, false, 'json-success.php', true, false);
    }

    public function setup()
    {
        $this->setFormObj();
        $post = $this->frmObj->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            LibHelper::exitWithError(current($this->frmObj->getValidationErrors()), true);
        }
        $post = array_map('trim', $post);

        $keyName = FatApp::getPostedData('keyName', FatUtility::VAR_STRING, '');
        if (empty($keyName)) {
            LibHelper::dieJsonError(Labels::getLabel('ERR_INVALID_KEY_NAME'));
        }

        $error = '';
        $plugin = LibHelper::callPlugin($keyName, [$this->siteLangId], $error, $this->siteLangId, false);
        if (false === $plugin) {
            $error = !empty($error) ? $error : Labels::getLabel('LBL_UNABLE_TO_LOCATE_REQUIRED_FILE.');
            FatUtility::dieJsonError($error);
        }
        
        if (false === $plugin->validateKeys($post)) {
            if (empty($error)) {
                $error = $plugin->getError();
            }
            $error = !empty($error) ? $error : Labels::getLabel('LBL_GIVEN_KEYS_ARE_NOT_VALID.');
            FatUtility::dieJsonError($error);
        }

        if (isset($post['update_previous_connected_accounts'])) {
            $post['update_previous_connected_accounts'] = applicationConstants::NO;
        }

        $pluginSetting = new PluginSetting($post["plugin_id"]);
        if (!$pluginSetting->save($post)) {
            LibHelper::exitWithError($pluginSetting->getError(), true);
        }

        $updatePayoutSettings = FatApp::getPostedData('update_previous_connected_accounts', FatUtility::VAR_INT, 0);
        if (0 < $updatePayoutSettings && StripeConnect::KEY_NAME == $keyName) {
            if (false === $plugin->updatePayoutSettings()) {
                LibHelper::exitWithError($plugin->getError(), true);
            }
        }

        $msg = Labels::getLabel('MSG_CONFIGURATION_KEYS_SAVED_SUCCESSFULLY.!!', $this->siteLangId);

        $plugin = Plugin::getAttributesById($post["plugin_id"], ['plugin_type', 'plugin_active']);
        if (Plugin::TYPE_SHIPPING_SERVICES == $plugin['plugin_type'] && $plugin['plugin_active'] == PLugin::ACTIVE) {
            $msg .=  ' ' . Labels::getLabel('MSG_PLEASE_SYNC_THE_CARRIERS.', $this->siteLangId);
        }

        $this->set('msg', $msg);
        $this->_template->render(false, false, 'json-success.php');
    }

    public function getForm()
    {
        $class = get_called_class();
        try {
            $requirements = $class::getConfigurationKeys();
        } catch (\Error $e) {
            if (false == method_exists($class, 'form')) {
                LibHelper::exitWithError($e->getMessage());
            }
            $frm = $class::form($this->siteLangId);
        }

        if ((empty($requirements) || !is_array($requirements)) && !isset($frm)) {
            return false;
        }
        if (isset($frm)) {
            $frm = PluginSetting::addKeyFields($frm);
        } else {
            $frm = PluginSetting::getForm($requirements, $this->siteLangId);
        }
        $frm->fill(['keyName' => $this->keyName]);
        return $frm;
    }

    /**
     * form - Used in case no form method defined in called class
     *
     * @param  int $langId
     * @return object
     */
    public static function form(int $langId)
    {
        $keyName = FatApp::getPostedData('keyName', FatUtility::VAR_STRING, '');
        if (empty($keyName)) {
            LibHelper::dieJsonError(Labels::getLabel('ERR_INVALID_KEY_NAME', $langId));
        }
        $plugin = LibHelper::callPlugin($keyName, [$langId], $error, $langId, false);
        if (false == method_exists($plugin, 'getFormFieldsArr')) {
            LibHelper::exitWithError(Labels::getLabel('ERR_UNABLE_TO_LOAD_SETTINGS_FORM', $langId));
        }
        $labelsArr = $plugin->getFormFieldsArr();

        $nonEnvFields = [];
        if (array_key_exists('envFields', $labelsArr)) {
            $nonEnvFields = array_key_exists('nonEnvFields', $labelsArr) ? $labelsArr['nonEnvFields'] : [];
            $labelsArr = $labelsArr['envFields'];
        }

        $frm = new Form('frm' . $keyName);

        $envoirment = Plugin::getEnvArr($langId);
        $envFld = $frm->addSelectBox(Labels::getLabel('FRM_ENVOIRMENT', $langId), 'env', $envoirment, '', ['class' => 'fieldsVisibilityJs'], '');
        $envFld->requirement->setRequired(true);
        foreach ($labelsArr as $colName => $colLabel) {
            $htmlAfterField = "";
            if (is_array($colLabel)) {
                $htmlAfterField = $colLabel['htmlAfterField'];
                $colLabel = $colLabel['label'];
            }

            /* Sanbox Key Field */
            $fieldFn = ('password' == strtolower($colName)) ? 'addPasswordField' : 'addTextBox';
            $fld = $frm->$fieldFn($colLabel, $colName);
            $fld->htmlAfterField = $htmlAfterField;

            $fld = new FormFieldRequirement($colName, $colLabel);
            $fld->setRequired(false);
            $reqFld = new FormFieldRequirement($colName, $colLabel);
            $reqFld->setRequired(true);

            $envFld->requirements()->addOnChangerequirementUpdate(Plugin::ENV_SANDBOX, 'eq', $colName, $reqFld);
            $envFld->requirements()->addOnChangerequirementUpdate(Plugin::ENV_PRODUCTION, 'eq', $colName, $fld);
            /* Sanbox Key Field */

            /* Live Key Fields */
            $colName = (false === strpos($colName, 'live_') ? 'live_' . $colName : $colName);
            $fld = $frm->$fieldFn($colLabel, $colName);
            $fld->htmlAfterField = $htmlAfterField;

            $fld = new FormFieldRequirement($colName, $colLabel);
            $fld->setRequired(false);
            $reqFld = new FormFieldRequirement($colName, $colLabel);
            $reqFld->setRequired(true);

            $envFld->requirements()->addOnChangerequirementUpdate(Plugin::ENV_SANDBOX, 'eq', $colName, $fld);
            $envFld->requirements()->addOnChangerequirementUpdate(Plugin::ENV_PRODUCTION, 'eq', $colName, $reqFld);
            /* Live Key Fields */
        }

        if (is_array($nonEnvFields) && !empty(array_filter($nonEnvFields))) {
            foreach ($nonEnvFields as $colName => $colLabel) {
                $htmlAfterField = "";
                if (is_array($colLabel)) {
                    $htmlAfterField = $colLabel['htmlAfterField'];
                    $colLabel = $colLabel['label'];
                }
                $fld = $frm->addRequiredField($colLabel, $colName);
                $fld->htmlAfterField = $htmlAfterField;
            }
        }
        return $frm;
    }
}
