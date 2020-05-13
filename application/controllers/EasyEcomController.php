<?php

class EasyEcomController extends MarketplaceChannelsBaseController
{
    public const KEY_NAME = 'EasyEcom';

    private $authToken;
    private $reqAuthToken = '';

    public function __construct($action)
    {
        parent::__construct($action);
        $error = '';
        if (false === PluginHelper::includePlugin(self::KEY_NAME, 'marketplace-channels', $this->siteLangId, $error)) {
            $resp = $this->formatOutput(false, $error);
            $this->dieWithJsonResponse($resp);
        }

        $this->init($action);
    }

    /**
     * inilialize
     * 
     * @param string $action 
     * @return void
     */
    private function init(string $action)
    {
        if ('getAuthToken' == $action && isset($_SERVER['HTTP_EEC_TOKEN'])){
            $this->reqAuthToken = $_SERVER['HTTP_EEC_TOKEN'];
        } else if (isset($_SERVER['HTTP_AUTH_TOKEN'])) {
            $this->reqAuthToken = $_SERVER['HTTP_AUTH_TOKEN'];
        }

        $this->easyEcom = new EasyEcom($this->siteLangId);
        if (false == $this->easyEcom->init($action, $this->reqAuthToken)) {
            $resp = $this->formatOutput(false, $this->easyEcom->getError());
            $this->dieWithJsonResponse($resp);
        }
    }

    /**
     * getAuthToken
     * 
     * @return void
     */
    public function getAuthToken()
    {
        $authToken = FatApp::getPostedData('authToken', FatUtility::VAR_STRING, '');
        if (empty($authToken)) {
            $msg = Labels::getLabel('MSG_MISSING_PARAMETERS', $this->siteLangId);
            $resp = $this->formatOutput(false, $msg);
            $this->dieWithJsonResponse($resp);
        }
        $resp = $this->easyEcom->getAuthToken($authToken);
        $this->dieWithJsonResponse($resp);
    }

    /**
     * getProducts
     * 
     * @return void
     */
    public function getProducts()
    {
        $post = FatApp::getPostedData();
        $resp = $this->easyEcom->getProducts($post);
        $this->dieWithJsonResponse($resp);
    }

    /**
     * getOrders
     * 
     * @return void
     */
    public function getOrders()
    {
        $post = FatApp::getPostedData();
        $resp = $this->easyEcom->getOrders($post);
        $this->dieWithJsonResponse($resp);
    }
}