<?php

class PluginBaseController extends DashboardBaseController
{
    use PluginHelper;
    use PluginBaseCommon;

    public function __construct($action)
    {
        parent::__construct($action);
    }
}
