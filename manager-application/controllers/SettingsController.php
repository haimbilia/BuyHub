<?php

class SettingsController extends AdminBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
        $this->objPrivilege->canViewSettings();
    }

    public function index()
    {
        $this->set('objPrivilege', $this->objPrivilege);
        $this->_template->render();
    }

    public function getBreadcrumbNodes($action)
    {
        $nodes = array();
        switch ($action) {
            case 'index':
                $nodes[] = array('title' => Labels::getLabel('LBL_CONFIGURATION_&_MANAGEMENT', $this->siteLangId));
                break;
        }
        return $nodes;
    }
}
