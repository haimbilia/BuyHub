<?php

class EasyEcomController extends MarketplaceChannelsBaseController
{
    public const KEY_NAME = 'EasyEcom';

    private $reqAuthToken = '';

    public function __construct($action)
    {
        parent::__construct($action);
        $error = '';
        if (false === PluginHelper::includePlugin(self::KEY_NAME, 'marketplace-channels', $error, $this->siteLangId)) {
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
     * index
     * 
     * @return void
     */
    public function index()
    {
        $this->set('easyEcomSellerToken', '');
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
        $this->_template->render(false, false);
    }
       
    /**
     * getRegisterForm
     *
     * @param  int $langId
     * @return object
     */
    private function getRegisterForm(int $langId): object
    {
        $frm = new Form('frmRegister');
        $frm->addRequiredField(Labels::getLabel('LBL_FULL_NAME', $langId), 'company_name', '', array('placeholder' => Labels::getLabel('LBL_FULL_NAME', $langId)));
        $frm->addRequiredField(Labels::getLabel('LBL_PHONE_NUMBER', $langId), 'phone', '', array('placeholder' => Labels::getLabel('LBL_PHONE_NUMBER_INCLUDING_COUNTRY_CODE', $langId)));

        $fld = $frm->addPasswordField(Labels::getLabel('LBL_PASSWORD', $langId), 'user_password', '', array('placeholder' => Labels::getLabel('LBL_PASSWORD', $langId)));
        $fld->requirements()->setRequired();
        $fld->requirements()->setRegularExpressionToValidate(ValidateElement::PASSWORD_REGEX);
        $fld->requirements()->setCustomErrorMessage(Labels::getLabel('MSG_PASSWORD_MUST_BE_EIGHT_CHARACTERS_LONG_AND_ALPHANUMERIC', $langId));

        $fld1 = $frm->addPasswordField(Labels::getLabel('LBL_CONFIRM_PASSWORD', $langId), 'password1', '', array('placeholder' => Labels::getLabel('LBL_CONFIRM_PASSWORD', $langId)));
        $fld1->requirements()->setRequired();
        $fld1->requirements()->setCompareWith('user_password', 'eq', Labels::getLabel('LBL_PASSWORD', $langId));

        $fld_submit = $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('LBL_REGISTER', $langId));
        $fld_cancel = $frm->addButton('', 'btn_cancel', Labels::getLabel('LBL_CANCEL', $langId));
        $fld_submit->attachField($fld_cancel);
        return $frm;
    }
    
    /**
     * register
     * 
     * @return void
     */
    public function register()
    {
        $userData = $this->getLoggedUserInfo();
        $dataToFill = [
            'company_name' => $userData['user_name'],
            'phone' =>  $userData['shop_phone'],
        ];
        $frm = $this->getRegisterForm($this->siteLangId);
        $frm->fill($dataToFill);
        $this->set('frm', $frm);
        $this->_template->render(false, false);
    }
    
    /**
     * setupUser
     * 
     * @return void
     */
    public function setupUser()
    {
        $frm = $this->getRegisterForm($this->siteLangId);
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());
        $userData = $this->getLoggedUserInfo();
        if (false === $this->easyEcom->createAuthToken($this->getUserId())) {
            FatUtility::dieJsonError($this->easyEcom->getError());
        }
        
        $shopAddress = [
            'address_line_1' => $userData['shop_name'],
            'address_line_2' => $userData['shop_city'],
            'pin_code' => $userData['shop_postalcode'],
            'state_code' => $userData['state_code'],
            'country' => strtoupper($userData['country_code']),
        ];

        $dataToUpdate = [
            "phone" => $post['phone'],
            "company_name" => $post['company_name'],
            "email" => $userData['credential_email'],
            "client_id" => $this->easyEcom->getKeys('easyecom_token'),
            "password" =>  $post['user_password'],
            "shipping1_address" => $shopAddress,
            "billing_address" => $shopAddress,
            "credentials" => [
                "m_id" => 219, // This need to be placed statically. It points to YoKart at EasyEcom(ID of YoKart).
                "username" => $userData['credential_email'],
                "password" => User::getUserMeta($this->getUserId(), 'seller_auth_token')
		    ]

        ];
        CommonHelper::printArray($dataToUpdate);
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
            $msg = Labels::getLabel('MSG_INVALID_REQUEST', $this->siteLangId);
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
            $resp = $this->formatOutput(false, $msg);
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
            $resp = $this->formatOutput(false, $msg);
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
            $resp = $this->formatOutput(false, $msg);
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