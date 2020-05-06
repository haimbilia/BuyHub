<?php

class EasyEcomController extends MarketplaceChannelsBaseController
{
    public const KEY_NAME = 'EasyEcom';

    public $requiredKeys = ['easyecom_token'];
    private $authToken;

    public function __construct($action)
    {
        parent::__construct($action);
        $error = '';
        if (false === PluginHelper::includePlugin(self::KEY_NAME, 'marketplace-channels', $this->siteLangId, $error)) {
            $resp = $this->formatOutput(false, $error);
            $this->dieWithResponse($resp);
        }
        $this->easyEcom = new EasyEcom($this->siteLangId);
        if (false === $this->easyEcom) {
            $resp = $this->formatOutput(false, $this->easyEcom->getError());
            $this->dieWithResponse($resp);
        }
    }

    public function getAuthToken()
    {
        if (!isset($_SERVER['HTTP_EEC_TOKEN']) || empty($_SERVER['HTTP_EEC_TOKEN'])) {
            $msg = Labels::getLabel("MSG_UNAUTHORIZED_ACCESS", $this->siteLangId);
            $resp = $this->formatOutput(false, $msg);
            $this->dieWithResponse($resp);
        }

        $this->dieWithResponse($this->easyEcom->getAuthToken($_SERVER['HTTP_EEC_TOKEN']));
    }
}