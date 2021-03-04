<?php

class SellerPluginsController extends SellerPluginBaseController
{

    public function __construct($action)
    {           
        parent::__construct($action);
        $this->userPrivilege->canViewSellerPLugins(UserAuthentication::getLoggedUserId());
    }

    public function index($type = Plugin::TYPE_DATA_MIGRATION)
    {  
        $this->set("type", $type);
        $this->_template->render();
    }
    
    public function search($type)
    {
        $post = FatApp::getPostedData();
        $srch = SellerPlugin::getSearchObject($this->siteLangId, false);        
        $srch->addCondition('plugin_type', '=', $type);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addOrder(Plugin::DB_TBL_PREFIX . 'active', 'DESC');
        $srch->addOrder(Plugin::DB_TBL_PREFIX . 'display_order', 'ASC');
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("arr_listing", $records);
        $this->set("defaultPluginId",  SellerPlugin::getDefaultPluginId($type,UserAuthentication::getLoggedUserId()));
        $this->set('canEdit', $this->userPrivilege->canEditSellerPLugins(UserAuthentication::getLoggedUserId(), true));
        $this->_template->render(false, false);
    }
    
    public function changeStatus()
    {
        $this->userPrivilege->canEditSellerPLugins(UserAuthentication::getLoggedUserId());
        $pluginId = FatApp::getPostedData('pluginId', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);
        if (0 >= $pluginId) {                  
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
        }
        
        $sPluginObj = new SellerPlugin(UserAuthentication::getLoggedUserId());

        $data = $sPluginObj->getAttributesById($pluginId);
        if (1 > count($data)) {         
            FatUtility::dieJsonError(Labels::getLabel('MSG_Invalid_Request', $this->siteLangId));
        }
        
        if (false == Plugin::updateStatus($data['plugin_type'], $status, $pluginId, $error)) {
            FatUtility::dieJsonError($error);
        }

        $this->set('msg', $this->str_update_record);
        $this->_template->render(false, false, 'json-success.php');
    }
    
    
    
    
    
    

}
