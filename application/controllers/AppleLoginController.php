<?php

class AppleLoginController extends SocialMediaAuthController
{
    public const KEY_NAME = 'AppleLogin';

    public $requiredKeys = ['client_id'];

    public function __construct($action)
    {
        parent::__construct($action);

        $this->apple = LibHelper::callPlugin(self::KEY_NAME, [$this->siteLangId], $error, $this->siteLangId);
        if (false === $this->apple) {
            $this->setErrorAndRedirect($error, true);
        }

        if (false === $this->apple->init()) {
            $this->setErrorAndRedirect($this->apple->getError(), true);
        }
    }
    
    public function index()
    {
        $post = FatApp::getPostedData();
        $userType = FatApp::getPostedData('type', FatUtility::VAR_INT, User::USER_TYPE_BUYER);

        if (isset($post['id_token'])) {
            $state = $post['state'] ?? '';
            if (false === MOBILE_APP_API_CALL && !empty($state) && $_COOKIE[self::KEY_NAME . '_state'] != $post['state']) {
                $message = Labels::getLabel('ERR_AUTHORIZATION_SERVER_RETURNED_AN_INVALID_STATE_PARAMETER', $this->siteLangId);
                $this->setErrorAndRedirect($message, true);
            }
            if (isset($post['error'])) {
                $message = Labels::getLabel('ERR_AUTHORIZATION_SERVER_RETURNED_AN_ERROR: ', $this->siteLangId);
                $message .= htmlspecialchars($post['error']);
                $this->setErrorAndRedirect($message, true);
            }
            $claims = explode('.', $post['id_token'])[1];
            $claims = json_decode(base64_decode($claims), true);
            
            $appleUserInfo = isset($post['user']) ? json_decode($post['user'], true) : false;
    
            $appleId = isset($claims['sub']) ? $claims['sub'] : '';
    
            if (false === $appleUserInfo) {
                if (!isset($claims['email'])) {
                    $message = Labels::getLabel('ERR_UNABLE_TO_FETCH_USER_INFO', $this->siteLangId);
                    $this->setErrorAndRedirect($message, true);
                }
                $email = $claims['email'];
            } else {
                $email = $appleUserInfo['email'];
            }
            
            $exp = explode("@", $email);
            $username = substr($exp[0], 0, 80) . rand();

            $userInfo = $this->doLogin($email, $username, $appleId, $userType);
            $this->redirectToDashboard($userInfo['user_preferred_dashboard']);
        }
        
        FatApp::redirectUser($this->apple->getRequestUri());
    }
}
