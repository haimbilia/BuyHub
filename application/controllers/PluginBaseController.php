<?php

class PluginBaseController extends MyAppController
{
    use PluginHelper;
    use PluginBaseCommon;

    public function __construct($action)
    {
        parent::__construct($action);
    }
}
