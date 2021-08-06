<?php

class PluginSettingController extends LoggedUserController
{

    use PluginHelper;

    protected $frmObj;
    protected $pluginSettingObj;

    public function __construct($action)
    {
        parent::__construct($action);
        if (get_called_class() == __CLASS__) {
            LibHelper::dieJsonError(Labels::getLabel('MSG_INVALID_ACCESS', $this->siteLangId));
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
                LibHelper::dieJsonError(Labels::getLabel('LBL_INVALID_KEY_NAME', $this->siteLangId));
            }
        }
    }    

    public function index()
    {
        $this->setFormObj();
        $pluginSetting = new PluginSetting(0, $this->keyName, UserAuthentication::getLoggedUserId());
        $settings = $pluginSetting->get($this->siteLangId);
        if (false === $settings) {
            FatUtility::dieJsonError(Labels::getLabel('LBL_SETTINGS_NOT_AVALIABLE_FOR_THIS_PLUGIN', $this->siteLangId));
        }
        $this->frmObj->fill($settings); 
        $this->set('frm', $this->frmObj);
        $this->set('plugin_name', $settings['plugin_name']);
    
        $this->_template->render(false, false, 'seller-plugins/settings.php');
    }

    public function setup()
    {
        $this->setFormObj();
        $post = $this->frmObj->getFormDataFromArray(FatApp::getPostedData());
        if (false === $post) {
            FatUtility::dieJsonError(current($this->frmObj->getValidationErrors()));
        }

        $pluginSetting = new PluginSetting($post["plugin_id"], NULL, UserAuthentication::getLoggedUserId());
        if (!$pluginSetting->save($post)) {
            FatUtility::dieWithError($pluginSetting->getError());
        }

        $this->set('msg', Labels::getLabel('MSG_SET_UP_SUCCESSFULLY', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }
    
    public function getForm()
    {
        $class = get_called_class();
        try {
            $requirements = $class::getConfigurationKeys();
        } catch (\Error $e) {
            if (false == method_exists($class, 'form')) {
                FatUtility::dieJsonError($e->getMessage());
            }
            $frm = $class::form($this->langId);
        }
        
        if ((empty($requirements) || !is_array($requirements)) && !isset($frm)) {
            return false;
        }
        if (isset($frm)) {
            $frm = PluginSetting::addKeyFields($frm);
        } else {
            $frm = PluginSetting::getForm($requirements, $this->langId);
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
            LibHelper::dieJsonError(Labels::getLabel('LBL_INVALID_KEY_NAME', $langId));
        }
        $plugin = PluginHelper::callPlugin($keyName, [$langId], $error, $langId, false);
        if (false == method_exists($plugin, 'getFormFieldsArr')) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_UNABLE_TO_LOAD_SETTINGS_FORM', $langId));
        }
        $labelsArr = $plugin->getFormFieldsArr();

        $nonEnvFields = [];
        if (array_key_exists('envFields', $labelsArr)) {
            $nonEnvFields = array_key_exists('nonEnvFields', $labelsArr) ? $labelsArr['nonEnvFields'] : [];
            $labelsArr = $labelsArr['envFields'];
        }

        $frm = new Form('frm' . $keyName);

        $envoirment = Plugin::getEnvArr($langId);
        $envFld = $frm->addSelectBox(Labels::getLabel('LBL_ENVOIRMENT', $langId), 'env', $envoirment, '', ['class' => 'fieldsVisibility-js'], '');
        $envFld->requirement->setRequired(true);
        foreach ($labelsArr as $colName => $colLabel) {
            $htmlAfterField = $fieldFn = "";
            if (is_array($colLabel)) {
                $htmlAfterField = $colLabel['htmlAfterField'];
                $colLabel = $colLabel['label'];
                $fieldFn = isset($colLabel['fieldType']) ? $colLabel['label'] : '' ;
            }

            /* Sanbox Key Field */
            $fieldFn = !empty($fieldFn) ? $fieldFn : (('password'== strtolower($colName)) ? 'addPasswordField' : 'addTextBox');
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
            $colName = 'live_' . $colName;
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

        if (is_array($nonEnvFields) && !empty(array_filter($nonEnvFields))){
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

        $frm->addSubmitButton('&nbsp;', 'btn_submit', Labels::getLabel('LBL_Save_Changes', $langId));
        return $frm;
    }

}
