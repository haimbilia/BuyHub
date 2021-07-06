<?php

use Curl\Curl;

class EasyEcomController extends MarketplaceChannelsBaseController
{
    public const KEY_NAME = 'EasyEcom';
    public const PRODUCTION_URL = 'https://app.easyecom.io/';
    public const LOGIN_URL = 'https://api.marketplace.4qcteam.com/';
    public const API_URL = 'https://api.easyecom.io/';
    
    private $remoteUserData = [];

    /**
     * __construct
     *
     * @param  string $action
     * @return void
     */
    public function __construct(string $action)
    {
        parent::__construct($action);
        $this->userId = $this->getUserId();
        $this->easyEcom = PluginHelper::callPlugin(self::KEY_NAME, [$this->siteLangId, $action, $this->userId], $error, $this->siteLangId);
        if (false === $this->easyEcom) {
            $error = is_string($error) ? $this->formatOutput(Plugin::RETURN_FALSE, $error) : $error;
            $this->dieWithJsonResponse($error);
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
        $this->settings = $this->easyEcom->getSettings();
        if (true === MOBILE_APP_API_CALL && false == UserAuthentication::doAppLogin(CommonHelper::getAppToken())) {
            $msg = Labels::getLabel("MSG_INVALID_USER", $this->siteLangId);
            $resp = $this->formatOutput(Plugin::RETURN_FALSE, $msg);
            $this->dieWithJsonResponse($resp);
        }
    }
    
    /**
     * getRemoteUserData
     *
     * @return void
     */
    private function getRemoteUserData()
    {
        $userData = $this->getLoggedUserInfo();
        $requestData = [
            "email" => $userData['credential_email'],
            "password" => $this->getUserMeta('seller_auth_token'),
        ];
        CommonHelper::printArray($requestData);
        $curl = new Curl();
        $curl->post(self::API_URL . 'getApiToken', json_encode($requestData));
        $curl->setHeader('Content-Type', 'application/json');
        if ($curl->error) {
            LibHelper::exitWithError($curl->errorCode . ': ' . $curl->errorMessage, true);
        }
        CommonHelper::printArray($curl->response, true);
        $resp = json_decode($curl->response, true);
        if (200 != $resp['code']) {
            LibHelper::exitWithError($resp['message'], true);
        }
    }


    /**
     * index
     * 
     * @return void
     */
    public function index()
    {
        $this->set('pluginName', $this->settings['plugin_name']);
        $this->_template->render();
    }

    /**
     * landingPage
     * 
     * @return void
     */
    public function landingPage()
    {
        $easyEcomSellerToken = User::getUserMeta($this->userId, 'easyEcomSellerToken');
        $userTempToken = substr(md5(rand(1, 99999) . microtime()), 0, UserAuthentication::TOKEN_LENGTH);
        $uObj = new User($this->userId);
        if (!$uObj->createUserTempToken($userTempToken)) {
            FatUtility::dieJsonError($uObj->getError());
        }

        /* Set Cookie expiry for 365 days. But Token expired after 10 mins. */
        CommonHelper::setCookie('_ykEasyLogin', $userTempToken, time() + 3600 * 24 * 365, '/', '.' . $_SERVER['HTTP_HOST'], false, false);

        $this->set('loginUrl', self::LOGIN_URL);
        $this->set('userId', $this->userId);
        $this->set('pluginDescription', $this->settings['plugin_description']);
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
        if (!$authToken = $uObj->setMobileAppToken(UserAuthentication::TOKEN_AGE_IN_DAYS)) {
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
            "client_id" => $this->easyEcom->getKey('easyecom_token'),
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
    
    /**
     * syncStatus : Used in case vendor don't want to sync orders or products.
     *
     * @return void
     */
    public function syncStatus(int $status)
    {
        // $this->getRemoteUserData();

        $msg = Labels::getLabel('MSG_AUTO_SYNC_TURNED_OFF', $this->siteLangId);
        if (0 < $status) {
            $msg = Labels::getLabel('MSG_AUTO_SYNC_TURNED_ON', $this->siteLangId);
        }
        
        $response = ['msg' => $msg, 'status' => Plugin::RETURN_TRUE];
        if (false === $this->updateUserMeta('easyEcomSyncingStatus', $status)) {
            $response = ['msg' => $this->getError(), 'status' => Plugin::RETURN_FALSE];
        }

        /* if (1 == $response['status']) {
            $userData = $this->getLoggedUserInfo();
            $dataToUpdate = [
                "api_token" => $this->easyEcom->getKey('easyecom_token'),
                "m_id" => 219,  // This need to be placed statically. It points to YoKart at EasyEcom(ID of YoKart).
                "syncStatus" => $status
            ];

            $curl = new Curl();
            $curl->post(self::PRODUCTION_URL . '/Maintenance/switchSyncStatus', json_encode($dataToUpdate));
            $curl->setHeader('Content-Type', 'application/json');
            if ($curl->error) {
                LibHelper::exitWithError($curl->errorCode . ': ' . $curl->errorMessage, true);
            }

            // $resp = json_decode($curl->response, true);
            CommonHelper::printArray($curl->response, true);
            if (200 != $resp['code']) {
                LibHelper::exitWithError($resp['message'], true);
            }
        } */

        $this->dieWithJsonResponse($response);
    }
    
    /**
     * getOrdersStatusList
     *
     * @return void
     */
    public function getOrdersStatusList()
    {
        $orderStatusArr = Orders::getOrderProductStatusArr($this->siteLangId);
        $msg = Labels::getLabel('MSG_SUCCESS', $this->siteLangId);
        $resp = $this->formatOutput(Plugin::RETURN_TRUE, $msg, $orderStatusArr);
        $this->dieWithJsonResponse($resp);
    }
}