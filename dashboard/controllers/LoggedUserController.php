<?php

class LoggedUserController extends DashboardBaseController
{
    public $userParentId = 0;
    public $userId = 0;
    public $userInfo = [];

    public function __construct($action)
    {
        parent::__construct($action);
        UserAuthentication::checkLogin(true);

        $this->userId = UserAuthentication::getLoggedUserId(true);
        if ($this->userId < 1) {
            LibHelper::exitWithError(Labels::getLabel('ERR_SESSION_SEEMS_TO_BE_EXPIRED', CommonHelper::getLangId()), false, true, ['displayLoginForm' => 1]);
            FatApp::redirectUser(UrlHelper::generateUrl('GuestUser', 'loginForm', [], CONF_WEBROOT_FRONTEND));
        }

        $user = new User($this->userId);
        $this->userInfo = $user->getUserInfo(array(), false, false);
        if (0 < $this->userId && empty($this->userInfo)) {
            LibHelper::exitWithError(Labels::getLabel('ERR_UNAUTHORIZED_ACCESS', CommonHelper::getLangId()), false, true, ['displayLoginForm' => 1]);
            FatApp::redirectUser(UrlHelper::generateUrl('GuestUser', 'logout', [], CONF_WEBROOT_FRONTEND));
        }

        $invalidAccess = (
            ($this->userId < 1) ||
            false === $this->userInfo ||
            (!UserAuthentication::isGuestUserLogged() &&
                ($this->userInfo['credential_verified'] == applicationConstants::NO ||
                    $this->userInfo['credential_active'] == applicationConstants::NO
                )
            )
        );

        $isLoginByAdmin = (isset($_SESSION[User::ADMIN_SESSION_ELEMENT_NAME]) && !empty($_SESSION[User::ADMIN_SESSION_ELEMENT_NAME]));
        if (true === $invalidAccess && false === $isLoginByAdmin) {
            LibHelper::exitWithError(Labels::getLabel('ERR_UNAUTHORIZED_ACCESS', CommonHelper::getLangId()), false, true, ['displayLoginForm' => 1]);
            FatApp::redirectUser(UrlHelper::generateUrl('GuestUser', 'logout', [], CONF_WEBROOT_FRONTEND));
        }

        if (false === $invalidAccess && 0 < $this->userInfo['user_parent']) {
            $user = new User($this->userInfo['user_parent']);
            $parentUserInfo = $user->getUserInfo(array(), true, true);
            if (false == $parentUserInfo || $parentUserInfo['credential_active'] != applicationConstants::ACTIVE) {
                LibHelper::exitWithError(Labels::getLabel('ERR_PARENT_MERCHANT_NOT_AUTHORIZED_TO_ACCESS', CommonHelper::getLangId()), false, true, ['displayLoginForm' => 1]);
                FatApp::redirectUser(UrlHelper::generateUrl('GuestUser', 'logout', [], CONF_WEBROOT_FRONTEND));
            }
        }

        if (!isset($_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'])) {
            $userPreferedDashboardType = $this->userInfo['user_preferred_dashboard'] ?? $this->userInfo['user_registered_initially_for'];
            switch ($userPreferedDashboardType) {
                case User::USER_TYPE_BUYER:
                    $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'B';
                    break;
                case User::USER_TYPE_SELLER:
                    $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'S';
                    break;
                case User::USER_TYPE_AFFILIATE:
                    $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'AFFILIATE';
                    break;
                case User::USER_TYPE_ADVERTISER:
                    $_SESSION[UserAuthentication::SESSION_ELEMENT_NAME]['activeTab'] = 'Ad';
                    break;
            }
        }

        /* These actions are used while configuring Phone from "Configure Email/Phone Page". */
        $allowedActions = ['getotp', 'resendotp', 'validateotp'];
        if (!in_array(strtolower($action), $allowedActions) && empty($this->userInfo['user_phone']) && empty($this->userInfo['credential_email'])) {
            if (true == SmsArchive::canSendSms()) {
                $message = Labels::getLabel('MSG_PLEASE_CONFIGURE_YOUR_EMAIL_OR_PHONE', $this->siteLangId);
            } else {
                $message = Labels::getLabel('MSG_PLEASE_CONFIGURE_YOUR_EMAIL', $this->siteLangId);
            }

            LibHelper::exitWithError($message, false, true);
            FatApp::redirectUser(UrlHelper::generateUrl('GuestUser', 'configureEmail', [], CONF_WEBROOT_FRONTEND));
        }

        $this->userParentId = (0 < $this->userInfo['user_parent']) ? $this->userInfo['user_parent'] : $this->userId;
        $this->initCommonValues();
        global $sellerRating;
        $sellerRating = [];
    }

    private function initCommonValues()
    {
        $this->userPrivilege = UserPrivilege::getInstance();
        $this->set('userPrivilege', $this->userPrivilege);
    }

    protected function getOrderCancellationRequestsSearchForm($langId)
    {
        $frm = new Form('frmOrderCancellationRequest');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'total_record_count');
        $fld = $frm->addTextBox('', 'op_invoice_number');
        $fld->overrideFldType('search');
        $frm->addSelectBox(Labels::getLabel('FRM_REQUEST_STATUS', $langId), 'ocrequest_status', array('-1' => Labels::getLabel('FRM_STATUS_DOES_NOT_MATTER', $langId)) + OrderCancelRequest::getRequestStatusArr($langId), '', array(), '');
        $frm->addDateField(Labels::getLabel('FRM_FROM_DATE', $langId), 'ocrequest_date_from', '', array('readonly' => 'readonly'));
        $frm->addDateField(Labels::getLabel('FRM_TO_DATE', $langId), 'ocrequest_date_to', '', array('readonly' => 'readonly'));

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm, 'btn btn-clear');
        return $frm;
    }

    protected function getOrderReturnRequestsSearchForm($langId)
    {
        $frm = new Form('frmOrderReturnRequest');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'total_record_count');
        $frm->addTextBox(Labels::getLabel('FRM_KEYWORD', $langId), 'keyword');
        $frm->addSelectBox(Labels::getLabel('FRM_REQUEST_STATUS', $langId), 'orrequest_status', array('-1' => Labels::getLabel('FRM_STATUS_DOES_NOT_MATTER', $langId)) + OrderReturnRequest::getRequestStatusArr($langId), '', array(), '');
        $returnRquestArray = OrderReturnRequest::getRequestTypeArr($langId);
        if (count($returnRquestArray) > applicationConstants::YES) {
            $frm->addSelectBox(Labels::getLabel('FRM_REQUEST_TYPE', $langId), 'orrequest_type', array('-1' => Labels::getLabel('FRM_REQUEST_TYPE_DOES_NOT_MATTER', $langId)) + $returnRquestArray, '', array(), '');
        } else {
            $frm->addHiddenField(Labels::getLabel('FRM_REQUEST_TYPE', $langId), 'orrequest_type', '-1');
        }
        $frm->addDateField(Labels::getLabel('FRM_DATE_FORM', $langId), 'orrequest_date_from', '', array('readonly' => 'readonly'));
        $frm->addDateField(Labels::getLabel('FRM_DATE_TO', $langId), 'orrequest_date_to', '', array('readonly' => 'readonly'));

        HtmlHelper::addSearchButton($frm);
        HtmlHelper::addClearButton($frm, 'btn btn-clear');
        return $frm;
    }

    protected function getOrderReturnRequestMessageSearchForm($langId)
    {
        $frm = new Form('frmOrderReturnRequestMsgsSrch');
        $frm->addHiddenField('', 'page');
        $frm->addHiddenField('', 'orrequest_id');
        return $frm;
    }

    protected function getOrderReturnRequestMessageForm($langId)
    {
        $frm = new Form('frmOrderReturnRequestMessge');
        $frm->setRequiredStarPosition('');
        $fld = $frm->addTextArea('', 'orrmsg_msg');
        $fld->requirements()->setRequired();
        $fld->requirements()->setCustomErrorMessage(Labels::getLabel('MSG_MESSAGE_IS_MANDATORY', $langId));
        $frm->addHiddenField('', 'orrmsg_orrequest_id');
        $frm->addSubmitButton('', 'btn_submit', Labels::getLabel('BTN_SUBMIT', $langId));
        return $frm;
    }
}
