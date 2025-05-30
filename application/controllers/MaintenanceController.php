<?php

class MaintenanceController extends MyAppController
{
    public function index()
    {
        if (!FatApp::getConfig("CONF_MAINTENANCE", FatUtility::VAR_STRING, '')) {
            FatApp::redirectUser(UrlHelper::generateUrl('Home'));
        }
        $this->set('maintenanceText', FatApp::getConfig("CONF_MAINTENANCE_TEXT_" . $this->siteLangId, FatUtility::VAR_STRING, ''));
        if (CommonHelper::isAppUser()) {
            $this->set('exculdeMainHeaderDiv', true);
        }
        $this->_template->render(true, !(CommonHelper::isAppUser()));
    }
}
