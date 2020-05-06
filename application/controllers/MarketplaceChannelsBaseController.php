<?php

class MarketplaceChannelsBaseController extends PluginBaseController
{
    public function __construct($action)
    {
        parent::__construct($action);

        $class = get_called_class();
        if (!defined($class . '::KEY_NAME')) {
            $msg = Labels::getLabel('MSG_INVALID_PLUGIN', $this->siteLangId);
            return $this->formatOutput(false, $msg);
        }
        $this->keyName = $class::KEY_NAME;
        if (false === Plugin::isActive($this->keyName)) {
            $msg = Labels::getLabel('MSG_MARKETPLACE_CHANNEL_ACCESS_RESTRICTED', $this->siteLangId);
            return $this->formatOutput(false, $msg);
        }
    }
}
