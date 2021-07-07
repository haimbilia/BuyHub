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

    private function setFormObj()
    {
        $this->frmObj = $this->getForm();
        if (false === $this->frmObj) {
            LibHelper::dieJsonError(Labels::getLabel('LBL_REQUIREMENT_SETTINGS_ARE_NOT_DEFINED', $this->siteLangId));
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
            $requirements = $class::getConfigurationKeys($this->siteLangId);
        } catch (\Error $e) {
            if (false == method_exists($class, 'form')) {
                FatUtility::dieJsonError($e->getMessage());
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

}
