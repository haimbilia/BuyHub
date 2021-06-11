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
        $userId = UserAuthentication::getLoggedUserId();
        $post = FatApp::getPostedData();
        $srch = SellerPlugin::getSearchObject($userId, $this->siteLangId, false, false);
        $srch->addCondition('plugin_type', '=', $type);
        $srch->doNotCalculateRecords();
        $srch->doNotLimitRecords();
        $srch->addOrder(Plugin::DB_TBL_PREFIX . 'active', 'DESC');
        $srch->addOrder(Plugin::DB_TBL_PREFIX . 'display_order', 'ASC');
        $rs = $srch->getResultSet();
        $records = FatApp::getDb()->fetchAll($rs);
        $this->set("arrListing", $records);
        $this->set("defaultPluginId", SellerPlugin::getDefaultPluginId($type, $userId));
        $this->set('canEdit', $this->userPrivilege->canEditSellerPLugins($userId, true));
        $this->_template->render(false, false);
    }

    public function changeStatus()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $this->userPrivilege->canEditSellerPLugins($userId);

        $pluginId = FatApp::getPostedData('pluginId', FatUtility::VAR_INT, 0);
        $status = FatApp::getPostedData('status', FatUtility::VAR_INT, 0);

        $sellerPlugin = new SellerPlugin($pluginId, $userId);
        if (!$sellerPlugin->updateStatus($status)) {
            FatUtility::dieJsonError($sellerPlugin->getError());
        }
        $this->set('msg', Labels::getLabel('MSG_Status_changed_Successfully', $this->siteLangId));
        $this->_template->render(false, false, 'json-success.php');
    }

}
