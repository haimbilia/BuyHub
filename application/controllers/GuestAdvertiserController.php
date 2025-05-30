<?php

class GuestAdvertiserController extends MyAppController
{
    public function __construct($action)
    {
        parent::__construct($action);
    }

    public function account()
    {
        if (UserAuthentication::isUserLogged() && (User::isAdvertiser() || User::isSigningUpAdvertiser())) {
            FatApp::redirectUser(UrlHelper::generateUrl('advertiser', '', [], CONF_WEBROOT_DASHBOARD, null, false, false, false));
        }
        if (UserAuthentication::isUserLogged()) {
            Message::addErrorMessage(Labels::getLabel('ERR_YOU_ARE_ALREADY_LOGGED_IN._PLEASE_LOGOUT_AND_REGISTER_FOR_ADVERTISER.', $this->siteLangId));
            FatApp::redirectUser(UrlHelper::generateUrl('account', '', [], CONF_WEBROOT_DASHBOARD, null, false, false, false));
        }

        $obj = new Extrapage();
        $slogan = $obj->getContentByPageType(Extrapage::ADVERTISER_BANNER_SLOGAN, $this->siteLangId);
        if (!empty($slogan)) {
            $slogan['epage_extra_info'] = !empty($slogan['epage_extra_info']) ? json_decode($slogan['epage_extra_info'], true) : [];
        }

        $this->set('slogan', $slogan);
        $this->set('siteLangId', $this->siteLangId);

        $this->_template->render();
    }

    public function form()
    {
        if (UserAuthentication::isUserLogged()) {
            LibHelper::exitWithError(Labels::getLabel('ERR_USER_ALREADY_LOGGED_IN', $this->siteLangId));
        }

        $userId = $this->getRegisteredAdvertiserId();
        if ($userId > 0) {
            $this->profileConfirmation($userId);
        } else {
            $cPageSrch = ContentPage::getSearchObject($this->siteLangId);
            $cPageSrch->addCondition('cpage_id', '=', FatApp::getConfig('CONF_TERMS_AND_CONDITIONS_PAGE', FatUtility::VAR_INT, 0));
            $cPageSrch->doNotCalculateRecords();
            $cPageSrch->setPageSize(1);
            $cpage = FatApp::getDb()->fetch($cPageSrch->getResultSet());
            if (!empty($cpage) && is_array($cpage)) {
                $termsAndConditionsLinkHref = UrlHelper::generateUrl('Cms', 'view', array($cpage['cpage_id']));
            } else {
                $termsAndConditionsLinkHref = 'javascript:void(0)';
            }

            $registrationFrm = $this->getAdvertiserRegistrationForm();
            $this->set('termsAndConditionsLinkHref', $termsAndConditionsLinkHref);
            $this->set('frm', $registrationFrm);
            $this->set('siteLangId', $this->siteLangId);
            $this->_template->render(false, false);
        }
    }

    public function companyDetailsForm()
    {
        $frm = $this->getAdvertiserRegistrationForm();
        $post = $frm->getFormDataFromArray(FatApp::getPostedData());

        if ($post == false) {
            LibHelper::exitWithError(current($frm->getValidationErrors()));
        }

        if (UserAuthentication::isUserLogged()) {
            LibHelper::exitWithError(Labels::getLabel('ERR_USER_ALREADY_LOGGED_IN', $this->siteLangId));
        }

        $approvalFrm = $this->getCompanyDetailsForm();

        unset($post['btn_submit']);
        $approvalFrm->fill($post);

        $this->set('siteLangId', $this->siteLangId);
        $this->set('approvalFrm', $approvalFrm);
        $this->set('post', $post);
        $this->_template->render(false, false, 'guest-advertiser/company-details-form.php');
    }

    public function validateDetails()
    {
        $post = FatApp::getPostedData();
        if (empty($post)) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_INVALID_ACCESS', $this->siteLangId));
        }

