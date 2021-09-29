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
    
}
