<?php

use Curl\Curl;

class EasyEcomController extends MarketplaceChannelsBaseController
{
    public const KEY_NAME = 'EasyEcom';
    public const PRODUCTION_URL = 'https://app.easyecom.io/';

    private $reqAuthToken = '';
    
    /**
     * __construct
     *
     * @param  string $action
     * @return void
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
        $error = '';
        if (false === PluginHelper::includePlugin(self::KEY_NAME, 'marketplace-channels', $error, $this->siteLangId)) {
            $resp = $this->formatOutput(Plugin::RETURN_FALSE, $error);
            $this->dieWithJsonResponse($resp);
        }

        $this->init();
    }

    /**
     * inilialize
     * 
     * @return void
     */
    private function init()
    {
        $this->easyEcom = new EasyEcom($this->siteLangId);
        if (false == $this->easyEcom->validateSettings($this->siteLangId)) {
            $resp = $this->formatOutput(Plugin::RETURN_FALSE, $this->easyEcom->getError());
            $this->dieWithJsonResponse($resp);
        }
        
        if (true === MOBILE_APP_API_CALL && false == UserAuthentication::doAppLogin(CommonHelper::getAppToken())) {
            $msg = Labels::getLabel("MSG_INVALID_USER", $this->siteLangId);
            $resp = $this->formatOutput(Plugin::RETURN_FALSE, $msg);
            $this->dieWithJsonResponse($resp);
        }
    }

    /**
     * index
     * 
     * @return void
     */
    public function index()
    {
        $this->set('pluginName', self::KEY_NAME);
        $this->_template->render();
    }

    /**
     * landingPage
     * 
     * @return void
     */
    public function landingPage()
    {
        $userId = UserAuthentication::getLoggedUserId();
        $easyEcomSellerToken = User::getUserMeta($userId, 'easyEcomSellerToken');
        $this->set('easyEcomSellerToken', $easyEcomSellerToken);
        $this->_template->render(false, false);
    }
    
    /**
     * register
     * 
     * @return void
     */
    public function register()
    {
        $userData = $this->getLoggedUserInfo();
        $uObj = new User($this->getUserId());
        if (!$authToken = $uObj->setMobileAppToken($this->easyEcom->getKeys('auth_token_age'))) {
            FatUtility::dieJsonError(Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId));
        }

        $shopAddress = [
            'address_line_1' => $userData['shop_name'],
            'address_line_2' => $userData['shop_city'],
            'pin_code' => $userData['shop_postalcode'],
            'state_code' => $userData['state_code'],
            'country' => strtoupper($userData['country_code']),
        ];

        $password = mt_rand();
        $dataToUpdate = [
            "phone" => $userData['shop_phone'],
            "company_name" => $userData['user_name'],
            "email" => $userData['credential_email'],
            "client_id" => $this->easyEcom->getKeys('easyecom_token'),
            "password" =>  $password,
            "shipping_address" => $shopAddress,
            "billing_address" => $shopAddress,
            "credentials" => [
                [
                    "m_id" => 219, // This need to be placed statically. It points to YoKart at EasyEcom(ID of YoKart).
                    "username" => $userData['credential_email'],
                    "password" => $authToken
                ]
		    ]

        ];

        $curl = new Curl();
        $curl->post(self::PRODUCTION_URL . 'Company/Create', json_encode($dataToUpdate));
        $curl->setHeader('Content-Type', 'application/json');
        if ($curl->error) {
            LibHelper::exitWithError($curl->errorCode . ': ' . $curl->errorMessage, true);
        }

        $resp = json_decode($curl->response, true);
        if (200 != $resp['code']) {
            LibHelper::exitWithError($resp['message'], true);
        }

        $easyEcomSellerToken = $resp['data']['token'];
        $this->updateUserMeta('easyEcomSellerToken', $easyEcomSellerToken);
        $this->updateUserMeta('seller_auth_token', $authToken);
        FatUtility::dieJsonSuccess($resp['message']);
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

    /**
     * updateStockQty
     * 
     * @return void
     */
    public function updateStockQty()
    {
        $selProdId = FatApp::getPostedData('selprod_id', FatUtility::VAR_INT, 0);
        $balanceQty = FatApp::getPostedData('balance_qty', FatUtility::VAR_INT, 0);

        if (1 > $selProdId || 0 > $balanceQty) {
            $msg = Labels::getLabel("MSG_INVALID_REQUEST", $this->langId);
            $resp = $this->formatOutput(Plugin::RETURN_FALSE, $msg);
            $this->dieWithJsonResponse($resp);
        }

        $resp = $this->easyEcom->updateProductStockQty($selProdId, $balanceQty);
        $this->dieWithJsonResponse($resp);
    }

    /**
     * getShippedOrderCarrierDetail
     * 
     * @return void
     */
    public function getShippedOrderCarrierDetail()
    {
        $opId = FatApp::getPostedData('op_id', FatUtility::VAR_INT, 0);
        if (1 > $opId) {
            $msg = Labels::getLabel("MSG_INVALID_REQUEST", $this->langId);
            $resp = $this->formatOutput(Plugin::RETURN_FALSE, $msg);
            $this->dieWithJsonResponse($resp);
        }
        $resp = $this->easyEcom->getShippedOrderCarrierDetail($opId);
        $this->dieWithJsonResponse($resp);
    }

    /**
     * getOrderStatus
     * 
     * @return void
     */
    public function getOrderStatus()
    {
        $opId = FatApp::getPostedData('op_id', FatUtility::VAR_INT, 0);
        if (1 > $opId) {
            $msg = Labels::getLabel("MSG_INVALID_REQUEST", $this->langId);
            $resp = $this->formatOutput(Plugin::RETURN_FALSE, $msg);
            $this->dieWithJsonResponse($resp);
        }
        $resp = $this->easyEcom->getOrderStatus($opId);
        $this->dieWithJsonResponse($resp);
    }

    /**
     * markOrderAsShipped
     * 
     * @return void
     */
    public function markOrderAsShipped()
    {
        $resp = $this->easyEcom->markOrderAsShipped(FatApp::getPostedData());
        $this->dieWithJsonResponse($resp);
    }
}