        if (!ValidateElement::username($post['user_username'])) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_USERNAME_MUST_BE_THREE_CHARACTERS_LONG_AND_ALPHANUMERIC', $this->siteLangId));
        }

        if (!ValidateElement::password($post['user_password'])) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_PASSWORD_MUST_BE_EIGHT_CHARACTERS_LONG_AND_ALPHANUMERIC', $this->siteLangId));
        }
        FatUtility::dieJsonSuccess(Labels::getLabel('MSG_Data_verified', $this->siteLangId));
    }

    public function setupCompanyDetailsForm()
    {
        if (UserAuthentication::isUserLogged()) {
            FatUtility::dieJsonError(Labels::getLabel('ERR_User_Already_Logged_in', $this->siteLangId));
        }

        $frm = $this->getCompanyDetailsForm();
        $post = FatApp::getPostedData();
        /* $post = $frm->getFormDataFromArray(FatApp::getPostedData()); */
        if ($post == false) {
            FatUtility::dieJsonError(current($frm->getValidationErrors()));
        }

        $userObj = new User();
        $db = FatApp::getDb();
        $db->startTransaction();

        $post['user_is_advertiser'] = 1;
        $post['user_registered_initially_for'] = User::USER_TYPE_ADVERTISER;
        $post['user_preferred_dashboard'] = User::USER_ADVERTISER_DASHBOARD;

        $post['user_phone_dcode'] = FatApp::getPostedData('user_phone_dcode', FatUtility::VAR_STRING, '');

        $userObj->assignValues($post);

        if (!$userObj->save()) {
            $db->rollbackTransaction();
            FatUtility::dieJsonError(Labels::getLabel("ERR_USER_COULD_NOT_BE_SET", $this->siteLangId) . $userObj->getError());
        }

        $active = FatApp::getConfig('CONF_ADMIN_APPROVAL_REGISTRATION', FatUtility::VAR_INT, 1) ? 0 : 1;
        $verify = FatApp::getConfig('CONF_EMAIL_VERIFICATION_REGISTRATION', FatUtility::VAR_INT, 1) ? 0 : 1;

        if (!$userObj->setLoginCredentials($post['user_username'], $post['user_email'], $post['user_password'], $active, $verify)) {
            $db->rollbackTransaction();
            FatUtility::dieJsonError(Labels::getLabel("ERR_LOGIN_CREDENTIALS_COULD_NOT_BE_SET", $this->siteLangId) . $userObj->getError());
        }

        $referrerCodeSignup = '';
        if (isset($_COOKIE['referrer_code_signup']) && $_COOKIE['referrer_code_signup'] != '') {
            $referrerCodeSignup = $_COOKIE['referrer_code_signup'];
        }
        $affiliateReferrerCodeSignup = '';
        if (isset($_COOKIE['affiliate_referrer_code_signup']) && $_COOKIE['affiliate_referrer_code_signup'] != '') {
            $affiliateReferrerCodeSignup = $_COOKIE['affiliate_referrer_code_signup'];
        }

        $userObj->setUpRewardEntry($userObj->getMainTableRecordId(), $this->siteLangId, $referrerCodeSignup, $affiliateReferrerCodeSignup);

        if (FatApp::getConfig('CONF_NOTIFY_ADMIN_REGISTRATION', FatUtility::VAR_INT, 1)) {
            if (!$userObj->notifyAdminRegistration($post, $this->siteLangId)) {
                $db->rollbackTransaction();
                FatUtility::dieJsonError(Labels::getLabel("ERR_NOTIFICATION_EMAIL_COULD_NOT_BE_SENT", $this->siteLangId));
            }
        }

        if (FatApp::getConfig('CONF_EMAIL_VERIFICATION_REGISTRATION', FatUtility::VAR_INT, 1)) {
            if (!$userObj->userEmailVerification($post, $this->siteLangId)) {
                $db->rollbackTransaction();
                FatUtility::dieJsonError(Labels::getLabel("ERR_VERIFICATION_EMAIL_COULD_NOT_BE_SENT", $this->siteLangId));
            }
        } else {
            if (FatApp::getConfig('CONF_WELCOME_EMAIL_REGISTRATION', FatUtility::VAR_INT, 1)) {
                $link = UrlHelper::generateFullUrl('GuestUser', 'loginForm');
                if (!$userObj->userWelcomeEmailRegistration($post, $link, $this->siteLangId)) {
                    $db->rollbackTransaction();
                    FatUtility::dieJsonError(Labels::getLabel("ERR_WELCOME_EMAIL_COULD_NOT_BE_SENT", $this->siteLangId));
                }
            }
        }

        $db->commitTransaction();
        if ($verify) {
            $this->set('msg', Labels::getLabel("MSG_SUCCESS_USER_SIGNUP_VERIFIED", $this->siteLangId));
        } else {
            $this->set('msg', Labels::getLabel("MSG_SUCCESS_USER_SIGNUP", $this->siteLangId));
        }

        $_SESSION['registered_supplier']['id'] = $userObj->getMainTableRecordId();
        $this->set('userId', $userObj->getMainTableRecordId());

        $this->_template->render(false, false, 'json-success.php');
    }

    public function profileConfirmation($userId)
    {
        $userId = FatUtility::int($userId);

        if (!$this->isRegisteredSupplierId($userId)) {
            LibHelper::exitWithError(Labels::getLabel("ERR_INVALID_ACCESS", $this->siteLangId));
        }

        if (UserAuthentication::isUserLogged()) {
            LibHelper::exitWithError(Labels::getLabel('ERR_USER_ALREADY_LOGGED_IN', $this->siteLangId));
        }

        $userObj = new User($userId);
        $userdata = $userObj->getUserInfo(array('credential_active', 'credential_verified', 'credential_email', 'credential_password'), false, false);

        if (false == $userdata) {
            LibHelper::exitWithError(Labels::getLabel("ERR_INVALID_ACCESS", $this->siteLangId));
        }

        if ($userdata['credential_verified'] == applicationConstants::YES) {
            $success_message = Labels::getLabel('MSG_SUCCESS_USER_SIGNUP_VERIFIED', $this->siteLangId);
        } else {
            $success_message = Labels::getLabel('MSG_SUCCESS_USER_SIGNUP', $this->siteLangId);
        }


        if (FatApp::getConfig('CONF_AUTO_LOGIN_REGISTRATION', FatUtility::VAR_INT, 1)  && $userdata['credential_active'] == applicationConstants::YES) {
            $authentication = new UserAuthentication();
            if (!$authentication->login($userdata['credential_email'], $userdata['credential_password'], $_SERVER['REMOTE_ADDR'], false)) {
                LibHelper::exitWithError($authentication->getError());
            }
            $this->set('redirectUrl', UrlHelper::generateUrl('Account', '', [], CONF_WEBROOT_DASHBOARD, null, false, false, false));
        }

        unset($_SESSION['registered_supplier']['id']);
        $this->set('success_message', $success_message);
        $this->set('siteLangId', $this->siteLangId);
        $this->_template->render(false, false);
    }

    private function getRegisteredAdvertiserId()
    {
        return $_SESSION['registered_supplier']['id'] ?? 0;
    }

    private function isRegisteredSupplierId($userId)
    {
        if (!isset($_SESSION['registered_supplier'])) {
            return false;
        }

        $userId = FatUtility::int($userId);
        if (1 > $userId || $userId != $_SESSION['registered_supplier']['id']) {
            return false;
        }
        return true;
    }

    private function getAdvertiserRegistrationForm()
    {
        $frm = new Form('frm');

        $frm->addHiddenField('', 'user_id', 0, array('id' => 'user_id'));

        $fld = $frm->addTextBox(Labels::getLabel('FRM_USERNAME', $this->siteLangId), 'user_username');
        $fld->setUnique('tbl_user_credentials', 'credential_username', 'credential_user_id', 'user_id', 'user_id');
        $fld->requirements()->setRequired();
        $fld->requirements()->setUsername();

        $fld = $frm->addEmailField(Labels::getLabel('FRM_EMAIL', $this->siteLangId), 'user_email');
        $fld->setUnique('tbl_user_credentials', 'credential_email', 'credential_user_id', 'user_id', 'user_id');

        $frm->addRequiredField(Labels::getLabel('FRM_NAME', $this->siteLangId), 'user_name');
        $frm->addHiddenField('', 'user_phone_dcode');
        $phnFld = $frm->addRequiredField(Labels::getLabel('FRM_PHONE', $this->siteLangId), 'user_phone', '', array('class' => 'phone-js ltr-right', 'placeholder' => ValidateElement::PHONE_NO_FORMAT, 'maxlength' => ValidateElement::PHONE_NO_LENGTH));
        $phnFld->requirements()->setRegularExpressionToValidate(ValidateElement::PHONE_REGEX);
        $phnFld->setUnique('tbl_users', 'user_phone', 'user_id', 'user_id', 'user_id');

        $fld = $frm->addPasswordField(Labels::getLabel('FRM_PASSWORD', $this->siteLangId), 'user_password');
        $fld->requirements()->setRequired();
        $fld->requirements()->setRegularExpressionToValidate(ValidateElement::PASSWORD_REGEX);
        $fld->requirements()->setCustomErrorMessage(Labels::getLabel('ERR_PASSWORD_MUST_BE_EIGHT_CHARACTERS_LONG_AND_ALPHANUMERIC', $this->siteLangId));

        $fld1 = $frm->addPasswordField(Labels::getLabel('FRM_CONFIRM_PASSWORD', $this->siteLangId), 'password1');
        $fld1->requirements()->setRequired();
        $fld1->requirements()->setCompareWith('user_password', 'eq', Labels::getLabel('FRM_PASSWORD', $this->siteLangId));

        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SUBMIT', $this->siteLangId));

        return $frm;
    }

    private function getCompanyDetailsForm()
    {
        $frm = new Form('frmCompanyDetailsForm');
        $frm->addHiddenField('', 'id', 0);
        $frm->setFormTagAttribute("class", "form invalid");
        $frm->addTextBox(Labels::getLabel('FRM_COMPANY', $this->siteLangId), 'user_company', '');
        $fld = $frm->addTextArea(Labels::getLabel('LBL_BRIEF_PROFILE', $this->siteLangId), 'user_profile_info', '');
        $fld->htmlAfterField = '<br/><small class="form-text text-muted">' . Labels::getLabel('MSG_PLEASE_TELL_US_SOMETHING_ABOUT_YOURSELF', $this->siteLangId) . '</small>';
        $fld = $frm->addTextArea(Labels::getLabel('FRM_PRODUCTS/SERVICES_YOU_WISH_TO_ADVERTISE?', $this->siteLangId), 'user_products_services', '');
        $frm->addHiddenField('', 'user_name');
        $frm->addHiddenField('', 'user_phone_dcode');
        $frm->addHiddenField('', 'user_phone');
        $frm->addHiddenField('', 'user_username');
        $frm->addHiddenField('', 'user_email');
        $frm->addHiddenField('', 'user_password');
        $frm->addHiddenField('', 'password1');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_Submit', $this->siteLangId));
        return $frm;
    }
}
