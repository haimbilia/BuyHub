<?php

class ErrorController extends DashboardBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function index()
    {
        $this->set('exculdeMainHeaderDiv', true);
        $this->_template->render(true, false);
    }
}
